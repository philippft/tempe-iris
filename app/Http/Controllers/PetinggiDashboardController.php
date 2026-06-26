<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;

class PetinggiDashboardController extends Controller
{
    public function petinggiDashboard () 
    {
        $suratMasuk = Surat::whereHas('detailPeminjaman.inventaris', function ($q) {
            $q->where('id_user', auth()->id());
        })->get();
        

        return view('petinggi.dashboard');
    }
}
