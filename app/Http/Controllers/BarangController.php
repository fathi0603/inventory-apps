<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BarangController extends Controller
{
   public function index()
{
    if (!session('login')) {
        return redirect('/login');
    }

    $query = Barang::query();
    $totalBarang = Barang::count();

    if(request('search')){

        $query->where('kode_barang','like','%'.request('search').'%')
              ->orWhere('nama_barang','like','%'.request('search').'%')
              ->orWhere('jenis_barang','like','%'.request('search').'%')
              ->orWhere('lokasi','like','%'.request('search').'%');

    }

    $barang = $query
    ->with('barangMasuk')
    ->orderBy('id_barang','desc')
    ->get();

    foreach ($barang as $b) {

    $b->total_stok = $b->barangMasuk->sum('sisa_stok');

    $b->stok_aman = 0;
    $b->stok_segera_expired = 0;
    $b->stok_expired = 0;

    foreach ($b->barangMasuk as $batch) {

        if ($batch->sisa_stok <= 0) {
            continue;
        }

        $expiredDate = \Carbon\Carbon::parse($batch->tanggal_expired);

        if ($expiredDate->isPast()) {

            $b->stok_expired += $batch->sisa_stok;

        } elseif ($expiredDate->lessThanOrEqualTo(now()->addDays(90))) {

            $b->stok_segera_expired += $batch->sisa_stok;

        } else {

            $b->stok_aman += $batch->sisa_stok;

        }
    }

    if ($b->total_stok <= $b->stok_minimum) {

        $b->status = 'Stok Minimum';

    } elseif ($b->stok_expired > 0) {

        $b->status = 'Expired';

    } elseif ($b->stok_segera_expired > 0) {

        $b->status = 'Perlu Rotasi';

    } else {

        $b->status = 'Aman';

    }
}

    $stokMinimum = 0;
$expired = 0;
$barangAman = 0;

foreach ($barang as $b) {

    if ($b->total_stok <= $b->stok_minimum) {
        $stokMinimum++;
    }

    if ($b->stok_expired > 0 || $b->stok_segera_expired > 0) {
        $expired++;
    } else {
        $barangAman++;
    }
}

   return view('barang.index', compact(
    'barang',
    'totalBarang',
    'stokMinimum',
    'expired',
    'barangAman'
    ));
}

   public function create()
{
    $reagenTerakhir = Barang::where('kode_barang', 'like', 'RG%')
        ->get()
        ->map(function ($barang) {
            return (int) substr($barang->kode_barang, 2);
        })
        ->max() ?? 0;

    $bmhpTerakhir = Barang::where('kode_barang', 'like', 'BH%')
        ->get()
        ->map(function ($barang) {
            return (int) substr($barang->kode_barang, 2);
        })
        ->max() ?? 0;

    $kodeReagenBerikutnya = 'RG' . str_pad(
        $reagenTerakhir + 1,
        3,
        '0',
        STR_PAD_LEFT
    );

    $kodeBmhpBerikutnya = 'BH' . str_pad(
        $bmhpTerakhir + 1,
        3,
        '0',
        STR_PAD_LEFT
    );

    return view('barang.create', compact(
        'kodeReagenBerikutnya',
        'kodeBmhpBerikutnya'
    ));
}
    public function store(Request $request)
{
    $request->validate([
        'nama_barang' => 'required',
        'jenis_barang' => 'required|in:Reagen,BMHP',
        'stok_minimum' => 'required|numeric',
        'lokasi' => 'required',
    ]);


    if ($request->jenis_barang == 'Reagen') {

        $prefix = 'RG';

    } else {

        $prefix = 'BH';
    }


    $kodeBarang = Barang::where(
        'kode_barang',
        'like',
        $prefix . '%'
    )->pluck('kode_barang');


    $nomorTerakhir = 0;

    foreach ($kodeBarang as $kode) {

        $nomor = (int) substr($kode, 2);

        if ($nomor > $nomorTerakhir) {
            $nomorTerakhir = $nomor;
        }
    }


    $kodeBaru =
        $prefix .
        str_pad(
            $nomorTerakhir + 1,
            3,
            '0',
            STR_PAD_LEFT
        );


    Barang::create([

        'kode_barang' => $kodeBaru,

        'nama_barang' => $request->nama_barang,

        'jenis_barang' => $request->jenis_barang,

        'stok' => 0,

        'stok_minimum' => $request->stok_minimum,

        'lokasi' => $request->lokasi,

    ]);


    return redirect('/barang')
        ->with(
            'success',
            'Barang berhasil ditambahkan dengan kode ' . $kodeBaru
        );
}
public function edit($id)
{
    $barang = Barang::findOrFail($id);

    return view('barang.edit', compact('barang'));
}

public function update(Request $request, $id)
{
    $barang = Barang::findOrFail($id);

    $barang->update([
        'kode_barang'  => $request->kode_barang,
        'nama_barang'  => $request->nama_barang,
        'jenis_barang' => $request->jenis_barang,
        'stok_minimum' => $request->stok_minimum,
        'lokasi'       => $request->lokasi,
    ]);

    return redirect('/barang')
        ->with('success', 'Data barang berhasil diubah.');
}
public function destroy($id)
{
    $barang = Barang::findOrFail($id);

    $barang->delete();

    return redirect('/barang');
}
public function show($id)
{
    $barang = Barang::with('barangMasuk')->findOrFail($id);

    $batchBarang = $barang->barangMasuk()->orderBy('tanggal_expired')->get();

    $totalStok = $batchBarang->sum('sisa_stok');

    $stokAman = 0;
    $stokSegeraExpired = 0;
    $stokExpired = 0;

    foreach ($batchBarang as $batch) {

        if ($batch->sisa_stok <= 0) {
            continue;
        }

        $expired = Carbon::parse($batch->tanggal_expired);

        if ($expired->isPast()) {

            $stokExpired += $batch->sisa_stok;

        } elseif ($expired->lessThanOrEqualTo(now()->addDays(90))) {

            $stokSegeraExpired += $batch->sisa_stok;

        } else {

            $stokAman += $batch->sisa_stok;

        }
    }

     $status = 'Aman';

    if ($totalStok <= $barang->stok_minimum) {

        $status = 'Stok Minimum';

    } elseif ($stokExpired > 0) {

        $status = 'Expired';

    } elseif ($stokSegeraExpired > 0) {

        $status = 'Perlu Rotasi';

    }

    return view('barang.show', compact(
        'barang',
        'batchBarang',
        'totalStok',
        'stokAman',
        'stokSegeraExpired',
        'stokExpired',
        'status'
    ));
}

public function barangMasuk()
{
    return $this->hasMany(BarangMasuk::class, 'id_barang');
}
}