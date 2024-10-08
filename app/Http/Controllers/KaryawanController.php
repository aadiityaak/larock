<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Inertia\Inertia;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        // Ambil semua data karyawan
        $karyawans = Karyawan::all();

        // Kirim data ke Vue.js melalui Inertia
        return Inertia::render('Karyawan/Index', [
            'karyawans' => $karyawans
        ]);
    }

    public function getKaryawanByIds(Request $request)
    {
        // Ambil ID karyawan dari request (array of IDs)
        $ids = $request->input('ids', []);

        // Ambil data karyawan yang ID-nya ada dalam array $ids
        $karyawans = Karyawan::whereIn('id_karyawan', $ids)->get();

        // Return JSON response
        return response()->json($karyawans);
    }
}
