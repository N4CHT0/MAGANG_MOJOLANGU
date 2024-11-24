@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-12 mt-3" id="perbandinganCard">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <p>Perbandingan Alternatif Berdasarkan Kriteria</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form untuk Data Kriteria -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <p>Data Alternatif</p>
                    </div>
                    <div class="table-responsive">
                        <form action="{{ route('nilai.submit') }}" method="POST">
                            @csrf
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Pilih yang Lebih Penting</th>
                                        <th>Nilai Perbandingan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                        $kategoriValues = [
                                            'Jalan' => 9,
                                            'Irigasi' => 5,
                                            'Taman' => 4,
                                            'Gorong - Gorong' => 7,
                                            'Jembatan' => 6,
                                            'Renovasi' => 3,
                                            'Pengadaan Barang' => 2,
                                            'Fasilitas Kesehatan' => 8,
                                            'Fasilitas Olahraga' => 4,
                                            'Pembangunan Lainnya' => 1,
                                        ];
                                    @endphp
                                    @foreach ($kriteria as $k)
                                        <tr>
                                            <td colspan="3" class="text-center font-weight-bold bg-light">
                                                Perbandingan Alternatif untuk Kriteria: {{ $k->nama_kriteria }}
                                            </td>
                                        </tr>
                                        @foreach ($alternatif as $a1)
                                            @foreach ($alternatif as $a2)
                                                @if ($a1->id < $a2->id)
                                                    @php
                                                        $a1Kategori = $kategoriValues[$a1->kategori] ?? 0;
                                                        $a2Kategori = $kategoriValues[$a2->kategori] ?? 0;

                                                        // Tentukan nilai perbandingan dengan memilih nilai kategori yang lebih besar
                                                        $selectedValue = max($a1Kategori, $a2Kategori);

                                                        // Tentukan mana yang lebih penting
                                                        $isA1Higher = $a1Kategori >= $a2Kategori;
                                                    @endphp

                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>
                                                            <label class="radio-label">
                                                                <input type="radio"
                                                                    name="comparisons[{{ $k->id }}][{{ $a1->id }}_{{ $a2->id }}]"
                                                                    value="1" {{ $isA1Higher ? 'checked' : '' }}
                                                                    required>
                                                                <span>{{ $a1->nama }}</span>
                                                            </label>
                                                            <label class="radio-label">
                                                                <input type="radio"
                                                                    name="comparisons[{{ $k->id }}][{{ $a1->id }}_{{ $a2->id }}]"
                                                                    value="0" {{ !$isA1Higher ? 'checked' : '' }}>
                                                                <span>{{ $a2->nama }}</span>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <select
                                                                name="values[{{ $k->id }}][{{ $a1->id }}_{{ $a2->id }}]"
                                                                class="form-control select-small nilai-perbandingan"
                                                                required>
                                                                <option value="" disabled>Pilih nilai</option>
                                                                @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $value)
                                                                    <option value="{{ $value }}"
                                                                        {{ $value == $selectedValue ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
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

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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

            // Tombol untuk edit semua select
            editAllButton.addEventListener('click', function() {
                nilaiPerbandingan.forEach(select => {
                    select.disabled = !select.disabled;
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
        .select-small {
            width: 80px;
        }

        .radio-label {
            display: inline-block;
            padding: 5px 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .radio-label input[type="radio"] {
            display: none;
        }

        .radio-label input[type="radio"]:checked+span {
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            padding: 5px 10px;
        }

        .radio-label span {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
@endsection
