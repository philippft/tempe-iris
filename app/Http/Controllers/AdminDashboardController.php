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
        $search = $request->search;
        $sort = $request->sort;

        // statistik surat
        $suratMasuk = Surat::with([
            'user.organization',
            'detailPeminjaman.inventaris.user.organization',
            'kegiatan'
        ])->latest()->get();

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

        // statistik inventaris
        $inventaris = Inventaris::with([
            'user.organization',
            'category',
            'stocks',
            'detailPeminjaman.surat'
        ])
        ->withCount([
            'stocks as stok_aktif' => function ($q) {
                $q->where('status', 1);
            },
            'stocks as stok_dipinjam' => function ($q) {
                $q->where('status', 0);
            }
        ])
        ->get();

        $totalInventaris = $inventaris->count();

        $inventarisDipinjam = $inventaris
            ->filter(fn($item) => $item->stok_dipinjam > 0)
            ->take(3);

        //statistik user
        $users = User::where('role', 'mahasiswa')->get();

        $userAktif = $users->filter(function ($user) {
            return $user->verify_at !== null;
        })->count();

        $userPending = $users->filter(function ($user) {
            return $user->verify_at === null
                && $user->note === null;
        })->count();

        $pendingUsers = $users->filter(function ($user) {
            return $user->verify_at === null
                && $user->note === null;
        })->take(5);

        $search = request('search');
        $sort = request('sort');

        $query = Surat::with([
            'user.organization',
            'detailPeminjaman.inventaris.user.organization',
            'kegiatan'
        ])
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

        
        return view('admin.dashboard', compact('suratAktif', 'suratSelesai', 'suratPending', 'suratReject', 'suratApprove', 'totalInventaris', 'inventarisDipinjam', 'userAktif', 'userPending', 'pendingUsers', 'peminjamanAktif'));
    }

    public function managementUser() 
    {
        $user = User::where('role', 'mahasiswa')->get();
        // dd($user);

        return view('admin.user.index', compact('user'));
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
