<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a href="{{ route('admin.download.surat', $surat->id) }}"
        class="inline-block px-3 py-1.5 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 transition text-xs shadow-sm">
        Cetak PDF
    </a>
    <form action="{{ route('admin.peminjaman.verifikasi', $surat->id) }}" method="POST" onsubmit="disableButton(this)">
        @csrf
        @method('PUT')

        {{-- 1. Input Catatan Verifikator --}}
        <div class="border border-slate-200 rounded-xl mb-4 bg-[#F8FAFC] shadow-sm p-5">
            <label for="catatan_peminjaman" class="block font-semibold text-sm text-[#1e293b] mb-2">
                Catatan Verifikator (Opsional)
            </label>
            <textarea name="catatan_peminjaman" id="catatan_peminjaman" rows="3"
                placeholder="Tambahkan alasan jika menolak peminjaman..."
                class="block w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-xs text-gray-700 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition resize-none outline-none"></textarea>
            @error('catatan_peminjaman')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- 2. Bar Tombol Aksi --}}
        <div
            class="border border-slate-200 rounded-xl bg-white shadow-sm p-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-xs text-gray-500 italic">
                Pastikan barang yang ingin dipinjam tersedia, jika tidak mohon diberikan pesan ditolak
            </p>

            <div class="flex items-center gap-3 w-full sm:w-auto">
                {{-- Tombol Tolak (status = 0) --}}
                <button type="submit" name="status_peminjaman" value="0"
                    class="btn-action w-full sm:w-auto px-5 py-2.5 rounded-lg border border-red-500 text-red-500 hover:bg-red-50 font-semibold text-xs flex items-center justify-center gap-2 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    Tolak
                </button>

                {{-- Tombol Setujui (status = 1) --}}
                <button type="submit" name="status_peminjaman" value="1"
                    class="btn-action w-full sm:w-auto px-5 py-2.5 rounded-lg bg-[#00B67A] text-white hover:bg-[#009E6A] font-semibold text-xs flex items-center justify-center gap-2 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Setujui
                </button>
            </div>
        </div>
    </form>

    {{-- Script pencegah double click --}}
    <script>
        function disableButton(form) {
            // 1. Ambil tombol yang memicu submit (tombol yang aktif diklik oleh admin)
            const activeButton = document.activeElement;

            if (activeButton && activeButton.name === 'status_peminjaman') {
                // 2. Buat input hidden darurat untuk mengamankan nilainya (0 atau 1)
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'status_peminjaman';
                hiddenInput.value = activeButton.value;

                // Tempelkan input hidden ini ke dalam form
                form.appendChild(hiddenInput);
            }

            // 3. Baru setelah nilainya aman di input hidden, matikan semua tombol aksi
            // Gunakan setTimeout agar browser sempat mendaftarkan input hidden tadi ke request
            setTimeout(() => {
                const buttons = form.querySelectorAll('.btn-action');
                buttons.forEach(btn => {
                    // btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                });
            }, 1);
        }
    </script>
</body>
</html>