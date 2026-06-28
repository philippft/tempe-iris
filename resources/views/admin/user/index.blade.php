@extends('layouts.app')

@section('title', 'Manajemen User') 

@section('content')
<div class="p-8 space-y-10">
    <div>
        <h3 class="text-4xl font-extrabold text-judul">Manajemen Pendaftaran Akun</h3>
        <p class="text-base text-dark-grey font-medium">Kelola pengajuan akun mahasiswa</p>
    </div>
    <div class="space-y-4">
        <h2 class="text-base font-bold text-dark-grey uppercase tracking-[1.5px]">Statistik akun mahasiswa</h2>
        <div class="flex flex-wrap w-full justify-start gap-6">
        <x-statecard
                title="Total Akun Mahasiswa"
                value="0"
                label="Akun"
                border="border-l-primary-hover"
                iconBg="bg-primary/10"
            > 
                <x-icons.totalaktif/>
            </x-statecard>
            <x-statecard
                title="Akun Pending"
                value="0"
                label="Akun"
                border="border-l-status-yellow"
                iconBg="bg-status-yellow/10"
            > 
                <x-icons.totalpending/>
            </x-statecard>
        </div>
    </div>

    <!-- ini placeholdernya search sama kategori -->
    <div class="rounded-2xl border border-border-custom bg-white p-5 shadow-md">
        <form action="{{ request()->url() }}" method="GET"
            class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div class="flex-1 max-w-3xl">
                <label class="block text-xs font-bold text-dark-grey uppercase tracking-wider mb-2">Cari Mahasiswa</label>
                <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.6 18L10.3 11.7C9.8 12.1 9.225 12.4167 8.575 12.65C7.925 12.8833 7.23333 13 6.5 13C4.68333 13 3.14583 12.3708 1.8875 11.1125C0.629167 9.85417 0 8.31667 0 6.5C0 4.68333 0.629167 3.14583 1.8875 1.8875C3.14583 0.629167 4.68333 0 6.5 0C8.31667 0 9.85417 0.629167 11.1125 1.8875C12.3708 3.14583 13 4.68333 13 6.5C13 7.23333 12.8833 7.925 12.65 8.575C12.4167 9.225 12.1 9.8 11.7 10.3L18 16.6L16.6 18ZM6.5 11C7.75 11 8.8125 10.5625 9.6875 9.6875C10.5625 8.8125 11 7.75 11 6.5C11 5.25 10.5625 4.1875 9.6875 3.3125C8.8125 2.4375 7.75 2 6.5 2C5.25 2 4.1875 2.4375 3.3125 3.3125C2.4375 4.1875 2 5.25 2 6.5C2 7.75 2.4375 8.8125 3.3125 9.6875C4.1875 10.5625 5.25 11 6.5 11Z" fill="#70787C"/>
                    </svg>
                </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="block w-full rounded-xl border border-border-custom bg-bg-dark py-2.5 pl-10 pr-4 text-sm text-dark-grey focus:border-primary-hover focus:ring-primary-hover transition"
                        placeholder="Masukkan NIM atau Nama Mahasiswa...">
                </div>
            </div>

            <div class="w-full md:w-64">
                <label class="block text-xs font-bold text-dark-grey uppercase tracking-wider mb-2">Status</label>
                <select name="category" onchange="this.form.submit()"
                    class="block w-full rounded-xl border border-border-custom bg-bg-dark px-4 py-2.5 text-sm text-dark-grey focus:border-primary-hover focus:ring-primary-hover transition">
                    <option value="">Semua Status</option>
<!-- tambah opsinyaaaaaaa -->
                </select>
            </div>
        </form>
    </div>
    
    <x-container>
        <x-table
    :headers="['No', 'Nama Mahasiswa', 'NIM', 'Email', 'Tanggal Daftar', 'Status', 'Aksi']"
    :cols="['60px', '1.2fr', '1fr', '1.5fr', '1.2fr', '1fr', '120px']"
    :data="$user"
    headerBg="bg-primary-hover"
    headerClass="text-white font-bold text-sm uppercase"
    bg="bg-white overflow-hidden"
>


