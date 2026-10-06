<?php

namespace App\Http\Controllers\admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    // Display a listing of the coupons
    public function index(Request $request)
    {
        if($request->ajax()){
            $coupons = Coupon::all();
            return response()->json($coupons);
        }
        return view('admin.coupon.index');
    }

    // Show the form for creating a new coupon
    public function create()
    {
        return view('admin.coupon.create'); // Adjust path as necessary
    }

    // Store a newly created coupon in storage
    public function store(Request $request)
    {
        dd($request->all());
        // Validate the request
        $request->validate([
            'code' => 'required|string|max:255|unique:coupons',
            'discount_amount' => 'required|numeric',
        ]);

        // Create the coupon
        Coupon::create([
            'code' => $request->code,
            'discount_amount' => $request->discount_amount,
            'is_active' => true, // Set default active status
        ]);

        return response()->json(['success' => true]);
    }

    // Show the form for editing the specified coupon
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return response()->json($coupon);
    }

    // Update the specified coupon in storage
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        // Validate the request
        $request->validate([
            'code' => 'required|string|max:255|unique:coupons,code,' . $coupon->id,
            'discount_amount' => 'required|numeric',
        ]);

        // Update the coupon
        $coupon->update([
            'code' => $request->code,
            'discount_amount' => $request->discount_amount,
            'is_active' => $request->has('is_active'), // Handle active status
        ]);

        return response()->json(['success' => true]);
    }

    // Remove the specified coupon from storage
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return response()->json(['success' => true]);
    }
}
