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
        'current_service',
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

    public function isCurrentlyManagingService()
    {
        return !empty($this->current_service);  // Mengecek apakah ada layanan yang sedang diurus
    }

    public function updateCurrentService($layanan)
    {
        if ($layanan) {
            $currentServices = explode(', ', $this->current_service);  // Pisahkan layanan yang ada

            // Cek apakah layanan yang akan diurus sudah ada di current_service
            if (!in_array($layanan, $currentServices)) {
                // Jika belum ada, tambahkan layanan baru
                $this->current_service = $this->current_service ? $this->current_service . ', ' . $layanan : $layanan;
            }
        } else {
            // Jika layanan selesai, cek apakah ada layanan selain SKTM yang masih diurus
            $currentServices = explode(', ', $this->current_service);

            // Hapus layanan SKTM dari daftar jika ada
            $currentServices = array_filter($currentServices, function ($service) {
                return $service !== 'SKTM';
            });

            // Jika masih ada layanan lain, perbarui current_service dengan layanan yang belum selesai
            if (!empty($currentServices)) {
                $this->current_service = implode(', ', $currentServices);
            } else {
                // Jika tidak ada layanan lain, kosongkan current_service
                $this->current_service = null;
            }
        }

        $this->save();  // Simpan perubahan
    }
}