@forelse($user as $data)
    <x-table-row>
        {{-- KOLOM 1: NO --}}
        <div class="justify-center font-medium">
            1
        </div>

        {{-- KOLOM 2: NAMA MAHASISWA --}}
        <div class="justify-start font-bold text-judul wrap-break-words pr-2 text-base leading-tight">
            {{ $data->username }}
        </div>

        {{-- KOLOM 3: NIM --}}
        <div class="justify-start">
            <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded text-[10px] font-bold border border-blue-100">
                {{ $data->NIM_NIP ?? '0000000000' }}
            </span>
        </div>

        {{-- KOLOM 4: EMAIL --}}
        <div class="justify-start text-dark-grey font-normal text-sm break-all">
            mayuri.24077@student.unud.ac.id
        </div>

        {{-- KOLOM 5: TANGGAL DAFTAR --}}
        <div class="justify-start text-dark-grey font-semibold text-sm">
            {{ $data->created_at ? $data->created_at->format('d F Y') : '-' }}
        </div>

        {{-- KOLOM 6: STATUS --}}
        <div class="justify-center">
            @if($data->verify_at)
                <span class="inline-flex items-center justify-center rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200 px-3 py-1 text-[9px] font-extrabold uppercase tracking-wide">
                    AKTIF
                </span>
            @elseif($data->note)
                <span class="inline-flex items-center justify-center rounded-full bg-rose-50 text-rose-600 border border-rose-200 px-3 py-1 text-[9px] font-extrabold uppercase tracking-wide">
                    DITOLAK
                </span>
            @else
                <span class="inline-flex items-center justify-center rounded-full bg-amber-50 text-amber-600 border border-amber-200 px-3 py-1 text-[9px] font-extrabold uppercase tracking-wide">
                    PENDING
                </span>
            @endif
        </div>

        {{-- KOLOM 7: AKSI --}}
        <div class="justify-center">
            <a href="{{ route('admin.user.detail', $data->id) }}"
               class="inline-block px-4 py-1.5 rounded-xl border border-slate-300 text-slate-700 font-bold hover:bg-slate-50 transition text-xs shadow-sm">
                Detail
            </a>
        </div>
    </x-table-row>
@empty
    <x-table-empty title="Tidak ada Data Mahasiswa" message="Saat ini belum ada mahasiswa yang terdaftar atau tidak ada data yang cocok dengan pencarian Anda."/>
@endforelse
</x-table>

