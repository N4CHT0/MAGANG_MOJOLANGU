@extends('layouts.main')

@section('content')
    <style>
        /* Pastikan efek hover ini hanya berlaku untuk card dalam my-special-card-container */
        .my-special-card-container .my-special-card {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            /* Menambahkan efek transisi untuk interaksi yang halus */
        }

        .my-special-card-container .my-special-hover-text {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            /* Latar belakang semi-transparan untuk teks hover */
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.2rem;
            opacity: 0;
            transition: opacity 0.3s ease;
            /* Pastikan teks hover muncul secara halus */
        }

        .my-special-card-container .my-special-card-link {
            text-decoration: none;
            /* Menghilangkan garis bawah link */
            color: inherit;
            /* Memastikan warna teks dalam card tidak berubah */
        }

        /* Efek hover hanya berlaku untuk .my-special-hover-text di dalam .my-special-card yang sedang di-hover */
        .my-special-card-container .my-special-card:hover .my-special-hover-text {
            opacity: 1;
            /* Teks akan muncul saat hover */
        }

        /* Hanya ubah opacity card yang di-hover, tanpa mempengaruhi card lain */
        .my-special-card-container .my-special-card:hover {
            opacity: 0.9;
            /* Efek hover untuk kartu yang di-hover */
            transform: scale(1.05);
            /* Efek zoom sedikit */
        }

        /* Pastikan hover hanya mempengaruhi card yang bersangkutan */
        .my-special-card-container .my-special-card-link:hover {
            text-decoration: none;
        }
    </style>


    <div class="col-12 my-special-card-container">
        <div class="card">
            <div class="card-header bg-info d-flex justify-content-between align-items-center">
                <span style="color: white; font-size: 16px;font-weight: 400;">Biodata</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img class="detail-value" id="foto"
                            src="{{ asset('admin-master/assets/images/LOGO_MOJOLANGU.png') }}" }}" alt="Foto"
                            style="max-width: 380px; height: 380px;">
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama :</label>
                                    <span>{{ Auth::user()->nama_lengkap }}</span>
                                </div>
                                <div class="form-group">
                                    <label>NIK :</label>
                                    <span>{{ Auth::user()->nik }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin :</label>
                                    <span>{{ Auth::user()->jenis_kelamin }}</span>
                                </div>
                                <div class="form-group">
                                    <label>Alamat :</label>
                                    <span>{{ Auth::user()->alamat }}</span>
                                </div>
                                <div class="form-group">
                                    <label>RT :</label>
                                    <span>{{ Auth::user()->rt }}</span>
                                </div>
                                <div class="form-group">
                                    <label>RW :</label>
                                    <span>{{ Auth::user()->rw }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 my-special-card-container">
            <div class="card">
                <div class="card-body">
                    <h4>Harap Baca Sebelum Menggunakan Aplikasi</h4>
                    <h6>1. Pengguna Wajib Memiliki Telegram Yang Berstatus Aktif</h6>
                    <h6>2. Mengisi ID Telegram Pada Akun, Dapatkan ID Telegram Anda <a
                            href="https://t.me/userinfobot">Disini</a></h6>
                    <h6> Jika Kesulitan Harap Lihat Panduan Untuk Mendapat ID Telegram Anda Di Sini</h6><br>
                    <h6>
                        3. Jika Sudah Mendapat ID Telegram, Harap Masukan Data Anda
                        @if (!Auth::user()->data_updated)
                            <a href="#" data-toggle="modal" data-target="#updateDataWargaModal">Disini</a>
                        @else
                            <span class="text-muted">(Data sudah diperbarui)</span>
                        @endif
                    </h6>

                    <h6>4. Pengguna Hanya Dapat Mengakses Layanan Dengan 1 Akun Untuk 1 Orang Saja.</h6>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Form Update Data Warga -->
    <div class="modal fade" id="updateDataWargaModal" tabindex="-1" role="dialog" aria-labelledby="updateDataWargaLabel"
        aria-hidden="true">
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
                            <input type="text" name="telegram_number" id="telegram_number" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
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
