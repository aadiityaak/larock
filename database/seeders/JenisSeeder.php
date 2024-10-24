<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Lain - Lain',
            'Iklan Google',
            'Deposit Iklan Google',
            'Jasa update iklan google',
            'Pembuatan apk',
            'Pembuatan apk biasa',
            'Pembuatan apk custom',
            'Pembuatan',
            'Perpanjangan',
            'Tambah Space',
            'Pembuatan Tanpa Domain',
            'Pembuatan Tanpa Hosting',
            'Pembuatan Tanpa Domain+Hosting',
            'Jasa Input Produk',
            'Jasa Update Web',
            'Jasa Buat Email',
            'Jasa Ganti Domain',
            'Jasa SEO',
            'Jasa Buat Facebook',
            'Redesign',
            'Jasa Pembuatan Logo',
            'Compro PDF',
        ];

        $id = 1;
        foreach ($data as $jenis) {
            DB::table('tb_jenis')->insert([
                'id' => $id++,
                'nama' => $jenis,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
