@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Selamat Datang Warga Kelurahan Mojolangu') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Layanan') }}</div>

                    <div class="card-body">
                        <a href="#" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-file"
                                style="margin-right: 10px "></i>Pengurusan SKTM</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pengurusan SKTM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('admin-master/assets/images/sktm_img.jpg') }}" alt="Gambar Pengurusan SKTM"
                        class="img-fluid mb-3">
                    <p>Deskripsi layanan pengurusan SKTM.</p>
                    <p>Syarat :</p>
                    <ul>
                        <li>Upload Fotocopy Kartu Keluarga</li>
                        <li>Upload Fotocopy E-KTP</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('sktms.create') }}" class="btn btn-primary">Ajukan Sekarang</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
