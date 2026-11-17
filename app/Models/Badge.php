<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $table = 'badge';
    protected $primaryKey = 'id_badge';
    public $timestamps = false;

    protected $fillable = ['nama', 'deskripsi', 'syarat'];
}
