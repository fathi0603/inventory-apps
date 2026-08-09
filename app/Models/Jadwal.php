<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Petugas;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';

    public $timestamps = false;

    protected $fillable = [
    'id_petugas',
    'hari',
    'shift',
    'periode'
];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas');
    }
}