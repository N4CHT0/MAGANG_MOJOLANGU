@extends('layouts.main')

@section('content')
    <div class="row">
        <!-- Tampilkan Peringkat Tertinggi -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4>Prioritas Tertinggi</h4>
                    <p>Alternatif dengan prioritas tertinggi adalah <strong>{{ $topPriority['alternatif'] }}</strong> dengan
                        skor <strong>{{ $topPriority['score'] }}</strong></p>
                </div>
            </div>
        </div>

        <!-- Tabel Skor Akhir Semua Alternatif -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4>Tabel Prioritas Semua Alternatif</h4>
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
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
                </div>
            </div>
        </div>

        <!-- Tabel Matriks Perkalian -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4>Tabel Matriks Perkalian</h4>
                    <table class="table table-bordered table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>Alternatif</th>
                                <th>A1 (Jalan)</th>
                                <th>A2 (Gorong-gorong)</th>
                                <th>A3 (Jembatan)</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($matrixData as $row)
                                <tr>
                                    <td>{{ $row['alternatif'] }}</td>
                                    <td>{{ $row[0] }}</td>
                                    <td>{{ $row[1] }}</td>
                                    <td>{{ $row[2] }}</td>
                                    <td>{{ $row['total'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Button untuk Submit dan Menyimpan PDF -->
        <div class="col-12 mt-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#savePdfModal">
                Simpan sebagai PDF
            </button>
        </div>
    </div>

    <!-- Modal untuk Input Nama -->
    <div class="modal fade" id="savePdfModal" tabindex="-1" aria-labelledby="savePdfModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('save-ranking-pdf') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="savePdfModalLabel">Masukkan Nama untuk Laporan PDF</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputNama">Nama</label>
                            <input type="text" class="form-control" id="inputNama" name="input_nama" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="pdfName">Nama File PDF</label>
                            <input type="text" class="form-control" id="pdfName" name="file_pdf" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
