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
                                            <a href="#" class="btn btn-info btn-sm">Detail</a>
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
@endsection
@section('script')
@endsection
