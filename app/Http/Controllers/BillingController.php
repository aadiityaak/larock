<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\MainProject;
use App\Models\Paket;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        // Get the search term from the request
        $searchTerm = $request->input('cari', '');
        $searchJenis = $request->input('jenis', '');
        $perPage = $request->input('perPage', 150);
        $searchStartDate = $request->input('startDate') ? Carbon::parse($request->input('startDate'))->format('Y-m-d') : '';
        $searchEndDate = $request->input('endDate') ? Carbon::parse($request->input('endDate'))->format('Y-m-d') : '';
        $sortColumn = $request->input('sort', 'id');
        $sortDirection = $request->input('direction', 'desc');

        // Query the MainProject model with eager loading and search functionality
        $mainprojects = MainProject::with(['webhost', 'webhost.paket', 'webhost.server'])
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->WhereHas('webhost', function ($q) use ($searchTerm) {
                        $q->where('nama_web', 'like', '%' . $searchTerm . '%');
                    });
                });
            })
            ->when($searchJenis, function ($query) use ($searchJenis) {
                $query->where('jenis', $searchJenis);
            })
            ->when($searchStartDate, function ($query) use ($searchStartDate) {
                $query->whereDate('tgl_masuk', '>=', $searchStartDate);
            })
            ->when($searchEndDate, function ($query) use ($searchEndDate) {
                $query->whereDate('tgl_masuk', '<=', $searchEndDate);
            })
            // Handle dynamic sorting
            ->when($sortColumn === 'webhost.nama_web', function ($query) use ($sortDirection) {
                // Join the webhost table and sort by webhost.nama_web
                $query->join('tb_webhost', 'tb_cs_main_project.id_webhost', '=', 'tb_webhost.id_webhost')
                    ->orderBy(DB::raw("REPLACE(TRIM(tb_webhost.nama_web), '	 ', '')"), $sortDirection);
            }, function ($query) use ($sortColumn, $sortDirection) {
                // Default sorting by the column in the main table
                $query->orderBy($sortColumn, $sortDirection);
            })
            ->select('tb_cs_main_project.*') // Make sure to select the main project fields
            ->paginate($perPage);

        $jenis_list = MainProject::select('jenis')
            ->whereNotNull('jenis') // Mengabaikan nilai null
            ->where('jenis', '!=', '') // Mengabaikan nilai kosong
            ->distinct()
            ->get()
            ->pluck('jenis');

        $list_paket = Paket::all();
        $project_bulan_ini = MainProject::whereIn('jenis', [
            'Pembuatan',
            'Pembuatan apk',
            'Pembuatan apk custom',
            'Pembuatan Tanpa Domain',
            'Pembuatan Tanpa Hosting',
            'Pembuatan Tanpa Domain+Hosting'
        ])
            ->whereBetween('tgl_masuk', [
                date('Y-m-01'), // Tanggal 1 bulan ini
                date('Y-m-t')   // Tanggal terakhir bulan ini
            ])
            ->count();
        $prediksi_bulan_ini = ceil($project_bulan_ini / intval(date('d'))) * intval(date('t'));

        // Add employee names and their workload to each project
        $mainprojects->getCollection()->transform(function ($mainproject) {
            $mainproject->karyawan_data = $mainproject->karyawan_data; // This calls the accessor
            return $mainproject;
        });

        return Inertia::render('Billing/Index', [
            'mainprojects' => $mainprojects,
            'qcari' => $searchTerm,
            'jenispaket' => $jenis_list,
            'qjenis' => $searchJenis,
            'listpaket' => $list_paket,
            'qdate' => [$searchStartDate, $searchEndDate],
            'project_bulan_ini' => $project_bulan_ini,
            'prediksi_bulan_ini' => $prediksi_bulan_ini,
            'qsort' => $sortColumn,
            'qdirection' => $sortDirection
        ]);
    }
}
