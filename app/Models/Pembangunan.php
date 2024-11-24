<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pembangunan extends Model
{
    use HasFactory;

    protected $table = 'pembangunan';
    protected $primaryKey = "id";

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

    // Accessor untuk dokumentasi
    public function getDokumentasiUrlAttribute()
    {
        if (!$this->dokumentasi) {
            return [];
        }

        $files = json_decode($this->dokumentasi, true); // Uraikan JSON
        if (!is_array($files)) {
            return [];
        }

        return array_map(function ($file) {
            return url("storage/image/{$file}");
        }, $files);
    }
}
