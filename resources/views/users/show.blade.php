@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">User Details</h1>

        <div class="mb-3">
            <strong>Nama Lengkap:</strong>
            <p>{{ $user->nama_lengkap }}</p>
        </div>

        <!-- Repeat similar blocks for other fields -->

        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
@endsection
