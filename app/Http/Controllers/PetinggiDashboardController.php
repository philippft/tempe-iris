<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;
use App\Models\Category;
use App\Models\Inventaris;
use Illuminate\Support\Facades\DB;

class PetinggiDashboardController extends Controller
{
    public function petinggiDashboard () 
    {
        $surats = Surat::paginate(10);
        $suratKeluar = Surat::where('id_user', auth()->id())->get();
        // dd($suratKeluar->first()->detailPeminjaman->first()->inventaris->first()->user->organization_name);
        
        $suratDone = $suratKeluar->filter(
            fn($s) => $s->getRawOriginal('tandatangan_pimpinan') === 1
        )->count();

        $suratReject = $suratKeluar->filter(
            fn($s) => $s->getRawOriginal('status_peminjaman') === 0
        )->count();

        $suratAprove = $suratKeluar->filter(
            fn($s) => $s->getRawOriginal('status_peminjaman') === 1
        )->count();

        $suratPending = $suratKeluar->filter(function ($surat) {
            return $surat->id_user === auth()->id()
                && $surat->status_peminjaman === null;
        })->count();
        return view('petinggi.dashboard', compact('surats', 'suratKeluar', 'suratDone', 'suratReject', 'suratAprove', 'suratPending'));
    }
}
