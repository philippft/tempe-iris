<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kegiatan;
use Carbon\Carbon;

class PdfController extends Controller
{
    public function downloadSurat(Surat $surat)
    {
        $user = $surat->user;

        $surat->load(['user', 'detailPeminjaman.inventaris.user', 'kegiatan']);

        $singkatanAcara = collect(explode(' ', $surat->acara))
            ->map(function ($word) {
                return strtoupper(substr($word, 0, 1));
            })
            ->implode('');

        $tujuan = $surat->detailPeminjaman->map(function ($detail) {
            return $detail->inventaris->user->organization->name;
        })->unique()->values()->first();

        // dd($tujuan);

        $detail_kegiatan = $surat->kegiatan->map(function ($item) {
            $item['nama_kegiatan'] = $item['nama'];
            $item['hari_mulai'] = $item['hari_mulai'];

            $item['tanggal_kegiatan'] = $item['tanggal_mulai'] 
                ? $item['tanggal_mulai']->locale('id')->translatedFormat('d F Y') 
                : '-'; 
            
            // Carbon akan membaca '19:00:00' dari database, lalu memformatnya jadi '19.00'
            $item['waktu_mulai'] = $item['waktu_mulai'] 
                ? \Carbon\Carbon::parse($item['waktu_mulai'])->format('H.i') 
                : '-';
                
            $item['waktu_selesai'] = $item['waktu_selesai'] 
                ? \Carbon\Carbon::parse($item['waktu_selesai'])->format('H.i') 
                : '-';
            
            return $item;
        });

        $inventaris = $surat->detailPeminjaman->map(function ($detail) {
            $detail['nama_inventaris'] = $detail->inventaris->nama;
            $detail['jumlah'] = $detail->qty_inventaris;
            $detail['tanggal_peminjaman'] = $detail->surat->tanggal_peminjaman
                ?->locale('id')
                ?->translatedFormat('d F Y') ?? '-';
            $detail['waktu_peminjaman'] = $detail->surat->tanggal_peminjaman
                ?->format('H:i') ?? '-';
            $detail['tanggal_kembali'] = $detail->surat->tanggal_kembali
                ?->locale('id')
                ?->translatedFormat('d F Y') ?? '-';
            $detail['waktu_kembali'] = $detail->surat->tanggal_kembali
                    ?->format('H:i') ?? '-';

            return $detail;
        });

        // dd($surat);
        // dd($surat->user->organization->name)

        $pdf = Pdf::loadView('pdf.surat', compact('surat', 'user', 'tujuan', 'detail_kegiatan', 'singkatanAcara', 'inventaris'));

        $pdf->setPaper('a4', 'portrait');

        $safeNomor = str_replace('/', '_', $surat->nomor);
        return $pdf->download('Surat_Permohonan_' . $safeNomor . '.pdf');
    }
    public function previewSurat(Surat $surat)
    {
        $user = $surat->user;

        $surat->load([
            'user.organization',
            'detailPeminjaman.inventaris.category',
            'detailPeminjaman.inventaris.user.organization',
            'kegiatan',
        ]);

        $singkatanAcara = collect(explode(' ', $surat->acara))
            ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
            ->implode('');

        $tujuan = $surat->detailPeminjaman
            ->map(fn ($detail) => optional($detail->inventaris->user->organization)->name)
            ->filter()
            ->unique()
            ->first();
    
        $detail_kegiatan = $surat->kegiatan->map(function ($item) {

            return (object) [
                'nama_kegiatan' => $item->nama,
                'hari_mulai' => $item->hari_mulai,

                'tanggal_kegiatan' => $item->tanggal_mulai
                    ? $item->tanggal_mulai
                        ->locale('id')
                        ->translatedFormat('d F Y')
                    : '-',
                
                'waktu_mulai' => $item->waktu_mulai
                    ? Carbon::parse($item->waktu_mulai)->format('H.i')
                    : '-',

                'waktu_selesai' => $item->waktu_selesai
                    ? Carbon::parse($item->waktu_selesai)->format('H.i')
                    : '-',
            ];
        });

        $inventaris = $surat->detailPeminjaman->map(function ($detail) {

            return (object) [

                'nama_inventaris' => $detail->inventaris->nama,

                'kategori' => optional(
                    $detail->inventaris->category
                )->nama,

                'gambar' => $detail->inventaris->gambar,

                'jumlah' => $detail->qty_inventaris,

                'tanggal_peminjaman' => optional(
                    $detail->surat->tanggal_peminjaman
                )?->locale('id')->translatedFormat('d F Y') ?? '-',

                'waktu_peminjaman' => optional(
                    $detail->surat->tanggal_peminjaman
                )?->format('H:i') ?? '-',

                'tanggal_kembali' => optional(
                    $detail->surat->tanggal_kembali
                )?->locale('id')->translatedFormat('d F Y') ?? '-',

                'waktu_kembali' => optional(
                    $detail->surat->tanggal_kembali
                )?->format('H:i') ?? '-',
            ];
        });

        return view(
            'surat.preview',
            compact(
                'surat',
                'user',
                'tujuan',
                'detail_kegiatan',
                'singkatanAcara',
                'inventaris'
            )
        );
        // $user = $surat->user;
        // $surat->load(['user', 'detailPeminjaman.inventaris.user', 'kegiatan']);

        // $tujuan = $surat->detailPeminjaman->map(function ($detail) {
        //     return $detail->inventaris->user->organization->name;
        // })->unique()->values()->first();

        // $kegiatan = $surat->kegiatan->map(function ($item) {
        //     $item['nama_kegiatan'] = $item['nama'];
        //     $item['hari_mulai']    = $item['hari_mulai'];
        //     $item['tanggal_kegiatan'] = $item['tanggal_mulai']
        //         ?->locale('id')->translatedFormat('d F Y') ?? '-';
        //     $item['waktu_mulai']   = $item['waktu_mulai']
        //         ? date('H:i', strtotime($item['waktu_mulai'])) : '-';
        //     $item['waktu_selesai'] = $item['waktu_selesai']
        //         ? date('H:i', strtotime($item['waktu_selesai'])) : '-';
        //     return $item;
        // });

        // $inventaris = $surat->detailPeminjaman->map(function ($detail) {
        //     $detail['nama_inventaris']    = $detail->inventaris->nama;
        //     $detail['jumlah']             = $detail->qty_inventaris;
        //     $detail['tanggal_peminjaman'] = $detail->surat->tanggal_peminjaman
        //         ?->locale('id')->translatedFormat('d F Y') ?? '-';
        //     $detail['waktu_peminjaman']   = $detail->surat->tanggal_peminjaman
        //         ?->format('H:i') ?? '-';
        //     $detail['tanggal_kembali']    = $detail->surat->tanggal_kembali
        //         ?->locale('id')->translatedFormat('d F Y') ?? '-';
        //     $detail['waktu_kembali']      = $detail->surat->tanggal_kembali
        //         ?->format('H:i') ?? '-';
        //     return $detail;
        // });

        // // Return sebagai HTML biasa, bukan PDF
        // return view('pdf.surat', compact('surat', 'user', 'tujuan', 'kegiatan', 'inventaris'));
    }
}
