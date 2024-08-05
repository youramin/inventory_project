@extends('layouts.app')

@section('title')

@section('contents')
<div class="container">
    <h1>Add Supplier</h1>
    <hr/>
    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="contact_person">Contact Person</label>
            <input type="text" class="form-control" id="contact_person" name="contact_person" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" id="address" name="address"></textarea>
        </div>
        <button type="submit" class="btn btn-success btn-icon-split mb-2">
            <span class="icon text-white-50">
                <i class="fa fa-check-circle" aria-hidden="true"></i>
            </span>
            <span class="text">Save</span>
        </button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-danger btn-icon-split mb-2">
            <span class="icon text-white-50">
                <i class="fa fa-times-circle" aria-hidden="true"></i>
            </span>
            <span class="text">Cancel</span>
        </a>
    </form>
</div>
@endsection
