@extends('layouts.app')

@section('title','Detail Peminjaman Inventaris')

@section('content')

<x-header-page title="Peminjaman" :href="route('admin.peminjaman.index')" />

<div class="p-8 space-y-8">
    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h1 class="text-2xl font-extrabold text-judul">
                    Detail Peminjaman
                </h1>

                <x-badge
                    :status="is_null($surat->status_peminjaman)
                        ? 'pending'
                        : ($surat->status_peminjaman == 1 ? 'aktif' : 'ditolak')" />
            </div>

            <p class="text-sm text-dark-grey">
                ID Peminjaman : #{{ $surat->nomor }}
            </p>
        </div>

        <x-button
            href="{{ route('admin.preview.surat', $surat) }}"
            variant="tersier"
            class="flex items-center gap-2">

            <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M1 9C1 9 4.5 4 10 4C15.5 4 19 9 19 9C19 9 15.5 14 10 14C4.5 14 1 9 1 9ZM13 9C13 10.6569 11.6569 12 10 12C8.34315 12 7 10.6569 7 9C7 7.34315 8.34315 6 10 6C11.6569 6 13 7.34315 13 9Z"
                    fill="#095769"/>
            </svg>

            Lihat Surat
        </x-button>
    </div>

    {{-- INFORMASI PEMINJAM --}}
    <x-container>
        <div class="p-8">
            <h3 class="text-base font-bold text-judul mb-6">
                Informasi Peminjam
            </h3>

            <div class="grid grid-cols-3 gap-10">
                <div>
                    <p class="text-xs font-bold uppercase text-dark-grey tracking-wider">Nama Lengkap</p>
                    <h4 class="font-bold">{{ $surat->user->name }}</h4>
                </div>

                <div>
                    <p class="text-xs font-bold uppercase text-dark-grey tracking-wider">NIM</p>
                    <h4 class="font-bold">{{ $surat->user->nim_nip }}</h4>
                </div>

                <div>
                    <p class="text-xs font-bold uppercase text-dark-grey tracking-wider">Program Studi</p>
                    <h4 class="font-bold">
                        {{ $surat->user->organization?->name ?? '-' }}
                    </h4>
                </div>

                <div>
                    <p class="text-xs font-bold uppercase text-dark-grey tracking-wider">Nama Acara</p>
                    <h4 class="font-bold">{{ $surat->acara }}</h4>
                </div>
            </div>
        </div>
    </x-container>

    {{-- INFORMASI DOKUMEN --}}
    <x-container>
        <div class="p-8">
            <h3 class="text-base font-bold text-judul mb-6">
                Informasi Dokumen
            </h3>

            <div class="grid grid-cols-1 gap-5">

                <div>
                    <p class="text-xs font-bold uppercase text-dark-grey tracking-wider">Nomor Surat</p>
                    <h4 class="font-bold">{{ $surat->nomor }}</h4>
                </div>

                <div>
                    <p class="text-xs font-bold uppercase text-dark-grey tracking-wider">Tanggal Terbit</p>
                    <h4 class="font-bold">
                        {{ optional($surat->created_at)->format('d F Y') }}
                    </h4>
                </div>

                <div>
                    <p class="text-xs font-bold uppercase text-dark-grey tracking-wider">Perihal</p>
                    <h4 class="font-bold">{{ $surat->perihal_peminjaman }}</h4>
                </div>

            </div>
        </div>
    </x-container>

    {{-- JADWAL --}}
    <x-container>
        <div class="p-8">
            <h3 class="text-base font-bold text-judul mb-6">
                Jadwal Peminjaman
            </h3>

            <div class="grid grid-cols-2 gap-10">

                <div>
                    <p class="text-xs font-bold uppercase text-dark-grey tracking-wider">Tanggal Peminjaman</p>
                    <h4 class="font-bold text-lg">
                        {{ optional($surat->tanggal_peminjaman)?->translatedFormat('l, d F Y') ?? '-' }}
                    </h4>
                </div>

                <div>
                    <p class="text-xs font-bold uppercase text-dark-grey tracking-wider">Tanggal Pengembalian</p>
                    <h4 class="font-bold text-lg">
                        {{ optional($surat->tanggal_kembali)?->translatedFormat('l, d F Y') ?? '-' }}
                    </h4>
                </div>

            </div>
        </div>
    </x-container>

    {{-- DETAIL BARANG --}}
    <x-container>
        <div class="p-8">
            <h3 class="text-base font-bold text-judul mb-6">
                Detail Barang
            </h3>

            @foreach($surat->detailPeminjaman as $detail)
                <x-detail-item
                    :image="$detail->inventaris->gambar"
                    :name="$detail->inventaris->nama"
                    :category="$detail->inventaris->category->name"
                    :quantity="$detail->qty_inventaris"
                />
            @endforeach
        </div>
    </x-container>

    {{-- VERIFIKASI --}}
    @if($type === 'masuk' && is_null($surat->status_peminjaman))
        <x-container>
            <form action="{{ route('admin.peminjaman.verifikasi', $surat) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-8 space-y-6">

                    <div>
                        <label class="block text-xs font-bold uppercase text-dark-grey tracking-wider mb-3">
                            Catatan Verifikator (Opsional)
                        </label>

                        <textarea
                            name="catatan_peminjaman"
                            rows="4"
                            class="w-full rounded-xl border border-border-custom bg-[#F5F6FF] p-4 text-sm"
                        >{{ old('catatan_peminjaman') }}</textarea>
                    </div>

                    <div class="flex justify-between items-center border rounded-2xl p-3">

                        <p class="italic text-sm text-dark-grey">
                            Pastikan barang yang ingin dipinjam tersedia.
                        </p>

                        <div class="flex gap-3">

                            <button type="submit" name="status_peminjaman" value="0"
                                class="px-6 py-2.5 rounded-xl font-bold text-sm bg-white border border-red-500 text-red-500">
                                Tolak
                            </button>

                            <button type="submit" name="status_peminjaman" value="1"
                                class="px-6 py-2.5 rounded-xl font-bold text-sm bg-status-green text-white">
                                Setujui
                            </button>

                        </div>

                    </div>

                </div>
            </form>
        </x-container>
    @endif

</div>
@endsection