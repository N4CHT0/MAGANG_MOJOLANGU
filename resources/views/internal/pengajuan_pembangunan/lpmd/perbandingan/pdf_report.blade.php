<!DOCTYPE html>
<html>

<head>
    <title>Laporan Perangkingan Pembangunan</title>
</head>

<body>
    <h1>Laporan Perangkingan</h1>
    <p>Nama: {{ $inputNama }}</p>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Alternatif</th>
                <th>Skor Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($finalScores as $score)
                <tr>
                    <td>{{ $score['alternatif'] }}</td>
                    <td>{{ $score['score'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
