<?php

namespace App\Http\Controllers\user;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductDetailController extends Controller
{
    public function show(Request $request, $id)
    {
        $product = Product::with('category')->find($id);

        // Check if the images are stored as a comma-separated string and convert them into an array
        if ($product && !is_null($product->images)) {
            $product->images = explode(',', $product->images); // Split the string into an array
        }

        if ($request->ajax()) {
            return response()->json(['product' => $product]);
        }
        return view('user.product.detailPage', compact('product'));
    }
}
