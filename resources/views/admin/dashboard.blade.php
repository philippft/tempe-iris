@extends('layouts.app')

@section('title', 'Dashboard Admin') 

@section('content')

<div class="p-8">
<x-header-dashboard />
    <div class="space-y-4">
        <h2 class="text-base font-bold text-dark-grey tracking-[1.5px]">STATISTIK PEMINJAMAN</h2>
        <div class="flex flex-wrap w-full justify-start gap-6">
            <x-statecard title="Total Aktif" value="21" label="Peminjaman" border="border-l-primary-hover"
                iconBg="bg-primary/10">
                <x-icons.totalaktif />
            </x-statecard>
            <x-statecard title="Total Selesai" value="21" label="Peminjaman" border="border-l-status-green"
                iconBg="bg-status-green/10">
                <x-icons.totalaktif />
            </x-statecard>
            <x-statecard title="Total Diproses" value="21" label="Peminjaman" border="border-l-status-yellow"
                iconBg="bg-status-yellow/10">
                <x-icons.totalpending />
            </x-statecard>
            <x-statecard title="Total Ditolak" value="21" label="Peminjaman" border="border-l-status-red"
                iconBg="bg-status-red/10">
                <x-icons.totaltolak />
            </x-statecard>
        </div>
    </div>

    <div class="mt-8 space-y-4">
        <h2 class="text-base font-bold text-dark-grey tracking-[1.5px]">MANAJEMEN ASET & USER</h2>
        <div class="flex flex-wrap w-full justify-start gap-6 items-center">
            <x-statecard class="flex-1" title="Total Inventaris" value="21" label="Barang" border="border-l-judul"
                iconBg="bg-primary/10">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M2.58128 17.2085C2.10804 17.2085 1.70293 17.04 1.36593 16.703C1.02893 16.366 0.860426 15.9609 0.860426 15.4877V5.78636C0.602298 5.62862 0.394362 5.42427 0.236617 5.17331C0.0788724 4.92235 0 4.63196 0 4.30213V1.72085C0 1.24762 0.1685 0.8425 0.5055 0.5055C0.8425 0.1685 1.24762 0 1.72085 0H15.4877C15.9609 0 16.366 0.1685 16.703 0.5055C17.04 0.8425 17.2085 1.24762 17.2085 1.72085V4.30213C17.2085 4.63196 17.1296 4.92235 16.9719 5.17331C16.8142 5.42427 16.6062 5.62862 16.3481 5.78636V15.4877C16.3481 15.9609 16.1796 16.366 15.8426 16.703C15.5056 17.04 15.1005 17.2085 14.6272 17.2085H2.58128ZM2.58128 6.02298V15.4877H14.6272V6.02298H2.58128ZM1.72085 4.30213H15.4877V1.72085H1.72085V4.30213ZM6.02298 10.3251H11.1855V8.60426H6.02298V10.3251Z"
                        fill="#131B2E" />
                </svg>
            </x-statecard>
            <x-stat-card class="flex-1" variant="green" label="User Aktif" number="21" unit="Mahasiswa">
            </x-stat-card>
            <x-stat-card class="flex-1" variant="yellow" label="User Pending" number="21" unit="Mahasiswa">
            </x-stat-card>
        </div>
    </div>
    <div class="mt-8 mb-8">
        <div class="w-full flex justify-between items-center mb-5">
            <div class="space-y-1">
                <h3 class="text-xl font-extrabold text-judul tracking-tight">
                    Status Inventaris
                </h3>
                <p class="text-sm font-medium text-dark-grey">Barang yang sedang dipinjam saat ini</p>
            </div>
            <div
                class="px-4 py-1.5 bg-primary/10 rounded-full border border-primary/5 flex items-center justify-center">
                <span class="text-sm font-bold text-primary whitespace-nowrap">
                    21 unit
                </span>
            </div>
        </div>

        <div class="space-y-3">
            <x-item-card title="Sound MX100 System" owner="Himaif" category="Elektronik" status="Dipinjam">
            </x-item-card>
            <x-item-card title="Sound MX100 System" owner="Himaif" category="Elektronik" status="Dipinjam">
            </x-item-card>
            <x-item-card title="Sound MX100 System" owner="Himaif" category="Elektronik" status="Dipinjam">
            </x-item-card>
        </div>
    </div>

    <div class="bg bg-white rounded-2xl p-6">
        <div class="w-full flex justify-between items-center mb-5">
            <div class="space-y-1">
                <h3 class="text-xl font-extrabold text-judul tracking-tight">
                    User Pending
                </h3>
                <p class="text-sm font-medium text-dark-grey">Mahasiswa menunggu aktivasi akun</p>
            </div>
            <div class="text-sm font-bold mr-6 text-primary-hover hover:underline">
                <a href="" ">Lihat semua</a>
        </div>
        <!-- el tolong hrefnya kemana kalo mau liat semua? -->
    </div>
    <x-container>
        <x-table
            :headers=" ['NO', 'NAMA MAHASISWA' , 'NIM' , 'DOKUMEN MAHASISWA' ]" :cols="['60px', '1fr', '1fr', '1fr']"
                    data="" headerBg="bg-primary-hover/10" headerClass="text-primary font-bold text-sm uppercase"
                    bg="bg-white overflow-hidden">
                    <x-table-row>
                        <div class="font-bold">1</div>
                        <div class="font-bold justify-center">
                            anak agung mas mayuriii iiiiiiiiiiiiiiiiiiiiii iiiiiiiiii
                        </div>
                        <div class="font-bold justify-center">
                            2408561077
                        </div>
                        <div class="justify-center">
                            <x-action-button type="view" as="a" href="#"></x-action-button>
                        </div>
                    </x-table-row>
                    </x-table>
                    </x-container>
            </div>

            <div class="bg bg-white rounded-2xl p-6 mt-8">
                <div class="space-y-1">
                    <h3 class="text-xl font-extrabold text-judul tracking-tight">
                        Peminjaman Aktif
                    </h3>
                    <p class="text-sm font-medium text-dark-grey">Daftar barang yang sedang dalam masa peminjaman</p>
                </div>
                <div class="my-8">
                    <x-search-bar filterOptions=""></x-search-bar>
                    <!-- gimana cara pakainya ini bro -->
                </div>
                <x-container>
                    <x-table
                        :headers="['NO', 'NAMA KEGIATAN', 'ID PINJAM', 'TANGGAL PINJAM', 'ESTIMASI KEMBALI', 'TUJUAN', 'AKSI']"
                        :cols="['60px', '1fr', '1fr', '1fr', '1fr', '1fr', '1fr']" data=""
                        headerBg="bg-primary-hover/10" headerClass="text-primary font-bold text-sm uppercase"
                        bg="bg-white overflow-hidden">
                        <x-table-row>
                            <div>1</div>
                            <div class="font-bold justify-center">
                                Ini nama kegiatann
                            </div>
                            <div class="font-bold justify-center">
                                id pinjam ini
                            </div>
                            <div class="justify-center">
                                tanggal minjem
                            </div>
                            <div class="justify-center">
                                tanggal balik
                            </div>
                            <div class="font-bold text-primary-hover justify-center">
                                tujuannya ke dekanat
                            </div>
                            <div class="justify-center">
                                <x-action-button type="view" as="a" href="#"></x-action-button>
                            </div>
                        </x-table-row>
                    </x-table>
                </x-container>
            </div>
</div>

@endsection