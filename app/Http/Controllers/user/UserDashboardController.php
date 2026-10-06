<?php

namespace App\Http\Controllers\user;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserDashboardController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $products = Product::with('category')->get();
            return response()->json(['products' => $products]);
        }
        return view('user.userDashboard', ['title' => 'dashboard']);
    }
}
