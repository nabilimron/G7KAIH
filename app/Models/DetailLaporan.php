<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailLaporan extends Model
{
    protected $table = 'detail_laporan';
    protected $primaryKey = 'id_detail';
    public $timestamps = false;

    protected $fillable = [
        'id_laporan',
        'id_kebiasaan',
        'status',
        'keterangan',
    ];

    protected function casts(): array
    {
        return ['status' => 'boolean'];
    }

    public function laporan()
    {
        return $this->belongsTo(Laporan::class, 'id_laporan', 'id_laporan');
    }

    public function kebiasaan()
    {
        return $this->belongsTo(Kebiasaan::class, 'id_kebiasaan', 'id_kebiasaan');
    }
}
