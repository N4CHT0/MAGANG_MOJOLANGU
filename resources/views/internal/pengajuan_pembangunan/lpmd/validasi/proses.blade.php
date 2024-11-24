@extends('layouts.main')

@section('content')
    <div class="container my-4">
        <h2 class="text-center">Validasi Proses</h2>
        @if (empty($hasilPerbandingan))
            <p class="text-muted text-center">Belum ada data. Klik tombol di bawah untuk memulai proses pertama.</p>
            <div class="text-center mt-4">
                <form action="{{ route('handle.validation') }}" method="POST">
                    @csrf
                    <input type="hidden" name="option" value="new_data">
                    <button type="submit" class="btn btn-primary">Mulai Proses Pertama</button>
                </form>
            </div>
        @else
            <p class="text-muted">Anda sudah menjalankan proses sebelumnya. Pilih salah satu opsi untuk melanjutkan:</p>
            <form action="{{ route('handle.validation') }}" method="POST">
                @csrf
                <div class="form-group">
                    @foreach ($options as $key => $label)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="option" value="{{ $key }}"
                                id="option-{{ $key }}" required>
                            <label class="form-check-label" for="option-{{ $key }}">
                                {{ $label }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-primary">Lanjutkan</button>
                </div>
            </form>
        @endif
    </div>
@endsection
