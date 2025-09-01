<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $fillable = [
        'judul',
        'isi',
        'gambar',
        'penulis_id',
    ];

    public function penulis()
    {
        return $this->belongsTo(Guru::class, 'penulis_id');
    }
}
