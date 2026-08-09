<?php

namespace App\Http\Controllers;

use App\Models\FormOrder;
use App\Models\Petugas;
use App\Models\Barang;
use App\Models\DetailOrder;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;

class FormOrderController extends Controller
{
  public function index()
{
    $search = request('search');

    $form_order = FormOrder::with([
        'pembuat',
        'pemeriksa',
        'detailOrder'
    ]) 

    ->when($search, function ($query) use ($search) {

        $query->where('tanggal_order', 'like', "%{$search}%")

            ->orWhereHas('pembuat', function ($q) use ($search) {
                $q->where('nama_petugas', 'like', "%{$search}%");
            })

            ->orWhereHas('pemeriksa', function ($q) use ($search) {
                $q->where('nama_petugas', 'like', "%{$search}%");
            });

    })

    ->orderBy('id_order', 'desc')
    ->get();

    $diajukan = FormOrder::where('status', 'Diajukan')->count();

    $disetujui = FormOrder::where('status', 'Disetujui')->count();

    $ditolak = FormOrder::where('status', 'Ditolak')->count();

    $diterima = FormOrder::where('status', 'Diterima')->count();

    return view('form_order.index', compact(
        'form_order',
        'diajukan',
        'disetujui',
        'ditolak',
        'diterima'
    ));
}

public function create()
{
    $barang = Barang::all();

    return view('form_order.create', compact('barang'));
}

public function edit($id)
{
   $form_order = FormOrder::with([
    'detailOrder.barang',
    'pembuat',
    'pemeriksa'
])->findOrFail($id);

    $petugas = Petugas::all();

    $koordinator = Petugas::where('jabatan', 'Koordinator Laboratorium')->get();

    return view('form_order.edit', compact(
        'form_order',
        'petugas',
        'koordinator'
    ));
}

public function update(Request $request, $id)
{
    $form_order = FormOrder::with('detailOrder')->findOrFail($id);

    $role = session('role');
    $statusLama = $form_order->status;
    $statusBaru = $request->status;

    if ($role == 'Koordinator Laboratorium') {

        if ($statusLama != 'Diajukan') {

            return redirect('/form_order')
                ->with('error', 'Order ini sudah diproses dan tidak dapat diubah lagi.');
        }

        if (!in_array($statusBaru, ['Disetujui', 'Ditolak'])) {

            return redirect('/form_order')
                ->with('error', 'Status tidak valid.');
        }

        $form_order->update([
            'status' => $statusBaru,
            'dicek_oleh' => session('id_petugas'),
        ]);

        return redirect('/form_order')
            ->with('success', 'Status order berhasil diperbarui.');
    }


    if ($role == 'Logistik') {

        if ($statusLama != 'Disetujui') {

            return redirect('/form_order')
                ->with('error', 'Order ini tidak dapat diproses lagi.');
        }

        if ($statusBaru != 'Diterima') {

            return redirect('/form_order')
                ->with('error', 'Status tidak valid.');
        }

        $form_order->update([
            'status' => 'Diterima',
        ]);

        return redirect('/form_order')
            ->with('success', 'Order berhasil diterima oleh logistik.');
    }


    if ($role == 'Petugas Laboratorium') {


        if ($statusLama == 'Ditolak') {

            if ($statusBaru != 'Diajukan') {

                return redirect('/form_order')
                    ->with('error', 'Order ditolak hanya dapat diajukan kembali.');
            }

            $form_order->update([
                'tanggal_order' => $request->tanggal_order,
                'departemen' => $request->departemen,
                'alasan' => $request->alasan,
                'status' => 'Diajukan',
            ]);

            return redirect('/form_order')
                ->with('success', 'Order berhasil direvisi dan diajukan kembali.');
        }


        if ($statusLama == 'Diterima') {


            foreach ($form_order->detailOrder as $index => $detail) {

                if (!isset($request->jumlah_diterima[$index])) {
                    continue;
                }

                $jumlahMasuk = (int) $request->jumlah_diterima[$index];

                $totalDiterima = $detail->jumlah_diterima + $jumlahMasuk;

                if ($totalDiterima > $detail->jumlah_order) {
                    $totalDiterima = $detail->jumlah_order;
                }

                $detail->update([
                    'jumlah_diterima' => $totalDiterima
                ]);

                $barang = Barang::find($detail->id_barang);

                if ($barang && $jumlahMasuk > 0) {

                    BarangMasuk::create([
                        'id_barang'       => $detail->id_barang,
                        'id_detail'       => $detail->id_detail,
                        'tanggal_masuk'   => $request->tanggal_masuk,
                        'tanggal_expired' => $request->tanggal_expired[$index],
                        'jumlah_masuk'    => $jumlahMasuk,
                        'sisa_stok'       => $jumlahMasuk,
                    ]);

                    $barang->stok += $jumlahMasuk;
                    $barang->save();
                }
            }

            $form_order->update([
                'konfirmasi_barang' => 1,
            ]);

            return redirect('/form_order')
                ->with('success', 'Barang berhasil dikonfirmasi.');
        }


        return redirect('/form_order')
            ->with('error', 'Order ini tidak dapat diubah.');
    }


    return redirect('/form_order')
        ->with('error', 'Anda tidak memiliki akses untuk mengubah order.');
}

public function destroy($id)
{
    $form_order = FormOrder::findOrFail($id);
    $form_order->delete();

    return redirect('/form_order');
}

public function store(Request $request)
{

    $formOrder = FormOrder::create([
    'tanggal_order' => $request->tanggal_order,
    'departemen'    => $request->departemen,
    'dibuat_oleh'   => session('id_user'),
    'dicek_oleh'    => null,
    'status'        => 'Diajukan',
    'alasan'        => $request->alasan,
]);

    foreach ($request->barang as $i => $barang) {

        DetailOrder::create([
            'id_order'         => $formOrder->id_order,
            'id_barang'        => $barang,
            'jumlah_order'     => $request->jumlah[$i],
            'keterangan_order' => '-'
        ]);
    }

    return redirect('/form_order')
        ->with('success', 'Data berhasil disimpan');
}
}