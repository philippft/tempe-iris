{{--
    Sidebar Partial - resources/views/partials/sidebar.blade.php
    Mendukung 4 role: admin_dekanat | admin_lm | mahasiswa | petinggi_dekanat
    Sesuaikan $user->role dengan field role di database kamu.
--}}

@php
    $user = Auth::user();
    $role = 'admin_lm'; //sesuaikan dengan field role di model User kamu

    // Subtitle per role
    $username = 'Leonardo';

    $subtitle = match($role) {
        'admin_dekanat'    => 'FMIPA – UNUD',
        'admin_lm'         => 'ADMIN PANEL',
        'mahasiswa'        => $user->nim ?? '',
        'petinggi_dekanat' => strtoupper($user->jabatan ?? 'WAKIL DEKAN'),
        default            => ''
    };

    // Menu per role
    $menus = [
        [
            'label'  => 'Dashboard',
            'route'  => 'dashboard',
            'roles'  => ['admin_dekanat', 'admin_lm', 'mahasiswa', 'petinggi_dekanat'],
            'icon'   => 'dashboard',
        ],
        [
            'label'  => 'Peminjaman',
            'route'  => 'peminjaman.index',
            'roles'  => ['admin_dekanat', 'admin_lm', 'mahasiswa'],
            'icon'   => 'transfer',
        ],
        [
            'label'  => 'Manajemen User',
            'route'  => 'manajemen-user.index',
            'roles'  => ['admin_lm'],
            'icon'   => 'users',
        ],
        [
            'label'  => 'Manajemen Inventaris',
            'route'  => 'manajemen-inventaris.index',
            'roles'  => ['admin_dekanat', 'admin_lm'],
            'icon'   => 'archive',
        ],
        [
            'label'  => 'Manajemen Surat',
            'route'  => 'manajemen-surat.index',
            'roles'  => ['admin_dekanat', 'admin_lm', 'mahasiswa', 'petinggi_dekanat'],
            'icon'   => 'document',
        ],
    ];
@endphp

<aside class="flex flex-col h-screen w-72 bg-[#EDF1F7] flex-shrink-0">

    {{-- ===================== HEADER ===================== --}}
    <div class="flex items-center justify-between px-5 pt-7 pb-5">
        <div class="flex items-center gap-3">
            {{-- Logo SIC --}}
            <img
                src="data:image/jpeg;base64,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" //{{ asset('images/image.png') }}
                alt="SIC Logo"
                class="w-14 h-14 rounded-full object-cover flex-shrink-0"
            >
            {{-- Nama & Subtitle --}}
            <div>
                <p class="font-extrabold text-[#1E293B] text-[15px] leading-tight tracking-wide uppercase">
                    {{ $username }}
                </p>
                <p class="text-[#64748B] text-[13px] font-medium mt-0.5 uppercase tracking-wide">
                    {{ $subtitle }}
                </p>
            </div>
        </div>

        {{-- Tombol Settings --}}
        <a
            href="#" 
            class="flex items-center justify-center w-11 h-11 bg-white rounded-xl shadow-sm flex-shrink-0 hover:bg-slate-50 transition-colors"
            title="Pengaturan"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#475569]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </a>
    </div>

    {{-- ===================== NAVIGASI ===================== --}}
    <nav class="flex-1 mt-3 overflow-y-auto">
        @foreach ($menus as $menu)
            @if (in_array($role, $menu['roles']))
                @php
                    $isActive = request()->routeIs($menu['route']) || request()->routeIs($menu['route'] . '.*');
                @endphp
                <a
                    href="#" 
                    class="flex items-center gap-4 px-6 py-[18px] relative transition-colors
                        {{ $isActive
                            ? 'bg-[#CDEAEA] text-[#1F6E6C] font-semibold border-r-[5px] border-[#1F6E6C]'
                            : 'text-[#475569] hover:bg-slate-200/60 font-medium'
                        }}"
                >
                    {{-- Icon --}}
                    <span class="w-6 h-6 flex-shrink-0 {{ $isActive ? 'text-[#1F6E6C]' : 'text-[#64748B]' }}">
                        @switch($menu['icon'])

                            @case('dashboard')
                                {{-- Grid 2x2 --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2" fill="none"/>
                                    <rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2" fill="none"/>
                                    <rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2" fill="none"/>
                                    <rect x="14" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2" fill="none"/>
                                </svg>
                                @break

                            @case('transfer')
                                {{-- Arrows left-right --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                                @break

                            @case('users')
                                {{-- People / Users --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                @break

                            @case('archive')
                                {{-- Archive / Box --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                @break

                            @case('document')
                                {{-- Document with lines --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                @break

                        @endswitch
                    </span>

                    {{-- Label --}}
                    <span class="text-[15px]">{{ $menu['label'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>

    {{-- ===================== TOMBOL KELUAR ===================== --}}
    <div class="px-5 pb-7">
        <form method="POST" action="#"
            @csrf
            <button
                type="submit"
                class="w-full flex items-center gap-3 px-5 py-4 rounded-2xl
                       border border-red-300 bg-[#BA1A1A]/10 text-[#BA1A1A] font-bold text-[15px]
                       hover:bg-red-100 transition-colors w-5 h-12"
            >
                {{-- Logout icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
            </button>
        </form>
    </div>

</aside>