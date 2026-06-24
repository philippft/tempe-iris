@php
$user = auth()->user();

if (!$user) return;

$role = $user->role;
$name = $user->username;
$identifier = $user->NIM_NIP;

$subtitle = match($role) {
    'admin_dekanat'    => $identifier,
    'admin_LM'         => $identifier,
    'mahasiswa'        => $identifier,
    'petinggi_dekanat' => strtoupper($identifier),
    default            => '',
};

$menus = match($role) {
    'mahasiswa' => [
        ['label'=>'Dashboard','route'=>'mahasiswa.dashboard','icon'=>'dashboard'],
        ['label'=>'Peminjaman','route'=>'mahasiswa.peminjaman.index','icon'=>'transfer'],
    ],

    'admin_LM' => [
        ['label'=>'Dashboard','route'=>'admin.dashboard','icon'=>'dashboard'],
        ['label'=>'Peminjaman','route'=>'admin.peminjaman.index','icon'=>'transfer'],
        ['label'=>'Manajemen User','route'=>'admin.management.user','icon'=>'users'],
        ['label'=>'Manajemen Inventaris','route'=>'admin.inventaris.index','icon'=>'archive'],
    ],

    'admin_dekanat' => [
        ['label'=>'Dashboard','route'=>'dekanat.dashboard','icon'=>'dashboard'],
        ['label'=>'Peminjaman','route'=>'dekanat.peminjaman.index','icon'=>'transfer'],
        ['label'=>'Manajemen Inventaris','route'=>'dekanat.inventaris.index','icon'=>'archive'],
    ],

    'petinggi_dekanat' => [
        ['label'=>'Dashboard','route'=>'petinggi.dashboard','icon'=>'dashboard'],
        ['label'=>'Manajemen Surat','route'=>'petinggi.surat.index','icon'=>'document'],
    ],

    default => [],
};
@endphp

