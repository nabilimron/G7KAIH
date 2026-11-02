<?php
 
namespace App\Models;
 
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
 
#[Fillable(['name', 'username', 'email', 'password', 'role', 'status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
 
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',   // password otomatis di-hash saat disimpan
        ];
    }
 
    // ===== METHOD buatan sendiri =====
 
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
        return $this->role === 'guru_wali' ? 'Guru Wali' : 'Siswa';
    }
}
