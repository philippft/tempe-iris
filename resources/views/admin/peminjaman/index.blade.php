@extends('layouts.app')

@section('title', 'Peminjaman Inventaris') 

@section('content')

<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h3 class="text-4xl font-extrabold text-judul">Daftar Peminjaman Inventaris</h3>
        <p class="text-base text-dark-grey font-medium">Kelola dan pantau status peminjaman inventaris Anda.</p>
    </div>
    <a href="{{ route('admin.peminjaman.create') }}"
                class="text-white bg-primary-hover px-4 py-2.5 text-xs font-bold rounded-lg shadow-sm hover:bg-primary transition flex items-center gap-2">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 15H11V11H15V9H11V5H9V9H5V11H9V15ZM10 20C8.61667 20 7.31667 19.7375 6.1 19.2125C4.88333 18.6875 3.825 17.975 2.925 17.075C2.025 16.175 1.3125 15.1167 0.7875 13.9C0.2625 12.6833 0 11.3833 0 10C0 8.61667 0.2625 7.31667 0.7875 6.1C1.3125 4.88333 2.025 3.825 2.925 2.925C3.825 2.025 4.88333 1.3125 6.1 0.7875C7.31667 0.2625 8.61667 0 10 0C11.3833 0 12.6833 0.2625 13.9 0.7875C15.1167 1.3125 16.175 2.025 17.075 2.925C17.975 3.825 18.6875 4.88333 19.2125 6.1C19.7375 7.31667 20 8.61667 20 10C20 11.3833 19.7375 12.6833 19.2125 13.9C18.6875 15.1167 17.975 16.175 17.075 17.075C16.175 17.975 15.1167 18.6875 13.9 19.2125C12.6833 19.7375 11.3833 20 10 20ZM10 18C12.2333 18 14.125 17.225 15.675 15.675C17.225 14.125 18 12.2333 18 10C18 7.76667 17.225 5.875 15.675 4.325C14.125 2.775 12.2333 2 10 2C7.76667 2 5.875 2.775 4.325 4.325C2.775 5.875 2 7.76667 2 10C2 12.2333 2.775 14.125 4.325 15.675C5.875 17.225 7.76667 18 10 18Z" fill="white"/>
            </svg>
        Tambah Peminjaman
    </a>
</div>

<div class="space-y-4 my-10">
    <h2 class="text-base font-bold text-dark-grey tracking-[1.5px]">STATISTIK PEMINJAMAN</h2>
    <div class="flex flex-wrap w-full justify-start gap-6">
    <x-statecard
            title="Total Peminjaman Masuk"
            :value="$suratMasuk->count()"
            label="Peminjaman"
            border="border-l-primary-hover"
            iconBg="bg-primary/10"
        > 
            <x-icons.totalaktif/>
        </x-statecard>
        <x-statecard
            title="Total Peminjaman Keluar"
            :value="$suratKeluar->count()"
            label="Peminjaman"
            border="border-l-status-black"
            iconBg="bg-black/10"
        > 
            <x-icons.totalaktif/>
        </x-statecard>
        <x-statecard
            title="Total Selesai"
            :value="$suratAprove->count()"
            label="Peminjaman"
            border="border-l-status-green"
            iconBg="bg-status-green/10"
        > 
            <x-icons.totalaktif/>
        </x-statecard>
        <x-statecard
            title="Total Diproses"
            :value="$suratPending->count()"
            label="Peminjaman"
            border="border-l-status-yellow"
            iconBg="bg-status-yellow/10"
        > 
            <x-icons.totalpending/>
        </x-statecard>
        <x-statecard
            title="Total Ditolak"
            :value="$suratReject->count()"
            label="Peminjaman"
            border="border-l-status-red"
            iconBg="bg-status-red/10"
        > 
            <x-icons.totaltolak/>
        </x-statecard>
    </div>
</div>

