@props([
    'data'
])

@if ($data->hasPages())
<div class="flex items-center justify-between px-12 py-8">

    {{-- Info --}}
    <p class="text-[18px] font-medium text-subjudul">
        Menampilkan {{ $data->count() }} dari {{ $data->total() }} data
    </p>

    {{-- Pagination --}}
    <div class="flex items-center gap-4">
        {{-- Previous --}}
        <a href="{{ $data->previousPageUrl() }}" class="size-14 rounded-2xl border border-zinc-200 flex items-center justify-center
            {{ $data->onFirstPage() ? 'opacity-40 pointer-events-none' : '' }}"
        >
            <svg class="size-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>

        {{-- Pages --}}
        @foreach ($data->getUrlRange(1, $data->lastPage()) as $page => $url)
            @if ($page == $data->currentPage())
                <span class="size-16 rounded-2xl bg-primary text-white text-2xl font-bold flex items-center justify-center shadow-lg">
                    {{ $page }}
                </span>
            @else
                <a href="{{ $url }}" class="size-16 rounded-2xl flex items-center justify-center text-2xl font-bold text-zinc-700 hover:bg-zinc-100">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        {{-- Next --}}
        <a href="{{ $data->nextPageUrl() }}" class="size-14 rounded-2xl border border-zinc-200 flex items-center justify-center
            {{ !$data->hasMorePages() ? 'opacity-40 pointer-events-none' : '' }}"
        >
            <svg class="size-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</div>
@endif