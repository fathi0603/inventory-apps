<h1>Edit Jaminan</h1>

<form action="/jaminan/{{ $jaminan->id_jaminan }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nama Jaminan</label><br>
    <input type="text" name="nama_jaminan" value="{{ $jaminan->nama_jaminan }}"><br><br>

    <button type="submit">Update</button>
</form>