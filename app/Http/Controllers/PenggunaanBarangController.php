<?php

namespace App\Http\Controllers;

use App\Models\PenggunaanBarang;
use App\Models\Pemeriksaan;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenggunaanBarangController extends Controller
{
    // Tampilkan data
    public function index()
    {
        $penggunaan = PenggunaanBarang::all();

        return view('penggunaan_barang.index', compact('penggunaan'));
    }

    // Form tambah
    public function create()
    {
        $pemeriksaan = Pemeriksaan::all();
        $barang = Barang::all();

        return view('penggunaan_barang.create', compact('pemeriksaan', 'barang'));
    }

    // Simpan data
    public function store(Request $request)
{
    DB::transaction(function () use ($request) {

        PenggunaanBarang::create([
            'id_pemeriksaan' => $request->id_pemeriksaan,
            'id_barang' => $request->id_barang,
            'jumlah_penggunaan' => $request->jumlah_penggunaan,
        ]);

        $sisaPenggunaan = $request->jumlah_penggunaan;

        $batchBarang = BarangMasuk::where('id_barang', $request->id_barang)
            ->where('sisa_stok', '>', 0)
            ->orderBy('tanggal_expired', 'asc')
            ->get();


        foreach ($batchBarang as $batch) {

            if ($sisaPenggunaan <= 0) {
                break;
            }

            if ($batch->sisa_stok >= $sisaPenggunaan) {

                $batch->sisa_stok -= $sisaPenggunaan;
                $batch->save();

                $sisaPenggunaan = 0;

            } else {

                $sisaPenggunaan -= $batch->sisa_stok;

                $batch->sisa_stok = 0;
                $batch->save();
            }
        }

        $barang = Barang::findOrFail($request->id_barang);
        $barang->stok = BarangMasuk::where('id_barang', $request->id_barang)
                            ->sum('sisa_stok');
        $barang->save();
    });

    return redirect('/penggunaan-barang');
}

    // Form edit
    public function edit($id)
    {
        $penggunaan = PenggunaanBarang::findOrFail($id);
        $pemeriksaan = Pemeriksaan::all();
        $barang = Barang::all();

        return view(
            'penggunaan_barang.edit',
            compact('penggunaan', 'pemeriksaan', 'barang')
        );
    }

    // Update data
    public function update(Request $request, $id)
    {
        $penggunaan = PenggunaanBarang::findOrFail($id);

        // kembalikan stok lama
        $barangLama = Barang::findOrFail($penggunaan->id_barang);
        $barangLama->stok += $penggunaan->jumlah_penggunaan;
        $barangLama->save();

        // update penggunaan
        $penggunaan->update([
            'id_pemeriksaan' => $request->id_pemeriksaan,
            'id_barang' => $request->id_barang,
            'jumlah_penggunaan' => $request->jumlah_penggunaan,
        ]);

        // kurangi stok baru
        $barangBaru = Barang::findOrFail($request->id_barang);
        $barangBaru->stok -= $request->jumlah_penggunaan;
        $barangBaru->save();

        return redirect('/penggunaan-barang');
    }

    // Hapus data
    public function destroy($id)
    {
        $penggunaan = PenggunaanBarang::findOrFail($id);

        $barang = Barang::findOrFail($penggunaan->id_barang);
        $barang->stok += $penggunaan->jumlah_penggunaan;
        $barang->save();

        $penggunaan->delete();

        return redirect('/penggunaan-barang');
    }
}