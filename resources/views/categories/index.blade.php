@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('contents')
<div class="container-fluid">
    <hr />

    <div class="mb-3">
        <a href="{{ route('categories.create') }}" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
            </span>
            <span class="text">Tambah Kategori</span>
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Kategori</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="table-primary">
                        <tr>
                            <th>No.</th>
                            <th>Nama Kategori</th>
                            <th>Kode Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->category_code }}</td>
                                <td>
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                                            </span>
                                            <span class="text">Edit</span>
                                        </a>
                                        <a href="#" class="btn btn-danger btn-icon-split" onclick="confirmDelete({{  $category->id  }})">
                                            <span class="icon text-white-50">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </span>
                                            <span class="text">Hapus</span>
                                        </a>
                                        
                                        <form id="delete-form-{{ $category->id  }}" action="{{ route('categories.destroy', $category) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="3">Tidak ada daftar kategori</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(categoryId) {
        Swal.fire({
            title: 'Apa anda yakin?',
            text: "Menghapus Kategori Tidak Dapat Kembali",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText : 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + categoryId).submit();
            }
        })
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
