<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembangunan extends Model
{
    use HasFactory;
    protected $table = 'pembangunan';
    protected $primarykey = "id";
    protected $fillable = [
        'id',
        'id_users',
        'pengusul',
        'nama',
        'tanggal_pengajuan',
        'status',
        'kategori',
        'biaya',
        'lokasi',
        'waktu_pelaksanaan',
        'prioritas',
        'dokumentasi',
        'validasi',
        'deskripsi',
        'persetujuan',
    ];

    public function Pengguna()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}
