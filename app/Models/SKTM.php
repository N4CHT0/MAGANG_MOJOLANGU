<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SKTM extends Model
{
    use HasFactory;
    protected $table = 'sktm';
    protected $primarykey = "id";
    protected $fillable = [
        'id',
        'id_users',
        'nama_lengkap',
        'alamat',
        'rt',
        'rw',
        'nik',
        'jenis_kelamin',
        'foto_ktp',
        'foto_kk',
    ];

    public function Pengguna()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}
