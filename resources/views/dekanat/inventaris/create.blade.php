@extends('layouts.app')

@section('title', 'Tambah Inventaris')

@section('content')

<x-header-page title="Daftar Inventaris" :href="route('dekanat.inventaris.index')"></x-header-page>

<form action="{{ route('dekanat.inventaris.store') }}" method="POST" enctype="multipart/form-data">
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
                @error('deskripsi')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-judul uppercase tracking-wider mb-2">
                    Media atau Foto Barang
                </label>

                {{-- Input File Asli (Disembunyikan, dikendalikan via label/JS) --}}
                <input type="file" name="image" id="image" accept="image/*" class="hidden" required>

                {{-- Preview Area (Awalnya disembunyikan) --}}
                <div id="preview-container" class="hidden mb-5">
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-72 h-72 overflow-hidden rounded-2xl border border-gray-200 bg-gray-100 shadow-sm">
                            <img
                                id="preview-image"
                                src=""
                                class="w-full h-full object-cover"
                                alt="Preview">
                        </div>
                        
                        {{-- Tombol Pilih Ulang --}}
                        <button type="button" id="btn-reupload" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-xs font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition focus:outline-none">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Pilih Ulang Foto
                        </button>
                    </div>
                </div>

                {{-- Upload Area (Kotak putus-putus) --}}
                <div id="upload-area" class="relative rounded-2xl border-2 border-dashed border-border-custom p-8 text-center bg-[#F8FAFC] hover:bg-slate-50 transition cursor-pointer" onclick="document.getElementById('image').click()">
                    <div class="space-y-2 pointer-events-none">
                        <div class="mx-auto h-10 w-10 text-indigo-500 bg-indigo-50 rounded-full flex items-center justify-center">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z"/>
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
                <button type="submit" class="rounded-xl bg-[#0B5C66] px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-[#00484C] transition focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0B5C66]">
                    Simpan Data
                </button>
            </div>
            
        </div>
    </div>
</form>

<script>
    const input = document.getElementById('image');
    const previewImage = document.getElementById('preview-image');
    const previewContainer = document.getElementById('preview-container');
    const uploadArea = document.getElementById('upload-area');
    const btnReupload = document.getElementById('btn-reupload');

    // Trigger input file saat tombol "Pilih Ulang Foto" diklik
    btnReupload.addEventListener('click', function() {
        input.click();
    });

    input.addEventListener('change', function () {
        const file = this.files[0];

        // Jika user batal memilih (close window), kembalikan ke tampilan awal
        if (!file) {
            previewContainer.classList.add('hidden');
            uploadArea.classList.remove('hidden');
            previewImage.src = "";
            return;
        }

        // Tampilkan preview dan sembunyikan kotak upload awal
        previewImage.src = URL.createObjectURL(file);
        previewContainer.classList.remove('hidden');
        uploadArea.classList.add('hidden');
    });
</script>

@endsection