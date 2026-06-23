<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TEMPE IRIS - Peminjaman Inventaris FMIPA</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite('resources/css/app.css')
</head>
<body class="font-sans antialiased text-judul bg-bg-light">

    <x-navbar active="beranda" />
    <section class="max-w-7xl mx-auto py-16 md:py-24" id="beranda"> 
        <div class="grid grid-cols-1 md:grid-cols-2 gap-11 items-center">
            <div>
                <h1 class="text-3xl md:text-[40px] font-bold text-judul leading-tight mb-6">
                    Transformasi Digital<br>Peminjaman Inventaris <span class="text-primary">FMIPA</span>
                </h1>
                <p class="text-lg text-subtext mb-8 leading-relaxed">
                    Mempercepat birokrasi kampus melalui sistem peminjaman aset yang transparan, otomatis, dan terpadu. Dari mahasiswa untuk efisiensi institusi.
                </p>
                <div class="flex flex-wrap gap-4">
                    <x-button href="#" variant="primary">
                        Mulai Pinjam Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </x-button>
                    <x-button href="#" variant="secondary">
                        Lihat Panduan
                    </x-button>
                </div>
            </div>
            <div class="relative">
                <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard Mockup" class="rounded-xl shadow-2xl object-cover w-full h-87.5">
            </div>
        </div>
    </section>

    <section class="bg-bg-dark py-24">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-judul mb-3">Mengapa TEMPE IRIS?</h2>
                <p class="text-subtext">Solusi modern untuk tantangan pengelolaan aset kampus.</p>
            </div>

            <!-- kotak yang kiri yang merah -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-7xl mx-auto">
                <div class="bg-white border border-red-200 rounded-2xl p-8 shadow-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <svg width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.5625 22.5L0 15.9375V6.5625L6.5625 0H15.9375L22.5 6.5625V15.9375L15.9375 22.5H6.5625ZM7.6875 16.5625L11.25 13L14.8125 16.5625L16.5625 14.8125L13 11.25L16.5625 7.6875L14.8125 5.9375L11.25 9.5L7.6875 5.9375L5.9375 7.6875L9.5 11.25L5.9375 14.8125L7.6875 16.5625ZM7.625 20H14.875L20 14.875V7.625L14.875 2.5H7.625L2.5 7.625V14.875L7.625 20Z" fill="#BA1A1A"/>
                        </svg>
                        <h3 class="text-2xl font-bold text-red-700">Sistem Manual (Lama)</h3>
                    </div>
                    <ul class="space-y-5">
                        <li class="flex gap-3 items-start">
                            <span class="text-red-700 font-bold">✕</span>
                            <div>
                                <h4 class="font-semibold text-judul text-base">Risiko Kehilangan Dokumen</h4>
                                <p class="text-sm text-subtext mt-0.5">Surat fisik sering tercecer atau hilang di tumpukan berkas admin.</p>
                            </div>
                        </li>
                        <li class="flex gap-3 items-start">
                            <span class="text-red-700 font-bold">✕</span>
                            <div>
                                <h4 class="font-semibold text-judul text-base">Birokrasi Lambat</h4>
                                <p class="text-sm text-subtext mt-0.5">Memerlukan tanda tangan basah yang menyita waktu antar departemen.</p>
                            </div>
                        </li>
                        <li class="flex gap-3 items-start">
                            <span class="text-red-700 font-bold">✕</span>
                            <div>
                                <h4 class="font-semibold text-judul text-base">Data Tidak Akurat</h4>
                                <p class="text-sm text-subtext mt-0.5">Sulit mengetahui ketersediaan barang secara real-time.</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="bg-primary border rounded-2xl p-8 shadow-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.75 18.25L19.5625 9.4375L17.8125 7.6875L10.75 14.75L7.1875 11.1875L5.4375 12.9375L10.75 18.25ZM12.5 25C10.7708 25 9.14583 24.6719 7.625 24.0156C6.10417 23.3594 4.78125 22.4688 3.65625 21.3438C2.53125 20.2188 1.64062 18.8958 0.984375 17.375C0.328125 15.8542 0 14.2292 0 12.5C0 10.7708 0.328125 9.14583 0.984375 7.625C1.64062 6.10417 2.53125 4.78125 3.65625 3.65625C4.78125 2.53125 6.10417 1.64062 7.625 0.984375C9.14583 0.328125 10.7708 0 12.5 0C14.2292 0 15.8542 0.328125 17.375 0.984375C18.8958 1.64062 20.2188 2.53125 21.3438 3.65625C22.4688 4.78125 23.3594 6.10417 24.0156 7.625C24.6719 9.14583 25 10.7708 25 12.5C25 14.2292 24.6719 15.8542 24.0156 17.375C23.3594 18.8958 22.4688 20.2188 21.3438 21.3438C20.2188 22.4688 18.8958 23.3594 17.375 24.0156C15.8542 24.6719 14.2292 25 12.5 25ZM12.5 22.5C15.2917 22.5 17.6562 21.5312 19.5938 19.5938C21.5312 17.6562 22.5 15.2917 22.5 12.5C22.5 9.70833 21.5312 7.34375 19.5938 5.40625C17.6562 3.46875 15.2917 2.5 12.5 2.5C9.70833 2.5 7.34375 3.46875 5.40625 5.40625C3.46875 7.34375 2.5 9.70833 2.5 12.5C2.5 15.2917 3.46875 17.6562 5.40625 19.5938C7.34375 21.5312 9.70833 22.5 12.5 22.5Z" fill="white"/>
                        </svg>

                        <h3 class="text-2xl font-bold text-white">TEMPE IRIS (Digital)</h3>
                    </div>
                    <ul class="space-y-5">
                        <li class="flex gap-3 items-start">
                            <svg width="22" height="25" viewBox="0 0 22 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.6 25L5.7 21.8L2.1 21L2.45 17.3L0 14.5L2.45 11.7L2.1 8L5.7 7.2L7.6 4L11 5.45L14.4 4L16.3 7.2L19.9 8L19.55 11.7L22 14.5L19.55 17.3L19.9 21L16.3 21.8L14.4 25L11 23.55L7.6 25ZM8.45 22.45L11 21.35L13.6 22.45L15 20.05L17.75 19.4L17.5 16.6L19.35 14.5L17.5 12.35L17.75 9.55L15 8.95L13.55 6.55L11 7.65L8.4 6.55L7 8.95L4.25 9.55L4.5 12.35L2.65 14.5L4.5 16.6L4.25 19.45L7 20.05L8.45 22.45ZM9.95 18.05L15.6 12.4L14.2 10.95L9.95 15.2L7.8 13.1L6.4 14.5L9.95 18.05Z" fill="#6FFBBE"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-judul text-white">Aman & Terpusat</h4>
                                <p class="text-sm text-[#BFEEFF] mt-0.5">Seluruh riwayat dan dokumen tersimpan permanen di server cloud.</p>
                            </div>
                        </li>
                        <li class="flex gap-3 items-start">
                            <svg width="22" height="25" viewBox="0 0 22 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.6 25L5.7 21.8L2.1 21L2.45 17.3L0 14.5L2.45 11.7L2.1 8L5.7 7.2L7.6 4L11 5.45L14.4 4L16.3 7.2L19.9 8L19.55 11.7L22 14.5L19.55 17.3L19.9 21L16.3 21.8L14.4 25L11 23.55L7.6 25ZM8.45 22.45L11 21.35L13.6 22.45L15 20.05L17.75 19.4L17.5 16.6L19.35 14.5L17.5 12.35L17.75 9.55L15 8.95L13.55 6.55L11 7.65L8.4 6.55L7 8.95L4.25 9.55L4.5 12.35L2.65 14.5L4.5 16.6L4.25 19.45L7 20.05L8.45 22.45ZM9.95 18.05L15.6 12.4L14.2 10.95L9.95 15.2L7.8 13.1L6.4 14.5L9.95 18.05Z" fill="#6FFBBE"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-judul text-white">Validasi Digital Berjenjang</h4>
                                <p class="text-sm text-[#BFEEFF] mt-0.5">Persetujuan instan melalui sistem notifikasi dashboard.</p>
                            </div>
                        </li>
                        <li class="flex gap-3 items-start">
                            <svg width="22" height="25" viewBox="0 0 22 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.6 25L5.7 21.8L2.1 21L2.45 17.3L0 14.5L2.45 11.7L2.1 8L5.7 7.2L7.6 4L11 5.45L14.4 4L16.3 7.2L19.9 8L19.55 11.7L22 14.5L19.55 17.3L19.9 21L16.3 21.8L14.4 25L11 23.55L7.6 25ZM8.45 22.45L11 21.35L13.6 22.45L15 20.05L17.75 19.4L17.5 16.6L19.35 14.5L17.5 12.35L17.75 9.55L15 8.95L13.55 6.55L11 7.65L8.4 6.55L7 8.95L4.25 9.55L4.5 12.35L2.65 14.5L4.5 16.6L4.25 19.45L7 20.05L8.45 22.45ZM9.95 18.05L15.6 12.4L14.2 10.95L9.95 15.2L7.8 13.1L6.4 14.5L9.95 18.05Z" fill="#6FFBBE"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-judul text-white">Live Tracking</h4>
                                <p class="text-sm text-[#BFEEFF] mt-0.5">Cek status peminjaman dan lokasi barang terintegrasi.</p>
                            </div>
                        </li>
                    </ul>
                </div>

                
                <!-- kotak yang kanan yang ijo -->
                <!-- <div class="bg-primary rounded-xl p-8 text-white shadow-lg">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="bg-white/10 p-2 rounded-full border border-white/20">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold">TEMPE IRIS (Digital)</h3>
                    </div>
                    <ul class="space-y-5">
                        <li class="flex gap-3 items-start">
                            <span class="text-teal-300 font-bold">✓</span>
                            <div>
                                <h4 class="font-semibold text-sm">Aman & Terpusat</h4>
                                <p class="text-xs text-teal-100/80 mt-0.5">Seluruh riwayat dan dokumen tersimpan permanen di server cloud.</p>
                            </div>
                        </li>
                        <li class="flex gap-3 items-start">
                            <span class="text-teal-300 font-bold">✓</span>
                            <div>
                                <h4 class="font-semibold text-sm">Validasi Digital Berjenjang</h4>
                                <p class="text-xs text-teal-100/80 mt-0.5">Persetujuan instan melalui sistem notifikasi dashboard.</p>
                            </div>
                        </li>
                        <li class="flex gap-3 items-start">
                            <span class="text-teal-300 font-bold">✓</span>
                            <div>
                                <h4 class="font-semibold text-sm">Live Tracking</h4>
                                <p class="text-xs text-teal-100/80 mt-0.5">Cek status peminjaman dan lokasi barang terintegrasi.</p>
                            </div>
                        </li>
                    </ul>
                </div> -->
            </div>
        </div>
    </section>

    <section class="py-24" id="fitur">
        <div class="max-w-7xl mx-auto">
            <div class="mb-12">
                <h2 class="text-[32px] font-bold text-judul mb-2">Fitur Unggulan</h2>
                <p class="text-subtext text-base">Solusi komprehensif untuk setiap stakeholder di lingkungan FMIPA.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <x-feature-card title="Hak Akses Spesifik" description="Dashboard khusus untuk Mahasiswa, Admin LM, hingga Dekanat dengan izin yang terenkripsi.">
                    <x-slot:icon>
                        <svg width="18" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 21L6 18H2C1.45 18 0.979167 17.8042 0.5875 17.4125C0.195833 17.0208 0 16.55 0 16V2C0 1.45 0.195833 0.979167 0.5875 0.5875C0.979167 0.195833 1.45 0 2 0H16C16.55 0 17.0208 0.195833 17.4125 0.5875C17.8042 0.979167 18 1.45 18 2V16C18 16.55 17.8042 17.0208 17.4125 17.4125C17.0208 17.8042 16.55 18 16 18H12L9 21ZM2 14.85C2.9 13.9667 3.94583 13.2708 5.1375 12.7625C6.32917 12.2542 7.61667 12 9 12C10.3833 12 11.6708 12.2542 12.8625 12.7625C14.0542 13.2708 15.1 13.9667 16 14.85V2H2V14.85ZM9 10C9.96667 10 10.7917 9.65833 11.475 8.975C12.1583 8.29167 12.5 7.46667 12.5 6.5C12.5 5.53333 12.1583 4.70833 11.475 4.025C10.7917 3.34167 9.96667 3 9 3C8.03333 3 7.20833 3.34167 6.525 4.025C5.84167 4.70833 5.5 5.53333 5.5 6.5C5.5 7.46667 5.84167 8.29167 6.525 8.975C7.20833 9.65833 8.03333 10 9 10ZM4 16H14C14 15.95 14 15.9083 14 15.875C14 15.8417 14 15.8 14 15.75C13.3 15.1667 12.525 14.7292 11.675 14.4375C10.825 14.1458 9.93333 14 9 14C8.06667 14 7.175 14.1458 6.325 14.4375C5.475 14.7292 4.7 15.1667 4 15.75C4 15.8 4 15.8417 4 15.875C4 15.9083 4 15.95 4 16ZM9 8C8.58333 8 8.22917 7.85417 7.9375 7.5625C7.64583 7.27083 7.5 6.91667 7.5 6.5C7.5 6.08333 7.64583 5.72917 7.9375 5.4375C8.22917 5.14583 8.58333 5 9 5C9.41667 5 9.77083 5.14583 10.0625 5.4375C10.3542 5.72917 10.5 6.08333 10.5 6.5C10.5 6.91667 10.3542 7.27083 10.0625 7.5625C9.77083 7.85417 9.41667 8 9 8Z" fill="#095769"/>
                        </svg>
                    </x-slot:icon>
                </x-feature-card>

                <x-feature-card title="Validasi Multi-Level" description="Alur persetujuan hierarkis yang menyesuaikan regulasi birokrasi universitas secara otomatis.">
                    <x-slot:icon>
                        <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13 18V15H9V5H7V8H0V0H7V3H13V0H20V8H13V5H11V13H13V10H20V18H13ZM2 2V6V2ZM15 12V16V12ZM15 2V6V2ZM15 6H18V2H15V6ZM15 16H18V12H15V16ZM2 6H5V2H2V6Z" fill="#095769"/>
                        </svg>
                    </x-slot:icon>
                </x-feature-card>

                <x-feature-card title="Surat Otomatis" description="Hasilkan formulir peminjaman dalam format PDF secara instan setelah disetujui oleh atasan.">
                    <x-slot:icon>
                        <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 16H12V14H4V16ZM4 12H12V10H4V12ZM2 20C1.45 20 0.979167 19.8042 0.5875 19.4125C0.195833 19.0208 0 18.55 0 18V2C0 1.45 0.195833 0.979167 0.5875 0.5875C0.979167 0.195833 1.45 0 2 0H10L16 6V18C16 18.55 15.8042 19.0208 15.4125 19.4125C15.0208 19.8042 14.55 20 14 20H2ZM9 7V2H2V18H14V7H9ZM2 2V7V2V7V18V2Z" fill="#095769"/>
                        </svg>
                    </x-slot:icon>
                </x-feature-card>

                <x-feature-card title="Tracking Real-Time" description="Monitoring pergerakan barang dan status ketersediaan inventaris secara langsung di peta digital.">
                    <x-slot:icon>
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 18V16L2 14V18H0ZM4 18V12L6 10V18H4ZM8 18V10L10 12.025V18H8ZM12 18V12.025L14 10.025V18H12ZM16 18V8L18 6V18H16ZM0 12.825V10L7 3L11 7L18 0V2.825L11 9.825L7 5.825L0 12.825Z" fill="#095769"/>
                        </svg>
                    </x-slot:icon>
                </x-feature-card>
            </div>
        </div>
    </section>

    <section class="bg-bg-dark py-24" id="alur-kerja">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-judul mb-3">Bagaimana Cara Meminjam?</h2>
                <p class="text-subtext text-base">Proses mudah hanya dalam 4 langkah sederhana.</p>
            </div>

            <div class="relative max-w-5xl mx-auto">
                <div class="hidden md:block absolute top-8 left-21 right-21 h-[2px] bg-border-custom z-0"></div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative z-10">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-white border-4 border-bg-light shadow-sm rounded-full flex items-center justify-center text-xl font-bold text-primary mx-auto mb-4 hover:bg-primary-hover hover:text-white transition-colors duration-300">1</div>
                        <h4 class="font-bold text-judul text-xl mb-1">Cari & Ajukan</h4>
                        <p class="text-sm text-subtext px-4">Pilih barang di katalog digital dan tentukan durasi peminjaman.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-white border-4 border-bg-light shadow-sm rounded-full flex items-center justify-center text-xl font-bold text-primary mx-auto mb-4 hover:bg-primary-hover hover:text-white transition-colors duration-300">2</div>
                        <h4 class="font-bold text-judul text-xl mb-1">Auto-Generate</h4>
                        <p class="text-sm text-subtext px-4">Sistem membuat dokumen peminjaman secara otomatis untuk divalidasi.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-white border-4 border-bg-light shadow-sm rounded-full flex items-center justify-center text-xl font-bold text-primary mx-auto mb-4 hover:bg-primary-hover hover:text-white transition-colors duration-300">3</div>
                        <h4 class="font-bold text-judul text-xl mb-1">Validasi Digital</h4>
                        <p class="text-sm text-subtext px-4">Persetujuan berjenjang dari Admin hingga Petinggi FMIPA.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-white border-4 border-bg-light shadow-sm rounded-full flex items-center justify-center text-xl font-bold text-primary mx-auto mb-4 hover:bg-primary-hover hover:text-white transition-colors duration-300">4</div>
                        <h4 class="font-bold text-judul text-xl mb-1">Ambil & Gunakan</h4>
                        <p class="text-sm text-subtext px-4">Dapatkan notifikasi dan ambil barang di sekre dengan QR Code.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-24 py-24 px-6">
        <div class="max-w-4xl mx-auto bg-bg-dark rounded-2xl p-12 text-center shadow-sm border border-border-custom">
            <h2 class="text-4xl font-bold text-primary mb-4">Siap untuk meminjam barang?</h2>
            <p class="text-subtext text-base mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan mahasiswa FMIPA yang telah beralih ke sistem digital yang lebih cepat dan transparan.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <x-button href="#" variant="primary" class="mb-4">
                    Daftar Sekarang
                </x-button>
                <x-button href="#" variant="secondary" class="mb-4">
                    Hubungi Bantuan
                </x-button>
            </div>
        </div>
    </section>

    <div id="tentang">
        <x-footer />
    </div>

</body>
</html>