<div class="bg bg-white rounded-2xl p-6 space-y-6">
    <div class="space-y-1">
            <h3 class="text-xl font-extrabold text-judul tracking-tight">
                Peminjaman Masuk
            </h3>
            <p class="text-sm font-medium text-dark-grey">Daftar peminjaman barang kepada {{ auth()->user()->username }}</p>
    </div>
    <x-search-bar />
    <!-- SIAPAPUN HELP INI GIMANA CARANYA MAKE SEARCH BAR -->
    <x-container>
        <x-table
            :headers="['NO', 'Nama kegiatan', 'id pinjam', 'tanggal pinjam', 'estimasi kembali', 'status', 'tujuan', 'aksi']"
            :cols="['60px', '1fr', '1fr', '1.2fr', '1.2fr', '1fr', '1fr', '0.8fr']"
            data=""
            headerBg="bg-primary-hover"
            headerClass="text-white font-bold text-sm uppercase"
            bg="bg-white overflow-hidden"
        >
        @foreach($suratMasuk as $surat)
            <x-table-row>
                <div>{{ sprintf('%02d', $loop->iteration) }}</div>
                <div class="font-bold justify-center">
                    {{ $surat->acara }}
                </div>
                <div class="font-bold  justify-center">
                    <span
                        class="text-wrap items-center rounded bg-primary-hover/20 px-2 py-0.5 font-bold text-primary-hover ">
                        {{ $surat->nomor }}
                    </span>
                </div>
                <div>
                    {{ \Carbon\Carbon::parse($surat->tanggal_peminjaman)->translatedFormat('d M Y') }}
                </div>
                <div>
                    {{ \Carbon\Carbon::parse($surat->tanggal_kembali)->translatedFormat('d M Y') }}
                </div>
                
                <div class="justify-center">
                    <x-status-card status="1"/>
                </div>
                <div>
                    {{ $surat->detailPeminjaman->first()->inventaris->user->organization_name }}
                </div>
                <div class="justify-center rounded-">
                    <x-action-button type="view" as="a" href="#"></x-action-button>
                    <x-action-button type="delete" as="a" href="#"></x-action-button>
                </div>
            </x-table-row>
        @endforeach
        </x-table>
    </x-container>
</div>


<div class="bg-white p-6 rounded-[32px] border border-gray-100 shadow-sm space-y-6">
        

        {{-- 4. RENDERING TABEL DARI DATA $suratMasuk --}}
        <x-container>
            <x-table
                :headers="['No', 'Nama Peminjam', 'NIM', 'Nama Kegiatan', 'Tanggal Kirim', 'Status', 'Aksi']"
                :cols="['60px', '1.2fr', '0.8fr', '1.5fr', '1fr', '1fr', '140px']"
                :data="$suratMasuk"
                headerBg="bg-primary-hover/10"
                headerClass="text-primary font-bold text-sm uppercase"
                bg="bg-white overflow-hidden"
            >
                @foreach($suratMasuk as $surat)
                    <x-table-row>
                        <div>{{ sprintf('%02d', $loop->iteration) }}</div>
                        
                        <div class="font-bold justify-start text-judul">
                            {{ $surat->nama_peminjam }}
                        </div>
                        
                        <div class="justify-start  font-medium">
                            {{ $surat->nim }}
                        </div>
                        
                        <div class="justify-start text-subtext">
                            {{ $surat->nama_kegiatan ?? $surat->perihal_peminjaman }}
                        </div>
                        
                        <div class="justify-center text-dark-grey font-medium">
                            {{ $surat->created_at ? $surat->created_at->format('d M Y') : '-' }}
                        </div>
                        
                        <div class="justify-center">
                            <x-status-card :status="$surat->status_peminjaman"/>
                        </div>
                        <div>
                            <x-take-action/>
                        </div>
                    </x-table-row>
                @endforeach
            </x-table>
        </x-container>

    </div>

        <!-- HEADER SECTION -->
