@extends('layouts.app')

@section('title', 'Detail Pengajuan Peminjaman')

@section('content')

<div class="flex flex-col gap-5 pb-8">
    <x-header-page title="Form Pengajuan Peminjaman"/>

    <form action="{{ route('admin.peminjaman.add.kegiatan', $surat->id) }}" method="POST" class="flex flex-col gap-5 px-6">
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
            <div>
                <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Tujuan
                    Peminjaman</label>
                <input type="text" value="{{ $tujuan ?? 'BEM FMIPA' }}" readonly
                    class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs text-gray-500 cursor-not-allowed">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label
                        class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Tanggal
                        Pinjam</label>
                    <div class="relative">
                        <input type="date" name="tanggal_peminjaman" required
                            class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] pl-4 pr-10 py-2.5 text-xs text-gray-400 focus:text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                    </div>
                </div>
                <div>
                    <label
                        class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Tanggal
                        Kembali</label>
                    <div class="relative">
                        <input type="date" name="tanggal_kembali" required
                            class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] pl-4 pr-10 py-2.5 text-xs text-gray-400 focus:text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Perihal
                    Peminjaman</label>
                <textarea name="perihal_peminjaman" rows="4"
                    placeholder="Jelaskan keperluan peminjaman barang secara detail..." required
                    class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] px-4 py-2.5 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition"></textarea>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit"
                    class="rounded-xl bg-[#0A5C66] hover:bg-[#084952] px-6 py-2.5 text-xs font-bold text-white shadow-md transition">
                    Simpan Data
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
                        <x-action-button
                            type="delete"
                            onclick="openDeleteModal('{{ route('admin.peminjaman.detail.destroy', $item->detail_id) }}')"
                        />
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