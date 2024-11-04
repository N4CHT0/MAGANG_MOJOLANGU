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
                                    @php $no = 1; @endphp
                                    @foreach ($kriteria as $k)
                                        <tr>
                                            <td colspan="3" class="text-center font-weight-bold bg-light">
                                                Perbandingan Alternatif untuk Kriteria: {{ $k->nama_kriteria }}
                                            </td>
                                        </tr>
                                        @foreach ($alternatif as $a1)
                                            @foreach ($alternatif as $a2)
                                                @if ($a1->id < $a2->id)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>
                                                            <label class="radio-label">
                                                                <input type="radio"
                                                                    name="comparisons[{{ $k->id }}][{{ $a1->id }}_{{ $a2->id }}]"
                                                                    value="1" required>
                                                                <span>{{ $a1->nama }}</span>
                                                            </label>
                                                            <label class="radio-label">
                                                                <input type="radio"
                                                                    name="comparisons[{{ $k->id }}][{{ $a1->id }}_{{ $a2->id }}]"
                                                                    value="0">
                                                                <span>{{ $a2->nama }}</span>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <select
                                                                name="values[{{ $k->id }}][{{ $a1->id }}_{{ $a2->id }}]"
                                                                class="form-control select-small nilai-perbandingan"
                                                                required>
                                                                <option value="1">1 (Sama penting)</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                                <option value="8">8</option>
                                                                <option value="9">9 (Mutlak lebih penting)</option>
                                                                <option value="0.5">1/2</option>
                                                                <option value="0.3333333333333333">1/3</option>
                                                                <option value="0.25">1/4</option>
                                                                <option value="0.2">1/5</option>
                                                                <option value="0.1666666666666667">1/6</option>
                                                                <option value="0.1428571428571429">1/7</option>
                                                                <option value="0.125">1/8</option>
                                                                <option value="0.1111111111111111">1/9</option>
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
                // Toggle enable/disable semua select
                nilaiPerbandingan.forEach(select => {
                    select.disabled = !select.disabled;
                });
            });

            // Pastikan semua select aktif sebelum form submit
            submitBtn.addEventListener('click', function(event) {
                // Aktifkan semua select sebelum submit
                nilaiPerbandingan.forEach(select => {
                    select.disabled = false;
                });

                // Pastikan semua radio yang di-disable oleh "sama penting" tidak memiliki atribut required
                document.querySelectorAll('.nilai-perbandingan').forEach(select => {
                    const radioInputs = select.closest('tr').querySelectorAll(
                    'input[type="radio"]');
                    if (select.value == '1') {
                        radioInputs.forEach(radio => {
                            radio.disabled = true;
                            radio.required = false;
                            radio.checked = false;
                        });
                    } else {
                        radioInputs.forEach(radio => {
                            radio.disabled = false;
                            radio.required = true;
                        });
                    }
                });
            });

            // Tambahan: Disable radio jika nilai sama penting (1) dipilih
            nilaiPerbandingan.forEach(select => {
                select.addEventListener('change', function() {
                    const radioInputs = select.closest('tr').querySelectorAll(
                    'input[type="radio"]');
                    if (select.value == '1') {
                        // Disable radio buttons and remove required attribute
                        radioInputs.forEach(radio => {
                            radio.disabled = true;
                            radio.required = false;
                            radio.checked = false; // Uncheck radio
                        });
                    } else {
                        // Enable radio buttons and set required attribute
                        radioInputs.forEach(radio => {
                            radio.disabled = false;
                            radio.required = true;
                        });
                    }
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

        /* Style untuk radio label */
        .radio-label {
            display: inline-block;
            padding: 5px 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        /* Hilangkan style asli radio dan tambahkan custom */
        .radio-label input[type="radio"] {
            display: none;
        }

        /* Style jika radio button aktif */
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
