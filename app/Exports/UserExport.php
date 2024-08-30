<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users; // Mengembalikan koleksi data pengguna
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Lengkap',
            'Jenis Kelamin',
            'NIK',
            'Alamat',
            'RT',
            'RW',
            'Role',
            'Email',
            'No KK',
            'Agama',
            'Pekerjaan',
            'Status Perkawinan',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Pendidikan',
            'Telegram Number'
        ];
    }
}
