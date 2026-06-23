<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - TEMPE IRIS</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite('resources/css/app.css')
</head>
<body class="font-sans antialiased bg-white min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-xl border border-border-custom shadow-sm overflow-hidden">
        
        <div class="bg-bg-dark text-center py-6 px-4 border-b border-border-custom">
            <h2 class="text-xl font-bold text-primary tracking-wide uppercase">LOGIN TEMPE IRIS</h2>
            <p class="text-sm text-subtext mt-1">Silakan masuk ke akun Anda</p>
        </div>

        <form action="{{ route('login.authenticate') }}" method="POST" class="p-6 space-y-5">
            @csrf

            <x-input id="username" name="username" label="USERNAME" placeholder="Nomor Induk Mahasiswa" />

            <x-input id="password" name="password" label="PASSWORD" type="password" placeholder="Password" />

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 text-subtext cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-border-custom text-primary focus:ring-primary">
                    <span>Ingat Saya</span>
                </label>
                <a href="#" class="font-semibold text-primary hover:text-primary-hover transition">Lupa Password?</a>
            </div>

            <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white font-bold py-3 px-4 rounded-lg tracking-wide uppercase shadow-sm transition duration-200 text-sm mt-2">
                LOGIN AKUN
            </button>

            <div class="relative flex py-1 items-center">
                <div class="flex-grow border-t border-border-custom"></div>
            </div>

            <div class="text-center text-sm text-subtext">
                Belum punya akun? <a href="/register" class="font-bold text-primary hover:underline">Daftar Sekarang</a>
            </div>
        </form>

    </div>

</body>
</html>