<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pengantar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            /* padding: 0; */
            font-size: 13px;
        }

        .container {
            width: 100%;
            margin: auto;
            box-sizing: border-box;
        }

        .header {
            border-collapse: collapse;
            display: flex;
            border-bottom: 5px solid black;
        }

        .th,
        td {
            padding: 5px;
            text-align: center;
        }

        .header table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .perihal {
            margin: 1px 0;
        }

        .content {
            text-align: center;
            /* margin-top: 1px; */
        }

        .contentisi {
            text-align: left;
            margin-left: 50px;
        }

        .contentisi strong {
            display: inline-block;
            width: 200px;
            /* margin-top: 2px;
            margin-bottom: 2px; */
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .content th,
        .content td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
            position: relative;
            font-size: 11px;
        }

        .signature {
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
        }

        .signature table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        .signature tr,
        .signature td {
            text-align: center;
            border: none;
        }

        @media print {
            @page {
                margin: 5mm;
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
            <table>
                <tr>
                    <th style="font-size: 30px; border: 1px solid black;">RW 07</th>
                    <th>RUKUN TETANGGA 08 RUKUN WARGA 07<br>KELURAHAN MOJOLANGU<br>KECAMATAN LOWOKWARU</th>
                    <th style="font-size: 30px; border: 1px solid black;">RT 08</th>
                </tr>
            </table>
        </div>

        <div class="perihal">
            <p>
                Kepada Yth<br>
                Kepala Kelurahan Mojolangu<br>
                Kecamatan Lowokwaru Kota Malang<br>
                Di Tempat
            </p>
        </div>

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
                    <th>1. SKU/SKDU</th>
                    <th>2. BORO KERJA</th>
                    <th class="checked">3. SKTM</th>
                    <th>4. IJIN KERAMAIAN</th>
                    <th>5. IMB/SPPL</th>
                </tr>
                <tr>
                    <td>SYARAT-SYARATNYA:<br>Fc. KTP pemohon 1x<br>FC Kartu Keluarga 1x</td>
                    <td>SYARAT-SYARATNYA:<br>Fc. KK+KTP pemohon 1x<br>... (daftar berlanjut)</td>
                    <td>SYARAT-SYARATNYA:<br>Fc. Kartu Keluarga 1x<br>Fc. E-KTP 1x</td>
                    <td>SYARAT-SYARATNYA:<br>Fc. E-KTP 1x<br>... (daftar berlanjut)</td>
                    <td>SYARAT-SYARATNYA:<br>Fc. Sertifikat tanah 1x<br>... (daftar berlanjut)</td>
                </tr>
            </table>
            <p style="text-align: justify;">Demikian surat pengantar ini kami sampaikan untuk diketahui, atas bantuan
                dan kerjasama yang baik diucapkan terimakasih.</p>
            <div class="signature">
                <p style="text-align: justify;">Malang,..................20..</p>
                <table>
                    <tr>
                        <td>
                            <p>Ketua RW.07</p><br>
                            <p>Mulyani, S.Pd</p>
                        </td>
                        <td>
                            <p>Ketua RT.08</p><br>
                            <p>Suwadi</p>
                        </td>
                        <td>
                            <p>Pemohon</p><br>
                            <p>{{ $data->nama_lengkap }}</p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>