<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan</title>

    <style>

        *{
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            margin:35px;
            color:#000;
        }

        .header{
            text-align:center;
            line-height:1.5;
        }

        .header h2,
        .header h3,
        .header p{
            margin:0;
        }

        hr{
            border:1px solid #000;
            margin:15px 0;
        }

        .info{
            margin:20px 0;
        }

        .info table{
            width:auto;
            border:none;
        }

        .info td{
            border:none;
            padding:3px 6px;
            text-align:left;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
        }

        table th,
        table td{
            border:1px solid #000;
            padding:8px;
            font-size:13px;
            text-align:center;
        }

        table th{
            background:#f3f3f3;
            font-weight:bold;
        }

        .ttd{
            width:250px;
            margin-left:auto;
            margin-top:60px;
            text-align:center;
        }

        .btn{
            margin-bottom:20px;
        }

        @media print{

            .btn{
                display:none;
            }

            body{
                margin:20px;
            }

        }

    </style>

</head>
<body>

<div class="btn">
    <button onclick="window.print()">Cetak</button>
    <button onclick="history.back()">Kembali</button>
</div>

<div style="text-align:center">

    <h2 style="margin-bottom:0">
        LABORATORIUM RS RIDHOKA SALMA
    </h2>

    <div>
        Jl. Raya Imam Bonjol No.7, Kalijaya, Kec. Cikarang Barat,
        Kabupaten Bekasi, Jawa Barat (Kode Pos: 17520).
    </div>

    <div>
        Kabupaten Bekasi
    </div>

</div>

<hr>

<h3 style="text-align:center">
    LAPORAN {{ strtoupper($jenis) }}
</h3>
<div class="info">

    <table>

        <tr>
            <p>
                <strong>Periode :</strong>

                {{ $tanggalAwal }}
                -
                {{ $tanggalAkhir }}
            </p>
        </tr>

    </table>

</div>

{{-- ========================= PENGGUNAAN ========================= --}}

@if($jenis=='penggunaan')

<table>

    <thead>

        <tr>

            <th>No</th>
            <th>Nama Barang</th>
            <th>Kode Barang</th>
            <th>Total Penggunaan</th>
            <th>Frekuensi</th>

        </tr>

    </thead>

    <tbody>

        @foreach($data as $item)

            <tr>

                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->barang->nama_barang }}</td>
                <td>{{ $item->barang->kode_barang }}</td>
                <td>{{ $item->total_penggunaan }}</td>
                <td>{{ $item->frekuensi }}x</td>

            </tr>

        @endforeach

    </tbody>

</table>

@endif

{{-- ========================= JAMINAN ========================= --}}

@if($jenis=='jaminan')

<table>

<thead>

<tr>

<th>No</th>
<th>Pemeriksaan</th>
<th>BPJS</th>
<th>BPJS TK</th>
<th>Asuransi</th>
<th>Umum</th>
<th>MCU</th>

</tr>

</thead>

<tbody>

@forelse($data as $item)

<tr>

<td>{{ $loop->iteration }}</td>
<td>{{ $item->nama_pemeriksaan }}</td>
<td>{{ $item->bpjs }}</td>
<td>{{ $item->bpjstk }}</td>
<td>{{ $item->asuransi }}</td>
<td>{{ $item->umum }}</td>
<td>{{ $item->mcu }}</td>

</tr>

@empty

<tr>
    <td colspan="7">Data tidak tersedia</td>
</tr>

@endforelse

</tbody>

</table>

@endif

{{-- ========================= JADWAL ========================= --}}

@if($jenis=='jadwal')

<table>

<thead>

<tr>

<th>No</th>
<th>Petugas</th>
<th>Hari</th>
<th>Shift</th>
<th>Periode</th>

</tr>

</thead>

<tbody>

@forelse($data as $item)

<tr>

<td>{{ $loop->iteration }}</td>
<td>{{ $item->petugas->nama_petugas }}</td>
<td>{{ $item->hari }}</td>
<td>{{ $item->shift }}</td>
<td>{{ $item->periode }}</td>

</tr>

@empty

<tr>
    <td colspan="5">Data tidak tersedia</td>
</tr>

@endforelse

</tbody>

</table>

@endif

<div class="ttd">

<div style="width:250px; margin-left:auto; margin-top:50px; text-align:center;">

    Bekasi,
    {{ date('d-m-Y') }}

    <br><br><br><br>

    <strong>Koordinator Laboratorium</strong>

</div>

</body>
</html>