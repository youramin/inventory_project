@extends('layouts.app')

@section('title', 'Pengguna')

@section('contents')
<div class="container-fluid">
    <hr />

    <!-- Button to create a new user -->
    <div class="mb-3">
        <a href="{{ route('users.create') }}" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
                <i class="fa fa-user-plus" aria-hidden="true"></i>
            </span>
            <span class="text">Buat Akun</span>
        </a>
    </div>
    

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Manajemen Pengguna</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Peran Pengguna</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-warning btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                                        </span>
                                        <span class="text">Edit</span>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-icon-split" onclick="confirmDelete({{ $user->id }})">
                                        <span class="icon text-white-50">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </span>
                                        <span class="text">Hapus</span>
                                    </a>
                                    
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>                                                           
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
    Swal.fire({
        title: 'Anda Yakin?',
        text: "Akun yang dihapus tidak dapat kembali",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus',
        cancelButtonText : 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>

@if(Session::has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: '{{ Session::get('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

@endsection
