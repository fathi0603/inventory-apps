@extends('layouts.app')

@section('title','Pencatatan Aktivitas')

@section('css')
<style>

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.page-title h2{
    font-size:30px;
    color:#1b5e20;
    margin:0;
}

.page-title p{
    color:#777;
    margin-top:6px;
}

.btn-add{
    background:#1b5e20;
    color:white;
    text-decoration:none;
    padding:12px 20px;
    border-radius:10px;
    font-weight:600;
}

.btn-add:hover{
    background:#14501b;
}

.summary{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:30px;
}

.summary-card{
    background:white;
    border-radius:16px;
    padding:20px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.summary-card h4{
    margin:0;
    color:#666;
    font-size:15px;
}

.summary-card h2{
    margin-top:10px;
    color:#1b5e20;
    font-size:32px;
}

.tab-menu{
    display:flex;
    gap:15px;
    margin-bottom:25px;
}

.tab-menu a{
    text-decoration:none;
    padding:10px 20px;
    border-radius:10px;
    background:#e8f5e9;
    color:#1b5e20;
    font-weight:600;
}

.tab-menu a.active{
    background:#1b5e20;
    color:white;
}

.search-box{
    margin-bottom:25px;
}

.search-box input{
    width:100%;
    height:48px;
    border:1px solid #ddd;
    border-radius:10px;
    padding:0 15px;
    font-size:15px;
}

.table-card{
    background:white;
    border-radius:16px;
    padding:25px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#1b5e20;
    color:white;
}

th{
    padding:15px;
}

td{
    padding:15px;
    border-bottom:1px solid #eee;
}

tbody tr:hover{
    background:#f5fff5;
}

.badge-danger{
    background:#ffebee;
    color:#c62828;
    padding:6px 12px;
    border-radius:20px;
    text-decoration:none;
}

.badge-success{
    background:#e8f5e9;
    color:#2e7d32;
    padding:6px 12px;
    border-radius:20px;
    text-decoration:none;
}

.badge-print{
    background:#e3f2fd;
    color:#1565c0;
    padding:6px 12px;
    border-radius:20px;
    text-decoration:none;
}

</style>
@endsection

@section('content')

<div class="page-header">

    <div class="page-title">

        <h2>Pencatatan Aktivitas</h2>

        <p>Kelola data pemeriksaan laboratorium dan penggunaan reagen/BMHP.</p>

    </div>

    <a href="/pemeriksaan/create" class="btn-add">
        <i class="fa-solid fa-plus"></i>
        Tambah Pemeriksaan
    </a>

</div>

<div class="summary">

    <div class="summary-card">

        <h4>Pemeriksaan Hari Ini</h4>

        <h2>{{ $pemeriksaanHariIni }}</h2>


    </div>

    <div class="summary-card">

        <h4>Stok Menipis</h4>

        <h2>{{ $stokMenipis }}</h2>

    </div>

    <div class="summary-card">

        <h4>Expired < 3 Bulan</h4>

        <h2>{{ $kadaluarsa }}</h2>

    </div>

</div>

<div class="tab-menu">

    <a href="/pemeriksaan" class="active">
        Pencatatan Pemeriksaan
    </a>

    <a href="/barang">
        Inventory & Monitoring Stok
    </a>

</div>

<form action="/pemeriksaan" method="GET" class="search-box">

    <input
        type="text"
        name="search"
        placeholder="Cari nama pasien, pemeriksaan atau tanggal..."
        value="{{ request('search') }}">

</form>

<div class="table-card">

<table>

<thead>

<tr>

    <th>Tanggal</th>
    <th>Pemeriksaan</th>
    <th>Pasien</th>
    <th>Asal</th>
    <th>Jaminan</th>
    <th>Dokter</th>
    <th>Petugas</th>
    <th>Aksi</th>

</tr>

</thead>

<tbody>

@foreach($pemeriksaan as $p)

<tr>

    <td>{{ $p->tanggal_pemeriksaan }}</td>

    <td>{{ $p->nama_pemeriksaan }}</td>

    <td>{{ $p->pasien->nama_pasien ?? '-' }}</td>

    <td>{{ $p->keterangan_klinik }}</td>

    <td>{{ $p->jaminan->nama_jaminan ?? '-' }}</td>

    <td>{{ $p->dokter->nama_dokter ?? '-' }}</td>

    <td>{{ $p->petugas->nama_petugas ?? '-' }}</td>

    <td>

        @if(empty($p->hasil_pemeriksaan))

            <a href="/pemeriksaan/{{ $p->id_pemeriksaan }}/edit"
               class="badge-danger">
                Input Hasil
            </a>

        @else

            <a href="/pemeriksaan/{{ $p->id_pemeriksaan }}/edit"
               class="badge-success">
                Lihat
            </a>

            <a href="{{ route('pemeriksaan.cetak',$p->id_pemeriksaan) }}"
               target="_blank"
               class="badge-print">
                Cetak
            </a>

        @endif

    </td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection