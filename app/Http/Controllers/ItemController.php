<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    // Only admin can access (add middleware as needed)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'points' => 'required|integer|min:1',
        ]);
        $item = Item::create($request->only('name', 'points'));
        return response()->json(['item' => $item, 'message' => 'Item added!']);
    }
}
