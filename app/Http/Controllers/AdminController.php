<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Guide;
use App\Models\Visit;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = \App\Models\Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json([
            'message' => 'Admin created successfully',
            'admin' => $admin,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function addItem(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $item = \App\Models\Item::create($validated);

        return response()->json([
            'message' => 'Item added successfully',
            'item' => $item,
        ], 201);
    }
    public function getDashboardStats()
    {
        $guideCount = \App\Models\Guide::count();
        $visitCount = \App\Models\Visit::count();
        $monthlyVisitCount = \App\Models\Visit::whereMonth('created_at', now()->month)->count();

        return response()->json([
            'guideCount' => $guideCount,
            'visitCount' => $visitCount,
            'monthlyVisitCount' => $monthlyVisitCount
        ]);
    }
    public function generatePDFReport(Request $request)
    {
        try {
            $date = Carbon::createFromFormat('Y-m', $request->date);
            
            $data = [
                'guides' => Guide::whereMonth('created_at', $date->month)
                                ->whereYear('created_at', $date->year)
                                ->get(),
                'visits' => Visit::whereMonth('created_at', $date->month)
                                ->whereYear('created_at', $date->year)
                                ->with('guide')
                                ->get(),
                'totalTourists' => Visit::whereMonth('created_at', $date->month)
                                       ->whereYear('created_at', $date->year)
                                       ->sum('pax_count'),
                'month' => $date->format('F Y')
            ];

            $pdf = PDF::loadView('admin.reports.monthly', $data);
            
            return $pdf->download('monthly-report-' . $request->date . '.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to generate PDF'], 500);
        }
    }

    public function generateExcelReport(Request $request)
    {
        try {
            $date = Carbon::createFromFormat('Y-m', $request->date);
            
            $visits = Visit::whereMonth('created_at', $date->month)
                          ->whereYear('created_at', $date->year)
                          ->with('guide')
                          ->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Headers
            $sheet->setCellValue('A1', 'Date');
            $sheet->setCellValue('B1', 'Guide Name');
            $sheet->setCellValue('C1', 'Tourist Count');
            
            // Data
            $row = 2;
            foreach ($visits as $visit) {
                $sheet->setCellValue('A' . $row, $visit->created_at->format('Y-m-d'));
                $sheet->setCellValue('B' . $row, $visit->guide->full_name);
                $sheet->setCellValue('C' . $row, $visit->pax_count);
                $row++;
            }
            
            $writer = new Xlsx($spreadsheet);
            
            $fileName = 'monthly-report-' . $request->date . '.xlsx';
            $tempFile = tempnam(sys_get_temp_dir(), $fileName);
            $writer->save($tempFile);
            
            return response()->download($tempFile, $fileName)->deleteFileAfterSend();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to generate Excel file'], 500);
        }
    }

    public function getGuides()
    {
        $guidesnew = Guide::with(['visits', 'redemptions'])
            ->withCount('visits')
            ->withSum('redemptions', 'points')
            ->get();

        return response()->json(['guides' => $guidesnew]);
    }
}
