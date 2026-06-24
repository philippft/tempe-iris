@aware([
    'cols' => []
])

@php
    $gridTemplate = implode(' ', $cols);
@endphp

<div
    class="grid border-b border-primary-50 *:px-6 *:py-8 *:text-left *:flex *:items-center *:justify-start" style="grid-template-columns: {{ $gridTemplate }}">
    {{ $slot }}
</div>