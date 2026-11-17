<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuruWali extends Model
{
    protected $table = 'guru_wali';
    protected $primaryKey = 'id_guru';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'user_id',
        'nip',
        'nama_guru',
        'no_hp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_guru', 'id_guru');
    }
}
