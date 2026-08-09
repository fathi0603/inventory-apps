<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class KartuStokController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $barang = Barang::with([
            'penggunaanBarang.pemeriksaan'
        ])
        ->when($search, function ($query) use ($search) {

            $query->where(function ($q) use ($search) {

                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('jenis_barang', 'like', "%{$search}%");

            });

        })
        ->orderBy('nama_barang')
        ->get();

        return view('kartu_stok.index', compact('barang'));
    }


    public function cetak(Request $request)
    {
        $bulan = $request->bulan ?? now()->format('Y-m');

        $barang = Barang::with([
            'penggunaanBarang.pemeriksaan'
        ])
        ->orderBy('nama_barang')
        ->get();

        return view('kartu_stok.cetak', compact(
            'barang',
            'bulan'
        ));
    }
}