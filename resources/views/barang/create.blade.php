@extends('layouts.app')

@section('title','Tambah Barang')

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

.kode-otomatis{
    background:#f5f5f5;
    color:#555;
    cursor:not-allowed;
}

.aksi{
    display:flex;
    gap:12px;
    margin-top:30px;
}

.btn-simpan{
    background:#2e7d32;
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
    Tambah Barang
</h2>

<div class="form-card">

    <form action="/barang" method="POST">

        @csrf

        {{-- KODE BARANG --}}
        <label>Kode Barang</label>

        <input
            type="text"
            id="kode_barang"
            class="kode-otomatis"
            readonly
            placeholder="Pilih jenis barang">

        {{-- NAMA BARANG --}}
        <label>Nama Barang</label>

        <input
            type="text"
            name="nama_barang"
            required>


        {{-- JENIS BARANG --}}
        <label>Jenis Barang</label>

        <select
            name="jenis_barang"
            id="jenis_barang"
            required>

            <option value="">
                -- Pilih Jenis Barang --
            </option>

            <option value="Reagen">
                Reagen
            </option>

            <option value="BMHP">
                BMHP
            </option>

        </select>


        {{-- STOK MINIMUM --}}
        <label>Stok Minimum</label>

        <input
            type="number"
            name="stok_minimum"
            required>


        {{-- LOKASI --}}
        <label>Lokasi Penyimpanan</label>

        <input
            type="text"
            name="lokasi"
            required>


        <div class="aksi">

            <button
                type="submit"
                class="btn-simpan">

                Simpan Barang

            </button>

            <a
                href="/barang"
                class="btn-batal">

                Batal

            </a>

        </div>

    </form>

</div>


<script>

document.getElementById('jenis_barang').addEventListener('change', function () {

    let kode = document.getElementById('kode_barang');

    <script>

document.addEventListener('DOMContentLoaded', function () {

    const jenisBarang = document.getElementById('jenis_barang');
    const kodeBarang = document.getElementById('kode_barang');

    const kodeReagen = @json($kodeReagenBerikutnya);
    const kodeBmhp = @json($kodeBmhpBerikutnya);

    jenisBarang.addEventListener('change', function () {

        if (this.value === 'Reagen') {

            kodeBarang.value = kodeReagen;

        } 
        else if (this.value === 'BMHP') {

            kodeBarang.value = kodeBmhp;

        } 
        else {

            kodeBarang.value = '';

        }

    });

});

</script>

@endsection