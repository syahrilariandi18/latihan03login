<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;

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
Route::get('/transaksi', [TransaksiController::class, 'index'])
    ->name('transaksi.index');

Route::post('/transaksi/tambah-keranjang', [TransaksiController::class, 'addToCart'])
    ->name('transaksi.addToCart');
    
Route::get('/transaksi/hapus-keranjang/{produk_id}', [TransaksiController::class, 'removeFromCart'])
    ->name('transaksi.removeFromCart');
    
Route::post('/transaksi/checkout', [TransaksiController::class, 'checkout'])
    ->name('transaksi.checkout');
    
Route::get('/transaksi/riwayat', [TransaksiController::class, 'riwayat'])
    ->name('transaksi.riwayat');
    
Route::get('/transaksi/detail/{id}', [TransaksiController::class, 'detail'])
    ->name('transaksi.detail');

Route::get('/transaksi/cetak-pdf/{id}', [TransaksiController::class, 'cetakPdf'])
    ->name('transaksi.cetakPdf');

Route::middleware(['auth'])->group(function () {
});
// Route::get('/Transaksi', function () {
//     return view('transaksi', ['title' => 'Transaksi']);
// })->middleware('auth');

// Route Data Produk - hanya admin dan kepala_toko
Route::get('/DataProduk', [ProdukController::class, 'index'])
    ->middleware('role:admin,kepala_toko');
    
Route::get('/TambahProduk', [ProdukController::class, 'tambah'])
    ->middleware('role:admin,kepala_toko');

Route::post('/SimpanProduk', [ProdukController::class, 'simpan'])
    ->middleware('role:admin,kepala_toko');

Route::get('/DetailProduk/{id}', [ProdukController::class, 'detail'])
    ->middleware('role:admin,kepala_toko');

Route::get('/EditProduk/{id}', [ProdukController::class, 'edit'])
    ->middleware('role:admin,kepala_toko');

Route::post('/UpdateProduk/{id}', [ProdukController::class, 'update'])
    ->middleware('role:admin,kepala_toko');
    
Route::get('/HapusProduk/{id}', [ProdukController::class, 'hapus'])
    ->middleware('role:admin,kepala_toko');
// Route::get('/DataProduk', function () {
//     return view('Produk.Data_Produk', ['title' => 'Data Produk']);
// })->middleware('role:admin,kepala_toko');

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