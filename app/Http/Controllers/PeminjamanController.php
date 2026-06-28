<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventaris;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $suratMasuk = Surat::whereHas('detailPeminjaman.inventaris', function ($q) {
            $q->where('id_user', auth()->id());
        })->paginate(5);
        // dd($suratMasuk->first()->detailPeminjaman->first()->inventaris->user);

        $suratKeluar = Surat::where('id_user', auth()->id()
        )->paginate(5, ['*'], 'surat_keluar_page');
        // dd($suratKeluar->first()->detailPeminjaman->first()->inventaris->first()->user->organization_name);

        $suratMasukReject = $suratMasuk->whereStrict('status_peminjaman', 0);
        $suratKeluarReject = $suratKeluar->whereStrict('status_peminjaman', 0);

        $suratMasukApprove = $suratMasuk->where('status_peminjaman', 1);
        $suratKeluarApprove = $suratKeluar->where('status_peminjaman', 1);

        $suratMasukPending = $suratMasuk->where('status_peminjaman', null);
        $suratKeluarPending = $suratKeluar->where('status_peminjaman', null);

        $suratReject  = $suratMasukReject->merge($suratKeluarReject);
        $suratApprove = $suratMasukApprove->merge($suratKeluarApprove);
        $suratPending = $suratMasukPending->merge($suratKeluarPending);

        // dd($suratApprove, $suratPending, $suratReject);

        return view('admin.peminjaman.index', compact(
            'suratMasuk',
            'suratKeluar',
            'suratReject',
            'suratApprove',
            'suratPending'
        ));
    }

    public function create(Request $request)
    {
        $tujuan = User::with('organization')
            ->where('id', '!=', auth()->id())
            ->whereNotNull('id_organization')
            ->whereNotIn('role', ['mahasiswa'])
            ->get()
            ->unique('id_organization')
            ->filter(function ($user) {
                $name = $user->organization?->name;
                return $name !== 'Non-Organisasi' && !empty($name);
            })
            ->map(function ($user) {
                return (object) [
                    'id' => $user->id,
                    'organization_name' => $user->organization->name
                ];
            })
            ->values();
        // dd($tujuan);
        $categories = Category::all();

        $selectedTujuan = $request->query('id_tujuan');
        $search = $request->query('search');
        $categoryId = $request->query('category_id');

        $inventaris = Inventaris::where('id_user', '!=', auth()->id())
            ->with(['category'])
            ->withCount([
                'stocks as stok_tersedia' => function ($query) {
                    $query->where('status', 1);
                }
            ])
            ->when($selectedTujuan, function ($query, $selectedTujuan) {
                return $query->where('id_user', $selectedTujuan);
            })
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', '%' . $search . '%');
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('id_category', $categoryId);
            })
            ->get();

        return view('admin.peminjaman.create', compact('tujuan', 'categories', 'inventaris'));
    }

    public function destroy (Surat $surat)
    {
        DB::beginTransaction();

        try {
            if ($surat->getRawOriginal('status_peminjaman') !== 0) {
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

            DB::table('kegiatans')->where('id_surat', $surat->id)->delete();

            DB::table('detail_peminjaman')->where('id_surat', $surat->id)->delete();

            DB::table('surat')->where('id', $surat->id)->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Permohonan peminjaman berhasil dihapus total dari sistem.');
        } catch (\Exception $e) {
            DB::rollBack();

            dd([
                'Pesan Error' => $e->getMessage(),
                'File' => $e->getFile(),
                'Baris' => $e->getLine()
            ]);

            // return redirect()->back()->with('error', 'Gagal menghapus surat: ' . $e->getMessage());
        }
    }

    public function detailPeminjaman(Surat $surat)
    {
        $peminjam = $surat->user;
        $listBarang = $surat->detailPeminjaman; 
        // dd($listBarang);

        return view('admin.peminjaman.detail-surat', compact('surat', 'peminjam', 'listBarang'));
    }

    public function addDetailPeminjaman(Request $request)
    {
        $request->validate([
            'id_tujuan' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.id_inventaris' => 'required|exists:inventaris,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $userPengaju = auth()->user();
        $timestamp = now();


        // mulai transaction
        DB::beginTransaction();

        try {
            $randomHex = strtoupper(bin2hex(random_bytes(3)));
            $nomorDrafSementara = "DRAFT/" . ($userPengaju->username ?? 'USER') . "/" . $timestamp->format('mY') . "/" . $randomHex;

            //create surat
            $idSuratBaru = DB::table('surat')->insertGetId([
                'id_user'              => $userPengaju->id,
                'nomor'                => $nomorDrafSementara,
                'status_peminjaman'    => null,
                'catatan_peminjaman'   => null,
                'perihal_peminjaman'   => 'DRAF_PERMOHONAN',
                'tanggal_peminjaman'   => $timestamp,
                'tanggal_kembali'      => $timestamp->copy()->addDays(1),
                'tandatangan_pimpinan' => null,
                'penyelenggara'        => $userPengaju->organization_name ?? 'DRAF_ORGANISASI',
                'acara'                => 'DRAF_ACARA',
                'singkatan_acara'      => null,           // ← ada di migration, tambahkan
                'prodi'                => 'DRAF_PRODI',
                'nama_peminjam'        => $userPengaju->username ?? 'Anonim',
                'nim'                  => $userPengaju->NIM_NIP ?? '0000000000',
                'created_at'           => $timestamp,
                'updated_at'           => $timestamp,
            ]);

            // loop detail barang
            foreach ($request->input('items', []) as $itemId => $data) {

                //ambil stock status == 1
                $kepinganStok = DB::table('stocks')
                    ->where('id_inventaris', $data['id_inventaris'])
                    ->where('status', 1)
                    ->limit($data['qty'])
                    ->pluck('id');

                if ($kepinganStok->count() < $data['qty']) {
                    throw new \Exception("Maaf, ketersediaan stok kepingan untuk barang ini mendadak tidak mencukupi.");
                }

                // crate detail peminmajan
                DB::table('detail_peminjaman')->insert([
                    'id_surat' => $idSuratBaru,
                    'id_inventaris' => $data['id_inventaris'],
                    'qty_inventaris' => $data['qty'],
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);

                // create stocks
                DB::table('stocks')
                    ->whereIn('id', $kepinganStok)
                    ->update([
                        'status' => 0,
                        'updated_at' => $timestamp
                    ]);
            }

            DB::commit();

            return redirect()->route('admin.peminjaman.kegiatan', ['surat' => $idSuratBaru])
                ->with('success', 'Barang inventaris berhasil dikunci!');
        } catch (\Exception $e) {
            // rollback jika gagal
            DB::rollBack();
            //return redirect()->back()->with('error', 'Gagal memproses draf: ' . $e->getMessage());
            dd([
                'Pesan Error' => $e->getMessage(),
                'File Bermasalah' => $e->getFile(),
                'Baris Kode' => $e->getLine()
            ]);
        }
    }

    public function destroyDetailPeminjaman ()
    {
        
    }

    public function kegiatan(Surat $surat)
    {
        $surat->load('detailPeminjaman.inventaris.user.organization');

        $detailBarang = DB::table('detail_peminjaman')
            ->join('inventaris', 'detail_peminjaman.id_inventaris', '=', 'inventaris.id')
            ->join('categories', 'inventaris.id_category', '=', 'categories.id')
            ->where('detail_peminjaman.id_surat', $surat->id)
            ->select(
                'inventaris.nama as nama_barang',
                'inventaris.id',
                'detail_peminjaman.qty_inventaris',
                'categories.name as nama_kategori'
            )
            ->get();

        $tujuan = $surat->detailPeminjaman->map(function ($detail) {
            return $detail->inventaris?->user?->organization?->name;
        })->unique()->filter()->first();
        // dd($tujuan);

        return view('admin.peminjaman.kegiatan', compact('surat', 'detailBarang', 'tujuan'));
    }

    public function addKegiatan(Surat $surat, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'acara'       => 'required|string|max:50',
            'singkatan'   => 'nullable|string|max:50',
            'tanggal_peminjaman'  => 'required|date|after_or_equal:today',
            'tanggal_kembali'     => 'required|date|after_or_equal:tanggal_peminjaman',
            'perihal_peminjaman'  => 'required|string|max:255',
        ], [
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali tidak boleh mendahului tanggal pinjam.',
        ]);

        $timestamp   = now();
        $pengaju     = auth()->user();
        // dd($pengaju);
        $nomorSurat  = 'PJM/' . strtoupper($pengaju->username ?? 'USER') . '/' . $timestamp->format('m/Y') . '/' . strtoupper(bin2hex(random_bytes(2)));

        $surat->update([
            'nomor'               => $nomorSurat,
            'acara'               => $request->acara,
            'singkatan_acara'     => $request->singkatan,
            'tanggal_peminjaman'  => $request->tanggal_peminjaman . ' 08:00:00',
            'tanggal_kembali'     => $request->tanggal_kembali . ' 17:00:00',
            'perihal_peminjaman'  => $request->perihal_peminjaman,
            'status_peminjaman'   => NULL,
        ]);

        return redirect()->route('admin.peminjaman.detail.kegiatan', ['surat' => $surat->id])
            ->with('success', 'Permohonan ' . $nomorSurat . ' berhasil diajukan! Silakan tunggu pengecekan.');
    }

    public function detailKegiatan(Surat $surat)
    {
        return view('admin.peminjaman.detail-kegiatan', compact('surat'));
    }

    public function addDetailKegiatan(Surat $surat, Request $request)
    {
        $request->validate([
            'nomor'                         => 'required|string|max:255|unique:surat,nomor,',
            'penyelenggara'                 => 'required|string|max:255',
            'prodi'                         => 'required|string|max:255',
            'nama_peminjam'                 => 'required|string|max:50',
            'nim'                           => 'required|string|max:15',
            'kegiatan'                      => 'required|array|min:1',
            'kegiatan.*.nama_kegiatan'      => 'required|string|max:50',
            'kegiatan.*.hari'               => 'required|string|max:25',
            'kegiatan.*.tanggal'            => 'required|date',
            'kegiatan.*.waktu_mulai'        => 'required|string',
            'kegiatan.*.waktu_selesai'      => 'required|string',
        ]);

        $surat->update([
            'nomor'         => $request->nomor,
            'penyelenggara' => $request->penyelenggara,
            'prodi'         => $request->prodi,
            'nama_peminjam' => $request->nama_peminjam,
            'nim'           => $request->nim,
        ]);

        foreach ($request->kegiatan as $item) {
            $surat->kegiatan()->create([
                'nama'          => $item['nama_kegiatan'],
                'hari_mulai'    => $item['hari'],
                'tanggal_mulai' => $item['tanggal'],
                'waktu_mulai'   => $item['waktu_mulai'],
                'waktu_selesai' => $item['waktu_selesai'],
            ]);
        }

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Detail kegiatan berhasil disimpan.');
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
                'tandatangan_pimpinan' => 1,
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
}
