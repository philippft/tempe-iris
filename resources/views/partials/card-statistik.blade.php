{{--  Row 1: 3 outlined  --}}
<div class="grid grid-cols-4 gap-5 mb-5">

    {{-- 1. Teal (Total Aktif – Peminjaman) --}}
    <div class="stat-card stat-teal">
        <div class="flex items-center justify-between">
            <p class="stat-label">Total Aktif</p>
            <div class="stat-icon">
                {{-- Icon: refresh/cycle --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9
                             m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357
                             2H15"/>
                </svg>
            </div>
        </div>
        <div class="flex items-baseline gap-2">
            <span class="stat-number">21</span>
            <span class="stat-unit">Peminjaman</span>
        </div>
    </div>

    {{-- 2. Green (Total Aktif – versi hijau) --}}
    <div class="stat-card stat-green">
        <div class="flex items-center justify-between">
            <p class="stat-label">Total Aktif</p>
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9
                             m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357
                             2H15"/>
                </svg>
            </div>
        </div>
        <div class="flex items-baseline gap-2">
            <span class="stat-number">21</span>
            <span class="stat-unit">Peminjaman</span>
        </div>
    </div>


    {{-- 3. Yellow (Total Diproses) --}}
    <div class="stat-card stat-yellow">
        <div class="flex items-center justify-between">
            <p class="stat-label">Total Diproses</p>
            <div class="stat-icon">
                {{-- Icon: hourglass --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="flex items-baseline gap-2">
            <span class="stat-number">21</span>
            <span class="stat-unit">Peminjaman</span>
        </div>
    </div>

</div>

{{--  Row 2: 2 outlined + 1 filled + 1 filled (beda ukuran grid)  --}}
<div class="grid grid-cols-4 gap-5">

    {{-- 4. Red (Total Ditolak) --}}
    <div class="stat-card stat-red">
        <div class="flex items-center justify-between">
            <p class="stat-label">Total Ditolak</p>
            <div class="stat-icon">
                {{-- Icon: x-circle --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2
                             m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="flex items-baseline gap-2">
            <span class="stat-number">21</span>
            <span class="stat-unit">Peminjaman</span>
        </div>
    </div>

    {{-- 5. Dark Navy (Total Inventaris) --}}
    <div class="stat-card stat-dark">
        <div class="flex items-center justify-between">
            <p class="stat-label">Total Inventaris</p>
            <div class="stat-icon">
                {{-- Icon: archive --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4
                             M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                </svg>
            </div>
        </div>
        <div class="flex items-baseline gap-2">
            <span class="stat-number">21</span>
            <span class="stat-unit">Barang</span>
        </div>
    </div>

    {{-- 6. Filled Green (User Aktif) --}}
    <div class="stat-card stat-filled-green">
        <div class="flex items-center justify-between">
            <p class="stat-label">User Aktif</p>
            <div class="stat-icon">
                {{-- Icon: single user --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0z
                             M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
        </div>
        <div class="flex items-baseline gap-2">
            <span class="stat-number">21</span>
            <span class="stat-unit">Mahasiswa</span>
        </div>
    </div>

    {{-- 7. Filled Yellow (User Pending) --}}
    <div class="stat-card stat-filled-yellow">
        <div class="flex items-center justify-between">
            <p class="stat-label">User Pending</p>
            <div class="stat-icon">
                {{-- Icon: user-add --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3
                             m-9-3a4 4 0 11-8 0 4 4 0 018 0z
                             M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
        </div>
        <div class="flex items-baseline gap-2">
            <span class="stat-number">21</span>
            <span class="stat-unit">Mahasiswa</span>
        </div>
    </div>

</div>