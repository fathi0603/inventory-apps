<!DOCTYPE html>
<html>
<head>
    <title>Cetak Jadwal Petugas</title>

    <style>

        body{
            font-family:Arial,sans-serif;
            margin:40px;
        }

        h2{
            text-align:center;
            margin-bottom:5px;
        }

        h3{
            text-align:center;
            margin-top:15px;
            margin-bottom:20px;
            font-weight:bold;
        }

        p{
            margin:4px 0;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        th,td{
            border:1px solid black;
            padding:8px;
            text-align:center;
        }

        th{
            background:#e5e5e5;
        }

        .ttd{
            width:300px;
            float:right;
            text-align:center;
            margin-top:60px;
        }

        @media print{

            .no-print{
                display:none;
            }

        }

    </style>

</head>

<body>

<div class="no-print" style="margin-bottom:20px;">

    <button onclick="window.print()">
        Cetak
    </button>

    <button onclick="window.history.back()">
        Kembali
    </button>

</div>

<h2>
    LABORATORIUM RS RIDHOKA SALMA
</h2>

<p style="text-align:center;">
   Jl. Raya Imam Bonjol No.7, Kalijaya, Kec. Cikarang Barat, Kabupaten Bekasi, Jawa Barat (Kode Pos: 17520).
</p>

<p style="text-align:center;">
    Kabupaten Bekasi
</p>

<hr>

<h3>
    JADWAL PETUGAS LABORATORIUM
</h3>

<p>
    @php
    $awal = \Carbon\Carbon::now()->setISODate(
        substr($periode, 0, 4),
        substr($periode, 6)
    )->startOfWeek();

    $akhir = $awal->copy()->endOfWeek();
@endphp

<p>
    <strong>Periode :</strong>
    {{ $awal->translatedFormat('d F Y') }}
    -
    {{ $akhir->translatedFormat('d F Y') }}
</p>
</p>

<table>

    <tr>

        <th>Petugas</th>
        <th>Senin</th>
        <th>Selasa</th>
        <th>Rabu</th>
        <th>Kamis</th>
        <th>Jumat</th>
        <th>Sabtu</th>
        <th>Minggu</th>
        <th>Total Jam</th>

    </tr>

    @foreach($jadwal as $data)

    @php

        $totalJam = collect([
            $data['Senin'],
            $data['Selasa'],
            $data['Rabu'],
            $data['Kamis'],
            $data['Jumat'],
            $data['Sabtu'],
            $data['Minggu']
        ])->filter(function($shift){
            return $shift != 'OFF';
        })->count() * 8;

    @endphp

    <tr>

        <td>{{ $data['nama'] }}</td>

        <td>{{ $data['Senin'] }}</td>

        <td>{{ $data['Selasa'] }}</td>

        <td>{{ $data['Rabu'] }}</td>

        <td>{{ $data['Kamis'] }}</td>

        <td>{{ $data['Jumat'] }}</td>

        <td>{{ $data['Sabtu'] }}</td>

        <td>{{ $data['Minggu'] }}</td>

        <td>{{ $totalJam }} Jam</td>

    </tr>

    @endforeach

</table>

<div class="ttd">

    Bekasi, {{ date('d-m-Y') }}

    <br><br><br><br><br>

    <b>Koordinator Laboratorium</b>

</div>

</body>
</html>