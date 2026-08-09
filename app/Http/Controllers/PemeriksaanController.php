<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemeriksaan;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Jaminan;
use App\Models\Petugas;
use App\Models\Barang;
use App\Models\PenggunaanBarang;
use Carbon\Carbon;
use App\Models\BarangMasuk;
use Illuminate\Support\Facades\DB;

class PemeriksaanController extends Controller
{
   public function index()
{
    $search = request('search');
    $pemeriksaan = Pemeriksaan::with([
        'pasien',
        'dokter',
        'jaminan',
        'petugas'
    ])
    ->when($search, function ($query) use ($search) {

    $query->where('nama_pemeriksaan', 'like', "%$search%")
          ->orWhere('tanggal_pemeriksaan', 'like', "%$search%")

          ->orWhereHas('pasien', function ($q) use ($search) {
                $q->where('nama_pasien', 'like', "%$search%");
          })

          ->orWhereHas('dokter', function ($q) use ($search) {
                $q->where('nama_dokter', 'like', "%$search%");
          })

          ->orWhereHas('petugas', function ($q) use ($search) {
                $q->where('nama_petugas', 'like', "%$search%");
          });

})

->orderBy('id_pemeriksaan', 'desc')
->get();

    $pemeriksaanHariIni = Pemeriksaan::whereDate(
    'tanggal_pemeriksaan',
    today()
    )->count();

    $stokMenipis = Barang::where('stok', '<=', 100)->count();

    $kadaluarsa = BarangMasuk::where('sisa_stok', '>', 0)
        ->whereDate('tanggal_expired', '<=', now()->addDays(90))
        ->count();

    return view('pemeriksaan.index', compact(
        'pemeriksaan',
        'pemeriksaanHariIni',
        'stokMenipis',
        'kadaluarsa'
    ));
}

   public function create()
{
    $pasien = Pasien::all();
    $dokter = Dokter::all();
    $jaminan = Jaminan::all();
    $petugas = Petugas::all();
    $barang = Barang::all();

    $tanggal = now()->format('Ymd');

    $lastPemeriksaan = Pemeriksaan::whereDate('created_at', today())
        ->latest('id_pemeriksaan')
        ->first();

    if ($lastPemeriksaan) {
        $lastNumber = (int) substr($lastPemeriksaan->no_lab, -3);
        $urutan = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $urutan = '001';
    }

    $noLab = 'LAB-' . $tanggal . '-' . $urutan;

    return view('pemeriksaan.create', compact(
        'pasien',
        'dokter',
        'jaminan',
        'petugas',
        'barang',
        'noLab'
    ));
}
    public function store(Request $request)
            {
            $pasien = Pasien::where('nama_pasien', $request->nama_pasien)->first();

        if (!$pasien) {

            $pasien = Pasien::create([
                'no_medik' => 'RM' . date('YmdHis'),
                'nama_pasien' => $request->nama_pasien,
                'alamat' => $request->alamat,
                'tanggal_lahir' => now(),
                'keterangan_pasien' => 'Umum'
            ]);

}
            $dokter = Dokter::where('nama_dokter', $request->nama_dokter)->first();

            if (!$dokter) {

                $dokter = Dokter::create([
                    'nama_dokter' => $request->nama_dokter
                ]);
}
            $jaminan = Jaminan::where('nama_jaminan', $request->nama_jaminan)->first();

            if (!$jaminan) {

                $jaminan = Jaminan::create([
                    'nama_jaminan' => $request->nama_jaminan
                ]);
}

        $tanggal = $request->tanggal_pemeriksaan;

            $prefix = 'LAB-' . date('Ymd', strtotime($tanggal));

           $lastNoLab = Pemeriksaan::whereDate('tanggal_pemeriksaan', $tanggal)
                ->where('no_lab', 'like', $prefix . '-%')
                ->max('no_lab');

            if ($lastNoLab) {
                $lastNumber = (int) substr($lastNoLab, -3);
                $urutan = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $urutan = '001';
            }

            $noLab = $prefix . '-' . $urutan;
            
        $pemeriksaan = Pemeriksaan::create([
            'no_lab' => $noLab,
            'nama_pemeriksaan' => $request->nama_pemeriksaan,
            'id_pasien' => $pasien->id_pasien,
            'id_dokter' => $dokter->id_dokter,
            'id_jaminan' => $jaminan->id_jaminan,
            'id_petugas' => $request->id_petugas,
            'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
            'keterangan_klinik' => $request->keterangan_klinik,
            'hasil_pemeriksaan' => $request->hasil_pemeriksaan,
        ]);

        if ($request->has('id_barang')) {

            foreach ($request->id_barang as $key => $id_barang) {

                if (
                    !empty($id_barang) &&
                    !empty($request->jumlah_penggunaan[$key])
                ) {

                    PenggunaanBarang::create([
                        'id_pemeriksaan' => $pemeriksaan->id_pemeriksaan,
                        'id_barang' => $id_barang,
                        'jumlah_penggunaan' => $request->jumlah_penggunaan[$key]
                    ]);

                    $sisaPenggunaan = $request->jumlah_penggunaan[$key];

                    $batchBarang = BarangMasuk::where('id_barang', $id_barang)
                        ->where('sisa_stok', '>', 0)
                        ->orderBy('tanggal_expired')
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

                    $barang = Barang::find($id_barang);

                    if ($barang) {

                        $barang->stok = BarangMasuk::where('id_barang', $id_barang)
                            ->sum('sisa_stok');

                        $barang->save();
                    }
                }
            }
        }

        return redirect('/pemeriksaan');
    }

