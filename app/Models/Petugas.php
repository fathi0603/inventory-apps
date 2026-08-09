<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugas';

    protected $primaryKey = 'id_petugas';

    public $timestamps = false;

    protected $fillable = [
        'nama_petugas',
        'jabatan'
    ];

    public function pemeriksaan()
    {
        return $this->hasMany(Pemeriksaan::class, 'id_petugas');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'id_petugas');
    }
}