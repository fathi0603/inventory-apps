@extends('layouts.app')

@section('title', 'Sistem Pengadaan')

@section('css')
<style>

.page-header{
display:flex;
justify-content:space-between;
align-items:end;
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

.summary{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:20px;
margin-bottom:30px;
}

.summary-card{
background:#fff;
padding:25px;
border-radius:16px;
box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.summary-card h4{
margin:0;
color:#666;
}

.summary-card h2{
margin-top:15px;
font-size:42px;
color:#1b5e20;
}

.toolbar{
display:flex;
justify-content:space-between;
align-items:center;
margin:30px 0;
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

th,td{
padding:16px;
text-align:center;
}

tbody tr{
border-bottom:1px solid #eee;
}

.btn-add,
.btn-secondary,
.btn-lihat,
.btn-konfirmasi{
padding:10px 18px;
border-radius:10px;
text-decoration:none;
font-weight:600;
}

.btn-add{
background:#1b5e20;
color:white;
}

.btn-secondary{
background:#eceff1;
color:#333;
}

.btn-lihat{
background:#1b5e20;
color:white;
}

.btn-konfirmasi{
background:#f39c12;
color:white;
}

.badge-success,
.badge-danger,
.badge-warning,
.badge-info,
.badge-primary{
padding:8px 14px;
border-radius:30px;
font-size:13px;
font-weight:600;
}

.badge-success{
background:#198754;
color:white;
}

.badge-danger{
background:#dc3545;
color:white;
}

.badge-warning{
background:#fff3cd;
color:#856404;
}

.badge-info{
background:#cff4fc;
color:#055160;
}

.badge-primary{
background:#0d6efd;
color:white;
}

</style>
@endsection

@section('content')

<div class="page-header">

    <div class="page-title">

        <h2>Pengadaan Barang</h2>

        <p>Kelola proses pengajuan dan penerimaan reagen serta BMHP.</p>

    </div>

    <div style="display:flex;gap:12px;">

    
    @if(
        session('role') == 'Petugas Laboratorium' ||
        session('role') == 'Koordinator Laboratorium'
    )

        <a href="{{ route('kartu-stok.index') }}"
           class="btn-secondary">

            <i class="fa-solid fa-clipboard-list"></i>
            Kartu Stok

        </a>

    @endif


    <a href="{{ route('barang-masuk.index') }}"
       class="btn-secondary">

        <i class="fa-solid fa-clock-rotate-left"></i>
        History Barang Masuk

    </a>


    @if(session('role') == 'Petugas Laboratorium')

        <a href="/form_order/create"
           class="btn-add">

            <i class="fa-solid fa-plus"></i>
            Buat Order

        </a>

    @endif

</div>

</div>


<div class="summary">

    <div class="summary-card">
        <h4>Order Diajukan</h4>
        <h2>{{ $diajukan }}</h2>
    </div>

    <div class="summary-card">
        <h4>Order Disetujui</h4>
        <h2>{{ $disetujui }}</h2>
    </div>

    <div class="summary-card">
        <h4>Barang Diterima</h4>
        <h2>{{ $diterima }}</h2>
    </div>

    <div class="summary-card">
        <h4>Order Ditolak</h4>
        <h2>{{ $ditolak }}</h2>
    </div>

</div>


<div class="search-box">

<input
type="text"
name="search"
placeholder="Cari tanggal, petugas atau status..."
value="{{ request('search') }}">

</div>


<div class="table-card">

<table>

    <thead>

    <tr>

        <th>Tanggal</th>
        <th>Petugas</th>
        <th>Jumlah Item</th>
        <th>Status</th>
        <th>Aksi</th>

    </tr>

    </thead>

    <tbody>

    @forelse($form_order as $o)

    <tr>

        <td>{{ $o->tanggal_order }}</td>

        <td>{{ $o->pembuat->nama_petugas ?? '-' }}</td>

        <td>{{ $o->detailOrder->count() }}</td>

        <td>

            @if($o->status == 'Diajukan')

                <span class="badge-warning">
                    Menunggu Persetujuan
                </span>

            @elseif($o->status == 'Disetujui')

                <span class="badge-info">
                    Menunggu Proses Logistik
                </span>

            @elseif($o->status == 'Ditolak')

                <span class="badge-danger">
                    Ditolak
                </span>

            @elseif($o->status == 'Diterima')

                @if($o->konfirmasi_barang)

                    <span class="badge-success">
                        Sudah Dikonfirmasi
                    </span>

                @else

                    <span class="badge-primary">
                        Barang Diterima
                    </span>

                @endif

            @endif

        </td>

        <td>

            @if(session('role') == 'Petugas Laboratorium')

                @if($o->status == 'Diterima')

                    @if($o->konfirmasi_barang)

                        <a href="/form_order/{{ $o->id_order }}/edit"
                           class="btn-lihat">

                            Lihat

                        </a>

                    @else

                        <a href="/form_order/{{ $o->id_order }}/edit"
                           class="btn-konfirmasi">

                            Konfirmasi

                        </a>

                    @endif

                @else

                    <a href="/form_order/{{ $o->id_order }}/edit"
                       class="btn-lihat">

                        Lihat

                    </a>

                @endif

            @else

                <a href="/form_order/{{ $o->id_order }}/edit"
                   class="btn-lihat">

                    Lihat

                </a>

            @endif

        </td>

    </tr>

    @empty

    <tr>

        <td colspan="5" style="text-align:center;padding:30px;">
            Belum ada data pengadaan.
        </td>

    </tr>

    @endforelse

    </tbody>

</table>

</div>

@endsection