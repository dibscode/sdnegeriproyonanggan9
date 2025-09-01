<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'tgl_lahir',
        'alamat',
        'kelas_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }
}
