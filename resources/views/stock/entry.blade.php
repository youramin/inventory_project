@extends('layouts.app')

@section('title')

@section('contents')
    <div class="container">
        <h1 class="mb-0">Stock Entry</h1>
        <hr />

        <form action="{{ route('stock.storeEntry') }}" method="POST" id="stockEntryForm">
            @csrf
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control" id="categorySelect">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Product</label>
                <select name="product_id" class="form-control" id="productSelect">
                    <option value="">Select Product</option>
                    <!-- Options will be loaded dynamically -->
                </select>
                @error('product_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Supplier</label>
                <select name="supplier_id" class="form-control">
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
                @error('supplier_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" placeholder="Quantity" value="{{ old('quantity') }}">
                @error('quantity')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Entry Date</label>
                <input type="date" name="entry_date" class="form-control" value="{{ old('entry_date') }}">
                @error('entry_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="notes" placeholder="Description">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-icon-split mb-2">
                <span class="icon text-white-50">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                </span>
                <span class="text">Submit</span>
            </button>
        </form>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categorySelect = document.getElementById('categorySelect');
            const productSelect = document.getElementById('productSelect');

            // Handle category change
            categorySelect.addEventListener('change', function () {
                const categoryId = categorySelect.value;

                // Clear previous product options
                productSelect.innerHTML = '<option value="">Select Product</option>';

                if (categoryId) {
                    // Fetch products based on the selected category
                    fetch(`/products-by-category/${categoryId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.products.forEach(product => {
                                const option = document.createElement('option');
                                option.value = product.id;
                                option.textContent = product.title;
                                productSelect.appendChild(option);
                            });
                        });
                }
            });

            const form = document.getElementById('stockEntryForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to save this stock entry?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, save it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
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
