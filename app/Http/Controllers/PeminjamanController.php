<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventaris;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $totalSurat = Surat::with('detailPeminjaman.inventaris')->get();

        $suratMasuk = Surat::whereHas('detailPeminjaman.inventaris', function ($q) {
            $q->where('id_user', auth()->id());
        })->get();
        // dd($suratMasuk->first()->detailPeminjaman->first()->inventaris->user);

        $suratKeluar = $totalSurat->where('id_user', auth()->id());
        // dd($suratKeluar->first()->detailPeminjaman->first()->inventaris->first()->user->organization_name);
        
        $suratReject = $totalSurat->where('id_user', auth()->id())->where('status_peminjaman', 0);

        $suratAprove = $totalSurat->where('id_user', auth()->id())->where('status_peminjaman', 1);

        $suratPending = $totalSurat->filter(function ($surat) {
            return $surat->id_user === auth()->id()
                && $surat->status_peminjaman === null;
        });

        // dd($totalSurat);

        return view('admin.peminjaman.index', compact('totalSurat', 'suratMasuk', 'suratKeluar', 'suratReject', 'suratAprove', 'suratPending'));
    }

    public function create(Request $request)
    {
        $tujuan = DB::table('users')
            ->where('id', '!=', auth()->id())
            ->whereNotNull('organization_name')
            ->where('organization_name', '!=', '')
            ->whereNotIn('role', ['mahasiswa'])
            ->whereNotIn('organization_name', ['Non-Organisasi'])
            ->select('id', 'organization_name')
            ->get()
            ->unique('organization_name');

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

    public function kegiatan (Surat $surat) 
    {
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

        return view('admin.peminjaman.kegiatan', compact('surat', 'detailBarang'));
    }

        public function addKegiatan (Surat $surat, Request $request) {
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
                'status_peminjaman'   => 0,
            ]);

            return redirect()->route('admin.peminjaman.detail.kegiatan', ['surat' => $surat->id])
                ->with('success', 'Permohonan ' . $nomorSurat . ' berhasil diajukan! Silakan tunggu pengecekan.');
        }

        public function detailKegiatan (Surat $surat) {
            return view('admin.peminjaman.detail-kegiatan', compact('surat'));
        }

        public function addDetailKegiatan (Surat $surat, Request $request) 
        {
            dd($surat, $request);
        }
}
