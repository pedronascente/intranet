<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $request = $request->session()->all();
        //dd($request);
        return view('dashboard.index');
    }
}
