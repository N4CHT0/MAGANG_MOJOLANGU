<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPerbandinganAHP extends Model
{
    use HasFactory;

    protected $table = 'hasil_perbandingan_ahp';

    protected $fillable = [
        'data_perbandingan',
        'perangkingan_pembangunan',
        'file_pdf',
        'input_nama'
    ];

    protected $casts = [
        'data_perbandingan' => 'array', // Mengonversi JSON otomatis menjadi array PHP
        'perangkingan_pembangunan' => 'array' // Untuk menyimpan data perangkingan sebagai array
    ];
}
