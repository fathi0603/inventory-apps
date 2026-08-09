<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    protected $table = 'pemeriksaan';

    protected $primaryKey = 'id_pemeriksaan';

    protected $fillable = [
        'no_lab',
        'nama_pemeriksaan',
        'id_pasien',
        'id_dokter',
        'id_jaminan',
        'id_petugas',
        'tanggal_pemeriksaan',
        'keterangan_klinik',
        'hasil_pemeriksaan'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter');
    }

    public function jaminan()
    {
        return $this->belongsTo(Jaminan::class, 'id_jaminan');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas');
    }

    public function penggunaanBarang()
    {
        return $this->hasMany(PenggunaanBarang::class, 'id_pemeriksaan', 'id_pemeriksaan');
    }
}