<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;
use App\Models\Category;
use App\Models\Inventaris;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\Organization;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function userDashboard()
    {
        $surats = Surat::paginate(1);
        $totalAktif = Surat::where('status_peminjaman', 1)->count();
        $totalPending = Surat::where('status_peminjaman', 0)->count();

        return view('user.dashboard', compact('surats', 'totalAktif', 'totalPending'));
    }

    public function detail(User $user)
    {
        if (auth()->user()->id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke halaman profil ini.');
        }
        return view('user.detail-akun', compact('user'));
    } 
    public function index()
    {
        // dd($suratMasuk->first()->detailPeminjaman->first()->inventaris->user);

        $suratKeluar = Surat::where('id_user', auth()->id())
        ->get();
        // dd($suratKeluar->first()->detailPeminjaman->first()->inventaris->first()->user->organization_name);
        
        $suratReject = $suratKeluar->filter(
            fn($s) => $s->getRawOriginal('status_peminjaman') === 0
        );

        $suratAprove = $suratKeluar->filter(
            fn($s) => $s->getRawOriginal('status_peminjaman') === 1
        );

        $suratPending = $suratKeluar->filter(function ($surat) {
            return $surat->id_user === auth()->id()
                && $surat->status_peminjaman === null;
        });
        // dd($totalSurat);

        return view('user.peminjaman.index', compact('suratKeluar', 'suratReject', 'suratAprove', 'suratPending'));
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

        $categories = Category::all();

        // Catch data dari query string URL
    $selectedTujuan = $request->query('id_tujuan');
    $search = $request->query('search');
    $categoryId = $request->query('category_id');

    // 1. Secara default, inventaris kosong jika tujuan belum dipilih
    $inventaris = collect(); 

    // 2. Jika tujuan sudah dipilih, baru tarik data dari database
    if ($selectedTujuan) {
        $inventaris = Inventaris::where('id_user', '!=', auth()->id())
            ->with(['category'])
            ->withCount([
                'stocks as stok_tersedia' => function ($query) {
                    $query->where('status', 1);
                }
            ])
            // Langsung gunakan where karena $selectedTujuan pasti ada nilainya
            ->where('id_user', $selectedTujuan) 
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', '%' . $search . '%');
            })
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('id_category', $categoryId);
            })
            ->get();
    }

    return view('user.peminjaman.create', compact('tujuan', 'categories', 'inventaris'));

        // dd($tujuan);

        return view('user.peminjaman.create', compact('tujuan', 'categories', 'inventaris'));
    }

    public function detailPeminjaman(Surat $surat)
    {
        return view('user.peminjaman.detail-surat', compact('surat'));
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

            return redirect()->route('user.peminjaman.kegiatan', ['surat' => $idSuratBaru])
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

    public function detailAkun(User $user)
    {
        if (auth()->user()->id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke halaman profil ini.');
        }

        $organizations = Organization::where('name', 'like', 'Himpunan Mahasiswa%')
        ->orderBy('id')
        ->get();

        return view('user.detail-akun', compact('user', 'organizations'));
    }

    public function detailAkunEdit(User $user, Request $request)
    {
        if (auth()->id() !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit profil ini.');
        }

        // 2. Validasi Data
        $validatedData = $request->validate([
            'name'            => 'required|string|max:255',
            'nim_nip'         => 'required|string|max:20|unique:users,nim_nip,' . $user->id,
            'id_organization' => 'required|exists:organizations,id',
            'email'           => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'ktm'             => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Wajib file gambar
        ]);

        // 3. Logika Upload Menggunakan Storage::
        if ($request->hasFile('ktm')) {
            if ($user->ktm && Storage::disk('public')->exists($user->ktm)) {
                Storage::disk('public')->delete($user->ktm);
            }

            $file = $request->file('ktm');
            $fileName = 'ktm_' . $user->nim_nip . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('ktm', $file, $fileName);

            $validatedData['ktm'] = $path;
        }

        // 4. Update Database
        $user->update($validatedData);

        // 5. Kembali dengan pesan sukses
        return redirect()->route('user.detail-akun', $user->id)
            ->with('success', 'Profil dan Foto KTM berhasil diperbarui.');
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

        $nama_tujuan = $surat->detailPeminjaman->first()->inventaris->user->organization->name ?? '-' ;

        return view('user.peminjaman.kegiatan', compact('surat', 'detailBarang', 'nama_tujuan'));
    }

    public function addKegiatan (Surat $surat, Request $request) 
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
                'status_peminjaman'   => 0,
            ]);

            return redirect()->route('user.peminjaman.detail.kegiatan', ['surat' => $surat->id])
                ->with('success', 'Permohonan ' . $nomorSurat . ' berhasil diajukan! Silakan tunggu pengecekan.');
    }

    public function detailKegiatan (Surat $surat) 
    {
        return view('user.peminjaman.detail-kegiatan', compact('surat'));
    }

    public function addDetailKegiatan (Surat $surat, Request $request) 
    {
            $request->validate([
                'nomor'                         => 'required|string|max:255',
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
                $waktuMulaiRaw = str_replace('.', ':', $item['waktu_mulai']);
                $waktuSelesaiRaw = str_replace('.', ':', $item['waktu_selesai']);
                
                $waktuMulaiFormatted = Carbon::parse($waktuMulaiRaw)->format('H:i');
                $waktuSelesaiFormatted = Carbon::parse($waktuSelesaiRaw)->format('H:i');
                

                $surat->kegiatan()->create([
                    'nama'          => $item['nama_kegiatan'],
                    'hari_mulai'    => $item['hari'],
                    'tanggal_mulai' => $item['tanggal'],
                    'waktu_mulai'   => $waktuMulaiFormatted,
                    'waktu_selesai' => $waktuSelesaiFormatted,
                ]);

                
            }

            return redirect()->route('user.peminjaman.index')
                ->with('success', 'Detail kegiatan berhasil disimpan.');
    }
}
