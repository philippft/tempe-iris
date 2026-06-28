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

    public function suratDashboard(Request $request)
    {
        $query = Surat::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nomor', 'like', '%' . $request->search . '%')
                ->orWhere('perihal_peminjaman', 'like', '%' . $request->search . '%')
                ->orWhere('acara', 'like', '%' . $request->search . '%')
                ->orWhere('nama_peminjam', 'like', '%' . $request->search . '%');
            });
        }

        // Filter status
        if ($request->filled('status')) {
            if ($request->status === 'pending') {
                $query->whereNull('status_peminjaman');
            } else {
                $query->where('status_peminjaman', $request->status);
            }
        }

        $surats = $query->latest()->paginate(10)->withQueryString();

        return view('petinggi.peminjaman.index', compact('surats'));
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
            return back()->withErrors(['catatan_peminjaman' => 'Wajib memberikan alasan jika menolak.'])->withInput();
        }

        DB::beginTransaction();
        try {
            $surat->update([
                'tandatangan_pimpinan' => $request->status_peminjaman,
                'status_peminjaman'    => $request->status_peminjaman, // ← tambah ini
                'catatan_peminjaman'   => $request->catatan_peminjaman,
            ]);

            if ($request->status_peminjaman == '0') {
                $idInventarisList = DB::table('detail_peminjaman')
                    ->where('id_surat', $surat->id)
                    ->pluck('id_inventaris');

                if ($idInventarisList->isNotEmpty()) {
                    DB::table('stocks')
                        ->whereIn('id_inventaris', $idInventarisList)
                        ->where('status', 0)
                        ->update(['status' => 1, 'updated_at' => now()]);
                }
            }

            DB::commit();
            $pesan1 = $request->status_peminjaman == '1' ? 'Peminjaman disetujui!' : 'Peminjaman ditolak.';
            $pesan2 = $request->tandatangan_pimpinan == '1' ? 'Tanda tangan disetujui!' : 'Tanda tangan ditolak.';

            return redirect()->back()
                ->with('success', $pesan1)
                ->with('info', $pesan2);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}
