<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormOrder extends Model
{
    protected $table = 'form_order';

    protected $primaryKey = 'id_order';

    public $timestamps = false; 

    protected $fillable = [
        'tanggal_order',
        'jumlah_item',
        'departemen',
        'dibuat_oleh',
        'dicek_oleh',
        'alasan',
        'status',
        'konfirmasi_barang'
];

    public function pembuat()
    {
        return $this->belongsTo(Petugas::class, 'dibuat_oleh', 'id_petugas');
    }

    public function pemeriksa()
    {
        return $this->belongsTo(Petugas::class, 'dicek_oleh', 'id_petugas');
    }
    public function detailOrder()
    {
    return $this->hasMany(DetailOrder::class, 'id_order', 'id_order');
    }
}