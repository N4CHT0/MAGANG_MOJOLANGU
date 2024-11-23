@extends('layouts.main')
@section('content')
    <div class="row">
        @foreach ($dataPerbandinganAlternatif as $kriteriaId => $data)
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h4>Perbandingan Alternatif Berdasarkan Kriteria: {{ $kriteria->find($kriteriaId)->nama_kriteria }}
                        </h4>

                        <!-- Matriks Awal -->
                        <h5 class="mt-3">Matriks Awal</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Alternatif</th>
                                        @foreach ($alternatif as $alt)
                                            <th>{{ $alt->nama }}</th>
                                        @endforeach
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alternatif as $a1)
                                        <tr>
                                            <td>{{ $a1->nama }}</td>
                                            @foreach ($alternatif as $a2)
                                                <td>{{ number_format($data['matrix'][$a1->id][$a2->id], 3) }}</td>
                                            @endforeach
                                            <td>{{ number_format(array_sum($data['matrix'][$a1->id]), 3) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Matriks Normalisasi -->
                        <h5 class="mt-3">Matriks Normalisasi</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Alternatif</th>
                                        @foreach ($alternatif as $alt)
                                            <th>{{ $alt->nama }}</th>
                                        @endforeach
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alternatif as $a1)
                                        <tr>
                                            <td>{{ $a1->nama }}</td>
                                            @foreach ($alternatif as $a2)
                                                <td>{{ number_format($data['normalizedMatrix'][$a1->id][$a2->id], 3) }}</td>
                                            @endforeach
                                            <td>{{ number_format(array_sum($data['normalizedMatrix'][$a1->id]), 3) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Tabel Hasil Normalisasi Matriks Alternatif -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4>Hasil Normalisasi Matriks Alternatif</h4>
                    <p>Total Masing-Masing Baris Kolom akan dibagi sejumlah kolom tersebut.</p>
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
                                @foreach ($alternatif as $alt)
                                    <tr>
                                        <td>{{ $alt->nama }}</td>
                                        @foreach ($kriteria as $krit)
                                            <td>{{ number_format($finalNormalizedMatrix[$alt->id][$krit->id] ?? 0, 3) }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <a href="{{ route('hasil.prioritas') }}" class="btn btn-success">
                Lanjutkan Perhitungan
            </a>
        </div>

    </div>
@endsection


<style>
    .table {
        text-align: center;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .table-primary {
        background-color: #007bff;
        color: white;
    }
</style>
