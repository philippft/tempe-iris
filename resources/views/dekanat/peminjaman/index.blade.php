@extends('layouts.app')

@section('title', 'Peminjaman Inventaris') 

@section('content')
<div class="p-8 space-y-10">
    
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-4xl font-extrabold text-judul">Daftar Peminjaman Inventaris</h3>
            <p class="text-base text-dark-grey font-medium">Kelola dan pantau status peminjaman inventaris Anda.</p>
        </div>
    </div>

    <div class="space-y-4">
        <h2 class="text-base font-bold text-dark-grey tracking-[1.5px]">STATISTIK PEMINJAMAN</h2>
        <div class="grid grid-cols-4 w-full justify-start gap-6">
        <x-statecard
            title="Total Surat"
            :value="$suratMasuk->total()"
            label="Peminjaman"
            border="border-l-primary-hover"
            iconBg="bg-primary/10">
            <x-icons.totalaktif/>
        </x-statecard>
        <x-statecard
            title="Disetujui"
            :value="$suratApprove->count()"
            label="Peminjaman"
            border="border-l-status-green"
            iconBg="bg-status-green/10">
            <x-icons.totalaktif/>
        </x-statecard>
        <x-statecard
            title="Pending"
            :value="$suratPending->count()"
            label="Peminjaman"
            border="border-l-status-yellow"
            iconBg="bg-status-yellow/10">
            <x-icons.totalpending/>
        </x-statecard>
        <x-statecard
            title="Ditolak"
            :value="$suratReject->count()"
            label="Peminjaman"
            border="border-l-status-red"
            iconBg="bg-status-red/10">
            <x-icons.totaltolak/>
        </x-statecard>
    </div>

    <div class="bg bg-white rounded-2xl p-6 space-y-6">
        <div class="space-y-1">
                <h3 class="text-xl font-extrabold text-judul tracking-tight">
                    Peminjaman Masuk
                </h3>
                <p class="text-sm font-medium text-dark-grey">Daftar peminjaman barang kepada {{ auth()->user()->name }}</p>
        </div>
        <form method="GET">
            <div class="grid grid-cols-[1fr_250px] gap-6">
                <x-search-bar
                    name="search"
                    :showFilter="false"
                    placeholder="Cari nama kegiatan atau ID peminjaman..."
                    :value="request('search')"
                />
                <x-select name="status" label="Status" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="pending" @selected(request('status_masuk') == 'pending')>Pending</option>
                    <option value="diterima" @selected(request('status_masuk') == 'diterima')>Diterima</option>
                    <option value="aktif" @selected(request('status_masuk') == 'aktif')>Aktif</option>
                    <option value="selesai" @selected(request('status_masuk') == 'selesai')>Selesai</option>
                    <option value="ditolak" @selected(request('status_masuk') == 'ditolak')>Ditolak</option>
                </x-select>
            </div>
            <input type="hidden" name="search_keluar" value="{{ request('search_keluar') }}">
            <input type="hidden" name="status_keluar" value="{{ request('status_keluar') }}">
        </form>
        <x-container>
            <x-table
                :headers="['NO', 'Nama kegiatan', 'id pinjam', 'tanggal pinjam', 'estimasi kembali', 'status', 'pengaju', 'aksi']"
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
                    <div class="font-bold justify-start">
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
                    <div class="justify-center text-primary-hover font-bold">
                        {{ $surat->user?->organization?->name ?? '-' }}
                    </div>
                    <div class="justify-center flex gap-2">
                        <x-action-button type="view" as="a" 
                        :href="route('dekanat.peminjaman.detail-surat', [
                            'surat' => $surat->id,
                            'type' => 'masuk'
                        ])"/>
                        <x-action-button
                            type="delete"
                            onclick="openDeleteModal('{{ route('dekanat.peminjaman.destroy', $surat) }}')"
                        />
                    </div>
                </x-table-row>
                @empty
                    <x-table-empty/>
            @endforelse          
            </x-table>
            <x-pagination :data="$suratMasuk" />
        </x-container>
    </div>
</div>

<x-popup-del id="deleteModal"/>

@push('scripts')
<script>
function openDeleteModal(action)
{
    document.getElementById('deleteForm').action = action;

    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteModal()
{
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}
</script>
@endpush
@endsection