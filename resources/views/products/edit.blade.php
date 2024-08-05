@extends('layouts.app')
  
@section('title')
  
@section('contents')
    <div class="container">
        <h1 class="mb-0">Edit Product</h1>
        <hr />
        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Title" value="{{ old('title', $product->title) }}">
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label class="form-label">Price</label>
                    <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="Price" value="{{ old('price', $product->price) }}">
                    @error('price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Product Code</label>
                    <input type="text" name="product_code" class="form-control @error('product_code') is-invalid @enderror" placeholder="Product Code" value="{{ old('product_code', $product->product_code) }}">
                    @error('product_code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Description">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-success btn-icon-split mb-2">
                <span class="icon text-white-50">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                </span>
                <span class="text">Update Product</span>
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-danger btn-icon-split mb-2">
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
