<?php

namespace App\Http\Controllers;

use App\Models\Jaminan;
use Illuminate\Http\Request;

class JaminanController extends Controller
{
    public function index()
    {
        $jaminan = Jaminan::all();
        return view('jaminan.index', compact('jaminan'));
    }

    public function create()
    {
        return view('jaminan.create');
    }

    public function store(Request $request)
    {
        Jaminan::create([
            'nama_jaminan' => $request->nama_jaminan
        ]);

        return redirect('/jaminan');
    }

    public function edit($id)
    {
        $jaminan = Jaminan::findOrFail($id);
        return view('jaminan.edit', compact('jaminan'));
    }

    public function update(Request $request, $id)
    {
        $jaminan = Jaminan::findOrFail($id);

        $jaminan->update([
            'nama_jaminan' => $request->nama_jaminan
        ]);

        return redirect('/jaminan');
    }

    public function destroy($id)
    {
        $jaminan = Jaminan::findOrFail($id);
        $jaminan->delete();

        return redirect('/jaminan');
    }
}