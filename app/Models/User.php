
<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'email', 'password', 'role', 'status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ===== ACCESSOR (GETTER) DAN MUTATOR (SETTER) =====

    protected function username(): Attribute
    {
        return Attribute::make(
            // GETTER: mengubah username menjadi huruf kecil saat dibaca
            get: fn ($value) => strtolower($value),

            // SETTER: menghapus spasi dan mengubah menjadi huruf kecil sebelum disimpan
            set: fn ($value) => strtolower(trim($value))
        );
    }

    // ===== METHOD BUATAN SENDIRI =====

    /** Dua huruf awal nama, untuk avatar */
    public function inisial(): string
    {
        return strtoupper(substr($this->name, 0, 2));
    }

    /** Apakah akun berstatus aktif? */
    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }

    /** Teks peran untuk ditampilkan di tabel */
    public function labelRole(): string
    {
        return match ($this->role) {
            'guru_wali' => 'Guru Wali',
            'admin'     => 'Admin',
            default     => 'Siswa',
        };
    }

    // ===== RELASI MODEL =====

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id', 'id');
    }

    public function guruWali()
    {
        return $this->hasOne(GuruWali::class, 'user_id', 'id');
    }
}
