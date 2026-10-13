@extends('layouts.app')

@section('title','Tambah Inventaris')

@section('content')

<x-header-page title="Daftar Inventaris" :href="route('admin.inventaris.index')"></x-header-page>

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
    
        <form action="{{ route('admin.inventaris.store') }}" method="POST" enctype="multipart/form-data"
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

<<<<<<< HEAD
            <div class="p-8 space-y-6">
                
                <x-input id="nama" name="nama" label="Nama Barang" placeholder="Nama Barang" />
                @error('nama')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <x-select id="id_category" name="id_category" label="Kategori Barang" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    @foreach($categories as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                    @endforeach
                </x-select>
                @error('id_category')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror


                <x-input id="stok" name="stok_awal" type="number" label="Stok Barang" placeholder="Masukkan jumlah barang" required />
                @error('stok_awal')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <x-select id="status" name="status_stok" label="Status Barang" required>
                    <option value="" disabled selected>Pilih Status Barang</option>
                    <option value="1">Tersedia</option>
                    <option value="0">Tidak Tersedia</option>
                </x-select>
                @error('status_stok')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <div>
                    <label for="deskripsi" class="block text-xs font-bold text-judul uppercase tracking-wider mb-2">
                        Deskripsi Barang
                    </label>
                    <textarea 
                        id="deskripsi" 
                        name="deskripsi" 
                        rows="4" 
                        placeholder="Jelaskan kondisi fisik atau catatan tambahan lainnya." 
                        class="w-full px-4 py-3 bg-bg-dark/50 border border-border-custom rounded-lg text-sm text-subtext placeholder-subtext/60 focus:outline-none focus:border-primary focus:bg-white transition duration-200 resize-none"
                    ></textarea>
                </div>
                @error('deskripsi')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <div x-data="{ 
                    imageUrl: null, 
                    fileChosen(event) { 
                        const file = event.target.files[0]; 
                        if (file) { 
                            this.imageUrl = URL.createObjectURL(file); 
                        } 
                    } 
                }">
                    <label class="block text-xs font-bold text-judul uppercase tracking-wider mb-2">
                        Media Atau Foto Barang
                    </label>
                    
                    <div class="border-2 border-dashed border-border-custom rounded-xl p-8 flex flex-col items-center justify-center text-center bg-white/50 hover:bg-bg-dark/20 transition-colors relative overflow-hidden">
                        
    
                        <input type="file" id="image" name="image" x-ref="fileInput" accept="image/png, image/jpeg, image/jpg" class="hidden" @change="fileChosen">
                    
                        <div x-show="!imageUrl" class="flex flex-col items-center">
                            <div class="w-14 h-14 bg-[#EEF2FF] text-primary rounded-full flex items-center justify-center mb-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                            </div>
                            <p class="text-base font-bold text-judul">Pilih Foto Barang</p>
                            <p class="text-xs font-medium text-subtext mt-1 mb-4">Support format JPG, PNG up to 5MB</p>
                            
                            
                            <x-button type="button" @click="$refs.fileInput.click()" variant="primary">
                                Pilih File
                            </x-button>
=======
                {{-- Preview (awalnya disembunyikan) --}}
                <div id="preview-container" class="hidden mb-5">
                    <div class="flex justify-center">
                        <div class="w-72 h-72 overflow-hidden rounded-2xl border border-gray-200 bg-gray-100">
                            <img
                                id="preview-image"
                                src=""
                                class="w-full h-full object-cover"
                                alt="Preview">
>>>>>>> 2a23291e3805c43d8ff43e0f5dc4c3327be9ec25
                        </div>

                    
                        <div x-show="imageUrl" class="flex flex-col items-center w-full" style="display: none;">
                            <img :src="imageUrl" class="max-h-48 rounded-lg object-contain mb-4 border border-border-custom shadow-sm">
                            
                            <x-button type="button" @click="$refs.fileInput.click()" variant="primary">
                                Upload Ulang
                            </x-button>
                        </div>
                        @error('image')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
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