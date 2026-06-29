@extends('layouts.app')

@section('title', 'Detail Pengajuan Peminjaman')

@section('content')

<div class="flex flex-col gap-5 pb-8">
    <x-header-page title="Form Pengajuan Peminjaman"/>

    <form action="{{ route('user.peminjaman.add.kegiatan', $surat->id) }}" method="POST" class="flex flex-col gap-5 px-6">
        @csrf
        @method('PUT')

        <div class="bg-white border border-border-custom rounded-2xl p-6 shadow-sm flex flex-col gap-5">
            <div class="border-b border-border-custom pb-3">
                <h2 class="text-xl font-bold text-judul tracking-tight">Detail Pengajuan</h2>
                <p class="text-xs font-medium text-subtext">Lengkapi formulir permohonan peminjaman.</p>
            </div>

            {{-- Nama Acara --}}
            <x-input id="acara" name="acara" label="Nama Acara" placeholder="Nama Kegiatan" :value="old('acara', $surat->acara)" />

            {{-- Singkatan Acara (Name disamakan dengan request 'singkatan') --}}
            <x-input id="singkatan" name="singkatan" label="Singkatan Acara" placeholder="Ex: SUPREMASI" :value="old('singkatan', $surat->singkatan_acara)" />

            {{-- Tujuan (Readonly) --}}
            <div>
                <label class="block text-[11px] font-bold text-judul uppercase tracking-wider mb-1.5">Tujuan Peminjaman</label>
                <input type="text" value="{{ $tujuan ?? 'BEM FMIPA' }}" readonly
                    class="w-full px-3 py-2.5 bg-[#E8F0FE] border border-border-custom rounded-lg text-sm text-judul cursor-not-allowed">
            </div>


            {{-- Tanggal Peminjaman & Kembali (Name disamakan dengan request) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input id="tanggal_peminjaman" name="tanggal_peminjaman" type="date" label="Tanggal Pinjam" 
                    :value="old('tanggal_peminjaman', $surat->tanggal_peminjaman ? \Carbon\Carbon::parse($surat->tanggal_peminjaman)->format('Y-m-d') : '')" />
                
                <x-input id="tanggal_kembali" name="tanggal_kembali" type="date" label="Tanggal Kembali" 
                    :value="old('tanggal_kembali', $surat->tanggal_kembali ? \Carbon\Carbon::parse($surat->tanggal_kembali)->format('Y-m-d') : '')" />
            </div>

            {{-- Perihal Peminjaman --}}
            <div>
                <label for="perihal_peminjaman" class="block text-[11px] font-bold text-judul uppercase tracking-wider mb-1.5">Perihal Peminjaman</label>
                <textarea id="perihal_peminjaman" name="perihal_peminjaman" rows="3" placeholder="Jelaskan detail perihal peminjaman..."
                    class="w-full px-3 py-2.5 bg-bg-dark/50 border border-border-custom rounded-lg text-sm transition focus:border-primary outline-none resize-none"
                ></textarea>
                @error('perihal_peminjaman') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end border-t border-border-custom pt-3">
                <button type="submit" class="px-5 py-2.5 bg-primary hover:bg-primary-hover text-white font-medium text-sm rounded-xl transition shadow-sm">
                    Simpan
                </button>
            </div>
        </div>

        {{-- List Barang (ReadOnly) --}}
        <div class="bg-white border border-border-custom rounded-2xl p-6 shadow-sm flex flex-col gap-5">
            <div class="flex flex-col gap-1">
                <h2 class="text-xl font-bold text-judul tracking-tight">List Barang Pinjaman</h2>
                <p class="text-xs font-medium text-subtext">Cek dan pastikan jumlah dari barang yang ingin dipinjam</p>
            </div>

            <x-table 
                :headers="['No', 'Nama Barang', 'ID Barang', 'Jumlah', 'Kategori', 'Aksi']"
                :cols="['0.5fr', '2fr', '1.2fr', '1fr', '1.5fr', '0.8fr']"
                class="border border-border-custom rounded-xl overflow-hidden shadow-sm"
                headerBg="bg-primary"
                headerClass="text-white font-bold text-xs tracking-wider text-left px-4 py-3"
            >
                @forelse($detailBarang as $index => $item)
                    <x-table-row>
                        {{-- No --}}
                        <div class="text-xs text-subtext font-medium px-4 py-3">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        
                        {{-- Nama Barang --}}
                        <div class="text-xs font-bold text-judul px-4 py-3">
                            {{ $item->nama_barang }}
                        </div>
                        
                        {{-- ID Barang (Badge style) --}}
                        <div class="px-4 py-3">
                            <span class="px-2 py-1 bg-bg-light border border-border-custom text-[10px] font-bold text-primary rounded-md uppercase">
                                {{ str_pad($item->id, 2, '0', STR_PAD_LEFT) }}-DKN
                            </span>
                        </div>
                        
                        {{-- Jumlah --}}
                        <div class="text-xs font-medium text-subtext px-4 py-3">
                            {{ $item->qty_inventaris }}
                        </div>
                        
                        {{-- Kategori --}}
                        <div class="text-xs font-medium text-subtext px-4 py-3">
                            {{ $item->nama_kategori }}
                        </div>
                        
                        {{-- Aksi --}}
                        <div class="flex justify-center items-center px-4 py-3">
                            <x-action-button
                                type="delete"
                                onclick="openDeleteModal('{{ route('user.peminjaman.detail.destroy', $item->detail_id) }}')"
                            />
                        </div>
                    </x-table-row>
                @empty
                    <div class="p-6 text-center text-xs text-subtext font-medium">
                        Belum ada barang dipilih.
                    </div>
                @endforelse
            </x-table>
        </div>

        {{-- NAVIGATION BOTTOM BUTTONS --}}
        {{-- <div class="bg-white border border-border-custom rounded-2xl p-4 flex items-center justify-between shadow-sm">
            <x-button variant="secondary" href="{{ url()->previous() }}" class="!text-xs !px-5 !py-2">
                Kembali
            </x-button>

            <x-button variant="primary" href="{{ route('user.peminjaman.detail.kegiatan', ['surat' => $surat->id]) }}" class="!text-xs !px-5 !py-2">
                Selanjutnya
            </x-button>
        </div> --}}
    </form>
</div>
<x-popup-del
    id="deleteModal"
    title="Hapus Barang"
    message="Apakah Anda yakin ingin menghapus barang ini dari daftar peminjaman?<br><strong>Tindakan ini tidak dapat dibatalkan.</strong>"
/>

@push('scripts')
<script>
function openDeleteModal(action) {
    document.getElementById('deleteForm').action = action;

    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}
</script>
@endpush
@endsection