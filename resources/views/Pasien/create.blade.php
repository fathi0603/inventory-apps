<h1>Tambah Pasien</h1>

<form action="/pasien" method="POST">
    @csrf

    No Medik<br>
    <input type="text" name="no_medik"><br><br>

    Nama Pasien<br>
    <input type="text" name="nama_pasien"><br><br>

    Tanggal Lahir<br>
    <input type="date" name="tanggal_lahir"><br><br>

    Alamat<br>
    <textarea name="alamat"></textarea><br><br>

    Keterangan Pasien<br>
    <input type="text" name="keterangan_pasien"><br><br>

    <button type="submit">Simpan</button>
</form>