@extends('layouts.app')

@section('title','Inventory & Monitoring Stok')

@section('css')
<style>

.page-header{

display:flex;
justify-content:space-between;
align-items:flex-end;
margin-bottom:25px;

}

.page-title{

font-size:38px;
font-weight:700;
color:#1b5e20;
margin:0;

}

.page-subtitle{

margin-top:8px;
color:#666;

}

.btn-add{

background:#1b5e20;
color:white;
padding:14px 22px;
border-radius:10px;
text-decoration:none;
font-weight:600;

}

.summary-wrapper{

display:flex;
gap:20px;
margin:25px 0;

}

.summary-card{

flex:1;
background:white;
border-radius:15px;
padding:22px;
box-shadow:0 5px 15px rgba(0,0,0,.08);

}

.summary-card h5{

margin:0;
color:#666;
font-size:16px;

}

.summary-card h2{

margin-top:10px;
font-size:34px;
color:#1b5e20;

}

.search-box{

width:100%;
height:52px;
border:2px solid #1b5e20;
border-radius:10px;
padding:0 18px;
margin-bottom:25px;

}

.table-card{

background:white;
border-radius:15px;
overflow:hidden;
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

padding:18px;
text-align:center;

}

td{

padding:18px;
border-bottom:1px solid #eee;
text-align:center;

}

.badge-success{

background:#2e7d32;
color:white;
padding:8px 14px;
border-radius:20px;

}

.badge-warning{

background:#ff9800;
color:white;
padding:8px 14px;
border-radius:20px;

}

.badge-danger{

background:#d32f2f;
color:white;
padding:8px 14px;
border-radius:20px;

}

.btn-detail{

background:#1b5e20;
color:white;
padding:8px 16px;
border-radius:8px;
text-decoration:none;

}

</style>
@endsection

@section('content')

<div class="page-header">

    <div>
        <h2 class="page-title">
            Inventory & Monitoring Stok
        </h2>

        <p class="page-subtitle">
            Kelola data reagen dan BMHP laboratorium.
        </p>
    </div>

    <a href="/barang/create" class="btn-add">
        <i class="fa-solid fa-plus"></i>
        Tambah Barang
    </a>

</div>


<div class="summary-wrapper">

    <div class="summary-card">

        <h5>Total Barang</h5>

        <h2>{{ $totalBarang }}</h2>

    </div>

    <div class="summary-card">

        <h5>Stok Minimum</h5>

        <h2>{{ $stokMinimum }}</h2>

    </div>

    <div class="summary-card">

        <h5>Expired < 3 Bulan</h5>

        <h2>{{ $expired }}</h2>

    </div>

</div>


<form method="GET">

    <input
        type="text"
        name="search"
        class="search-box"
        placeholder="Cari kode, nama, jenis atau lokasi barang..."
        value="{{ request('search') }}">

</form>


<div class="table-card">

<table>

<thead>

<tr>

<th>Kode</th>
<th>Nama Barang</th>
<th>Jenis</th>
<th>Total Stok</th>
<th>Stok Minimum</th>
<th>Lokasi</th>
<th>Status</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

@forelse($barang as $b)

<tr>

<td>{{ $b->kode_barang }}</td>

<td>{{ $b->nama_barang }}</td>

<td>{{ $b->jenis_barang }}</td>

<td>{{ $b->total_stok }}</td>

<td>{{ $b->stok_minimum }}</td>

<td>{{ $b->lokasi }}</td>

<td>

@if($b->status=='Stok Minimum')

<span class="badge-danger">
Stok Minimum
</span>

@elseif($b->status=='Expired')

<span class="badge-danger">
Expired
</span>

@elseif($b->status=='Perlu Rotasi')

<span class="badge-warning">
Perlu Rotasi
</span>

@else

<span class="badge-success">
Aman
</span>

@endif

</td>

<td>

<a
href="/barang/{{ $b->id_barang }}"
class="btn-detail">

Lihat

</a>

</td>

</tr>

@empty

<tr>

<td colspan="8" style="text-align:center;padding:30px">

Belum ada data barang.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@endsection