<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Karyawan;

class MainProject extends Model
{
    use HasFactory;
    protected $table = 'tb_cs_main_project';

    public function webhost()
    {
        return $this->belongsTo(Webhost::class, 'id_webhost');
    }

    public function getKaryawanDataAttribute()
    {
        $data = $this->dikerjakan_oleh; // Assuming this is the column name
        // Example: "10[50],12[50]"

        // Split the data into an array
        $items = explode(',', $data);

        $karyawanData = [];

        foreach ($items as $item) {
            preg_match('/(\d+)\[(\d+)\]/', $item, $matches);
            if ($matches) {
                $karyawanId = $matches[1];
                $bobot = $matches[2];

                // Find the Karyawan by id
                $karyawan = Karyawan::find($karyawanId);
                if ($karyawan) {
                    // Add name and weight to the array
                    $karyawanData[] = [
                        'nama' => $karyawan->nama, // Assuming there's a 'nama' field in the Karyawan model
                        'bobot' => $bobot
                    ];
                }
            }
        }

        return $karyawanData;
    }
}
