@extends('layouts.app')

@section('title', 'List Categories')

@section('contents')
<div class="container-fluid">
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('categories.create') }}" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
            </span>
            <span class="text">Add Category</span>
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Categories</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Category Code</th>
                            <th>Name</th>
                            <th>Action</th>
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
                                            <span class="text">Delete</span>
                                        </a>
                                        
                                        <form id="delete-form-{{ $category->id  }}" action="{{ route('categories.destroy', $category) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="3">No categories found.</td>
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
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
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
        title: 'Success',
        text: '{{ Session::get('success') }}',
        showConfirmButton: false,
        timer: 2000
    });
</script>
@endif
@endsection
