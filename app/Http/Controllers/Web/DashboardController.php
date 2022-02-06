<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // return redirect()->route('dashboard.index');
        return view('layouts.app');
    }
}
