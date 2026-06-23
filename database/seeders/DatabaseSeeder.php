<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Inventaris;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        // 2. SEED ORGANIZATIONS
        $organizationsData = [
            ['name' => 'Himpunan Mahasiswa Matematika'],
            ['name' => 'Himpunan Mahasiswa Fisika'],
            ['name' => 'Himpunan Mahasiswa Kimia'],
            ['name' => 'Himpunan Mahasiswa Biologi'],
            ['name' => 'Himpunan Mahasiswa Farmasi'],
            ['name' => 'Himpunan Mahasiswa Informatika'],
        ];

        Organization::factory()
            ->count(count($organizationsData))
            ->sequence(...$organizationsData)
            ->create();

        // Array penampung untuk semua akun admin LM yang akan dibuatkan inventaris
        $lmUsers = [];

        // 3. SEED USER (DPM & BEM)
        $lmUsers[] = User::factory()->create([
            'username' => 'dpm_fmipa',
            'role' => 'admin_LM',
            'organization_name' => 'DPM FMIPA',
            'NIM_NIP' => '2308561001',
        ]);

        $lmUsers[] = User::factory()->create([
            'username' => 'bem_fmipa',
            'role' => 'admin_LM',
            'organization_name' => 'BEM FMIPA',
            'NIM_NIP' => '2308561002',
        ]);

        // 4. SEED USER HIMA PRODI
        $himaProdi = [
            ['slug' => 'himatika', 'nama' => 'HimaTika', 'prodi' => 'Matematika', 'nim' => '2408511001'],
            ['slug' => 'himafi', 'nama' => 'HimaFi', 'prodi' => 'Fisika', 'nim' => '2408521001'],
            ['slug' => 'himaki', 'nama' => 'HimaKi', 'prodi' => 'Kimia', 'nim' => '2408531001'],
            ['slug' => 'himabio', 'nama' => 'HimaBio', 'prodi' => 'Biologi', 'nim' => '2408541001'],
            ['slug' => 'himafarma', 'nama' => 'HimaFarma', 'prodi' => 'Farmasi', 'nim' => '2408551001'],
            ['slug' => 'himaif', 'nama' => 'HimaIF', 'prodi' => 'Informatika', 'nim' => '2408561081'],
        ];

        foreach ($himaProdi as $hima) {
            $lmUsers[] = User::factory()->create([
                'username' => $hima['slug'],
                'role' => 'admin_LM',
                'organization_name' => $hima['nama'] . ' (' . $hima['prodi'] . ')',
                'ktm' => fake()->boolean(50) ? 'uploads/ktm/' . fake()->uuid() . '.jpg' : null,
                'NIM_NIP' => $hima['nim'],
            ]);
        }

        // 5. SEED USER DEKANAT & MAHASISWA BIASA (Tidak mendapatkan inventaris)
        User::factory()->create([
            'username' => 'admin_dekanat',
            'role' => 'admin_dekanat',
            'organization_name' => 'Dekanat FMIPA',
            'NIM_NIP' => '198503152010121001',
        ]);

        User::factory()->create([
            'username' => 'dekan_fmipa',
            'role' => 'petinggi_dekanat',
            'organization_name' => 'Dekan FMIPA',
            'NIM_NIP' => '197305201999031002',
        ]);

        User::factory()->count(3)->create([
            'role' => 'mahasiswa',
            'organization_name' => 'Non-Organisasi',
            'ktm' => fake()->boolean(50) ? 'uploads/ktm/' . fake()->uuid() . '.jpg' : null,
        ]);

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
    }
}