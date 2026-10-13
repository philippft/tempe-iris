@php
$user = auth()->user() ?? (object) [
    'role' => 'mahasiswa',
    'username' => 'Guest',
    'NIM_NIP' => '00000000',
];;

if (!$user) return;

$role = $user->role;
$role_admin = str_replace('_', ' ', $user->role);
$name = $user->name;
$nim_nip = $user->nim_nip;
$admin_name = str_replace('_', ' ', $user->username);
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
        ['label'=>'Dashboard','route'=>'user.dashboard','icon'=>'dashboard'],
        ['label'=>'Peminjaman','route'=>'user.peminjaman.index','icon'=>'transfer'],
    ],

    'admin_LM' => [
        ['label'=>'Dashboard','route'=>'admin.dashboard','icon'=>'dashboard'],
        ['label'=>'Peminjaman','route'=>'admin.peminjaman.index','active'=>'admin.peminjaman.*','icon'=>'transfer'],
        ['label'=>'Manajemen User','route'=>'admin.management.user','active'=>['admin.management.user','admin.user.*'],'icon'=>'users'],
        ['label'=>'Manajemen Inventaris','route'=>'admin.inventaris.index','active'=>'admin.inventaris.*','icon'=>'archive'],
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
        @if ($role === 'mahasiswa')
            <div class="flex items-center gap-3">
                {{-- Nama & Subtitle --}}
                <div class="flex flex-col justify-center">
                    <p class="font-bold text-[#051F20] text-[16px] leading-tight tracking-wide uppercase">
                        {{ $name }}
                    </p>
                    <p class="text-[#64748B] text-[13px] font-medium mt-0.5 uppercase tracking-wide">
                        {{ $nim_nip }}
                    </p>
                </div>
            </div>
        @endif
        
        @if (in_array($role, ['admin_LM', 'admin_dekanat', 'petinggi_dekanat']))
            <div class="flex items-center gap-3">
                {{-- Nama & Subtitle --}}
                <div class="flex flex-col justify-center">
                    <p class="font-bold text-[#051F20] text-[16px] leading-tight tracking-wide uppercase">
                        {{ $admin_name }}
                    </p>
                    <p class="text-[#64748B] text-[13px] font-medium mt-0.5 uppercase tracking-wide">
                        {{ $role_admin }}
                    </p>
                </div>
            </div>
        @endif

        {{-- Tombol Settings --}}
        @if ($role === 'mahasiswa')
            <a
                href="{{ route('user.detail-akun', ['user' => auth()->user()->id]) }}"
                class="flex items-center justify-center w-9.5 h-9.5 bg-[#E2E8F0]/70 rounded-xl flex-shrink-0 hover:bg-gray-200 transition-colors ml-2"
                title="Pengaturan"
            >
            <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.61717 20.869L7.19979 17.5299C6.97371 17.443 6.76068 17.3386 6.56068 17.2169C6.36069 17.0952 6.16504 16.9647 5.97374 16.8256L2.86948 18.1299L0 13.1735L2.68688 11.1388C2.66949 11.0171 2.66079 10.8997 2.66079 10.7866C2.66079 10.6736 2.66079 10.5562 2.66079 10.4345C2.66079 10.3127 2.66079 10.1954 2.66079 10.0823C2.66079 9.96928 2.66949 9.85189 2.68688 9.73016L0 7.69543L2.86948 2.73905L5.97374 4.04336C6.16504 3.90424 6.36504 3.77381 6.57373 3.65207C6.78241 3.53033 6.9911 3.42599 7.19979 3.33904L7.61717 0H13.3561L13.7735 3.33904C13.9996 3.42599 14.2126 3.53033 14.4126 3.65207C14.6126 3.77381 14.8083 3.90424 14.9996 4.04336L18.1038 2.73905L20.9733 7.69543L18.2864 9.73016C18.3038 9.85189 18.3125 9.96928 18.3125 10.0823C18.3125 10.1954 18.3125 10.3127 18.3125 10.4345C18.3125 10.5562 18.3125 10.6736 18.3125 10.7866C18.3125 10.8997 18.2951 11.0171 18.2603 11.1388L20.9472 13.1735L18.0777 18.1299L14.9996 16.8256C14.8083 16.9647 14.6083 17.0952 14.3996 17.2169C14.1909 17.3386 13.9822 17.443 13.7735 17.5299L13.3561 20.869H7.61717ZM9.44321 18.7821H11.504L11.8692 16.0169C12.4083 15.8778 12.9083 15.6735 13.3692 15.4039C13.83 15.1343 14.2518 14.8083 14.6344 14.4257L17.2169 15.4952L18.2343 13.7213L15.9908 12.0257C16.0778 11.7823 16.1387 11.5258 16.1735 11.2562C16.2082 10.9866 16.2256 10.7127 16.2256 10.4345C16.2256 10.1562 16.2082 9.88233 16.1735 9.61277C16.1387 9.34321 16.0778 9.0867 15.9908 8.84323L18.2343 7.14762L17.2169 5.37376L14.6344 6.46938C14.2518 6.06939 13.83 5.73462 13.3692 5.46506C12.9083 5.1955 12.4083 4.99116 11.8692 4.85204L11.5301 2.0869H9.4693L9.10409 4.85204C8.56497 4.99116 8.06499 5.1955 7.60413 5.46506C7.14327 5.73462 6.72155 6.0607 6.33895 6.44329L3.75641 5.37376L2.73905 7.14762L4.98247 8.81714C4.89551 9.078 4.83464 9.33886 4.79986 9.59973C4.76508 9.86059 4.74769 10.1388 4.74769 10.4345C4.74769 10.7127 4.76508 10.9823 4.79986 11.2432C4.83464 11.504 4.89551 11.7649 4.98247 12.0257L2.73905 13.7213L3.75641 15.4952L6.33895 14.3996C6.72155 14.7996 7.14327 15.1343 7.60413 15.4039C8.06499 15.6735 8.56497 15.8778 9.10409 16.0169L9.44321 18.7821ZM10.5388 14.0866C11.5475 14.0866 12.4083 13.73 13.1214 13.017C13.8344 12.304 14.1909 11.4432 14.1909 10.4345C14.1909 9.42582 13.8344 8.56497 13.1214 7.85195C12.4083 7.13893 11.5475 6.78241 10.5388 6.78241C9.51277 6.78241 8.64758 7.13893 7.94325 7.85195C7.23892 8.56497 6.88676 9.42582 6.88676 10.4345C6.88676 11.4432 7.23892 12.304 7.94325 13.017C8.64758 13.73 9.51277 14.0866 10.5388 14.0866Z" fill="#40484B"/>
            </svg>

            </a>
        @endif
    </div>

    {{-- ===================== NAVIGASI ===================== --}}
    <nav class="flex-1 mt-2 overflow-y-auto">
        @foreach ($menus as $menu)
            @php
                $active = request()->routeIs($menu['active'] ?? $menu['route']);
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