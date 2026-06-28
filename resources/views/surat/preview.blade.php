@extends('layouts.app')

@section('title', 'Detail Surat Peminjaman')

@section('content')

@php
    $role = auth()->user()->role;

    switch ($role) {
        case 'mahasiswa':
            $backRoute = route('user.peminjaman.detail-surat', $surat);
            $downloadRoute = route('user.download.surat', $surat);
            break;

        case 'admin_LM':
            $backRoute = route('admin.peminjaman.detail-surat', $surat);
            $downloadRoute = route('admin.download.surat', $surat);
            break;

        case 'admin_dekanat':
            $backRoute = route('dekanat.peminjaman.detail-surat', $surat);
            $downloadRoute = route('dekanat.download.surat', $surat);
            break;

        case 'petinggi_dekanat':
            $backRoute = route('petinggi.peminjaman.detail-surat', $surat);
            $downloadRoute = route('petinggi.surat.download', $surat);
            break;

        default:
            $backRoute = '#';
            $downloadRoute = '#';
    }
@endphp

<x-header-page
    title="Peminjaman"
    :href="$backRoute"
/>

<div class="p-8 space-y-8">

    {{-- Header --}}
    <div class="flex justify-between items-center">

        <div>
            <div class="flex items-center gap-3">

                <h1 class="text-5xl font-extrabold text-judul">
                    {{ strtoupper($surat->acara) }}
                </h1>

                <x-badge
                    :status="is_null($surat->status_peminjaman)
                        ? 'pending'
                        : ($surat->status_peminjaman == 1 ? 'aktif' : 'ditolak')"
                />

            </div>

            <h3 class="text-2xl font-bold text-primary-hover">
                Detail Surat Peminjaman
            </h3>
        </div>

        <x-button
            :href="$downloadRoute"
            variant="tersier"
        >
            <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 5V2H6V5H4V0H16V5H14ZM2 7C2 7 2.09583 7 2.2875 7C2.47917 7 2.71667 7 3 7H17C17.2833 7 17.5208 7 17.7125 7C17.9042 7 18 7 18 7H16H4H2ZM16 9.5C16.2833 9.5 16.5208 9.40417 16.7125 9.2125C16.9042 9.02083 17 8.78333 17 8.5C17 8.21667 16.9042 7.97917 16.7125 7.7875C16.5208 7.59583 16.2833 7.5 16 7.5C15.7167 7.5 15.4792 7.59583 15.2875 7.7875C15.0958 7.97917 15 8.21667 15 8.5C15 8.78333 15.0958 9.02083 15.2875 9.2125C15.4792 9.40417 15.7167 9.5 16 9.5ZM14 16V12H6V16H14ZM16 18H4V14H0V8C0 7.15 0.291667 6.4375 0.875 5.8625C1.45833 5.2875 2.16667 5 3 5H17C17.85 5 18.5625 5.2875 19.1375 5.8625C19.7125 6.4375 20 7.15 20 8V14H16V18ZM18 12V8C18 7.71667 17.9042 7.47917 17.7125 7.2875C17.5208 7.09583 17.2833 7 17 7H3C2.71667 7 2.47917 7.09583 2.2875 7.2875C2.09583 7.47917 2 7.71667 2 8V12H4V10H16V12H18Z" fill="#095769"/>
            </svg>

            Download Surat
        </x-button>

    </div>

    {{-- Informasi Dokumen --}}
    <x-container>

        <div class="p-8">

            <h3 class="font-bold text-primary-hover mb-8">
                Informasi Dokumen
            </h3>

            <div class="grid grid-cols-2 gap-10">

                <div>
                    <p class="uppercase text-dark-grey text-sm">
                        Nomor Surat
                    </p>

                    <h4 class="font-bold">
                        {{ $surat->nomor }}
                    </h4>
                </div>

                <div>
                    <p class="uppercase text-dark-grey text-sm">
                        Tanggal Terbit
                    </p>

                    <h4 class="font-bold">
                        {{ $surat->created_at->translatedFormat('d F Y') }}
                    </h4>
                </div>

            </div>

            <div class="mt-6">
                <p class="uppercase text-dark-grey text-sm">
                    Perihal
                </p>

                <h4 class="font-bold">
                    {{ $surat->perihal_peminjaman }}
                </h4>
            </div>

            <div class="mt-6">
                <p class="uppercase text-dark-grey text-sm">
                    Tujuan
                </p>

                <h4 class="font-bold">
                    {{ $tujuan }}
                </h4>
            </div>

        </div>

    </x-container>

    {{-- Preview Surat --}}
    <x-container>

        <div class="bg-primary-hover text-white px-6 py-4 rounded-t-xl">
            <h3 class="font-bold text-2xl">
                Preview Dokumen
            </h3>
        </div>

        @include('shared.preview-detail')

    </x-container>

</div>

@endsection