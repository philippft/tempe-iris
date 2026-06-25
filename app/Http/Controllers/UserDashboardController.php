<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;
use App\Models\User;

class UserDashboardController extends Controller
{
    public function userDashboard()
    {
        $surats = Surat::paginate(1);
        $totalAktif = Surat::where('status_peminjaman', 1)->count();
        $totalPending = Surat::where('status_peminjaman', 0)->count();

        return view('user.dashboard', compact('surats', 'totalAktif', 'totalPending'));
    }

    public function detail(User $user)
    {
        if (auth()->user()->id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke halaman profil ini.');
        }
        return view('user.detail-akun', compact('user'));
    } 
}
