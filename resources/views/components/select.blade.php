@props(['name', 'label'])

<div>
    <label for="{{ $name }}" class="block text-xs font-bold text-judul uppercase tracking-wider mb-2">
        {{ $label }}
    </label>
    
    <select id="{{ $name }}" name="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full bg-bg-dark/50 border ' . ($errors->has($name) ? 'border-red-500' : 'border-border-custom') . ' rounded-lg px-4 py-3 text-sm text-judul focus:outline-none']) }}>
        
        {{ $slot }}
        
    </select>
</div>