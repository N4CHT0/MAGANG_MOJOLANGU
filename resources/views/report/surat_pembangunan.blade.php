<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Surat Perangkingan Pembangunan</title>
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
            <h1>SURAT RANCANGAN PEMBANGUNAN</h1>
            <p>Nomor : .../.../.........../2024</p>
        </div>
        <div class="isi">
            <p>
                Yang bertanda tangan dibawah ini Lurah Kelurahan Mojolangu, Kecamatan
                Lowokwaru, menerangkan bahwa:
            </p>
            <table>
                <tr>
                    <td>Nama: {{ $inputNama }}</td>
                </tr>
            </table>
            <p>
                Menjamin Data Prioritas Untuk Pembangunan Yang Akan Dilaksanakan Sudah Dijamin Dan Diolah Menggunakan
                Metode AHP (Analytic Hierarcy Priority), Berikut datanya:
            </p>
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th>Urutan</th>
                        <th>Alternatif</th>
                        <th>Skor Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($finalScores as $index => $score)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $score['alternatif'] }}</td>
                            <td>{{ $score['score'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p>Demikian untuk menjadikan periksa dan dipergunakan sepertinya.</p>
        </div>
        <div class="signature">
            <div class="left">
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('report/qr_sktm.jpg'))) }}"
                    alt="qr" style="max-width: 90px; max-height: 40px" />
            </div>
            <div class="right">
                <p>Malang, {{ \Carbon\Carbon::parse($data)->locale('id')->translatedFormat('d F Y') }}</p>
                <p>LURAH MOJOLANGU</p>
                <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('report/ttd_sktm.jpg'))) }}"
                    alt="ttd" style="max-width: 200px; max-height: 45px" />
            </div>
        </div>
    </div>

    <div class="footer">
        Sesuai dengan ketentuan peraturan perundang-undangan yang berlaku, surat ini telah ditandatangani secara
        elektronik yang tersertifikasi oleh Balai Sertifikasi Elektronik (BSrE) sehingga tidak diperlukan tanda tangan
        dan stempel basah.
    </div>

</body>

</html>
