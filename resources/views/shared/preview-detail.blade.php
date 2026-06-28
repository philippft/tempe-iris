<div class="bg-slate-100 p-10 flex justify-center rounded-b-xl">
    <div class="w-[794px] min-h-[1123px] bg-white shadow-lg border p-20 text-[15px] leading-8 text-black">

        {{-- Header Surat --}}
        <div class="flex justify-between items-start">
            <div class="space-y-1">
                <p>Nomor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $surat->nomor }}</p>
                <p>Lampiran : 1 (Satu)</p>
                <p>Hal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                    {{ $surat->perihal_peminjaman }}
                </p>
            </div>

            <div>
                Jimbaran,
                {{ $surat->created_at->translatedFormat('d F Y') }}
            </div>
        </div>

        {{-- Tujuan --}}
        <div class="mt-12">
            <p>Yth. <strong>{{ $tujuan }}</strong></p>
            <p>Universitas Udayana</p>
            <p>di Jimbaran</p>
        </div>

        {{-- Isi Surat --}}
        <div class="mt-10 text-justify">
            <p class="underline font-semibold">
                Dengan Hormat,
            </p>

            <p class="mt-5 indent-10">
                Dalam rangka melaksanakan kegiatan
                <strong>{{ $surat->acara }}</strong>,
                yang diselenggarakan oleh
                {{ $surat->user->organization->name }},
                Fakultas Matematika dan Ilmu Pengetahuan Alam Universitas Udayana,
                maka kami bermaksud mengajukan Permohonan Peminjaman Inventaris
                (terlampir). Adapun kegiatan tersebut akan diselenggarakan pada:
            </p>
        </div>

        {{-- Detail Kegiatan --}}
        <div class="mt-8 space-y-7">

            @foreach($detail_kegiatan as $kegiatan)

                <div class="pl-10">

                    <p class="font-semibold mb-2">
                        {{ $kegiatan->nama_kegiatan }}
                    </p>

                    <table class="ml-6 border-collapse">
                        <tr>
                            <td class="w-32 align-top">
                                Hari, tanggal
                            </td>
                            <td class="w-5">:</td>
                            <td>
                                {{ $kegiatan->hari_mulai }}, {{ $kegiatan->tanggal_kegiatan }}
                            </td>
                        </tr>

                        <tr>
                            <td class="align-top">
                                Waktu
                            </td>
                            <td>:</td>
                            <td>
                                {{ $kegiatan->waktu_mulai }} - {{ $kegiatan->waktu_selesai }} WITA
                            </td>
                        </tr>
                    </table>
                </div>
            @endforeach
        </div>

        {{-- Penutup --}}
        <div class="mt-10 text-justify">
            <p class="indent-10">
                Demikian surat peminjaman ini kami sampaikan. Atas kerja sama dan
                dukungan yang diberikan, kami ucapkan terima kasih.
            </p>
        </div>

        {{-- TTD --}}
        <div class="flex justify-end mt-24">
            <div class="text-center w-64">
                <p>
                    Panitia Pelaksana
                </p>
                <p>
                    {{ $surat->acara }}
                    ({{ $singkatanAcara }})
                </p>
                <div class="h-28"></div>
                <p class="font-semibold">
                    {{ $surat->user->organization->name }}
                </p>
            </div>
        </div>
    </div>
</div>