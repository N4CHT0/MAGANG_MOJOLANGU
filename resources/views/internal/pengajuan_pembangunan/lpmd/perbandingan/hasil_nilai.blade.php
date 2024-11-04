@extends('layouts.main')
@section('content')
    <div class="row">
        @foreach ($dataPerbandinganAlternatif as $kriteriaId => $data)
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h4>Perbandingan Alternatif Berdasarkan Kriteria: {{ $kriteria->find($kriteriaId)->nama_kriteria }}
                        </h4>

                        <!-- Matriks Awal (Sebelum Normalisasi) -->
                        <h5>Matriks Awal (Sebelum Normalisasi)</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Alternatif</th>
                                        @foreach ($alternatif as $alt)
                                            <th>{{ $alt->nama }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['matrix'] as $a1 => $row)
                                        <tr>
                                            <td>{{ $alternatif->find($a1)->nama }}</td>
                                            @foreach ($row as $a2 => $value)
                                                <td>{{ $value }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        @foreach ($data['columnSums'] as $sum)
                                            <th>{{ $sum }}</th>
                                        @endforeach
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Matriks Normalisasi -->
                        <h5>Matriks Setelah Normalisasi</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Alternatif</th>
                                        @foreach ($alternatif as $alt)
                                            <th>{{ $alt->nama }}</th>
                                        @endforeach
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['normalizedMatrix'] as $a1 => $row)
                                        <tr>
                                            <td>{{ $alternatif->find($a1)->nama }}</td>
                                            @foreach ($row as $a2 => $value)
                                                <td>{{ $value }}</td>
                                            @endforeach
                                            <td>{{ array_sum($row) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Priority Vector (Bobot Alternatif) -->
                        <h5>Priority Vector (Bobot Alternatif)</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Alternatif</th>
                                    <th>Priority Vector</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['priorityVector'] as $altId => $priority)
                                    <tr>
                                        <td>{{ $alternatif->find($altId)->nama }}</td>
                                        <td>{{ $priority }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Tampilkan tabel normalisasi alternatif akhir -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>Alternatif</th>
                        @foreach ($kriteria as $krit)
                            <th>{{ $krit->nama_kriteria }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($finalNormalizedResults as $altId => $resultRow)
                        <tr>
                            <td>{{ $alternatif->find($altId)->nama }}</td>
                            @foreach ($kriteria as $krit)
                                <td>{{ $resultRow[$krit->id] ?? '-' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
@endsection
