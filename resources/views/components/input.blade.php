@props(['id', 'name', 'label', 'type' => 'text', 'placeholder' => ''])

<div>
    <label for="{{ $id }}" class="block text-xs font-bold text-judul uppercase tracking-wider mb-2">
        {{ $label }}
    </label>
    
    <input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}" placeholder="{{ $placeholder }}" 
        class="w-full px-4 py-3 bg-bg-dark/50 border border-border-custom rounded-lg text-sm text-subtext placeholder-subtext/60 focus:outline-none focus:border-primary focus:bg-white transition duration-200">
</div>