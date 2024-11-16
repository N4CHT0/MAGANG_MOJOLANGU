@extends('layouts.main')
@section('content')
    <div class="container">
        <form action="{{ route('pembangunan.approveValidasi') }}" method="POST" id="approveForm">
            @csrf
            <div class="row">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Pembangunan</th>
                                    <th>Pengusul</th>
                                    <th>Kategori</th>
                                    <th class="text-center align-middle">
                                        <div class="custom-checkbox">
                                            <input type="checkbox" id="selectAll" class="form-check-input custom-input">
                                            <label for="selectAll" class="custom-label">Pilih Semua</label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembangunan as $data)
                                    <tr>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->pengusul }}</td>
                                        <td>{{ $data->kategori }}</td>
                                        <td>
                                            <div class="custom-checkbox">
                                                <input type="checkbox" class="form-check-input custom-input"
                                                    id="checkbox{{ $data->id }}" name="selected[]"
                                                    value="{{ $data->id }}" data-nama="{{ $data->nama }}"
                                                    data-pengusul="{{ $data->pengusul }}"
                                                    data-kategori="{{ $data->kategori }}">
                                                <label for="checkbox{{ $data->id }}" class="custom-label"></label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <button type="submit" class="btn btn-success">Validasi</button>
                <button type="button" class="btn btn-danger" id="tolakButton" data-bs-toggle="modal"
                    data-bs-target="#rejectModal">Tolak</button>
            </div>
        </form>

        <!-- Modal untuk Tolak -->
        <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <form action="{{ route('pembangunan.rejectValidasi') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tolak Validasi</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Pembangunan</th>
                                        <th>Pengusul</th>
                                        <th>Kategori</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="rejectTableBody">
                                    <!-- Data yang dicentang akan dimasukkan di sini -->
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Tolak Validasi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi Pilih Semua
            document.getElementById('selectAll').addEventListener('change', function() {
                var checkboxes = document.querySelectorAll('input.form-check-input:not(#selectAll)');
                for (var checkbox of checkboxes) {
                    checkbox.checked = this.checked;
                }
            });
        });

        // Menampilkan hanya data yang dicentang di modal
        document.getElementById('tolakButton').onclick = function() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"].form-check-input:checked');
            var rejectTableBody = document.getElementById('rejectTableBody');
            rejectTableBody.innerHTML = ''; // Kosongkan tabel modal

            // Loop melalui checkbox yang dicentang dan tambahkan ke tabel modal
            checkboxes.forEach(function(checkbox) {
                var nama = checkbox.getAttribute('data-nama');
                var pengusul = checkbox.getAttribute('data-pengusul');
                var kategori = checkbox.getAttribute('data-kategori');

                // Buat baris baru di tabel modal
                var row = `
                    <tr>
                        <td>${nama}</td>
                        <td>${pengusul}</td>
                        <td>${kategori}</td>
                        <td>
                            <input type="text" name="keterangan[${checkbox.value}]" placeholder="Alasan penolakan">
                        </td>
                        <input type="hidden" name="selected[]" value="${checkbox.value}">
                    </tr>
                `;
                rejectTableBody.insertAdjacentHTML('beforeend', row);
            });
        }
    </script>
@endsection
