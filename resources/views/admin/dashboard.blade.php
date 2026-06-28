@extends('layouts.app')

@section('title', 'Dashboard Admin') 

@section('content')

<x-header-dashboard />

<div class="space-y-4 px-8">
    <h2 class="text-base font-bold text-dark-grey tracking-[1.5px]">STATISTIK PEMINJAMAN</h2>
    <div class="flex flex-wrap w-full justify-start gap-6">
    <x-statecard
            title="Total Aktif"
            :value="$suratAktif"
            label="Peminjaman"
            border="border-l-primary-hover"
            iconBg="bg-primary/10"
        > 
            <x-icons.totalaktif/>
        </x-statecard>
        <x-statecard
            title="Total Selesai"
            :value="$suratSelesai"
            label="Peminjaman"
            border="border-l-status-green"
            iconBg="bg-status-green/10"
        > 
            <x-icons.totalaktif/>
        </x-statecard>
        <x-statecard
            title="Total Diproses"
            :value="$suratPending"
            label="Peminjaman"
            border="border-l-status-yellow"
            iconBg="bg-status-yellow/10"
        > 
            <x-icons.totalpending/>
        </x-statecard>
        <x-statecard
            title="Total Ditolak"
            :value="$suratReject"
            label="Peminjaman"
            border="border-l-status-red"
            iconBg="bg-status-red/10"
        > 
            <x-icons.totaltolak/>
        </x-statecard>
    </div>
</div>

<div class="mt-8 space-y-4 px-8">
    <h2 class="text-base font-bold text-dark-grey tracking-[1.5px]">MANAJEMEN ASET & USER</h2>
    <div class="flex flex-wrap w-full justify-start gap-6 items-center">
        <x-statecard class="flex-1"
            title="Total Inventaris"
            :value="$totalInventaris"
            label="Barang"
            border="border-l-judul"
            iconBg="bg-primary/10"
            >
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.58128 17.2085C2.10804 17.2085 1.70293 17.04 1.36593 16.703C1.02893 16.366 0.860426 15.9609 0.860426 15.4877V5.78636C0.602298 5.62862 0.394362 5.42427 0.236617 5.17331C0.0788724 4.92235 0 4.63196 0 4.30213V1.72085C0 1.24762 0.1685 0.8425 0.5055 0.5055C0.8425 0.1685 1.24762 0 1.72085 0H15.4877C15.9609 0 16.366 0.1685 16.703 0.5055C17.04 0.8425 17.2085 1.24762 17.2085 1.72085V4.30213C17.2085 4.63196 17.1296 4.92235 16.9719 5.17331C16.8142 5.42427 16.6062 5.62862 16.3481 5.78636V15.4877C16.3481 15.9609 16.1796 16.366 15.8426 16.703C15.5056 17.04 15.1005 17.2085 14.6272 17.2085H2.58128ZM2.58128 6.02298V15.4877H14.6272V6.02298H2.58128ZM1.72085 4.30213H15.4877V1.72085H1.72085V4.30213ZM6.02298 10.3251H11.1855V8.60426H6.02298V10.3251Z" fill="#131B2E"/>
                </svg>
        </x-statecard> 
        <x-stat-card class="flex-1"
            variant="green" 
            label="User Aktif" 
            :number="$userAktif" 
            unit="Mahasiswa"
            /> 
        <x-stat-card class="flex-1"
            variant="yellow" 
            label="User Pending" 
            :number="$userPending" 
            unit="Mahasiswa"
            /> 
    </div>
</div>
<div class="p-8">
    <div class="w-full flex justify-between items-center mb-5">
        <div class="space-y-1">
            <h3 class="text-xl font-extrabold text-judul tracking-tight">
                Status Inventaris
            </h3>
            <p class="text-sm font-medium text-dark-grey">Barang yang sedang dipinjam saat ini</p>
        </div>
        <div class="px-4 py-1.5 bg-primary/10 rounded-full border border-primary/5 flex items-center justify-center">
            <span class="text-sm font-bold text-primary whitespace-nowrap">
                {{ $inventarisDipinjam->count() }} Unit
            </span>
        </div>
    </div>

    <div class="space-y-3">
        @forelse($inventarisDipinjam as $barang)
            <x-item-card 
                :title="$barang->nama"
                :owner="$barang->user?->organization?->name ?? '-'"
                :category="$barang->category?->name ?? '-'"
                status="Dipinjam"
            />
        @empty
            <div class="bg-white rounded-xl p-6 text-center text-gray-500">
                Tidak ada inventaris yang sedang dipinjam.
            </div>
        @endforelse
    </div>
</div>

