@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <p>Data Kriteria</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah
                            Kriteria</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pembangunan</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->nama_kriteria }}</td>
                                        <td>{{ $item->deskripsi }}</td>
                                        <td>
                                            <button class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editModal" data-id="{{ $item->id }}"
                                                data-nama="{{ $item->nama_kriteria }}"
                                                data-deskripsi="{{ $item->deskripsi }}">Edit</button>
                                            <button class="btn btn-danger delete-btn"
                                                data-id="{{ $item->id }}">Hapus</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Kriteria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createForm">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
                            <input type="text" class="form-control" id="nama_kriteria" name="nama_kriteria" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Kriteria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        @csrf
                        @method('PUT') <!-- Method Override -->
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_nama_kriteria" class="form-label">Nama Kriteria</label>
                            <input type="text" class="form-control" id="edit_nama_kriteria" name="nama_kriteria"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="edit_deskripsi" name="deskripsi" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Handle create form submission
        $('#createForm').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: "{{ route('kriteria.store') }}",
                method: "POST",
                data: formData,
                success: function(response) {
                    location.reload();
                }
            });
        });

        // Handle edit form submission
        $('#editModal').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget); // Tombol yang men-trigger modal
            let id = button.data('id'); // Ambil ID dari tombol
            let nama = button.data('nama'); // Ambil nama dari tombol
            let deskripsi = button.data('deskripsi'); // Ambil deskripsi dari tombol

            let modal = $(this);
            modal.find('#edit_id').val(id);
            modal.find('#edit_nama_kriteria').val(nama);
            modal.find('#edit_deskripsi').val(deskripsi);
        });


        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            let id = $('#edit_id').val(); // Ambil ID
            let formData = $(this).serialize(); // Serialize form

            $.ajax({
                url: "{{ url('kriteria') }}/" + id, // Gunakan url() helper
                method: "PUT",
                data: formData,
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Gagal mengupdate data. Coba lagi.');
                    console.error(xhr.responseText);
                }
            });
        });


        // Handle delete
        $('.delete-btn').on('click', function() {
            let id = $(this).data('id'); // Ambil ID dari tombol

            if (confirm("Apakah Anda yakin ingin menghapus kriteria ini?")) {
                $.ajax({
                    url: "{{ url('kriteria') }}/" + id, // URL dengan ID
                    method: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}" // Sertakan CSRF token
                    },
                    success: function(response) {
                        alert(response.message); // Tampilkan pesan sukses
                        location.reload(); // Reload halaman
                    },
                    error: function(xhr) {
                        alert('Gagal menghapus data. Coba lagi.');
                        console.error(xhr.responseText); // Debugging
                    }
                });
            }
        });
    </script>
@endsection
