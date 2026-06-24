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

        <!-- BACK BUTTON & HEADER HEADER -->
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.inventaris.index') }}"
                class="inline-flex items-center justify-center p-2 rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition shadow-sm">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-sm font-medium text-slate-500">Detail Inventaris</h1>
            </div>
        </div>

        <!-- MAIN DETAIL CARD -->
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white p-6 shadow-sm max-w-4xl mb-8 relative">

            <!-- Status Badge Pojok Kanan Atas -->
            <div class="absolute top-6 right-6">
                @if(($statusStok === 'aktif') || ($statusStok === 1))
                <span
                    class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    Aktif
                </span>
                @else
                <span
                    class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                    <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                    Tidak Aktif
                </span>
                @endif
            </div>

            <div class="mb-6">
                <h2 class="text-2xl font-bold text-[#0B5C66]">Detail Barang</h2>
                <p class="text-xs text-slate-400 mt-1">Lihat detail informasi barang {{ $inventaris->nama }}</p>
            </div>

            <!-- FOTO PRODUK (CENTERED BIG IMAGE) -->
            <div class="flex justify-center mb-8">
                <div
                    class="w-full max-w-xl h-64 overflow-hidden rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-center shadow-inner">
                    @if($inventaris->image && file_exists(public_path($inventaris->image)))
                    <img src="{{ asset($inventaris->image) }}" alt="{{ $inventaris->nama }}" class="w-full h-full object-cover">
                    @else
                    <svg class="h-16 w-16 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    @endif
                </div>
            </div>

            <!-- BLOCK INFORMASI BARANG -->
            <div class="rounded-2xl border border-slate-100 bg-[#F8FAFC] p-6 space-y-5">
                <h3 class="text-base font-bold text-[#0B5C66] border-b border-slate-200 pb-2">Informasi Barang</h3>

                <!-- Nama Barang -->
                <div>
                    <label class="block text-[10px] font-bold text-[#94A3B8] uppercase tracking-wider">Nama
                        Barang</label>
                    <p class="text-sm font-bold text-slate-800 mt-0.5">{{ $inventaris->nama }}</p>
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-[10px] font-bold text-[#94A3B8] uppercase tracking-wider">Kategori</label>
                    <p class="text-sm font-semibold text-slate-700 mt-0.5">{{ $inventaris->category->name ?? 'Umum' }}</p>
                </div>

                <!-- Stok Barang -->
                <div>
                    <label class="block text-[10px] font-bold text-[#94A3B8] uppercase tracking-wider">Stok
                        Barang</label>
                    <p class="text-sm font-semibold text-slate-700 mt-0.5">
                        {{ $jumlahStok }} Pcs</p>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-[10px] font-bold text-[#94A3B8] uppercase tracking-wider">Deskripsi</label>
                    <p class="text-sm text-slate-600 mt-1 leading-relaxed text-justify">
                        {{ $inventaris->deskripsi ?? 'Tidak ada deskripsi atau catatan tambahan untuk barang ini.' }}
                    </p>
                </div>
            </div>

            <!-- TOMBOL PERBAHURUI DATA (ORANGE BUTTON) -->
            <div class="mt-6">
                <a href="{{ route('admin.inventaris.edit', $inventaris->id) }}"
                    class="block w-full text-center rounded-xl bg-[#FDB022] py-3 text-sm font-bold text-white shadow-sm hover:bg-[#EAAA08] transition">
                    Perbaharui Data
                </a>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- 4. TABEL RIWAYAT PEMINJAMAN -->
        <!-- ========================================== -->
        <div class="max-w-4xl">
            <div class="mb-4">
                <h2 class="text-xl font-bold text-[#0B5C66]">Riwayat Peminjaman</h2>
                <p class="text-xs text-slate-400 mt-0.5">Lihat riwayat peminjaman dari inventaris ini</p>
            </div>

            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-left text-sm">
                        <thead class="bg-[#0B5C66] text-xs font-bold uppercase tracking-wider text-white">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-center">No</th>
                                <th scope="col" class="px-6 py-4">Nama Peminjam</th>
                                <th scope="col" class="px-6 py-4">Tanggal Pinjam</th>
                                <th scope="col" class="px-6 py-4">Tanggal Kembali</th>
                                <th scope="col" class="px-6 py-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            {{-- Ganti dengan @forelse($inventaris  ->loans as $index => $loan) jika relasi sudah ada --}}
                            @forelse([] as $index => $loan)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="whitespace-nowrap px-6 py-4 text-center font-medium text-slate-500">
                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-900">Nama Peminjam</td>
                                <td class="px-6 py-4 text-slate-600">12 Mei 2026</td>
                                <td class="px-6 py-4 text-slate-600">13 Mei 2026</td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded-full bg-[#22C55E] px-3 py-0.5 text-[10px] font-bold text-white uppercase tracking-wide">
                                        SELESAI
                                    </span>
                                </td>
                            </tr>
                            @empty
                            {{-- Dummy row agar tampilannya persis seperti screenshot saat data asli kosong --}}
                            <tr class="hover:bg-slate-50 transition">
                                <td class="whitespace-nowrap px-6 py-4 text-center font-medium text-slate-500">01</td>
                                <td class="px-6 py-4 font-bold text-slate-700">Anak Agung Mas Mayuri</td>
                                <td class="px-6 py-4 text-slate-500">12 Mei 2026</td>
                                <td class="px-6 py-4 text-slate-500">13 Mei 2026</td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded-full bg-[#00C853] px-3 py-0.5 text-[10px] font-bold text-white uppercase tracking-wide">SELESAI</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="whitespace-nowrap px-6 py-4 text-center font-medium text-slate-500">02</td>
                                <td class="px-6 py-4 font-bold text-slate-700">Anak Agung Mas Mayuri</td>
                                <td class="px-6 py-4 text-slate-500">23 Mei 2026</td>
                                <td class="px-6 py-4 text-slate-500">-</td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center rounded-full bg-[#FFB300] px-3 py-0.5 text-[10px] font-bold text-white uppercase tracking-wide">DIPINJAM</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- TABEL PAGINATION FOOTER -->
                <div class="bg-white px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                    <div class="text-xs text-slate-400">
                        Menampilkan <span class="font-medium text-slate-700">2</span> dari <span
                            class="font-medium text-slate-700">21</span> data
                    </div>
                    <div class="flex items-center gap-1">
                        <button class="px-2 py-1 border border-gray-200 rounded-lg text-slate-300 text-xs"
                            disabled>&lt;</button>
                        <button class="px-3 py-1 bg-[#0B5C66] text-white rounded-lg text-xs font-semibold">1</button>
                        <button
                            class="px-3 py-1 border border-gray-200 rounded-lg text-slate-600 text-xs hover:bg-slate-50">2</button>
                        <button
                            class="px-3 py-1 border border-gray-200 rounded-lg text-slate-600 text-xs hover:bg-slate-50">3</button>
                        <button
                            class="px-2 py-1 border border-gray-200 rounded-lg text-slate-600 text-xs hover:bg-slate-50">&gt;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>