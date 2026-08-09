@extends('layouts.app')

@section('title','History Barang Masuk')

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

.btn-back{
    background:#1b5e20;
    color:white;
    text-decoration:none;
    padding:12px 20px;
    border-radius:10px;
    font-weight:600;
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
    box-sizing:border-box;
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
    text-align:center;
}

td{
    padding:15px;
    border-bottom:1px solid #eee;
    text-align:center;
}

tbody tr:hover{
    background:#f5fff5;
}

</style>

@endsection


@section('content')

<div class="page-header">

    <div class="page-title">

        <h2>History Barang Masuk</h2>

        <p>
            Riwayat penerimaan reagen dan BMHP laboratorium.
        </p>

    </div>

    <a href="/form_order" class="btn-back">

        <i class="fa-solid fa-arrow-left"></i>

        Kembali

    </a>

</div>

<div class="summary">

    <div class="summary-card">

        <h4>Total History</h4>

        <h2>{{ $barang_masuk->count() }}</h2>

    </div>

</div>



<div class="search-box">

    <form method="GET">

        <input
            type="text"
            name="search"
            placeholder="Cari nama barang atau tanggal masuk..."
            value="{{ request('search') }}">

    </form>

</div>




<div class="table-card">

<table>

    <thead>

        <tr>

            <th>No</th>

            <th>Tanggal Masuk</th>

            <th>Nama Barang</th>

            <th>Jumlah Dipesan</th>

            <th>Jumlah Diterima</th>

            <th>Tanggal Expired</th>

            <th>Sisa Batch</th>

        </tr>

    </thead>


    <tbody>

        @forelse($barang_masuk as $item)

        <tr>

            <td>
                {{ $loop->iteration }}
            </td>

            <td>
                {{ $item->tanggal_masuk }}
            </td>

            <td>
                {{ $item->barang->nama_barang ?? '-' }}
            </td>

            <td>
                {{ $item->detailOrder->jumlah_order ?? '-' }}
            </td>

            <td>
                {{ $item->jumlah_masuk }}
            </td>

            <td>
                {{ $item->tanggal_expired }}
            </td>

            <td>
                {{ $item->sisa_stok }}
            </td>

        </tr>

        @empty

        <tr>

            <td colspan="7" style="text-align:center;padding:30px;">

                Belum ada history barang masuk.

            </td>

        </tr>

        @endforelse

    </tbody>

</table>

</div>

@endsection