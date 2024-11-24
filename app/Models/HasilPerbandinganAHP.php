<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPerbandinganAHP extends Model
{
    use HasFactory;

    protected $table = 'hasil_perbandingan_ahp';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'data_perbandingan',
        'perangkingan_pembangunan',
        'file_pdf',
        'input_nama',
        'status',
    ];

    // Pastikan primary key adalah id (default Eloquent)
    protected $primaryKey = 'id';

    // Pastikan casting JSON bekerja
    protected $casts = [
        'data_perbandingan' => 'array',
        'perangkingan_pembangunan' => 'array',
    ];
}
