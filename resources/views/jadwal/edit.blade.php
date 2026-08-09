@extends('layouts.app')

@section('title','Edit Jadwal Petugas')

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

.info{
    margin-bottom:25px;
    font-size:17px;
    line-height:1.8;
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
    padding:12px;
}

select{
    width:100%;
    height:45px;
    border:2px solid #1b5e20;
    border-radius:8px;
    padding:8px;
    box-sizing:border-box;
}

.aksi{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-top:30px;
}

.btn-kembali{
    background:#757575;
    color:white;
    text-decoration:none;
    padding:12px 25px;
    border-radius:8px;
    font-weight:bold;
}

.btn-simpan{
    background:#1b5e20;
    color:white;
    border:none;
    padding:12px 25px;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
}

.btn-simpan:hover{
    background:#145a1f;
}

</style>

@endsection

@section('content')

<h2 class="judul-halaman">
    Edit Jadwal Petugas
</h2>

<div class="form-card">

<div class="info">

<strong>Petugas :</strong>
{{ $petugas->nama_petugas }}

<br>

<strong>Periode :</strong>
{{ $periode }}

</div>

<form action="{{ url('/jadwal/'.$petugas->id_petugas.'/'.$periode) }}" method="POST">

@csrf
@method('PUT')

<table class="table-box">

<tr>

<th>Hari</th>

<th>Shift</th>

</tr>

@foreach($hariList as $hari)

<tr>

<td>{{ $hari }}</td>

<td>

<select name="shift[{{ $hari }}]">

@foreach($shiftList as $shift)

<option
value="{{ $shift }}"
{{ optional($jadwal->get($hari))->shift == $shift ? 'selected' : '' }}>

{{ $shift }}

</option>

@endforeach

</select>

</td>

</tr>

@endforeach

</table>

<div class="aksi">

<a
    href="{{ url('/jadwal') }}"
    class="btn-kembali">
    Kembali
</a>

<button
    type="submit"
    class="btn-simpan">
    Simpan Perubahan
</button>

</div>

</form>

</div>

@endsection