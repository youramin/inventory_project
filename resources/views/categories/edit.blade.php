@extends('layouts.app')

@section('title')

@section('contents')
    <div class="container">
        <h1 class="mb-0">Edit Category</h1>
        <hr />
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $category->name }}">
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Category Code</label>
                    <input type="text" name="category_code" class="form-control" placeholder="Category Code" value="{{ $category->category_code }}">
                </div>
            </div>
            <button type="submit" class="btn btn-success btn-icon-split mb-2">
                <span class="icon text-white-50">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                </span>
                <span class="text">Update Category</span>
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-danger btn-icon-split mb-2">
                <span class="icon text-white-50">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </span>
                <span class="text">Cancel</span>
            </a>
        </form>
    </div>
   
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
