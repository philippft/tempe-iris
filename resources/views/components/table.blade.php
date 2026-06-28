@props([
    'headers' => [],
    'cols' => [],
    'data' => null,

    'bg' => 'bg-white',
    'headerBg' => 'bg-primary',
    'headerClass' => 'text-white font-bold text-2xl',
])

@php
    $gridTemplate = empty($cols)
        ? implode(' ', array_fill(0, count($headers), '1fr'))
        : implode(' ', $cols);
@endphp

<div {{ $attributes->merge(['class' => $bg ]) }}>
    {{-- Header --}}
    <div class="grid {{ $headerBg }}" style="grid-template-columns: {{ $gridTemplate }}">
        @foreach($headers as $header)
            <div class="py-7 text-center {{ $headerClass }}">
                {{ strtoupper($header) }}
            </div>
        @endforeach
    </div>

    {{-- Body --}}
    {{ $slot }}

    {{-- pagination --}}
    @if($data instanceof \Illuminate\Contracts\Pagination\Paginator)
        <x-pagination :data="$data"/>
    @endif
</div>