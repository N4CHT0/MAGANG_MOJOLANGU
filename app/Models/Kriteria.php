<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $table = 'kriteria';
    protected $primarykey = "id";
    protected $fillable = [
        'id',
        'nama_kriteria',
        'deskripsi',
    ];
}
