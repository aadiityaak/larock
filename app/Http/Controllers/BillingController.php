<?php

namespace App\Http\Controllers;

use App\Models\MainProject;
use App\Models\Paket;
use Inertia\Inertia;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        // Get the search term from the request
        $searchTerm = $request->input('cari', '');
        $searchJenis = $request->input('jenis', '');
        $perPage = $request->input('perPage', 150);
        $searchStartDate = $request->input('startDate', '');
        $searchEndDate = $request->input('endDate', '');

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
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        $jenis_list = MainProject::select('jenis')->distinct()->get()->pluck('jenis');
        $list_paket = Paket::all();

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
        ]);
    }
}
