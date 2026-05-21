<?php

namespace Database\Seeders;

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
        User::factory()->create([
            'username' => 'dpm_fmipa',
            'role' => 'admin_LM',
            'organization_name' => 'DPM FMIPA',
            'NIM_NIP' => '2308561001',
        ]);

        User::factory()->create([
            'username' => 'bem_fmipa',
            'role' => 'admin_LM',
            'organization_name' => 'BEM FMIPA',
            'NIM_NIP' => '2308561002',
        ]);

        $himaProdi = [
            ['slug' => 'himatika', 'nama' => 'HimaTika', 'prodi' => 'Matematika', 'nim' => '2408511001'],
            ['slug' => 'himafi', 'nama' => 'HimaFi', 'prodi' => 'Fisika', 'nim' => '2408521001'],
            ['slug' => 'himaki', 'nama' => 'HimaKi', 'prodi' => 'Kimia', 'nim' => '2408531001'],
            ['slug' => 'himabio', 'nama' => 'HimaBio', 'prodi' => 'Biologi', 'nim' => '2408541001'],
            ['slug' => 'himafarma', 'nama' => 'HimaFarma', 'prodi' => 'Farmasi', 'nim' => '2408551001'],
            ['slug' => 'himaif', 'nama' => 'HimaIF', 'prodi' => 'Informatika', 'nim' => '2408561081'],
        ];

        foreach ($himaProdi as $hima) {
            User::factory()->create([
                'username' => $hima['slug'],
                'role' => 'admin_LM',
                'organization_name' => $hima['nama'] . ' (' . $hima['prodi'] . ')',
                'ktm' => fake()->boolean(50) ? 'uploads/ktm/' . fake()->uuid() . '.jpg' : null,
                'NIM_NIP' => $hima['nim'],
            ]);
        }

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
    }
}
