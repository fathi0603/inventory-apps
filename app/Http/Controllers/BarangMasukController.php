<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function index()
    {
        $search = request('search');

        $barang_masuk = BarangMasuk::with([
    'barang',
    'detailOrder'
])

            ->when($search, function ($query) use ($search) {

                $query->whereDate('tanggal_masuk', $search)

                    ->orWhereHas('barang', function ($q) use ($search) {

                        $q->where('nama_barang', 'like', "%{$search}%");

                    });

            })
            ->latest('id_masuk')
            ->get();

        return view('barang_masuk.index', compact('barang_masuk'));
    }
}