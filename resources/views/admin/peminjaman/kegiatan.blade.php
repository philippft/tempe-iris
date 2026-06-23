<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan Peminjaman</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F8FAFC] pb-12 font-sans text-gray-800">

    <div class="bg-white border-b border-slate-200 px-6 py-3 flex items-center gap-3">
        <a href="#" class="text-slate-600 hover:text-slate-900 transition">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
        </a>
        <h1 class="text-sm font-bold text-[#0A5C66]">Lengkapi Berkas Peminjaman</h1>
    </div>

    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        <form action="{{ route('admin.peminjaman.add.kegiatan', $surat->id) }}" method="POST"
            class="bg-white rounded-2xl border border-blue-100 shadow-sm overflow-hidden">
            @csrf
            @method('PUT')

            <div class="bg-blue-50/50 px-6 py-4 border-b border-slate-100">
                <h2 class="text-base font-bold text-[#0A5C66]">Detail Pengajuan Peminjaman</h2>
                <p class="text-xs text-[#64748B] mt-0.5">Lengkapi formulir di bawah ini untuk mengajukan peminjaman
                    inventaris organisasi.</p>
            </div>

            <div class="p-6 space-y-4">

                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">ID
                        Peminjaman</label>
                    <input type="text" name="nama_kegiatan" placeholder="Nama Kegiatan" required
                        class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] px-4 py-2.5 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Nama
                        Acara</label>
                    <input type="text" name="acara" placeholder="Nama Kegiatan" required
                        class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] px-4 py-2.5 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Tujuan
                        Peminjaman</label>
                    <input type="text" value="{{ $surat->user->organization_name ?? 'BEM FMIPA' }}" readonly
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs text-gray-500 cursor-not-allowed">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Tanggal
                            Pinjam</label>
                        <div class="relative">
                            <input type="date" name="tanggal_peminjaman" required
                                class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] pl-4 pr-10 py-2.5 text-xs text-gray-400 focus:text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Tanggal
                            Kembali</label>
                        <div class="relative">
                            <input type="date" name="tanggal_kembali" required
                                class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] pl-4 pr-10 py-2.5 text-xs text-gray-400 focus:text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Perihal
                        Peminjaman</label>
                    <textarea name="perihal_peminjaman" rows="4"
                        placeholder="Jelaskan keperluan peminjaman barang secara detail..." required
                        class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] px-4 py-2.5 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition"></textarea>
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="submit"
                        class="rounded-xl bg-[#0A5C66] hover:bg-[#084952] px-6 py-2.5 text-xs font-bold text-white shadow-md transition">
                        Simpan Data
                    </button>
                </div>

            </div>
        </form>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="text-base font-bold text-[#0F172A]">List Barang Pinjaman</h2>
                <p class="text-xs text-[#64748B] mt-0.5">Cek dan pastikan jumlah dari barang yang ingin dipinjam</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#0A5C66] text-white text-[11px] font-bold uppercase tracking-wider">
                            <th class="px-6 py-3.5 text-center w-16">No</th>
                            <th class="px-6 py-3.5">Nama Barang</th>
                            <th class="px-6 py-3.5">ID Barang</th>
                            <th class="px-6 py-3.5 text-center">Jumlah</th>
                            <th class="px-6 py-3.5">Kategori</th>
                            <th class="px-6 py-3.5 text-center w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700 font-medium">

                        {{-- 💡 Melakukan perulangan menggunakan variabel $detailBarang dari Controller --}}
                        @forelse($detailBarang as $index => $item)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-4 text-center text-slate-400 font-normal">
                                {{ sprintf('%02d', $index + 1) }}
                            </td>

                            <td class="px-6 py-4 text-slate-800 font-bold">{{ $item->nama_barang }}</td>

                            <td class="px-6 py-4">
                                <span
                                    class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded text-[10px] font-bold border border-blue-100">
                                    {{ $item->kode_barang ?? '01-DKN' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center font-bold text-slate-800">
                                {{ $item->qty_inventaris }}
                            </td>

                            <td class="px-6 py-4 text-slate-500">
                                {{ $item->nama_kategori ?? 'Elektronik' }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <button type="button" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                    title="Hapus Barang">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400 font-normal bg-white">
                                Belum ada daftar barang inventaris yang terikat pada draf peminjaman ini.
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>

    </div>
</body>

</html>