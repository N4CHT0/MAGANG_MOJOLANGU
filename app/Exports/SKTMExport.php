<?php

namespace App\Exports;

use App\Models\SKTM;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SKTMExport implements FromCollection, WithMapping, WithHeadings,  WithColumnFormatting
{
    public function collection()
    {
        return SKTM::all();
    }

    /**
     * @var SKTM $sktm
     */
    public function map($sktm): array
    {
        return [
            $sktm->id,
            $sktm->id_users,
            $sktm->nama_lengkap,
            $sktm->alamat,
            $sktm->rt,
            $sktm->rw,
            $sktm->nik,
            $sktm->jenis_kelamin,
            $sktm->foto_ktp,
            $sktm->foto_kk,
            $sktm->keperluan,
            $sktm->tujuan,
            $sktm->validasi,
            $sktm->keterangan,
            $sktm->surat_pengantar,
            $sktm->product,
            // Mengonversi timestamp menjadi datetime
            $sktm->created_at->format('Y-m-d H:i:s'),
            $sktm->updated_at->format('Y-m-d H:i:s'),
            // Tambahkan kolom lain sesuai kebutuhan
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'ID Users',
            'Nama Lengkap',
            'Alamat',
            'RT',
            'RW',
            'NIK',
            'Jenis Kelamin',
            'Foto KTP',
            'Foto KK',
            'Keperluan',
            'Tujuan',
            'Validasi',
            'Keterangan',
            'Surat Pengantar',
            'Produk',
            'Tanggal Dibuat',
            'Tanggal Diperbarui',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_DATE_DATETIME, // Kolom created_at
            'H' => NumberFormat::FORMAT_DATE_DATETIME, // Kolom updated_at
        ];
    }
}
