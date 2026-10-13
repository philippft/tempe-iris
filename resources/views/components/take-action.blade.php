@props([
    'viewUrl' => '#',
    'showView' => true,
    'showDelete' => true,
])

<div class="flex items-center gap-4">

    @if($showView)
        <x-action-button
            type="view"
            as="a"
            href="{{ $viewUrl }}"
        />
    @endif

    @if($showDelete)
        <x-action-button
            type="delete"
            {{ $attributes }}
        />
    @endif
</div>