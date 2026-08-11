<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Petugas;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
   public function index(Request $request)
{
    $periode = request('periode');

if (!$periode) {
    $periode = date('Y') . '-W' . date('W');
}

   $query = Jadwal::with('petugas');

$query->where('periode', $periode);

if(session('role') == 'Petugas Laboratorium'){
    $query->where('id_petugas', session('id_petugas'));
}

$jadwal = $query
    ->orderBy('id_petugas')
    ->orderBy('hari')
    ->get()
    ->groupBy('id_petugas')
    ->map(function ($items) {

        $petugas = $items->first()->petugas;

        $row = [
            'id_petugas' => $petugas->id_petugas,
            'nama' => $petugas->nama_petugas,

            'Senin' => 'OFF',
            'Selasa' => 'OFF',
            'Rabu' => 'OFF',
            'Kamis' => 'OFF',
            'Jumat' => 'OFF',
            'Sabtu' => 'OFF',
            'Minggu' => 'OFF',
        ];

        foreach ($items as $item) {
        $row[$item->hari] = $item->shift;
    }

    $row['total_jam'] = collect([
        $row['Senin'],
        $row['Selasa'],
        $row['Rabu'],
        $row['Kamis'],
        $row['Jumat'],
        $row['Sabtu'],
        $row['Minggu'],
    ])->filter(function ($shift) {
        return $shift != 'OFF';
    })->count() * 8;

    return $row;
    });

$totalPetugas = $jadwal->count();
$kurangJam = 0;
$cukupJam = 0;

foreach ($jadwal as &$data) {

    $totalJam = collect([
        $data['Senin'],
        $data['Selasa'],
        $data['Rabu'],
        $data['Kamis'],
        $data['Jumat'],
        $data['Sabtu'],
        $data['Minggu'],
    ])->filter(function ($shift) {
        return $shift != 'OFF';
    })->count() * 8;

        $data['total_jam'] = $totalJam;

        if ($totalJam >= 48) {
            $cukupJam++;
        } else {
            $kurangJam++;
        }
    }

    return view('jadwal.index', compact(
    'jadwal',
    'periode',
    'totalPetugas',
    'kurangJam',
    'cukupJam'
));

    }
    public function create(Request $request)
{
    $petugas = Petugas::all();

    $periode = $request->periode;

    return view(
        'jadwal.create',
        compact(
            'petugas',
            'periode'
        )
    );
}

    public function store(Request $request)
{
    $request->validate([
        'id_petugas' => 'required',
        'periode' => 'required'
    ]);

    $jadwalLama = Jadwal::where('id_petugas', $request->id_petugas)
    ->where('periode', $request->periode)
    ->count();

    if ($jadwalLama > 0) {
        return back()
            ->withInput()
            ->with('error', 'Petugas sudah memiliki jadwal pada periode tersebut.');
    }

    $hariList = [
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu'
    ];

    foreach ($hariList as $hari) {
        Jadwal::create([
            'id_petugas' => $request->id_petugas,
            'periode' => $request->periode,
            'hari' => $hari,
            'shift' => 'OFF'
        ]);
    }

    return redirect('/jadwal');
}
    public function edit($id_petugas, $periode)
{
    $petugas = Petugas::findOrFail($id_petugas);

    $jadwal = Jadwal::where('id_petugas', $id_petugas)
        ->where('periode', $periode)
        ->get()
        ->keyBy('hari');

    $hariList = [
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu'
    ];

    $shiftList = [
        'Pagi',
        'Siang',
        'Malam',
        'OFF',
        'MD9',
        'MD10'
    ];

    return view('jadwal.edit', compact(
        'petugas',
        'jadwal',
        'periode',
        'hariList',
        'shiftList'
    ));
}

    public function update(Request $request, $id_petugas, $periode)
{
    $shift = $request->shift;

    
    $jumlahShift = collect($shift)
        ->filter(function ($value) {
            return $value != 'OFF';
        })
        ->count();

    
    $totalJam = $jumlahShift * 8;


    if ($totalJam > 48) {

        return back()
            ->withInput()
            ->with(
                'error',
                'Jadwal tidak dapat disimpan. Total jam kerja maksimal adalah 48 jam per minggu.'
            );
    }

    
    foreach ($shift as $hari => $value) {

        Jadwal::updateOrCreate(
            [
                'id_petugas' => $id_petugas,
                'periode'    => $periode,
                'hari'       => $hari,
            ],
            [
                'shift' => $value
            ]
        );
    }

    return redirect('/jadwal?periode=' . $periode)
        ->with('success', 'Jadwal berhasil diperbarui.');
}

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect('/jadwal');
    }
    public function cetak($periode)
{
    $jadwal = Jadwal::with('petugas')
        ->where('periode', $periode)
        ->orderBy('id_petugas')
        ->orderBy('hari')
        ->get()
        ->groupBy('id_petugas')
        ->map(function ($items) {

            $petugas = $items->first()->petugas;

            $row = [
                'nama' => $petugas->nama_petugas,

                'Senin' => 'OFF',
                'Selasa' => 'OFF',
                'Rabu' => 'OFF',
                'Kamis' => 'OFF',
                'Jumat' => 'OFF',
                'Sabtu' => 'OFF',
                'Minggu' => 'OFF',
            ];

            foreach ($items as $item) {
                $row[$item->hari] = $item->shift;
            }

            return $row;
        });

    return view('jadwal.cetak', compact(
        'jadwal',
        'periode'
    ));
}
}