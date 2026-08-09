<h1>Edit Petugas</h1>

<form action="/petugas/{{ $petugas->id_petugas }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nama Petugas</label><br>
    <input type="text" name="nama_petugas" value="{{ $petugas->nama_petugas }}"><br><br>

    <button type="submit">Update</button>
</form>