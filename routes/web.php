<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/barang', [BarangController::class, 'index']);
Route::get('/barang/create', [BarangController::class, 'create']);
Route::post('/barang', [BarangController::class, 'store']);
Route::get('/barang/{id}/edit', [BarangController::class, 'edit']);
Route::put('/barang/{id}', [BarangController::class, 'update']);
Route::delete('/barang/{id}', [BarangController::class, 'destroy']);
Route::get('/barang/{id}', [BarangController::class, 'show']);

use App\Http\Controllers\PetugasController;

Route::get('/petugas', [PetugasController::class, 'index']);
Route::get('/petugas/create', [PetugasController::class, 'create']);
Route::post('/petugas', [PetugasController::class, 'store']);
Route::get('/petugas/{id}/edit', [PetugasController::class, 'edit']);
Route::put('/petugas/{id}', [PetugasController::class, 'update']);
Route::delete('/petugas/{id}', [PetugasController::class, 'destroy']);
Route::get('/petugas/create', [PetugasController::class, 'create'])->name('petugas.create');
Route::post('/petugas', [PetugasController::class, 'store'])->name('petugas.store');

use App\Http\Controllers\DokterController;

Route::get('/dokter', [DokterController::class, 'index']);
Route::get('/dokter/create', [DokterController::class, 'create']);
Route::post('/dokter', [DokterController::class, 'store']);
Route::get('/dokter/{id}/edit', [DokterController::class, 'edit']);
Route::put('/dokter/{id}', [DokterController::class, 'update']);
Route::delete('/dokter/{id}', [DokterController::class, 'destroy']);

use App\Http\Controllers\JaminanController;

Route::get('/jaminan', [JaminanController::class, 'index']);
Route::get('/jaminan/create', [JaminanController::class, 'create']);
Route::post('/jaminan', [JaminanController::class, 'store']);
Route::get('/jaminan/{id}/edit', [JaminanController::class, 'edit']);
Route::put('/jaminan/{id}', [JaminanController::class, 'update']);
Route::delete('/jaminan/{id}', [JaminanController::class, 'destroy']);

use App\Http\Controllers\PasienController;

Route::get('/pasien', [PasienController::class, 'index']);
Route::get('/pasien/create', [PasienController::class, 'create']);
Route::post('/pasien', [PasienController::class, 'store']);
Route::get('/pasien/{id}/edit', [PasienController::class, 'edit']);
Route::put('/pasien/{id}', [PasienController::class, 'update']);
Route::delete('/pasien/{id}', [PasienController::class, 'destroy']);

use App\Http\Controllers\PemeriksaanController;

Route::get('/pemeriksaan', [PemeriksaanController::class, 'index']);
Route::get('/pemeriksaan/create', [PemeriksaanController::class, 'create']);
Route::post('/pemeriksaan', [PemeriksaanController::class, 'store']);
Route::delete('/pemeriksaan/{id}', [PemeriksaanController::class, 'destroy']);
Route::get('/pemeriksaan/{id}/edit', [PemeriksaanController::class, 'edit']);
Route::put('/pemeriksaan/{id}', [PemeriksaanController::class, 'update']);
Route::get('/pemeriksaan/{id}/cetak', [PemeriksaanController::class, 'cetak'])
    ->name('pemeriksaan.cetak');

use App\Http\Controllers\PenggunaanBarangController;

Route::get('/penggunaan-barang', [PenggunaanBarangController::class, 'index']);
Route::get('/penggunaan-barang/create', [PenggunaanBarangController::class, 'create']);
Route::post('/penggunaan-barang', [PenggunaanBarangController::class, 'store']);
Route::get('/penggunaan-barang/{id}/edit', [PenggunaanBarangController::class, 'edit']);
Route::put('/penggunaan-barang/{id}', [PenggunaanBarangController::class, 'update']);
Route::delete('/penggunaan-barang/{id}', [PenggunaanBarangController::class, 'destroy']);

use App\Http\Controllers\FormOrderController;

Route::get('/form_order', [FormOrderController::class, 'index']);
Route::get('/form_order/create', [FormOrderController::class, 'create']);
Route::post('/form_order', [FormOrderController::class, 'store']);
Route::get('/form_order/{id}/edit', [FormOrderController::class, 'edit']);
Route::put('/form_order/{id}', [FormOrderController::class, 'update']);
Route::delete('/form_order/{id}', [FormOrderController::class, 'destroy']);


use App\Http\Controllers\DetailOrderController;

Route::get('/detail-order', [DetailOrderController::class, 'index']);
Route::get('/detail-order/create', [DetailOrderController::class, 'create']);
Route::post('/detail-order', [DetailOrderController::class, 'store']);
Route::get('/detail-order/{id}/edit', [DetailOrderController::class, 'edit']);
Route::put('/detail-order/{id}', [DetailOrderController::class, 'update']);
Route::delete('/detail-order/{id}', [DetailOrderController::class, 'destroy']);

use App\Http\Controllers\JadwalController;

Route::get('/jadwal', [JadwalController::class, 'index']);
Route::get('/jadwal/create', [JadwalController::class, 'create']);
Route::post('/jadwal', [JadwalController::class, 'store']);
Route::get('/jadwal/{id_petugas}/{periode}/edit', [JadwalController::class, 'edit']);
Route::put('/jadwal/{id_petugas}/{periode}', [JadwalController::class, 'update']);
Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy']);
Route::get('/jadwal/cetak/{periode}', [JadwalController::class, 'cetak']);

use App\Http\Controllers\KartuStokController;

Route::get('/kartu-stok', [KartuStokController::class, 'index']);
Route::get('/kartu-stok/create', [KartuStokController::class, 'create']);
Route::post('/kartu-stok', [KartuStokController::class, 'store']);
Route::get('/kartu-stok/{id}/edit', [KartuStokController::class, 'edit']);
Route::put('/kartu-stok/{id}', [KartuStokController::class, 'update']);
Route::delete('/kartu-stok/{id}', [KartuStokController::class, 'destroy']);
Route::get('/kartu-stok', [KartuStokController::class, 'index'])
    ->name('kartu-stok.index');
Route::get('/kartu-stok/cetak', [KartuStokController::class, 'cetak'])
    ->name('kartu-stok.cetak');

use App\Http\Controllers\LoginController;

Route::get('/login', [LoginController::class, 'formLogin']);
Route::post('/login', [LoginController::class, 'prosesLogin']);
Route::get('/logout', [LoginController::class, 'logout']);

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index']);

use App\Http\Controllers\LaporanController;

Route::get('/laporan', [LaporanController::class, 'index']);
Route::get('/cari-pasien/{nama}', [PemeriksaanController::class, 'cariPasien']);
Route::get('/laporan/cetak', [LaporanController::class, 'cetak']);

use App\Http\Controllers\AkunController;

Route::get('/akun', [AkunController::class, 'index']);
Route::post('/akun/password', [AkunController::class, 'updatePassword']);

use App\Http\Controllers\BarangMasukController;

Route::resource('barang-masuk', BarangMasukController::class);