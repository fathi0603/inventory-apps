@extends('layouts.app')

@section('title','Tambah Jadwal Petugas')

@section('css')

<style>

.judul-halaman{
    color:#1b5e20;
    font-size:32px;
    margin-bottom:30px;
}

.form-card{
    background:#fff;
    border:2px solid #1b5e20;
    border-radius:15px;
    padding:35px;
    box-shadow:0 6px 18px rgba(0,0,0,.12);
}

.container-form{
    display:flex;
    gap:40px;
}

.left{
    width:65%;
}

.right{
    width:35%;
}

.form-group{
    margin-bottom:20px;
}

label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
    color:#1b5e20;
}

.form-control{
    width:100%;
    height:45px;
    border:2px solid #1b5e20;
    border-radius:8px;
    padding:10px;
    box-sizing:border-box;
}

.btn{
    background:#1b5e20;
    color:white;
    border:none;
    padding:12px 25px;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
}

.btn:hover{
    background:#145a1f;
}

.table-box{
    width:100%;
    border-collapse:collapse;
}

.table-box th{
    background:#1b5e20;
    color:white;
    padding:12px;
}

.table-box td{
    border:2px solid #1b5e20;
    padding:10px;
}

.btn-petugas{
    background:#1b5e20;
    color:white;
    padding:8px 15px;
    border-radius:8px;
    text-decoration:none;
    font-size:14px;
    font-weight:bold;
}

</style>

@endsection

@section('content')

<h2 class="judul-halaman">
    Tambah Jadwal Petugas
</h2>

@if(session('error'))
<div style="
    background:#FEE2E2;
    color:#B91C1C;
    border:1px solid #FCA5A5;
    padding:12px 16px;
    border-radius:10px;
    margin-bottom:20px;
    font-weight:600;
">
    {{ session('error') }}
</div>
@endif

<div class="form-card">

<form action="/jadwal" method="POST">

@csrf

<div class="container-form">

<div class="left">

<div class="form-group">

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">

<label style="margin:0;">Petugas</label>

<a href="{{ route('petugas.create') }}"
class="btn-petugas">
+ Tambah Petugas
</a>

</div>

<select name="id_petugas" class="form-control">

@foreach($petugas as $p)

<option value="{{ $p->id_petugas }}">
{{ $p->nama_petugas }}
</option>

@endforeach

</select>

</div>

<div class="form-group">

<label>Periode</label>

<input
type="week"
name="periode"
class="form-control"
required>

</div>

</div>

<div class="right">

<h3>Jadwal</h3>

<table class="table-box">

<tr>

<th>Hari</th>

<th>Shift</th>

</tr>

<tr>

<td>

<select
name="hari"
class="form-control">

<option>Senin</option>
<option>Selasa</option>
<option>Rabu</option>
<option>Kamis</option>
<option>Jumat</option>
<option>Sabtu</option>
<option>Minggu</option>

</select>

</td>

<td>

<select
name="shift"
class="form-control">

<option>OFF</option>

</select>

</td>

</tr>

</table>

<br>

<button
    type="submit"
    class="btn">
    Simpan Jadwal
</button>

</div>

</div>

</form>

</div>

@endsection