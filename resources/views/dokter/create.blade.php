<<h1>Tambah Dokter</h1>

<form action="/dokter" method="POST">
    @csrf

    <label>Nama Dokter</label><br>
    <input type="text" name="nama_dokter"><br><br>

    <button type="submit">Simpan</button>
</form>