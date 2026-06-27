@extends('layouts.app')

@section('title','Detail Peminjaman Inventaris')

@section('content')

<div class="p-8 space-y-8">
     <a href="{{ route('user.peminjaman.index') }}" class="font-extrabold text-primary-hover hover:underline transition text-4xl space-y-0!">
        ←
    </a>
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h1 class="text-4xl font-extrabold text-primary-hover">
                    Detail Peminjaman Masuk
                </h1>
                <x-badge :status="$surat->status_peminjaman ? 'aktif' : 'pending'"/>
            </div>
            <p class="text-dark-grey">
                ID Peminjaman :
                #{{ $surat->nomor }}
            </p>
        </div>

        <x-button href="{{ route('user.surat.review.surat',$surat) }}" variant="tersier" class="flex items-center gap-2">
            <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 5V2H6V5H4V0H16V5H14ZM2 7C2 7 2.09583 7 2.2875 7C2.47917 7 2.71667 7 3 7H17C17.2833 7 17.5208 7 17.7125 7C17.9042 7 18 7 18 7H16H4H2ZM16 9.5C16.2833 9.5 16.5208 9.40417 16.7125 9.2125C16.9042 9.02083 17 8.78333 17 8.5C17 8.21667 16.9042 7.97917 16.7125 7.7875C16.5208 7.59583 16.2833 7.5 16 7.5C15.7167 7.5 15.4792 7.59583 15.2875 7.7875C15.0958 7.97917 15 8.21667 15 8.5C15 8.78333 15.0958 9.02083 15.2875 9.2125C15.4792 9.40417 15.7167 9.5 16 9.5ZM14 16V12H6V16H14ZM16 18H4V14H0V8C0 7.15 0.291667 6.4375 0.875 5.8625C1.45833 5.2875 2.16667 5 3 5H17C17.85 5 18.5625 5.2875 19.1375 5.8625C19.7125 6.4375 20 7.15 20 8V14H16V18ZM18 12V8C18 7.71667 17.9042 7.47917 17.7125 7.2875C17.5208 7.09583 17.2833 7 17 7H3C2.71667 7 2.47917 7.09583 2.2875 7.2875C2.09583 7.47917 2 7.71667 2 8V12H4V10H16V12H18Z" fill="#095769"/>
            </svg>
            Lihat Surat
        </x-button>
    </div>

    {{-- Informasi Peminjam --}}
    <x-container>
        <div class="p-8">
            <h3 class="font-bold text-primary-hover mb-6">
                Informasi Peminjam
            </h3>
            <div class="grid grid-cols-3 gap-10">
                <div>
                    <p class="text-xs uppercase text-dark-grey">
                        Nama Lengkap
                    </p>
                    <h4 class="font-bold">
                        {{ $surat->user->name }}
                    </h4>
                </div>
                <div>
                    <p class="text-xs uppercase text-dark-grey">
                        NIM
                    </p>
                    <h4 class="font-bold">
                        {{ $surat->user->nim_nip }}
                    </h4>
                </div>
                <div>
                    <p class="text-xs uppercase text-dark-grey">
                        Program Studi
                    </p>
                    <h4 class="font-bold">
                        {{ $surat->user->organization?->name }}
                    </h4>
                </div>
                <div>
                    <p class="text-xs uppercase text-dark-grey">
                        Nama Acara
                    </p>
                    <h4 class="font-bold">
                        {{ $surat->acara }}
                    </h4>
                </div>
            </div>
        </div>
    </x-container>

    {{-- Informasi Dokumen --}}
    <x-container>
        <div class="p-8">
            <h3 class="font-bold text-primary-hover mb-6">
                Informasi Dokumen
            </h3>

            <div class="grid grid-cols-1 gap-5">
                <div>
                    <p class="text-xs uppercase text-dark-grey">
                        Nomor Surat
                    </p>
                    <h4 class="font-bold">
                        {{ $surat->nomor }}
                    </h4>
                </div>
                <div>
                    <p class="text-xs uppercase text-dark-grey">
                        Tanggal Terbit
                    </p>
                    <h4 class="font-bold">
                        {{ $surat->created_at->format('d F Y') }}
                    </h4>
                </div>
                <div>
                    <p class="text-xs uppercase text-dark-grey">
                        Perihal
                    </p>
                    <h4 class="font-bold">
                        {{ $surat->perihal_peminjaman }}
                    </h4>
                </div>
            </div>
        </div>
    </x-container>


    {{-- Jadwal --}}
    <x-container>
        <div class="p-8">
            <h3 class="font-bold text-primary-hover mb-6">
                Jadwal Peminjaman
            </h3>
            <div class="grid grid-cols-2 gap-10">
                <div>
                    <p class="text-xs uppercase text-dark-grey">
                        Tanggal Peminjaman
                    </p>
                    <h4 class="font-bold text-2xl">
                        {{ $surat->tanggal_peminjaman->translatedFormat('l, d F Y') }}
                    </h4>
                </div>

                <div>
                    <p class="text-xs uppercase text-dark-grey">
                        Tanggal Pengembalian
                    </p>
                    <h4 class="font-bold text-2xl">
                        {{ $surat->tanggal_kembali->translatedFormat('l, d F Y') }}
                    </h4>
                </div>
            </div>
        </div>
    </x-container>

    {{-- Detail Barang --}}
    <x-container>
        <div class="p-8">
            <h3 class="font-bold text-primary-hover mb-6">
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
</div>
@endsection


{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="{{ route('user.download.surat', $surat->id) }}"
        class="inline-block px-3 py-1.5 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition text-xs shadow-sm">
        Cetak PDF
    </a>
</body>
</html> --}}