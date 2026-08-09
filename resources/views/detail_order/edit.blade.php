<h1>Edit Detail Order</h1>

<form action="/detail-order/{{ $detail_order->id_detail_order }}"
      method="POST">

    @csrf
    @method('PUT')

    <label>Form Order</label><br>
    <select name="id_order">
        @foreach($form_order as $o)
            <option value="{{ $o->id_order }}"
                {{ $detail_order->id_order == $o->id_order ? 'selected' : '' }}>
                {{ $o->id_order }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Barang</label><br>
    <select name="id_barang">
        @foreach($barang as $b)
            <option value="{{ $b->id_barang }}"
                {{ $detail_order->id_barang == $b->id_barang ? 'selected' : '' }}>
                {{ $b->nama_barang }}
            </option>
        @endforeach
    </select>
    <br><br>

    <label>Jumlah Order</label><br>
    <input type="number"
           name="jumlah_order"
           value="{{ $detail_order->jumlah_order }}">
    <br><br>

    <label>Keterangan</label><br>
    <input type="text"
           name="keterangan_order"
           value="{{ $detail_order->keterangan_order }}">
    <br><br>

    <button type="submit">
        Update
    </button>
</form>s