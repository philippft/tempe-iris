<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Terverifikasi - TEMPE IRIS</title>
</head>

<body style="margin:0; padding:0; background-color:#e8f4f0; font-family: Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#e8f4f0; padding: 32px 16px;">
        <tr>
            <td align="center">
                <table width="480" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:16px; overflow:hidden; border: 1px solid #d1e8e2;">

                    {{-- HEADER --}}
                    <tr>
                        <td style="background:#0A5C66; padding: 36px 32px; text-align:center;">
                            <div
                                style="width:56px; height:56px; background:#ffffff; border-radius:50%; margin: 0 auto 14px; display:flex; align-items:center; justify-content:center;">
                                ✓
                            </div>
                            <div style="color:#ffffff; font-size:22px; font-weight:700; margin-bottom:4px;">TEMPE IRIS
                            </div>
                            <div style="color:#a8d8d0; font-size:13px;">Akun Terverifikasi Admin</div>
                        </td>
                    </tr>

                    {{-- BODY --}}
                    <tr>
                        <td style="padding: 32px 32px 24px;">

                            <p style="font-size:15px; color:#0f172a; margin:0 0 6px;">
                                Halo, <strong style="color:#0A5C66;">{{ $namaUser }}</strong> 👋
                            </p>
                            <p style="font-size:14px; color:#334155; margin:0 0 20px;">
                                Selamat datang di TEMPE IRIS (Sistem Peminjaman Inventaris)
                            </p>

                            <p style="font-size:13.5px; color:#475569; line-height:1.7; margin:0 0 16px;">
                                Kami ingin menginformasikan bahwa data pendaftaran dan foto KTM yang kamu unggah
                                telah divalidasi oleh Admin Lembaga Mahasiswa (LM). Saat ini, akunmu sudah aktif
                                sepenuhnya.
                            </p>

                            <p style="font-size:13.5px; color:#475569; line-height:1.7; margin:0 0 20px;">
                                Mulai sekarang, kamu sudah bisa menggunakan sistem untuk mempermudah persiapan
                                kegiatanmu. Berikut adalah beberapa hal yang bisa kamu lakukan:
                            </p>

                            {{-- CHECKLIST --}}
                            <table cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                                @foreach([
                                'Mengecek ketersediaan barang inventaris secara real-time.',
                                'Mengajukan peminjaman sarana dan prasarana dengan cepat.',
                                'Melacak status persetujuan surat peminjamanmu tanpa harus bertanya secara manual.',
                                ] as $item)
                                <tr>
                                    <td style="vertical-align:top; padding-bottom:10px;">
                                        <div
                                            style="width:18px; height:18px; background:#e1f5ee; border-radius:50%; text-align:center; line-height:18px; color:#0A5C66; font-size:11px; font-weight:bold; margin-right:10px;">
                                            ✓</div>
                                    </td>
                                    <td style="font-size:13px; color:#475569; line-height:1.6; padding-bottom:10px;">
                                        {{ $item }}
                                    </td>
                                </tr>
                                @endforeach
                            </table>

                            <p
                                style="font-size:13.5px; color:#475569; text-align:center; line-height:1.7; margin:0 0 24px;">
                                Silakan masuk ke akunmu menggunakan NIM dan password yang telah didaftarkan melalui
                                tautan di bawah ini:
                            </p>

                            {{-- BUTTON --}}
                            <div style="text-align:center; margin-bottom:28px;">
                                <a href="{{ route('login') }}" style="display:inline-block; background:#0A5C66; color:#ffffff; text-decoration:none;
                          font-size:14px; font-weight:600; padding:12px 28px; border-radius:10px;">
                                    Login Sekarang →
                                </a>
                            </div>

                            {{-- FOOTER NOTE --}}
                            <div style="border-top: 1px solid #e2e8f0; padding-top:20px;">
                                <p style="font-size:12px; color:#94a3b8; line-height:1.7; margin:0 0 12px;">
                                    <em>Jika kamu mengalami kendala saat login atau memiliki pertanyaan terkait
                                        peminjaman,
                                        jangan ragu untuk menghubungi Admin LM.</em>
                                </p>
                                <p style="font-size:12px; color:#94a3b8; margin:0 0 20px;">
                                    <em>Semoga persiapan kegiatanmu berjalan lancar!</em>
                                </p>
                                <p style="font-size:13px; color:#475569; margin:0;">Salam hangat,</p>
                                <p style="font-size:13px; font-weight:700; color:#0A5C66; margin:2px 0 0;">Tim Pengelola
                                    TEMPE IRIS</p>
                            </div>

                        </td>
                    </tr>

                    {{-- FOOTER --}}
                    <tr>
                        <td style="background:#0f172a; padding:20px 32px; text-align:center;">
                            <p style="color:#94a3b8; font-size:13px; font-weight:600; margin:0 0 8px;">Universitas
                                Udayana</p>
                            <p style="color:#475569; font-size:11px; margin:0 0 2px;">© {{ date('Y') }} | TEMPE IRIS –
                                Sistem Peminjaman Inventaris</p>
                            <p style="color:#475569; font-size:11px; margin:0;">Developed by Kelompok ADS Informatika
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>