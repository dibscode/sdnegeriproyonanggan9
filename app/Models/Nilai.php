<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $fillable = [
        'murid_id',
        'kelas_id',
        'semester',
        'tahun_ajaran',
        'mapel_id',
        'nilai',
        'wali_guru_id',
    ];

    public function murid()
    {
        return $this->belongsTo(Murid::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    public function wali()
    {
        return $this->belongsTo(Guru::class, 'wali_guru_id');
    }
}
