@php
    $user = Auth::user();
@endphp

<div class="flex flex-col rounded-xl border border-slate-200 overflow-hidden bg-white
            hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">

    {{-- Image placeholder --}}
    <div class="bg-slate-200 aspect-[4/3] flex-shrink-0 m-4 rounded-xl"></div>

    {{-- Card body --}}
    <div class="flex flex-col flex-1 p-3 gap-1.5">

        {{-- Name & category --}}
        <p class="font-bold text-[14px] text-[#1E293B] leading-tight">Nama Barang</p>
        <p class="text-[12px] text-[#64748B]">Kategori Barang</p>

        {{-- Tersedia badge --}}
        <span class="inline-flex items-center gap-1.5 w-fit mt-0.5">
            <span class="w-2 h-2 rounded-full bg-teal-500 flex-shrink-0"></span>
            <span class="text-[11px] font-semibold text-teal-700">Tersedia: 5</span>
        </span>

        {{-- Jumlah Pinjam --}}
        <div class="mt-1 vertical-align flex justify-between items-center gap-2">
            <p class="text-[11px] font-bold tracking-widest text-[#64748B] uppercase">
                Jumlah Pinjam
            </p>
            <div class="flex items-center gap-1">
                <button class="w-7 h-7 rounded-lg bg-[#1F6E6C] text-white flex items-center
                           justify-center hover:bg-[#175b59] active:scale-90 transition-all
                           text-lg font-light leading-none flex-shrink-0">
                    <p class="tombol">−</p>
                </button>
                <span class="text-[14px] font-semibold text-[#1E293B] w-5 text-center">1</span>
                <button class="w-7 h-7 rounded-lg bg-[#1F6E6C] text-white flex items-center
                       justify-center hover:bg-[#175b59] active:scale-90 transition-all
                       text-lg font-light leading-none flex-shrink-0">
                    <p class="tombol">+</p>
                </button>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex gap-2 mt-2">
            {{-- Eye / detail --}}
            <button class="w-9 h-9 flex-shrink-0 rounded-lg border-2 border-[#1F6E6C] text-[#1F6E6C]
                                               flex items-center justify-center hover:bg-[#CDEAEA] transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                                                 -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>

            {{-- Pilih Barang --}}
            <button class="flex-1 h-9 rounded-lg bg-[#1F6E6C] text-white text-[13px] font-semibold
                                               hover:bg-[#175b59] active:scale-95 transition-all">
                Pilih Barang
            </button>
        </div>
    </div>
</div>