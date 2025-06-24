<?php

// app/Http/Controllers/RedemptionController.php

namespace App\Http\Controllers;

use App\Models\Redemption;
use App\Models\Guide;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Item;

class RedemptionController extends Controller
{
    // public function store(Request $request, $guide_id)
    // {
    //     $request->validate([
    //         'points' => 'required|integer|min:1',
    //     ]);

    //     $guide = Guide::findOrFail($guide_id);
    //     $remaining = $guide->pointsRemaining();

    //     // Calculate the maximum redeemable points (must leave at least 10)
    //     $maxRedeemable = max($remaining - 10, 0);

    //     if ($maxRedeemable <= 0) {
    //         return response()->json([
    //             'message' => "You need at least 11 points to redeem. You currently have only $remaining points."
    //         ], 400);
    //     }

    //     if ($request->points > $maxRedeemable) {
    //         return response()->json([
    //             'message' => "You only have $remaining points. You can redeem up to $maxRedeemable points."
    //         ], 400);
    //     }

    //     // Update the existing redemption row for this guide
    //     $redemption = $guide->redemptions()->first();
    //     if ($redemption) {
    //         $redemption->points -= $request->points;
    //         $redemption->redeemed_at = Carbon::now();
    //         $redemption->save();
    //     } else {
    //         // If no row exists, create one (should only happen for new guides)
    //         $redemption = $guide->redemptions()->create([
    //             'points' => 0,
    //             'redeemed_at' => Carbon::now(),
    //         ]);
    //     }

    //     return response()->json([
    //         'message' => 'Points redeemed.',
    //         'redemption' => $redemption
    //     ]);
    // }

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
                'points' => $guide->earned_points, // or however you track starting points
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

        // Subtract redeemed points from the existing row
        $redemption->points = $remaining - $totalPoints;
        $redemption->redeemed_at = now();
        $redemption->save();

        return response()->json([
            'message' => 'Redemption successful.',
            'redemption' => $redemption
        ]);
    }

    public function history($guideId)
    {
        return Redemption::where('guide_id', $guideId)->orderByDesc('redeemed_at')->get();
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
