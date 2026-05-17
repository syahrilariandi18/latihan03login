<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        return view('dashboard.admin', ['title' => 'Admin Dashboard']);
    }

    public function kepalaDashboard()
    {
        return view('dashboard.kepala', ['title' => 'Kepala Toko Dashboard']);
    }

    public function kasirDashboard()
    {
        return view('dashboard.kasir', ['title' => 'Kasir Dashboard']);
    }
}