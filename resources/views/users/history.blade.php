@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Riwayat Pengajuan</div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Alamat</th>
                                    <th>RT</th>
                                    <th>RW</th>
                                    <th>Pengurusan</th>
                                    <th>Status</th>
                                    @if ($data->some(fn($item) => $item->keterangan))
                                        <th>Keterangan</th>
                                    @endif
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1 @endphp
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->nama_lengkap }}</td>
                                        <td>{{ $item->alamat }}</td>
                                        <td>{{ $item->rt }}</td>
                                        <td>{{ $item->rw }}</td>
                                        <td>{{ $item->source }}</td>
                                        <td>
                                            @if ($item->validasi === 'tervalidasi')
                                                <span class="badge badge-success">Tervalidasi</span>
                                            @elseif($item->validasi === 'ditolak')
                                                <span class="badge badge-danger">Ditolak</span>
                                            @elseif($item->validasi === 'final')
                                                <span class="badge badge-info">Terfinalisasi</span>
                                            @else
                                                <span class="badge badge-warning">Sedang Diproses</span>
                                            @endif
                                        </td>
                                        @if ($item->keterangan)
                                            <td>{{ $item->keterangan }}</td>
                                        @endif
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-info" data-toggle="modal" data-target="#detailModal"
                                                    data-id="{{ $item->id }}" data-nama="{{ $item->nama_lengkap }}"
                                                    data-alamat="{{ $item->alamat }}"
                                                    data-keperluan="{{ $item->keperluan }}"
                                                    data-tujuan="{{ $item->tujuan }}"
                                                    data-ktp="{{ asset('storage/img/' . $item->foto_ktp) }}"
                                                    data-kk="{{ asset('storage/img/' . $item->foto_kk) }}"
                                                    data-pdf="{{ $item->surat_pengantar }}"
                                                    data-product="{{ $item->produk }}">
                                                    <i class="fa fa-info-circle"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detaillModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detaillModalLabel">Informasi Pengajuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="detailForm" method="POST" action="">
                        @csrf
                        <input type="hidden" name="id" id="detail-id">
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" readonly>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" readonly>
                        </div>
                        <div class="form-group">
                            <label for="keperluan">Keperluan</label>
                            <input type="text" class="form-control" id="keperluan" name="keperluan">
                        </div>
                        <div class="form-group">
                            <label for="tujuan">Tujuan</label>
                            <input type="text" class="form-control" id="tujuan" name="tujuan">
                        </div>
                        <div class="form-group">
                            <label for="foto_ktp">Foto KTP</label>
                            <br>
                            <img id="foto_ktp" class="img-fluid" alt="Foto KTP">
                        </div>
                        <div class="form-group">
                            <label for="foto_kk">Foto KK</label>
                            <br>
                            <img id="foto_kk" class="img-fluid" alt="Foto KK">
                        </div>
                        <div class="form-group">
                            <label for="pdf">Surat Pengantar</label>
                            <br>
                            <a id="pdf-download" href="" target="_blank">Klik di sini untuk mengunduh</a>.
                        </div>
                        <div class="form-group">
                            <label for="product">Produk</label>
                            <br>
                            <a id="product-download" href="" target="_blank">Klik di sini untuk mengunduh</a>.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#detailModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nama = button.data('nama');
            var alamat = button.data('alamat');
            var keperluan = button.data('keperluan');
            var tujuan = button.data('tujuan');
            var ktp = button.data('ktp');
            var kk = button.data('kk');
            var suratPengantar = button.data('pdf');
            var Product = button.data('product');
            var modal = $(this);
            var detailUrl = '{{ route('sktm.final', ':id') }}';
            detailUrl = detailUrl.replace(':id', id);
            var pdfUrl = '{{ route('sktm.viewPDF', ':filename') }}';
            var productUrl = '{{ route('sktm.viewPDF', ':filename') }}';

            pdfUrl = pdfUrl.replace(':filename', encodeURIComponent(suratPengantar)); // Encode nama file
            productUrl = productUrl.replace(':filename', encodeURIComponent(Product)); // Encode nama file

            modal.find('#detail-id').val(id);
            modal.find('#detailForm').attr('action', detailUrl);
            modal.find('#nama_lengkap').val(nama);
            modal.find('#alamat').val(alamat);
            modal.find('#keperluan').val(keperluan);
            modal.find('#tujuan').val(tujuan);
            modal.find('#foto_ktp').attr('src', ktp);
            modal.find('#foto_kk').attr('src', kk);
            modal.find('#pdf-download').attr('href', pdfUrl); // Set href for download link
            modal.find('#product-download').attr('href', productUrl); // Set href for download link
        });
    </script>
@endsection
