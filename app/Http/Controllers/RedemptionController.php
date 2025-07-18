<?php

// app/Http/Controllers/RedemptionController.php

namespace App\Http\Controllers;

use App\Models\Redemption;
use App\Models\Guide;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Item;
use Illuminate\Support\Facades\Log;

class RedemptionController extends Controller
{
    // Update the store method in RedemptionController.php
    public function store(Request $request, $guide_id)
    {
        $request->validate([
            'item_ids' => 'required|array|min:1',
            'item_ids.*' => 'exists:items,id',
        ]);

        $guide = Guide::findOrFail($guide_id);
        $items = Item::whereIn('id', $request->item_ids)->get();
        $totalPoints = $items->sum('points');

        // Find the existing redemption row for this guide
        $redemption = Redemption::where('guide_id', $guide_id)->first();

        if (!$redemption) {
            // If no row exists, create one with the guide's starting points
            $redemption = Redemption::create([
                'guide_id' => $guide_id,
                'points' => $guide->earned_points,
                'redeemed_at' => now(),
            ]);
        }

        $remaining = $redemption->points;
        $minPointsToLeave = 10;
        $maxRedeemable = max($remaining - $minPointsToLeave, 0);

        if ($maxRedeemable <= 0) {
            return response()->json([
                'message' => "You need at least 11 points to redeem. You currently have only $remaining points."
            ], 400);
        }

        if ($totalPoints > $maxRedeemable) {
            return response()->json([
                'message' => "You only have $remaining points. You can redeem up to $maxRedeemable points worth of items."
            ], 400);
        }

        // DON'T deduct points here - only create the request
        // Points will be deducted only when admin approves

        $redemptionRequest = \App\Models\RedemptionRequest::create([
            'guide_id' => $guide_id,
            'item_ids' => $request->item_ids,
            'item_details' => $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'points' => $item->points
                ];
            })->toArray(),
            'total_points' => $totalPoints,
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Redemption request submitted successfully. Please wait for admin approval.',
            'request_id' => $redemptionRequest->id,
            'status' => 'pending'
        ]);
    }

    // Update the approveRequest method in RedemptionController.php
    public function approveRequest(Request $request, $requestId)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $redemptionRequest = \App\Models\RedemptionRequest::findOrFail($requestId);
        
        if ($redemptionRequest->status !== 'pending') {
            return response()->json([
                'message' => 'This request has already been processed.'
            ], 400);
        }

        $guide = $redemptionRequest->guide;
        $action = $request->action;

        // Get the authenticated admin (fix for the error)
        $admin = auth('sanctum')->user();
        $adminId = $admin ? $admin->id : null;

        if ($action === 'approve') {
            // Process the redemption - ONLY NOW deduct points
            $redemption = Redemption::where('guide_id', $redemptionRequest->guide_id)->first();
            
            if (!$redemption) {
                $redemption = Redemption::create([
                    'guide_id' => $redemptionRequest->guide_id,
                    'points' => $guide->earned_points,
                    'redeemed_at' => now(),
                ]);
            }

            // Check again if guide still has enough points (in case points changed)
            if ($redemption->points < $redemptionRequest->total_points) {
                return response()->json([
                    'message' => 'Guide no longer has sufficient points for this redemption.'
                ], 400);
            }

            // Subtract points ONLY when approved
            $redemption->points -= $redemptionRequest->total_points;
            $redemption->redeemed_at = now();
            $redemption->save();

            // Update request status
            $redemptionRequest->update([
                'status' => 'approved',
                'approved_by' => $adminId,
                'approved_at' => now(),
                'admin_notes' => $request->admin_notes
            ]);

            // Send WhatsApp approval message
            $this->sendApprovalMessage($guide, $redemptionRequest->item_details);

            return response()->json([
                'message' => 'Redemption request approved successfully. Points have been deducted.',
                'redemption' => $redemption
            ]);

        } else {
            // Reject the request - NO points deduction needed since they weren't deducted
            $redemptionRequest->update([
                'status' => 'rejected',
                'approved_by' => $adminId,
                'approved_at' => now(),
                'admin_notes' => $request->admin_notes
            ]);

            // Send WhatsApp rejection message
            $this->sendRejectionMessage($guide, $request->admin_notes);

            return response()->json([
                'message' => 'Redemption request rejected. Points remain with the guide.',
            ]);
        }
    }

    // Add method to send approval WhatsApp message
    private function sendApprovalMessage($guide, $itemDetails)
    {
        try {
            $twilio = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

            $mobile = $guide->mobile_number;
            if (strpos($mobile, '+') !== 0) {
                $mobile = '+94' . ltrim($mobile, '0');
            }

            $itemNames = array_column($itemDetails, 'name');
            $itemList = implode(', ', $itemNames);

            $twilio->messages->create(
                'whatsapp:' . $mobile,
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'),
                    'contentSid' => 'HXa265a3ead6889d9f10cbc576f34c4373',
                    'contentVariables' => json_encode([ 
                        '1' => $itemList                     
                    ]),
                ]
            );
        } catch (\Exception $e) {
            Log::error('WhatsApp approval notification failed: ' . $e->getMessage());
        }
    }

    // Add method to send rejection WhatsApp message
    private function sendRejectionMessage($guide, $reason)
    {
        try {
            $twilio = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

            $mobile = $guide->mobile_number;
            if (strpos($mobile, '+') !== 0) {
                $mobile = '+94' . ltrim($mobile, '0');
            }

            $message = "❌ Your redemption request has been rejected.\n\n";
            $message .= "✅ Your points remain unchanged.\n";
            if ($reason) {
                $message .= "\n📝 Reason: " . $reason . "\n";
            }
            $message .= "\nYou can submit a new request anytime.\n";
            $message .= "- ChauffeurGuide Team";

            $twilio->messages->create(
                'whatsapp:' . $mobile,
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'),
                    'body' => $message
                ]
            );
        } catch (\Exception $e) {
            Log::error('WhatsApp rejection notification failed: ' . $e->getMessage());
        }
    }

    // Add method to get pending requests for admin
    public function getPendingRequests()
    {
        $requests = \App\Models\RedemptionRequest::with('guide')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'requests' => $requests
        ]);
    }

    public function history($guideId)
    {
        return Redemption::where('guide_id', $guideId)->orderByDesc('redeemed_at')->get();
    }

    /**
     * Redeem points for cash
     */
    public function redeemCash(Request $request, $guide_id)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        $guide = Guide::findOrFail($guide_id);
        $amount = $request->amount;

        // Find the existing redemption row for this guide
        $redemption = Redemption::where('guide_id', $guide_id)->first();

        if (!$redemption) {
            // If no row exists, create one with the guide's starting points
            $redemption = Redemption::create([
                'guide_id' => $guide_id,
                'points' => $guide->earned_points, // or however you track starting points
                'redeemed_at' => now(),
            ]);
        }

        $remaining = $redemption->points;

        // Check if guide has enough points
        if ($amount > $remaining) {
            return response()->json([
                'message' => "Insufficient points. You have $remaining points available."
            ], 400);
        }

        // Subtract redeemed points from the existing row
        $redemption->points = $remaining - $amount;
        $redemption->redeemed_at = now();
        $redemption->save();
        
        //HXd79234b801be221fac7c71a031f22b7a
        // Send WhatsApp notification about cash redemption
        try {
            $twilio = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

            $mobile = $guide->mobile_number;
            if (strpos($mobile, '+') !== 0) {
                $mobile = '+94' . ltrim($mobile, '0');
            }

            $twilio->messages->create(
                'whatsapp:' . $mobile,
                [
                    'from' => env('TWILIO_WHATSAPP_FROM'),
                    'contentSid' => 'HXd79234b801be221fac7c71a031f22b7a',
                    'contentVariables' => json_encode([
                        '1' => $guide->full_name,
                        '2' => number_format($amount),
                        '3' => number_format($amount),
                        '4' => number_format($redemption->points)
                    ]),
                ]
            );
        } catch (\Exception $e) {
            Log::error('WhatsApp notification failed: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'Cash redemption request submitted successfully.',
            'amount' => $amount,
            'remaining_points' => $redemption->points,
            'redemption' => $redemption
        ]);
    }

    /**
     * Show the redemption details for a specific guide.
     */

    public function show($id)
    {
        $redemption = \App\Models\Redemption::where('guide_id', $id)->first();

        if (!$redemption) {
            return response()->json(['message' => 'Redemption not found'], 404);
        }

        return response()->json([
            'redemption' => $redemption
        ]);
    }
}
