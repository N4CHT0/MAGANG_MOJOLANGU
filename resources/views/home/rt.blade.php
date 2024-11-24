@extends('layouts.main')

@section('content')
    <style>
        .card {
            position: relative;
            overflow: hidden;
        }

        .hover-text {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            /* Latar belakang semi-transparan */
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.2rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card-link {
            text-decoration: none;
            /* Menghilangkan garis bawah link */
            color: inherit;
            /* Memastikan warna teks dalam card tidak berubah */
        }

        .card-link:hover .card {
            opacity: 0.9;
            /* Efek hover untuk seluruh card saat di-hover */
        }


        .card:hover .hover-text {
            opacity: 1;
            /* Teks akan muncul saat hover */
        }
    </style>
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info d-flex justify-content-between align-items-center">
                <span style="color: white; font-size: 20px;font-weight: 400;">Biodata</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img class="detail-value" id="foto"
                            src="{{ asset('admin-master/assets/images/LOGO_MOJOLANGU.png') }}" alt="Foto"
                            style="max-width: 380px; height: 380px;">
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <h3>Nama :</h3>
                                    <h3><strong>{{ Auth::user()->nama_lengkap }}</strong></h3>
                                </div>
                                <div class="form-group">
                                    <h3>NIK :</h3>
                                    <h3><strong>{{ Auth::user()->nik }}</strong></h3>
                                </div>
                                <div class="form-group">
                                    <h3>Jenis Kelamin :</h3>
                                    <h3><strong>{{ Auth::user()->jenis_kelamin }}</strong></h3>
                                </div>
                                <div class="form-group">
                                    <h3>Alamat :</h3>
                                    <h3><strong>{{ Auth::user()->alamat }}</strong></h3>
                                </div>
                                <div class="form-group">
                                    <h3>RT :</h3>
                                    <h3><strong>{{ Auth::user()->rt }}</strong></h3>
                                </div>
                                <div class="form-group">
                                    <h3>RW :</h3>
                                    <h3><strong>{{ Auth::user()->rw }}</strong></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-info d-flex justify-content-between align-items-center">
                <span style="color: white; font-size: 20px;font-weight: 400;">Harap Baca</span>
            </div>
            <div class="card-body">
                <h4>1. Pengguna Wajib Memiliki Telegram Yang Berstatus Aktif</h4>
                <h4>2. Mengisi ID Telegram Pada Akun, Dapatkan ID Telegram Anda <a
                        href="https://t.me/userinfobot">Disini</a></h4>
                <h4> Jika Kesulitan Harap Lihat Panduan Untuk Mendapat ID Telegram Anda Di Sini</h4><br>
                <h4>
                    3. Jika Sudah Mendapat ID Telegram, Harap Masukan Data Anda
                    @if (!Auth::user()->data_updated)
                        <a href="#" data-toggle="modal" data-target="#updateDataWargaModal">Disini</a>
                    @else
                        <span class="text-muted">(Data sudah diperbarui)</span>
                    @endif
                </h4>

                <h4>4. Pengguna Hanya Dapat Mengakses Layanan Dengan 1 Akun Untuk 1 Orang Saja.</h4>
            </div>
        </div>

        <!-- Modal Form Update Data Warga -->
        <div class="modal fade" id="updateDataWargaModal" tabindex="-1" role="dialog"
            aria-labelledby="updateDataWargaLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateDataWargaLabel">Perbarui Data Anda</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('update_data_warga') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="no_kk">Nomor KK</label>
                                <input type="text" name="no_kk" id="no_kk" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="agama">Agama</label>
                                <input type="text" name="agama" id="agama" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="pekerjaan">Pekerjaan</label>
                                <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="status_perkawinan">Status Perkawinan</label>
                                <select name="status_perkawinan" id="status_perkawinan" class="form-control" required>
                                    <option value="Belum Kawin">Belum Kawin</option>
                                    <option value="Kawin">Kawin</option>
                                    <option value="Cerai Hidup">Cerai Hidup</option>
                                    <option value="Cerai Mati">Cerai Mati</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pendidikan">Pendidikan</label>
                                <select name="pendidikan" id="pendidikan" class="form-control" required>
                                    <option value="SMA/SMK/SEDERAJAT">SMA/SMK/SEDERAJAT</option>
                                    <option value="D1">D1</option>
                                    <option value="S1/D4">S1/D4</option>
                                    <option value="S2/S3">S2/S3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="telegram_number">ID Telegram</label>
                                <input type="text" name="telegram_number" id="telegram_number" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
