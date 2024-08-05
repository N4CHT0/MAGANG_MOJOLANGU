@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Pengajuan Untuk Surat Keterangan Tidak Mampu (SKTM)') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('sktms.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                    id="nama_lengkap" name="nama_lengkap" value="{{ Auth::user()->nama_lengkap }}" required>
                                @error('nama_lengkap')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik"
                                    name="nik" value="{{ Auth::user()->nik }}" required>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                                    id="alamat" name="alamat" value="{{ Auth::user()->alamat }}" required>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="rt" class="form-label">RT</label>
                                <input type="text" class="form-control @error('rt') is-invalid @enderror" id="rt"
                                    name="rt" value="{{ Auth::user()->rt }}" required>
                                @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="rw" class="form-label">RW</label>
                                <input type="text" class="form-control @error('rw') is-invalid @enderror" id="rw"
                                    name="rw" value="{{ Auth::user()->rw }}" required>
                                @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="foto_ktp" class="form-label">Upload Fotocopy KTP</label>
                                <input type="file" class="form-control @error('foto_ktp') is-invalid @enderror"
                                    id="foto_ktp" name="foto_ktp" required>
                                @error('foto_ktp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="foto_kk" class="form-label">Upload Fotocopy KK</label>
                                <input type="file" class="form-control @error('foto_kk') is-invalid @enderror"
                                    id="foto_kk" name="foto_kk" required>
                                @error('foto_kk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">{{ __('Jenis Kelamin') }}</label>

                                <div class="md-6">
                                    <select id="jenis_kelamin"
                                        class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                        name="jenis_kelamin" required autofocus onchange="toggleLainnyaInput(this)">
                                        <option value="">{{ __('Pilih Jenis Kelamin') }}</option>
                                        <option value="Laki-Laki"
                                            {{ Auth::user()->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>
                                            {{ __('Laki-Laki') }}</option>
                                        <option value="Perempuan"
                                            {{ Auth::user()->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                            {{ __('Perempuan') }}</option>
                                        <option value="Lainnya"
                                            {{ Auth::user()->jenis_kelamin == 'Lainnya' ? 'selected' : '' }}>
                                            {{ __('Lainnya') }}</option>
                                    </select>

                                    @error('jenis_kelamin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <input id="jenis_kelamin_lainnya" type="text"
                                        class="form-control mt-2 @error('jenis_kelamin_lainnya') is-invalid @enderror"
                                        name="jenis_kelamin_lainnya" value="{{ old('jenis_kelamin_lainnya') }}"
                                        style="display:none;" placeholder="Masukkan Jenis Kelamin" />

                                    @error('jenis_kelamin_lainnya')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="keperluan" class="form-label">Keperluan</label>
                                <input type="text" class="form-control @error('keperluan') is-invalid @enderror"
                                    id="keperluan" name="keperluan" required>
                                @error('keperluan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tujuan" class="form-label">Tujuan</label>
                                <input type="text" class="form-control @error('tujuan') is-invalid @enderror"
                                    id="tujuan" name="tujuan" required>
                                @error('tujuan')
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
