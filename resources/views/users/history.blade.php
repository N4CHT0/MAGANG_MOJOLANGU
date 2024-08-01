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
                                    <th>Validasi</th>
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
                                            @else
                                                <span class="badge badge-warning">Sedang Diproses</span>
                                            @endif
                                        </td>
                                        @if ($item->keterangan)
                                            <td>{{ $item->keterangan }}</td>
                                        @endif
                                        <td>
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-dark">
                                                    <i class="fa fa-download"></i>
                                                </a>
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
@endsection
