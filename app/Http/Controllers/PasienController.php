<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        
        if (!session('login')) {
        return redirect('/login');
    }
        $pasien = Pasien::all();
        return view('pasien.index', compact('pasien'));
    }

    public function create()
    {
        return view('pasien.create');
    }

    public function store(Request $request)
    {
        Pasien::create([
            'no_medik' => $request->no_medik,
            'nama_pasien' => $request->nama_pasien,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'keterangan_pasien' => $request->keterangan_pasien
        ]);

        return redirect('/pasien');
    }

    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasien.edit', compact('pasien'));
    }

    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        $pasien->update([
            'no_medik' => $request->no_medik,
            'nama_pasien' => $request->nama_pasien,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'keterangan_pasien' => $request->keterangan_pasien
        ]);

        return redirect('/pasien');
    }

    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return redirect('/pasien');
    }
}