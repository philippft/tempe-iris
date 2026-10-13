@extends('layouts.app')

@section('title', 'Edit Inventaris')

@section('content')

<x-header-page title="Edit Inventaris"></x-header-page>

<form
    action="{{ route('dekanat.inventaris.update', $inventaris) }}"
    method="POST"
    enctype="multipart/form-data"
    class="p-8 sm:px-6 space-y-8">

    @csrf
    @method('PUT')

    <div>
        <h2 class="text-3xl font-bold text-primary-hover">
            Edit Barang
        </h2>
        <p class="text-sm text-dark-grey font-medium mt-1">
            Perbarui informasi inventaris {{ $inventaris->nama }}
        </p>
    </div>

    {{-- FOTO --}}
    <div class="flex justify-center">
        <div class="w-96 overflow-hidden rounded-2xl bg-bg-dark border border-border-custom shadow-inner">

            @if($inventaris->image)
                <img
                    id="preview-image"
                    src="{{ asset($inventaris->image) }}"
                    class="w-full h-96 object-cover"
                    alt="{{ $inventaris->nama }}">
            @else
                <img
                    id="preview-image"
                    src="https://placehold.co/600x600?text=No+Image"
                    class="w-full h-96 object-cover"
                    alt="Preview">
            @endif

        </div>
    </div>

    {{-- INFORMASI --}}
    <div class="bg-white rounded-2xl border border-border-custom/50 p-6 space-y-6">

        <h2 class="text-2xl font-semibold text-primary-hover border-b border-border-custom pb-3">
            Informasi Barang
        </h2>

        {{-- Nama --}}
        <div>
            <label class="text-xs font-semibold uppercase text-dark-grey">
                Nama Barang
            </label>

            <input
                type="text"
                name="nama"
                value="{{ old('nama', $inventaris->nama) }}"
                class="mt-2 w-full rounded-xl border border-border-custom p-4">

            @error('nama')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Kategori --}}
        <div>
            <label class="text-xs font-semibold uppercase text-dark-grey">
                Kategori
            </label>

            <select
                name="id_category"
                class="mt-2 w-full rounded-xl border border-border-custom p-4">

                @foreach($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected(old('id_category', $inventaris->id_category) == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach

            </select>

            @error('id_category')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Stok --}}
        <div>
            <label class="text-xs font-semibold uppercase text-dark-grey">
                Total Stok Saat Ini
            </label>

            <input
                type="text"
                disabled
                value="{{ $inventaris->stocks->count() }} Pcs"
                class="mt-2 w-full rounded-xl border border-border-custom bg-slate-100 p-4">
        </div>

        {{-- Tambah stok --}}
        <div>
            <label class="text-xs font-semibold uppercase text-dark-grey">
                Tambah Stok
            </label>

            <input
                type="number"
                name="stok_awal"
                min="0"
                value="{{ old('stok_awal', 0) }}"
                class="mt-2 w-full rounded-xl border border-border-custom p-4">

            <p class="text-xs text-dark-grey mt-2">
                Isi jika ingin menambahkan stok baru.
            </p>

            @error('stok_awal')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="text-xs font-semibold uppercase text-dark-grey">
                Deskripsi
            </label>

            <textarea
                name="deskripsi"
                rows="5"
                class="mt-2 w-full rounded-xl border border-border-custom p-4"
                placeholder="Masukkan deskripsi inventaris...">{{ old('deskripsi', $inventaris->deskripsi) }}</textarea>

            @error('deskripsi')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Upload gambar --}}
        <div>
            <label class="text-xs font-semibold uppercase text-dark-grey">
                Ganti Foto
            </label>

            <input
                id="image"
                type="file"
                name="image"
                accept="image/*"
                class="mt-2 block w-full rounded-xl border border-border-custom p-3">

            <p class="text-xs text-dark-grey mt-2">
                Kosongkan jika tidak ingin mengganti gambar.
            </p>

            @error('image')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

    </div>

    {{-- BUTTON --}}
    <div class="flex justify-end gap-4">
        <a href="{{ route('dekanat.inventaris.show', $inventaris) }}" class="rounded-xl border border-border-custom px-8 py-3 font-semibold hover:bg-slate-100 transition">
            Batal
        </a>
        <div>
        <button
            type="submit"
            class="px-6 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white font-medium text-xl transition shadow-sm">
            Simpan Perubahan
        </button>
        </div>
    </div>

</form>

{{-- Preview gambar --}}
<script>
document.getElementById('image').addEventListener('change', function(e){

    const file = e.target.files[0];

    if(file){
        document.getElementById('preview-image').src = URL.createObjectURL(file);
    }

});
</script>

@endsection