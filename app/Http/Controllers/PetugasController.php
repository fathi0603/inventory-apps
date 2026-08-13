<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use App\Http\Controllers\JadwalController;
use Illuminate\Http\Request;
use App\Models\UserLogin;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = Petugas::all();

        return view('petugas.index', compact('petugas'));
    }
    public function create()
    {
        return view('petugas.create');
    }
    public function store(Request $request)
{
    $request->validate([
        'nama_petugas' => 'required',
        'jabatan' => 'required',
    ]);

   
    $petugas = Petugas::create([
        'nama_petugas' => $request->nama_petugas,
        'jabatan'      => $request->jabatan,
    ]);

   
    $username = strtolower(str_replace(' ', '', $request->nama_petugas));

    
    $cek = UserLogin::where('username', $username)->count();

    if ($cek > 0) {
        $username .= ($cek + 1);
    }

   
    UserLogin::create([
    'username'   => $username,
    'password'   => Hash::make('12345'),
    'role'       => $request->jabatan,
    'id_petugas' => $petugas->id_petugas,
]);

    return redirect('/jadwal/create?periode=' . now()->format('Y-\WW'))
            ->with('success', 'Petugas berhasil ditambahkan.');
}

    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);

        return view('petugas.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        $petugas->update([
            'nama_petugas' => $request->nama_petugas
        ]);

        return redirect('/petugas');
    }

    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);

        $petugas->delete();

        return redirect('/petugas');
    }
}