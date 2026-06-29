@extends('layouts.app')

@section('title', 'Form Surat Peminjaman')

@section('content')

<x-header-page title="Form Pengajuan Peminjaman"/>

<div class="w-full p-6" x-data="kegiatanForm()">

    <form action="{{ route('admin.peminjaman.store.kegiatan', $surat->id) }}" method="POST" class="flex flex-col gap-6">
        @csrf
        @method('PUT')

        {{-- MAIN CARD --}}
        <div class="bg-white rounded-[24px] border border-slate-200 shadow-sm overflow-hidden">
            
            {{-- Header --}}
            <div class="bg-[#F8FAFC] px-8 py-6 border-b border-slate-100">
                <h2 class="text-xl font-bold text-[#0A5C66]">Form Surat Peminjaman</h2>
                <p class="text-xs font-medium text-slate-500 mt-1">Lengkapi formulir di bawah ini untuk mengenerate surat peminjaman inventaris.</p>
            </div>

            {{-- Body --}}
            <div class="p-8 space-y-6">
                
                {{-- Static Inputs menggunakan komponen x-input --}}
                <x-input id="nomor" name="nomor" label="Nomor Surat" placeholder="Nomor Surat" required />
                <x-input id="penyelenggara" name="penyelenggara" label="Penyelenggara" placeholder="Nama Penyelenggara" required />
                <x-input id="prodi" name="prodi" label="Prodi Penyelenggara" placeholder="Prodi Penyelenggara" required />
                <x-input id="nama_peminjam" name="nama_peminjam" label="Nama Ketua LM" placeholder="Nama Lengkap Ketua LM" required />
                <x-input id="nim" name="nim" label="NIM Ketua LM" placeholder="NIM Ketua LM" required />

                {{-- Dynamic Inputs (Kegiatan) menggunakan AlpineJS --}}
                <div class="space-y-6 pt-6 border-t border-dashed border-slate-200">
                    <template x-for="(item, index) in kegiatans" :key="item.id">
                        <div class="relative bg-[#F8FAFC] p-6 rounded-2xl border border-slate-200 space-y-5 pt-8">
                            
                            {{-- Tombol Hapus (Muncul jika baris lebih dari 1) --}}
                            <button type="button" @click="removeKegiatan(item.id)" x-show="kegiatans.length > 1"
                                class="absolute top-3 right-3 p-1.5 text-rose-500 hover:bg-rose-100 rounded-lg transition-colors">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <div class="flex flex-col gap-2">
                                <label class="block text-xs font-bold text-judul uppercase tracking-wider">Nama Kegiatan</label>
                                <input type="text" x-bind:name="'kegiatan['+index+'][nama_kegiatan]'" placeholder="Nama Kegiatan (ex: Gladi Day-1)" required
                                    class="w-full bg-white border border-border-custom rounded-lg px-4 py-3 text-sm text-judul focus:outline-none focus:border-[#0A5C66]">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex flex-col gap-2">
                                    <label class="block text-xs font-bold text-judul uppercase tracking-wider">Hari Kegiatan</label>
                                    <input type="text" x-bind:name="'kegiatan['+index+'][hari]'" placeholder="Hari Kegiatan (ex: Kamis)" required
                                        class="w-full bg-white border border-border-custom rounded-lg px-4 py-3 text-sm text-judul focus:outline-none focus:border-[#0A5C66]">
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="block text-xs font-bold text-judul uppercase tracking-wider">Tanggal Kegiatan</label>
                                    <input type="date" x-bind:name="'kegiatan['+index+'][tanggal]'" required
                                        class="w-full bg-white border border-border-custom rounded-lg px-4 py-3 text-sm text-judul focus:outline-none focus:border-[#0A5C66]">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex flex-col gap-2">
                                    <label class="block text-xs font-bold text-judul uppercase tracking-wider">Waktu Mulai</label>
                                    <input type="text" x-bind:name="'kegiatan['+index+'][waktu_mulai]'" placeholder="Waktu Mulai (ex: 10.00)" required
                                        class="w-full bg-white border border-border-custom rounded-lg px-4 py-3 text-sm text-judul focus:outline-none focus:border-[#0A5C66]">
                                </div>
                                <div class="flex flex-col gap-2">
                                    <label class="block text-xs font-bold text-judul uppercase tracking-wider">Waktu Selesai</label>
                                    <input type="text" x-bind:name="'kegiatan['+index+'][waktu_selesai]'" placeholder="Waktu Selesai (ex: 19.00)" required
                                        class="w-full bg-white border border-border-custom rounded-lg px-4 py-3 text-sm text-judul focus:outline-none focus:border-[#0A5C66]">
                                </div>
                            </div>
                        </div>
                    </template>

                    {{-- Tombol Tambah Kegiatan --}}
                    <button type="button" @click="addKegiatan()"
                        class="w-full py-3.5 border-2 border-dashed border-slate-300 hover:border-[#0A5C66] rounded-xl flex justify-center items-center text-slate-400 hover:text-[#0A5C66] transition-colors bg-white shadow-sm">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- BOTTOM NAVIGATION (Sticky floating seperti di gambar) --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-4 flex items-center justify-between shadow-lg z-10">
            <x-button variant="secondary" href="{{ url()->previous() }}" type="button" class="!bg-white !text-slate-600 border border-slate-200 hover:!bg-slate-50 !text-sm !px-6 !py-2.5">
                Kembali
            </x-button>

            <button type="submit" class="px-6 py-2.5 bg-[#0A5C66] hover:bg-[#084952] text-white font-bold text-sm rounded-xl transition shadow-md">
                Kirim Peminjaman
            </button>
        </div>
    </form>
</div>

{{-- Skrip AlpineJS untuk Form Dinamis --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('kegiatanForm', () => ({
            kegiatans: [{ id: Date.now() }],
            
            addKegiatan() {
                this.kegiatans.push({ id: Date.now() });
            },
            
            removeKegiatan(id) {
                if (this.kegiatans.length > 1) {
                    this.kegiatans = this.kegiatans.filter(k => k.id !== id);
                }
            }
        }));
    });
</script>
@endsection