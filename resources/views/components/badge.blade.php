@props([
    'label1' => 'Tersedia', // Teks bagian kiri
    'label2' => '0',        // Teks atau angka bagian kanan
])

<div {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 px-4 py-1.5 bg-[#E6F8F0] border border-[#BDE8D6] rounded-full']) }}>
    
    <span class="w-2.5 h-2.5 bg-[#0C7351] rounded-full"></span>
    
    <span class="text-sm font-bold text-[#0C7351] tracking-wide">
        {{ $label1 }}: {{ $label2 }}
    </span>

</div>