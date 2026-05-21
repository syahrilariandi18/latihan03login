<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route Login & Logout
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route Home - Redirect ke dashboard jika sudah login, atau ke login jika belum
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'kepala_toko') {
            return redirect()->route('kepala.dashboard');
        } else {
            return redirect()->route('kasir.dashboard');
        }
    }

    return redirect('/login');
});

// Route Dashboard per role (dilindungi middleware)
Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])
    ->name('admin.dashboard')
    ->middleware('role:admin');

Route::get('/kepala/dashboard', [DashboardController::class, 'kepalaDashboard'])
    ->name('kepala.dashboard')
    ->middleware('role:kepala_toko');

Route::get('/kasir/dashboard', [DashboardController::class, 'kasirDashboard'])
    ->name('kasir.dashboard')
    ->middleware('role:kasir');

// Route lainnya (belum ada middleware, akan ditambahkan nanti)

// Route Transaksi - semua role yang login bisa akses
Route::get('/Transaksi', function () {
    return view('transaksi', ['title' => 'Transaksi']);
})->middleware('auth');

// Route Data Produk - hanya admin dan kepala_toko
Route::get('/DataProduk', function () {
    return view('Produk.Data_Produk', ['title' => 'Data Produk']);
})->middleware('role:admin,kepala_toko');

// Route About - semua role yang login bisa akses
Route::get('/About', function () {
    return view('about', ['title' => 'About']);
})->middleware('auth');

// Route Kelola User - hanya admin
Route::get('/users', function () {
    return view('users', ['title' => 'Kelola User']);
})->middleware('role:admin');

// Route Pengaturan Role - hanya admin
Route::get('/roles', function () {
    return view('roles', ['title' => 'Pengaturan Role']);
})->middleware('role:admin');