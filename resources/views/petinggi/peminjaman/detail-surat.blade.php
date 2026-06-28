@extends('layouts.app')

@section('title','Detail Peminjaman Inventaris')

@section('content')

<x-header-page title="Peminjaman" :href="route('petinggi.surat.index')" />

<div class="p-8 space-y-8">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h1 class="text-4xl font-extrabold text-primary-hover">
                    Detail Peminjaman
                </h1>

                <x-badge
                    :status="is_null($surat->status_peminjaman)
                        ? 'pending'
                        : ($surat->status_peminjaman == 1 ? 'aktif' : 'ditolak')" />
            </div>

            <p class="text-dark-grey">
                ID Peminjaman : #{{ $surat->nomor }}
            </p>
        </div>

        {{-- BUTTON --}}
        <x-button
            href="{{ route('petinggi.preview.surat', $surat) }}"
            variant="tersier"
            class="flex items-center gap-2">

            <svg width="20" height="18" viewBox="0 0 20 18" fill="none">
                <path d="M14 5V2H6V5H4V0H16V5H14ZM2 7C2 7 2.09583 7 2.2875 7C2.47917 7 2.71667 7 3 7H17C17.2833 7 17.5208 7 17.7125 7C17.9042 7 18 7 18 7H16H4H2ZM16 9.5C16.2833 9.5 16.5208 9.40417 16.7125 9.2125C16.9042 9.02083 17 8.78333 17 8.5C17 8.21667 16.9042 7.97917 16.7125 7.7875C16.5208 7.59583 16.2833 7.5 16 7.5C15.7167 7.5 15.4792 7.59583 15.2875 7.7875C15.0958 7.97917 15 8.21667 15 8.5C15 8.78333 15.0958 9.02083 15.2875 9.2125C15.4792 9.40417 15.7167 9.5 16 9.5Z"
                fill="#095769"/>
            </svg>

            Lihat Surat
        </x-button>
    </div>

    {{-- INFORMASI PEMINJAM --}}
    <x-container>
        <div class="p-8">
            <h3 class="font-bold text-primary-hover mb-6">
                Informasi Peminjam
            </h3>

            <div class="grid grid-cols-3 gap-10">
                <div>
                    <p class="text-xs uppercase text-dark-grey">Nama Lengkap</p>
                    <h4 class="font-bold">{{ $surat->user->name }}</h4>
                </div>

                <div>
                    <p class="text-xs uppercase text-dark-grey">NIM</p>
                    <h4 class="font-bold">{{ $surat->user->nim_nip }}</h4>
                </div>

                <div>
                    <p class="text-xs uppercase text-dark-grey">Program Studi</p>
                    <h4 class="font-bold">
                        {{ $surat->user->organization?->name }}
                    </h4>
                </div>

                <div>
                    <p class="text-xs uppercase text-dark-grey">Nama Acara</p>
                    <h4 class="font-bold">{{ $surat->acara }}</h4>
                </div>
            </div>
        </div>
    </x-container>

    {{-- INFORMASI DOKUMEN --}}
    <x-container>
        <div class="p-8">
            <h3 class="font-bold text-primary-hover mb-6">
                Informasi Dokumen
            </h3>

            <div class="grid grid-cols-1 gap-5">
                <div>
                    <p class="text-xs uppercase text-dark-grey">Nomor Surat</p>
                    <h4 class="font-bold">{{ $surat->nomor }}</h4>
                </div>

                <div>
                    <p class="text-xs uppercase text-dark-grey">Tanggal Terbit</p>
                    <h4 class="font-bold">
                        {{ $surat->created_at->format('d F Y') }}
                    </h4>
                </div>

                <div>
                    <p class="text-xs uppercase text-dark-grey">Perihal</p>
                    <h4 class="font-bold">{{ $surat->perihal_peminjaman }}</h4>
                </div>
            </div>
        </div>
    </x-container>

    {{-- JADWAL --}}
    <x-container>
        <div class="p-8">
            <h3 class="font-bold text-primary-hover mb-6">
                Jadwal Peminjaman
            </h3>

            <div class="grid grid-cols-2 gap-10">
                <div>
                    <p class="text-xs uppercase text-dark-grey">Tanggal Peminjaman</p>
                    <h4 class="font-bold text-2xl">
                        {{ $surat->tanggal_peminjaman->translatedFormat('l, d F Y') }}
                    </h4>
                </div>

                <div>
                    <p class="text-xs uppercase text-dark-grey">Tanggal Pengembalian</p>
                    <h4 class="font-bold text-2xl">
                        {{ $surat->tanggal_kembali->translatedFormat('l, d F Y') }}
                    </h4>
                </div>
            </div>
        </div>
    </x-container>

    {{-- DETAIL BARANG --}}
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

    {{-- VERIFIKASI PETINGGI --}}
    @if(is_null($surat->status_peminjaman))
        <x-container>
            <form action="{{ route('petinggi.peminjaman.verifikasi', $surat) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="p-8 space-y-6">

                    <div>
                        <label class="block font-bold text-dark-grey mb-3">
                            Catatan Verifikator (Opsional)
                        </label>

                        <textarea
                            name="catatan_peminjaman"
                            rows="4"
                            class="w-full rounded-xl border border-border-custom bg-[#F5F6FF] p-4">
                            {{ old('catatan_peminjaman') }}
                        </textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" name="status_peminjaman" value="0"
                            class="px-6 py-3 rounded-xl font-medium text-xl bg-white border border-red-500 text-red-500">
                            Tolak
                        </button>

                        <button type="submit" name="status_peminjaman" value="1"
                            class="px-6 py-3 rounded-xl font-medium text-xl bg-status-green text-white">
                            Setujui
                        </button>
                    </div>

                </div>
            </form>
        </x-container>
    @endif

</div>
@endsection