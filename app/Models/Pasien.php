<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';

    protected $primaryKey = 'id_pasien';

    public $timestamps = false;

    protected $fillable = [
        'no_medik',
        'nama_pasien',
        'tanggal_lahir',
        'alamat',
        'keterangan_pasien'
    ];

    public function pemeriksaan()
    {
        return $this->hasMany(Pemeriksaan::class, 'id_pasien');
    }
}