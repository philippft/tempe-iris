@props([
    'title',
    'value',
    'label' => '',
    'bg' => 'bg-white',
    'border' => 'border-l-primary',
    'iconBg' => 'bg-gray-100',
])

<div class="w-fit h-fit {{ $bg }} {{ $border }} border-l-8 rounded-4xl p-7 font-sans">
    <div class="flex justify-between items-center mb-4.5">
        <h2 class="text-base font-bold text-subtext">
            {{ $title }}
        </h2>
        <div class="{{ $iconBg }} p-2 rounded-lg">
            {{ $slot }}
        </div>
    </div>

    <div class="flex gap-2">
        <span class="text-4xl leading-none font-bold text-judul">
            {{ $value }}
        </span>

        @if($label)
            <span class="text-base font-semibold text-[#70787C] flex items-end">
                {{ $label }}
            </span>
        @endif
    </div>
</div>