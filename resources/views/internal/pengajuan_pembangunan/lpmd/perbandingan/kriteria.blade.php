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
                                        $kriteriaValues = [
                                            'Manfaat Sosial' => 9,
                                            'Urgensi Proyek' => 8,
                                            'Biaya Proyek' => 6,
                                            'Dampak Ekonomi' => 6,
                                            'Ketersediaan SDM' => 4,
                                            'Keberlanjutan Manfaat' => 7,
                                            'Kesiapan Infrastruktur' => 5,
                                            'Dukungan Masyarakat' => 3,
                                            'Efisiensi Waktu' => 3,
                                            'Risiko Proyek' => 4,
                                        ];
                                    @endphp
                                    @foreach ($comparisons as $index => $comparison)
                                        @php
                                            $k1Value = $kriteriaValues[$comparison['kriteria1']->nama_kriteria] ?? 0;
                                            $k2Value = $kriteriaValues[$comparison['kriteria2']->nama_kriteria] ?? 0;
                                            $k1Value = $kriteriaValues[$comparison['kriteria1']->nama_kriteria] ?? 0;
                                            $k2Value = $kriteriaValues[$comparison['kriteria2']->nama_kriteria] ?? 0;

                                            if ($k1Value > $k2Value) {
                                                // Kriteria 1 lebih penting dari Kriteria 2
                                                $selectedValue = $k1Value - $k2Value + 1; // Skala 1-9
                                            } elseif ($k1Value < $k2Value) {
                                                // Kriteria 2 lebih penting dari Kriteria 1
                                                $selectedValue = 9 - ($k2Value - $k1Value); // Skala 1-9 terbalik
                                            } else {
                                                // Jika sama penting
                                                $selectedValue = 1;
                                            }

                                            // Pastikan nilai berada dalam rentang 1-9
                                            $selectedValue = max(1, min($selectedValue, 9));
                                        @endphp
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $comparison['kriteria1']->nama_kriteria }}</td>
                                            <td>{{ $comparison['kriteria2']->nama_kriteria }}</td>
                                            <td>
                                                <select
                                                    name="comparisons[{{ $comparison['kriteria1']->id }}_{{ $comparison['kriteria2']->id }}]"
                                                    class="form-select nilai-perbandingan select-small" disabled required>
                                                    @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $value)
                                                        <option value="{{ $value }}"
                                                            {{ $value == $selectedValue ? 'selected' : '' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
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

            // Pastikan semua select aktif sebelum form submit
            submitBtn.addEventListener('click', function(event) {
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
