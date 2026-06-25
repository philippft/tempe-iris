<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Mahasiswa - SIC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="flex h-screen bg-white text-gray-800 font-sans overflow-hidden">

    <aside class="w-[260px] bg-[#f4f5fa] border-r border-gray-200 flex flex-col justify-between h-full shrink-0">
        <div>
            {{-- Profil Sidebar Dinamis --}}
            <div class="flex items-center justify-between p-6 pb-6">
                <div>
                    <h2 class="font-bold text-[13px] text-gray-900 leading-tight uppercase">{{ $user->name }}</h2>
                    <p class="text-[11px] text-gray-500 mt-0.5">{{ $user->nim }}</p>
                </div>
                <button class="p-1.5 bg-[#e2e8f0] rounded-md hover:bg-gray-300 transition">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </button>
            </div>

            {{-- Navigasi Sidebar (Hanya aktif jika sudah diverifikasi) --}}
            <nav class="flex flex-col gap-0.5 px-4 mt-2">
                @if(!is_null($user->verify_at))
                    <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-200 rounded-md font-medium text-[14px] transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('mahasiswa.peminjaman.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-200 rounded-md font-medium text-[14px] transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                        Peminjaman
                    </a>
                @else
                    {{-- Navigasi terkunci untuk status Pending --}}
                    <div class="px-4 py-3 text-gray-400 font-medium text-[13px] italic">
                        Menu terkunci. Tunggu verifikasi admin.
                    </div>
                @endif
            </nav>
        </div>

        {{-- Form Logout Dinamis --}}
        <div class="p-6">
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-start gap-2 px-4 py-2.5 bg-[#f5eef1] text-[#c92a54] font-semibold rounded-md hover:bg-[#eedbe2] transition text-[14px]">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto h-full p-8 lg:p-10">
        <div class="max-w-[850px]">
            
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-[22px] font-bold text-[#1e293b]">Profile Mahasiswa</h1>
                    <p class="text-[13px] text-gray-500 mt-1">Akses detail akunmu melalui halaman ini!</p>
                </div>
                
                {{-- Status Badge Dinamis --}}
                @if(is_null($user->verify_at))
                    <div class="flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 border border-amber-200 text-amber-700 rounded-full">
                        <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                        <span class="text-[11px] font-bold tracking-wide">Pending</span>
                    </div>
                @else
                    <div class="flex items-center gap-1.5 px-3 py-1.5 bg-[#e8f5e9] border border-[#a5d6a7] text-[#1b5e20] rounded-full">
                        <div class="w-2 h-2 bg-[#2e7d32] rounded-full"></div>
                        <span class="text-[11px] font-bold tracking-wide">Aktif</span>
                    </div>
                @endif
            </div>

            {{-- Pesan Notifikasi Dinamis --}}
            @if(is_null($user->verify_at))
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 flex gap-3 mb-6">
                    <div class="mt-0.5 shrink-0">
                        <svg class="w-[22px] h-[22px] text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[14px] font-bold text-amber-800">Menunggu Verifikasi</h3>
                        <p class="text-[13px] text-amber-700 mt-0.5 leading-relaxed">
                            Pendaftaran Anda sedang ditinjau oleh Admin. Harap bersabar, Anda akan mendapatkan akses penuh setelah KTM Anda selesai divalidasi.
                        </p>
                    </div>
                </div>
            @else
                <div class="bg-[#e8f5e9] border border-[#a5d6a7] rounded-lg p-4 flex gap-3 mb-6">
                    <div class="mt-0.5 shrink-0">
                        <svg class="w-[22px] h-[22px] text-[#2e7d32]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <polyline points="9 12 12 15 16 9"></polyline>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[14px] font-bold text-[#1b5e20]">Selamat Datang!</h3>
                        <p class="text-[13px] text-[#2e7d32] mt-0.5 leading-relaxed">
                            Akun Anda telah diverifikasi oleh tim administrasi. Sekarang Anda memiliki akses penuh untuk meminjam barang dan peralatan dari inventaris TEMPE IRIS.
                        </p>
                    </div>
                </div>
            @endif

            {{-- Foto KTM Dinamis --}}
            <div class="border border-gray-200 rounded-lg mb-6 bg-white shadow-sm">
                <div class="px-5 py-4 border-b border-gray-200">
                    <h2 class="font-semibold text-[15px] text-[#1e293b]">Foto KTM (Kartu Tanda Mahasiswa)</h2>
                </div>
                <div class="p-6">
                    <div class="bg-[#f0f4ff] border-2 border-dashed border-[#c7d2fe] rounded-xl p-6 flex justify-center items-center">
                        <img src="{{ asset($user->file_ktm) }}" alt="Foto KTM {{ $user->name }}" class="w-full max-w-[500px] rounded-md shadow-md object-cover max-h-[300px]">
                    </div>
                </div>
            </div>

            {{-- Data Input Dinamis (Sudah sesuai dari Anda) --}}
            <div class="border border-gray-200 rounded-lg bg-white shadow-sm">
                <div class="px-5 py-4 border-b border-gray-200">
                    <h2 class="font-semibold text-[15px] text-[#1e293b]">Informasi Pribadi</h2>
                </div>
                <div class="p-6 flex flex-col gap-5">
                    
                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 mb-1.5 uppercase tracking-wide">Nama Lengkap</label>
                        <input type="text" value="{{ $user->name }}" readonly class="w-full bg-[#f4f5fa] border border-gray-200 text-[#64748b] text-[13px] rounded-md px-4 py-2.5 outline-none cursor-default">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 mb-1.5 uppercase tracking-wide">NIM (Nomor Induk Mahasiswa)</label>
                        <input type="text" value="{{ $user->nim }}" readonly class="w-full bg-[#f4f5fa] border border-gray-200 text-[#64748b] text-[13px] rounded-md px-4 py-2.5 outline-none cursor-default">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 mb-1.5 uppercase tracking-wide">Program Studi</label>
                        <input type="text" value="{{ $user->prodi }}" readonly class="w-full bg-[#f4f5fa] border border-gray-200 text-[#64748b] text-[13px] rounded-md px-4 py-2.5 outline-none cursor-default">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-600 mb-1.5 uppercase tracking-wide">Email</label>
                        <input type="text" value="{{ $user->email }}" readonly class="w-full bg-[#f4f5fa] border border-gray-200 text-[#64748b] text-[13px] rounded-md px-4 py-2.5 outline-none cursor-default">
                    </div>

                </div>
            </div>

        </div>
    </main>

</body>
</html>