@extends('layouts.app')

@section('title', 'Suppliers')

@section('contents')
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('suppliers.create') }}" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
            </span>
            <span class="text">Add Supplier</span>
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Supplier</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Contact Person</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            @if(Auth::check() && Auth::user()->role === 'admin')
                            <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->contact_person }}</td>
                                <td>{{ $supplier->phone }}</td>
                                <td>{{ $supplier->email }}</td>
                                <td>{{ $supplier->address }}</td>
                                @if(Auth::check() && Auth::user()->role === 'admin')
                                <td>
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                                        </span>
                                        <span class="text">Edit</span>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-icon-split" onclick="confirmDelete({{ $supplier->id  }})">
                                        <span class="icon text-white-50">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </span>
                                        <span class="text">Delete</span>
                                    </a>
                                    
                                    <form id="delete-form-{{$supplier->id }}" action="{{ route('suppliers.destroy', $supplier ) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="7">No suppliers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(supplierId) {
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
                    document.querySelector(`form[action*="${supplierId}"]`).submit();
                }
            });
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
