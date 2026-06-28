@extends('layouts.app')

@section('title', 'Tambah Inventaris') 

@section('content')

<div class="flex flex-col">
    <x-header-page title="Form Tambah Inventaris"></x-header-page>

    <form action="{{ route('admin.inventaris.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white rounded-[24px] m-6 border border-border-custom shadow-sm overflow-hidden flex flex-col">
            
            <div class="bg-[#F8FAFC] px-8 py-6 border-b border-border-custom">
                <h2 class="text-xl font-bold text-bg-primary-dark text-judul">Tambah Barang Inventaris</h2>
                <p class="text-sm font-medium text-subtext mt-1">Lengkapi formulir di bawah ini untuk melakukan penambahan barang inventaris.</p>
            </div>

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

            </div>

            
            <div class="px-8 py-5 border-t border-border-custom flex justify-end bg-white">
                
                <button type="submit" class="px-8 py-3 bg-primary hover:bg-primary-hover text-white font-medium text-base rounded-xl transition-colors shadow-sm">
                    Simpan Data
                </button>
            </div>
            
        </div>
    </form>
</div>
@endsection