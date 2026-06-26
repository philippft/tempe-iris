<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;

class AdminDashboardController extends Controller
{
    public function adminDashboard ()
    {
        return view('admin.dashboard');
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
