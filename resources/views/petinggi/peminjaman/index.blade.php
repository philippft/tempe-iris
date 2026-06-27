@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<x-header-dashboard />

<x-container>
    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold m-4 mb-1 pt-5">Surat Masuk</h1>
            <p class="ml-4 mt-0 text-gray-600">Daftar Surat Peminjaman Inventaris</p>
        </div>

        <div class="flex justify-end items-center pr-4 pt-5">
            <button
                class="flex items-center gap-2 px-3 py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" />
                </svg>
            </button>
        </div>
    </div>
        <hr>
    <div class="m-5">
        <x-search-bar></x-search-bar>
    </div>
        <div class="">
            <x-table
                :headers="['No', 'Nomor Surat', 'Perihal', 'Nama Kegiatan', 'Tanggal Kirim', 'Status', 'Aksi']"
                :cols="['60px', '0.5fr', '0.5fr', '0.5fr', '0.5fr', '0.5fr', '180px']"
                :data="$surats"
                headerBg="bg-primary-hover/10"
                headerClass="text-primary font-bold text-sm uppercase"
                bg="bg-white overflow-hidden">
                @foreach($surats as $surat)
                <x-table-row>
                    <div>{{ $loop->iteration }}</div>
                    <div class="font-bold justify-start">
                        {{ $surat->nomor }}
                    </div>
                    <div class="justify-start">
                        {{ $surat->perihal_peminjaman }}
                    </div>
                    <div class="justify-center">
                        {{ $surat->nama_kegiatan }}
                    </div>
                    <div class="justify-center">
                        {{ $surat->tanggal_peminjaman->format('d M Y') }}
                    </div>
                    <div class="justify-center">
                        <x-status-card :status="$surat->status_peminjaman" />
                    </div>
                    <div class="flex justify-center items-center gap-3">
                        <x-action-button
                            type="view"
                            as="a"
                            :href="route('petinggi.surat.show', $surat)"
                        />

                        <x-action-button
                            type="delete"
                            as="a"
                            :href="route('petinggi.surat.show', $surat)"
                        />
                    </div>
                </x-table-row>
                @endforeach
            </x-table>
        </div>
    </div>
</x-container>

@endsection