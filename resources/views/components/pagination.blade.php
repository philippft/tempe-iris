@props([
    'data'
])

@if ($data->hasPages())
<div class="flex items-center justify-between p-7">

    {{-- Info --}}
    <p class="text-base font-medium text-dark-grey">
        Menampilkan {{ $data->count() }} dari {{ $data->total() }} data
    </p>

    {{-- Pagination --}}
    <div class="flex items-center gap-4">
        {{-- Previous --}}
        <a href="{{ $data->previousPageUrl() }}" class="size-12 rounded-2xl border border-border-custom flex items-center justify-center shadow-2xl
            {{ $data->onFirstPage() ? 'opacity-40 pointer-events-none' : '' }}"
        >
            <svg class="size-6 text-dark-grey" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>

        {{-- Pages --}}
        @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
            @if ($page == $data->currentPage())
                <span class="size-12 rounded-2xl bg-primary text-white text-base font-bold flex items-center justify-center shadow-lg">
                    {{ $page }}
                </span>
            @else
                <a href="{{ $url }}" class="size-12 rounded-2xl flex items-center justify-center text-base font-bold text-dark-grey hover:bg-zinc-100">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        {{-- Next --}}
        <a href="{{ $data->nextPageUrl() }}" class="size-12 rounded-2xl border border-border-custom flex items-center justify-center shadow-2xl
            {{ !$data->hasMorePages() ? 'opacity-40 pointer-events-none' : '' }}"
        >
            <svg class="size-6 text-dark-grey" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</div>
@endif