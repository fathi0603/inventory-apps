<hr>

<h3>Daftar Barang</h3>

<table id="tabelBarang" border="1" cellpadding="8" cellspacing="0" width="100%">
    <tr>
        <th>Barang</th>
        <th>Jumlah</th>
        <th>Aksi</th>
    </tr>

    <tr>
        <td>
            <select name="barang[]" required>
                <option value="">Pilih Barang</option>
                @foreach($barang as $b)
                    <option value="{{ $b->id_barang }}">
                        {{ $b->nama_barang }}
                    </option>
                @endforeach
            </select>
        </td>

        <td>
            <input type="number" name="jumlah[]" min="1" required>
        </td>

        <td>
            <button type="button" onclick="hapusBaris(this)">
                Hapus
            </button>
        </td>
    </tr>
</table>

<br>

<button type="button" onclick="tambahBaris()">
    + Tambah Barang
</button>
<script>

function tambahBaris(){

    let tabel=document.getElementById('tabelBarang');

    let baris=tabel.insertRow(-1);

    baris.innerHTML=`
        <td>
            <select name="barang[]" required>
                <option value="">Pilih Barang</option>

                @foreach($barang as $b)
                    <option value="{{ $b->id_barang }}">
                        {{ $b->nama_barang }}
                    </option>
                @endforeach

            </select>
        </td>

        <td>
            <input type="number" name="jumlah[]" min="1" required>
        </td>

        <td>
            <button type="button" onclick="hapusBaris(this)">
                Hapus
            </button>
        </td>
    `;
}

function hapusBaris(btn){

    let row=btn.parentNode.parentNode;

    row.remove();

}

</script>
<br><br>