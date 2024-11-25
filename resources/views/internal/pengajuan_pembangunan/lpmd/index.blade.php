@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <p>Data Perankingan Pembangunan</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun</th>
                                    <th>Status</th>
                                    <th>Petugas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($pembangunan->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data yang tersedia.</td>
                                    </tr>
                                @else
                                    @foreach ($pembangunan as $index => $data)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($data->created_at)->format('Y') }}</td>
                                            <td>
                                                @if ($data->status === 'final')
                                                    <span class="badge badge-success rounded-2">Dikirim Ke Lurah</span>
                                                @else
                                                    <span class="badge badge-warning rounded-2">Sedang Diproses</span>
                                                @endif
                                            </td>
                                            <td>{{ $data->input_nama ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('download.pdf', $data->id) }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fa fa-file-pdf-o"></i> Unduh PDF
                                                </a>
                                                <a href="{{ route('pembangunan.detail', $data->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fa fa-bar-chart"></i> Detail
                                                </a>
                                                <form action="{{ route('perbandingan.destroy', $data->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
