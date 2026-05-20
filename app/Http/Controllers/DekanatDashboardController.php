<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DekanatDashboardController extends Controller
{
    public function dekanatDashboard () 
    {
        return view('dekanat.dashboard');
    }
}
