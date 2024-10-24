<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_paket')->insert([
            ['id_paket' => 4, 'id_jenis' => 8, 'paket' => 'Paket E', 'bobot' => 30],
            ['id_paket' => 0, 'paket' => '-', 'bobot' => 100],
            ['id_paket' => 5, 'id_jenis' => 8, 'paket' => 'Paket F', 'bobot' => 50],
            ['id_paket' => 6, 'id_jenis' => 8, 'paket' => 'Paket G', 'bobot' => 100],
            ['id_paket' => 7, 'id_jenis' => 8, 'paket' => 'Paket Toko Online Biasa', 'bobot' => 30],
            ['id_paket' => 8, 'id_jenis' => 8, 'paket' => 'Paket Portal Berita Biasa', 'bobot' => 30],
            ['id_paket' => 10, 'id_jenis' => 8, 'paket' => 'Paket Luar', 'bobot' => 0],
            ['id_paket' => 11, 'id_jenis' => 8, 'paket' => 'Paket Iklan Baris Biasa', 'bobot' => 30],
            ['id_paket' => 12, 'id_jenis' => 8, 'paket' => 'Paket Email', 'bobot' => 15],
            ['id_paket' => 13, 'id_jenis' => 8, 'paket' => 'Paket Toko Online Custom', 'bobot' => 100],
            ['id_paket' => 14, 'id_jenis' => 8, 'paket' => 'Paket Portal Berita Custom', 'bobot' => 100],
            ['id_paket' => 15, 'id_jenis' => 8, 'paket' => 'Paket Iklan Baris Custom', 'bobot' => 100],
            ['id_paket' => 16, 'id_jenis' => 8, 'paket' => 'Paket Marketplace Biasa', 'bobot' => 50],
            ['id_paket' => 17, 'id_jenis' => 8, 'paket' => 'Paket Marketplace Custom', 'bobot' => 100],
            ['id_paket' => 20, 'id_jenis' => 8, 'paket' => 'Paket Forum Custom', 'bobot' => 100],
            ['id_paket' => 21, 'id_jenis' => 8, 'paket' => 'Paket Radio Streaming Biasa', 'bobot' => 30],
            ['id_paket' => 22, 'id_jenis' => 5, 'paket' => 'APK Biasa', 'bobot' => 15],
            ['id_paket' => 23, 'id_jenis' => 5, 'paket' => 'APK Custom', 'bobot' => 100],
            ['id_paket' => 24, 'id_jenis' => 8, 'paket' => 'Paket SIA', 'bobot' => 100],
            ['id_paket' => 25, 'id_jenis' => 8, 'paket' => 'Paket Loker Biasa', 'bobot' => 100],
            ['id_paket' => 26, 'id_jenis' => 8, 'paket' => 'Paket Landing Page Biasa', 'bobot' => 100],
            ['id_paket' => 27, 'id_jenis' => 8, 'paket' => 'Paket Landing Page Custom', 'bobot' => 100],
            ['id_paket' => 28, 'id_jenis' => 8, 'paket' => 'Paket Radio Streaming Custom', 'bobot' => 100],
            ['id_paket' => 29, 'id_jenis' => 8, 'paket' => 'Paket Forum Biasa', 'bobot' => 100],
            ['id_paket' => 30, 'paket' => 'Lain - Lain', 'bobot' => 0],
            ['id_paket' => 32, 'paket' => 'Domain', 'bobot' => 0],
            ['id_paket' => 33, 'paket' => 'Hosting', 'bobot' => 0],
            ['id_paket' => 3, 'paket' => '-', 'bobot' => null],
            ['id_paket' => 35, 'id_jenis' => 8, 'paket' => 'Paket Lelang Custom', 'bobot' => 100],
            ['id_paket' => 36, 'id_jenis' => 8, 'paket' => 'Paket PPOB', 'bobot' => 100],
            ['id_paket' => 31, 'id_jenis' => 8, 'paket' => 'Paket Loker Custom', 'bobot' => 0],
            ['id_paket' => 37, 'id_jenis' => 8, 'paket' => 'Paket PPOB Custom', 'bobot' => 100],
            ['id_paket' => 38, 'id_jenis' => 8, 'paket' => 'Paket PPDB', 'bobot' => 100],
            ['id_paket' => 39, 'id_jenis' => 8, 'paket' => 'Paket PPDB Custom', 'bobot' => 100],
        ]);
    }
}
