@extends('layouts.main')

@section('content')
    <div class="container my-4">
        <div class="row">
            <!-- Card 1: Perbandingan Kriteria -->
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <i class="fa fa-balance-scale fa-3x text-primary mb-3"></i>
                        <h5 class="card-title">Perbandingan Kriteria</h5>
                        <p class="card-text">Lakukan perbandingan kriteria untuk menentukan bobot prioritas.</p>
                        <a href="{{ route('kriteria.perbandingan') }}" class="btn btn-primary">
                            Pergi ke Perbandingan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 2: Perbandingan Alternatif -->
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <i class="fa fa-tasks fa-3x text-success mb-3"></i>
                        <h5 class="card-title">Perbandingan Alternatif</h5>
                        <p class="card-text">Bandingkan alternatif berdasarkan kriteria yang ditentukan.</p>
                        <a href="{{ route('nilai.perbandingan') }}" class="btn btn-success">
                            Pergi ke Perbandingan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 3: Hasil Proses -->
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <i class="fa fa-line-chart fa-3x text-warning mb-3"></i>
                        <h5 class="card-title">Hasil Proses</h5>
                        <p class="card-text">Lihat hasil akhir dari perhitungan prioritas yang dilakukan.</p>
                        <a href="{{ route('hasil.prioritas') }}" class="btn btn-warning">
                            Pergi ke Hasil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <style>
        .card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection
