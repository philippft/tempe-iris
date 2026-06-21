{{--
    Sidebar Partial - resources/views/partials/sidebar.blade.php
    Mendukung 4 role: admin_dekanat | admin_lm | mahasiswa | petinggi_dekanat
    Sesuaikan $user->role dengan field role di database kamu.
--}}

@php
    $user = Auth::user();
    $role = $user->role ?? 'mahasiswa'; //sesuaikan dengan field role di model User kamu

    // Subtitle per role
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
                src="{{ asset('images/image.png') }}"
                alt="SIC Logo"
                class="w-14 h-14 rounded-full object-cover flex-shrink-0"
            >
            {{-- Nama & Subtitle --}}
            <div>
                <p class="font-extrabold text-[#1E293B] text-[15px] leading-tight tracking-wide uppercase">
                    {{ $user->name }}
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
    <div class="px-5 pb-7 pt-4">
        <form method="POST" action="#"
            @csrf
            <button
                type="submit"
                class="w-full flex items-center justify-center gap-3 px-5 py-4 rounded-2xl
                       border border-red-300 bg-red-50 text-red-500 font-bold text-[15px]
                       hover:bg-red-100 transition-colors"
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