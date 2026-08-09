<h1>Tambah Jaminan</h1>

<form action="/jaminan" method="POST">
    @csrf

    <label>Nama Jaminan</label><br>
    <input type="text" name="nama_jaminan"><br><br>

    <button type="submit">Simpan</button>
</form>