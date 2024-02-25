<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BahanBaku;
use App\Models\LaporanBahanBaku;
use App\Models\Page;
use App\Models\Tentang;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '12345',
            'role' => 'Admin'
        ]);

        User::factory()->create([
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'password' => '12345',
            'role' => 'Customer'
        ]);

        Page::create([
            'judul' => 'Judul Website',
            'deskripsi' => '',
            'logo' => 'logo-default.png',
            'favicon' => 'logo-default.png'
        ]);

        Tentang::create([
            'nama' => 'PT. NAMA',
            'alamat' => 'ALAMAT',
            'deskripsi' => 'DESKRIPSI',
            'no_tlp1' => '081XXXXXXXXXXX',
            'no_tlp2' => '081XXXXXXXXXXX',
            'email1' => 'EMAIL@GMAIL.COM',
            'email2' => 'EMAIL@GMAIL.COM',
            'instagram' => 'INSTAGRAM',
            'facebook' => 'FACEBOOK',
            'x'=> 'X'
        ]);

        for ($i=1; $i <= 50; $i++) {
            $nama = fake()->words(2,true);
            $stok = 10;
            $harga = 50000;

            BahanBaku::create([
                'id' => $i,
                'nama' => $nama,
                'slug' => Str::slug($nama),
                'deskripsi' => fake()->sentences(3, true),
                'satuan' => 'KG',
                'stok' => $stok,
                'harga' => $harga
            ]);
        }
    }
}
