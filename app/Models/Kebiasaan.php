<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kebiasaan extends Model
{
    protected $table = 'kebiasaan';
    protected $primaryKey = 'id_kebiasaan';
    public $timestamps = false;

    protected $fillable = ['nama_kebiasaan', 'deskripsi'];
}
