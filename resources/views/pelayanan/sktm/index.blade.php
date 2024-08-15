@extends('layouts.main')
@section('content')
    <style>
        #searchInput {
            width: 100%;
            padding: 10px 15px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        #searchInput:focus {
            border-color: #80bdff;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-body">
                        <div class="card-title">
                            <p>Pengajuan Untuk Surat Keterangan Tidak Mampu (SKTM)</p>
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari...">
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Alamat</th>
                                        <th>RT</th>
                                        <th>RW</th>
                                        @if (Auth::user()->role != 'rw' && Auth::user()->role != 'warga')
                                            <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_lengkap }}</td>
                                            <td>{{ $item->alamat }}</td>
                                            <td>{{ $item->rt }}</td>
                                            <td>{{ $item->rw }}</td>
                                            @if (Auth::user()->role != 'rw' && Auth::user()->role != 'warga')
                                                <td>
                                                    <div class="btn-group">
                                                        @if (Auth::user()->role == 'admin')
                                                            @if ($item->validasi != 'tervalidasi' && $item->validasi != 'final')
                                                                <button class="btn btn-success" data-toggle="modal"
                                                                    data-target="#validateModal"
                                                                    data-id="{{ $item->id }}"
                                                                    data-nama="{{ $item->nama_lengkap }}"
                                                                    data-alamat="{{ $item->alamat }}"
                                                                    data-ktp="{{ asset('storage/img/' . $item->foto_ktp) }}"
                                                                    data-kk="{{ asset('storage/img/' . $item->foto_kk) }}">
                                                                    <i class="fa fa-check-circle"></i>
                                                                </button>
                                                            @elseif ($item->validasi = 'tervalidasi')
                                                                <a href="{{ route('sktms.download', $item->id) }}"
                                                                    class="btn btn-dark">
                                                                    <i class="fa fa-download"></i>
                                                                </a>
                                                            @endif
                                                            <a href="{{ route('sktms.show', $item->id) }}"
                                                                class="btn btn-info">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('sktms.edit', $item->id) }}"
                                                                class="btn btn-warning">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('sktms.destroy', $item->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('delete')
                                                                <button class="btn btn-danger">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @elseif (Auth::user()->role == 'rt')
                                                            @if ($item->validasi != 'tervalidasi' && $item->validasi != 'final')
                                                                <button class="btn btn-success" data-toggle="modal"
                                                                    data-target="#validateModal"
                                                                    data-id="{{ $item->id }}"
                                                                    data-nama="{{ $item->nama_lengkap }}"
                                                                    data-alamat="{{ $item->alamat }}"
                                                                    data-ktp="{{ asset('storage/img/' . $item->foto_ktp) }}"
                                                                    data-kk="{{ asset('storage/img/' . $item->foto_kk) }}">
                                                                    <i class="fa fa-check-circle"></i>
                                                                </button>
                                                            @elseif ($item->validasi = 'tervalidasi')
                                                                <a href="{{ route('sktms.download', $item->id) }}"
                                                                    class="btn btn-dark">
                                                                    <i class="fa fa-download"></i>
                                                                </a>
                                                            @endif
                                                        @elseif (Auth::user()->role == 'kelurahan')
                                                            @if ($item->validasi == 'tervalidasi')
                                                                <button class="btn btn-success" data-toggle="modal"
                                                                    data-target="#finalModal" data-id="{{ $item->id }}"
                                                                    data-nama="{{ $item->nama_lengkap }}"
                                                                    data-alamat="{{ $item->alamat }}"
                                                                    data-keperluan="{{ $item->keperluan }}"
                                                                    data-tujuan="{{ $item->tujuan }}"
                                                                    data-ktp="{{ asset('storage/img/' . $item->foto_ktp) }}"
                                                                    data-kk="{{ asset('storage/img/' . $item->foto_kk) }}"
                                                                    data-pdf="{{ $item->surat_pengantar }}">
                                                                    <i class="fa fa-check-square-o"></i>
                                                                </button>
                                                            @elseif ($item->validasi == 'final')
                                                                <a href="{{ route('sktms.download', $item->id) }}"
                                                                    class="btn btn-dark">
                                                                    <i class="fa fa-download"></i>
                                                                </a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="card-actions">
                                <a href="{{ route('sktms.all') }}" class="btn btn-success"><i class="fa fa-file-excel-o"
                                        style="margin-right: 5px"></i>Cetak Data</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Validate Modal -->
    <div class="modal fade" id="validateModal" tabindex="-1" role="dialog" aria-labelledby="validateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="validateModalLabel">Validasi Pengajuan SKTM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="validateForm" method="POST" action="">
                        @csrf
                        <input type="hidden" name="id" id="validate-id">
                        <p>Apakah Anda yakin ingin memvalidasi pengajuan SKTM ini?</p>
                        <div class="form-group">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" readonly>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" readonly>
                        </div>
                        <div class="form-group">
                            <label for="foto_ktp">Foto KTP</label>
                            <img id="foto_ktp" class="img-fluid" alt="Foto KTP">
                        </div>
                        <div class="form-group">
                            <label for="foto_kk">Foto KK</label>
                            <img id="foto_kk" class="img-fluid" alt="Foto KK">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan (jika ditolak)</label>
                            <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Validasi</button>
                        <button type="button" id="rejectBtn" class="btn btn-danger">Tolak</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Final Modal -->
    <div class="modal fade" id="finalModal" tabindex="-1" role="dialog" aria-labelledby="finalModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="finalModalLabel">Finalisasi Pengajuan SKTM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="finalForm" method="POST" action="">
                        @csrf
                        <input type="hidden" name="id" id="final-id">
                        <p>Apakah Anda yakin ingin memfinalisasi pengajuan SKTM ini?</p>
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
                            <img id="foto_ktp" class="img-fluid" alt="Foto KTP">
                        </div>
                        <div class="form-group">
                            <label for="foto_kk">Foto KK</label>
                            <img id="foto_kk" class="img-fluid" alt="Foto KK">
                        </div>
                        <div class="form-group">
                            <label for="pdf">Surat Pengantar</label>
                            <p>PDF tidak dapat ditampilkan.
                                <a id="pdf-download" href="" target="_blank">Klik di sini untuk mengunduh</a>.
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan (jika ditolak)</label>
                            <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Finalisasi</button>
                        <button type="button" id="rejecFinaltBtn" class="btn btn-danger">Tolak</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Modal -->

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('.table tbody tr').each(function() {
                    var rowText = $(this).text().toLowerCase();
                    if (rowText.indexOf(value) > -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
        $('#validateModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nama = button.data('nama');
            var alamat = button.data('alamat');
            var ktp = button.data('ktp');
            var kk = button.data('kk');
            var modal = $(this);
            var validateUrl = '{{ route('sktm.validate', ':id') }}';
            validateUrl = validateUrl.replace(':id', id);
            modal.find('#validate-id').val(id);
            modal.find('#validateForm').attr('action', validateUrl);
            modal.find('#nama_lengkap').val(nama);
            modal.find('#alamat').val(alamat);
            modal.find('#foto_ktp').attr('src', ktp);
            modal.find('#foto_kk').attr('src', kk);
        });

        $('#finalModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nama = button.data('nama');
            var alamat = button.data('alamat');
            var keperluan = button.data('keperluan');
            var tujuan = button.data('tujuan');
            var ktp = button.data('ktp');
            var kk = button.data('kk');
            var suratPengantar = button.data('pdf'); // Nama file PDF
            var modal = $(this);
            var finalUrl = '{{ route('sktm.final', ':id') }}';
            finalUrl = finalUrl.replace(':id', id);
            var pdfUrl = '{{ route('sktm.viewPDF', ':filename') }}';
            pdfUrl = pdfUrl.replace(':filename', encodeURIComponent(suratPengantar)); // Encode nama file

            modal.find('#final-id').val(id);
            modal.find('#finalForm').attr('action', finalUrl);
            modal.find('#nama_lengkap').val(nama);
            modal.find('#alamat').val(alamat);
            modal.find('#keperluan').val(keperluan);
            modal.find('#tujuan').val(tujuan);
            modal.find('#foto_ktp').attr('src', ktp);
            modal.find('#foto_kk').attr('src', kk);
            modal.find('#pdf-download').attr('href', pdfUrl); // Set href for download link
        });

        $('#rejecFinaltBtn').on('click', function() {
            var modal = $('#finalModal');
            var id = modal.find('#validate-id').val();
            var rejectUrl = '{{ route('sktm.reject', ':id') }}';
            rejectUrl = rejectUrl.replace(':id', id);
            modal.find('#finalMpdal').attr('action', rejectUrl);
            modal.find('#finalMpdal').submit();
        });

        $('#rejectBtn').on('click', function() {
            var modal = $('#validateModal');
            var id = modal.find('#validate-id').val();
            var rejectUrl = '{{ route('sktm.reject', ':id') }}';
            rejectUrl = rejectUrl.replace(':id', id);
            modal.find('#validateForm').attr('action', rejectUrl);
            modal.find('#validateForm').submit();
        });
    </script>
@endsection
