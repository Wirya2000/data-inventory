<?php

use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GlobalController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;

Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');
	Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
	Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
	Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
	Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
	Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
	Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
	Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
	Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');

    // Route::resource('customers', CustomerController::class)->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
	Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
	Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
	Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
	Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
	Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
	Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
    // Route::post('pembelians/showAddDetailPembelian/', 'PembelianController@showAddDetailPembelian')->name('pembelians.showAddDetailPembelian');

    // Pembelian
    Route::post('pembelians/showAddDetailPembelian/', [PembelianController::class, 'showAddDetailPembelian'])->name('pembelians.showAddDetailPembelian');
    Route::post('pembelians/addDetailPembelian/{barang}', [PembelianController::class, 'addDetailPembelian'])->name('pembelians.addDetailPembelian');
    Route::get('barangs/getKodebarang/', [BarangController::class, 'getKodeBarang'])->name('barangs.getKodeBarang');
    Route::get('pembelians/getDataHargaBeli/{barang}', [PembelianController::class, 'getDataHargaBeli'])->name('pembelians.getDataHargaBeli');
    Route::post('pembelians/updateJumlah/', [PembelianController::class, 'updateJumlah'])->name('pembelians.updateJumlah');
    Route::delete('pembelians/removeFromCart/{barang_id}', [PembelianController::class, 'removeFromCart'])->name('pembelians.removeFromCart');

    // Global
    Route::get('getDataKategoriBarang/', [GlobalController::class, 'getDataKategoriBarang'])->name('getDataKategoriBarang');
    Route::get('getDataListBarang/', [GlobalController::class, 'getDataListBarang'])->name('getDataListBarang');

    // Penjualan
    Route::post('penjualans/showAddDetailPenjualan/', [PenjualanController::class, 'showAddDetailPenjualan'])->name('penjualans.showAddDetailPenjualan');
    Route::post('penjualans/updateJumlah/', [PenjualanController::class, 'updateJumlah'])->name('penjualans.updateJumlah');
    Route::delete('penjualans/removeFromCart/{barang_id}', [PenjualanController::class, 'removeFromCart'])->name('penjualans.removeFromCart');
    Route::get('penjualans/getDataBarangSelected/{barang}', [PenjualanController::class, 'getDataBarangSelected'])->name('penjualans.getDataBarangSelected');
    Route::post('penjualans/addDetailPenjualan/{barang}', [PenjualanController::class, 'addDetailPenjualan'])->name('penjualans.addDetailPenjualan');

    // Report
    Route::get('reports.penjualanDetail', [ReportController::class, 'penjualanDetail'])->name('reports.penjualanDetail');
    Route::get('reports.penjualanRekap', [ReportController::class, 'penjualanRekap'])->name('reports.penjualanRekap');
    Route::get('reports.penjualanHarian', [ReportController::class, 'penjualanHarian'])->name('reports.penjualanHarian');
    Route::get('reports.penjualanPerBarang', [ReportController::class, 'penjualanPerBarang'])->name('reports.penjualanPerBarang');
    Route::get('reports.penjualanPerCustomer', [ReportController::class, 'penjualanPerCustomer'])->name('reports.penjualanPerCustomer');
    Route::get('reports.penjualanProfitPenjualan', [ReportController::class, 'penjualanProfitPenjualan'])->name('reports.penjualanProfitPenjualan');

    Route::resource('customers', CustomerController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('users', UserController::class);
    Route::resource('kategoris', KategoriController::class);
    Route::resource('satuans', SatuanController::class);
    Route::resource('barangs', BarangController::class);
    Route::resource('pembelians', PembelianController::class);
    Route::resource('penjualans', PenjualanController::class);
    Route::resource('reports', ReportController::class);
	Route::get('/{page}', [PageController::class, 'index'])->name('page');
	Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
