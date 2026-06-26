<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetinggiDashboardController extends Controller
{
    public function petinggiDashboard () 
    {
        $suratMasuk = Surat::whereHas('detailPeminjaman.inventaris', function ($q) {
            $q->where('id_user', auth()->id());
        })->get();


        return view('petinggi.dashboard');
    }

    public function index()
    {
        $suratMasuk = Surat::whereHas('detailPeminjaman.inventaris', function ($q) {
            $q->where('id_user', auth()->id());
        })->get();
        // dd($suratMasuk->first()->detailPeminjaman->first()->inventaris->user);
        // dd($suratMasuk);

        $suratReject  = $suratMasuk->whereStrict('status_peminjaman', 0);
        $suratApprove = $suratMasuk->where('status_peminjaman', 1);
        $suratPending = $suratMasuk->where('status_peminjaman', null);

        // dd($suratApprove, $suratPending, $suratReject);

        return view('petinggi.peminjaman.index', compact(
            'suratMasuk',
            'suratReject',
            'suratApprove',
            'suratPending'
        ));
    }

    public function detailPeminjaman(Surat $surat)
    {
        $user = $surat->user;

        $surat->load(['user', 'detailPeminjaman.inventaris.user', 'kegiatan']);

        $tujuan = $surat->detailPeminjaman->map(function ($detail) {
            return $detail->inventaris->user->organization->name;
        })->unique()->values()->first();

        // dd($tujuan);

        $kegiatan = $surat->kegiatan->map(function ($item) {
            $item['nama_kegiatan'] = $item['nama'];

            $item['hari_mulai'] = $item['hari_mulai'];

            $item['tanggal_kegiatan'] = $item['tanggal_mulai']
                ?->locale('id')
                ?->translatedFormat('d F Y') ?? '-';

            $item['waktu_mulai'] = $item['waktu_mulai']
                ? date('H:i', strtotime($item['waktu_mulai']))
                : '-';

            $item['waktu_selesai'] = $item['waktu_selesai']
                ? date('H:i', strtotime($item['waktu_selesai']))
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

        // dd($surat->user->organization->name)

        return view('petinggi.peminjaman.detail-surat', compact('surat', 'user', 'tujuan', 'kegiatan', 'inventaris'));
    }

    public function verifikasiSurat(Request $request, Surat $surat)
    {
        $request->validate([
            'status_peminjaman'  => 'required|in:0,1',
            'catatan_peminjaman' => 'nullable|string|max:500',
        ]);

        if ($request->status_peminjaman == '0' && empty($request->catatan_peminjaman)) {
            return back()->withErrors(['catatan_peminjaman' => 'Wajib memberikan alasan jika menolak permohonan.'])->withInput();
        }

        DB::beginTransaction();

        try {
            $surat->update([
                'tandatangan_pimpinan'  => $request->status_peminjaman,
                'catatan_peminjaman' => $request->catatan_peminjaman,
            ]);


            if ($request->status_peminjaman == '0') {
                $idInventarisList = DB::table('detail_peminjaman')
                    ->where('id_surat', $surat->id)
                    ->pluck('id_inventaris');

                if ($idInventarisList->isNotEmpty()) {
                    DB::table('stocks')
                        ->whereIn('id_inventaris', $idInventarisList)
                        ->where('status', 0)
                        ->update([
                            'status'     => 1,
                            'updated_at' => now(),
                        ]);
                }
            }

            DB::commit();

            $pesan = $request->status_peminjaman == '1' ? 'Peminjaman disetujui!' : 'Peminjaman ditolak dan stok dikembalikan.';
            return redirect()->back()->with('success', $pesan);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }
}
