<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;

class UserDashboardController extends Controller
{
    public function userDashboard()
    {
        $surats = Surat::paginate(10);
        $totalPending = Surat::where('status_peminjaman', NULL)->count();
        $totalAktif = Surat::where('status_peminjaman', 1)->count();
        // kurang totalSelesai
        $totalTolak = Surat::where('status_peminjaman', 0)->count();

        return view('user.dashboard', compact('surats', 'totalPending', 'totalAktif', 'totalTolak'));
    }
}