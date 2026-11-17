<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'user_id',
        'id_guru',
        'id_kelas',
        'nisn',
        'nama_siswa',
        'jenis_kelamin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function guruWali()
    {
        return $this->belongsTo(GuruWali::class, 'id_guru', 'id_guru');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_siswa', 'id_siswa');
    }

    public function badgeSiswa()
    {
        return $this->hasMany(BadgeSiswa::class, 'id_siswa', 'id_siswa');
    }
}
