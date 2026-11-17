<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';
    public $timestamps = false;

    protected $fillable = [
        'id_siswa',
        'id_semester',
        'status_verifikasi',
        'id_guru_verifikator',
        'tanggal',
        'catatan',
        'waktu_input',
    ];

    protected function casts(): array
    {
        return [
            'status_verifikasi' => 'boolean',
            'tanggal' => 'date',
            'waktu_input' => 'datetime',
        ];
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester', 'id_semester');
    }

    public function guruVerifikator()
    {
        return $this->belongsTo(GuruWali::class, 'id_guru_verifikator', 'id_guru');
    }

    public function details()
    {
        return $this->hasMany(DetailLaporan::class, 'id_laporan', 'id_laporan');
    }

    public function statusLabel(): string
    {
        if ($this->status_verifikasi) {
            return 'Disetujui';
        }

        if ($this->id_guru_verifikator !== null && ! empty($this->catatan)) {
            return 'Ditolak';
        }

        return 'Menunggu';
    }
}
