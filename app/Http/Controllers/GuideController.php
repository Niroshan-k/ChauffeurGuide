<?php
// app/Http/Controllers/GuideController.php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Twilio\Rest\Client;
use App\Models\Item;

class GuideController extends Controller
{
    public function dashboard()
    {
        $guideCount = Guide::count();
        $guideMax = 100;

        $visitCount = Visit::count();

        $guides = \App\Models\Guide::with(['visits', 'redemptions'])->withCount('visits')->get();

        // Monthly visits (current month)
        $monthlyVisitCount = Visit::whereMonth('created_at', Carbon::now()->month)
                                ->whereYear('created_at', Carbon::now()->year)
                                ->count();

        return view('admin.dashboard', compact('guideCount', 'guideMax', 'visitCount', 'monthlyVisitCount','guides'));
    }

    public function dashboard1()
    {
        $guideCount = Guide::count();
        $guideMax = 100;

        $visitCount = Visit::count();

        $guides = \App\Models\Guide::with(['visits', 'redemptions'])->withCount('visits')->get();

        // Monthly visits (current month)
        $monthlyVisitCount = Visit::whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->count();

        // Total tourists count (sum of pax_count)
        $touristCount = Visit::sum('pax_count');
       
        // Monthly visits and tourists (current month)
        $currentMonth = Carbon::now();
        $monthlyVisitCount = Visit::whereMonth('created_at', $currentMonth->month)
        ->whereYear('created_at', $currentMonth->year)
        ->count();

        // Monthly tourists count
        $monthlyTouristCount = Visit::whereMonth('created_at', $currentMonth->month)
        ->whereYear('created_at', $currentMonth->year)
        ->sum('pax_count');

        // Get top 5 guides by total pax count
        $topGuides = Guide::select([
            'guides.id',
            'guides.full_name',
            'guides.mobile_number',
            'guides.email',
            'guides.profile_photo'
        ])
            ->leftJoin('visits', 'guides.id', '=', 'visits.guide_id')
            ->selectRaw('COALESCE(SUM(visits.pax_count), 0) as total_pax')
            ->groupBy('guides.id', 'guides.full_name', 'guides.mobile_number', 'guides.email', 'guides.profile_photo')
            ->orderByDesc('total_pax')
            ->limit(5)
            ->get();

        // Get last 12 months of tourist data
        $monthlyTourists = Visit::selectRaw('
            DATE_FORMAT(created_at, "%Y-%m") as month,
            SUM(pax_count) as tourist_count
        ')
        ->where('created_at', '>=', Carbon::now()->subMonths(11)->startOfMonth())
        ->where('created_at', '<=', Carbon::now()->endOfMonth())
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->keyBy('month');

        // Create array of last 12 months with tourist counts
        $monthlyData = collect([]);
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $yearMonth = $date->format('Y-m');
            $monthlyData->push([
                'month' => $date->format('M Y'), // Format: Mar 2025
                'tourist_count' => $monthlyTourists->get($yearMonth)?->tourist_count ?? 0
            ]);
        }

        // Get total guide count
        $guideCount = Guide::count();
        
        // Get this month's new guides count
        $monthlyNewGuides = Guide::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Get monthly guide data for the last 12 months
        $monthlyGuides = Guide::selectRaw('
            DATE_FORMAT(created_at, "%Y-%m") as month,
            COUNT(*) as guide_count
        ')
        ->where('created_at', '>=', Carbon::now()->subMonths(11)->startOfMonth())
        ->where('created_at', '<=', Carbon::now()->endOfMonth())
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->keyBy('month');

        // Create array of last 12 months with guide counts
        $monthlyGuideData = collect([]);
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $yearMonth = $date->format('Y-m');
            $monthlyGuideData->push([
                'month' => $date->format('M Y'),
                'guide_count' => $monthlyGuides->get($yearMonth)?->guide_count ?? 0
            ]);
        }

        return view('admin.dashboard1', compact(
            'guideCount',
            'guideMax',
            'visitCount',
            'touristCount',
            'monthlyVisitCount',
            'monthlyTouristCount',
            'guides',
            'topGuides',
            'monthlyData',
            'monthlyNewGuides',     // Add this
            'monthlyGuideData'      // Add this
        ));
    }

    // Admin creates guide
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|unique:guides,mobile_number',
            'date_of_birth' => 'nullable|date',
            'email' => 'nullable|email',
            'whatsapp_number' => 'nullable|string',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        $guide = Guide::create($data);

        //Send WhatsApp welcome message
        try {
            $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
            
            $mobile = $guide->mobile_number;
            if (strpos($mobile, '+') !== 0) {
                // Assuming Sri Lanka numbers, add +94 if not present
                $mobile = '+94' . ltrim($mobile, '0');
            }

            $dashboardLink = 'https://your-app-link.com/dashboard'; // or dynamically generated link

            $twilio->messages->create(
                'whatsapp:' . $mobile,
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'),
                    'contentSid' => 'HX4e215b7f3d45ad4d0a4c67b9e81212c9', 
                    'contentVariables' => json_encode([
                        '1' => $dashboardLink
                    ]),
                ]
            );
        } catch (\Exception $e) {
            // Optionally log or handle the error
        }

        return response()->json(['message' => 'Guide registered successfully.', 'guide' => $guide]);
    }

    public function index()
    {
        
    }

    public function show($id)
    {
        $guide = \App\Models\Guide::find($id);
        $items = \App\Models\Item::all();
        if (!$guide) {
            return response()->json(['message' => 'Guide not found'], 404);
        }

        $redemption = \App\Models\Redemption::where('guide_id', $id)->first();

        return response()->json([
            'guide' => [
                'full_name' => $guide->full_name,
                'mobile_number' => $guide->mobile_number,
                'date_of_birth' => $guide->date_of_birth,
                'email' => $guide->email,
                'whatsapp_number' => $guide->whatsapp_number,
                'profile_photo' => $guide->profile_photo,
                'created_at' => $guide->created_at,
                'updated_at' => $guide->updated_at,
                'pointsRemaining' => $guide->pointsRemaining(), // <-- Add this line
            ],
            'redemption' => $redemption,
            'items' => $items
        ]);
    }

    public function update(Request $request, $id)
    {
        $guide = Guide::findOrFail($id);

        $request->validate([
            'full_name' => 'sometimes|required|string|max:255',
            'mobile_number' => 'sometimes|required|string|unique:guides,mobile_number,' . $guide->id,
            'date_of_birth' => 'nullable|date',
            'email' => 'nullable|email',
            'whatsapp_number' => 'nullable|string',
            'profile_photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        $guide->update($data);
        return response()->json(['message' => 'Guide updated successfully.', 'guide' => $guide]);
    }

    public function destroy($id)
    {
        $guide = Guide::findOrFail($id);
        $guide->delete();
        return response()->json(['message' => 'Guide deleted.']);
    }

    public function login(Request $request)
    {
        
    }

    public function logout()
    {
        Auth::guard('guide')->logout();
        return response()->json(['message' => 'Logged out.']);
    }
    public function search(Request $request)
    {
        $query = $request->input('q');
        $guides = \App\Models\Guide::where(function ($qB) use ($query) {
            $qB->whereRaw('LOWER(full_name) LIKE ?', ['%' . strtolower($query) . '%'])
               ->orWhere('id', $query);
        })->get();

        return response()->json(['guides' => $guides]);
    }
    
}
