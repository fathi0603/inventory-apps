@extends('layouts.app')

@section('title','Laporan Bulanan')

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



.filter-box{
    display:flex;
    align-items:center;
    gap:15px;
    margin-bottom:30px;
    flex-wrap:wrap;
}

.select-laporan,
.filter-box input[type="date"]{
    height:48px;
    border:1px solid #ddd;
    border-radius:10px;
    padding:0 15px;
    font-size:15px;
    background:white;
    box-sizing:border-box;
}

.select-laporan{
    width:300px;
}

.filter-box input[type="date"]{
    width:190px;
}



.btn-tampilkan,
.btn-cetak{
    height:48px;
    padding:0 20px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
    display:flex;
    align-items:center;
    justify-content:center;
    border:none;
    cursor:pointer;
}

.btn-tampilkan{
    background:#1b5e20;
    color:white;
}

.btn-tampilkan:hover{
    background:#14501b;
}

.btn-cetak{
    background:#e8f5e9;
    color:#1b5e20;
}

.btn-cetak:hover{
    background:#1b5e20;
    color:white;
}



.section-title{
    font-size:22px;
    color:#1b5e20;
    margin:30px 0 20px;
}




.table-card{
    background:white;
    border-radius:16px;
    padding:25px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
    overflow-x:auto;
}

.table-card table{
    width:100%;
    border-collapse:collapse;
}

.table-card thead{
    background:#1b5e20;
    color:white;
}

.table-card th{
    padding:15px;
    text-align:center;
}

.table-card td{
    padding:15px;
    border-bottom:1px solid #eee;
    text-align:center;
}

.table-card tbody tr:hover{
    background:#f5fff5;
}




@media(max-width:900px){

    .filter-box{
        align-items:stretch;
    }

    .select-laporan,
    .filter-box input[type="date"],
    .btn-tampilkan,
    .btn-cetak{
        width:100%;
    }

}

</style>

@endsection


@section('content')




<div class="page-header">

    <div class="page-title">

        <h2>Laporan Bulanan</h2>

        <p>
            Menampilkan laporan penggunaan barang,
            pemeriksaan dan penjadwalan petugas laboratorium.
        </p>

    </div>

</div>




<form method="GET"
      action="/laporan"
      class="filter-box">

    <select name="jenis"
            class="select-laporan">

        <option value="penggunaan"
            {{ request('jenis') == 'penggunaan' ? 'selected' : '' }}>

            Reagen & BMHP yang Sering Digunakan

        </option>

        <option value="jaminan"
            {{ request('jenis') == 'jaminan' ? 'selected' : '' }}>

            Detail Pemeriksaan Per Jaminan

        </option>

        <option value="jadwal"
            {{ request('jenis') == 'jadwal' ? 'selected' : '' }}>

            Laporan Penjadwalan Petugas

        </option>

    </select>


    <input
        type="date"
        name="tanggal_awal"
        value="{{ request('tanggal_awal') }}">


    <input
        type="date"
        name="tanggal_akhir"
        value="{{ request('tanggal_akhir') }}">


    <button type="submit"
            class="btn-tampilkan">

        Tampilkan

    </button>


    <a
        href="/laporan/cetak?jenis={{ $jenis }}&tanggal_awal={{ request('tanggal_awal') }}&tanggal_akhir={{ request('tanggal_akhir') }}"
        class="btn-cetak">

        <i class="fa-solid fa-print"></i>
        &nbsp; Cetak

    </a>

</form>




@if($jenis == 'jaminan')

<h3 class="section-title">
    Detail Pemeriksaan Per Jaminan
</h3>


<div class="table-card">

<table>

    <thead>

        <tr>

            <th>Nama Pemeriksaan</th>
            <th>BPJS</th>
            <th>BPJS TK</th>
            <th>Asuransi</th>
            <th>Umum</th>
            <th>MCU</th>
            <th>Total</th>

        </tr>

    </thead>


    <tbody>

        @forelse($laporanJaminan as $l)

        <tr>

            <td>
                {{ $l->nama_pemeriksaan }}
            </td>

            <td>
                {{ $l->bpjs }}
            </td>

            <td>
                {{ $l->bpjstk }}
            </td>

            <td>
                {{ $l->asuransi }}
            </td>

            <td>
                {{ $l->umum }}
            </td>

            <td>
                {{ $l->mcu }}
            </td>

            <td>
                {{ $l->bpjs + $l->bpjstk + $l->asuransi + $l->umum + $l->mcu }}
            </td>

        </tr>

        @empty

        <tr>

            <td colspan="7">
                Belum ada data pemeriksaan.
            </td>

        </tr>

        @endforelse

    </tbody>

</table>

</div>

@endif



@if($jenis == 'penggunaan')

<h3 class="section-title">
    Reagen & BMHP yang Sering Digunakan
</h3>


<div class="table-card">

<table>

    <thead>

        <tr>

            <th>Rank</th>
            <th>Nama Barang</th>
            <th>Kode</th>
            <th>Total Penggunaan</th>
            <th>Frekuensi Pakai</th>

        </tr>

    </thead>


    <tbody>

        @forelse($penggunaan as $index => $p)

        <tr>

            <td>
                {{ $index + 1 }}
            </td>

            <td>
                {{ $p->barang->nama_barang ?? '-' }}
            </td>

            <td>
                {{ $p->id_barang }}
            </td>

            <td>
                {{ $p->total_penggunaan }}
            </td>

            <td>
                {{ $p->frekuensi }}x
            </td>

        </tr>

        @empty

        <tr>

            <td colspan="5">
                Belum ada data penggunaan barang.
            </td>

        </tr>

        @endforelse

    </tbody>

</table>

</div>

@endif




@if($jenis == 'jadwal')

<h3 class="section-title">
    Laporan Penjadwalan Petugas
</h3>


<div class="table-card">

<table>

    <thead>

        <tr>

            <th>No</th>
            <th>Petugas</th>
            <th>Total Shift</th>
            <th>Total Jam</th>
            <th>Capaian</th>

        </tr>

    </thead>


    <tbody>

        @forelse($jadwal as $index => $j)

        <tr>

            <td>
                {{ $index + 1 }}
            </td>

            <td>
                {{ $j['nama'] }}
            </td>

            <td>
                {{ $j['total_shift'] }}
            </td>

            <td>
                {{ $j['total_jam'] }} Jam
            </td>

            <td>
                {{ $j['capaian'] }}
            </td>

        </tr>

        @empty

        <tr>

            <td colspan="5">
                Belum ada data penjadwalan.
            </td>

        </tr>

        @endforelse

    </tbody>

</table>

</div>

@endif


@endsection