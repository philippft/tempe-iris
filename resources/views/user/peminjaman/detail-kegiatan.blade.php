<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <form action="{{ route('user.peminjaman.store.kegiatan', $surat->id) }}" method="POST"
        class="max-w-4xl mx-auto space-y-6 pb-24">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl border border-blue-100 shadow-sm overflow-hidden">
            <div class="bg-blue-50/50 px-6 py-4 border-b border-slate-100">
                <h2 class="text-base font-bold text-[#0A5C66]">Form Surat Peminjaman</h2>
                <p class="text-xs text-[#64748B] mt-0.5">Lengkapi formulir di bawah ini untuk mengenerate surat
                    peminjaman inventaris.</p>
            </div>

            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Nomor
                            Surat</label>
                        <input type="text" name="nomor" placeholder="Nomor Surat" required
                            class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] px-4 py-2.5 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Penyelenggara</label>
                        <input type="text" name="penyelenggara" placeholder="Nama Penyelenggara" required
                            class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] px-4 py-2.5 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Prodi
                            Penyelenggara</label>
                        <input type="text" name="prodi" placeholder="Prodi Penyelenggara" required
                            class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] px-4 py-2.5 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Nama
                            Ketua LM</label>
                        <input type="text" name="nama_peminjam" placeholder="Nama Lengkap Ketua LM" required
                            class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] px-4 py-2.5 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">NIM
                            Ketua LM</label>
                        <input type="text" name="nim" placeholder="NIM Ketua LM" required
                            class="block w-full rounded-xl border border-slate-200 bg-[#F8FAFC] px-4 py-2.5 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                    </div>
                </div>

                <div id="kegiatan-container" class="space-y-4 pt-4 border-t border-dashed border-slate-200">
                    <div class="kegiatan-row space-y-4 bg-slate-50/50 p-4 rounded-xl border border-slate-100 relative">
                        <div>
                            <label
                                class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Nama
                                Kegiatan</label>
                            <input type="text" name="kegiatan[0][nama_kegiatan]"
                                placeholder="Nama Kegiatan (ex: Gladi Day-1)" required
                                class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Hari
                                    Kegiatan</label>
                                <input type="text" name="kegiatan[0][hari]" placeholder="Hari Kegiatan (ex: Kamis)"
                                    required
                                    class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Tanggal
                                    Kegiatan</label>
                                <input type="date" name="kegiatan[0][tanggal]" required
                                    class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs text-gray-400 focus:text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label
                                    class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Waktu
                                    Mulai</label>
                                <input type="text" name="kegiatan[0][waktu_mulai]" placeholder="Waktu Mulai (ex: 10.00)"
                                    required
                                    class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Waktu
                                    Selesai</label>
                                <input type="text" name="kegiatan[0][waktu_selesai]"
                                    placeholder="Waktu Selesai (ex: 19.00)" required
                                    class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" id="btn-add-kegiatan"
                    class="w-full py-3 border-2 border-dashed border-slate-200 hover:border-[#0A5C66] rounded-xl flex justify-center items-center text-slate-400 hover:text-[#0A5C66] transition bg-white mt-4">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 px-6 py-4 shadow-2xl z-50">
            <div class="max-w-4xl mx-auto flex justify-between items-center">
                <a href="#"
                    class="rounded-xl border border-slate-200 px-6 py-2.5 text-xs font-bold text-slate-500 hover:bg-slate-50 transition">
                    Kembali
                </a>
                <button type="submit"
                    class="rounded-xl bg-[#0A5C66] px-6 py-2.5 text-xs font-bold text-white shadow-md hover:bg-[#084952] transition">
                    Kirim Peminjaman
                </button>
            </div>
        </div>
    </form>

    <template id="kegiatan-row-template">
        <div class="kegiatan-row space-y-4 bg-slate-50/50 p-4 rounded-xl border border-slate-100 relative pt-8">
            <button type="button" onclick="removeRow(this)"
                class="absolute top-2 right-2 p-1 text-rose-500 hover:bg-rose-50 rounded-lg transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div>
                <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Nama
                    Kegiatan</label>
                <input type="text" name="kegiatan[{index}][nama_kegiatan]" placeholder="Nama Kegiatan (ex: Gladi Day-1)"
                    required
                    class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Hari
                        Kegiatan</label>
                    <input type="text" name="kegiatan[{index}][hari]" placeholder="Hari Kegiatan (ex: Kamis)" required
                        class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Tanggal
                        Kegiatan</label>
                    <input type="date" name="kegiatan[{index}][tanggal]" required
                        class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs text-gray-400 focus:text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Waktu
                        Mulai</label>
                    <input type="text" name="kegiatan[{index}][waktu_mulai]" placeholder="Waktu Mulai (ex: 10.00)"
                        required
                        class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-[#64748B] uppercase tracking-wider mb-1.5">Waktu
                        Selesai</label>
                    <input type="text" name="kegiatan[{index}][waktu_selesai]" placeholder="Waktu Selesai (ex: 19.00)"
                        required
                        class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs text-gray-900 focus:border-[#0A5C66] focus:ring-[#0A5C66] transition">
                </div>
            </div>
        </div>
    </template>

    <script>
        let kegiatanIndex = 1;

        document.getElementById('btn-add-kegiatan').addEventListener('click', function () {
            const container = document.getElementById('kegiatan-container');
            const template = document.getElementById('kegiatan-row-template').innerHTML;

            // Ganti placeholder {index} dengan angka indeks dinamis saat ini
            const newRowHtml = template.replace(/{index}/g, kegiatanIndex);

            // Sisipkan elemen HTML baru ke dalam container
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = newRowHtml;
            container.appendChild(tempDiv.firstElementChild);

            kegiatanIndex++;
        });

        function removeRow(button) {
            // Hapus kepingan box sub-kegiatan tertentu
            button.closest('.kegiatan-row').remove();
        }
    </script>
</body>
</html>