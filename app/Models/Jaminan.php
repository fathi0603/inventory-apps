<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jaminan extends Model
{
    protected $table = 'jaminan';

    protected $primaryKey = 'id_jaminan';

    public $timestamps = false;

    protected $fillable = [
        'nama_jaminan'
    ];

    public function pemeriksaan()
    {
        return $this->hasMany(Pemeriksaan::class, 'id_jaminan');
    }
}