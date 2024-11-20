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
                                                @if ($data->status === 'Final')
                                                    <span class="badge badge-success rounded-2">Final</span>
                                                @else
                                                    <span class="badge badge-warning rounded-2">Sedang Diproses</span>
                                                @endif
                                            </td>
                                            <td>{{ $data->input_nama ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('download.pdf', $data->id) }}"
                                                    class="btn btn-primary">Unduh PDF</a>
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
