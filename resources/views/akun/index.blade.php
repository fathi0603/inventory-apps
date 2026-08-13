@extends('layouts.app')

@section('title','Akun Saya')

@section('css')

<style>

.page-title{
    font-size:34px;
    color:#1b5e20;
    font-weight:700;
    margin-bottom:8px;
}

.page-subtitle{
    color:#777;
    margin-bottom:30px;
}

.form-card{
    max-width:650px;
    background:#fff;
    padding:35px;
    border-radius:18px;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.form-group{
    margin-bottom:22px;
}

label{
    display:block;
    font-weight:600;
    margin-bottom:8px;
    color:#444;
}

input{
    width:100%;
    height:50px;
    border:1px solid #dcdcdc;
    border-radius:10px;
    padding:0 15px;
    font-size:15px;
    transition:.3s;
}

input:focus{
    outline:none;
    border-color:#1b5e20;
    box-shadow:0 0 0 3px rgba(27,94,32,.15);
}

.btn-simpan{
    background:#1b5e20;
    color:white;
    border:none;
    padding:14px 30px;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
}

.btn-simpan:hover{
    background:#14501b;
}

.btn-kembali{
    text-decoration:none;
    color:#1b5e20;
    font-weight:600;
    margin-bottom:25px;
    display:inline-block;
}

</style>

@endsection

@section('content')
<a href="/dashboard" class="btn-kembali">
    Kembali
</a>

<h2 class="page-title">
    Ganti Password
</h2>

<div class="form-card">

<form action="/akun/password" method="POST">

    @csrf

    <div class="form-group">
        <label>Username</label>
        <input type="text"
               value="{{ session('username') }}"
               readonly>
    </div>

    <div class="form-group">
        <label>Password Lama</label>
        <input type="password" name="password_lama">
    </div>

    <div class="form-group">
        <label>Password Baru</label>
        <input type="password" name="password_baru">
    </div>

    <div class="form-group">
        <label>Konfirmasi Password</label>
        <input type="password" name="konfirmasi">
    </div>

    <button type="submit" class="btn-simpan">
        Simpan Password
    </button>

</form>

</div>

@endsection