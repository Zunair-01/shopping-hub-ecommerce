<?php

namespace App\Http\Controllers\user;

use App\Models\Cart;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function add(Request $request)
    {
        // Validate the request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        // Check if the item is already in the cart
        $cartItem = Cart::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->where('size', $request->size)
            ->first();

        if ($cartItem) {
            // Update quantity if item already exists
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Add new item to the cart
            Cart::create([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'size' => $request->size,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json(['message' => 'Item added to cart successfully']);
    }

    // Fetch cart data with discounts, tax, and shipping charges
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $cartItems = Cart::with('product')->get();

            // Calculate total amount
            $totalAmount = $cartItems->sum(function ($item) {
                return ($item->product->sale_price ?? $item->product->regular_price) * $item->quantity;
            });

            // Fetch discount, tax, and shipping charges
            $discountInfo = Discount::first(); // Adjust as needed to fetch the right discount

            // Initialize amounts
            $discountAmount = 0;
            $taxAmount = 0;
            $shippingCharges = $discountInfo->shipping_charges ?? 0;

            // Calculate discounts: $3 discount for every $100 spent
            if ($totalAmount >= 100) {
                $discountAmount = floor($totalAmount / 100) * ($discountInfo->discount ?? 0);
            }

            // Calculate taxes: $2 tax for every $50 spent
            if ($totalAmount >= 50) {
                $taxAmount = floor($totalAmount / 50) * ($discountInfo->tax ?? 0);
            }

            // Calculate final total
            $finalAmount = $totalAmount - $discountAmount + $taxAmount + $shippingCharges;

            return response()->json([
                'cartItems' => $cartItems,
                'totalAmount' => $totalAmount,
                'discountAmount' => $discountAmount,
                'taxAmount' => $taxAmount,
                'shippingCharges' => $shippingCharges,
                'finalAmount' => $finalAmount
            ]);
        }

        return view('user.cart.cart');
    }

    public function updateQuantity(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->quantity = $request->input('quantity');
        $cartItem->save();

        return response()->json(['success' => true]);
    }

    public function removeItem($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return response()->json(['success' => true]);
    }
}
