<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BadgeSiswa extends Model
{
    protected $table = 'badge_siswa';
    public $timestamps = false;

    protected $fillable = ['id_siswa', 'id_badge', 'diperoleh_pada'];

    protected function casts(): array
    {
        return ['diperoleh_pada' => 'datetime'];
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class, 'id_badge', 'id_badge');
    }
}
