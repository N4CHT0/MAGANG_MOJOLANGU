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
            padding-right: 10px;
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

        /* Style tambahan untuk mengatur ukuran gambar yang berbeda */
        .signature .qr {
            width: 80px;
            height: auto;
            object-fit: contain;
        }

        .signature .ttd-img {
            width: auto;
            height: 50px;
            object-fit: contain;
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
            <div class="data">
                <p><span class="label">Nama</span>: {{ $data->nama_lengkap }}<br /></p>
                <p><span class="label">Nomor KK</span>: {{ $data->Pengguna->no_kk }}<br /></p>
                <p><span class="label">NIK</span>: {{ $data->nik }}<br /></p>
                <p>
                    <span class="label">Tempat dan Tanggal Lahir</span>:
                    {{ $data->Pengguna->tempat_lahir }},
                    {{ \Carbon\Carbon::parse($data->Pengguna->tanggal_lahir)->translatedFormat('d F Y') }}<br />

                </p>
                <p><span class="label">Jenis Kelamin</span>: {{ $data->jenis_kelamin }}<br /></p>
                <p><span class="label">Agama</span>: {{ $data->Pengguna->agama }}<br /></p>
                <p><span class="label">Status Perkawinan</span>: {{ $data->Pengguna->status_perkawinan }}<br /></p>
                <p><span class="label">Alamat</span>: {{ $data->alamat }}<br /></p>
                <p><span class="label">Pendidikan</span>: {{ $data->Pengguna->pendidikan }}<br /></p>
                <p><span class="label">Keperluan</span>: {{ $data->keperluan }}<br /></p>
                <p><span class="label">Tujuan</span>: {{ $data->tujuan }}<br /></p>
                <p><span class="label">Berlaku Hingga</span>:
                    {{ \Carbon\Carbon::parse($data->masa_berlaku)->translatedFormat('d F Y') }}<br /></p>
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
            <p>Malang, {{ \Carbon\Carbon::parse($data->waktu_finalisasi)->translatedFormat('d F Y') }}</p>
            <p>Lurah Kelurahan Mojolangu</p>
            <p class="ttd">{{ $lurah->nama_lengkap }}</p>
        </div>
    </div>

    <div class="footer">
        Sesuai dengan ketentuan peraturan perundang-undangan yang berlaku, surat ini telah ditandatangani secara
        elektronik yang tersertifikasi oleh Balai Sertifikasi Elektronik (BSrE) sehingga tidak diperlukan tanda tangan
        dan stempel basah.
    </div>
</body>

</html>
