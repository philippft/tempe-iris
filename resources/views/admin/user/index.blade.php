<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pendaftaran Akun</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F8FAFC] p-6 sm:p-8 font-sans text-gray-800">

    <div class="max-w-7xl mx-auto space-y-8">

        <div>
            <h1 class="text-2xl font-extrabold text-[#0F172A]">Manajemen Pendaftaran Akun</h1>
            <p class="text-xs text-[#64748B] mt-0.5">Kelola pengajuan akun akses sistem inventory kampus.</p>
        </div>

        <div>
            <h2 class="text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-3">Statistik Akun Mahasiswa</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                <div
                    class="bg-white rounded-2xl border-l-[6px] border-[#0A5C66] border-y border-r border-slate-100 p-5 shadow-sm flex justify-between items-start">
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-500">Total Akun Mahasiswa</p>
                        <p class="text-3xl font-extrabold text-slate-800">21 <span
                                class="text-xs font-medium text-slate-400">Akun</span></p>
                    </div>
                    <div class="p-2 rounded-xl bg-slate-50 text-[#0A5C66]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121 12v-1L19 11" />
                        </svg>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl border-l-[6px] border-amber-500 border-y border-r border-slate-100 p-5 shadow-sm flex justify-between items-start">
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-slate-500">Akun Pending</p>
                        <p class="text-3xl font-extrabold text-slate-800">21 <span
                                class="text-xs font-medium text-slate-400">Akun</span></p>
                    </div>
                    <div class="p-2 rounded-xl bg-amber-50 text-amber-500">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

            </div>
        </div>

        <div
            class="bg-white rounded-2xl border border-slate-100 p-4 shadow-sm flex flex-col sm:flex-row gap-4 items-end sm:items-center justify-between">
            <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto flex-1">
                <div class="flex-1 max-w-md">
                    <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Cari
                        Surat</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" placeholder="Masukkan Nomor atau Perihal Peminjaman..."
                            class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] pl-10 pr-4 py-2 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                    </div>
                </div>

                <div class="w-full sm:w-48">
                    <label
                        class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Status</label>
                    <div class="relative">
                        <select
                            class="block w-full appearance-none rounded-xl border border-slate-200 bg-[#F8FAFC] px-4 py-2 text-xs text-gray-700 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="pending">Pending</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button"
                class="p-2 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition shadow-sm flex justify-center items-center h-[34px] w-full sm:w-auto px-4 sm:px-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
            </button>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#0A5C66] text-white text-[11px] font-bold uppercase tracking-wider">
                            <th class="px-6 py-4 text-center w-16">No</th>
                            <th class="px-6 py-4">Nama Mahasiswa</th>
                            <th class="px-6 py-4">NIM</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Tanggal Daftar</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700 font-medium">

                        {{-- Dummy Loops - Ganti dengan @forelse($users as $index => $user) jika diintegrasikan --}}
                        @php
                        $dummyData = [
                        ['status' => 'AKTIF', 'color' => 'bg-emerald-50 text-emerald-600 border-emerald-200
                        bg-emerald-500'],
                        ['status' => 'DITOLAK', 'color' => 'bg-rose-50 text-rose-600 border-rose-200 bg-rose-500'],
                        ['status' => 'PENDING', 'color' => 'bg-amber-50 text-amber-600 border-amber-200 bg-amber-500'],
                        ['status' => 'DITOLAK', 'color' => 'bg-rose-50 text-rose-600 border-rose-200 bg-rose-500'],
                        ['status' => 'AKTIF', 'color' => 'bg-emerald-50 text-emerald-600 border-emerald-200
                        bg-emerald-500'],
                        ['status' => 'PENDING', 'color' => 'bg-amber-50 text-amber-600 border-amber-200 bg-amber-500'],
                        ];
                        @endphp

                        @foreach($dummyData as $index => $data)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-6 py-5 text-center text-slate-400 font-normal">01</td>
                            <td class="px-6 py-5 text-slate-800 font-extrabold leading-tight">I Putu Ardyana<br>Darma
                                Nugraha</td>
                            <td class="px-6 py-5">
                                <span
                                    class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded text-[10px] font-bold border border-blue-100">
                                    2408561030
                                </span>
                            </td>
                            <td class="px-6 py-5 text-slate-400 font-normal">ardyanadarma@gmail.com</td>
                            <td class="px-6 py-5 text-slate-500 font-semibold">11 April 2026</td>
                            <td class="px-6 py-5 text-center">
                                <span
                                    class="inline-flex items-center justify-center rounded-full px-3 py-1 text-[9px] font-extrabold uppercase tracking-wide border {{ strtok($data['color'], ' ') }} {{ str_replace(strtok($data['color'], ' ').' ', '', $data['color']) }}">
                                    {{ $data['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <a href="#"
                                    class="inline-block px-4 py-1.5 rounded-xl border border-slate-300 text-slate-700 font-bold hover:bg-slate-50 transition text-xs shadow-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="bg-white px-6 py-4 border-t border-slate-100 flex items-center justify-between shadow-sm">
                <div class="text-[11px] text-slate-400 font-medium">
                    Menampilkan <span class="font-bold text-slate-600">2</span> dari <span
                        class="font-bold text-slate-600">21</span> data
                </div>
                <div class="flex items-center gap-1">
                    <button type="button"
                        class="px-2 py-1 border border-slate-200 rounded-lg text-slate-300 text-[11px]"
                        disabled>&lt;</button>
                    <button type="button"
                        class="px-3 py-1 bg-[#0A5C66] text-white rounded-lg text-[11px] font-bold">1</button>
                    <button type="button"
                        class="px-3 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">2</button>
                    <button type="button"
                        class="px-3 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">3</button>
                    <button type="button"
                        class="px-2 py-1 border border-slate-200 rounded-lg text-slate-600 text-[11px] hover:bg-slate-50">&gt;</button>
                </div>
            </div>

        </div>
    </div>

</body>

</html>