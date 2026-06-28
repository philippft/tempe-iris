@extends('layouts.app')

@section('title', 'Detail Inventaris') 

@section('content')
<x-header-page title="Detail Inventaris"></x-header-page>

<div class="p-8 sm:px-6 space-y-9">
    <div class="flex gap-4 flex-row items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-primary-hover">Detail Barang</h2>
            <p class="text-sm text-dark-grey font-medium mt-1">Lihat detail informasi barang {{ $inventaris->nama }}</p>
        </div>
        <!-- <div>
            @if(($inventaris->stocks === 'aktif') || ($inventaris->stocks === 1))
            <x-badge label1="aktif"/>
            @else
            <x-badge label1="tidak aktif" variant="red"/>
            @endif
        </div>     -->
    </div>    
    <div class="flex justify-center">
        <div
            class="w-96 overflow-hidden rounded-2xl bg-bg-dark border border-border-custom flex items-center justify-center shadow-inner">
            @if($inventaris->image && file_exists(public_path($inventaris->image)))
            <img src="{{ asset($inventaris->image) }}" alt="{{ $inventaris->nama }}" class="w-full h-full object-cover">
            @else
            <div class="h-96 flex items-center justify-center">
                <svg class="h-16 w-16 justify-center items-center text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>

            </div>
            @endif
        </div>
    </div>

    <div class="bg bg-white rounded-2xl  border border-border-custom/50 p-6 space-y-6">
        <h1 class="text-2xl font-semibold text-primary-hover pb-3 border-b border-border-custom">
            Informasi Barang
        </h1>
        <div class="space-y-6">
            <div>
                <h3 class="text-xs font-semibold text-dark-grey uppercase mb-0.5">
                    Nama barang
                </h3>
                <h1 class="text-lg font-semibold text-judul capitalize">
                   {{ $inventaris->nama }}
                </h1>
            </div>
            <div>
                <h3 class="text-xs font-semibold text-dark-grey uppercase mb-0.5">
                    Kategori
                </h3>
                <h1 class="text-lg font-semibold text-judul capitalize">
                   {{ $inventaris->category->name ?? 'Umum' }}
                </h1>
            </div>
            <div>
                <h3 class="text-xs font-semibold text-dark-grey uppercase mb-0.5">
                    Stok Barang
                </h3>
                <h1 class="text-lg font-semibold text-judul capitalize">
                   {{ $inventaris->stocks->count() }} Pcs
                </h1>
            </div>
            <div>
                <h3 class="text-xs font-semibold text-dark-grey uppercase mb-0.5">
                    Deskripsi
                </h3>
                <h1 class="text-lg font-semibold text-judul">
                   {{ $inventaris->deskripsi ?? 'Tidak ada deskripsi atau catatan tambahan untuk barang ini.' }}
                </h1>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.inventaris.edit', $inventaris->id) }}" class="block w-full text-center rounded-xl bg-status-yellow py-4 text-2xl font-bold text-white shadow-lg hover:bg-[#EAAA08] transition">Perbarui Data</a>
    
    <div>
        <h2 class="text-3xl font-bold text-primary-hover">Riwayat Peminjaman</h2>
        <p class="text-sm text-dark-grey font-medium mt-1">Lihat riwayat peminjaman dari inventaris {{ $inventaris->nama }}</p>
    </div>

    <x-container>
        <x-table
            :headers="['NO', 'Nama Peminjam', 'Tanggal Pinjam', 'Tanggal Kembali', 'status']"
            :cols="['60px', '1fr', '1fr', '1fr', '140px']"
            :data="$inventaris"
            headerBg="bg-primary-hover"
            headerClass="text-white font-bold text-sm uppercase"
            bg="bg-white overflow-hidden"
        >
        

                <x-table-row>
                    <div class="justify-center font-medium text-base text-dark-grey">
                        01
                    </div>
                    <div class="justify-center font-bold text-base text-judul capitalize">
                          Anak Agung mas mayuri  
                    </div>
                    <div class="justify-center font-medium text-dark-grey text-base">
                        12 Jun 2026    
                    </div>
                    <div class="justify-center font-medium text-dark-grey text-base">
                        12 Jun 2026    
                    </div>
                    <div class="justify-center">
                        <div class="bg-status-green inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white uppercase rounded-full tracking-wider">
                            Selesai
                        </div>
                    </div>
                    
                </x-table-row>
            
            <x-table-empty title="Tidak ada Riwayat" message="Saat ini tidak ada riwayat inventaris yang sedang dipinjam atau telah dipinjam ."/>
        
        </x-table>
    </x-container>



