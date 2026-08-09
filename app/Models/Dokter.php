<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $table = 'dokter';

    protected $primaryKey = 'id_dokter';

    public $timestamps = false;

    protected $fillable = [
        'nama_dokter'
    ];

    public function pemeriksaan()
    {
        return $this->hasMany(Pemeriksaan::class, 'id_dokter');
    }
}