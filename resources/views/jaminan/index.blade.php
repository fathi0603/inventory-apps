<h1>Data Jaminan</h1>

<a href="/jaminan/create">Tambah Jaminan</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama Jaminan</th>
        <th>Aksi</th>
    </tr>

    @foreach($jaminan as $j)
    <tr>
        <td>{{ $j->id_jaminan }}</td>
        <td>{{ $j->nama_jaminan }}</td>
        <td>
            <a href="/jaminan/{{ $j->id_jaminan }}/edit">Edit</a>

            <form action="/jaminan/{{ $j->id_jaminan }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>