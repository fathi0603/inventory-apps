@extends('layouts.app')

@section('title','Detail Barang')

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

input{
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
.card-monitoring{
    display:flex;
    gap:20px;
    margin:30px 0;
}

.monitor-box{
    flex:1;
    border:2px solid #1b5e20;
    border-radius:12px;
    padding:20px;
    text-align:center;
    background:#fff;
}

.monitor-box h5{
    margin:0;
    color:#1b5e20;
    font-size:16px;
}

.monitor-box h2{
    margin-top:15px;
    font-size:34px;
    color:#1b5e20;
}

.table-batch{
    width:100%;
    border-collapse:collapse;
    margin-top:35px;
}

.table-batch th,
.table-batch td{
    border:1px solid #ddd;
    padding:12px;
    text-align:center;
}

.table-batch th{
    background:#1b5e20;
    color:white;
}

.badge-hijau{
    background:#2e7d32;
    color:white;
    padding:6px 12px;
    border-radius:6px;
}

.badge-kuning{
    background:#f9a825;
    color:white;
    padding:6px 12px;
    border-radius:6px;
}

.badge-merah{
    background:#c62828;
    color:white;
    padding:6px 12px;
    border-radius:6px;
}

.wrapper-detail{
    display:flex;
    gap:30px;
    align-items:flex-start;
}

.detail-kiri{
    width:40%;
}

.detail-kanan{
    width:60%;
}

.cards{
    display:flex;
    justify-content:space-between;
    gap:15px;
    margin-bottom:30px;
}

.card{
    flex:1;
    min-width:0;
    height:150px;
    border:2px solid #1b5e20;
    border-radius:15px;
    background:#fff;
    box-shadow:0 6px 18px rgba(0,0,0,.12);
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
}

.card h4{
    margin:0;
    font-size:20px;
    color:#1b5e20;
    font-weight:bold;
}

.card h2{
    margin-top:18px;
    margin-bottom:0;
    font-size:56px;
    color:#1b5e20;
    font-weight:bold;
}

.table-batch{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    border:3px solid #1b5e20;
}

.batch-table th{
    background:#1b5e20;
    color:white;
}

.batch-table th,
.batch-table td{
    border:1px solid #ddd;
    padding:12px;
    text-align:center;
}
</style>
@endsection

@section('content')

<h2 class="judul-halaman">
    Detail Barang
</h2>

<div class="wrapper-detail">

    {{-- ================= KIRI ================= --}}
    <div class="detail-kiri">

        <div class="form-card">

            <label>Nama Barang</label>
            <input type="text" value="{{ $barang->nama_barang }}" readonly>

            <label>Jenis Barang</label>
            <input type="text" value="{{ $barang->jenis_barang }}" readonly>

            <label>Lokasi</label>
            <input type="text" value="{{ $barang->lokasi }}" readonly>

            <label>Total Stok</label>
            <input type="text" value="{{ $totalStok }} pcs" readonly>

            <label>Stok Minimum</label>
            <input type="text" value="{{ $barang->stok_minimum }} pcs" readonly>

            <div class="aksi">

                <a href="/barang/{{ $barang->id_barang }}/edit" class="btn-update">
                    Update Barang
                </a>

                <form action="/barang/{{ $barang->id_barang }}" method="POST">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn-hapus"
                        onclick="return confirm('Yakin ingin menghapus barang?')">

                        Hapus Barang

                    </button>

                </form>

            </div>

        </div>

    </div>

    {{-- ================= KANAN ================= --}}
    <div class="detail-kanan">

        <div class="cards">

            <div class="card">
                <h4>Stok Aman</h4>
                <h2>{{ $stokAman }}</h2>
            </div>

            <div class="card">
                <h4>Segera Expired</h4>
                <h2>{{ $stokSegeraExpired }}</h2>
            </div>

            <div class="card">
                <h4>Sudah Expired</h4>
                <h2>{{ $stokExpired }}</h2>
            </div>

        </div>

        <h3 style="color:#1b5e20;margin-bottom:20px;">
            Riwayat Batch Barang
        </h3>

        <table class="batch-table">

            <thead>

            <tr>
                <th>No</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Expired</th>
                <th>Jumlah Masuk</th>
                <th>Sisa Batch</th>
                <th>Status</th>
            </tr>

            </thead>

            <tbody>

            @forelse($batchBarang as $batch)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>
                    {{ \Carbon\Carbon::parse($batch->tanggal_masuk)->format('d-m-Y') }}
                </td>

                <td>
                    {{ \Carbon\Carbon::parse($batch->tanggal_expired)->format('d-m-Y') }}
                </td>

                <td>{{ $batch->jumlah_masuk }}</td>

                <td>{{ $batch->sisa_stok }}</td>

                <td>

                    @if($batch->sisa_stok == 0)

                        <span class="badge-hijau">
                            Habis Digunakan
                        </span>

                    @elseif(\Carbon\Carbon::parse($batch->tanggal_expired)->isPast())

                        <span class="badge-merah">
                            Expired
                        </span>

                    @elseif(\Carbon\Carbon::parse($batch->tanggal_expired)->lessThanOrEqualTo(now()->addDays(90)))

                        <span class="badge-kuning">
                            Segera Expired
                        </span>

                    @else

                        <span class="badge-hijau">
                            Aman
                        </span>

                    @endif

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="6">
                    Belum ada riwayat barang masuk.
                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection