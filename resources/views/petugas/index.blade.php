@extends('layouts.app')

@section('title','Data Petugas')

@section('css')
<style>

.judul-halaman{
    color:#1b5e20;
    font-size:32px;
    margin-bottom:25px;
}

.atas{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.btnTambah{
    background:#2e7d32;
    color:white;
    padding:12px 22px;
    text-decoration:none;
    border-radius:10px;
    font-weight:bold;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    border:3px solid #1b5e20;
}

th{
    background:#1b5e20;
    color:white;
    padding:15px;
    border:2px solid #0d3b12;
}

td{
    border:2px solid #1b5e20;
    padding:14px;
    text-align:center;
}

.btnEdit{
    color:#1b5e20;
    font-weight:bold;
    text-decoration:none;
    margin-right:10px;
}

.btnHapus{
    background:#c62828;
    color:white;
    border:none;
    padding:8px 12px;
    border-radius:6px;
    cursor:pointer;
}

</style>
@endsection

@section('content')

<div class="atas">

    <h2 class="judul-halaman">
        Data Petugas
    </h2>

</div>

<table>

<tr>

    <th>ID</th>
    <th>Nama Petugas</th>
    <th>Jabatan</th>
    <th>Aksi</th>

</tr>

@foreach($petugas as $p)

<tr>

    <td>{{ $p->id_petugas }}</td>

    <td>{{ $p->nama_petugas }}</td>

    <td>{{ $p->jabatan }}</td>

    <td>

        <a href="/petugas/{{ $p->id_petugas }}/edit"
           class="btnEdit">
            Edit
        </a>

        <form
            action="/petugas/{{ $p->id_petugas }}"
            method="POST"
            style="display:inline;">

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="btnHapus"
                onclick="return confirm('Yakin ingin menghapus petugas?')">

                Hapus

            </button>

        </form>

    </td>

</tr>

@endforeach

</table>

@endsection