<!-- philip -->
    <!-- ========================================== -->
    <!-- 4. TABEL RIWAYAT PEMINJAMAN -->
    <!-- ========================================== -->
    <div class="max-w-4xl">
        <div class="mb-4">
            <h2 class="text-xl font-bold text-[#0B5C66]">Riwayat Peminjaman</h2>
            <p class="text-xs text-slate-400 mt-0.5">Lihat riwayat peminjaman dari inventaris ini</p>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 text-left text-sm">
                    <thead class="bg-[#0B5C66] text-xs font-bold uppercase tracking-wider text-white">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-center">No</th>
                            <th scope="col" class="px-6 py-4">Nama Peminjam</th>
                            <th scope="col" class="px-6 py-4">Tanggal Pinjam</th>
                            <th scope="col" class="px-6 py-4">Tanggal Kembali</th>
                            <th scope="col" class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        {{-- Ganti dengan @forelse($inventaris  ->loans as $index => $loan) jika relasi sudah ada --}}
                        @forelse([] as $index => $loan)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="whitespace-nowrap px-6 py-4 text-center font-medium text-slate-500">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-900">Nama Peminjam</td>
                            <td class="px-6 py-4 text-slate-600">12 Mei 2026</td>
                            <td class="px-6 py-4 text-slate-600">13 Mei 2026</td>
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center rounded-full bg-[#22C55E] px-3 py-0.5 text-[10px] font-bold text-white uppercase tracking-wide">
                                    SELESAI
                                </span>
                            </td>
                        </tr>
                        @empty
                        {{-- Dummy row agar tampilannya persis seperti screenshot saat data asli kosong --}}
                        <tr class="hover:bg-slate-50 transition">
                            <td class="whitespace-nowrap px-6 py-4 text-center font-medium text-slate-500">01</td>
                            <td class="px-6 py-4 font-bold text-slate-700">Anak Agung Mas Mayuri</td>
                            <td class="px-6 py-4 text-slate-500">12 Mei 2026</td>
                            <td class="px-6 py-4 text-slate-500">13 Mei 2026</td>
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center rounded-full bg-[#00C853] px-3 py-0.5 text-[10px] font-bold text-white uppercase tracking-wide">SELESAI</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="whitespace-nowrap px-6 py-4 text-center font-medium text-slate-500">02</td>
                            <td class="px-6 py-4 font-bold text-slate-700">Anak Agung Mas Mayuri</td>
                            <td class="px-6 py-4 text-slate-500">23 Mei 2026</td>
                            <td class="px-6 py-4 text-slate-500">-</td>
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <span
                                    class="inline-flex items-center rounded-full bg-[#FFB300] px-3 py-0.5 text-[10px] font-bold text-white uppercase tracking-wide">DIPINJAM</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- TABEL PAGINATION FOOTER -->
            <div class="bg-white px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                <div class="text-xs text-slate-400">
                    Menampilkan <span class="font-medium text-slate-700">2</span> dari <span
                        class="font-medium text-slate-700">21</span> data
                </div>
                <div class="flex items-center gap-1">
                    <button class="px-2 py-1 border border-gray-200 rounded-lg text-slate-300 text-xs"
                        disabled>&lt;</button>
                    <button class="px-3 py-1 bg-[#0B5C66] text-white rounded-lg text-xs font-semibold">1</button>
                    <button
                        class="px-3 py-1 border border-gray-200 rounded-lg text-slate-600 text-xs hover:bg-slate-50">2</button>
                    <button
                        class="px-3 py-1 border border-gray-200 rounded-lg text-slate-600 text-xs hover:bg-slate-50">3</button>
                    <button
                        class="px-2 py-1 border border-gray-200 rounded-lg text-slate-600 text-xs hover:bg-slate-50">&gt;</button>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection