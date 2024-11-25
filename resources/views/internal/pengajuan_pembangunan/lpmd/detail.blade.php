@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Detail Perangkingan Pembangunan</h5>
                    <p><strong>Nama Petugas:</strong> {{ $data->input_nama ?? 'N/A' }}</p>
                    <p><strong>Status:</strong>
                        @if ($data->status === 'final')
                            <span class="badge badge-success">Dikirim Ke Lurah</span>
                        @else
                            <span class="badge badge-warning">Sedang Diproses</span>
                        @endif
                    </p>

                    <div>
                        <canvas id="chartContainer" style="height: 400px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Ambil data JSON dari server
            const finalScores = @json($finalScores);

            // Debugging untuk memastikan data ada
            console.log("Final Scores Data:", finalScores);

            // Pastikan data tidak kosong
            if (finalScores && finalScores.length > 0) {
                // Urutkan data berdasarkan score (nilai tertinggi di atas)
                const sortedScores = finalScores.sort((a, b) => b.score - a.score);

                // Ambil label dan data untuk chart
                const labels = sortedScores.map(score => score.alternatif);
                const data = sortedScores.map(score => score.score);

                // Cari elemen canvas
                const ctx = document.getElementById('chartContainer');
                if (!ctx) {
                    console.error("Canvas element with ID 'chartContainer' tidak ditemukan.");
                    return;
                }

                // Inisialisasi Chart.js
                new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Skor Akhir',
                            data: data,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        indexAxis: 'y', // Membuat bar chart horizontal
                        scales: {
                            x: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                display: false // Sembunyikan legenda jika tidak diperlukan
                            }
                        }
                    }
                });
            } else {
                console.error("Data finalScores kosong atau tidak valid.");
            }
        });
    </script>
@endsection
