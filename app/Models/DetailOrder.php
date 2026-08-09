<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DetailOrder extends Model
{
    protected $table = 'detail_order';

    protected $primaryKey = 'id_detail';

    public $timestamps = false;

    protected $fillable = [
        'id_order',
        'id_barang',
        'jumlah_order',
        'jumlah_diterima',
        'keterangan_order'
    ];

    public function formOrder()
    {
        return $this->belongsTo(FormOrder::class, 'id_order');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}