<?php

namespace App\Http\Controllers;

use App\Models\MainProject;
use App\Models\Webhost;
use Inertia\Inertia;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $mainproject = MainProject::with(['webhost', 'webhost.paket', 'webhost.server'])
            ->orderBy('id', 'desc')
            ->paginate(150);
        // dd($projects);
        return Inertia::render('Billing/Index', [
            'mainprojects' => $mainproject,
        ]);
    }
}
