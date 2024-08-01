@extends('layouts.main')

@section('content')
    <div class="container">
        <h1 class="my-4">Edit User</h1>

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap"
                    name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                @error('nama_lengkap')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik"
                    value="{{ old('nik', $user->nik) }}" required>
                @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                    name="alamat" value="{{ old('alamat', $user->alamat) }}" required>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="rt" class="form-label">RT</label>
                <input type="text" class="form-control @error('rt') is-invalid @enderror" id="rt" name="rt"
                    value="{{ old('rt', $user->rt) }}" required>
                @error('rt')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="rw" class="form-label">RW</label>
                <input type="text" class="form-control @error('rw') is-invalid @enderror" id="rw" name="rw"
                    value="{{ old('rw', $user->rw) }}" required>
                @error('rw')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                    <option value="">Pilih Role</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="warga" {{ old('role', $user->role) == 'warga' ? 'selected' : '' }}>Warga</option>
                    <option value="rt" {{ old('role', $user->role) == 'rt' ? 'selected' : '' }}>RT</option>
                    <option value="rw" {{ old('role', $user->role) == 'rw' ? 'selected' : '' }}>RW</option>
                    <option value="kelurahan" {{ old('role', $user->role) == 'kelurahan' ? 'selected' : '' }}>Kelurahan
                    </option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">{{ __('Jenis Kelamin') }}</label>

                <div class="md-6">
                    <select id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror"
                        name="jenis_kelamin" required autofocus onchange="toggleLainnyaInput(this)">
                        <option value="">{{ __('Pilih Jenis Kelamin') }}</option>
                        <option value="Laki-Laki"
                            {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-Laki' ? 'selected' : '' }}>
                            {{ __('Laki-Laki') }}</option>
                        <option value="Perempuan"
                            {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                            {{ __('Perempuan') }}</option>
                        <option value="Lainnya"
                            {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Lainnya' ? 'selected' : '' }}>
                            {{ __('Lainnya') }}</option>
                    </select>

                    @error('jenis_kelamin')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input id="jenis_kelamin_lainnya" type="text"
                        class="form-control mt-2 @error('jenis_kelamin_lainnya') is-invalid @enderror"
                        name="jenis_kelamin_lainnya" value="{{ old('jenis_kelamin_lainnya') }}" style="display:none;"
                        placeholder="Masukkan Jenis Kelamin" />

                    @error('jenis_kelamin_lainnya')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password (Leave blank to keep current)</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                    id="password_confirmation" name="password_confirmation">
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    <script>
        function toggleLainnyaInput(select) {
            var lainnyaInput = document.getElementById('jenis_kelamin_lainnya');
            if (select.value === 'Lainnya') {
                lainnyaInput.style.display = 'block';
                lainnyaInput.required = true;
            } else {
                lainnyaInput.style.display = 'none';
                lainnyaInput.required = false;
                lainnyaInput.value = '';
            }
        }

        // Initialize the visibility of the "Lainnya" input field on page load
        document.addEventListener('DOMContentLoaded', function() {
            var select = document.getElementById('jenis_kelamin');
            toggleLainnyaInput(select);
        });
    </script>
@endsection
