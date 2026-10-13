@props([
    'placeholder' => 'Cari ID atau nama barang...', 
    'name' => 'search',                           
    'showFilter' => true,
    'filterOptions' => [] 
])

<div x-data="{ openFilter: false }" class="relative flex items-center gap-3 w-full">
    
    <div class="relative flex-1">
        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
            <svg class="w-6 h-6 text-dark-grey" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <input
            type="text"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            value="{{ request($name) }}"
            {{ $attributes->merge(['class' => 'block w-full py-4 pl-12 pr-4 text-dark-grey font-sans bg-[#F2F3FF] border border-transparent rounded-xl focus:ring-2 focus:ring-[#0E5C66] focus:border-transparent focus:outline-none placeholder-gray-500 sm:text-base transition-shadow']) }}
        >
    </div>

    @if($showFilter)
        <div class="relative">
            <button 
                type="button" 
                @click="openFilter = !openFilter"
                class="flex items-center justify-center gap-2 px-8 py-4 text-white bg-[#0C5C66] rounded-xl hover:bg-[#0a4d55] active:bg-[#083b42] transition-colors shrink-0 font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0C5C66]"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M7 12h10M10 18h4"></path>
                </svg>
                Filter
            </button>

            <div 
                x-show="openFilter" 
                @click.away="openFilter = false"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2 w-56 origin-top-right rounded-xl bg-white border border-gray-100 shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none z-50 overflow-hidden"
                style="display: none;"
            >
                <div class="py-1 divide-y divide-gray-100">
                    @if(!empty($filterOptions))
                        @foreach($filterOptions as $value => $label)
                            <button type="submit" name="sort" value="{{ $value }}" class="w-full text-left block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                {{ $label }}
                            </button>
                        @endforeach
                    @else
                        <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Urutkan Berdasarkan</div>
                        <button type="button" class="w-full text-left block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">Terbaru</button>
                        <button type="button" class="w-full text-left block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">Terlama</button>
                        
                        <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase tracking-wider border-t border-gray-100">Status Stok</div>
                        <button type="button" class="w-full text-left block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">Stok Tersedia</button>
                        <button type="button" class="w-full text-left block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors">Stok Habis</button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>