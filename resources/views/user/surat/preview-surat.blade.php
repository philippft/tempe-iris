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
              <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 5V2H6V5H4V0H16V5H14ZM2 7C2 7 2.09583 7 2.2875 7C2.47917 7 2.71667 7 3 7H17C17.2833 7 17.5208 7 17.7125 7C17.9042 7 18 7 18 7H16H4H2ZM16 9.5C16.2833 9.5 16.5208 9.40417 16.7125 9.2125C16.9042 9.02083 17 8.78333 17 8.5C17 8.21667 16.9042 7.97917 16.7125 7.7875C16.5208 7.59583 16.2833 7.5 16 7.5C15.7167 7.5 15.4792 7.59583 15.2875 7.7875C15.0958 7.97917 15 8.21667 15 8.5C15 8.78333 15.0958 9.02083 15.2875 9.2125C15.4792 9.40417 15.7167 9.5 16 9.5ZM14 16V12H6V16H14ZM16 18H4V14H0V8C0 7.15 0.291667 6.4375 0.875 5.8625C1.45833 5.2875 2.16667 5 3 5H17C17.85 5 18.5625 5.2875 19.1375 5.8625C19.7125 6.4375 20 7.15 20 8V14H16V18ZM18 12V8C18 7.71667 17.9042 7.47917 17.7125 7.2875C17.5208 7.09583 17.2833 7 17 7H3C2.71667 7 2.47917 7.09583 2.2875 7.2875C2.09583 7.47917 2 7.71667 2 8V12H4V10H16V12H18Z" fill="#095769"/>
            </svg>
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
                    @foreach($surat->kegiatan as $kegiatan)
                    <tr>
                        <td>{{ $kegiatan->nama }}</td>
                        <td>{{ $kegiatan->hari_mulai }}</td>
                        <td>
                            {{ $kegiatan->tanggal_mulai
                                ? $kegiatan->tanggal_mulai->translatedFormat('d F Y')
                                : '-' }}
                        </td>

                        <td>
                            {{ $kegiatan->waktu_mulai
                                ? \Carbon\Carbon::parse($kegiatan->waktu_mulai)->format('H.i')
                                : '-' }}
                            {{ $kegiatan->waktu_selesai
                                ? \Carbon\Carbon::parse($kegiatan->waktu_selesai)->format('H.i')
                                : '-' }}
                        </td>
                    </tr>
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