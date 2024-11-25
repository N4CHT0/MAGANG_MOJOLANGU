@extends('layouts.main')
@section('content')
    <div class="container my-4">
        <!-- Form untuk Validasi -->
        <form action="{{ route('pembangunan.approve') }}" method="POST" id="approveForm">
            @csrf

            <!-- Card Tabel Pembangunan -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0" style="color: white">Daftar Pembangunan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th class="align-middle">Nama Pembangunan</th>
                                    <th class="align-middle">Pengusul</th>
                                    <th class="align-middle">Kategori</th>
                                    <th class="align-middle">
                                        <div class="form-check">
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                            <label for="selectAll" class="form-check-label">Pilih Semua</label>
                                        </div>
                                    </th>
                                    <th class="align-middle">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembangunan as $data)
                                    <tr>
                                        <td class="align-middle">{{ $data->nama }}</td>
                                        <td class="align-middle">{{ $data->pengusul }}</td>
                                        <td class="align-middle">{{ $data->kategori }}</td>
                                        <td class="text-center align-middle">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="checkbox{{ $data->id }}" name="selected[]"
                                                    value="{{ $data->id }}" data-nama="{{ $data->nama }}"
                                                    data-pengusul="{{ $data->pengusul }}"
                                                    data-kategori="{{ $data->kategori }}">
                                                <label for="checkbox{{ $data->id }}" class="form-check-label"></label>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <button class="btn btn-info btn-sm detail-button" data-id="{{ $data->id }}"
                                                data-bs-toggle="modal" data-bs-target="#detailModal" type="button">
                                                <i class="fas fa-info-circle"></i> Detail
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-end gap-3">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i> Setuju
                </button>
                <button type="button" class="btn btn-danger" id="tolakButton" data-bs-toggle="modal"
                    data-bs-target="#rejectModal">
                    <i class="fas fa-times"></i> Tolak
                </button>
            </div>
        </form>

        <!-- Modal untuk Detail -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">Detail Pengajuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="detailContent">
                            <p class="text-center">Memuat data...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk Tolak -->
        <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="{{ route('pembangunan.reject') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectModalLabel">Tolak Usulan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
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
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times"></i> Tolak Usulan
                            </button>
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
            // Pilih Semua Checkbox
            document.getElementById('selectAll').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('input.form-check-input:not(#selectAll)');
                checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            });

            // Tombol Tolak: Tampilkan Data di Modal
            document.getElementById('tolakButton').addEventListener('click', function() {
                const checkboxes = document.querySelectorAll(
                    'input[type="checkbox"].form-check-input:checked');
                const rejectTableBody = document.getElementById('rejectTableBody');
                rejectTableBody.innerHTML = ''; // Kosongkan tabel modal

                checkboxes.forEach(function(checkbox) {
                    if (checkbox.id !== 'selectAll') {
                        const nama = checkbox.dataset.nama;
                        const pengusul = checkbox.dataset.pengusul;
                        const kategori = checkbox.dataset.kategori;

                        // Tambahkan baris ke tabel modal
                        rejectTableBody.insertAdjacentHTML('beforeend', `
                            <tr>
                                <td>${nama}</td>
                                <td>${pengusul}</td>
                                <td>${kategori}</td>
                                <td>
                                    <input type="text" name="keterangan[${checkbox.value}]"
                                           class="form-control" placeholder="Alasan penolakan">
                                </td>
                                <input type="hidden" name="selected[]" value="${checkbox.value}">
                            </tr>
                        `);
                    }
                });
            });

            // Tombol Detail: Tampilkan Data di Modal
            document.querySelectorAll('.detail-button').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const detailContent = document.getElementById('detailContent');

                    detailContent.innerHTML = '<p class="text-center">Memuat data...</p>';

                    fetch(`/verifikasi-riwayat-rw/${id}`)
                        .then(response => response.json())
                        .then(data => {
                            const dokumentasi = Array.isArray(data.dokumentasi) ? data
                                .dokumentasi : [];
                            detailContent.innerHTML = `
                                <p><strong>Nama Pembangunan:</strong> ${data.nama}</p>
                                <p><strong>Status:</strong> ${data.status}</p>
                                <p><strong>Tanggal Pengajuan:</strong> ${data.tanggal_pengajuan}</p>
                                <p><strong>Keterangan:</strong> ${data.keterangan}</p>
                                <div class="mt-3">
                                    <h5>Dokumentasi:</h5>
                                    <div class="row">
                                        ${dokumentasi.map(image => `
                                                                <div class="col-12 text-center">
                                                                    <img src="${image}" alt="Dokumentasi" class="modal-img img-thumbnail">
                                                                </div>
                                                            `).join('')}
                                    </div>
                                </div>
                            `;
                        })
                        .catch(error => {
                            detailContent.innerHTML =
                                `<p class="text-center text-danger">Gagal memuat data.</p>`;
                            console.error(error);
                        });
                });
            });
        });
    </script>
@endsection
