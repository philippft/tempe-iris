@extends('layouts.app')

@section('title','Tambah Inventaris')

@section('content')

<x-header-page title="Daftar Inventaris" :href="route('dekanat.inventaris.index')"></x-header-page>

<div class="p-8 sm:px-6 space-y-8">
    <div class="flex items-center gap-4 mb-6">
        <h1 class="text-xl font-bold text-[#0B5C66]">Form Tambah Inventaris</h1>
    </div>
    
    <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white p-6 shadow-sm max-w-4xl">
        <div class="mb-6 border-b border-gray-100 pb-4">
            <h2 class="text-lg font-bold text-slate-800">Tambah Barang Inventaris</h2>
            <p class="text-xs text-slate-400 mt-1">Lengkapi formulir di bawah ini untuk melakukan penambahan barang
                inventaris.</p>
        </div>
    
        <form action="{{ route('dekanat.inventaris.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-5">
            @csrf
    
            <div>
                <label for="nama" class="block text-xs font-bold text-[#64748B] uppercase tracking-wider mb-2">Nama
                    Barang</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                    class="block w-full rounded-xl border border-gray-200 bg-[#F8FAFC] px-4 py-2.5 text-sm text-gray-900 focus:border-[#005B60] focus:ring-[#005B60] transition 
                    placeholder="Nama Barang" required>
                @error('nama')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
    
            <div>
                <label for="id_category"
                    class="block text-xs font-bold text-[#64748B] uppercase tracking-wider mb-2">Kategori
                    Barang</label>
                <select name="id_category" id="id_category"
                    class="block w-full rounded-xl border border-gray-200 bg-[#F8FAFC] px-4 py-2.5 text-sm text-gray-900 focus:border-[#005B60] focus:ring-[#005B60] transition"
                    required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('id_category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('id_category')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
    
            <div>
                <label for="stok_awal"
                    class="block text-xs font-bold text-[#64748B] uppercase tracking-wider mb-2">Stok Barang</label>
                <input type="number" name="stok_awal" id="stok_awal" value="{{ old('stok_awal') }}" min="1"
                    class="block w-full rounded-xl border border-gray-200 bg-[#F8FAFC] px-4 py-2.5 text-sm text-gray-900 focus:border-[#005B60] focus:ring-[#005B60] transition @error('stok_awal') border-red-500 @enderror"
                    placeholder="Masukkan jumlah barang" required>
                @error('stok_awal')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
    
            <div>
                <label for="status_stok"
                    class="block text-xs font-bold text-[#64748B] uppercase tracking-wider mb-2">Status
                    Barang</label>
                <select name="status_stok" id="status_stok"
                    class="block w-full rounded-xl border border-gray-200 bg-[#F8FAFC] px-4 py-2.5 text-sm text-gray-900 focus:border-[#005B60] focus:ring-[#005B60] transition @error('status_stok') border-red-500 @enderror"
                    required>
                    <option value="" disabled selected>Pilih Status Barang</option>
                    <option value="1" {{ old('status_stok') == '1' ? 'selected' : '' }}>Bagus (Aktif)</option>
                    <option value="0" {{ old('status_stok') == '0' ? 'selected' : '' }}>Rusak (Tidak Aktif)</option>
                </select>
                @error('status_stok')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
    
            <div>
                <label for="deskripsi"
                    class="block text-xs font-bold text-[#64748B] uppercase tracking-wider mb-2">Deskripsi
                    Barang</label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                    class="block w-full rounded-xl border border-gray-200 bg-[#F8FAFC] px-4 py-2.5 text-sm text-gray-900 focus:border-[#005B60] focus:ring-[#005B60] transition @error('deskripsi') border-red-500 @enderror"
                    placeholder="Jelaskan kondisi fisik atau catatan tambahan lainnya.">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
    
            <div>
                <label class="block text-xs font-bold text-[#64748B] uppercase tracking-wider mb-2">
                    Media atau Foto Barang
                </label>

                {{-- Preview (awalnya disembunyikan) --}}
                <div id="preview-container" class="hidden mb-5">
                    <div class="flex justify-center">
                        <div class="w-72 h-72 overflow-hidden rounded-2xl border border-gray-200 bg-gray-100">
                            <img
                                id="preview-image"
                                src=""
                                class="w-full h-full object-cover"
                                alt="Preview">
                        </div>
                    </div>
                </div>

                {{-- Upload --}}
                <div class="relative rounded-2xl border-2 border-dashed border-gray-200 p-8 text-center bg-[#F8FAFC] hover:bg-slate-50 transition">
                    <input
                        type="file"
                        name="image"
                        id="image"
                        accept="image/*"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        required>

                    <div class="space-y-2">
                        <div class="mx-auto h-10 w-10 text-indigo-500 bg-indigo-50 rounded-full flex items-center justify-center">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z"/>
                            </svg>
                        </div>

                        <div class="text-sm font-bold text-slate-700">
                            Pilih Foto Barang
                        </div>

                        <p class="text-xs text-slate-400">
                            Support format JPG, PNG hingga 5 MB
                        </p>

                        <span class="inline-flex mt-2 items-center rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-xs font-semibold text-gray-700 shadow-sm">
                            Pilih File
                        </span>
                    </div>
                </div>

                @error('image')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
    
            <div class="flex justify-end pt-4">
                <button type="submit"
                    class="rounded-xl bg-[#0B5C66] px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#00484C] transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0B5C66]">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
    </div>
</div>

<script>
const input = document.getElementById('image');
const preview = document.getElementById('preview-image');
const container = document.getElementById('preview-container');

input.addEventListener('change', function () {

    const file = this.files[0];

    if (!file) {
        container.classList.add('hidden');
        preview.src = "";
        return;
    }

    preview.src = URL.createObjectURL(file);
    container.classList.remove('hidden');

});
</script>

@endsection