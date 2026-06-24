@props([
    'title'    => '',
    'owner'    => '',
    'category' => '',
    'status'   => ''
])

<div class="flex items-center p-4 pr-6 bg-white border border-border-custom rounded-[28px] gap-6 transition-shadow hover:shadow-md">
    
    {{-- 1. Icon Container --}}
    <div class="w-[84px] h-[84px] rounded-[24px] bg-bg-dark flex items-center justify-center shrink-0">
        {{-- Ikon Clipboard Centang --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-primary-hover" viewBox="0 0 61 63" fill="currentColor">
            <path d="M38.7612 58.6845L25.5824 45.5057L29.9237 41.1644L38.7612 50.002L56.2813 32.4819L60.6226 36.8232L38.7612 58.6845ZM55.8162 27.9081H49.6144V12.4036H43.4126V21.7063H12.4036V12.4036H6.2018V55.8162H24.8072V62.018H6.2018C4.4963 62.018 3.0363 61.4107 1.82178 60.1962C0.607259 58.9817 0 57.5217 0 55.8162V12.4036C0 10.6981 0.607259 9.23809 1.82178 8.02357C3.0363 6.80906 4.4963 6.2018 6.2018 6.2018H19.148C19.7165 4.39294 20.8277 2.90709 22.4815 1.74426C24.1353 0.581418 25.9442 0 27.9081 0C29.9754 0 31.823 0.581418 33.4509 1.74426C35.0789 2.90709 36.1772 4.39294 36.7456 6.2018H49.6144C51.3199 6.2018 52.7799 6.80906 53.9944 8.02357C55.2089 9.23809 55.8162 10.6981 55.8162 12.4036V27.9081ZM27.9081 12.4036C28.7867 12.4036 29.5231 12.1064 30.1175 11.5121C30.7118 10.9177 31.009 10.1813 31.009 9.30269C31.009 8.42411 30.7118 7.68764 30.1175 7.0933C29.5231 6.49897 28.7867 6.2018 27.9081 6.2018C27.0295 6.2018 26.293 6.49897 25.6987 7.0933C25.1044 7.68764 24.8072 8.42411 24.8072 9.30269C24.8072 10.1813 25.1044 10.9177 25.6987 11.5121C26.293 12.1064 27.0295 12.4036 27.9081 12.4036Z" />
        </svg>
    </div>

    {{-- 2. Info Content --}}
    <div class="flex flex-col flex-1 justify-center gap-1.5">
        <h3 class="text-3xl font-bold text-judul tracking-tight">{{ $title }}</h3>
        
        <div class="flex items-center gap-3">
            {{-- Badge Kepemilikan (Owner) --}}
            <span class="px-3 py-1.5 bg-[#F1F5F9] rounded-lg text-sm font-bold text-[#475569] tracking-wide">
                {{ $owner }}
            </span>
            
            {{-- Titik Pemisah & Kategori --}}
            <div class="flex items-center gap-2 text-subtext font-medium text-lg tracking-wide">
                <span class="w-1.5 h-1.5 rounded-full bg-[#94A3B8]"></span>
                {{ $category }}
            </div>
        </div>
    </div>

    {{-- 3. Status Badge --}}
    <div class="shrink-0">
        {{-- Memanggil komponen badge kuning yang sudah Anda miliki --}}
        {{-- Catatan: Sesuaikan nama props (seperti label/variant) dengan struktur komponen <x-badge> Anda --}}
        <x-badge label1="{{ $status }}" variant="yellow" />
    </div>
</div>