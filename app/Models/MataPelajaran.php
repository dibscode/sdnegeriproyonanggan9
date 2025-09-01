<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajarans';

    protected $fillable = [
        'nama',
    ];

    public function nilais()
    {
        return $this->hasMany(Nilai::class, 'mapel_id');
    }
}
