<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Barang;

class KartuStok extends Model
{
    protected $table = 'kartu_stok';
    protected $primaryKey = 'id_stok';

    protected $fillable = [
        'id_barang',
        'tanggal_stok',
        'jumlah_barang'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}