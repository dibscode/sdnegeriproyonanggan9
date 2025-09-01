<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'nama',
        'wali_guru_id',
    ];

    public function wali()
    {
        return $this->belongsTo(Guru::class, 'wali_guru_id');
    }

    public function murids()
    {
        return $this->hasMany(Murid::class);
    }
}