<aside class="flex flex-col h-screen w-70 bg-[#F4F5F9] shrink-0 border-r border-gray-200">

    {{-- ===================== HEADER ===================== --}}
    <div class="flex items-center justify-between px-8.5 py-8">
        <div class="flex items-center gap-3">
            {{-- Nama & Subtitle --}}
            <div class="flex flex-col justify-center">
                <p class="font-bold text-[#051F20] text-[16px] leading-tight tracking-wide uppercase">
                    {{ $name }}
                </p>
                <p class="text-[#64748B] text-[13px] font-medium mt-0.5 uppercase tracking-wide">
                    {{ $subtitle }}
                </p>
            </div>
        </div>

        {{-- Tombol Settings --}}
        @if ($role === 'mahasiswa')
            <a
                href="#" 
                class="flex items-center justify-center w-9.5 h-9.5 bg-[#E2E8F0]/70 rounded-xl flex-shrink-0 hover:bg-gray-200 transition-colors ml-2"
                title="Pengaturan"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#475569]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </a>
        @endif
    </div>

    {{-- ===================== NAVIGASI ===================== --}}
    <nav class="flex-1 mt-2 overflow-y-auto">
        @foreach ($menus as $menu)
            @php
                $active = request()->routeIs($menu['route']);
            @endphp
            {{-- Tambahkan class 'group' untuk mentrigger perubahan pada elemen di dalamnya saat di-hover --}}
            <a
                href="{{ route($menu['route']) }}"
                class="group flex items-center gap-4 px-8 py-4 relative transition-all duration-200
                    {{ $active
                        ? 'bg-[#E3EAEB] text-primary-hover font-bold border-r-4 border-primary-hover'
                        : 'text-[#475569] hover:bg-[#E3EAEB]/40 hover:text-primary-hover font-medium'
                    }}"
            >
                {{-- Icon --}}
                {{-- Gunakan 'group-hover:text-primary-hover' agar ikon otomatis berubah warna saat baris menu di-hover --}}
                <span class="w-6 h-6 shrink-0 transition-colors duration-200 
                    {{ $active ? 'text-primary-hover' : 'text-[#64748B] group-hover:text-primary-hover' }}">
                    
                    @switch($menu['icon'])
                        @case('dashboard')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2" fill="none"/>
                                <rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2" fill="none"/>
                                <rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2" fill="none"/>
                                <rect x="14" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="2" fill="none"/>
                            </svg>
                            @break

                        @case('transfer')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            @break

                        @case('users')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 59 43" fill="currentColor">
                                <path d="M0 42.5266V35.0844C0 33.5783 0.387612 32.194 1.16284 30.9315C1.93806 29.669 2.968 28.7055 4.25266 28.041C6.99917 26.6677 9.78998 25.6378 12.6251 24.9512C15.4602 24.2645 18.3396 23.9212 21.2633 23.9212C24.187 23.9212 27.0664 24.2645 29.9015 24.9512C32.7366 25.6378 35.5274 26.6677 38.2739 28.041C39.5586 28.7055 40.5885 29.669 41.3638 30.9315C42.139 32.194 42.5266 33.5783 42.5266 35.0844V42.5266H0ZM47.8424 42.5266V34.5529C47.8424 32.6037 47.2998 30.7321 46.2145 28.938C45.1291 27.1439 43.5898 25.6046 41.5963 24.3199C43.8556 24.5857 45.9819 25.0398 47.9753 25.6821C49.9688 26.3244 51.8293 27.1107 53.5569 28.041C55.1517 28.927 56.3699 29.9126 57.2116 30.9979C58.0532 32.0832 58.4741 33.2682 58.4741 34.5529V42.5266H47.8424ZM21.2633 21.2633C18.3396 21.2633 15.8367 20.2223 13.7547 18.1403C11.6727 16.0582 10.6317 13.5554 10.6317 10.6317C10.6317 7.70795 11.6727 5.20508 13.7547 3.12305C15.8367 1.04102 18.3396 0 21.2633 0C24.187 0 26.6899 1.04102 28.7719 3.12305C30.8539 5.20508 31.895 7.70795 31.895 10.6317C31.895 13.5554 30.8539 16.0582 28.7719 18.1403C26.6899 20.2223 24.187 21.2633 21.2633 21.2633ZM47.8424 10.6317C47.8424 13.5554 46.8014 16.0582 44.7194 18.1403C42.6374 20.2223 40.1345 21.2633 37.2108 21.2633C36.7235 21.2633 36.1033 21.2079 35.3502 21.0972C34.5972 20.9864 33.977 20.8646 33.4897 20.7317C34.6858 19.3142 35.605 17.7416 36.2473 16.0139C36.8896 14.2863 37.2108 12.4922 37.2108 10.6317C37.2108 8.77111 36.8896 6.97702 36.2473 5.24938C35.605 3.52173 34.6858 1.94914 33.4897 0.531583C34.1099 0.31009 34.7301 0.16612 35.3502 0.0996717C35.9704 0.0332239 36.5906 0 37.2108 0C40.1345 0 42.6374 1.04102 44.7194 3.12305C46.8014 5.20508 47.8424 7.70795 47.8424 10.6317ZM5.31583 37.2108H37.2108V35.0844C37.2108 34.5972 37.089 34.1542 36.8453 33.7555C36.6017 33.3568 36.2805 33.0467 35.8818 32.8252C33.4897 31.6292 31.0754 30.7321 28.639 30.1341C26.2026 29.5361 23.744 29.237 21.2633 29.237C18.7826 29.237 16.324 29.5361 13.8876 30.1341C11.4512 30.7321 9.0369 31.6292 6.64478 32.8252C6.2461 33.0467 5.92493 33.3568 5.68129 33.7555C5.43765 34.1542 5.31583 34.5972 5.31583 35.0844V37.2108ZM21.2633 15.9475C22.7252 15.9475 23.9766 15.427 25.0176 14.386C26.0586 13.3449 26.5791 12.0935 26.5791 10.6317C26.5791 9.1698 26.0586 7.91837 25.0176 6.87735C23.9766 5.83633 22.7252 5.31583 21.2633 5.31583C19.8015 5.31583 18.55 5.83633 17.509 6.87735C16.468 7.91837 15.9475 9.1698 15.9475 10.6317C15.9475 12.0935 16.468 13.3449 17.509 14.386C18.55 15.427 19.8015 15.9475 21.2633 15.9475Z" />
                            </svg>

                            @break

                        @case('archive')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            @break

                        @case('document')
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            @break
                    @endswitch
                </span>

                {{-- Label --}}
                <span class="text-[17px] tracking-wide">{{ $menu['label'] }}</span>
            </a>
        @endforeach
    </nav>

    {{-- ===================== TOMBOL KELUAR ===================== --}}
    <div class="px-6 pb-8 pt-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="w-full flex items-center justify-start gap-3 px-6 py-[14px] rounded-[14px] border border-[#E5B5B5] bg-[#FCE8E8] text-[#BA1A1A] font-bold text-[16px] tracking-wide hover:bg-[#fadcdc] transition-colors"
            >
                {{-- Logout icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
            </button>
        </form>
    </div>

</aside>