{{-- Pastikan untuk menambahkan komponen pagination di bawah penutup x-table jika diperlukan --}}

    </x-container>
    <div class="bg-[#F8FAFC] p-6 sm:p-8 font-sans text-gray-800">
    
        <div class="max-w-7xl mx-auto space-y-8">
    
            <div>
                <h1 class="text-2xl font-extrabold text-[#0F172A]">Manajemen Pendaftaran Akun</h1>
                <p class="text-xs text-[#64748B] mt-0.5">Kelola pengajuan akun akses sistem inventory kampus.</p>
            </div>
    
            <div>
                <h2 class="text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-3">Statistik Akun Mahasiswa</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    
                    <div
                        class="bg-white rounded-2xl border-l-[6px] border-[#0A5C66] border-y border-r border-slate-100 p-5 shadow-sm flex justify-between items-start">
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-slate-500">Total Akun Mahasiswa</p>
                            <p class="text-3xl font-extrabold text-slate-800">21 <span
                                    class="text-xs font-medium text-slate-400">Akun</span></p>
                        </div>
                        <div class="p-2 rounded-xl bg-slate-50 text-[#0A5C66]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121 12v-1L19 11" />
                            </svg>
                        </div>
                    </div>
    
                    <div
                        class="bg-white rounded-2xl border-l-[6px] border-amber-500 border-y border-r border-slate-100 p-5 shadow-sm flex justify-between items-start">
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-slate-500">Akun Pending</p>
                            <p class="text-3xl font-extrabold text-slate-800">21 <span
                                    class="text-xs font-medium text-slate-400">Akun</span></p>
                        </div>
                        <div class="p-2 rounded-xl bg-amber-50 text-amber-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
    
                </div>
            </div>
    
            <div
                class="bg-white rounded-2xl border border-slate-100 p-4 shadow-sm flex flex-col sm:flex-row gap-4 items-end sm:items-center justify-between">
                <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto flex-1">
                    <div class="flex-1 max-w-md">
                        <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Cari
                            Surat</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" placeholder="Masukkan Nomor atau Perihal Peminjaman..."
                                class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] pl-10 pr-4 py-2 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                        </div>
                    </div>
    
                    <div class="w-full sm:w-48">
                        <label
                            class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Status</label>
                        <div class="relative">
                            <select
                                class="block w-full appearance-none rounded-xl border border-slate-200 bg-[#F8FAFC] px-4 py-2 text-xs text-gray-700 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                                <option value="">Semua Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="pending">Pending</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
    
                <button type="button"
                    class="p-2 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition shadow-sm flex justify-center items-center h-[34px] w-full sm:w-auto px-4 sm:px-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </button>
            </div>
    
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#0A5C66] text-white text-[11px] font-bold uppercase tracking-wider">
                                <th class="px-6 py-4 text-center w-16">No</th>
                                <th class="px-6 py-4">Nama Mahasiswa</th>
                                <th class="px-6 py-4">NIM</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Tanggal Daftar</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs text-slate-700 font-medium">
    
                            @foreach($user as $index => $data)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="px-6 py-5 text-center text-slate-400 font-normal">
                                    {{ sprintf('%02d', $index + 1) }}
                                </td>
    
                                <td class="px-6 py-5 text-slate-800 font-extrabold leading-tight">
                                    {{ $data->username }}
                                </td>
    
                                <td class="px-6 py-5">
                                    <span
                                        class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded text-[10px] font-bold border border-blue-100">
                                        {{ $data->NIM_NIP ?? '0000000000' }}
                                    </span>
                                </td>
    
                                <td class="px-6 py-5 text-slate-400 font-normal">
                                    {{ $data->email }}
                                </td>
    
                                <td class="px-6 py-5 text-slate-500 font-semibold">
                                    {{ $data->created_at ? $data->created_at->format('d F Y') : '-' }}
                                </td>
    
                                <td class="px-6 py-5 text-center">
                                    @if($data->verify_at)
                                    <span
                                        class="inline-flex items-center justify-center rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200 px-3 py-1 text-[9px] font-extrabold uppercase tracking-wide">
                                        AKTIF
                                    </span>
                                    @elseif($data->note)
                                    <span
                                        class="inline-flex items-center justify-center rounded-full bg-rose-50 text-rose-600 border border-rose-200 px-3 py-1 text-[9px] font-extrabold uppercase tracking-wide">
                                        DITOLAK
                                    </span>
                                    @else
                                    <span
                                        class="inline-flex items-center justify-center rounded-full bg-amber-50 text-amber-600 border border-amber-200 px-3 py-1 text-[9px] font-extrabold uppercase tracking-wide">
                                        PENDING
                                    </span>
                                    @endif
                                </td>
    
                                <td class="px-6 py-5 text-center">
                                    <a href="{{ route('admin.user.detail', $data->id) }}"
                                        class="inline-block px-4 py-1.5 rounded-xl border border-slate-300 text-slate-700 font-bold hover:bg-slate-50 transition text-xs shadow-sm">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
    
                        </tbody>
                    </table>
                </div>
    
                <div class="bg-white px-6 py-4 border-t border-slate-100 flex items-center justify-between shadow-sm">
                    <div class="text-[11px] text-slate-400 font-medium">
                        Menampilkan <span class="font-bold text-slate-600">2</span> dari <span
                            class="font-bold text-slate-600">21</span> data
                    </div>
                    <div class="flex items-center gap-1">
                        <button type="button"
                            class="px-2 py-1 border border-slate-200 rounded-lg text-slate-300 text-[11px]"
                            disabled>&lt;</button>
                        <button type="button"
                            class="px-3 py-1 bg-[#0A5C66] text-white rounded-lg text-[11px] font-bold">1</button>
                        <button type="button"
                            class="px-3 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">2</button>
                        <button type="button"
                            class="px-3 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">3</button>
                        <button type="button"
                            class="px-2 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">&gt;</button>
                    </div>
                </div>
    
            </div>
            @if(session('success'))
            <div class="p-4 mb-4 text-xs text-emerald-800 bg-emerald-50 rounded-xl border border-emerald-200">
                {{ session('success') }}
            </div>
            @endif
    
            @if(session('error'))
            <div class="p-4 mb-4 text-xs text-rose-800 bg-rose-50 rounded-xl border border-rose-200">
                {{ session('error') }}
            </div>
            @endif
        </div>
    
    </div>
    
@endsection