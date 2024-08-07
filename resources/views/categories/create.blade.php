@extends('layouts.app')

@section('title')

@section('contents')
    <div class="container">
        <h1>{{ isset($category) ? 'Edit Category' : 'Tambah Kategori' }}</h1>
        <hr/>
        <form action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}" method="POST">
            @csrf
            @if(isset($category))
                @method('PUT')
            @endif
            <div class="mb-3">
                <label for="name" class="form-label">Nama Kategori</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $category->name ?? '') }}">
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Kode Kategori</label>
                    <input type="text" name="category_code" class="form-control" id="category_code" value="{{ old('category_code', $category->category_code ?? '') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-success btn-icon-split mb-2">
                <span class="icon text-white-50">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                </span>
                <span class="text">{{ isset($category) ? 'Update' : 'Tambah' }} Kategori</span>
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
