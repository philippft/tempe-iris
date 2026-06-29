<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Surat;
use App\Models\Inventaris;

class AdminDashboardController extends Controller
{
    public function adminDashboard (Request $request)
    {
        $admin = auth()->user();
        $search = $request->search;
        $sort = $request->sort;

        // ========== STATISTIK SURAT ==========
        // FIXED: Filter berdasarkan organization admin yang login
        $suratMasuk = Surat::with([
            'user.organization',
            'detailPeminjaman.inventaris.user.organization',
            'kegiatan'
        ])
        ->whereHas('user', function ($q) use ($admin) {
            $q->where('id_organization', $admin->id_organization);
        })
        ->latest()
        ->get();

        $suratReject = $suratMasuk->filter(
            fn($s) => $s->getRawOriginal('status_peminjaman') === 0
        )->count();

        $suratApprove = $suratMasuk->filter(
            fn($s) => $s->getRawOriginal('status_peminjaman') === 1 && $s->tandatangan_pimpinan == 1
        )->count();

        $suratPending = $suratMasuk->filter(function ($surat) {
            return $surat->status_peminjaman === null || ($surat->status_peminjaman == 1 && $surat->tandatangan_pimpinan != 1);
        })->count();

        $suratAktif = $suratMasuk->filter(function ($surat) {
            return $surat->status_peminjaman == 1 && $surat->tandatangan_pimpinan == 1 && $surat->tanggal_kembali >= now();
        })->count();

        $suratSelesai = $suratMasuk->filter(function ($surat) {
            return $surat->status_peminjaman == 1 && $surat->tandatangan_pimpinan == 1 && $surat->tanggal_kembali < now();
        })->count();

        // ========== STATISTIK INVENTARIS ==========
        // FIXED: Filter berdasarkan organization pemilik inventaris
        $inventaris = Inventaris::with([
            'user.organization',
            'category',
            'stocks',
            'detailPeminjaman.surat'
        ])
        ->whereHas('user', function ($q) use ($admin) {
            $q->where('id_organization', $admin->id_organization);
        })
        ->withCount([
            'stocks as stok_aktif' => function ($q) {
                $q->where('status', 1);
            },
            'stocks as stok_dipinjam' => function ($q) {
                $q->where('status', 0);
            }
        ])
        ->get();

        // FIXED: Total inventaris hanya dari organization admin
        $totalInventaris = $inventaris->count();

        // FIXED: Ambil inventaris yang sedang dipinjam dengan limit yang reasonable
        $inventarisDipinjam = $inventaris
            ->filter(fn($item) => $item->stok_dipinjam > 0)
            ->take(10); // Increased from 3 untuk better overview

        // ========== STATISTIK USER ==========
        // FIXED: Filter berdasarkan organization admin
        $users = User::where('role', 'mahasiswa')
            ->where('id_organization', $admin->id_organization)
            ->get();

        $userAktif = $users->filter(function ($user) {
            return $user->verify_at !== null;
        })->count();

        $userPending = $users->filter(function ($user) {
            return $user->verify_at === null
                && $user->note === null;
        })->count();

        // FIXED: Ambil lebih banyak pending users dengan limit yang reasonable
        $pendingUsers = $users->filter(function ($user) {
            return $user->verify_at === null
                && $user->note === null;
        })->take(10); // Increased from 5

        // ========== PEMINJAMAN AKTIF ==========
        $query = Surat::with([
            'user.organization',
            'detailPeminjaman.inventaris.user.organization',
            'kegiatan'
        ])
        // FIXED: Filter berdasarkan organization admin
        ->whereHas('user', function ($q) use ($admin) {
            $q->where('id_organization', $admin->id_organization);
        })
        ->where('status_peminjaman', 1)
        ->where('tandatangan_pimpinan', 1)
        ->whereDate('tanggal_kembali', '>=', now());

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor', 'like', "%{$search}%")
                    ->orWhere('acara', 'like', "%{$search}%");
            });
        }

        if ($sort === 'terbaru') {
            $query->latest('tanggal_peminjaman');
        } elseif ($sort === 'terlama') {
            $query->oldest('tanggal_peminjaman');
        } else {
            $query->latest();
        }

        $peminjamanAktif = $query
            ->paginate(5)
            ->withQueryString();

        
        return view('admin.dashboard', compact(
            'suratAktif', 
            'suratSelesai', 
            'suratPending', 
            'suratReject', 
            'suratApprove', 
            'totalInventaris', 
            'inventarisDipinjam', 
            'userAktif', 
            'userPending', 
            'pendingUsers', 
            'peminjamanAktif'
        ));
    }

    public function managementUser(Request $request) 
    {
        $admin = auth()->user();

        $search = $request->search;
        $status = $request->status;

        $query = User::where('role', 'mahasiswa')
            ->where('id_organization', $admin->id_organization);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nim_nip', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status === 'aktif') {
            $query->whereNotNull('verify_at');
        } elseif ($status === 'ditolak') {
            $query->whereNotNull('note')->whereNull('verify_at');
        } elseif ($status === 'pending') {
            $query->whereNull('note')->whereNull('verify_at');
        }

        $user = $query->paginate(5)->withQueryString();

        $totalMahasiswa = User::where('role', 'mahasiswa')
            ->where('id_organization', $admin->id_organization)
            ->count();

        $totalPending = User::where('role', 'mahasiswa')
            ->where('id_organization', $admin->id_organization)
            ->whereNull('verify_at')
            ->whereNull('note')
            ->count();

        return view('admin.user.index', compact('user', 'totalMahasiswa', 'totalPending', 'search', 'status'));
    }

    public function userDetail(User $user) {
        // dd($user);
        return view('admin.user.detail', compact('user'));
    }

    public function approveUser(User $user, Request $request) 
    {
        // dd($request);
        $request->validate([
            'status'  => 'required|in:setuju,tolak',
            'notes' => 'required_if:status,tolak|nullable|string|max:255',
        ]);



        if ($request->status === 'setuju') {
            $user->update([
                'verify_at' => now(),
                'note'     => null,
            ]);

            $userLogin = auth()->user();
            // dd($user);
            $emailPenerima = $user->email;
            $namaPenerima = $user->name;
            $emailPengirim = $userLogin->email;
            $namaPengirim = $userLogin->username;
            // dd($namaPengirim, $emailPengirim, $namaPenerima);

            Mail::to($emailPenerima)->send(
                new NotificationMail($namaPenerima, $emailPengirim, $namaPengirim)
            );

            return redirect()->route('admin.management.user')->with('success', 'Akun berhasil disetujui!');
        }

        if ($request->status === 'tolak') {
            $user->update([
                'verify_at' => null,
                'note'     => $request->notes,
            ]);
            return redirect()->route('admin.management.user')->with('error', 'Akun telah ditolak.');
        }
    }
}
