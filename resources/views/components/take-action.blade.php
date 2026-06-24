@props([
    'viewUrl' => '#',       
    'deleteAction' => null  
])

<div class="flex items-center gap-4">
    
    <x-action-button
        type="view" 
        as="a" 
        href="{{ $viewUrl }}" 
    />

    <x-action-button
        type="delete"  
        {{ $attributes }} 
    />

</div>