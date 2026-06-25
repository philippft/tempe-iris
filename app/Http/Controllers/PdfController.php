<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function downloadSurat(Surat $surat)
    {
        $user = $surat->user;

        $pdf = Pdf::loadView('pdf.surat', compact('surat', 'user'));

        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('Surat_Permohonan_' . $user->username . '.pdf');
    }
}
