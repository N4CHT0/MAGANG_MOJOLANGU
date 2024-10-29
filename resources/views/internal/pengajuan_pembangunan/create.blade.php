@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label style="font-size: 20px" class="form-label" for="">Pengajuan Pembangunan
                                Infrastruktur Desa</label>
                        </div>
                        <form method="POST" action="{{ route('pembangunan.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="nama" class="form-label">Pembangunan Yang Akan Di Ajukan</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" value=""
                                    placeholder="Pembangunan Yang Akan Di Ajukan" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Pembangunan Beserta Alasan</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" cols="30"
                                    rows="10" placeholder="Deskripsi Pembangunan Beserta Alasan" required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="pengusul" class="form-label">Pengusul</label>
                                <input type="text" class="form-control @error('pengusul') is-invalid @enderror"
                                    id="pengusul" name="pengusul" value="{{ Auth::user()->nama_lengkap }}" readonly>
                                @error('pengusul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="kategori" class="form-label">{{ __('Jenis Pembangunan') }}</label>

                                <div class="md-6">
                                    <select id="kategori" class="form-control @error('kategori') is-invalid @enderror"
                                        name="kategori" required>
                                        <option value="">Jalan</option>
                                        <option value="Irigasi">Irigasi</option>
                                        <option value="Taman">Taman</option>
                                        <option value="Gorong - Gorong">Gorong - Gorong</option>
                                        <option value="Bangunan">Bangunan</option>
                                    </select>

                                    @error('kategori')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="biaya" class="form-label">Estimasi Biaya Pembangunan</label>
                                <input type="number" class="form-control @error('biaya') is-invalid @enderror"
                                    id="biaya" name="biaya" placeholder="Estimasi Biaya Pembangunan">
                                @error('biaya')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="lokasi" class="form-label">Lokasi Pembangunan</label>
                                <input type="text" class="form-control @error('lokasi') is-invalid @enderror"
                                    id="lokasi" name="lokasi"placeholder="Lokasi Pembangunan" required>
                                @error('lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="dokumentasi" class="form-label">Upload Dokumentasi Terkait Pembangunan</label>
                                <input type="file" class="form-control @error('dokumentasi') is-invalid @enderror"
                                    id="dokumentasi" name="dokumentasi[]" multiple required>
                                @error('dokumentasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan & Ajukan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
