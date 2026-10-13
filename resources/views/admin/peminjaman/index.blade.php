<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 bg-[#F8FAFC]">

        <!-- HEADER SECTION -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-extrabold text-[#0F172A]">Daftar Peminjaman Inventaris</h1>
                <p class="mt-1 text-sm text-[#64748B]">Kelola dan pantau status peminjaman inventaris Anda.</p>
            </div>
            <a href="{{ route('admin.peminjaman.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-[#0A5C66] px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-[#084952] transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Peminjaman
            </a>
        </div>

    <div class="space-y-4">
        <h2 class="text-base font-bold text-dark-grey tracking-[1.5px]">STATISTIK PEMINJAMAN</h2>
        <div class="grid grid-cols-4 w-full justify-start gap-6">
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
        <form method="GET">
            <div class="grid grid-cols-[1fr_250px] gap-6">
                <x-search-bar
                    name="search_masuk"
                    :showFilter="false"
                    placeholder="Cari nama kegiatan atau ID peminjaman..."
                    :value="request('search_masuk')"
                />
                <x-select name="status_masuk" label="Status" onchange="this.form.submit()">
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
                            class="text-wrap items-center rounded bg-primary-hover/20 px-2 py-0.5 font-bold text-primary-hover break-all">
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
                        :href="route('admin.peminjaman.detail-surat', [
                            'surat' => $surat->id,
                            'type' => 'masuk'
                        ])"/>
                        <x-action-button
                            type="delete"
                            onclick="openDeleteModal('{{ route('admin.peminjaman.destroy', $surat) }}')"
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

    <div class="bg bg-white rounded-2xl p-6 space-y-6">
        <div class="space-y-1">
                <h3 class="text-xl font-extrabold text-judul tracking-tight">
                    Peminjaman Keluar
                </h3>
                <p class="text-sm font-medium text-dark-grey">Daftar peminjaman barang dari {{ auth()->user()->username }}</p>
        </div>
        <form method="GET">
            <div class="grid grid-cols-[1fr_250px] gap-6">
                <x-search-bar
                    name="search_keluar"
                    :showFilter="false"
                    placeholder="Cari nama kegiatan atau ID peminjaman..."
                    :value="request('search_keluar')"
                />
                <x-select name="status_keluar" label="Status" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="pending" @selected(request('status_keluar') == 'pending')>Pending</option>
                    <option value="diterima" @selected(request('status_keluar') == 'diterima')>Diterima</option>
                    <option value="aktif" @selected(request('status_keluar') == 'aktif')>Aktif</option>
                    <option value="selesai" @selected(request('status_keluar') == 'selesai')>Selesai</option>
                    <option value="ditolak" @selected(request('status_keluar') == 'ditolak')>Ditolak</option>
                </x-select>
            </div>
            <input type="hidden" name="search_masuk" value="{{ request('search_masuk') }}">
            <input type="hidden" name="status_masuk" value="{{ request('status_masuk') }}">
        </form>
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
                    <div class="font-bold break-word justify-center">
                        {{ $surat->acara }}
                    </div>
                    <div class="justify-start">
                        <span
                            class="text-wrap justify-start break-word leading-tight items-center rounded bg-primary-hover/20 px-1 py-0.5 font-bold text-primary-hover ">
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
                                $surat->status_peminjaman === null => 'Pending',
                                $surat->status_peminjaman === false => 'Ditolak',
                                $surat->status_peminjaman === true && now()->lt($surat->tanggal_peminjaman) => 'Diterima',
                                $surat->status_peminjaman === true && now()->between($surat->tanggal_peminjaman, $surat->tanggal_kembali) => 'Aktif',
                                $surat->status_peminjaman === true && now()->gt($surat->tanggal_kembali) => 'Selesai',
                                default => 'Unknown',
                            };
                        @endphp
                        <x-status-card :status="$surat->status_peminjaman">
                            {{ $label }}
                        </x-status-card>
                    </div>
                    <div class="justify-start text-primary-hover break-word font-bold">
                       {{ $surat->detailPeminjaman->first()->inventaris->user->organization->name }}
                    </div>
                    <div class="justify-center flex gap-2">
                        <x-action-button type="view" as="a" 
                        :href="route('admin.peminjaman.detail-surat', [
                            'surat' => $surat->id,
                            'type' => 'keluar'
                        ])"/>
                        <x-action-button
                            type="delete"
                            onclick="openDeleteModal('{{ route('admin.peminjaman.destroy', $surat) }}')"
                        />
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
