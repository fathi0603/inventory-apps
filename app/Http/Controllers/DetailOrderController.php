<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use App\Models\FormOrder;
use App\Models\Barang;
use Illuminate\Http\Request;

class DetailOrderController extends Controller
{
    public function index()
    {
        $detail_order = DetailOrder::all();
        return view('detail_order.index', compact('detail_order'));
    }

    public function create()
    {
        $form_order = FormOrder::all();
        $barang = Barang::all();

        return view('detail_order.create',
            compact('form_order','barang'));
    }

    public function store(Request $request)
    {
        DetailOrder::create([
            'id_order' => $request->id_order,
            'id_barang' => $request->id_barang,
            'jumlah_order' => $request->jumlah_order,
            'keterangan_order' => $request->keterangan_order
        ]);

        return redirect('/detail-order');
    }

    public function edit($id)
    {
        $detail_order = DetailOrder::findOrFail($id);
        $form_order = FormOrder::all();
        $barang = Barang::all();

        return view('detail_order.edit',
            compact('detail_order','form_order','barang'));
    }

    public function update(Request $request, $id)
    {
        $detail_order = DetailOrder::findOrFail($id);

        $detail_order->update([
            'id_order' => $request->id_order,
            'id_barang' => $request->id_barang,
            'jumlah_order' => $request->jumlah_order,
            'keterangan_order' => $request->keterangan_order
        ]);

        return redirect('/detail-order');
    }

    public function destroy($id)
    {
        $detail_order = DetailOrder::findOrFail($id);
        $detail_order->delete();

        return redirect('/detail-order');
    }
}