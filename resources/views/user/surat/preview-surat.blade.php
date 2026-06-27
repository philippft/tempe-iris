@extends('layouts.app')

@section('title','Detail Surat Peminjaman')

@section('content')

<div class="p-8 space-y-8">
    <a href="{{ route('user.peminjaman.detail-surat', $surat) }}" class="font-extrabold text-primary-hover hover:underline transition text-4xl space-y-0!">
        ←
    </a>
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-5">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-5xl font-extrabold text-judul">
                        {{ strtoupper($surat->acara) }}
                    </h1>
                    <x-badge status="aktif"/>
                </div>
                <h3 class="text-2xl font-bold text-primary-hover">
                    Detail Surat Peminjaman
                </h3>
            </div>
        </div>

        <x-button href="{{ route('user.download.surat',$surat) }}" variant="tersier">
            Download Surat
        </x-button>
    </div>

    {{-- informasi dokumen --}}
    <x-container>
        <div class="p-8 ">
            <h3 class="font-bold text-primary-hover mb-8">
                Informasi Dokumen
            </h3>
            <div class="grid grid-cols-2 gap-10 text-sm">
                <div>
                    <p class="uppercase text-dark-grey">
                        Nomor Surat
                    </p>
                    <h4 class="font-bold">
                        {{ $surat->nomor }}
                    </h4>
                </div>
                <div>
                    <p class="uppercase text-dark-grey">
                        Tanggal Terbit
                    </p>
                    <h4 class="font-bold">
                        {{ $surat->created_at->translatedFormat('d F Y') }}
                    </h4>
                </div>
            </div>
            <div class="mt-6">
                <p class="uppercase text-dark-grey">
                    Perihal
                </p>
                <h4 class="font-bold">
                    {{ $surat->perihal_peminjaman }}
                </h4>
            </div>
            <div class="mt-6">
                <p class="uppercase text-dark-grey">
                    Tujuan
                </p>
                <h4 class="font-bold">
                    {{ $tujuan }}
                </h4>
            </div>
        </div>
    </x-container>

    {{-- preview surat --}}
    <x-container>
        <div>
            <div class="bg-primary-hover text-white px-6 py-4">
                <h3 class="font-bold text-2xl">
                    Preview Dokumen
                </h3>
            </div>

            <div class="bg-slate-50 p-10 flex justify-center">
                <div class="w-200 bg-white border shadow-lg p-14 text-[15px] leading-8">
                    <div class="flex justify-between">
                        <div>
                            <p>Nomor : {{ $surat->nomor }}</p>
                            <p>Lampiran : 1 (Satu)</p>
                            <p>Hal : {{ $surat->perihal_peminjaman }}</p>
                        </div>
                        <p>
                            {{ $surat->created_at->translatedFormat('d F Y') }}
                        </p>
                    </div>

                    <div class="mt-8">
                        <p>Yth.</p>
                        <p class="font-bold">{{ $tujuan }}</p>
                        <p>Universitas Udayana</p>
                        <p>di Jimbaran</p>
                    </div>

                    <div class="mt-6 text-justify">
                        <p>Dengan Hormat,</p>
                        <p class="mt-4">
                            Dalam rangka melaksanakan kegiatan <b>{{ $surat->acara }}</b>,
                            yang diselenggarakan oleh {{ $surat->user->organization->name }},
                            Fakultas MIPA Universitas Udayana, maka kami bermaksud untuk mengajukan Permohonan Peminjaman Inventaris
                            (terlampir).
                            Adapun kegiatan tersebut akan diselenggarakan pada: 
                        </p>
                    </div>
                    @foreach($detail_kegiatan as $kegiatan)
                        <div class="mt-6 ml-8">
                            <p class="font-semibold">
                                {{ $kegiatan['nama_kegiatan'] }}
                            </p>
                            <div class="grid grid-cols-[140px_1fr]">
                                <p>Hari, tanggal</p>
                                <p>
                                    : {{ $kegiatan['hari_mulai'] }},
                                    {{ $kegiatan['tanggal_kegiatan'] }}
                                </p>
                                <p>Waktu</p>
                                <p>
                                    : {{ $kegiatan['waktu_mulai'] }} - {{ $kegiatan['waktu_selesai'] }} WITA
                                </p>
                            </div>
                        </div>
                    @endforeach

                    <p class="mt-8 text-justify">
                        Demikian surat peminjaman ini kami sampaikan. Atas kerja sama dan dukungan yang diberikan, kami ucapkan terima kasih.
                    </p>

                    <div class="mt-16 flex justify-end">
                        <div class="text-center">
                            <p>Panitia Pelaksana</p>
                            <p>
                                {{ $surat->acara }}
                                ({{ $singkatanAcara }})
                            </p>
                            <div class="h-24"></div>
                            <p>
                                {{ $surat->user->organization->name }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-container>
</div>
@endsection