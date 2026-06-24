<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;

class UserDashboardController extends Controller
{
    public function userDashboard()
    {
        $surats = Surat::paginate(1);
        $totalAktif = Surat::where('status_peminjaman', 1)->count();
        $totalPending = Surat::where('status_peminjaman', 0)->count();

        return view('user.dashboard', compact('surats', 'totalAktif', 'totalPending'));
    }
}
