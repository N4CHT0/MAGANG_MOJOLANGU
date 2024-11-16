@extends('layouts.main')

@section('content')
    <style>
        #searchInput {
            width: 100%;
            padding: 10px 15px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        #searchInput:focus {
            border-color: #80bdff;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }
    </style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-body">
                        <div class="card-title">
                            <p>Data Pengguna Sistem</p>
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari...">
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->nama_lengkap }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if ($user->role === 'admin')
                                                    <span class="badge badge-primary">Admin</span>
                                                @elseif($user->role === 'rt')
                                                    <span class="badge badge-info">RT</span>
                                                @elseif($user->role === 'rw')
                                                    <span class="badge badge-warning">RW</span>
                                                @elseif($user->role === 'kelurahan')
                                                    <span class="badge badge-danger">Kelurahan</span>
                                                @elseif($user->role === 'warga')
                                                    <span class="badge badge-success">Warga</span>
                                                @else
                                                    <span class="badge badge-secondary">Tidak Terdefinisi</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info"><i
                                                            class="fa fa-eye"></i></a>
                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                        class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"><i
                                                                class="fa fa-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                    <!-- Baris untuk pesan "Tidak ada data" saat search -->
                                    <tr class="no-data">
                                        <td colspan="6" class="text-center">Tidak ada data</td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#filterModal">Filter
                                & Export</a>
                            <a href="{{ route('users.export.all') }}" class="btn btn-success">Export
                                All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Filter & Export -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.export') }}" method="GET">
                        <div class="form-group">
                            <label for="rw">Pilih RW</label>
                            <select id="rw" name="rw" class="form-control">
                                @foreach ($users->unique('rw') as $user)
                                    <option value="{{ $user->rw }}">{{ $user->rw }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rt">Pilih RT</label>
                            <select id="rt" name="rt" class="form-control">
                                @foreach ($users->unique('rt') as $user)
                                    <option value="{{ $user->rt }}" data-rw="{{ $user->rw }}">{{ $user->rt }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Export to Excel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#rw').on('change', function() {
                var selectedRw = $(this).val();
                $('#rt option').each(function() {
                    var option = $(this);
                    if (option.data('rw') == selectedRw) {
                        option.show();
                    } else {
                        option.hide();
                    }
                });
                $('#rt').val($('#rt option:visible:first').val());
            });

            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                var rowCount = 0;

                $('.table tbody tr').each(function() {
                    var rowText = $(this).text().toLowerCase();
                    if (rowText.indexOf(value) > -1) {
                        $(this).show();
                        rowCount++;
                    } else {
                        $(this).hide();
                    }
                });

                // Tampilkan pesan "Tidak ada data" jika rowCount adalah 0
                if (rowCount === 0) {
                    $('.no-data').show();
                } else {
                    $('.no-data').hide();
                }
            });
        });
    </script>
@endsection
