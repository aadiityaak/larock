<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Lain - Lain'],
            ['nama' => 'Iklan Google'],
            ['nama' => 'Deposit Iklan Google'],
            ['nama' => 'Jasa update iklan google'],
            ['nama' => 'Pembuatan apk'],
            ['nama' => 'Pembuatan apk biasa'],
            ['nama' => 'Pembuatan apk custom'],
            ['nama' => 'Pembuatan'],
            ['nama' => 'Perpanjangan'],
            ['nama' => 'Tambah Space'],
            ['nama' => 'Pembuatan Tanpa Domain'],
            ['nama' => 'Pembuatan Tanpa Hosting'],
            ['nama' => 'Pembuatan Tanpa Domain+Hosting'],
            ['nama' => 'Jasa Input Produk'],
            ['nama' => 'Jasa Update Web'],
            ['nama' => 'Jasa Buat Email'],
            ['nama' => 'Jasa Ganti Domain'],
            ['nama' => 'Jasa SEO'],
            ['nama' => 'Jasa Buat Facebook'],
            ['nama' => 'Redesign'],
            ['nama' => 'Jasa Pembuatan Logo'],
            ['nama' => 'Compro PDF'],
            ['nama' => 'Lain-lain'],
        ];

        DB::table('jenis_project')->insert($data);
    }
}
