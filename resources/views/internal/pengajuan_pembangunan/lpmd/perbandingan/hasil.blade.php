@extends('layouts.main')
@section('content')
    <div class="row">
        <!-- Matriks Awal Sebelum Normalisasi -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4>Matriks Awal Sebelum Normalisasi</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Kriteria</th>
                                    @foreach ($kriteria as $krit)
                                        <th>{{ $krit->nama_kriteria }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($initialMatrix as $i => $row)
                                    <tr>
                                        <td>{{ $kriteria[$i]->nama_kriteria }}</td>
                                        @foreach ($row as $value)
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Matriks Perbandingan Berpasangan (Setelah Normalisasi) -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4>Matriks Perbandingan Berpasangan (Setelah Normalisasi)</h4>
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
                    <h4>Matriks Nilai Kriteria dan Priority Vector</h4>
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
                    <p><strong>Consistency Index (CI):</strong>
                        {{ round($consistencyIndex, 4) }}
                        {{-- ({{ round($consistencyIndex * 100, 2) }}%) --}}
                    </p>
                    <p><strong>Consistency Ratio (CR):</strong>
                        {{ round($consistencyRatio, 4) }}
                        {{-- ({{ round($consistencyRatio * 100, 2) }}%) --}}
                    </p>

                    @if (round($consistencyRatio * 100, 2) < 0)
                        <p><strong style="color: green;">Hasil perhitungan bisa dinyatakan benar</strong></p>
                    @else
                        <p><strong style="color: red;">Penilaian data harus diperbaiki lagi</strong></p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <a href="{{ route('nilai.perbandingan') }}" class="btn btn-primary">
                Lanjutkan Perhitungan
            </a>
        </div>
    </div>
@endsection
