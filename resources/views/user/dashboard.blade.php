@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <x-header-dashboard/>

    <div class="space-y-8 p-8">
        <h1 class="text-xl font-bold text-dark-grey tracking-[1.5px]">STATISTIK PEMINJAMAN</h1>
        <div class="flex w-full justify-start gap-6">
            <x-statecard
                title="Total Aktif"
                :value="$suratAprove"
                label="Peminjaman"
                border="border-l-primary-hover"
                iconBg="bg-primary-hover/10"
            >
                <x-icons.totalaktif/>
            </x-statecard>
            <x-statecard
                title="Total Pending"
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

        {{-- status persuratan --}}
        <x-container>
            <div>
                <div class="p-9">
                    <h1 class="text-judul text-xl font-extrabold">Status Persuratan</h1>
                    <p class="text-dark-grey text-base font-medium">Daftar surat peminjaman yang sedang diproses</p>
                </div>
                <x-table
                    :headers="['No', 'Nomor Surat', 'Perihal', 'Tanggal Kirim', 'Status', 'Aksi']"
                    :cols="['60px', '0.75fr', '1fr', '0.5fr', '0.5fr', '0.5fr']"
                    :data="$surats"
                    headerBg="bg-primary-hover/10"
                    headerClass="text-primary font-bold text-base uppercase"
                    bg="bg-white"
                >
                    @foreach($surats as $surat)
                        <x-table-row>
                            <div class="justify-center text-dark-grey">{{ $loop->iteration }}</div>
                            <div class="font-bold justify-start break-all">
                                {{ $surat->nomor }}
                            </div>
                            <div class="font-medium justify-start break-all">
                                {{ $surat->perihal_peminjaman }}
                            </div>
                            <div class="justify-center text-dark-grey/70">
                                {{ $surat->tanggal_peminjaman->format('d M Y') }}
                            </div>
                            <div class="justify-center">
                                    @php
                                        $label = match (true) {
                                            is_null($surat->status_peminjaman) => 'Pending',
                                            $surat->status_peminjaman == 0 => 'Ditolak',
                                            $surat->status_peminjaman == 1 && $surat->tandatangan_pimpinan != 1 => 'Pending',
                                            $surat->status_peminjaman == 1 && $surat->tandatangan_pimpinan == 1 && now()->lt($surat->tanggal_peminjaman) => 'Diterima',
                                            $surat->status_peminjaman == 1 && $surat->tandatangan_pimpinan == 1 && now()->between($surat->tanggal_peminjaman, $surat->tanggal_kembali) => 'Aktif',
                                            $surat->status_peminjaman == 1 && $surat->tandatangan_pimpinan == 1 && now()->gt($surat->tanggal_kembali) => 'Selesai',
                                            default => 'Pending',
                                        };
                                    @endphp

                                <x-status-card :status="$surat->status_peminjaman" :ttd="$surat->tandatangan_pimpinan">
                                    {{ $label }}
                                </x-status-card>
                            </div>
                            <div class="justify-center">
                                <div class="justify-center">
                                    <x-action-button
                                        type="view"
                                        as="a"
                                        :href="route('user.peminjaman.detail-surat', $surat)"
                                    />
                                </div>
                            </div>
                        </x-table-row>
                    @endforeach
                </x-table>
            </div>
        </x-container>

        <x-container>
            <div class="p-9 space-y-8">
                <div>
                    <h1 class="text-judul text-3xl font-extrabold">
                        Peminjaman Aktif
                    </h1>
                    <p class="text-dark-grey text-lg">
                        Daftar barang yang sedang dalam masa peminjaman
                    </p>
                </div>

            <form>
                <x-search-bar name="search" :value="request('search')" 
                    :filterOptions="[
                        'terbaru' => 'Terbaru',
                        'terlama' => 'Terlama'
                    ]"
                />
            </form>
            </div>

            <x-table
                :headers="['No', 'Nama Kegiatan', 'ID Pinjam', 'Tanggal Pinjam', 'Estimasi Kembali', 'Tujuan', 'Aksi']"
                :cols="['70px', '1fr', '0.9fr', '0.8fr', '0.8fr', '0.7fr', '90px']"
                :data="$peminjamanAktif"
                headerBg="bg-primary-hover/10"
                headerClass="text-primary font-bold text-base uppercase"
            >
                @foreach($peminjamanAktif as $surat)
                    <x-table-row>
                        <div class="justify-center text-dark-grey">
                            {{ $loop->iteration }}
                        </div>
                        <div class="font-bold break-all">
                            {{ $surat->acara }}
                        </div>
                        <div class="justify-center font-medium">
                            <span class="bg-[#EEF0FF] text-primary-hover rounded-xl px-4 py-2 font-bold break-all">
                                {{ $surat->nomor }}
                            </span>
                        </div>
                        <div class="justify-center">
                            {{ $surat->tanggal_peminjaman->format('d M Y') }}
                        </div>
                        <div class="justify-center">
                            {{ $surat->tanggal_kembali->format('d M Y') }}
                        </div>
                        <div>
                            {{$surat->detailPeminjaman->first()?->inventaris?->user?->organization?->name?? '-'}}
                        </div>
                        <div class="justify-center">
                            <div class="justify-center">
                                <x-action-button
                                    type="view"
                                    as="a"
                                    :href="route('user.peminjaman.detail-surat', $surat)"
                                />
                            </div>
                        </div>
                    </x-table-row>
                @endforeach
            </x-table>
        </x-container>
    </div>
@endsection