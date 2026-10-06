<?php

namespace App\Http\Controllers\admin;

use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $discount = Discount::all();
            return response()->json($discount);
        }
        return view('admin.discountAndTax.index',['title' => 'discount index']);
    }

    public function create()
    {
        return view('admin.discountAndTax.create',['title' => 'discount create']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'discount' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'shipping_charges' => 'nullable|numeric',
        ]);

        Discount::create([
            'discount' => $request->discount,
            'tax' => $request->tax,
            'shipping_charges' => $request->shipping_charges,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Discount saved successfully!',
        ]);
    }

    public function edit($id){
        $discount = Discount::findOrFail($id);
        return view('admin.discountAndTax.edit',get_defined_vars(),['title' => 'discount edit']);
    }

    public function update(Request $request, $id){
        $request->validate([
            'discount' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'shipping_charges' => 'nullable|numeric',
        ]);
        $discount = Discount::findOrFail($id);
        $discount->update([
            'discount' => $request->discount,
            'tax' => $request->tax,
            'shipping_charges' => $request->shipping_charges,
        ]);
        return response()->json([
            'success' => true,
            'msg' => 'Discount updated successfully!',
        ]);
    }

    public function destroy($id)
    {
        $discount = Discount::findOrFail($id);
        $discount->delete();

        return response()->json([
            'success' => true,
            'message' => 'Discount deleted successfully!',
        ]);
    }
}
