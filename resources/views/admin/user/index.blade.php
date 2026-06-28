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
                :value="$totalMahasiswa"
                label="Akun"
                border="border-l-primary-hover"
                iconBg="bg-primary/10"
            > 
                <x-icons.totalaktif/>
            </x-statecard>
            <x-statecard
                title="Akun Pending"
                :value="$totalPending"
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
        @php 
            $no = ($user->currentPage() - 1) * $user->perPage(); 
        @endphp

        @forelse($user as $index => $data)
            <x-table-row>
                <div class="justify-center font-medium text-base text-dark-grey">
                    {{ str_pad(++$no, 2, '0', STR_PAD_LEFT) }}
                </div>

                <div class="justify-start font-bold text-judul wrap-break-words pr-2 text-base leading-tight">
                    {{ $data->name }}
                </div>

                <div class="justify-start">
                    <span class="bg-bg-dark text-primary px-2 py-0.5 rounded-md text-sm font-bold ">
                        {{ $data->nim_nip ?? '0000000000' }}
                    </span>
                </div>

                <div class="justify-center text-dark-grey font-normal text-[10px] break-all">
                    {{ $data->email }}
                </div>

                <div class="justify-center text-dark-grey font-medium text-base">
                    {{ $data->created_at ? $data->created_at->format('d F Y') : '-' }}
                </div>

                <div class="justify-center">
                    @if($data->verify_at)
                        <span class="bg-status-green inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white uppercase rounded-full tracking-wider">
                            AKTIF
                        </span>
                    @elseif($data->note && $data->verify_at == null)
                        <span class="bg-status-red inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white uppercase rounded-full tracking-wider">
                            DITOLAK
                        </span>
                    @elseif($data->note == null && $data->verify_at == null)
                        <span class="bg-status-yellow inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white uppercase rounded-full tracking-wider">
                            PENDING
                        </span>
                    @endif
                </div>

                <div class="justify-center">
                    <a href="{{ route('admin.user.detail', $data->id) }}"
                    class="border-2 border-primary-hover  rounded-xl inline-flex items-center justify-center px-4.5 py-2 text-sm font-bold text-primary-hover shadow-sm hover:bg-bg-dark hover:shadow-lg transition tracking-wider">
                        Detail
                    </a>
                </div>
            </x-table-row>
            @empty
            <x-table-empty title="Tidak ada Data Mahasiswa" message="Saat ini belum ada mahasiswa yang terdaftar atau tidak ada data yang cocok dengan pencarian Anda."/>
        @endforelse
        </x-table>

</x-container>
    
@endsection