<?php
// app/Http/Controllers/GuideController.php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

class GuideController extends Controller
{
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

        // Send WhatsApp welcome message
        // try {
        //     $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        //     $twilio->messages->create(
        //         'whatsapp:' . $guide->mobile_number, // recipient in international format
        //         [
        //             'from' => env('TWILIO_WHATSAPP_FROM'),
        //             'body' => "Welcome to Chauffeur Guide! Download our app here: https://your-app-link.com"
        //         ]
        //     );
        // } catch (\Exception $e) {
        //     // Optionally log or handle the error
        // }

        return response()->json(['message' => 'Guide registered successfully.', 'guide' => $guide]);
    }

    public function index()
    {
        return Guide::with('visits', 'redemptions')->get();
    }

    public function show($id)
    {
        return Guide::with('visits', 'redemptions')->findOrFail($id);
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
}
