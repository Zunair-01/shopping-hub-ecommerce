<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboarController extends Controller
{
    public function index(){
        return view('admin.adminDashboard',['title' => 'Dashboard']);
    }
}
