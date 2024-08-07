@extends('layouts.app')

@section('title')

@section('contents')
<div class="container">
    <h1>Edit Data Pemasok</h1>
    <hr>
    <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $supplier->name }}" required>
        </div>
        <div class="form-group">
            <label for="phone">No. Telp</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $supplier->phone }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $supplier->email }}">
        </div>
        <div class="form-group">
            <label for="address">Alamat</label>
            <textarea class="form-control" id="address" name="address">{{ $supplier->address }}</textarea>
        </div>
        <button type="submit" class="btn btn-success btn-icon-split mb-2">
            <span class="icon text-white-50">
                <i class="fa fa-check-circle" aria-hidden="true"></i>
            </span>
            <span class="text">Perbarui</span>
        </button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-danger btn-icon-split mb-2">
            <span class="icon text-white-50">
                <i class="fa fa-times-circle" aria-hidden="true"></i>
            </span>
            <span class="text">Batal</span>
        </a>
    </form>
</div>
@endsection