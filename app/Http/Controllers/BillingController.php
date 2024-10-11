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
        $perPage = $request->input('perPage', 150);

        // Query the MainProject model with eager loading and search functionality
        $mainprojects = MainProject::with(['webhost', 'webhost.paket', 'webhost.server'])
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->WhereHas('webhost', function ($q) use ($searchTerm) {
                        $q->where('nama_web', 'like', '%' . $searchTerm . '%');
                    });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        $list_paket = Paket::all();

        // Add employee names and their workload to each project
        $mainprojects->getCollection()->transform(function ($mainproject) {
            $mainproject->karyawan_data = $mainproject->karyawan_data; // This calls the accessor
            return $mainproject;
        });

        return Inertia::render('Billing/Index', [
            'mainprojects' => $mainprojects,
            'cari' => $searchTerm,
            'list_paket' => $list_paket
        ]);
    }
}
