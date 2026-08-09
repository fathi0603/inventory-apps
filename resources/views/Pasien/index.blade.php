<body>

<a href="/dashboard">Dashboard</a> |
<a href="/logout">Logout</a>

<hr>

<h1>Data Pasien</h1>

<a href="/pasien/create">Tambah Pasien</a>

<table border="1">
    <tr>
        <th>No Medik</th>
        <th>Nama Pasien</th>
        <th>Tanggal Lahir</th>
        <th>Alamat</th>
        <th>Keterangan</th>
        <th>Aksi</th>
    </tr>

    @foreach($pasien as $p)
    <tr>
        <td>{{ $p->no_medik }}</td>
        <td>{{ $p->nama_pasien }}</td>
        <td>{{ $p->tanggal_lahir }}</td>
        <td>{{ $p->alamat }}</td>
        <td>{{ $p->keterangan_pasien }}</td>
        <td>
            <a href="/pasien/{{ $p->id_pasien }}/edit">Edit</a>

            <form action="/pasien/{{ $p->id_pasien }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

</body>