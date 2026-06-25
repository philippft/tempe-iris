<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Inventaris;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. SEED CATEGORIES TERLEBIH DAHULU
        $categoriesData = [
            ['name' => 'Elektronik & Audio'],
            ['name' => 'Perlengkapan Acara'],
            ['name' => 'Kesekretariatan & ATK'],
            ['name' => 'Dokumentasi'],
            ['name' => 'Inventaris Ruangan'],
            ['name' => 'Konsumsi & Rumah Tangga'],
        ];

        // Simpan hasil collection categories untuk digunakan nanti
        $categories = Category::factory()
            ->count(count($categoriesData))
            ->sequence(...$categoriesData)
            ->create();

        // ==========================================
        // 2. SEED ORGANIZATIONS (Master Data)
        // ==========================================
        $organizationsData = [
            'DPM' => ['name' => 'Dewan Perwakilan Mahasiswa FMIPA'],
            'BEM' => ['name' => 'Badan Eksekutif Mahasiswa FMIPA'],
            'MAT' => ['name' => 'Himpunan Mahasiswa Matematika'],
            'FIS' => ['name' => 'Himpunan Mahasiswa Fisika'],
            'KIM' => ['name' => 'Himpunan Mahasiswa Kimia'],
            'BIO' => ['name' => 'Himpunan Mahasiswa Biologi'],
            'FAR' => ['name' => 'Himpunan Mahasiswa Farmasi'],
            'INF' => ['name' => 'Himpunan Mahasiswa Informatika'],
            'DEK' => ['name' => 'Dekanat FMIPA'],
            'NON' => ['name' => 'Non-Organisasi / Umum'],
        ];

        // Simpan instance ID ke dalam array penampung untuk memudahkan asosiasi FK
        $orgId = [];
        foreach ($organizationsData as $key => $org) {
            $createdOrg = Organization::factory()->create([
                'name' => $org['name']
            ]);
            $orgId[$key] = $createdOrg->id;
        }

        // Variable konstan nama mahasiswa lokalan biar realistis, cok!
        $namaKonstan = [
            'I Putu Ardyana Darma Nugraha',
            'I Gede Bagus Teja Wijaya',
            'Made Satya Pramana',
            'Ketut Agus Adi Putra',
            'Ni Wayan Sri Wahyuni',
            'Ni Luh Gede Kirana Dewi'
        ];

        $lmUsers = [];

        // ==========================================
        // 3. SEED USER INTI (DPM & BEM)
        // ==========================================
        $lmUsers[] = User::factory()->create([
            'id_organization' => $orgId['DPM'],
            'username'        => 'dpm_fmipa',
            'name'            => 'Ketua Umum DPM FMIPA',
            'role'            => 'admin_LM',
            'nim_nip'         => '2308561001',
            'verify_at'       => now(),
        ]);

        $lmUsers[] = User::factory()->create([
            'id_organization' => $orgId['BEM'],
            'username'        => 'bem_fmipa',
            'name'            => 'Presiden Mahasiswa BEM FMIPA',
            'role'            => 'admin_LM',
            'nim_nip'         => '2308561002',
            'verify_at'       => now(),
        ]);

        // ==========================================
        // 4. SEED USER HIMA PRODI
        // ==========================================
        $himaProdi = [
            ['slug' => 'himatika',  'org_key' => 'MAT', 'nama' => 'Ketua Himatika',  'nim' => '2408511001'],
            ['slug' => 'himafi',     'org_key' => 'FIS', 'nama' => 'Ketua Himafi',     'nim' => '2408521001'],
            ['slug' => 'himaki',     'org_key' => 'KIM', 'nama' => 'Ketua Himaki',     'nim' => '2408531001'],
            ['slug' => 'himabio',    'org_key' => 'BIO', 'nama' => 'Ketua Himabio',    'nim' => '2408541001'],
            ['slug' => 'himafarma',  'org_key' => 'FAR', 'nama' => 'Ketua Himafarma',  'nim' => '2408551001'],
            ['slug' => 'himaif',     'org_key' => 'INF', 'nama' => 'Ketua HimaIF',     'nim' => '2408561081'],
        ];

        foreach ($himaProdi as $hima) {
            $lmUsers[] = User::factory()->create([
                'id_organization' => $orgId[$hima['org_key']],
                'username'        => $hima['slug'],
                'name'            => $hima['nama'],
                'role'            => 'admin_LM',
                'ktm'             => fake()->boolean(50) ? 'uploads/ktm/' . fake()->uuid() . '.jpg' : null,
                'nim_nip'         => $hima['nim'],
                'verify_at'       => now(),
            ]);
        }

        // ==========================================
        // 5. SEED USER DEKANAT (PIMPINAN & ADMIN)
        // ==========================================
        User::factory()->create([
            'id_organization' => $orgId['DEK'],
            'username'        => 'admin_dekanat',
            'name'            => 'Staff Admin Dekanat FMIPA',
            'role'            => 'admin_dekanat',
            'nim_nip'         => '198503152010121001',
            'verify_at'       => now(),
        ]);

        User::factory()->create([
            'id_organization' => $orgId['DEK'],
            'username'        => 'dekan_fmipa',
            'name'            => 'Prof. Dr. Dekan FMIPA',
            'role'            => 'petinggi_dekanat',
            'nim_nip'         => '197305201999031002',
            'verify_at'       => now(),
        ]);

        // ==========================================
        // 6. SEED MAHASISWA UMUM (Menggunakan Variabel Nama Konstan)
        // ==========================================
        foreach ($namaKonstan as $index => $nama) {
            User::factory()->create([
                'id_organization' => $orgId['NON'], // Terikat ke entitas Non-Organisasi
                'username'        => 'mahasiswa_' . ($index + 1),
                'name'            => $nama, // 💡 Diambil dari array konstan atas
                'role'            => 'mahasiswa',
                'nim_nip'         => '24085610' . str_pad($index + 10, 2, '0', STR_PAD_LEFT),
                'ktm'             => 'uploads/ktm/ktm_dummy_' . ($index + 1) . '.jpg',
                'verify_at'       => fake()->boolean(50) ? now() : null, // Variasi 70% aktif, 30% pending (null)
            ]);
        }

        // 6. GENERATE 2 INVENTARIS UNTUK SETIAP LM
        // Daftar nama barang tiruan agar data inventaris terlihat realistis
        $barangDummy = [
            'Mikrofon Wireless',
            'Sound System Portable',
            'HT (Handy Talkie)',
            'Kabel XLR 10m',
            'Printer Inkjet',
            'Stapler Jilid Besar',
            'Papan Tulis Whiteboard',
            'Kamera DSLR',
            'Tripod Kamera',
            'Kipas Angin Berdiri',
            'Dispenser Air',
            'Teko Listrik Pompa'
        ];

        $barangDummy = [
            'Mikrofon Wireless',
            'Sound System Portable',
            'HT (Handy Talkie)',
            'Kabel XLR 10m',
            'Printer Inkjet',
            'Stapler Jilid Besar',
            'Papan Tulis Whiteboard',
            'Kamera DSLR',
            'Tripod Kamera',
            'Kipas Angin Berdiri',
            'Dispenser Air',
            'Teko Listrik Pompa'
        ];

        foreach ($lmUsers as $user) {
            for ($i = 1; $i <= 2; $i++) {
                $randomCategory = $categories->random();
                $namaBarang = fake()->randomElement($barangDummy) . ' ' . $user->username . ' ' . $i;

                $inventaris = Inventaris::create([
                    'id_user' => $user->id,
                    'id_category' => $randomCategory->id,
                    'nama' => $namaBarang,
                    'status_pinjam' => fake()->boolean(20), 
                    'deskripsi' => fake()->paragraph(2),
                    'image' => 'uploads/inventaris/' . fake()->uuid() . '.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                for ($j = 1; $j <= 5; $j++) {
                    \App\Models\Stock::create([
                        'id_inventaris' => $inventaris->id,
                        'status' => fake()->boolean(80) ? 1 : 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        $himaif = User::where('username', 'himaif')->firstOrFail();

        // Surat hanya boleh meminjam barang dari 1 LM saja.
        // Di sini HimaIF meminjam ke BEM FMIPA.
        $bemFmipa = User::where('username', 'bem_fmipa')->firstOrFail();

        // Ambil user LM tujuan
        $himafi = User::where('username', 'himafi')->firstOrFail();
        $himaki = User::where('username', 'himaki')->firstOrFail();

        // Ambil 2 inventaris dari masing-masing LM tujuan
        $inventarisDariBem   = Inventaris::where('id_user', $bemFmipa->id)->inRandomOrder()->take(2)->get();
        $inventarisDariHimafi = Inventaris::where('id_user', $himafi->id)->inRandomOrder()->take(2)->get();
        $inventarisDariHimaki = Inventaris::where('id_user', $himaki->id)->inRandomOrder()->take(2)->get();

        // Template kegiatan yang sama untuk semua surat HimaIF
        $templateKegiatan = [
            [
                'nama'          => 'Registrasi & Pembukaan',
                'hari_mulai'    => 'Senin',
                'offset_jam'    => [7, 30],
                'waktu_mulai'   => '07:30:00',
                'waktu_selesai' => '08:00:00',
            ],
            [
                'nama'          => 'Sesi Seminar Utama',
                'hari_mulai'    => 'Senin',
                'offset_jam'    => [8, 0],
                'waktu_mulai'   => '08:00:00',
                'waktu_selesai' => '12:00:00',
            ],
            [
                'nama'          => 'Penutupan & Dokumentasi',
                'hari_mulai'    => 'Senin',
                'offset_jam'    => [13, 0],
                'waktu_mulai'   => '13:00:00',
                'waktu_selesai' => '14:00:00',
            ],
        ];

        // Helper closure: insert detail + kegiatan untuk 1 surat
        $insertDetailDanKegiatan = function (int $suratId, $inventaris, int $subDaysAgo) use ($templateKegiatan) {
            foreach ($inventaris as $inv) {
                DB::table('detail_peminjaman')->insert([
                    'id_inventaris'  => $inv->id,
                    'id_surat'       => $suratId,
                    'qty_inventaris' => fake()->numberBetween(1, 3),
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }

            $kegiatan = array_map(fn($k) => [
                'id_surat'      => $suratId,
                'nama'          => $k['nama'],
                'hari_mulai'    => $k['hari_mulai'],
                'tanggal_mulai' => now()->subDays($subDaysAgo)->setTime($k['offset_jam'][0], $k['offset_jam'][1]),
                'waktu_mulai'   => $k['waktu_mulai'],
                'waktu_selesai' => $k['waktu_selesai'],
                'created_at'    => now(),
                'updated_at'    => now(),
            ], $templateKegiatan);

            DB::table('kegiatans')->insert($kegiatan);
        };

        // ── SURAT 1: HimaIF → BEM FMIPA ──────────────────────────────
        $surat1Id = DB::table('surat')->insertGetId([
            'id_user'              => $himaif->id,
            'nomor'                => 'SRT/HIMAIF/2025/001',
            'status_peminjaman'    => true,
            'catatan_peminjaman'   => 'Barang digunakan untuk keperluan acara seminar prodi.',
            'perihal_peminjaman'   => 'Peminjaman Perlengkapan Seminar',
            'tanggal_peminjaman'   => now()->subDays(10),
            'tanggal_kembali'      => now()->subDays(7),
            'tandatangan_pimpinan' => true,
            'penyelenggara'        => 'HimaIF',
            'acara'                => 'Seminar Teknologi',
            'singkatan_acara'      => 'SETOK',
            'prodi'                => 'Informatika',
            'nama_peminjam'        => 'Budi Santoso',
            'nim'                  => '2408561081',
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);
        $insertDetailDanKegiatan($surat1Id, $inventarisDariBem, 10);

        // ── SURAT 2: HimaIF → HimaFi ─────────────────────────────────
        $surat2Id = DB::table('surat')->insertGetId([
            'id_user'              => $himaif->id,
            'nomor'                => 'SRT/HIMAIF/2025/002',
            'status_peminjaman'    => true,
            'catatan_peminjaman'   => 'Peminjaman peralatan untuk workshop fisika terapan.',
            'perihal_peminjaman'   => 'Peminjaman Peralatan Workshop',
            'tanggal_peminjaman'   => now()->subDays(6),
            'tanggal_kembali'      => now()->subDays(3),
            'tandatangan_pimpinan' => true,
            'penyelenggara'        => 'HimaIF',
            'acara'                => 'Workshop Kolaborasi',
            'singkatan_acara'      => 'WOKO',
            'prodi'                => 'Informatika',
            'nama_peminjam'        => 'Budi Santoso',
            'nim'                  => '2408561081',
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);
        $insertDetailDanKegiatan($surat2Id, $inventarisDariHimafi, 6);

        // ── SURAT 3: HimaIF → HimaKi ─────────────────────────────────
        $surat3Id = DB::table('surat')->insertGetId([
            'id_user'              => $himaif->id,
            'nomor'                => 'SRT/HIMAIF/2025/003',
            'status_peminjaman'    => false,
            'catatan_peminjaman'   => null,
            'perihal_peminjaman'   => 'Peminjaman Alat untuk Pameran',
            'tanggal_peminjaman'   => now()->addDays(2),
            'tanggal_kembali'      => now()->addDays(4),
            'tandatangan_pimpinan' => null,
            'penyelenggara'        => 'HimaIF',
            'acara'                => 'Pameran Inovasi Mahasiswa',
            'singkatan_acara'      => 'INMA',
            'prodi'                => 'Informatika',
            'nama_peminjam'        => 'Budi Santoso',
            'nim'                  => '2408561081',
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);
        $insertDetailDanKegiatan($surat3Id, $inventarisDariHimaki, 0);

        // ============================================================
        // SURAT 2 — Dibuat oleh mahasiswa biasa, meminjam 3 barang
        //           dari inventaris LM manapun secara acak
        // ============================================================

        $mahasiswa = User::where('role', 'mahasiswa')->inRandomOrder()->firstOrFail();

        // Surat mahasiswa meminjam khusus dari HimaIF saja
        $inventarisUntukMhs = Inventaris::where('id_user', $himaif->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        if ($inventarisUntukMhs->count() < 3) {
            $this->command->warn('Inventaris HimaIF kurang dari 3. Seed tetap jalan dengan yang ada.');
        }

        $suratCounter = 1;
        $nomorSuratManual = 'SRT/MHS/2025/' . str_pad($suratCounter, 3, '0', STR_PAD_LEFT);

        $suratMhsId = DB::table('surat')->insertGetId([
            'id_user'              => $mahasiswa->id,
            'nomor'                => $nomorSuratManual,
            'status_peminjaman'    => false,
            'catatan_peminjaman'   => null,
            'perihal_peminjaman'   => 'Peminjaman Peralatan untuk Lomba',
            'tanggal_peminjaman'   => now()->addDays(3),
            'tanggal_kembali'      => now()->addDays(5),
            'tandatangan_pimpinan' => null,
            'penyelenggara'        => 'Mahasiswa',
            'acara'                => 'Lomba Kreativitas Mahasiswa',
            'singkatan_acara'      => 'LOMKREMA',
            'prodi'                => 'Non-Organisasi',
            'nama_peminjam'        => $mahasiswa->name ?? 'Mahasiswa Biasa',
            'nim'                  => $mahasiswa->NIM_NIP ?? '2408500001',
            'created_at'           => now(),
            'updated_at'           => now(),
        ]);

        // Detail peminjaman — 3 barang dari LM manapun
        foreach ($inventarisUntukMhs as $inv) {
            DB::table('detail_peminjaman')->insert([
                'id_inventaris'  => $inv->id,
                'id_surat'       => $suratMhsId,
                'qty_inventaris' => fake()->numberBetween(1, 2),
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // Kegiatan untuk surat mahasiswa (1 sesi saja)
        DB::table('kegiatans')->insert([
            [
                'id_surat'      => $suratMhsId,
                'nama'          => 'Persiapan & Gladi Resik',
                'hari_mulai'    => 'Rabu',
                'tanggal_mulai' => now()->addDays(3)->setTime(8, 0),
                'waktu_mulai'   => '08:00:00',
                'waktu_selesai' => '10:00:00',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'id_surat'      => $suratMhsId,
                'nama'          => 'Pelaksanaan Lomba',
                'hari_mulai'    => 'Rabu',
                'tanggal_mulai' => now()->addDays(3)->setTime(10, 0),
                'waktu_mulai'   => '10:00:00',
                'waktu_selesai' => '16:00:00',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);

        $mahasiswas = User::where('role', 'mahasiswa')->get();
        $allLM = User::where('role', 'admin_LM')->get();

        $suratCounter = 2;

        foreach ($mahasiswas as $mahasiswa) {
            // Setiap mahasiswa punya 3 surat
            for ($i = 1; $i <= 3; $i++) {
                // Pilih 1 LM secara random untuk surat ini
                $lm = $allLM->random();

                // Ambil 2 inventaris dari LM yang dipilih
                $inventaris = Inventaris::where('id_user', $lm->id)
                    ->inRandomOrder()
                    ->take(2)
                    ->get();

                if ($inventaris->isEmpty()) {
                    $this->command->warn("LM {$lm->username} tidak punya inventaris, surat ke-{$i} untuk {$mahasiswa->username} dilewati.");
                    continue;
                }

                $nomorSurat = 'SRT/MHS/2025/' . str_pad($suratCounter, 3, '0', STR_PAD_LEFT);
                $tanggalPinjam = now()->addDays(rand(3, 14));
                $tanggalKembali = (clone $tanggalPinjam)->addDays(rand(1, 3));

                $statusPeminjaman = ($i % 2 === 0) ? 0 : null;

                $suratId = DB::table('surat')->insertGetId([
                    'id_user'              => $mahasiswa->id,
                    'nomor'                => $nomorSurat,
                    'status_peminjaman'    => $statusPeminjaman,
                    'catatan_peminjaman'   => null,
                    'perihal_peminjaman'   => 'Peminjaman Peralatan untuk Kegiatan ' . $i,
                    'tanggal_peminjaman'   => $tanggalPinjam,
                    'tanggal_kembali'      => $tanggalKembali,
                    'tandatangan_pimpinan' => null,
                    'penyelenggara'        => $mahasiswa->organization_name ?? 'Mahasiswa',
                    'acara'                => 'Kegiatan Mahasiswa ' . $i,
                    'singkatan_acara'      => 'KMHS' . $i,
                    'prodi'                => $mahasiswa->prodi ?? 'Non-Organisasi',
                    'nama_peminjam'        => $mahasiswa->name ?? $mahasiswa->username,
                    'nim'                  => $mahasiswa->NIM_NIP ?? '0000000000',
                    'created_at'           => now(),
                    'updated_at'           => now(),
                ]);

                // Insert detail peminjaman — 2 barang dari LM yang sama
                foreach ($inventaris as $inv) {
                    DB::table('detail_peminjaman')->insert([
                        'id_inventaris'  => $inv->id,
                        'id_surat'       => $suratId,
                        'qty_inventaris' => fake()->numberBetween(1, 2),
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                }

                // Insert kegiatan — 2 sesi per surat
                DB::table('kegiatans')->insert([
                    [
                        'id_surat'      => $suratId,
                        'nama'          => 'Persiapan Kegiatan ' . $i,
                        'hari_mulai'    => 'Rabu',
                        'tanggal_mulai' => $tanggalPinjam->copy()->setTime(8, 0),
                        'waktu_mulai'   => '08:00:00',
                        'waktu_selesai' => '10:00:00',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                    [
                        'id_surat'      => $suratId,
                        'nama'          => 'Pelaksanaan Kegiatan ' . $i,
                        'hari_mulai'    => 'Rabu',
                        'tanggal_mulai' => $tanggalPinjam->copy()->setTime(10, 0),
                        'waktu_mulai'   => '10:00:00',
                        'waktu_selesai' => '16:00:00',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                ]);

                $suratCounter++;
            }
        }
    }
}