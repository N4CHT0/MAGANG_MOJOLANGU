<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_lengkap',
        'jenis_kelamin',
        'nik',
        'alamat',
        'rt',
        'rw',
        'role',
        'email',
        'password',
        'no_kk',
        'agama',
        'pekerjaan',
        'status_perkawinan',
        'tempat_lahir',
        'tanggal_lahir',
        'pendidikan',
        'telegram_number',
        'waktu_validasi',
        'waktu_finalisasi',
        'data_updated',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function SKTM()
    {
        return $this->hasMany(SKTM::class);
    }
}
