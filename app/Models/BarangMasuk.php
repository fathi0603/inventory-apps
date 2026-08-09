<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = 'barang_masuk';

    protected $primaryKey = 'id_masuk';

    protected $fillable = [
        'id_barang',
        'id_detail',
        'tanggal_masuk',
        'tanggal_expired',
        'jumlah_masuk',
        'sisa_stok'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function detailOrder()
    {
        return $this->belongsTo(DetailOrder::class, 'id_detail', 'id_detail');
    }
}