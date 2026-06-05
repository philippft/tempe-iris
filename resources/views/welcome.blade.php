<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TEMPE IRIS - Peminjaman Inventaris FMIPA</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 
                        sans: ['Plus Jakarta Sans', 'sans-serif'] 
                    },
                    colors: {
                        primary: '#2E6F82', 
                        'primary-hover': '#095769',
                        'bg-light': '#FAF8FF',
                        'bg-dark': '#F2F3FF', 
                        'subtext': '#40484B',
                        'judul': '#131B2E',
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased text-judul bg-bg-light">

    <x-navbar active="beranda" />
    <section class="max-w-7xl mx-auto py-16 md:py-24"> 
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

    <section class="bg-bg-dark py-16">
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

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-12">
                <h2 class="text-[32px] font-bold text-judul mb-2">Fitur Unggulan</h2>
                <p class="text-subtext text-base">Solusi komprehensif untuk setiap stakeholder di lingkungan FMIPA.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-bg-dark p-6 rounded-xl border border-gray-100">
                    <div class="bg-primary w-10 h-10 rounded-lg flex items-center justify-center mb-4 text-primary shadow-sm">
                        <svg class="w-5 h-5 backdrop-opacity-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="font-bold text-judul mb-2 text-xl">Hak Akses Spesifik</h3>
                    <p class="text-sm text-subtext leading-relaxed">Dashboard khusus untuk Mahasiswa, Admin LM, hingga Dekanat dengan izin yang terenkripsi.</p>
                </div>
                <div class="bg-bg-dark p-6 rounded-xl border border-gray-100">
                    <div class="bg-primary w-10 h-10 rounded-lg flex items-center justify-center mb-4 text-primary shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.965 11.965 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="font-bold text-judul mb-2 text-xl">Validasi Multi-Level</h3>
                    <p class="text-sm text-subtext leading-relaxed">Alur persetujuan hierarkis yang menyesuaikan regulasi birokrasi universitas secara otomatis.</p>
                </div>
                <div class="bg-bg-dark p-6 rounded-xl border border-gray-100">
                    <div class="bg-primary w-10 h-10 rounded-lg flex items-center justify-center mb-4 text-primary shadow-sm">
                        <svg class="w-5 h-5 backdrop-opacity-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="font-bold text-judul mb-2 text-xl">Surat Otomatis</h3>
                    <p class="text-sm text-subtext leading-relaxed">Hasilkan formulir peminjaman dalam format PDF secara instan setelah disetujui oleh atasan.</p>
                </div>
                <div class="bg-bg-dark p-6 rounded-xl border border-gray-100">
                    <div class="bg-primary w-10 h-10 rounded-lg flex items-center justify-center mb-4 text-primary shadow-sm">
                        <svg class="w-5 h-5 backdrop-opacity-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="font-bold text-judul mb-2 text-xl">Tracking Real-Time</h3>
                    <p class="text-sm text-subtext leading-relaxed">Monitoring pergerakan barang dan status ketersediaan inventaris secara langsung di peta digital.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-bg-dark py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-judul mb-2">Bagaimana Cara Meminjam?</h2>
                <p class="text-subtext text-sm">Proses mudah hanya dalam 4 langkah sederhana.</p>
            </div>

            <div class="relative max-w-5xl mx-auto">
                <div class="hidden md:block absolute top-8 left-12 right-12 h-[2px] bg-gray-200 z-0"></div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative z-10">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-white border-4 border-bg-light shadow-sm rounded-full flex items-center justify-center text-xl font-bold text-primary mx-auto mb-4">1</div>
                        <h4 class="font-bold text-gray-900 text-sm mb-1">Cari & Ajukan</h4>
                        <p class="text-xs text-gray-500 px-4">Pilih barang di katalog digital dan tentukan durasi peminjaman.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-white border-4 border-bg-light shadow-sm rounded-full flex items-center justify-center text-xl font-bold text-primary mx-auto mb-4">2</div>
                        <h4 class="font-bold text-gray-900 text-sm mb-1">Auto-Generate</h4>
                        <p class="text-xs text-gray-500 px-4">Sistem membuat dokumen peminjaman secara otomatis untuk divalidasi.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-white border-4 border-bg-light shadow-sm rounded-full flex items-center justify-center text-xl font-bold text-primary mx-auto mb-4">3</div>
                        <h4 class="font-bold text-gray-900 text-sm mb-1">Validasi Digital</h4>
                        <p class="text-xs text-gray-500 px-4">Persetujuan berjenjang dari Admin hingga Petinggi FMIPA.</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary border-4 border-bg-light shadow-sm rounded-full flex items-center justify-center text-xl font-bold text-white mx-auto mb-4">4</div>
                        <h4 class="font-bold text-gray-900 text-sm mb-1">Ambil & Gunakan</h4>
                        <p class="text-xs text-gray-500 px-4">Dapatkan notifikasi dan ambil barang di sekre dengan QR Code.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pb-24 px-6">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-100">
            <h2 class="text-3xl font-bold text-primary mb-4">Siap untuk meminjam barang?</h2>
            <p class="text-gray-500 text-sm mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan mahasiswa FMIPA yang telah beralih ke sistem digital yang lebih cepat dan transparan.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#" class="bg-primary hover:bg-primary-hover text-white px-8 py-3 rounded-md font-medium transition shadow-sm text-sm">
                    Daftar Sekarang
                </a>
                <a href="#" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-8 py-3 rounded-md font-medium transition text-sm">
                    Hubungi Bantuan
                </a>
            </div>
        </div>
    </section>

    <x-footer />

</body>
</html>