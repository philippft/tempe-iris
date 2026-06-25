<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginView () 
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user()->role);
        }

        return view('login');
    }

    public function authenticate(Request $request) 
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        // dd($credentials);

        if(Auth::attempt($credentials)) {
            if (is_null(Auth::user()->verify_at)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'username' => 'Akun Anda belum diverifikasi oleh Admin.',
                ])->onlyInput('username');
            }


            $request->session()->regenerate();
            if(Auth::user()->role) {
                return $this->redirectBasedOnRole(Auth::user()->role);
            }
        };

        return back()->withErrors([
            'username' => 'Username atau Password salah!',
        ])->onlyInput('username');
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
