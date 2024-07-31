<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pengantar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0px;
            padding: 0px;
            font-size: 13px;
        }

        .container {
            width: 210mm;
            height: 330mm; /* Ukuran tinggi kertas F4 */
            margin: auto;
            padding: 10px;
            box-sizing: border-box;
            /* border: 1px solid black; */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 5px solid black;
            padding-bottom: 10px;
        }

        .header div {
            text-align: center;
            border: 1px solid black;
            padding: 1px;
            flex: 1;
            margin: 5px;
            font-size: 30px;
            font-weight: normal;
        }

        .header .center {
            flex: 4;
            font-size: 14px;
            font-weight: normal;
        }

        .content {
            text-align: center;
            margin-top: 2px;
        }

        .contentisi {
            text-align: left;
            margin-left: 50px;
        }

        .contentisi strong {
            display: inline-block;
            width: 200px;
            margin-top: 2px;
            margin-bottom: 2px;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .content th,
        .content td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
            position: relative;
            font-size: 11px;
        }

        .checkbox {
            width: 15px;
            height: 15px;
            border: 1px solid black;
            position: absolute;
            right: 2px;
            top: 50%;
            transform: translateY(-50%);
        }

        .checked .checkbox::after {
            content: '√';
            position: absolute;
            left: 3px;
            top: -2px;
        }

        .signature {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .signature div {
            width: 30%;
            text-align: center;
        }

        @media print {
            @page {
                size: 210mm 330mm; /* Ukuran kertas F4 */
                margin: 20mm; /* Margin presisi di sisi kanan, kiri, dan bawah */
            }

            body {
                width: 210mm;
                height: 330mm;
            }

            .container {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div>RW.07</div>
            <div class="center">
                <p>RUKUN TETANGGA 08 RUKUN WARGA 07</p>
                <p>KELURAHAN MOJOLANGU</p>
                <p>KECAMATAN LOWOKWARU</p>
            </div>
            <div>RT.08</div>
        </div>
        <p>
            Kepada Yth<br>
            Kepala Kelurahan Mojolangu<br>
            Kecamatan Lowokwaru Kota Malang<br>
            Di Tempat
        </p>
        <div class="content">
            <h2 style="text-decoration: underline;">SURAT PENGANTAR</h2>
            <p>No. Register RW: .......................</p>
            <p>No. Register RT: .......................</p>
            <p style="text-align: justify;">Bersama ini kami mohon bantuannya untuk dilengkapi kebutuhan kepengurusan
                surat yang diperlukan warga kami di bawah ini:</p>
            <p class="contentisi">
                <strong>Nama</strong>: {{ $data->nama_lengkap }}<br>
                <strong>Jenis Kelamin</strong>: {{ $data->jenis_kelamin }}<br>
                <strong>NIK/NO. KTP</strong>: {{ $data->nik }}<br>
                <strong>Alamat</strong>: {{ $data->alamat }}<br>
                <strong>Keperluan Untuk</strong>: Beri tanda √ pada kotak yang dibutuhkan
            </p>
            <table>
                <tr>
                    <th>1. SKU/SKDU<div class="checkbox"></div>
                    </th>
                    <th>2. BORO KERJA<div class="checkbox"></div>
                    </th>
                    <th class="checked">3. SKTM<div class="checkbox"></div>
                    </th>
                    <th>4. IJIN KERAMAIAN<div class="checkbox"></div>
                    </th>
                    <th>5. IMB/SPPL<div class="checkbox"></div>
                    </th>
                </tr>
                <tr>
                    <td>SYARAT-SYARATNYA:<br>Fc. KTP pemohon 1x<br>FC Kartu Keluarga 1x</td>
                    <td>SYARAT-SYARATNYA:<br>Fc. KK+KTP pemohon 1x<br>... (daftar berlanjut)</td>
                    <td>SYARAT-SYARATNYA:<br>Fc. Kartu Keluarga 1x<br>Fc. E-KTP 1x</td>
                    <td>SYARAT-SYARATNYA:<br>Fc. E-KTP 1x<br>... (daftar berlanjut)</td>
                    <td>SYARAT-SYARATNYA:<br>Fc. Sertifikat tanah 1x<br>... (daftar berlanjut)</td>
                </tr>
                <!-- Tambahkan baris lainnya sesuai kebutuhan -->
            </table>
            <p style="text-align: justify;">Demikian surat pengantar ini kami sampaikan untuk diketahui, atas bantuan
                dan kerjasama yang baik diucapkan terimakasih.</p>
            <p style="text-align: justify;">Malang,..................20..</p>
            <div class="signature">
                <div>
                    <p>Ketua RW.07</p><br>
                    <p>Mulyani, S.Pd</p>
                </div>
                <div>
                    <p>Ketua RT.08</p><br>
                    <p>Suwadi</p>
                </div>
                <div>
                    <p>Pemohon</p><br>
                    <p>{{ $data->nama_lengkap }}</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
