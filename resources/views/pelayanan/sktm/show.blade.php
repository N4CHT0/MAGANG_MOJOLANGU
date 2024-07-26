@extends('layouts.main')

@section('content')
    <div class="container">
        <h1 class="my-4">User Details</h1>

        <div class="mb-3">
            <strong>Nama Lengkap:</strong>
            <p>{{ $data->nama_lengkap }}</p>
        </div>

        <div class="mb-3">
            <strong>NIK:</strong>
            <p>{{ $data->nik }}</p>
        </div>

        <div class="mb-3">
            <strong>Jenis Kelamin:</strong>
            <p>{{ $data->jenis_kelamin }}</p>
        </div>

        <div class="mb-3">
            <strong>Jenis Kelamin:</strong>
            <p>{{ $data->alamat }}</p>
        </div>

        <div class="mb-3">
            <strong>RT :</strong>
            <p>{{ $data->rt }}</p>
        </div>

        <div class="mb-3">
            <strong>RW :</strong>
            <p>{{ $data->rw }}</p>
        </div>

        <div class="mb-3">
            <strong for="foto_ktp">Foto KTP : </strong>
            <br>
            <img class="detail-value" id="foto_ktp" src="{{ asset('storage/img/' . $data->foto_ktp) }}" alt="Foto"
                style="max-width: 300px;">
        </div>

        <div class="mb-3">
            <strong for="foto_kk">Foto KK : </strong>
            <br>
            <img class="detail-value" id="foto_kk" src="{{ asset('storage/img/' . $data->foto_kk) }}" alt="Foto"
                style="max-width: 300px;">
        </div>

        <!-- Repeat similar blocks for other fields -->

        <a href="{{ route('sktms.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
@endsection
