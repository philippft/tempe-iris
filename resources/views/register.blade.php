<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - TEMPE IRIS</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="font-sans antialiased bg-white min-h-screen flex items-center justify-center p-6 md:p-12">
    <div class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="hidden lg:flex justify-center items-center">
            <img src="{{ asset('images/register-illustration.svg') }}" alt="Register Illustration" class="w-full max-w-lg object-contain">
        </div>
        <div class="w-full max-w-xl bg-white rounded-xl border border-border-custom shadow-sm overflow-hidden justify-self-center lg:justify-self-end">
            <div class="bg-bg-dark text-center py-6 px-4 border-b border-border-custom">
                <h2 class="text-xl font-bold text-primary tracking-wide uppercase">DAFTAR AKUN TEMPE IRIS</h2>
                <p class="text-sm text-subtext mt-1">Lengkapi formulir di bawah ini untuk melakukan pendaftaran akun pada sistem!</p>
            </div>
            <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <x-input id="name" name="name" label="NAMA LENGKAP" placeholder="Nama Lengkap" />
                <x-input id="nim" name="nim" label="NIM" placeholder="Nomor Induk Mahasiswa" />
                <x-input id="prodi" name="prodi" label="PROGRAM STUDI" placeholder="Pilih Program Studi" />
                <x-input id="email" name="email" type="email" label="EMAIL" placeholder="Email Aktif (mahasiswa@gmail.com)" />
                <div>
                    <label class="block text-xs font-bold text-judul uppercase tracking-wider mb-2">UPLOAD KTM (KARTU TANDA MAHASISWA)</label>
                    <div class="w-full flex items-center bg-bg-dark/50 border border-border-custom rounded-lg overflow-hidden">
                        <label for="ktm" class="bg-primary hover:bg-primary-hover text-white text-xs font-bold px-4 py-3 cursor-pointer transition whitespace-nowrap">
                            Pilih File
                        </label>
                        <input type="file" id="ktm" name="ktm" class="hidden" onchange="document.getElementById('file-name').textContent = this.files[0].name">
                        <span id="file-name" class="px-4 text-sm text-subtext/60 truncate">Upload File KTM (.jpg, .png, .jpeg)</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-input id="password" name="password" type="password" label="PASSWORD" placeholder="Password" />
                    <x-input id="password_confirmation" name="password_confirmation" type="password" label="KOFIRMASI PASSWORD" placeholder="Konfirmasi Password" />
                </div>
                <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white font-bold py-3 px-4 rounded-lg tracking-wide uppercase shadow-sm transition duration-200 text-sm mt-4">
                    DAFTAR AKUN
                </button>

                <div class="relative flex py-1 items-center">
                    <div class="flex-grow border-t border-border-custom"></div>
                </div>

                <div class="text-center text-sm text-subtext">
                    Sudah punya akun? <a href="/login" class="font-bold text-primary hover:underline">Masuk Sekarang</a>
                </div>
            </form>

        </div>
    </div>

</body>
</html>