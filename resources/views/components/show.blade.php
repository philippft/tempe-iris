@props([
    'id' => null, 
    'name', 
    'label', 
    'type' => 'text', 
    'value' => '', 
    'isReadonly' => false // Tambahkan properti ini (default: false / bisa diketik)
])

<div>
    <label for="{{ $id }}" class="block text-xs font-bold text-judul uppercase tracking-wider mb-2">
        {{ $label }}
    </label>
    
    <input 
        type="{{ $type }}" 
        id="{{ $id }}" 
        name="{{ $name }}" 
        value="{{ $value ?? '' }}"
        
        {{-- Jika isReadonly true, tambahkan atribut readonly --}}
        {{ $isReadonly ? 'readonly' : '' }}
        
        {{-- Logika Tailwind: Ganti warna background dan hilangkan focus jika readonly --}}
        class="w-full px-4 py-3 border border-border-custom rounded-lg text-sm text-subtext placeholder-subtext/60 transition duration-200 outline-none
        {{ $isReadonly 
            ? 'bg-bg-dark/50 cursor-default opacity-80' 
            : 'bg-white focus:border-primary focus:ring-1 focus:ring-primary' 
        }}"
    >
</div>