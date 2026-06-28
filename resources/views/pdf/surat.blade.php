<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan Peminjaman Inventaris & Lampiran</title>
    <style>
        @page {
            margin: 1.2in 1in 1in 1in;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #000;
        }

        .content {
            width: 100%;
        }

        /* ----- STYLING HALAMAN 1 (SURAT) ----- */
        .info-table {
            width: 100%;
            margin-bottom: 25px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .isi-surat {
            text-align: justify;
            margin-bottom: 20px;
        }

        .jadwal-container {
            margin-left: 20px;
            margin-bottom: 20px;
        }

        .jadwal-title {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .jadwal-detail {
            margin-left: 15px;
            margin-bottom: 10px;
        }

        .jadwal-detail table td {
            padding: 2px 0;
        }

        .ttd-container {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
        }

        .ttd-container td {
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .stempel-container {
            margin-top: 5px;
            text-align: center;
        }

        .stempel-img {
            width: 140px;
            /* Sesuaikan ukuran cap dengan kebutuhan */
            height: auto;
            opacity: 0.9;
            /* Sedikit transparan agar terlihat seperti cap asli */
        }

        /* ----- STYLING HALAMAN 2 (LAMPIRAN) ----- */

        /* Memaksa elemen setelah class ini untuk pindah ke halaman baru saat di-print/PDF */
        .page-break {
            page-break-before: always;
        }

        .table-lampiran {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            /* Sedikit dikecilkan agar pas di tabel */
        }

        .table-lampiran th,
        .table-lampiran td {
            border: 1px solid #cbd5e1;
            /* Warna border abu-abu muda */
            padding: 12px 10px;
            vertical-align: middle;
        }

        .table-lampiran th {
            background-color: #e2e8f0;
            /* Warna biru muda keabuan mirip di gambar */
            font-weight: bold;
            color: #1e293b;
        }

        .table-lampiran th:first-child,
        .table-lampiran th:nth-child(3),
        .table-lampiran th:nth-child(4),
        .table-lampiran th:nth-child(5) {
            text-align: center;
        }

        .table-lampiran th:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="content">
        <table class="info-table">
            <tr>
                <td style="width: 12%;">Nomor</td>
                <td style="width: 3%;">:</td>
                <td style="width: 50%;">{{ $surat->nomor }}</td>
                <td style="text-align: right; width: 35%;">
                    {{ $surat->created_at->locale('id')->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td colspan="2">1 (Satu)</td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>:</td>
                <td colspan="2">{{ $surat->perihal_peminjaman }}</td>
            </tr>
        </table>

        <div style="margin-bottom: 25px;">
            Yth. <strong>{{ $tujuan }}</strong><br>
            Universitas Udayana</strong><br>
            di Jimbaran
        </div>

        <div style="margin-bottom: 15px;">
            <u>Dengan Hormat,</u>
        </div>

        <div class="isi-surat">
            Dalam rangka melaksanakan kegiatan {{ $surat->acara }}, yang diselenggarakan oleh
            {{ $surat->penyelenggara }} Fakultas MIPA Universitas Udayana, maka kami bermaksud untuk mengajukan
            Permohonan Peminjaman Inventaris (terlampir). Adapun kegiatan tersebut akan diselenggarakan pada:
        </div>

        @foreach ($detail_kegiatan as $k)
            <div class="jadwal-container">
                <div class="jadwal-title">{{ $k['nama_kegiatan'] }}</div>
                <div class="jadwal-detail">
                    <table cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="width: 100px;">Hari, tanggal</td>
                            <td style="width: 15px;">:</td>
                            <td>{{ $k['hari_mulai'] }}, {{ $k['tanggal_kegiatan'] }}</td>
                        </tr>
                        <tr>
                            <td>Waktu</td>
                            <td>:</td>
                            <td>{{ $k['waktu_mulai'] }} – {{ $k['waktu_selesai'] }} WITA</td>
                        </tr>
                    </table>
                </div>
            </div>
        @endforeach

        <div class="isi-surat">
            Demikian surat peminjaman ini kami sampaikan. Atas kerja sama dan dukungan yang diberikan, kami ucapkan
            terima kasih.
        </div>

        <table class="ttd-container">
            <tr>
                <td style="width: 60%;"></td>
                <td style="width: 40%;" class="text-center">
                    Panitia Pelaksana<br>
                    {{ $surat->acara }} ({{ $singkatanAcara }})<br>
                    Universitas Udayana
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center" style="padding-top: 60px;">
                    Mengetahui,<br>
                    {{ $surat->prodi }} FMIPA UNUD 2026

                    @if ($surat->status_peminjaman === '1' || $surat->status_peminjaman === 'Approved')
                        <div class="stempel-container">
                            {{-- Ganti URL src dengan path gambar cap Anda (bisa pakai asset() atau base64 untuk PDF) --}}
                            <img src="{{ asset('images/cap_panpel.png'); }}" alt="Cap PANPEL" class="stempel-img">
                        </div>
                    @else
                        <div class="stempel-container" style="height: 140px;"></div>
                    @endif

                </td>
            </tr>
        </table>
    </div>

    <div class="page-break"></div>

    <div class="content">
        <table class="table-lampiran">
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 25%;">Alat</th>
                    <th style="width: 15%;">Jumlah</th>
                    <th style="width: 25%;">Waktu dan Tanggal<br>Peminjaman</th>
                    <th style="width: 30%;">Waktu dan Tanggal<br>Pengembalian</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventaris as $inv)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $inv['nama_inventaris'] }}</td>
                        <td class="text-center">{{ $inv['jumlah'] }}</td>
                        <td class="text-center">{{ $inv['waktu_peminjaman'] }} WITA
                            <br>{{ $inv['tanggal_peminjaman'] }}</td>
                        <td class="text-center">{{ $inv['waktu_kembali'] }} WITA <br>{{ $inv['tanggal_kembali'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
