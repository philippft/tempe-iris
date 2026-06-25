<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function loginView () 
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user()->role);
        }

        return view('login');
    }

    public function registerView () 
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user()->role);
        }

        return view('register');
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
                // Auth::logout();
                // $request->session()->invalidate();
                // $request->session()->regenerateToken();

                // return back()->withErrors([
                //     'username' => 'Akun Anda belum diverifikasi oleh Admin.',
                // ])->onlyInput('username');
                return redirect()->route('mahasiswa.user.detail-akun', Auth::user()->id)
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
            'nim'               => 'required|string|max:20|unique:users,nim', // Asumsi kolom di db adalah 'nim'
            'program_studi'     => 'required|string|max:100',
            'email'             => 'required|string|email|max:255|unique:users,email',
            'ktm'               => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB sesuai gambar (.jpg, .png, .jpeg)
            'password'          => 'required|string|min:8|confirmed', // 'confirmed' otomatis mencari input 'password_confirmation'
        ], [
            'nim.unique'        => 'NIM ini sudah terdaftar di sistem.',
            'email.unique'      => 'Email ini sudah digunakan.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
            'ktm.image'         => 'File yang diupload harus berupa gambar.',
        ]);

        $ktmPath = null;
        if ($request->hasFile('ktm')) {
            $file = $request->file('ktm');
            // Membuat nama file yang unik
            $fileName = 'ktm_' . $validated['nim'] . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Menyimpan file ke folder 'public/ktm' (bisa juga 'public/images' jika Anda mau)
            Storage::disk('public')->putFileAs('ktm', $file, $fileName);
            
            // Menyimpan format path lengkapnya agar mudah dipanggil dengan asset()
            $ktmPath = 'storage/ktm/' . $fileName; 
        }

        return redirect()->route('login')
        ->with('success', 'Pendaftaran berhasil! Silakan tunggu verifikasi admin.');
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
            'mahasiswa'         => redirect()->route('mahasiswa.dashboard'),
            'admin_LM'          => redirect()->route('admin.dashboard'),
            'admin_dekanat'     => redirect()->route('dekanat.dashboard'),
            'petinggi_dekanat'  => redirect()->route('petinggi.dashboard'),
            default             => redirect()->route('login'),
        };
    }
}
