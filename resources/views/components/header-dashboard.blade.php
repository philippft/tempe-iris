@props([
    'title' => 'Dashboard',
    'subtitle' => 'Selamat Datang,',
    'username' => auth()->user()->username,
])

<div class="w-full flex justify-between items-start">
    <div>
        <h1 class="text-judul font-extrabold text-4xl pb-2">
            {{ $title }}
        </h1>
        <h2 class="text-dark-grey font-medium text-lg pb-4">
            {{ $subtitle }}
            <span class="text-judul text-lg font-bold">
                {{ $username }}
            </span>
        </h2>

        <x-badge label1="Status" label2="Aktif" />
    </div>

    <div class="bg-white rounded-2xl px-4 py-2 flex items-center gap-2 shadow-md max-w-fit">
        <img
            src="{{ auth()->user()->profile
                ? asset('storage/' . auth()->user()->profile)
                : asset('images/default-profile.png') }}"
            alt="Foto Profil"
            class="size-6 rounded-full outline-black object-cover"
        >
        <div class="text-left">
            <h3 class="text-judul text-base font-bold leading-tight">
                {{ auth()->user()->username }}
            </h3>
            <p class="text-dark-grey text-xs uppercase tracking-wide">
                {{ auth()->user()->prodi }}
            </p>
        </div>
    </div>
</div>