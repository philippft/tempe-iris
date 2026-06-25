<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengajuan Peminjaman</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F8FAFC]">

    <div class="bg-white border-b border-slate-200 px-6 py-3 flex items-center gap-3">
        <a href="#" class="text-slate-600 hover:text-slate-900 transition">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
        </a>
        <h1 class="text-sm font-bold text-[#0A5C66]">Form Pengajuan Peminjaman</h1>
    </div>

    <form action="{{ route('user.peminjaman.detail') }}" method="POST">
        @csrf

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 pb-32">

            <div class="mb-6">
                <h2 class="text-2xl font-extrabold text-[#0F172A]">Daftar Barang Inventaris</h2>
                <p class="text-xs text-[#64748B] mt-0.5">Pilih tujuan peminjaman dan barang yang ingin dipinjam</p>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm mb-6">
                <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-2">Pilih Tujuan
                    Peminjaman</label>
                <div class="relative">
                    <select name="id_tujuan" id="select-tujuan" required
                        class="block w-full appearance-none rounded-xl border border-slate-200 bg-[#F8FAFC] px-4 py-2.5 text-xs text-gray-700 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                        <option value="">Pilih Tujuan</option>
                        @foreach($tujuan as $user)
                        <option value="{{ $user->id }}" {{ request('id_tujuan') == $user->id ? 'selected' : '' }}>
                            {{ $user->organization_name }}
                        </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm mb-6 flex flex-col sm:flex-row gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-2">Cari
                        Barang</label>
                    <input type="text" id="input-search" value="{{ request('search') }}"
                        placeholder="Masukkan Nama Barang..."
                        class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] py-2 px-4 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                </div>

                <div class="w-full sm:w-64">
                    <label
                        class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-2">Kategori</label>
                    <div class="relative">
                        <select id="select-kategori"
                            class="block w-full appearance-none rounded-xl border border-slate-200 bg-[#F8FAFC] px-4 py-2 text-xs text-gray-500 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
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

                <button type="button" id="btn-cari"
                    class="w-full sm:w-auto p-2 rounded-xl border border-slate-200 bg-white text-slate-500 hover:bg-slate-50 transition shadow-sm flex justify-center items-center h-[34px]">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
                @forelse($inventaris as $item)
                <div
                    class="rounded-2xl border border-gray-100 bg-white p-4 shadow-sm flex flex-col justify-between hover:shadow-md transition product-card">
                    <div>
                        <div
                            class="w-full h-36 bg-[#E2E8F0] rounded-xl mb-4 flex items-center justify-center text-slate-400 overflow-hidden border border-slate-100">
                            @if($item->image && file_exists(public_path($item->image)))
                            <img src="{{ asset($item->image) }}" alt="{{ $item->nama }}"
                                class="h-full w-full object-cover">
                            @else
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                            @endif
                        </div>

                        <h4 class="text-sm font-bold text-slate-800">{{ $item->nama }}</h4>
                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $item->category->name ?? 'Umum' }}</p>

                        <div class="mt-2">
                            @if(($item->stok_tersedia ?? 0) > 0)
                            <span
                                class="inline-flex items-center gap-1 rounded bg-emerald-50 px-1.5 py-0.5 text-[9px] font-bold text-emerald-600 border border-emerald-100">
                                <span class="h-1 w-1 rounded-full bg-emerald-500"></span> Tersedia:
                                {{ $item->stok_tersedia }}
                            </span>
                            @else
                            <span
                                class="inline-flex items-center gap-1 rounded bg-red-50 px-1.5 py-0.5 text-[9px] font-bold text-red-600 border border-red-100">
                                <span class="h-1 w-1 rounded-full bg-red-500"></span> Tersedia: 0
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-100 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Jumlah
                                Pinjam</span>

                            <div
                                class="flex items-center border border-slate-200 rounded-lg bg-[#F8FAFC] overflow-hidden">
                                <button type="button" onclick="decrementQty(this)"
                                    class="px-2 py-1 text-xs font-bold text-slate-500 hover:bg-slate-200 transition">-</button>

                                <input type="text" name="items[{{ $item->id }}][qty]" value="1" readonly
                                    data-max="{{ $item->stok_tersedia }}" disabled
                                    class="qty-input w-8 text-center bg-transparent text-xs font-bold text-slate-800 border-none focus:ring-0 p-0">

                                <input type="hidden" name="items[{{ $item->id }}][id_inventaris]"
                                    value="{{ $item->id }}" class="id-input" disabled>

                                <button type="button" onclick="incrementQty(this)"
                                    class="px-2 py-1 text-xs font-bold text-white bg-[#0A5C66] hover:bg-[#084952] transition">+</button>
                            </div>
                        </div>

                        <div class="flex items-center gap-1.5">
                            <a href="#"
                                class="p-1.5 rounded-lg bg-[#0A5C66] text-white hover:bg-[#084952] transition shadow-sm"
                                title="Detail Barang">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.644l.711-.356a1.012 1.012 0 011.355.45l.182.363a1.012 1.012 0 001.356.453l.71-.355a1.012 1.012 0 00.453-1.356l-.183-.365a1.012 1.012 0 01.45-1.355l.712-.356a1.012 1.012 0 011.356 0l.712.356a1.012 1.012 0 01.45 1.355l-.183.365a1.012 1.012 0 00.453 1.356l.71.355a1.012 1.012 0 001.356-.453l.182-.363a1.012 1.012 0 011.355-.45l.711.356a1.012 1.012 0 010 .644l-.711.356a1.012 1.012 0 01-1.355-.45l-.182-.363a1.012 1.012 0 00-1.356-.453l-.71.355a1.012 1.012 0 00-.453 1.356l.183.365a1.012 1.012 0 01-.45 1.355l-.712.356a1.012 1.012 0 01-1.356 0l-.712-.356a1.012 1.012 0 01-.45-1.355l.183-.365a1.012 1.012 0 00-.453-1.356l-.71-.355a1.012 1.012 0 00-1.356.453l-.182.363a1.012 1.012 0 01-1.355.45l-.711-.356z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>

                            @if($item->stok_tersedia > 0)
                            <button type="button" onclick="togglePilihBarang(this)"
                                class="btn-pilih flex-1 text-center text-xs font-bold text-white bg-[#0A5C66] hover:bg-[#084952] py-1.5 rounded-lg transition shadow-sm">
                                Pilih Barang
                            </button>
                            @else
                            <button type="button" disabled
                                class="flex-1 text-center text-xs font-bold text-slate-400 bg-slate-100 py-1.5 rounded-lg cursor-not-allowed">
                                Stok Habis
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div
                    class="col-span-full bg-white border border-slate-100 rounded-2xl py-12 text-center text-xs text-slate-400 font-normal shadow-sm">
                    @if(request('id_tujuan'))
                    Tidak ditemukan barang inventaris yang sesuai dengan filter pencarian pada organisasi ini.
                    @else
                    Silakan pilih tujuan organisasi terlebih dahulu untuk memuat daftar barang inventaris.
                    @endif
                </div>
                @endforelse
            </div>

            <div
                class="bg-white px-6 py-4 border border-gray-100 rounded-2xl flex items-center justify-between shadow-sm">
                <div class="text-[11px] text-slate-400">
                    Menampilkan <span class="font-bold text-slate-600">{{ $inventaris->count() }}</span> data
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

        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 px-6 py-4 shadow-2xl z-50">
            <div class="max-w-7xl w-full mx-auto flex justify-end">
                <button type="submit"
                    class="rounded-xl bg-[#0A5C66] px-6 py-2.5 text-xs font-bold text-white shadow-md hover:bg-[#084952] transition">
                    Lanjut Peminjaman
                </button>
            </div>
        </div>

    </form>

    <script>
        // 💡 FUNGSI REDIRECT FILTER DINAMIS KE METHOD CREATE CONTROLLER
        function applyFilters() {
            const idTujuan = document.getElementById('select-tujuan').value;
            const search = document.getElementById('input-search').value;
            const categoryId = document.getElementById('select-kategori').value;

            const params = new URLSearchParams();
            if (idTujuan) params.set('id_tujuan', idTujuan);
            if (search) params.set('search', search);
            if (categoryId) params.set('category_id', categoryId);

            window.location.href = window.location.pathname + '?' + params.toString();
        }

        // Event listener memicu reload filter
        document.getElementById('select-tujuan').addEventListener('change', applyFilters);
        document.getElementById('select-kategori').addEventListener('change', applyFilters);
        document.getElementById('btn-cari').addEventListener('click', applyFilters);

        document.getElementById('input-search').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                applyFilters();
            }
        });

        function incrementQty(button) {
            const input = button.parentNode.querySelector('.qty-input');
            const maxStok = parseInt(input.getAttribute('data-max')) || 0;
            let currentVal = parseInt(input.value) || 1;

            if (currentVal < maxStok) {
                input.value = currentVal + 1;
            } else {
                alert(`Stok tidak mencukupi! Batas maksimum tersedia hanya ${maxStok} barang.`);
            }
        }

        function decrementQty(button) {
            const input = button.parentNode.querySelector('.qty-input');
            let currentVal = parseInt(input.value) || 1;

            if (currentVal > 1) {
                input.value = currentVal - 1;
            }
        }

        function togglePilihBarang(button) {
            const card = button.closest('.product-card');
            const qtyInput = card.querySelector('.qty-input');
            const idInput = card.querySelector('.id-input');

            if (button.classList.contains('bg-[#0A5C66]')) {
                button.innerText = 'Batal Pilih';
                button.classList.remove('bg-[#0A5C66]', 'hover:bg-[#084952]');
                button.classList.add('bg-rose-600', 'hover:bg-rose-700');

                qtyInput.removeAttribute('disabled');
                idInput.removeAttribute('disabled');
            } else {
                button.innerText = 'Pilih Barang';
                button.classList.remove('bg-rose-600', 'hover:bg-rose-700');
                button.classList.add('bg-[#0A5C66]', 'hover:bg-[#084952]');

                qtyInput.setAttribute('disabled', 'disabled');
                idInput.setAttribute('disabled', 'disabled');
            }
        }
    </script>
</body>

</html>