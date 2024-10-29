@extends('layouts.main')
@section('content')
    <div class="row">
        <!-- Card Perbandingan Berpasangan Kriteria -->
        <div class="col-12 mt-3" id="perbandinganCard">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <p>Perbandingan Berpasangan Kriteria</p>
                    </div>
                    <p>Membandingkan kriteria secara berpasangan. Perbandingan dilakukan dengan skala 1-9, di mana:</p>
                    <ul>
                        <li>1: Kedua elemen sama penting.</li>
                        <li>3: Elemen satu sedikit lebih penting.</li>
                        <li>5: Elemen satu lebih penting.</li>
                        <li>7: Elemen satu jelas lebih penting.</li>
                        <li>9: Elemen satu mutlak lebih penting.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Form untuk Data Kriteria -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <p>Data Kriteria</p>
                    </div>
                    <div class="table-responsive">
                        <!-- Tambahkan Form dan Aksi -->
                        <form action="{{ route('compare.submit') }}" method="POST">
                            @csrf
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Kriteria 1</th>
                                        <th>Kriteria 2</th>
                                        <th>Nilai Perbandingan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($comparisons as $index => $comparison)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $comparison['kriteria1']->nama_kriteria }}</td>
                                            <td>{{ $comparison['kriteria2']->nama_kriteria }}</td>
                                            <td>
                                                <select
                                                    name="comparisons[{{ $comparison['kriteria1']->id }}_{{ $comparison['kriteria2']->id }}]"
                                                    class="form-select nilai-perbandingan select-small" disabled required>
                                                    <option value="1">1</option>
                                                    <option value="3">3</option>
                                                    <option value="5">5</option>
                                                    <option value="7">7</option>
                                                    <option value="9">9</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Card Submit Data -->
                            <div class="mt-3">
                                <button type="button" class="btn btn-warning" id="editAllBtn">Edit Semua</button>
                                <button type="submit" class="btn btn-success" id="submitBtn">Submit Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editAllButton = document.getElementById('editAllBtn');
            const nilaiPerbandingan = document.querySelectorAll('.nilai-perbandingan');
            const submitBtn = document.getElementById('submitBtn');

            // Saat pertama kali load, semua select akan disabled
            nilaiPerbandingan.forEach(select => {
                select.disabled = true;
            });

            editAllButton.addEventListener('click', function() {
                // Aktifkan semua select
                nilaiPerbandingan.forEach(select => {
                    select.disabled = false;
                });
            });

            // Aktifkan semua select sebelum form submit
            submitBtn.addEventListener('click', function() {
                nilaiPerbandingan.forEach(select => {
                    select.disabled = false;
                });
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        /* CSS tambahan untuk membuat select lebih kecil */
        .select-small {
            width: 80px;
            /* Sesuaikan ukuran select agar tidak terlalu panjang */
        }
    </style>
@endsection
