<h1>Edit Penggunaan Barang</h1>

<form action="/penggunaan-barang/{{ $penggunaan->id_penggunaan }}" method="POST">
    @csrf
    @method('PUT')

    Pemeriksaan<br>
    <select name="id_pemeriksaan">
        @foreach($pemeriksaan as $p)
            <option value="{{ $p->id_pemeriksaan }}" {{ $penggunaan->id_pemeriksaan == $p->id_pemeriksaan ? 'selected' : '' }}>
                {{ $p->no_lab }}
            </option>
        @endforeach
    </select>
    <br><br>

    Barang<br>
    <select name="id_barang">
        @foreach($barang as $b)
            <option value="{{ $b->id_barang }}" {{ $penggunaan->id_barang == $b->id_barang ? 'selected' : '' }}>
                {{ $b->nama_barang }} - Stok: {{ $b->stok }}
            </option>
        @endforeach
    </select>
    <br><br>

    Jumlah Penggunaan<br>
    <input type="number" name="jumlah_penggunaan" value="{{ $penggunaan->jumlah_penggunaan }}">
    <br><br>

    <button type="submit">Update</button>
</form>