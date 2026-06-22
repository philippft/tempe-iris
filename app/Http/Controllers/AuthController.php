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
            'nim_nip' => ['required'],
            'password' => ['required']
        ]);

        // dd($credentials);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if(Auth::user()->role) {
                return $this->redirectBasedOnRole(Auth::user()->role);
            }
        };

        return back()->withErrors([
            'nim_nip' => 'NIM atau Password salah!',
        ])->onlyInput('nim_nip');
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
            'admin_LM'          => redirect()->route('admin_lm.dashboard'),
            'admin_dekanat'     => redirect()->route('admin_dekanat.dashboard'),
            'petinggi_dekanat'  => redirect()->route('petinggi_dekanat.dashboard'),
            default             => redirect()->route('login'),
        };
    }
}
