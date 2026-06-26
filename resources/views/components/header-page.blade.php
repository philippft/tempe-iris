@props([
    'title', 
    'href' => url()->previous()
])

<div class="bg-white border-b border-slate-200 px-6 py-3 flex items-center gap-3">
    <a href="{{ $href }}" class="text-slate-600 hover:text-slate-900 transition">
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
    </a>
    <h1 class="text-sm font-bold text-[#0A5C66]">{{ $title }}</h1>
</div>