<div class="p-10">
</div> 
        <!-- STATISTIK PEMINJAMAN (GRID CARD) --
        <!-- MAIN DATA BOX -->
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm mb-8">

            <!-- Judul Bagian Peminjaman Masuk & Tombol Export -->
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Peminjaman Masuk</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Daftar peminjaman barang kepada LM ini</p>
                </div>
                <button
                    class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 transition shadow-sm"
                    title="Unduh Log">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                </button> 
            </div>

            <!-- FILTER & CARI PANEL -->
            <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div class="flex-1 max-w-2xl">
                    <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Cari
                        Peminjaman</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" placeholder="Masukkan Nama Peminjaman..."
                            class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] py-2 pl-9 pr-4 text-xs text-gray-900 focus:border-[#0B5C66] focus:ring-[#0B5C66] transition">
                    </div>
                </div>

                <div class="w-full md:w-48">
                    <label
                        class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Status</label>
                    <select
                        class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] px-3 py-2 text-xs text-gray-900 focus:border-[#0B5C66] focus:ring-[#0B5C66] transition">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="pending">Pending</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
            </div>

            <!-- TABEL DATA UTAMA -->
            <div class="overflow-hidden rounded-xl border border-gray-100 bg-white">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-left text-xs">
                        <thead class="bg-[#0B5C66] font-bold uppercase tracking-wider text-white">
                            <tr>
                                <th scope="col" class="px-4 py-3.5 text-center w-12">No</th>
                                <th scope="col" class="px-6 py-3.5">Nama Kegiatan</th>
                                <th scope="col" class="px-4 py-3.5 text-center">ID Pinjam</th>
                                <th scope="col" class="px-6 py-3.5">Tanggal Pinjam</th>
                                <th scope="col" class="px-6 py-3.5">Estimasi Kembali</th>
                                <th scope="col" class="px-4 py-3.5 text-center">Status</th>
                                <th scope="col" class="px-6 py-3.5">Tujuan</th>
                                <th scope="col" class="px-4 py-3.5 text-center w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white font-medium text-slate-700">
                            @forelse($suratMasuk as $index => $row)
                            @php
                            // 💡 LOGIKA STRICK WARNA DAN TEXT BADGE STATUS
                            if ($row->tandatangan_pimpinan === 1 && $row->status_peminjaman == 1) {
                            $statusText = 'AKTIF';
                            $badgeBg = 'bg-[#22C55E]'; // Hijau
                            } elseif ($row->status_peminjaman === 0) {
                            $statusText = 'DITOLAK';
                            $badgeBg = 'bg-[#EF4444]'; // Merah
                            } else {
                            $statusText = 'PENDING';
                            $badgeBg = 'bg-[#FDB022]'; // Oranye (Default menunggu review)
                            }
                            @endphp

                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="whitespace-nowrap px-4 py-4 text-center font-normal text-slate-400">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </td>

                                <td class="px-6 py-4 font-bold text-slate-800">
                                    {{ $row->acara }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded bg-blue-50 px-2 py-0.5 text-[10px] font-bold text-blue-600 border border-blue-100">
                                        {{ str_pad($row->id, 2, '0', STR_PAD_LEFT) }}-DKN
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 font-normal text-slate-500">
                                    {{ \Carbon\Carbon::parse($row->tanggal_peminjaman)->translatedFormat('d M Y') }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 font-normal text-slate-500">
                                    {{ \Carbon\Carbon::parse($row->tanggal_kembali)->translatedFormat('d M Y') }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded-full {{ $badgeBg }} px-2.5 py-0.5 text-[9px] font-extrabold text-white uppercase tracking-wider">
                                        {{ $statusText }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 font-bold text-[#0A5C66]">
                                    {{ $row->detailPeminjaman->first()->inventaris->user->organization_name }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.peminjaman.detail-surat', $row->id) }}"
                                            class="rounded-md bg-slate-50 p-1.5 text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition border border-slate-100 shadow-sm"
                                            title="Lihat Data">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.644l.711-.356a1.012 1.012 0 011.355.45l.182.363a1.012 1.012 0 001.356.453l.71-.355a1.012 1.012 0 00.453-1.356l-.183-.365a1.012 1.012 0 01.45-1.355l.712-.356a1.012 1.012 0 011.356 0l.712.356a1.012 1.012 0 01.45 1.355l-.183.365a1.012 1.012 0 00.453 1.356l.71.355a1.012 1.012 0 001.356-.453l.182-.363a1.012 1.012 0 011.355-.45l.711.356a1.012 1.012 0 010 .644l-.711.356a1.012 1.012 0 01-1.355-.45l-.182-.363a1.012 1.012 0 00-1.356-.453l-.71.355a1.012 1.012 0 00-.453 1.356l.183.365a1.012 1.012 0 01-.45 1.355l-.712.356a1.012 1.012 0 01-1.356 0l-.712-.356a1.012 1.012 0 01-.45-1.355l.183-.365a1.012 1.012 0 00-.453-1.356l-.71-.355a1.012 1.012 0 00-1.356.453l-.182.363a1.012 1.012 0 01-1.355.45l-.711-.356z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.inventaris.destroy', $row->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan surat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="rounded-md bg-slate-50 p-1.5 text-[#EF4444] hover:bg-red-50 transition border border-slate-100 shadow-sm"
                                                title="Hapus Data">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-xs text-slate-400 font-normal">
                                    Belum ada log data surat peminjaman keluar yang tercatat.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION BLOCK -->
                <div class="bg-white px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                    <div class="text-[11px] text-slate-400">
                        Menampilkan <span class="font-bold text-slate-600">2</span> dari <span
                            class="font-bold text-slate-600">21</span> data
                    </div>
                    <div class="flex items-center gap-1">
                        <button class="px-2 py-1 border border-slate-200 rounded-lg text-slate-300 text-[11px]"
                            disabled>&lt;</button>
                        <button class="px-3 py-1 bg-[#0B5C66] text-white rounded-lg text-[11px] font-bold">1</button>
                        <button
                            class="px-3 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">2</button>
                        <button
                            class="px-3 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">3</button>
                        <button
                            class="px-2 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">&gt;</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm mb-8">

            <!-- Judul Bagian Peminjaman Masuk & Tombol Export -->
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Peminjaman Keluar</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Daftar peminjaman barang kepada LM ini</p>
                </div>
                <button
                    class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 transition shadow-sm"
                    title="Unduh Log">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                </button>
            </div>

            <!-- FILTER & CARI PANEL -->
            <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div class="flex-1 max-w-2xl">
                    <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Cari
                        Peminjaman</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" placeholder="Masukkan Nama Peminjaman..."
                            class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] py-2 pl-9 pr-4 text-xs text-gray-900 focus:border-[#0B5C66] focus:ring-[#0B5C66] transition">
                    </div>
                </div>

                <div class="w-full md:w-48">
                    <label
                        class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Status</label>
                    <select
                        class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] px-3 py-2 text-xs text-gray-900 focus:border-[#0B5C66] focus:ring-[#0B5C66] transition">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="pending">Pending</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
            </div>

            <!-- TABEL DATA UTAMA -->
            <div class="overflow-hidden rounded-xl border border-gray-100 bg-white">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-left text-xs">
                        <thead class="bg-[#0B5C66] font-bold uppercase tracking-wider text-white">
                            <tr>
                                <th scope="col" class="px-4 py-3.5 text-center w-12">No</th>
                                <th scope="col" class="px-6 py-3.5">Nama Kegiatan</th>
                                <th scope="col" class="px-4 py-3.5 text-center">ID Pinjam</th>
                                <th scope="col" class="px-6 py-3.5">Tanggal Pinjam</th>
                                <th scope="col" class="px-6 py-3.5">Estimasi Kembali</th>
                                <th scope="col" class="px-4 py-3.5 text-center">Status</th>
                                <th scope="col" class="px-6 py-3.5">Tujuan</th>
                                <th scope="col" class="px-4 py-3.5 text-center w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white font-medium text-slate-700">
                            @forelse($suratKeluar as $index => $row)
                            @php
                            // 💡 LOGIKA STRICK WARNA DAN TEXT BADGE STATUS
                            if ($row->tandatangan_pimpinan === 1 && $row->status_peminjaman == 1) {
                            $statusText = 'AKTIF';
                            $badgeBg = 'bg-[#22C55E]'; // Hijau
                            } elseif ($row->tandatangan_pimpinan === 0) {
                            $statusText = 'DITOLAK';
                            $badgeBg = 'bg-[#EF4444]'; // Merah
                            } else {
                            $statusText = 'PENDING';
                            $badgeBg = 'bg-[#FDB022]'; // Oranye (Default menunggu review)
                            }
                            @endphp

                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="whitespace-nowrap px-4 py-4 text-center font-normal text-slate-400">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </td>

                                <td class="px-6 py-4 font-bold text-slate-800">
                                    {{ $row->acara }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded bg-blue-50 px-2 py-0.5 text-[10px] font-bold text-blue-600 border border-blue-100">
                                        {{ str_pad($row->id, 2, '0', STR_PAD_LEFT) }}-DKN
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 font-normal text-slate-500">
                                    {{ \Carbon\Carbon::parse($row->tanggal_peminjaman)->translatedFormat('d M Y') }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 font-normal text-slate-500">
                                    {{ \Carbon\Carbon::parse($row->tanggal_kembali)->translatedFormat('d M Y') }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded-full {{ $badgeBg }} px-2.5 py-0.5 text-[9px] font-extrabold text-white uppercase tracking-wider">
                                        {{ $statusText }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 font-bold text-[#0A5C66]">
                                    {{ $row->detailPeminjaman->first()->inventaris->user->organization_name }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.inventaris.show', ['inventaris' => $row->id, 'status_tampilan' => strtolower($statusText)]) }}"
                                            class="rounded-md bg-slate-50 p-1.5 text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition border border-slate-100 shadow-sm"
                                            title="Lihat Data">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.644l.711-.356a1.012 1.012 0 011.355.45l.182.363a1.012 1.012 0 001.356.453l.71-.355a1.012 1.012 0 00.453-1.356l-.183-.365a1.012 1.012 0 01.45-1.355l.712-.356a1.012 1.012 0 011.356 0l.712.356a1.012 1.012 0 01.45 1.355l-.183.365a1.012 1.012 0 00.453 1.356l.71.355a1.012 1.012 0 001.356-.453l.182-.363a1.012 1.012 0 011.355-.45l.711.356a1.012 1.012 0 010 .644l-.711.356a1.012 1.012 0 01-1.355-.45l-.182-.363a1.012 1.012 0 00-1.356-.453l-.71.355a1.012 1.012 0 00-.453 1.356l.183.365a1.012 1.012 0 01-.45 1.355l-.712.356a1.012 1.012 0 01-1.356 0l-.712-.356a1.012 1.012 0 01-.45-1.355l.183-.365a1.012 1.012 0 00-.453-1.356l-.71-.355a1.012 1.012 0 00-1.356.453l-.182.363a1.012 1.012 0 01-1.355.45l-.711-.356z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.inventaris.destroy', $row->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan surat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="rounded-md bg-slate-50 p-1.5 text-[#EF4444] hover:bg-red-50 transition border border-slate-100 shadow-sm"
                                                title="Hapus Data">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-xs text-slate-400 font-normal">
                                    Belum ada log data surat peminjaman keluar yang tercatat.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION BLOCK -->
                <div class="bg-white px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                    <div class="text-[11px] text-slate-400">
                        Menampilkan <span class="font-bold text-slate-600">2</span> dari <span
                            class="font-bold text-slate-600">21</span> data
                    </div>
                    <div class="flex items-center gap-1">
                        <button class="px-2 py-1 border border-slate-200 rounded-lg text-slate-300 text-[11px]"
                            disabled>&lt;</button>
                        <button class="px-3 py-1 bg-[#0B5C66] text-white rounded-lg text-[11px] font-bold">1</button>
                        <button
                            class="px-3 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">2</button>
                        <button
                            class="px-3 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">3</button>
                        <button
                            class="px-2 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">&gt;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection