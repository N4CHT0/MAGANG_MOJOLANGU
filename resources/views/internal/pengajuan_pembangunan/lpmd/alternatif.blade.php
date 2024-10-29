@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <p>Data Alternatif yang Sudah Divalidasi</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pembangunan</th>
                                    <th>Alamat</th>
                                    <th>Pengusul</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembangunan as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->lokasi }}</td>
                                        <td>{{ $item->pengusul }}</td>
                                        <td>{{ $item->kategori }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal"
                                                data-id="{{ $item->id }}" data-nama="{{ $item->nama }}"
                                                data-lokasi="{{ $item->lokasi }}" data-pengusul="{{ $item->pengusul }}"
                                                data-kategori="{{ $item->kategori }}"
                                                data-deskripsi="{{ $item->deskripsi }}">
                                                Lihat
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($pembangunan->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data yang tersedia.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pembangunan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama:</strong> <span id="modalNama"></span></p>
                    <p><strong>Alamat:</strong> <span id="modalLokasi"></span></p>
                    <p><strong>Pengusul:</strong> <span id="modalPengusul"></span></p>
                    <p><strong>Kategori:</strong> <span id="modalKategori"></span></p>
                    <p><strong>Deskripsi:</strong> <span id="modalDeskripsi"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Saat tombol "Lihat" diklik
            $('[data-toggle="modal"]').on('click', function() {
                // Ambil data dari tombol
                var nama = $(this).data('nama');
                var lokasi = $(this).data('lokasi');
                var pengusul = $(this).data('pengusul');
                var kategori = $(this).data('kategori');
                var deskripsi = $(this).data('deskripsi');

                // Masukkan data ke modal
                $('#modalNama').text(nama);
                $('#modalLokasi').text(lokasi);
                $('#modalPengusul').text(pengusul);
                $('#modalKategori').text(kategori);
                $('#modalDeskripsi').text(deskripsi);
            });
        });
    </script>
@endsection
