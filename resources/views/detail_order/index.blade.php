<h1>Data Detail Order</h1>

<a href="/detail-order/create">
Tambah Detail Order
</a>

<table border="1">
<tr>
    <th>ID</th>
    <th>Order</th>
    <th>Barang</th>
    <th>Jumlah</th>
    <th>Keterangan</th>
    <th>Aksi</th>
</tr>

@foreach($detail_order as $d)
<tr>
   <td>{{ $d->barang->nama_barang ?? '-' }}</td>
    <td>Order #{{ $d->id_order }}</td>
    <td>{{ $d->id_barang }}</td>
    <td>{{ $o->detailOrder->sum('jumlah_order') }}</td>
    <td>{{ $d->keterangan_order }}</td>

    <td>
        <a href="/detail-order/{{ $d->id_detail_order }}/edit">
            Edit
        </a>

        <form action="/detail-order/{{ $d->id_detail_order }}"
              method="POST"
              style="display:inline">

            @csrf
            @method('DELETE')

            <button type="submit">
                Hapus
            </button>
        </form>
    </td>
</tr>
@endforeach
</table>