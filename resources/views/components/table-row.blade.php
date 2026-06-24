@aware([
    'cols' => []
])

@php
    $gridTemplate = implode(' ', $cols);
@endphp

<div
    class="grid *:px-6 *:py-8 *:text-left *:flex *:items-center" style="grid-template-columns: {{ $gridTemplate }}">
    {{ $slot }}
</div>