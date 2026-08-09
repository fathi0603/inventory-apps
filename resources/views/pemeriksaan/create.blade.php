@extends('layouts.app')

@section('title','Tambah Pencatatan Aktivitas')

@section('css')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

<style>

.judul-halaman{
    color:#1b5e20;
    font-size:32px;
    margin-bottom:30px;
}

.form-card{
    background:white;
    border:2px solid #1b5e20;
    border-radius:15px;
    padding:35px;
    box-shadow:0 6px 18px rgba(0,0,0,.12);
}

.form-wrapper{
    display:flex;
    gap:40px;
    align-items:flex-start;
}

.kiri{
    width:45%;
}

.kanan{
    width:55%;
}

label{
    display:block;
    margin-top:15px;
    margin-bottom:8px;
    font-weight:bold;
    color:#1b5e20;
}

input,
select,
textarea{
    width:100%;
    border:2px solid #1b5e20;
    border-radius:8px;
    padding:10px 12px;
    box-sizing:border-box;
}

textarea{
    height:90px;
}

.table-barang{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

.table-barang th{
    background:#1b5e20;
    color:white;
    padding:12px;
}

.table-barang td{
    border:2px solid #1b5e20;
    padding:10px;
}

.btn-area{
    margin-top:25px;
    display:flex;
    gap:10px;
}

.btn-simpan,
.btn-tambah{
    margin-left:auto;
    background:#1b5e20;
    color:white;
    text-decoration:none;
    padding:12px 22px;
    border-radius:8px;
    font-weight:bold;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:180px;
    height:45px;
    box-sizing:border-box;
    transition:.2s;
}

.btn-tambah:hover{
    background:#145a1f;
}

</style>

@endsection

@section('content')

<h2 class="judul-halaman">
    Tambah Pencatatan Aktivitas
</h2>

<div class="form-card">

<form action="/pemeriksaan" method="POST">

@csrf

<div class="form-wrapper">

<div class="kiri">

<label>Nama Pasien</label>

<input
    type="text"
    name="nama_pasien"
    id="nama_pasien"
    list="list-pasien"
    autocomplete="off">

<datalist id="list-pasien">

@foreach($pasien as $p)

<option value="{{ $p->nama_pasien }}">

@endforeach

</datalist>

<label>Alamat</label>

<input
    type="text"
    name="alamat"
    id="alamat">

<label>Dokter</label>

<input
    type="text"
    name="nama_dokter"
    list="list-dokter"
    autocomplete="off">

<datalist id="list-dokter">

@foreach($dokter as $d)

<option value="{{ $d->nama_dokter }}">

@endforeach

</datalist>

<label>Petugas Lab</label>

<select name="id_petugas">

@foreach($petugas as $pt)

<option value="{{ $pt->id_petugas }}">
{{ $pt->nama_petugas }}
</option>

@endforeach

</select>

<label>Jaminan</label>

<input
    type="text"
    name="nama_jaminan"
    list="list-jaminan"
    autocomplete="off">

<datalist id="list-jaminan">

@foreach($jaminan as $j)

<option value="{{ $j->nama_jaminan }}">

@endforeach

</datalist>

<label>Tanggal Pemeriksaan</label>

<input
type="date"
name="tanggal_pemeriksaan">

<label>Asal / Keterangan Klinik</label>

<input
type="text"
name="keterangan_klinik">

<label>Hasil Pemeriksaan</label>

<textarea name="hasil_pemeriksaan"></textarea>

<label>Nama Pemeriksaan</label>

<input
type="text"
name="nama_pemeriksaan">

</div>

<div class="kanan">

<h3>Penggunaan Reagen & BMHP</h3>

<table class="table-barang" id="tabelBarang">

<tr>

<th>Barang</th>

<th>Jumlah</th>

</tr>

<tr>

<td>

<select
name="id_barang[]"
class="barang"
style="width:100%">

<option value="">
Pilih Barang
</option>

@foreach($barang as $b)

<option value="{{ $b->id_barang }}">
{{ $b->nama_barang }} (Stok: {{ $b->stok }})
</option>

@endforeach

</select>

</td>

<td>

<input
type="number"
name="jumlah_penggunaan[]"
min="1"
required>

</td>

</tr>

</table>

<div class="btn-area">

<button
    type="button"
    class="btn-tambah"
    onclick="tambahBarang()">
    + Tambah Barang
</button>

<button
    type="submit"
    class="btn-simpan">
    Simpan Pemeriksaan
</button>

</a>
</div>

</div>

</div>

</form>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$(document).ready(function () {

    $('.barang').select2({
        placeholder:'Pilih Barang'
    });

});

function tambahBarang(){

    let tabel = document.getElementById('tabelBarang');

    let row = tabel.insertRow(-1);

    row.innerHTML = `
        <td>

            <select
                name="id_barang[]"
                class="barang"
                style="width:100%">

                <option value="">
                    Pilih Barang
                </option>

                @foreach($barang as $b)

                <option value="{{ $b->id_barang }}">
                    {{ $b->nama_barang }} (Stok: {{ $b->stok }})
                </option>

                @endforeach

            </select>

        </td>

        <td>

            <input
                type="number"
                name="jumlah_penggunaan[]"
                min="1"
                required>

        </td>
    `;

    row.querySelector('.barang').style.width = '100%';

    $(row).find('.barang').select2({
        placeholder:'Pilih Barang'
    });

}

</script>

@endsection