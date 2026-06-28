<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inventaris;

class DekanatDashboardController extends Controller
{
    public function dekanatDashboard()
    {
        $surat = Surat::whereHas('detailPeminjaman.inventaris', function ($q) {
            $q->where('id_user', auth()->id());
        })->with([
            'detailPeminjaman.inventaris.user.organization',
            'user'
        ])->get();

        $suratPending = $surat->filter(fn ($s) =>
            $s->getRawOriginal('status_peminjaman') === null || ($s->status_peminjaman == 1 && $s->tandatangan_pimpinan != 1)
        )->count();

        $suratReject = $surat->filter(fn ($s) =>
            (int) $s->getRawOriginal('status_peminjaman') === 0
            && $s->getRawOriginal('status_peminjaman') !== null
        )->count();

        $suratAktif = $surat->filter(fn ($s) =>
            $s->status_peminjaman == 1 && $s->tandatangan_pimpinan == 1 && now()->between($s->tanggal_peminjaman, $s->tanggal_kembali)
        )->count();

        $suratSelesai = $surat->filter(fn ($s) =>
            $s->status_peminjaman == 1 && $s->tandatangan_pimpinan == 1 && now()->gt($s->tanggal_kembali)
        )->count();

        $totalInventaris = Inventaris::where('id_user', auth()->id())->count();

        $inventarisDipinjam = Inventaris::where('id_user', auth()->id())
            ->whereHas('stocks', function ($q) {
                $q->where('status', 0);
            })
            ->with(['category', 'user.organization'])
            ->get();

        $peminjamanAktif = Surat::whereHas('detailPeminjaman.inventaris', function ($q) {
                $q->where('id_user', auth()->id());
            })
            ->where('status_peminjaman', 1)
            ->whereDate('tanggal_peminjaman', '<=', now())
            ->whereDate('tanggal_kembali', '>=', now())
            ->with([
                'detailPeminjaman.inventaris.user.organization',
                'user'
            ])
            ->latest()
            ->paginate(5);

        return view('dekanat.dashboard', compact('suratAktif', 'suratSelesai', 'suratPending', 'suratReject', 'totalInventaris', 'inventarisDipinjam', 'peminjamanAktif'));
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $suratMasuk = Surat::whereHas('detailPeminjaman.inventaris', function ($q) {
            $q->where('id_user', auth()->id());
        });
        // dd($suratMasuk->first()->detailPeminjaman->first()->inventaris->user);
        // dd($suratMasuk);

        if ($status === 'diterima') {
            $suratMasuk->where('status_peminjaman', 1)
                ->where('tandatangan_pimpinan', 1)
                ->whereDate('tanggal_peminjaman', '>', now());
        }

        elseif ($status === 'aktif') {
            $suratMasuk->where('status_peminjaman', 1)
                ->where('tandatangan_pimpinan', 1)
                ->whereDate('tanggal_peminjaman', '<=', now())
                ->whereDate('tanggal_kembali', '>=', now());
        }

        elseif ($status === 'selesai') {
            $suratMasuk->where('status_peminjaman', 1)
                ->where('tandatangan_pimpinan', 1)
                ->whereDate('tanggal_kembali', '<', now());
        }

        if ($search) {
            $suratMasuk->where(function ($q) use ($search) {
                $q->where('acara', 'like', "%{$search}%")
                ->orWhere('nomor', 'like', "%{$search}%");
            });
        }

        if ($status === 'pending') {
            $suratMasuk->whereNull('status_peminjaman');
        } elseif ($status === 'ditolak') {
            $suratMasuk->where('status_peminjaman', false);
        } elseif ($status === 'diterima') {
            $suratMasuk->where('status_peminjaman', true)
                ->whereDate('tanggal_peminjaman', '>', now());
        } elseif ($status === 'aktif') {
            $suratMasuk->where('status_peminjaman', true)
                ->whereDate('tanggal_peminjaman', '<=', now())
                ->whereDate('tanggal_kembali', '>=', now());
        } elseif ($status === 'selesai') {
            $suratMasuk->where('status_peminjaman', true)
                ->whereDate('tanggal_kembali', '<', now());
        }

        $suratMasuk = $suratMasuk
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $allSurat = Surat::whereHas('detailPeminjaman.inventaris', function ($q) {
            $q->where('id_user', auth()->id());
        })->get();

        $suratReject = $allSurat->filter(fn ($s) => $s->status_peminjaman == 0);
        $suratApprove = $allSurat->filter(function ($s) {
            return $s->status_peminjaman == 1 && $s->tandatangan_pimpinan == 1;
        });
        $suratPending = $allSurat->filter(function ($s) {
            return is_null($s->status_peminjaman) || ($s->status_peminjaman == 1 && $s->tandatangan_pimpinan != 1);
        });

        // dd($suratApprove, $suratPending, $suratReject);

        return view('dekanat.peminjaman.index', compact(
            'allSurat',
            'suratMasuk',
            'suratReject',
            'suratApprove',
            'suratPending'
        ));
    }

    public function detailPeminjaman(Request $request, Surat $surat)
    {
        $peminjam = $surat->user;
        $listBarang = $surat->detailPeminjaman;
        $type = $request->get('type', 'masuk');
        // dd($listBarang);

        return view('dekanat.peminjaman.detail-surat', compact('surat', 'peminjam', 'listBarang', 'type'));
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

                $itemsDiSurat = DB::table('detail_peminjaman')
                    ->where('id_surat', $surat->id)
                    ->select('id_inventaris', 'qty_inventaris')
                    ->get();

                foreach ($itemsDiSurat as $item) {
                    DB::table('stocks')
                        ->where('id_inventaris', $item->id_inventaris)
                        ->where('status', 0)
                        ->limit($item->qty_inventaris)
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

    public function destroy(Surat $surat)
    {
        DB::transaction(function () use ($surat) {
            $surat->detailPeminjaman()->delete();
            $surat->kegiatan()->delete();
            $surat->delete();
        });

        return redirect()
            ->route('dekanat.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
