<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Surat Keterangan Tidak Mampu</title>
    <style>
        @page {
            size: 210mm 330mm;
            /* Ukuran F4 */
            margin-left: 10mm;
            margin-right: 25mm;
            margin-top: 10mm;
            margin-bottom: -15mm;
        }

        body {
            font-family: Times New Roman;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            padding: 10mm;
            box-sizing: border-box;
        }

        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            border-bottom: 5px solid black;
            margin-right: 2mm;
        }

        .header img {
            max-width: 100%;
        }

        .content {
            width: 100%;
        }

        .content h1 {
            text-align: center;
            text-decoration: underline;
            font-size: 30px;
            margin-bottom: 0;
        }

        .content p {
            font-family: Times New Roman;
            text-align: center;
            font-size: 20px;
            margin-top: 0;
            margin-bottom: -15px;
        }

        .isi {
            width: 100%;
            text-align: justify;
        }

        .isi table {
            width: 100%;
            border-collapse: collapse;
        }

        .isi table,
        .isi table th,
        .isi table td {
            border: none;
        }

        .isi th {
            text-align: left;
            width: 240px;
            vertical-align: top;
            padding-right: 20px;
            /* Tambahkan padding kanan */
        }

        .isi td {
            padding-left: 10px;
            vertical-align: top;
        }

        .signature {
            width: 100%;
            /* margin-top: 20mm; */
        }

        .signature table {
            width: 100%;
        }

        .signature table td {
            vertical-align: top;
        }

        .signature .left {
            text-align: left;
            font-size: 16px;
        }

        .signature .right {
            text-align: right;
            font-size: 16px;
        }

        .signature .ttd {
            margin-top: 10mm;
        }

        .signature .qr {
            display: block;
            max-width: 70px;
            max-height: auto;
            max-width: 35px;
            max-height: 35px;
            /* >>>>>>> d22b27a140b1ad5da7b30aa40a432cca3cb84bc1 */
        }

        .signature .ttd-img {
            display: block;
            max-width: auto;
            max-height: 50px;
            max-width: 20px;
            max-height: 20px;
            /* >>>>>>> d22b27a140b1ad5da7b30aa40a432cca3cb84bc1 */
        }

        /* Style untuk footer */
        .footer {
            /* width: 100%; */
            text-align: justify;
            border-top: 1px solid black;
            padding-top: 5px;
            margin-top: 10mm;
            font-size: 10px;
            font-style: italic;
            position: fixed;
            bottom: 18mm;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('report/header_sktm.jpg'))) }}"
                alt="header" />
        </div>
        <div class="content">
            <h1>SURAT KETERANGAN TIDAK MAMPU</h1>
            <p>Nomor : .../.../.........../2024</p>
        </div>
        <div class="isi">
            <p>
                Yang bertanda tangan dibawah ini Lurah Kelurahan Mojolangu, Kecamatan
                Lowokwaru, menerangkan bahwa:
            </p>
            <table>
                <tr>
                    <td>Nama</td>
                    <<<<<<< HEAD
                        <td>: AI</td>
                </tr>
                <tr>
                    <td>Nomor KK</td>
                    <td>: 356787878777</td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>: 232312323213</td>
                </tr>
                <tr>
                    <td>Tempat dan Tanggal Lahir</td>
                    <td>: BALIKPAPAN, 31 DESEMBER 1974</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>: LAKI-LAKI</td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td>: ISLAM</td>
                </tr>
                <tr>
                    <td>Status Perkawinan</td>
                    <td>: Kawin</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: MOJOLANGU</td>
                </tr>
                <tr>
                    <td>Pendidikan</td>
                    <td>: SMK</td>
                </tr>
                <tr>
                    <td>Keperluan</td>
                    <td>: SKTM</td>
                </tr>
                <tr>
                    <td>Tujuan</td>
                    <td>: UNISMA</td>
                </tr>
                <tr>
                    <td>Berlaku tanggal</td>
                    <td>: 30 JULI 2024</td>
                    =======
                    <td style="padding-left: 30px;">: {{ $data->nama_lengkap }}</td>
                </tr>
                <tr>
                    <td>Nomor KK</td>
                    <td>: {{ $data->Pengguna->no_kk }}</td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>: {{ $data->nik }}</td>
                </tr>
                <tr>
                    <td>Tempat dan Tanggal Lahir</td>
                    <td>: {{ $data->Pengguna->tempat_lahir }}, {{ $data->Pengguna->tanggal_lahir }}</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>: {{ $data->jenis_kelamin }}</td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td>: {{ $data->Pengguna->agama }}</td>
                </tr>
                <tr>
                    <td>Status Perkawinan</td>
                    <td>: {{ $data->Pengguna->status_perkawinan }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{ $data->alamat }}</td>
                </tr>
                <tr>
                    <td>Pendidikan</td>
                    <td>: {{ $data->Pengguna->pendidikan }}</td>
                </tr>
                <tr>
                    <td>Keperluan</td>
                    <td>: {{ $data->keperluan }}</td>
                </tr>
                <tr>
                    <td>Tujuan</td>
                    <td>: {{ $data->tujuan }}</td>
                </tr>
                <tr>
                    <td>Berlaku tanggal</td>
                    <td>: {{ \Carbon\Carbon::parse($data->masa_berlaku)->translatedFormat('d F Y') }}</td>
                    >>>>>>> d22b27a140b1ad5da7b30aa40a432cca3cb84bc1
                </tr>
                <tr>
                    <td>Berdasarkan Keterangan RT/RW</td>
                    <td>: .../.../..../../../2024</td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        1. Yang bersangkutan benar-benar penduduk Kelurahan Mojolangu
                        Kecamatan Lowokwaru Kota Malang.<br />
                        2. Berdasarkan Keterangan RT/RW setempat di atas serta pernyataan
                        pemohon, yang bersangkutan tergolong orang yang tidak mampu /
                        miskin.
                    </td>
                </tr>
            </table>
            <p>Demikian untuk menjadikan periksa dan dipergunakan sepertinya.</p>
        </div>
        <div class="signature">
            <table>
                <tr>
                    <td class="left">
                        <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('report/qr_sktm.jpg'))) }}"
                            <<<<<<< HEAD
                            alt="qr" />
                        =======
                        alt="qr" style="max-width: 90px; max-height: 40px" />
                        >>>>>>> d22b27a140b1ad5da7b30aa40a432cca3cb84bc1
                    </td>
                </tr>
                <tr>
                    <td class="right">
                        <<<<<<< HEAD
                            <p>Malang, 30 Juli 2024</p>
                            <p>LURAH MOJOLANGU</p>
                            <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('report/ttd_sktm.jpg'))) }}"
                                alt="ttd" />
                            =======
                            <p>Malang, {{ \Carbon\Carbon::parse($data->waktu_finalisasi)->translatedFormat('d F Y') }}</p>
                            <p>LURAH MOJOLANGU</p>
                            <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('report/ttd_sktm.jpg'))) }}"
                                alt="ttd" style="max-width: 200px; max-height: 45px" />
                            >>>>>>> d22b27a140b1ad5da7b30aa40a432cca3cb84bc1
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        Sesuai dengan ketentuan peraturan perundang-undangan yang berlaku, surat ini telah ditandatangani secara elektronik yang tersertifikasi oleh Balai Sertifikasi Elektronik (BSrE) sehingga tidak diperlukan tanda tangan dan stempel basah.
    </div>
</body>

</html>