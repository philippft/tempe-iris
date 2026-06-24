<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 bg-[#F8FAFC]">

        <!-- HEADER SECTION -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-extrabold text-[#0F172A]">Daftar Peminjaman Inventaris</h1>
                <p class="mt-1 text-sm text-[#64748B]">Kelola dan pantau status peminjaman inventaris Anda.</p>
            </div>
            <a href="{{ route('admin.peminjaman.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-[#0A5C66] px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-[#084952] transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Tambah Peminjaman
            </a>
        </div>

        <!-- STATISTIK PEMINJAMAN (GRID CARD) -->
        <div class="mb-4">
            <h2 class="text-xs font-bold text-[#94A3B8] uppercase tracking-wider mb-4">Statistik Peminjaman</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Card 1: Total Masuk -->
                <div
                    class="relative rounded-2xl border-l-[4px] border-[#0A5C66] bg-white p-5 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wide">Total Peminjaman Masuk
                        </p>
                        <p class="mt-2 text-3xl font-extrabold text-[#0F172A]">{{ $suratMasuk->count() }} <span
                                class="text-xs font-medium text-[#94A3B8] normal-case tracking-normal">Peminjaman</span>
                        </p>
                    </div>
                    <div class="rounded-lg bg-[#E0F2FE] p-1.5 text-[#0A5C66]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.656 48.656 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
                        </svg>
                    </div>
                </div>

                <!-- Card 2: Total Keluar -->
                <div
                    class="relative rounded-2xl border-l-[4px] border-[#0F172A] bg-white p-5 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wide">Total Peminjaman Keluar
                        </p>
                        <p class="mt-2 text-3xl font-extrabold text-[#0F172A]">{{ $suratKeluar->count() }} <span
                                class="text-xs font-medium text-[#94A3B8] normal-case tracking-normal">Peminjaman</span>
                        </p>
                    </div>
                    <div class="rounded-lg bg-[#E2E8F0] p-1.5 text-[#0F172A]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 00-3.7-3.7 48.656 48.656 0 00-7.324 0 4.006 4.006 0 00-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3l-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 003.7 3.7 48.656 48.656 0 007.324 0 4.006 4.006 0 003.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3l-3 3" />
                        </svg>
                    </div>
                </div>

                <!-- Card 3: Total Selesai -->
                <div
                    class="relative rounded-2xl border-l-[4px] border-[#22C55E] bg-white p-5 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wide">Total Selesai</p>
                        <p class="mt-2 text-3xl font-extrabold text-[#0F172A]">{{ $suratAprove->count() }} <span
                                class="text-xs font-medium text-[#94A3B8] normal-case tracking-normal">Peminjaman</span>
                        </p>
                    </div>
                    <div class="rounded-lg bg-[#DCFCE7] p-1.5 text-[#22C55E]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </div>
                </div>

                <!-- Card 4: Total Diproses -->
                <div
                    class="relative rounded-2xl border-l-[4px] border-[#EAAA08] bg-white p-5 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wide">Total Diproses</p>
                        <p class="mt-2 text-3xl font-extrabold text-[#0F172A]">{{ $suratPending->count() }}<span
                                class="text-xs font-medium text-[#94A3B8] normal-case tracking-normal">Peminjaman</span>
                        </p>
                    </div>
                    <div class="rounded-lg bg-[#FEF9E7] p-1.5 text-[#EAAA08]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Baris Kedua Statistik: Total Ditolak -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div
                    class="relative rounded-2xl border-l-[4px] border-[#EF4444] bg-white p-5 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wide">Total Ditolak</p>
                        <p class="mt-2 text-3xl font-extrabold text-[#0F172A]">{{ $suratReject->count() }} <span
                                class="text-xs font-medium text-[#94A3B8] normal-case tracking-normal">Peminjaman</span>
                        </p>
                    </div>
                    <div class="rounded-lg bg-[#FEE2E2] p-1.5 text-[#EF4444]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN DATA BOX -->
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm mb-8">

            <!-- Judul Bagian Peminjaman Masuk & Tombol Export -->
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Peminjaman Masuk</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Daftar peminjaman barang kepada LM ini</p>
                </div>
                <button
                    class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 transition shadow-sm"
                    title="Unduh Log">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                </button>
            </div>

            <!-- FILTER & CARI PANEL -->
            <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div class="flex-1 max-w-2xl">
                    <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Cari
                        Peminjaman</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" placeholder="Masukkan Nama Peminjaman..."
                            class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] py-2 pl-9 pr-4 text-xs text-gray-900 focus:border-[#0B5C66] focus:ring-[#0B5C66] transition">
                    </div>
                </div>

                <div class="w-full md:w-48">
                    <label
                        class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Status</label>
                    <select
                        class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] px-3 py-2 text-xs text-gray-900 focus:border-[#0B5C66] focus:ring-[#0B5C66] transition">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="pending">Pending</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
            </div>

            <!-- TABEL DATA UTAMA -->
            <div class="overflow-hidden rounded-xl border border-gray-100 bg-white">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-left text-xs">
                        <thead class="bg-[#0B5C66] font-bold uppercase tracking-wider text-white">
                            <tr>
                                <th scope="col" class="px-4 py-3.5 text-center w-12">No</th>
                                <th scope="col" class="px-6 py-3.5">Nama Kegiatan</th>
                                <th scope="col" class="px-4 py-3.5 text-center">ID Pinjam</th>
                                <th scope="col" class="px-6 py-3.5">Tanggal Pinjam</th>
                                <th scope="col" class="px-6 py-3.5">Estimasi Kembali</th>
                                <th scope="col" class="px-4 py-3.5 text-center">Status</th>
                                <th scope="col" class="px-6 py-3.5">Tujuan</th>
                                <th scope="col" class="px-4 py-3.5 text-center w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white font-medium text-slate-700">
                            @forelse($suratMasuk as $index => $row)
                            @php
                            // 💡 LOGIKA STRICK WARNA DAN TEXT BADGE STATUS
                            if ($row->tandatangan_pimpinan === 1 && $row->status_peminjaman == 1) {
                            $statusText = 'AKTIF';
                            $badgeBg = 'bg-[#22C55E]'; // Hijau
                            } elseif ($row->status_peminjaman === 0) {
                            $statusText = 'DITOLAK';
                            $badgeBg = 'bg-[#EF4444]'; // Merah
                            } else {
                            $statusText = 'PENDING';
                            $badgeBg = 'bg-[#FDB022]'; // Oranye (Default menunggu review)
                            }
                            @endphp

                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="whitespace-nowrap px-4 py-4 text-center font-normal text-slate-400">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </td>

                                <td class="px-6 py-4 font-bold text-slate-800">
                                    {{ $row->acara }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded bg-blue-50 px-2 py-0.5 text-[10px] font-bold text-blue-600 border border-blue-100">
                                        {{ str_pad($row->id, 2, '0', STR_PAD_LEFT) }}-DKN
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 font-normal text-slate-500">
                                    {{ \Carbon\Carbon::parse($row->tanggal_peminjaman)->translatedFormat('d M Y') }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 font-normal text-slate-500">
                                    {{ \Carbon\Carbon::parse($row->tanggal_kembali)->translatedFormat('d M Y') }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded-full {{ $badgeBg }} px-2.5 py-0.5 text-[9px] font-extrabold text-white uppercase tracking-wider">
                                        {{ $statusText }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 font-bold text-[#0A5C66]">
                                    {{ $row->detailPeminjaman->first()->inventaris->user->organization_name }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.peminjaman.detail-surat', $row->id) }}"
                                            class="rounded-md bg-slate-50 p-1.5 text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition border border-slate-100 shadow-sm"
                                            title="Lihat Data">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.644l.711-.356a1.012 1.012 0 011.355.45l.182.363a1.012 1.012 0 001.356.453l.71-.355a1.012 1.012 0 00.453-1.356l-.183-.365a1.012 1.012 0 01.45-1.355l.712-.356a1.012 1.012 0 011.356 0l.712.356a1.012 1.012 0 01.45 1.355l-.183.365a1.012 1.012 0 00.453 1.356l.71.355a1.012 1.012 0 001.356-.453l.182-.363a1.012 1.012 0 011.355-.45l.711.356a1.012 1.012 0 010 .644l-.711.356a1.012 1.012 0 01-1.355-.45l-.182-.363a1.012 1.012 0 00-1.356-.453l-.71.355a1.012 1.012 0 00-.453 1.356l.183.365a1.012 1.012 0 01-.45 1.355l-.712.356a1.012 1.012 0 01-1.356 0l-.712-.356a1.012 1.012 0 01-.45-1.355l.183-.365a1.012 1.012 0 00-.453-1.356l-.71-.355a1.012 1.012 0 00-1.356.453l-.182.363a1.012 1.012 0 01-1.355.45l-.711-.356z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.inventaris.destroy', $row->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan surat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="rounded-md bg-slate-50 p-1.5 text-[#EF4444] hover:bg-red-50 transition border border-slate-100 shadow-sm"
                                                title="Hapus Data">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-xs text-slate-400 font-normal">
                                    Belum ada log data surat peminjaman keluar yang tercatat.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION BLOCK -->
                <div class="bg-white px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                    <div class="text-[11px] text-slate-400">
                        Menampilkan <span class="font-bold text-slate-600">2</span> dari <span
                            class="font-bold text-slate-600">21</span> data
                    </div>
                    <div class="flex items-center gap-1">
                        <button class="px-2 py-1 border border-slate-200 rounded-lg text-slate-300 text-[11px]"
                            disabled>&lt;</button>
                        <button class="px-3 py-1 bg-[#0B5C66] text-white rounded-lg text-[11px] font-bold">1</button>
                        <button
                            class="px-3 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">2</button>
                        <button
                            class="px-3 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">3</button>
                        <button
                            class="px-2 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">&gt;</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm mb-8">

            <!-- Judul Bagian Peminjaman Masuk & Tombol Export -->
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Peminjaman Keluar</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Daftar peminjaman barang kepada LM ini</p>
                </div>
                <button
                    class="inline-flex items-center justify-center p-2 rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 transition shadow-sm"
                    title="Unduh Log">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                </button>
            </div>

            <!-- FILTER & CARI PANEL -->
            <div class="mb-6 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div class="flex-1 max-w-2xl">
                    <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Cari
                        Peminjaman</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" placeholder="Masukkan Nama Peminjaman..."
                            class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] py-2 pl-9 pr-4 text-xs text-gray-900 focus:border-[#0B5C66] focus:ring-[#0B5C66] transition">
                    </div>
                </div>

                <div class="w-full md:w-48">
                    <label
                        class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Status</label>
                    <select
                        class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] px-3 py-2 text-xs text-gray-900 focus:border-[#0B5C66] focus:ring-[#0B5C66] transition">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="pending">Pending</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
            </div>

            <!-- TABEL DATA UTAMA -->
            <div class="overflow-hidden rounded-xl border border-gray-100 bg-white">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-left text-xs">
                        <thead class="bg-[#0B5C66] font-bold uppercase tracking-wider text-white">
                            <tr>
                                <th scope="col" class="px-4 py-3.5 text-center w-12">No</th>
                                <th scope="col" class="px-6 py-3.5">Nama Kegiatan</th>
                                <th scope="col" class="px-4 py-3.5 text-center">ID Pinjam</th>
                                <th scope="col" class="px-6 py-3.5">Tanggal Pinjam</th>
                                <th scope="col" class="px-6 py-3.5">Estimasi Kembali</th>
                                <th scope="col" class="px-4 py-3.5 text-center">Status</th>
                                <th scope="col" class="px-6 py-3.5">Tujuan</th>
                                <th scope="col" class="px-4 py-3.5 text-center w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white font-medium text-slate-700">
                            @forelse($suratKeluar as $index => $row)
                            @php
                            // 💡 LOGIKA STRICK WARNA DAN TEXT BADGE STATUS
                            if ($row->tandatangan_pimpinan === 1 && $row->status_peminjaman == 1) {
                            $statusText = 'AKTIF';
                            $badgeBg = 'bg-[#22C55E]'; // Hijau
                            } elseif ($row->tandatangan_pimpinan === 0) {
                            $statusText = 'DITOLAK';
                            $badgeBg = 'bg-[#EF4444]'; // Merah
                            } else {
                            $statusText = 'PENDING';
                            $badgeBg = 'bg-[#FDB022]'; // Oranye (Default menunggu review)
                            }
                            @endphp

                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="whitespace-nowrap px-4 py-4 text-center font-normal text-slate-400">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </td>

                                <td class="px-6 py-4 font-bold text-slate-800">
                                    {{ $row->acara }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded bg-blue-50 px-2 py-0.5 text-[10px] font-bold text-blue-600 border border-blue-100">
                                        {{ str_pad($row->id, 2, '0', STR_PAD_LEFT) }}-DKN
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 font-normal text-slate-500">
                                    {{ \Carbon\Carbon::parse($row->tanggal_peminjaman)->translatedFormat('d M Y') }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 font-normal text-slate-500">
                                    {{ \Carbon\Carbon::parse($row->tanggal_kembali)->translatedFormat('d M Y') }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded-full {{ $badgeBg }} px-2.5 py-0.5 text-[9px] font-extrabold text-white uppercase tracking-wider">
                                        {{ $statusText }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 font-bold text-[#0A5C66]">
                                    {{ $row->detailPeminjaman->first()->inventaris->user->organization_name }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.inventaris.show', ['inventaris' => $row->id, 'status_tampilan' => strtolower($statusText)]) }}"
                                            class="rounded-md bg-slate-50 p-1.5 text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition border border-slate-100 shadow-sm"
                                            title="Lihat Data">
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.036 12.322a1.012 1.012 0 010-.644l.711-.356a1.012 1.012 0 011.355.45l.182.363a1.012 1.012 0 001.356.453l.71-.355a1.012 1.012 0 00.453-1.356l-.183-.365a1.012 1.012 0 01.45-1.355l.712-.356a1.012 1.012 0 011.356 0l.712.356a1.012 1.012 0 01.45 1.355l-.183.365a1.012 1.012 0 00.453 1.356l.71.355a1.012 1.012 0 001.356-.453l.182-.363a1.012 1.012 0 011.355-.45l.711.356a1.012 1.012 0 010 .644l-.711.356a1.012 1.012 0 01-1.355-.45l-.182-.363a1.012 1.012 0 00-1.356-.453l-.71.355a1.012 1.012 0 00-.453 1.356l.183.365a1.012 1.012 0 01-.45 1.355l-.712.356a1.012 1.012 0 01-1.356 0l-.712-.356a1.012 1.012 0 01-.45-1.355l.183-.365a1.012 1.012 0 00-.453-1.356l-.71-.355a1.012 1.012 0 00-1.356.453l-.182.363a1.012 1.012 0 01-1.355.45l-.711-.356z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.inventaris.destroy', $row->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan surat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="rounded-md bg-slate-50 p-1.5 text-[#EF4444] hover:bg-red-50 transition border border-slate-100 shadow-sm"
                                                title="Hapus Data">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-xs text-slate-400 font-normal">
                                    Belum ada log data surat peminjaman keluar yang tercatat.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION BLOCK -->
                <div class="bg-white px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                    <div class="text-[11px] text-slate-400">
                        Menampilkan <span class="font-bold text-slate-600">2</span> dari <span
                            class="font-bold text-slate-600">21</span> data
                    </div>
                    <div class="flex items-center gap-1">
                        <button class="px-2 py-1 border border-slate-200 rounded-lg text-slate-300 text-[11px]"
                            disabled>&lt;</button>
                        <button class="px-3 py-1 bg-[#0B5C66] text-white rounded-lg text-[11px] font-bold">1</button>
                        <button
                            class="px-3 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">2</button>
                        <button
                            class="px-3 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">3</button>
                        <button
                            class="px-2 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">&gt;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>