<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
            font-family: Arial, sans-serif;
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

        .header,
        .footer {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin-bottom: 10mm;
            margin-right: 2mm;
        }

        .header img,
        .footer img {
            max-width: 100%;
        }

        .content {
            margin-top: 10mm;
            width: 100%;
        }

        .content h1 {
            text-align: center;
            text-decoration: underline;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 38mm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        .content p {
            line-height: 1.5;
            margin: 0 0 10px 0;
            font-family: sans-serif;
            font-size: 12px;
        }

        .notes {
            margin-top: 15mm;
            font-size: 10px;
            text-align: left;
        }

        .notes p {
            margin: 5px 0;
        }

        .signature {
            margin-top: 25mm;
            text-align: right;
        }

        .signature p {
            margin: 0;
        }

        .qr-code {
            text-align: right;
            margin-top: 15px;
        }

        .qr-code img {
            width: 80px;
            height: 80px;
        }

        .content .label {
            display: inline-block;
            min-width: 160px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('Surat/header.png') }}" alt="Header Atas">
        </div>

        <div class="content">
            <h1>INVOICE</h1>

        </div>

        <div class="signature">
            <p>Surabaya, 2024</p>
            <p>Mey Prayogo Radi Putro, S.Kom.</p>
        </div>

        <div class="qr-code">
            <img src="{{ public_path('kwitansi_keuangan/QR.png') }}" alt="QR Code">
        </div>

        <div class="footer">
            <img src="{{ public_path('kwitansi_keuangan/Kop Bawah.png') }}" alt="Kop Bawah">
        </div>
    </div>
</body>

</html>