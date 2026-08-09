<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pemeriksaan;
use App\Models\BarangMasuk;

class DashboardController extends Controller
{
   public function index()
{
    $pemeriksaanHariIni = Pemeriksaan::whereDate(
        'tanggal_pemeriksaan',
        today()
    )->count();

    $stokMinimum = Barang::where('stok', '<=', 100)->count();

    $kadaluarsa = BarangMasuk::where('sisa_stok', '>', 0)
    ->whereDate('tanggal_expired', '<=', now()->addDays(90))
    ->count();

   $barang = Barang::all();

$barangExpired = BarangMasuk::with('barang')
    ->where('sisa_stok', '>', 0)
    ->whereDate('tanggal_expired', '<=', now()->addDays(90))
    ->orderBy('tanggal_expired')
    ->get();

    return view('dashboard', compact(
    'pemeriksaanHariIni',
    'stokMinimum',
    'kadaluarsa',
    'barang',
    'barangExpired'
));
}
}