@extends('layouts.app')

@section('title','Form Order')

@section('css')

<style>

.judul-halaman{
    color:#1b5e20;
    font-size:32px;
    margin-bottom:30px;
}

.form-card{
    max-width:850px;
    background:white;
    border:2px solid #1b5e20;
    border-radius:15px;
    padding:35px;
    box-shadow:0 6px 18px rgba(0,0,0,.12);
}

label{
    display:block;
    margin-top:15px;
    margin-bottom:8px;
    font-weight:bold;
    color:#1b5e20;
}

input,
select{
    width:100%;
    padding:10px 12px;
    border:2px solid #1b5e20;
    border-radius:8px;
    box-sizing:border-box;
    margin-bottom:18px;
    font-size:15px;
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
    display:flex;
    gap:12px;
    margin-top:25px;
}

.btn-simpan,
.btn-tambah{
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
    padding:10px 18px;
    border-radius:6px;
    cursor:pointer;
}

</style>

@endsection

@section('content')

<h2 class="judul-halaman">
    Form Order
</h2>

<div class="form-card">

<form action="/form_order" method="POST">

@csrf

<label>Tanggal Order</label>

<input
type="date"
name="tanggal_order"
required>

<label>Departemen</label>

<input
type="text"
name="departemen"
required>

<label>Alasan</label>

<input
type="text"
name="alasan"
placeholder="Masukkan alasan order"
required>

<h3>Daftar Barang</h3>

<table
class="table-barang"
id="tabelBarang">

<tr>

<th>Barang</th>

<th>Jumlah</th>

<th>Aksi</th>

</tr>

<tr>

<td>

<select
name="barang[]"
required>

<option value="">
Pilih Barang
</option>

@foreach($barang as $b)

<option value="{{ $b->id_barang }}">
{{ $b->nama_barang }}
</option>

@endforeach

</select>

</td>

<td>

<input
type="number"
name="jumlah[]"
min="1"
required>

</td>

<td>

<button
type="button"
class="btn-hapus"
onclick="hapusBaris(this)">
Hapus
</button>

</td>

</tr>

</table>

<div class="btn-area">

<button
    type="button"
    class="btn-tambah"
    onclick="tambahBaris()">
    + Tambah Barang
</button>

<button
    type="submit"
    class="btn-simpan">
    Simpan Order
</button>

</div>

</form>

</div>

<script>

function tambahBaris(){

    let tabel = document.getElementById('tabelBarang');

    let baris = tabel.insertRow(-1);

    baris.innerHTML = `
        <td>

            <select
                name="barang[]"
                required>

                <option value="">
                    Pilih Barang
                </option>

                @foreach($barang as $b)

                <option value="{{ $b->id_barang }}">
                    {{ $b->nama_barang }}
                </option>

                @endforeach

            </select>

        </td>

        <td>

            <input
                type="number"
                name="jumlah[]"
                min="1"
                required>

        </td>

        <td>

            <button
                type="button"
                class="btn-hapus"
                onclick="hapusBaris(this)">
                Hapus
            </button>

        </td>
    `;

}

function hapusBaris(btn){

    let row = btn.closest('tr');

    let tabel = document.getElementById('tabelBarang');

    if(tabel.rows.length > 2){
        row.remove();
    }else{
        alert('Minimal harus ada satu barang.');
    }

}

</script>

@endsection