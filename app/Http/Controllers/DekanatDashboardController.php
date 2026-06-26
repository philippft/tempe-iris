<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DekanatDashboardController extends Controller
{
    public function dekanatDashboard () 
    {

        return view('dekanat.dashboard');
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

        return view('dekanat.peminjaman.index', compact(
            'suratMasuk',
            'suratReject',
            'suratApprove',
            'suratPending'
        ));
    }

    public function detailPeminjaman(Surat $surat)
    {
        $peminjam = $surat->user;
        $listBarang = $surat->detailPeminjaman;
        // dd($listBarang);

        return view('dekanat.peminjaman.detail-surat', compact('surat', 'peminjam', 'listBarang'));
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
                'status_peminjaman'  => $request->status_peminjaman,
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
