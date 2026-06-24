<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;

class UserDashboardController extends Controller
{
    public function userDashboard()
    {
        $surats = Surat::all();

        return view('user.dashboard', compact('surats'));
    }
}
