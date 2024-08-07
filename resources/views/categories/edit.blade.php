@extends('layouts.app')

@section('title')

@section('contents')
    <div class="container">
        <h1 class="mb-0">Edit Kategori</h1>
        <hr />
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $category->name }}">
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Kode Kategori</label>
                    <input type="text" name="category_code" class="form-control" placeholder="Category Code" value="{{ $category->category_code }}">
                </div>
            </div>
            <button type="submit" class="btn btn-success btn-icon-split mb-2">
                <span class="icon text-white-50">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                </span>
                <span class="text">Perbarui Kategori</span>
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-danger btn-icon-split mb-2">
                <span class="icon text-white-50">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </span>
                <span class="text">Batal</span>
            </a>
        </form>
    </div>
   
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
