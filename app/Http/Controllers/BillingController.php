<?php

namespace App\Http\Controllers;

use App\Models\MainProject;
use Inertia\Inertia;
use Illuminate\Http\Request;

class BillingController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 150); // Default items per page
        $mainprojects = MainProject::with(['webhost', 'webhost.paket', 'webhost.server'])
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        // Add employee names and their workload to each project
        $mainprojects->getCollection()->transform(function ($mainproject) {
            $mainproject->karyawan_data = $mainproject->karyawan_data; // This calls the accessor
            return $mainproject;
        });

        return Inertia::render('Billing/Index', [
            'mainprojects' => $mainprojects
        ]);
    }
}
