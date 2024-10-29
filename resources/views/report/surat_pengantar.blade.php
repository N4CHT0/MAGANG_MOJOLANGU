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
            font-size: 13px;
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
                    <th style="font-size: 30px; border: 1px solid black;">RW 0{{ $data->rw }}</th>
                    <th>RUKUN TETANGGA {{ $data->rt }} RUKUN WARGA 0{{ $data->rw }}<br>KELURAHAN
                        MOJOLANGU<br>KECAMATAN LOWOKWARU
                    </th>
                    <th style="font-size: 30px; border: 1px solid black;">RT 0{{ $data->rt }}</th>
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
                <strong>Jenis Kelamin</strong>:{{ $data->jenis_kelamin }}<br>
                <strong>NIK/NO. KTP</strong>: {{ $data->nik }}<br>
                <strong>Alamat</strong>: {{ $data->alamat }}<br>
                <strong>Keperluan Untuk</strong>:
                Beri Tanda <input type="checkbox" checked> pada kotak yang diperlukan
            </p>
            <table>
                <tr>
                    <th><input type="checkbox"
                            {{ in_array('SKU/SKDU', explode(', ', $user->current_service)) ? 'checked' : '' }}> 1.
                        SKU/SKDU</th>
                    <th><input type="checkbox"
                            {{ in_array('BORO KERJA', explode(', ', $user->current_service)) ? 'checked' : '' }}> 2.
                        BORO KERJA</th>
                    <th><input type="checkbox"
                            {{ in_array('SKTM', explode(', ', $user->current_service)) ? 'checked' : '' }}> 3. SKTM
                    </th>
                    <th><input type="checkbox"
                            {{ in_array('IJIN KERAMAIAN', explode(', ', $user->current_service)) ? 'checked' : '' }}>
                        4. IJIN KERAMAIAN</th>
                    <th><input type="checkbox"
                            {{ in_array('IMB/SPPL', explode(', ', $user->current_service)) ? 'checked' : '' }}> 5.
                        IMB/SPPL</th>
                </tr>
                <tr>
                    <td>
                        SYARAT-SYARATNYA:<br>
                        Fc. KK + KTP pemohon 1x<br>
                        Fc. Akta pendirian PT/CV bagi yang sudah terbentuk PT/CV 1x<br>
                        Fc. Lunas PBB tahun ini 1x<br>
                        Fc. Surat perjanjian sewa jika tempat usahanya sewa 1x<br>
                        Fc. Foto tempat usaha 1x<br>
                        Fc. Nomor Induk Berusaha 1 lbr
                    </td>
                    <td>
                        SYARAT-SYARATNYA:<br>
                        Fc. KK+KTP pemohon 1x<br>
                        Fc. berwarna ukuran 4x6 = 3 lbr
                    </td>
                    <td>
                        SYARAT-SYARATNYA:<br>
                        Fc. Kartu Keluarga 1x<br>
                        Fc. E-KTP 1x
                    </td>
                    <td>
                        SYARAT-SYARATNYA:<br>
                        Fc. Kartu Keluarga 1x<br>
                        Fc. E-KTP 1x<br>
                        Pelunasan PBB
                    </td>
                    <td>
                        SYARAT-SYARATNYA:<br>
                        Fc. Kartu Keluarga 1x<br>
                        Fc. E-KTP 1x<br>
                        Fc. Sertifikat tanah 1x<br>
                        Fc. Lunas PBB tahun ini 1x<br>
                        Asli + copy blanko isian dari dinas perijinan 1x<br>
                        Fc. KKPR 1x<br>
                        Fc. Nomor Induk Berusaha 1 lbr
                    </td>
                </tr>
            </table>
            <p style="text-align: justify;">Demikian surat pengantar ini kami sampaikan untuk diketahui, atas bantuan
                dan kerjasama yang baik diucapkan terimakasih.</p>
            <div class="signature">
                <p>Malang, {{ \Carbon\Carbon::parse($data->waktu_validasi)->translatedFormat('d F Y') }}</p>
                <table>
                    <tr>
                        <td>
                            <p>Ketua RW.0{{ $data->rw }}</p><br>
                            <p>{{ $ketuaRW ? $ketuaRW->nama_lengkap : 'Nama Ketua RW Tidak Ditemukan' }}</p>
                            <!-- Tampilkan nama Ketua RW -->
                        </td>
                        <td>
                            <p>Ketua RT.0{{ $data->rt }}</p><br>
                            <p>{{ $ketuaRT ? $ketuaRT->nama_lengkap : 'Nama Ketua RT Tidak Ditemukan' }}</p>
                            <!-- Tampilkan nama Ketua RT -->
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
