<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'jenis_barang',
        'stok',
        'stok_minimum',
        'tanggal_masuk',
        'tanggal_expired',
        'lokasi'
    ];

    public function penggunaanBarang()
    {
        return $this->hasMany(PenggunaanBarang::class, 'id_barang');
    }

    public function detailOrder()
    {
        return $this->hasMany(DetailOrder::class, 'id_barang');
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_barang');
    }
}