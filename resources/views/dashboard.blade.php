@extends('layouts.app')

@section('title', 'Dashboard')

@section('css')
<style>

.dashboard-cards{
    display:flex;
    gap:25px;
    margin-bottom:35px;
}

.stat-card{
    flex:1;
    background:white;
    border-radius:18px;
    padding:25px;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.stat-card .icon{
    width:60px;
    height:60px;
    border-radius:15px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:24px;
    color:white;
}

.green{
    background:#2e7d32;
}

.orange{
    background:#ff9800;
}

.red{
    background:#e53935;
}

.stat-card h4{
    margin:0;
    color:#666;
    font-size:15px;
}

.stat-card h2{
    margin-top:8px;
    font-size:34px;
    color:#1b5e20;
}

.table-card{

    background:white;

    border-radius:18px;

    padding:25px;

    margin-bottom:30px;

    box-shadow:0 8px 20px rgba(0,0,0,.08);

}

.table-card h3{

    margin-bottom:20px;

    color:#1b5e20;

}

table{

    width:100%;

    border-collapse:collapse;

}

th{

    background:#f4f7f9;

    color:#555;

    text-align:left;

    padding:15px;

    font-weight:600;

}

td{

    padding:15px;

    border-bottom:1px solid #eee;

}

.status-warning{

    background:#fff3cd;

    color:#856404;

    padding:5px 12px;

    border-radius:20px;

    font-size:13px;

}

.status-danger{

    background:#fdecea;

    color:#d32f2f;

    padding:5px 12px;

    border-radius:20px;

    font-size:13px;

}

</style>
@endsection

@section('content')

<div class="dashboard-cards">

    <div class="stat-card">

        <div>

            <h4>Pemeriksaan Hari Ini</h4>

            <h2>{{ $pemeriksaanHariIni }}</h2>

        </div>

        <div class="icon green">

            <i class="fa-solid fa-vials"></i>

        </div>

    </div>

    <div class="stat-card">

        <div>

            <h4>Stok Menipis</h4>

            <h2>{{ $stokMinimum }}</h2>

        </div>

        <div class="icon orange">

            <i class="fa-solid fa-box-open"></i>

        </div>

    </div>

    <div class="stat-card">

        <div>

            <h4>Expired < 3 Bulan</h4>

            <h2>{{ $kadaluarsa }}</h2>

        </div>

        <div class="icon red">

            <i class="fa-solid fa-triangle-exclamation"></i>

        </div>

    </div>

</div>

<div class="table-card">

    <h3>Barang Stok Minimum</h3>

    <table>

        <thead>

        <tr>

            <th>Nama Barang</th>

            <th>Stok</th>

            <th>Status</th>

        </tr>

        </thead>

        <tbody>

        @forelse($barang as $b)

            @if($b->stok <= 100)

            <tr>

                <td>{{ $b->nama_barang }}</td>

                <td>{{ $b->stok }}</td>

                <td>

                    <span class="status-warning">

                        Stok Minimum

                    </span>

                </td>

            </tr>

            @endif

        @empty

            <tr>

                <td colspan="3">

                    Tidak ada data.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

<div class="table-card">

    <h3>Barang Kedaluwarsa</h3>

    <table>

        <thead>

        <tr>

            <th>Nama Barang</th>

            <th>Tanggal Expired</th>

            <th>Status</th>

        </tr>

        </thead>

        <tbody>

        @forelse($barangExpired as $b)

            <tr>

                <td>{{ $b->barang->nama_barang }}</td>

                <td>{{ $b->tanggal_expired }}</td>

                <td>

                    <span class="status-danger">

                        Segera Expired

                    </span>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="3">

                    Tidak ada data barang yang akan kedaluwarsa.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>
@endsection