    public function edit($id)
    {
        $pemeriksaan = Pemeriksaan::with([
            'penggunaanBarang.barang'
        ])->findOrFail($id);

        $pasien = Pasien::all();
        $dokter = Dokter::all();
        $jaminan = Jaminan::all();
        $petugas = Petugas::all();
        $barang = Barang::all();

        return view('pemeriksaan.edit', compact(
            'pemeriksaan',
            'pasien',
            'dokter',
            'jaminan',
            'petugas',
            'barang'
        ));
    }

    public function update(Request $request, $id)
{
    $pemeriksaan = Pemeriksaan::findOrFail($id);

    $hasil = $pemeriksaan->update([
        'nama_pemeriksaan' => $request->nama_pemeriksaan,
        'id_pasien' => $request->id_pasien,
        'id_dokter' => $request->id_dokter,
        'id_jaminan' => $request->id_jaminan,
        'id_petugas' => $request->id_petugas,
        'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
        'keterangan_klinik' => $request->keterangan_klinik,
        'hasil_pemeriksaan' => $request->hasil_pemeriksaan,
    ]);
    return redirect('/pemeriksaan')->with('success', 'Data berhasil diupdate');
}

   public function destroy($id)
{
    $pemeriksaan = Pemeriksaan::with('penggunaanBarang')->findOrFail($id);

    foreach ($pemeriksaan->penggunaanBarang as $penggunaan) {

        $jumlahKembali = $penggunaan->jumlah_penggunaan;

        $batchBarang = BarangMasuk::where('id_barang', $penggunaan->id_barang)
            ->orderBy('tanggal_expired', 'asc')
            ->get();

        foreach ($batchBarang as $batch) {

            if ($jumlahKembali <= 0) {
                break;
            }

            $kapasitas = $batch->jumlah_masuk - $batch->sisa_stok;

            if ($kapasitas <= 0) {
                continue;
            }

            if ($kapasitas >= $jumlahKembali) {

                $batch->sisa_stok += $jumlahKembali;
                $batch->save();

                $jumlahKembali = 0;

            } else {

                $batch->sisa_stok += $kapasitas;
                $batch->save();

                $jumlahKembali -= $kapasitas;
            }
        }

        $barang = Barang::find($penggunaan->id_barang);

        if ($barang) {
            $barang->stok = BarangMasuk::where('id_barang', $penggunaan->id_barang)
                ->sum('sisa_stok');
            $barang->save();
        }
    }

    PenggunaanBarang::where('id_pemeriksaan', $id)->delete();

    $pemeriksaan->delete();

    return redirect('/pemeriksaan')
        ->with('success', 'Pemeriksaan berhasil dihapus.');
}

    public function cariPasien($nama)
{
    $pasien = Pasien::where('nama_pasien', $nama)->first();

    if ($pasien) {
        return response()->json($pasien);
    }

    return response()->json(null);
}
public function cetak($id)
{
    $pemeriksaan = Pemeriksaan::with([
        'pasien',
        'dokter',
        'jaminan',
        'petugas',
        'penggunaanBarang.barang'
    ])->findOrFail($id);

    return view('pemeriksaan.cetak', compact('pemeriksaan'));
}
}