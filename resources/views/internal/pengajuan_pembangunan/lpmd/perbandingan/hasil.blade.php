@extends('layouts.main')
@section('content')
    <div class="row">
        <!-- Matriks Perbandingan Berpasangan -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4>Matriks Perbandingan Berpasangan</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Kriteria</th>
                                    @foreach ($kriteria as $krit)
                                        <th>{{ $krit->nama_kriteria }}</th>
                                    @endforeach
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($matrix as $i => $row)
                                    <tr>
                                        <td>{{ $kriteria[$i]->nama_kriteria }}</td>
                                        @foreach ($row as $value)
                                            <td>{{ $value }}</td>
                                        @endforeach
                                        <td>{{ array_sum($row) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>Jumlah</td>
                                    @foreach ($columnSums as $sum)
                                        <td>{{ round($sum, 4) }}</td>
                                    @endforeach
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Matriks Nilai Kriteria dan Priority Vector -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4>Matriks Nilai Kriteria</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Kriteria</th>
                                    @foreach ($kriteria as $krit)
                                        <th>{{ $krit->nama_kriteria }}</th>
                                    @endforeach
                                    <th>Jumlah</th>
                                    <th>Priority Vector</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($matrix as $i => $row)
                                    <tr>
                                        <td>{{ $kriteria[$i]->nama_kriteria }}</td>
                                        @foreach ($row as $value)
                                            <td>{{ $value }}</td>
                                        @endforeach
                                        <td>{{ round(array_sum($row), 4) }}</td>
                                        <td>{{ $priorityVector[$i] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Konsistensi Result Card -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4>Hasil Konsistensi</h4>
                    <p><strong>Principle Eigen Vector (λ maks):</strong> {{ round($lambdaMax, 4) }}</p>
                    <p><strong>Consistency Index (CI):</strong> {{ round($consistencyIndex, 4) }}</p>
                    <p><strong>Consistency Ratio (CR):</strong> {{ round($consistencyRatio * 100, 2) }}%</p>
                </div>
            </div>
        </div>
    </div>
@endsection
