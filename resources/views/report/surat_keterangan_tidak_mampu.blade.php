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
            margin-bottom: 5mm;
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
            margin-bottom: 1px;
        }

        .content p {
            line-height: 1.5;
            margin: 0 0 10px 0;
            font-family: Times New Roman;
            text-align: center;
            font-size: 20px;
        }

        .isi {
            width: 100%;
            text-align: justify;
        }

        .isi p {
            font-size: 16px;
            line-height: 1.5;
        }

        .data {
            width: 100%;
        }

        .data p {
            font-size: 16px;
            line-height: 1.5;
            margin: 0 0 10px 0;
        }

        .data span {
            width: 200px;
        }

        .label {
            display: inline-block;
            width: 120px;
            /* Lebar label */
        }

        .signature {
            width: 100%;
            text-align: right;
            margin-top: 20mm;
        }

        .signature p {
            font-size: 16px;
            line-height: 1.5;
        }

        .signature .ttd {
            margin-top: 30mm;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('Surat/header.png') }}" alt="Header" />
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
            <div class="data">
                <p><span class="label">Nama</span>: AI<br /></p>
                <p><span class="label">Nomor KK</span>: 356787878777<br /></p>
                <p><span class="label">NIK</span>: 232312323213<br /></p>
                <p>
                    <span class="label">Tempat dan Tanggal Lahir</span>: BALIKPAPAN, 31
                    DESEMBER 1974<br />
                </p>
                <p><span class="label">Jenis Kelamin</span>: LAKI-LAKI<br /></p>
                <p><span class="label">Agama</span>: ISLAM<br /></p>
                <p><span class="label">Status Perkawinan</span>: Kawin<br /></p>
                <p><span class="label">Alamat</span>: MOJOLANGU<br /></p>
                <p><span class="label">Pendidikan</span>: SMK<br /></p>
                <p><span class="label">Keperluan</span>: SKTM<br /></p>
                <p><span class="label">Tujuan</span>: UNISMA<br /></p>
                <p><span class="label">Berlaku tanggal</span>: 30 JULI 2024<br /></p>
                <p>
                    <span class="label">Berdasarkan Keterangan</span>:
                    .../.../..../../../2024<br />
                </p>
            </div>
            <p>
                <span class="label"></span>
                1. Yang bersangkutan benar-benar penduduk Kelurahan Mojolangu
                Kecamatan Lowokwaru Kota Malang.
            </p>
            <p>
                <span class="label"></span>
                2. Berdasarkan Keterangan RT/RW setempat di atas serta pernyataan
                pemohon, yang bersangkutan tergolong orang yang tidak mampu / miskin.
            </p>
            <p>Demikian untuk menjadikan periksa dan dipergunakan sepertinya</p>
        </div>
        <div class="signature">
            <p>Malang, 30 Juli 2024</p>
            <p>Lurah Kelurahan Mojolangu</p>
            <p class="ttd">(Nama Lurah)</p>
        </div>
    </div>
</body>

</html>