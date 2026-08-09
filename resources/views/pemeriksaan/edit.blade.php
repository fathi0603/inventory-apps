@extends('layouts.app')

@section('title','Edit Pencatatan Aktivitas')

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
}

.btn-hapus{
    background:#d32f2f;
    color:white;
    border:none;
    padding:12px 25px;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
}

</style>

@endsection

@section('content')

<h2 class="judul-halaman">
    Edit Pencatatan Aktivitas
</h2>

<div class="form-card">

<form action="/pemeriksaan/{{ $pemeriksaan->id_pemeriksaan }}" method="POST">

@csrf
@method('PUT')

<div class="form-wrapper">

<div class="kiri">

<label>No Lab</label>

<input
type="text"
name="no_lab"
value="{{ $pemeriksaan->no_lab }}">

<label>Pasien</label>

<select name="id_pasien">

@foreach($pasien as $p)

<option
value="{{ $p->id_pasien }}"
{{ $pemeriksaan->id_pasien == $p->id_pasien ? 'selected' : '' }}>
{{ $p->nama_pasien }}
</option>

@endforeach

</select>

<label>Alamat Pasien</label>

<input
type="text"
value="{{ $pemeriksaan->pasien->alamat ?? '-' }}"
readonly>

<label>Dokter</label>

<select name="id_dokter">

@foreach($dokter as $d)

<option
value="{{ $d->id_dokter }}"
{{ $pemeriksaan->id_dokter == $d->id_dokter ? 'selected' : '' }}>
{{ $d->nama_dokter }}
</option>

@endforeach

</select>

<label>Jaminan</label>

<select name="id_jaminan">

@foreach($jaminan as $j)

<option
value="{{ $j->id_jaminan }}"
{{ $pemeriksaan->id_jaminan == $j->id_jaminan ? 'selected' : '' }}>
{{ $j->nama_jaminan }}
</option>

@endforeach

</select>

<label>Tanggal Pemeriksaan</label>

<input
type="date"
name="tanggal_pemeriksaan"
value="{{ $pemeriksaan->tanggal_pemeriksaan }}">

<label>Asal / Keterangan Klinik</label>

<input
type="text"
name="keterangan_klinik"
value="{{ $pemeriksaan->keterangan_klinik }}">

<label>Hasil Pemeriksaan</label>

<textarea name="hasil_pemeriksaan">{{ $pemeriksaan->hasil_pemeriksaan }}</textarea>

<label>Nama Pemeriksaan</label>

<input
type="text"
name="nama_pemeriksaan"
value="{{ $pemeriksaan->nama_pemeriksaan }}">

<label>Petugas Lab</label>

<select name="id_petugas">

@foreach($petugas as $pt)

<option
value="{{ $pt->id_petugas }}"
{{ $pemeriksaan->id_petugas == $pt->id_petugas ? 'selected' : '' }}>
{{ $pt->nama_petugas }}
</option>

@endforeach

</select>

<div class="aksi">

<button
    type="submit"
    class="btn-update">
    Update Pemeriksaan
</button>

</form>

<form
    action="/pemeriksaan/{{ $pemeriksaan->id_pemeriksaan }}"
    method="POST"
    onsubmit="return confirm('Yakin ingin menghapus data ini?');">

    @csrf
    @method('DELETE')

    <button
        type="submit"
        class="btn-hapus">
        Hapus Pemeriksaan
    </button>

</form>

</div>

</div>

<div class="kanan">

<h3>Penggunaan Reagen & BMHP</h3>

<p>
    Jumlah Data Barang :
    <strong>{{ $pemeriksaan->penggunaanBarang->count() }}</strong>
</p>

<table class="table-barang">

    <tr>
        <th>Nama Barang</th>
        <th>Jumlah</th>
    </tr>

    @forelse($pemeriksaan->penggunaanBarang as $pb)

    <tr>

        <td>
            {{ $pb->barang->nama_barang }}
        </td>

        <td>
            {{ $pb->jumlah_penggunaan }}
        </td>

    </tr>

    @empty

    <tr>

        <td colspan="2">
            Tidak ada data penggunaan barang
        </td>

    </tr>

    @endforelse

</table>

</div>

</div>

@endsection