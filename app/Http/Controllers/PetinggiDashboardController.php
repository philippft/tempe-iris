<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetinggiDashboardController extends Controller
{
    public function petinggiDashboard () 
    {
        return view('petinggi.dashboard');
    }
}
