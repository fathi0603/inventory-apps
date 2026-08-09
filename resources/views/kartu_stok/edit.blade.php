<h1>Edit Kartu Stok</h1>

<form action="/kartu-stok/{{ $kartu_stok->id_stok }}" method="POST">
    @csrf
    @method('PUT')

    Barang <br>
    <select name="id_barang">
        @foreach($barang as $b)
            <option value="{{ $b->id_barang }}" {{ $kartu_stok->id_barang == $b->id_barang ? 'selected' : '' }}>
                {{ $b->nama_barang }}
            </option>
        @endforeach
    </select>
    <br><br>

    Tanggal <br>
    <input type="date" name="tanggal_stok" value="{{ $kartu_stok->tanggal_stok }}">
    <br><br>

    Jumlah Barang <br>
    <input type="number" name="jumlah_barang" value="{{ $kartu_stok->jumlah_barang }}">
    <br><br>

    <button type="submit">Update</button>
</form>