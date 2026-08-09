@extends('layouts.app')

@section('title','Edit Barang')

@section('css')
<style>

.judul-halaman{
    color:#1b5e20;
    font-size:32px;
    margin-bottom:30px;
}

.form-card{
    max-width:650px;
    background:white;
    border:2px solid #1b5e20;
    border-radius:15px;
    padding:35px;
    box-shadow:0 6px 18px rgba(0,0,0,.12);
}

label{
    display:block;
    margin-top:18px;
    margin-bottom:8px;
    font-weight:bold;
    color:#1b5e20;
}

input,
select{
    width:100%;
    height:45px;
    border:2px solid #1b5e20;
    border-radius:8px;
    padding:0 12px;
    font-size:15px;
    box-sizing:border-box;
}

.aksi{
    display:flex;
    gap:12px;
    margin-top:30px;
}

.btn-update{
    background:#1b5e20;
    color:white;
    border:none;
    padding:12px 25px;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
    font-size:15px;
}

.btn-batal{
    background:#757575;
    color:white;
    padding:12px 25px;
    border-radius:8px;
    text-decoration:none;
    font-weight:bold;
}

</style>
@endsection

@section('content')

<h2 class="judul-halaman">
    Edit Barang
</h2>

<div class="form-card">

<form action="/barang/{{ $barang->id_barang }}" method="POST">

    @csrf
    @method('PUT')

    <label>Kode Barang</label>

    <input
        type="text"
        name="kode_barang"
        value="{{ $barang->kode_barang }}">

    <label>Nama Barang</label>

    <input
        type="text"
        name="nama_barang"
        value="{{ $barang->nama_barang }}">

    <label>Jenis Barang</label>

    <select name="jenis_barang">

        <option value="Reagen"
            {{ $barang->jenis_barang == 'Reagen' ? 'selected' : '' }}>
            Reagen
        </option>

        <option value="BMHP"
            {{ $barang->jenis_barang == 'BMHP' ? 'selected' : '' }}>
            BMHP
        </option>

    </select>

    <label>Stok Minimum</label>

    <input
        type="number"
        name="stok_minimum"
        value="{{ $barang->stok_minimum }}">

    <label>Lokasi</label>

    <input
    type="text"
    name="lokasi"
    value="{{ $barang->lokasi }}">

    <div class="aksi">

        <button
            type="submit"
            class="btn-update">
            Update Barang
        </button>

        <a
            href="/barang"
            class="btn-batal">
            Batal
        </a>

    </div>

</form>

</div>

@endsection