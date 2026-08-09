<h1>Data Dokter</h1>

<a href="/dokter/create">Tambah Dokter</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama Dokter</th>
        <th>Aksi</th>
    </tr>

    @foreach($dokter as $d)
    <tr>
        <td>{{ $d->id_dokter }}</td>
        <td>{{ $d->nama_dokter }}</td>
        <td>
            <a href="/dokter/{{ $d->id_dokter }}/edit">Edit</a>

            <form action="/dokter/{{ $d->id_dokter }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>