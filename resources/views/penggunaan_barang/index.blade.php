<h1>Data Penggunaan Barang</h1>

<a href="/penggunaan-barang/create">Tambah Penggunaan Barang</a>

<table border="1">
    <tr>
        <th>ID Penggunaan</th>
        <th>ID Pemeriksaan</th>
        <th>ID Barang</th>
        <th>Jumlah Penggunaan</th>
        <th>Aksi</th>
    </tr>

    @foreach($penggunaan as $p)
    <tr>
        <td>{{ $p->id_penggunaan }}</td>
        <td>{{ $p->pemeriksaan->no_lab ?? '-' }}</td>
        <td>{{ $p->barang->nama_barang ?? '-' }}</td>
        <td>{{ $p->jumlah_penggunaan }}</td>
        <td>
            <a href="/penggunaan-barang/{{ $p->id_penggunaan }}/edit">Edit</a>

            <form action="/penggunaan-barang/{{ $p->id_penggunaan }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>