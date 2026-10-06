<?php

namespace App\Http\Controllers\user;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    public function add(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // Check if the product is already in the wishlist
        $exists = Wishlist::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Product already in wishlist!'], 409); // Conflict status
        }

        // Create new wishlist entry
        $wishlist = new Wishlist();
        $wishlist->user_id = $request->user_id;
        $wishlist->product_id = $request->product_id;
        $wishlist->save();

        return response()->json(['message' => 'Product added to wishlist successfully!']);
    }
}
