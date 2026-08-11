<?php

namespace App\Http\Controllers;

use App\Models\Pemeriksaan;
use App\Models\PenggunaanBarang;
use App\Models\Jadwal;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
   public function index()
{
    $jenis = request('jenis', 'penggunaan');

    $tanggalAwal = request('tanggal_awal');
    $tanggalAkhir = request('tanggal_akhir');

    $bpjs = Pemeriksaan::whereHas('jaminan', fn($q) => $q->where('nama_jaminan', 'BPJS'))->count();
    $bpjstk = Pemeriksaan::whereHas('jaminan', fn($q) => $q->where('nama_jaminan', 'BPJS TK'))->count();
    $asuransi = Pemeriksaan::whereHas('jaminan', fn($q) => $q->where('nama_jaminan', 'Asuransi'))->count();
    $umum = Pemeriksaan::whereHas('jaminan', fn($q) => $q->where('nama_jaminan', 'Umum'))->count();
    $mcu = Pemeriksaan::whereHas('jaminan', fn($q) => $q->where('nama_jaminan', 'MCU'))->count();

    $penggunaan = collect();
    $jadwal = collect();
    $laporanJaminan = collect();

    
    if ($jenis == 'penggunaan') {

        $query = PenggunaanBarang::select(
            'id_barang',
            DB::raw('SUM(jumlah_penggunaan) as total_penggunaan'),
            DB::raw('COUNT(*) as frekuensi')
        )
        ->join(
            'pemeriksaan',
            'penggunaan_barang.id_pemeriksaan',
            '=',
            'pemeriksaan.id_pemeriksaan'
        )
        ->with('barang');

        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween(
                'pemeriksaan.tanggal_pemeriksaan',
                [
                    $tanggalAwal,
                    $tanggalAkhir
                ]
            );
        }

        $penggunaan = $query
            ->groupBy('id_barang')
            ->orderByDesc('total_penggunaan')
            ->get();
    }

    
    
if ($jenis == 'jadwal') {

    $query = Jadwal::with('petugas');

 
    
    if ($tanggalAwal && $tanggalAkhir) {

        $awal = Carbon::parse($tanggalAwal)->startOfDay();
        $akhir = Carbon::parse($tanggalAkhir)->endOfDay();

        $jadwalData = $query->get()->filter(function ($item) use ($awal, $akhir) {

            

            [$tahun, $minggu] = explode('-W', $item->periode);

            $hariMap = [
                'Senin'  => 1,
                'Selasa' => 2,
                'Rabu'   => 3,
                'Kamis'  => 4,
                'Jumat'  => 5,
                'Sabtu'  => 6,
                'Minggu' => 7,
            ];

            
            $tanggalJadwal = Carbon::now()->setISODate(
                (int) $tahun,
                (int) $minggu,
                $hariMap[$item->hari]
            )->startOfDay();

            return $tanggalJadwal->between(
                $awal->copy()->startOfDay(),
                $akhir->copy()->startOfDay()
            );
        });

    } else {

        $jadwalData = $query->get();
    }


    

    $jumlahMinggu = 1;

    if ($tanggalAwal && $tanggalAkhir) {

        $awal = Carbon::parse($tanggalAwal);
        $akhir = Carbon::parse($tanggalAkhir);

        $minggu = [];

        $tanggal = $awal->copy();

        while ($tanggal->lte($akhir)) {

            $minggu[] = $tanggal->format('o-W');

            $tanggal->addDay();
        }

        $jumlahMinggu = count(array_unique($minggu));
    }


    

    $jadwal = $jadwalData
        ->groupBy('id_petugas')
        ->map(function ($items) use ($jumlahMinggu) {

            $petugas = $items->first()->petugas;

            $totalShift = $items
                ->where('shift', '!=', 'OFF')
                ->count();

            
            $totalJam = $totalShift * 8;

            
            $targetJam = $jumlahMinggu * 48;


            if ($totalJam == $targetJam) {

                $capaian = 'Tercapai';

            } elseif ($totalJam < $targetJam) {

                $capaian = 'Belum Tercapai';

            } else {

                $capaian = 'Melebihi Target';
            }


            return [
                'nama' => $petugas->nama_petugas,

                'total_shift' => $totalShift,

                'total_jam' => $totalJam,

                'capaian' => $capaian,
            ];

        })
        ->values();
}

    // ================= LAPORAN JAMINAN =================
    if ($jenis == 'jaminan') {

        $laporanJaminan = Pemeriksaan::select(
            'nama_pemeriksaan',
            DB::raw("SUM(CASE WHEN id_jaminan=1 THEN 1 ELSE 0 END) as bpjs"),
            DB::raw("SUM(CASE WHEN id_jaminan=2 THEN 1 ELSE 0 END) as bpjstk"),
            DB::raw("SUM(CASE WHEN id_jaminan=3 THEN 1 ELSE 0 END) as asuransi"),
            DB::raw("SUM(CASE WHEN id_jaminan=4 THEN 1 ELSE 0 END) as umum"),
            DB::raw("SUM(CASE WHEN id_jaminan=5 THEN 1 ELSE 0 END) as mcu")
        )
        ->groupBy('nama_pemeriksaan')
        ->get();
    }

    return view('laporan.index', compact(
        'jenis',
        'tanggalAwal',
        'tanggalAkhir',
        'bpjs',
        'bpjstk',
        'asuransi',
        'umum',
        'mcu',
        'penggunaan',
        'jadwal',
        'laporanJaminan'
    ));
}
public function cetak()
{
    $jenis = request('jenis', 'penggunaan');

    $tanggalAwal = request('tanggal_awal');
    $tanggalAkhir = request('tanggal_akhir');

    if ($jenis == 'penggunaan') {

        $query = PenggunaanBarang::select(
            'id_barang',
            DB::raw('SUM(jumlah_penggunaan) as total_penggunaan'),
            DB::raw('COUNT(*) as frekuensi')
        )
        ->join(
            'pemeriksaan',
            'penggunaan_barang.id_pemeriksaan',
            '=',
            'pemeriksaan.id_pemeriksaan'
        )
        ->with('barang');

        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween(
                'pemeriksaan.tanggal_pemeriksaan',
                [
                    $tanggalAwal,
                    $tanggalAkhir
                ]
            );
        }

        $data = $query
            ->groupBy('id_barang')
            ->orderByDesc('total_penggunaan')
            ->get();

    } elseif ($jenis == 'jaminan') {

        $query = Pemeriksaan::select(
            'nama_pemeriksaan',
            DB::raw("SUM(CASE WHEN id_jaminan=1 THEN 1 ELSE 0 END) as bpjs"),
            DB::raw("SUM(CASE WHEN id_jaminan=2 THEN 1 ELSE 0 END) as bpjstk"),
            DB::raw("SUM(CASE WHEN id_jaminan=3 THEN 1 ELSE 0 END) as asuransi"),
            DB::raw("SUM(CASE WHEN id_jaminan=4 THEN 1 ELSE 0 END) as umum"),
            DB::raw("SUM(CASE WHEN id_jaminan=5 THEN 1 ELSE 0 END) as mcu")
        );

        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween(
                'tanggal_pemeriksaan',
                [
                    $tanggalAwal,
                    $tanggalAkhir
                ]
            );
        }

        $data = $query
            ->groupBy('nama_pemeriksaan')
            ->get();

    } elseif ($jenis == 'jadwal') {

        $data = Jadwal::with('petugas')->get();

    } else {

        $data = collect();

    }

    return view('laporan.cetak', compact(
        'jenis',
        'data',
        'tanggalAwal',
        'tanggalAkhir'
    ));
}
}