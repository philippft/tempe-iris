<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Organization;

class AuthController extends Controller
{
    public function loginView () 
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user()->role);
        }

        return view('login');
    }

    public function registerView() 
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user()->role);
        }

        $organizations = Organization::where('name', 'like', 'Program Studi%')
        ->orderBy('id')
        ->get();

        return view('register', compact('organizations'));
    }

    public function authenticate(Request $request) 
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        // dd($credentials);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (is_null(Auth::user()->verify_at)) {
                return redirect()->route('user.detail-akun', Auth::user()->id)
                    ->with('warning', 'Akun Anda sedang menunggu verifikasi admin.');
            }

            if(Auth::user()->role) {
                return $this->redirectBasedOnRole(Auth::user()->role);
            }
        };

        return back()->withErrors([
            'username' => 'Username atau Password salah!',
        ])->onlyInput('username');
    }

    public function register(Request $request) 
    {
        $validated = $request->validate([
            'nama_lengkap'      => 'required|string|max:255',
            'nim_nip'           => 'required|string|max:20|unique:users,nim_nip', // Input bernama nim_nip, tapi mengecek ke kolom nim di db
            'prodi'             => 'required|exists:organizations,id',
            'email'             => 'required|string|email|max:255|unique:users,email',
            'ktm'               => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'password'          => 'required|string|min:8|confirmed', 
        ], [
            'nim_nip.unique'    => 'NIM/NIP ini sudah terdaftar di sistem.', // Diperbaiki agar sesuai dengan nama input
            'email.unique'      => 'Email ini sudah digunakan.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
            'ktm.image'         => 'File yang diupload harus berupa gambar.',
        ]);

        $ktmPath = null;
        if ($request->hasFile('ktm')) {
            $file = $request->file('ktm');
            $fileName = 'ktm_' . $validated['nim_nip'] . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            Storage::disk('public')->putFileAs('ktm', $file, $fileName);
            $ktmPath = 'storage/ktm/' . $fileName; 
        }

        User::create([
            'name'      => $validated['nama_lengkap'], 
            'nim_nip'   => $validated['nim_nip'],
            'username'  => $validated['nim_nip'], 
            'id_organization'     => $validated['prodi'],
            'email'     => $validated['email'],
            'ktm'       => $ktmPath,
            'password'  => Hash::make($validated['password']), 
            'role'      => 'mahasiswa', 
            'verify_at' => null,
        ]);

        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Silakan login untuk mengecek status verifikasi Anda.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // nanti coba buatin helper 1 buat authnya
    private function redirectBasedOnRole(string $role): RedirectResponse
    {
        return match ($role) {
            'mahasiswa'         => redirect()->route('user.dashboard'),
            'admin_LM'          => redirect()->route('admin.dashboard'),
            'admin_dekanat'     => redirect()->route('dekanat.dashboard'),
            'petinggi_dekanat'  => redirect()->route('petinggi.dashboard'),
            default             => redirect()->route('login'),
        };
    }
}
