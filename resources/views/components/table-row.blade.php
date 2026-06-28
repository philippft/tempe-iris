@aware([
    'cols' => []
])

@php
    $gridTemplate = implode(' ', $cols);
@endphp

<div
    class="grid *:min-w-0  *:px-4 *:py-6 *:text-left *:flex *:items-center *:text-base" style="grid-template-columns: {{ $gridTemplate }}">
    {{ $slot }}
</div>