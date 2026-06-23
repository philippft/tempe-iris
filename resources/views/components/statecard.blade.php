@props([
    'title',
    'value',
    'label' => '',
    'bg' => 'bg-white',
    'border' => 'border-l-primary',
    'iconBg' => 'bg-gray-100',
])

<div class="w-fit h-fit {{ $bg }} {{ $border }} border-l-8 rounded-4xl p-6 font-sans">
    <div class="flex justify-between items-center mb-3">
        <h2 class="text-[16px] font- text-subtext">
            {{ $title }}
        </h2>
        <div class="{{ $iconBg }} p-2 rounded-2xl">
            {{ $slot }}
        </div>
    </div>

    <div class="flex gap-3">
        <span class="text-4xl leading-none font-bold text-judul">
            {{ $value }}
        </span>

        @if($label)
            <span class="text-[16px] text-[#70787C] flex items-end">
                {{ $label }}
            </span>
        @endif
    </div>
</div>