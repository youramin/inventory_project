@extends('layouts.app')

@section('title', 'Home Product')

@section('contents')
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
            </span>
            <span class="text">Add Product</span>
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Products</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Product Code</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->product_code }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->category->name }}</td> <!-- Assuming 'name' is the attribute in Category model -->
                                <td>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                                        </span>
                                        <span class="text">Edit</span>
                                    </a>
                                    
                                    <a href="#" class="btn btn-danger btn-icon-split" onclick="confirmDelete({{ $product->id  }})">
                                        <span class="icon text-white-50">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </span>
                                        <span class="text">Delete</span>
                                    </a>
                                    
                                    <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product ) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                                     
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="7">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(productId) {
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
                document.getElementById('delete-form-' + productId).submit();
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
