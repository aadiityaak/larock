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
        $mainproject = MainProject::with(['webhost', 'webhost.paket', 'webhost.server'])
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return Inertia::render('Billing/Index', [
            'mainprojects' => $mainproject
        ]);
    }
}
