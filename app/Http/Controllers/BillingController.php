<?php

namespace App\Http\Controllers;

use App\Models\MainProject;
use Inertia\Inertia;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $projects = MainProject::with(['webhost.paket', 'webhost.server'])
            ->paginate(50); // Pastikan ini mengembalikan data yang lengkap

        return Inertia::render('Billing/Index', [
            'projects' => $projects,
        ]);
    }
}
