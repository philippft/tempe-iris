@props(['title', 'description'])

<div class="bg-bg-dark p-6 rounded-xl border border-gray-100 transition-all duration-300 ease-in-out hover:-translate-y-1 hover:shadow-md">
    <div class="bg-primary/10 w-10 h-10 rounded-lg flex items-center justify-center mb-4 text-primary shadow-sm">
        {{ $icon }}
    </div>
    
    <h3 class="font-bold text-judul mb-2 text-xl">{{ $title }}</h3>
    <p class="text-sm text-subtext leading-relaxed">{{ $description }}</p>
</div>