@extends('layouts.app')

@section('title','Informasi Penggunaan Barang')

@section('css')

<style>

.page-title{
    margin-bottom:25px;
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


/* SUMMARY */

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


/* TOOLBAR */

.toolbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
    margin-bottom:25px;
}

.search-box{
    flex:1;
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

.print-box{
    display:flex;
    align-items:center;
    gap:10px;
}

.print-box input{
    height:46px;
    border:1px solid #ddd;
    border-radius:10px;
    padding:0 12px;
}

.btn-cetak{
    background:#1b5e20;
    color:white;
    padding:12px 18px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
}

.btn-cetak:hover{
    background:#14501b;
}


/* TABLE */

.table-card{
    background:white;
    border-radius:16px;
    padding:25px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
    overflow-x:auto;
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

<div class="page-title">

    <h2>Informasi Penggunaan Barang</h2>

    <p>
        Informasi penggunaan reagen dan BMHP laboratorium.
    </p>

</div>


{{-- SUMMARY --}}

<div class="summary">

    <div class="summary-card">

        <h4>Total Barang</h4>

        <h2>
            {{ $barang->count() }}
        </h2>

    </div>


    <div class="summary-card">

        <h4>Reagen</h4>

        <h2>
            {{ $barang->where('jenis_barang','Reagen')->count() }}
        </h2>

    </div>


    <div class="summary-card">

        <h4>BMHP</h4>

        <h2>
            {{ $barang->where('jenis_barang','BMHP')->count() }}
        </h2>

    </div>

</div>


{{-- SEARCH + CETAK --}}

<div class="toolbar">

    <div class="search-box">

        <form method="GET">

            <input
                type="text"
                name="search"
                placeholder="Cari nama barang atau jenis barang..."
                value="{{ request('search') }}">

        </form>

    </div>


    <div class="print-box">

        <form
            action="{{ route('kartu-stok.cetak') }}"
            method="GET"
            target="_blank"
            style="display:flex;gap:10px;align-items:center;">

            <input
                type="month"
                name="bulan"
                value="{{ now()->format('Y-m') }}"
                required>

            <button type="submit" class="btn-cetak">

                <i class="fa-solid fa-print"></i>

                Cetak Laporan

            </button>

        </form>

    </div>

</div>


{{-- TABLE --}}

<div class="table-card">

    <table>

        <thead>

            <tr>

                <th>No</th>

                <th>Nama Barang</th>

                <th>Jenis Barang</th>

                <th>Tanggal Penggunaan</th>

                <th>Barang Keluar</th>

            </tr>

        </thead>


        <tbody>

        @php
            $nomor = 1;
        @endphp


        @forelse($barang as $item)

            @forelse($item->penggunaanBarang as $penggunaan)

                <tr>

                    <td>
                        {{ $nomor++ }}
                    </td>

                    <td>
                        {{ $item->nama_barang }}
                    </td>

                    <td>
                        {{ $item->jenis_barang }}
                    </td>

                    <td>
                        {{ $penggunaan->pemeriksaan->tanggal_pemeriksaan ?? '-' }}
                    </td>

                    <td>
                        {{ $penggunaan->jumlah_penggunaan }} pcs
                    </td>

                </tr>

            @empty

                <tr>

                    <td>
                        {{ $nomor++ }}
                    </td>

                    <td>
                        {{ $item->nama_barang }}
                    </td>

                    <td>
                        {{ $item->jenis_barang }}
                    </td>

                    <td>
                        -
                    </td>

                    <td>
                        0 pcs
                    </td>

                </tr>

            @endforelse

        @empty

            <tr>

                <td colspan="5" style="text-align:center;padding:30px;">

                    Belum ada data barang.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection