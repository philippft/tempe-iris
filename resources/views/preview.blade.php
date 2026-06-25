@php

    // SETUP 
        // Pagination Card 
            // Dropdown Menu 


    // SETUP 


@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Preview Sidebar</title>
    @vite('resources/css/app.css')
</head>

<body class="flex bg-gray-100 h-screen">
<<<<<<< Updated upstream
=======
    <x-sidebar />
>>>>>>> Stashed changes
    <main class="flex-1 p-8">

        {{--Card Statistik --}}
        <div>
            @include('partials.card-statistik')
        </div>

        <br>
        <hr>
        <br>
        
        {{--Card Product --}}
        <div>
            <div class="grid grid-cols-4 gap-4 mb-6">
                @for ($i = 0; $i < 4; $i++)
                    @include('partials.card-product')
                @endfor
            </div>
        </div>

        <br>
        <hr>
        <br>

        {{-- Pagination card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-7 py-6">
                {{-- Dropdown Menu --}}
                <div class="mb-6">
                    <label class="block text-[11px] font-bold tracking-widest text-[#475569] uppercase mb-2">
                        Pilih Tujuan Peminjaman
                    </label>
                    <div class="relative">
                        <select class="w-full appearance-none border border-slate-300 rounded-xl px-4 py-3 text-[14px]
                                       text-[#1E293B] bg-white focus:outline-none focus:ring-2 focus:ring-[#1F6E6C]/30
                                       focus:border-[#1F6E6C] transition-colors cursor-pointer pr-10">
                            <option value="" disabled selected>Pilih Tujuan</option>
                            <option>Kegiatan Akademik</option>
                            <option>Kegiatan Organisasi</option>
                            <option>Kegiatan Penelitian</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#64748B]" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Search + Kategori --}}
                <div class="flex gap-3 mb-7">
                    {{-- Search input --}}
                    <div class="flex-1">
                        <label class="block text-[11px] font-bold tracking-widest text-[#475569] uppercase mb-2">
                            Cari Barang
                        </label>
                        <input
                            type="text"
                            placeholder="Masukkan Nama Barang..."
                            class="w-full border border-slate-300 rounded-xl px-4 py-3 text-[14px] text-[#1E293B]
                                   placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1F6E6C]/30
                                   focus:border-[#1F6E6C] transition-colors"
                        >
                    </div>

                    {{-- Kategori dropdown --}}
                    <div class="w-52">
                        <label class="block text-[11px] font-bold tracking-widest text-[#475569] uppercase mb-2">
                            Kategori
                        </label>
                        <div class="relative">
                            <select class="w-full appearance-none border border-slate-300 rounded-xl px-4 py-3 text-[14px]
                                           text-[#1E293B] bg-white focus:outline-none focus:ring-2 focus:ring-[#1F6E6C]/30
                                           focus:border-[#1F6E6C] transition-colors cursor-pointer pr-8">
                                <option value="" selected>Pilih Kategori</option>
                                <option>Elektronik</option>
                                <option>Furniture</option>
                                <option>Alat Tulis</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#64748B]" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Search icon button --}}
                    <div class="flex flex-col justify-end">
                        <button class="flex items-center justify-center w-12 h-[46px] rounded-xl bg-[#1F6E6C]
                                       text-white hover:bg-[#175b59] active:scale-95 transition-all shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Other content --}}
                <div class="grid grid-cols-4 gap-4 mb-6">
                    @for ($i = 0; $i < 4; $i++)
                        @include('partials.card-product')
                    @endfor
                </div>

                {{-- Pagination --}}
                <div class="flex items-center justify-between pt-4 border-t border-slate-200">

                    {{-- Info --}}
                    <p class="text-[13px] text-[#64748B]">Menampilkan 2 dari 21 data</p>

                    {{-- Pages --}}
                    <div class="flex items-center gap-1">
                        {{-- Prev --}}
                        <button class="w-9 h-9 rounded-lg flex items-center justify-center text-[#64748B]
                                       hover:bg-slate-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>

                        {{-- Pages 1-3 --}}
                        @foreach ([1, 2, 3] as $page)
                        <button class="w-9 h-9 rounded-lg text-[14px] font-semibold transition-colors
                                       {{ $page === 1
                                           ? 'bg-[#1F6E6C] text-white shadow-sm'
                                           : 'text-[#64748B] hover:bg-slate-100' }}">
                            {{ $page }}
                        </button>
                        @endforeach

                        {{-- Next --}}
                        <button class="w-9 h-9 rounded-lg flex items-center justify-center text-[#64748B]
                                       hover:bg-slate-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>{{-- /white card --}}

        <br>
        <hr>
        <br>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-7 py-6">
        </div>

    </main>
<<<<<<< Updated upstream
=======
    @include('components.popup-del')
>>>>>>> Stashed changes
</body>

<script>
    function openDeleteModal(actionUrl) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');

        form.action = actionUrl;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Klik area gelap untuk menutup modal
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>

</html>