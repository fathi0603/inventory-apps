<h1>Edit Dokter</h1>

<form action="/dokter/{{ $dokter->id_dokter }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nama Dokter</label><br>
    <input type="text" name="nama_dokter" value="{{ $dokter->nama_dokter }}"><br><br>

    <button type="submit">Update</button>
</form>