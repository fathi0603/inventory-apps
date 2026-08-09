@extends('layouts.app')

@section('title','Tambah Petugas')

@section('css')
<style>

.judul-halaman{
    color:#1b5e20;
    font-size:32px;
    margin-bottom:30px;
}

.form-card{
    max-width:700px;
    background:#fff;
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

.btn-simpan{
    background:#1b5e20;
    color:white;
    border:none;
    padding:12px 28px;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
    font-size:15px;
}

.btn-simpan:hover{
    background:#145a1f;
}

.btn-batal{
    background:#757575;
    color:white;
    text-decoration:none;
    padding:12px 28px;
    border-radius:8px;
    font-weight:bold;
}

.btn-batal:hover{
    background:#616161;
}

</style>
@endsection

@section('content')

<h2 class="judul-halaman">
    Tambah Petugas
</h2>

<div class="form-card">

<form action="/petugas" method="POST">

    @csrf

    <label>Nama Petugas</label>

    <input
        type="text"
        name="nama_petugas"
        value="{{ old('nama_petugas') }}"
        required>

    <label>Jabatan</label>

    <select name="jabatan" required>
        <option value="">-- Pilih Jabatan --</option>
        <option value="Koordinator Laboratorium">Koordinator Laboratorium</option>
        <option value="Petugas Laboratorium">Petugas Laboratorium</option>
    </select>

    <div class="aksi">

        <button type="submit" class="btn-simpan">
            Simpan
        </button>

       <a href="/petugas" class="btn-batal">
        Detail Petugas
        </a>

    </div>

</form>

</div>

@endsection