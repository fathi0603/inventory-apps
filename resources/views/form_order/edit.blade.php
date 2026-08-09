@extends('layouts.app')

@section('title','Detail Form Order')

@section('css')

<style>

.judul-halaman{
    color:#1b5e20;
    font-size:32px;
    margin-bottom:30px;
}

.form-card{
    max-width:900px;
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
    font-size:15px;
    margin-bottom:15px;
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

.btn-simpan{
    margin-top:25px;
    background:#1b5e20;
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
    Detail Form Order
</h2>

<div class="form-card">

<form action="/form_order/{{ $form_order->id_order }}" method="POST">

@csrf
@method('PUT')

<label>Tanggal Order</label>

<input
type="date"
name="tanggal_order"
value="{{ $form_order->tanggal_order }}">

<label>Departemen</label>

<input
type="text"
name="departemen"
value="{{ $form_order->departemen }}">

<label>Dibuat Oleh</label>

<input
type="text"
value="{{ $form_order->pembuat->nama_petugas }}"
readonly>

<label>Dicek Oleh</label>

<input
type="text"
value="{{ $form_order->pemeriksa->nama_petugas ?? '-' }}"
readonly>

<label>Status</label>

<select
    name="status"
    @if(
        ($form_order->status != 'Diajukan' && session('role') == 'Koordinator Laboratorium') ||
        ($form_order->status != 'Disetujui' && session('role') == 'Logistik') ||
        session('role') == 'Petugas Laboratorium'
    )
        disabled
    @endif
>

    {{-- KOORDINATOR --}}
    @if(session('role') == 'Koordinator Laboratorium')

        @if($form_order->status == 'Diajukan')

            <option value="Diajukan" selected>
                Diajukan
            </option>

            <option value="Disetujui">
                Disetujui
            </option>

            <option value="Ditolak">
                Ditolak
            </option>

        @else

            <option value="{{ $form_order->status }}" selected>
                {{ $form_order->status }}
            </option>

        @endif

    @endif


    {{-- LOGISTIK --}}
    @if(session('role') == 'Logistik')

        @if($form_order->status == 'Disetujui')

            <option value="Disetujui" selected>
                Disetujui
            </option>

            <option value="Diterima">
                Diterima
            </option>

        @else

            <option value="{{ $form_order->status }}" selected>
                {{ $form_order->status }}
            </option>

        @endif

    @endif


    {{-- PETUGAS --}}
    @if(session('role') == 'Petugas Laboratorium')

        <option value="{{ $form_order->status }}" selected>
            {{ $form_order->status }}
        </option>

    @endif

</select>


{{-- STATUS UNTUK FORM YANG DISABLED --}}
@if(
    session('role') == 'Koordinator Laboratorium' &&
    $form_order->status != 'Diajukan'
)

    <input
        type="hidden"
        name="status"
        value="{{ $form_order->status }}">

@endif


@if(
    session('role') == 'Logistik' &&
    $form_order->status != 'Disetujui'
)

    <input
        type="hidden"
        name="status"
        value="{{ $form_order->status }}">

@endif


@if(session('role') == 'Petugas Laboratorium')

    <input
        type="hidden"
        name="status"
        value="{{ $form_order->status }}">

@endif

@if(session('role') == 'Petugas Laboratorium')
<input
    type="hidden"
    name="status"
    value="{{ $form_order->status }}">
@endif

@if(session('role') == 'Petugas Laboratorium')

<div id="penerimaan-barang" style="display:none;">

    <label>Tanggal Masuk</label>

    <input
        type="date"
        name="tanggal_masuk"
        value="{{ date('Y-m-d') }}">

</div>

@endif

<label>Alasan</label>

<input
type="text"
name="alasan"
value="{{ $form_order->alasan }}">

<table class="table-barang">

<tr>

    <th>Nama Barang</th>
    <th>Jumlah Dipesan</th>
    <th>Sudah Diterima</th>
    <th>Sisa Pesanan</th>

    @if(session('role') == 'Petugas Laboratorium')

        <th class="diterima-header" style="display:none;">
            Diterima Sekarang
        </th>

        <th id="header-expired" style="display:none;">
            Tanggal Expired
        </th>

    @endif

</tr>

@foreach($form_order->detailOrder as $detail)

<tr>

    <td>{{ $detail->barang->nama_barang }}</td>

    <td style="text-align:center;">
        {{ $detail->jumlah_order }}
    </td>

    <td style="text-align:center;">
        {{ $detail->jumlah_diterima }}
    </td>

    <td style="text-align:center;font-weight:bold;color:red;">
        {{ $detail->jumlah_order - $detail->jumlah_diterima }}
    </td>

@if(session('role') == 'Petugas Laboratorium')

    <td class="diterima-col" style="display:none;">

        <input
            type="number"
            name="jumlah_diterima[]"
            min="0"
            max="{{ $detail->jumlah_order - $detail->jumlah_diterima }}"
            value="0">

    </td>

    <td class="expired-col" style="display:none;">

        <input
            type="date"
            name="tanggal_expired[]">

    </td>

@endif

</tr>

@endforeach

</table>

@if(session('role') == 'Koordinator Laboratorium' || session('role') == 'Logistik')

<button
    type="submit"
    class="btn-simpan">
    Simpan Perubahan
</button>

@endif

@if(session('role') == 'Petugas Laboratorium')

<button
    type="submit"
    class="btn-simpan">
    Simpan Konfirmasi
</button>

@endif

</form>

</div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const status = document.querySelector('select[name="status"]');
    const penerimaan = document.getElementById('penerimaan-barang');

    const headerDiterima = document.querySelector('.diterima-header');
    const diterimaCols = document.querySelectorAll('.diterima-col');

    const headerExpired = document.getElementById('header-expired');
    const expiredCols = document.querySelectorAll('.expired-col');

    function cekStatus(){

        if(status.value === 'Diterima'){

            penerimaan.style.display = 'block';
            headerExpired.style.display = 'table-cell';
            headerDiterima.style.display = 'table-cell';

            diterimaCols.forEach(function(col){
            col.style.display = 'table-cell';
            });

            expiredCols.forEach(function(col){
                col.style.display = 'table-cell';
            });

        }else{

            penerimaan.style.display = 'none';

            headerDiterima.style.display = 'none';
            headerExpired.style.display = 'none';

            diterimaCols.forEach(function(col){
                col.style.display = 'none';
            });

            expiredCols.forEach(function(col){
                col.style.display = 'none';
            });

        }

    }

    cekStatus();

    status.addEventListener('change', cekStatus);

});
</script>

@endsection