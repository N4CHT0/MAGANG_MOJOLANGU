@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pembangunan</th>
                                    <th>Status</th>
                                    <th>Waktu Pengajuan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1 @endphp
                                @forelse ($riwayat as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>
                                            <span
                                                class="badge
                                                @if ($item->status == 'menunggu_verifikasi') badge-warning
                                                @elseif ($item->status == 'disetujui') badge-success
                                                @elseif ($item->status == 'ditolak') badge-danger
                                                @elseif ($item->status == 'divalidasi') badge-info @endif">
                                                @if ($item->status == 'menunggu_verifikasi')
                                                    Menunggu Verifikasi RT
                                                @elseif ($item->status == 'disetujui')
                                                    Disetujui RW
                                                @elseif ($item->status == 'divalidasi')
                                                    Divalidasi LPMD
                                                @elseif ($item->status == 'ditolak')
                                                    Pembangunan Ditolak
                                                @endif
                                            </span>
                                        </td>
                                        <td>{{ $item->tanggal_pengajuan }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm detail-button" data-id="{{ $item->id }}"
                                                data-bs-toggle="modal" data-bs-target="#detailModal">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada pengajuan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="detailContent">
                        <!-- Data detail akan dimuat di sini -->
                        <p class="text-center">Memuat data...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .modal-img {
            width: 100%;
            max-width: 600px;
            height: auto;
            margin: 0 auto;
            display: block;
        }
    </style>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tombol detail
            const detailButtons = document.querySelectorAll('.detail-button');

            detailButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const detailContent = document.getElementById('detailContent');

                    // Tampilkan loading saat data diambil
                    detailContent.innerHTML = '<p class="text-center">Memuat data...</p>';

                    // Lakukan permintaan AJAX untuk mengambil detail
                    fetch(`/riwayat/${id}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('detailContent').innerHTML = `
                                <p><strong>Nama Pembangunan:</strong> ${data.nama}</p>
                                <p><strong>Status:</strong> ${data.status}</p>
                                <p><strong>Tanggal Pengajuan:</strong> ${data.tanggal_pengajuan}</p>
                                <p><strong>Keterangan:</strong> ${data.keterangan}</p>
                                <div class="mt-3">
                                    <h5>Dokumentasi:</h5>
                                    <div class="row">
                                        ${data.dokumentasi.map(image => `
                                                        <div class="col-12 text-center">
                                                            <img src="${image}" alt="Dokumentasi" class="modal-img img-thumbnail">
                                                        </div>
                                                    `).join('')}
                                    </div>
                                </div>
                            `;
                        })
                        .catch(error => {
                            document.getElementById('detailContent').innerHTML =
                                `<p class="text-center text-danger">Gagal memuat data.</p>`;
                            console.error('Error:', error);
                        });
                });
            });
        });
    </script>
@endsection
