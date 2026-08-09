<h1>Tambah Kartu Stok</h1>

<form action="/kartu-stok" method="POST">
    @csrf

    Barang <br>
    <select name="id_barang">
        @foreach($barang as $b)
            <option value="{{ $b->id_barang }}">
                {{ $b->nama_barang }}
            </option>
        @endforeach
    </select>
    <br><br>

    Tanggal <br>
    <input type="date" name="tanggal_stok">
    <br><br>

    Jumlah Barang <br>
    <input type="number" name="jumlah_barang">
    <br><br>

    <button type="submit">
        Simpan
    </button>
</form>