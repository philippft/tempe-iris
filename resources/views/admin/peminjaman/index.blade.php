@extends('layouts.app')

@section('title', 'Peminjaman Inventaris') 

@section('content')
<div class="p-8 space-y-10">
    
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

    <div class="space-y-4">
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
                :value="$suratApprove->count()"
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
                :cols="['60px', '1fr', '1.3fr', '1fr', '1fr', '1fr', '1fr', '0.8fr']"
                data=""
                headerBg="bg-primary-hover"
                headerClass="text-white font-bold text-sm uppercase"
                bg="bg-white overflow-hidden"
            >
            @forelse($suratMasuk as $surat)
                <x-table-row>
                    <div>{{ sprintf('%02d', ($suratMasuk->currentPage() - 1) * $suratMasuk->perPage() + $loop->iteration) }}</div>
                    <div class="font-bold justify-center">
                        {{ $surat->acara }}
                    </div>
                    <div class="font-bold  justify-center">
                        <span
                            class="text-wrap items-center rounded bg-primary-hover/20 px-2 py-0.5 font-bold text-primary-hover ">
                            {{ $surat->nomor }}
                        </span>
                    </div>
                    <div class="justify-center text-dark-grey font-medium">
                        {{ \Carbon\Carbon::parse($surat->tanggal_peminjaman)->translatedFormat('d M Y') }}
                    </div>
                    <div class="justify-center text-dark-grey font-medium">
                        {{ \Carbon\Carbon::parse($surat->tanggal_kembali)->translatedFormat('d M Y') }}
                    </div>
                    
                    <div class="justify-center">
                        <x-status-card :status="$surat->status_peminjaman"/>
                        <!-- guys ni status keknya ga work di aku deh, salah kode -->
                    </div>
                    <div class="justify-center text-primary-hover font-bold">
                        {{ $surat->detailPeminjaman->first()->inventaris->user->organization_name }}
                    </div>
                    <div class="justify-center flex gap-2">
                        <x-action-button type="view" as="a" href="{{ route('admin.peminjaman.detail-surat', $surat->id) }}"></x-action-button>
                        <form action="{{ route('admin.inventaris.destroy', $surat->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan surat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    title="Hapus Data">
                                                    <x-action-button type="delete" as="a" href=""></x-action-button>
                                                </button>
                                            </form>
                    </div>
                </x-table-row>
                @empty
                    <x-table-empty/>
            @endforelse            
            </x-table>
            <x-pagination :data="$suratMasuk" />
        </x-container>
    </div>

    <div class="bg bg-white rounded-2xl p-6 space-y-6">
        <div class="space-y-1">
                <h3 class="text-xl font-extrabold text-judul tracking-tight">
                    Peminjaman Keluar
                </h3>
                <p class="text-sm font-medium text-dark-grey">Daftar peminjaman barang dari {{ auth()->user()->username }}</p>
        </div>
        <x-search-bar />
        <!-- SIAPAPUN HELP INI GIMANA CARANYA MAKE SEARCH BAR -->
        <x-container>
            <x-table
                :headers="['NO', 'Nama kegiatan', 'id pinjam', 'tanggal pinjam', 'estimasi kembali', 'status', 'tujuan', 'aksi']"
                :cols="['60px', '1fr', '250px', '1fr', '1fr', '1fr', '1.5fr', '140px']"
                data=""
                headerBg="bg-primary-hover"
                headerClass="text-white font-bold text-sm uppercase"
                bg="bg-white overflow-hidden"
            >
            @forelse($suratKeluar as $surat)
                <x-table-row>
                    <div>{{ sprintf('%02d', ($suratKeluar->currentPage() - 1) * $suratKeluar->perPage() + $loop->iteration) }}</div>
                    <div class="font-bold break-words justify-center">
                        {{ $surat->acara }}
                    </div>
                    <div class="justify-center">
                        <span
                            class="text-wrap justify-start break-all leading-tight items-center rounded bg-primary-hover/20 px-1 py-0.5 font-bold text-primary-hover ">
                            {{ $surat->nomor }}
                        </span>
                    </div>
                    <div class="justify-center text-dark-grey font-medium">
                        {{ \Carbon\Carbon::parse($surat->tanggal_peminjaman)->translatedFormat('d M Y') }}
                    </div>
                    <div class="justify-center text-dark-grey font-medium">
                        {{ \Carbon\Carbon::parse($surat->tanggal_kembali)->translatedFormat('d M Y') }}
                    </div>
                    
                    <div class="justify-center">
                        <x-status-card :status="$surat->status_peminjaman"/>
                        <!-- guys ni status keknya ga work di aku deh, salah kode -->
                    </div>
                    <div class="justify-center text-primary-hover break-words font-bold">
                        {{ $surat->detailPeminjaman->first()->inventaris->user->organization_name ?? '-' }}
                    </div>
                    <div class="justify-center flex gap-2">
                        <x-action-button type="view" as="a" href="{{ route('admin.peminjaman.detail-surat', $surat->id) }}"></x-action-button>
                        <form action="{{ route('admin.inventaris.destroy', $surat->id) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan surat ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                title="Hapus Data">
                                <x-action-button type="delete" as="a" href=""></x-action-button>
                            </button>
                        </form>
                    </div>
                </x-table-row>
                @empty
                    <x-table-empty/>
            @endforelse
            </x-table>
            <x-pagination :data="$suratKeluar"/>
        </x-container>
    </div>

</div>

@endsection