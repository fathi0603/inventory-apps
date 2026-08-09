<h1>Tambah Penggunaan Barang</h1>

<form action="/penggunaan-barang" method="POST">
    @csrf

    Pemeriksaan<br>
    <select name="id_pemeriksaan">
        @foreach($pemeriksaan as $p)
            <option value="{{ $p->id_pemeriksaan }}">
                {{ $p->no_lab }}
            </option>
        @endforeach
    </select>
    <br><br>

    Barang<br>
    <select name="id_barang">
        @foreach($barang as $b)
            <option value="{{ $b->id_barang }}">
                {{ $b->nama_barang }}
            </option>
        @endforeach
    </select>
    <br><br>

    Jumlah Penggunaan<br>
    <input type="number" name="jumlah_penggunaan">
    <br><br>

    <button type="submit">Simpan</button>
</form>