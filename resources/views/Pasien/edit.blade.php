<h1>Edit Pasien</h1>

<form action="/pasien/{{ $pasien->id_pasien }}" method="POST">
    @csrf
    @method('PUT')

    No Medik<br>
    <input type="text" name="no_medik" value="{{ $pasien->no_medik }}"><br><br>

    Nama Pasien<br>
    <input type="text" name="nama_pasien" value="{{ $pasien->nama_pasien }}"><br><br>

    Tanggal Lahir<br>
    <input type="date" name="tanggal_lahir" value="{{ $pasien->tanggal_lahir }}"><br><br>

    Alamat<br>
    <textarea name="alamat">{{ $pasien->alamat }}</textarea><br><br>

    Keterangan Pasien<br>
    <input type="text" name="keterangan_pasien" value="{{ $pasien->keterangan_pasien }}"><br><br>

    <button type="submit">Update</button>
</form>