<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;
use App\Models\Category;
use App\Models\Inventaris;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserDashboardController extends Controller
{
    public function userDashboard()
    {
        $surats = Surat::paginate(1);

        return view('user.dashboard', compact('surats'));
    }

    public function indexPeminjamanUser()
    {
        $userId = auth()->id();
        $suratKeluar = Surat::where('id_user', $userId)->with('detailPeminjaman.inventaris')->get();

        $suratMasuk = Surat::whereHas('detailPeminjaman.inventaris', function ($q) use ($userId) {
            $q->where('id_user', $userId);
        })->get();

        // Surat yang REJECT
        $suratReject = $suratKeluar->where('status_peminjaman', 0);

        // Surat yang APPROVE
        $suratAprove = $suratKeluar->where('status_peminjaman', 1);

        // Surat yang PENDING / DRAF
        $suratPending = $suratKeluar->whereNull('status_peminjaman');

        return view('user.peminjaman.index', compact(
         'suratMasuk', 'suratKeluar', 'suratReject', 'suratAprove', 'suratPending'));
    }
}
