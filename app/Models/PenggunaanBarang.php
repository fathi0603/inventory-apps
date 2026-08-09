<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenggunaanBarang extends Model
{
    protected $table = 'penggunaan_barang';
    protected $primaryKey = 'id_penggunaan';
    public $timestamps = false;

    protected $fillable = [
        'id_pemeriksaan',
        'id_barang',
        'jumlah_penggunaan'
    ];
    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class, 'id_pemeriksaan');
    }

   public function barang()
    {
        return $this->belongsTo( \App\Models\Barang::class, 'id_barang','id_barang' );
    }
}