<div class="p-8">
    <x-container>
        <div class="w-full flex justify-between items-center mb-5">
            <div class="space-y-1 pt-4 pl-8">
                <h3 class="text-xl font-extrabold text-judul tracking-tight ">
                    User Pending
                </h3>
                <p class="text-sm font-medium text-dark-grey">Mahasiswa menunggu aktivasi akun</p>
            </div>
            <div class="text-base font-bold mr-6 text-primary-hover hover:underline py-2 pl-4">
                <a href="{{ route('admin.management.user') }}">
                    Lihat semua
                </a>
            </div>
        </div>
        <div>
            <x-table
                :headers="['NO', 'NAMA MAHASISWA', 'NIM', 'DOKUMEN MAHASISWA']"
                :cols="['60px', '1fr', '1fr', '1fr']"
                :data="$pendingUsers"
                headerBg="bg-primary-hover/10"
                headerClass="text-primary font-bold text-sm uppercase"
                bg="bg-white overflow-hidden"
            >
            @forelse ($pendingUsers as $index => $user )
                <x-table-row>
                    <div class="font-bold justify-center">{{ $index }}</div>
                    <div class="font-bold justify-left">
                        {{ $user->name }}
                    </div>
                    <div class="font-bold justify-center">
                        {{ $user->nim_nip }}
                    </div>
                    <div class="justify-center">
                        <x-action-button type="view" as="a" :href="route('admin.user.detail', $user)"/>
                    </div>
                </x-table-row>
            @empty
                <x-table-row>
                    <div class="justify-center font-bold"> - </div>
                    <div class="justify-center text-gray-500">
                        Tidak ada user pending
                    </div>
                    <div></div>
                        <div></div>
                </x-table-row>
            @endforelse
            </x-table>
        </div>
    </x-container>
</div>

<div class="p-8">
    <x-container>
        <div class="space-y-1 pt-4 pl-8">
            <h3 class="text-xl font-extrabold text-judul tracking-tight">
                Peminjaman Aktif
            </h3>
            <p class="text-sm font-medium text-dark-grey">Daftar barang yang sedang dalam masa peminjaman</p>
        </div>
        <div class="m-8">
            <form method="GET">
                <x-search-bar
                    name="search"
                    :filterOptions="[
                        'terbaru' => 'Terbaru',
                        'terlama' => 'Terlama'
                    ]"
                />
            </form>
        </div>
        <div>
            @if($peminjamanAktif->count())
                <x-table
                    :headers="['NO', 'NAMA KEGIATAN', 'ID PINJAM', 'TANGGAL PINJAM', 'ESTIMASI KEMBALI', 'TUJUAN', 'AKSI']"
                    :cols="['60px', '1fr', '1fr', '1fr', '1fr', '1fr', '1fr']"
                    :data="$peminjamanAktif"
                    headerBg="bg-primary-hover/10"
                    headerClass="text-primary font-bold text-sm uppercase"
                    bg="bg-white overflow-hidden"
                >
                    @foreach($peminjamanAktif as $surat)
                        <x-table-row>
                            <div>{{ $loop->iteration + ($peminjamanAktif->currentPage()-1) * $peminjamanAktif->perPage() }}</div>

                            <div class="font-bold justify-center break-all">
                                {{ $surat->acara }}
                            </div>

                            <div class="font-bold justify-center break-all">
                                <span class="bg-[#EEF0FF] px-4 py-2 rounded-xl font-bold text-primary-hover">
                                    {{ $surat->nomor }}
                                </span>
                            </div>

                            <div class="justify-center">
                                {{ $surat->tanggal_peminjaman->format('d M Y') }}
                            </div>

                            <div class="justify-center">
                                {{ $surat->tanggal_kembali->format('d M Y') }}
                            </div>

                            <div class="font-bold text-primary-hover justify-center">
                                {{ $surat->detailPeminjaman->first()?->inventaris?->user?->organization?->name ?? '-' }}
                            </div>

                            <div class="justify-center">
                                <x-action-button
                                    type="view"
                                    as="a"
                                    :href="route('admin.surat.detail', $surat)"
                                />
                            </div>
                        </x-table-row>
                    @endforeach
                </x-table>

                <div class="mt-6">
                    {{ $peminjamanAktif->links() }}
                </div>
            @else
                <x-table
                    :headers="['NO', 'NAMA KEGIATAN', 'ID PINJAM', 'TANGGAL PINJAM', 'ESTIMASI KEMBALI', 'TUJUAN', 'AKSI']"
                    :cols="['60px', '1fr', '1fr', '1fr', '1fr', '1fr', '1fr']"
                    :data="collect()"
                    headerBg="bg-primary-hover/10"
                    headerClass="text-primary font-bold text-sm uppercase"
                    bg="bg-white overflow-hidden"
                />

                <x-table-empty
                    title="Belum Ada Peminjaman Aktif"
                    message="Saat ini tidak ada peminjaman yang sedang berlangsung."
                />
            @endif
        </div>
    </x-container>
</div>
@endsection