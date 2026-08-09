<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<title>Hasil Pemeriksaan</title>

<style>

body{
    font-family: Arial, sans-serif;
    margin:40px;
    color:#000;
}

.header{
    text-align:center;
    border-bottom:3px solid #000;
    padding-bottom:12px;
    margin-bottom:25px;
}

.header h2{
    margin:0;
    font-size:28px;
}

.header h3{
    margin:5px 0;
    font-size:20px;
}

.header p{
    margin:2px;
    font-size:14px;
}

.judul{
    text-align:center;
    font-size:22px;
    font-weight:bold;
    margin:25px 0;
    text-transform:uppercase;
}

.info{
    width:100%;
    margin-bottom:25px;
}

.info td{
    border:none;
    padding:6px 2px;
}

.section{
    font-weight:bold;
    font-size:18px;
    margin-top:20px;
    margin-bottom:8px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#f2f2f2;
    border:1px solid black;
    padding:10px;
}

td{
    border:1px solid black;
    padding:8px;
}

.ttd{
    width:250px;
    margin-left:auto;
    margin-top:70px;
    text-align:center;
}

</style>

</head>

<body>

<div class="header">

    <h2>RS RIDHOKA SALMA</h2>

    <h3>LABORATORIUM KLINIK</h3>
</div>

<div class="judul">

HASIL PEMERIKSAAN LABORATORIUM

</div>

<hr>

<table class="info">

<tr>
<td width="180">No Laboratorium</td>
<td>: {{ $pemeriksaan->no_lab }}</td>
</tr>

<tr>
<td>Nama Pasien</td>
<td>: {{ $pemeriksaan->pasien->nama_pasien }}</td>
</tr>

<tr>
<td>Dokter</td>
<td>: {{ $pemeriksaan->dokter->nama_dokter }}</td>
</tr>

<tr>
<td>Petugas</td>
<td>: {{ $pemeriksaan->petugas->nama_petugas }}</td>
</tr>

<tr>
<td>Jaminan</td>
<td>: {{ $pemeriksaan->jaminan->nama_jaminan }}</td>
</tr>

<tr>
<td>Tanggal</td>
<td>: {{ $pemeriksaan->tanggal_pemeriksaan }}</td>
</tr>

<tr>
<td>Asal Klinik</td>
<td>: {{ $pemeriksaan->keterangan_klinik }}</td>
</tr>

<tr>
<td>Pemeriksaan</td>
<td>: {{ $pemeriksaan->nama_pemeriksaan }}</td>
</tr>

<tr>
<td>Hasil</td>
<td>: {{ $pemeriksaan->hasil_pemeriksaan }}</td>
</tr>

</table>

<br>

<h3>Penggunaan Reagen & BMHP</h3>

<table>

<tr>

<th>No</th>

<th>Barang</th>

<th>Jumlah</th>

</tr>

@foreach($pemeriksaan->penggunaanBarang as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $item->barang->nama_barang }}</td>

<td>{{ $item->jumlah_penggunaan }}</td>

</tr>

@endforeach

</table>

<div class="ttd">

Bandung,
{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}

<br><br><br><br>

<b>

{{ $pemeriksaan->petugas->nama_petugas }}

</b>

</div>

<script>

window.print();

</script>

</body>
</html>