@extends('layouts.app')

@section('title')

@section('contents')
    <div class="container">
        <h1 class="mb-0">Stok Keluar</h1>
        <hr />

        <form action="{{ route('stock.storeExit') }}" method="POST" id="stockExitForm">
            @csrf
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="category_id" class="form-control" id="categorySelect">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Produk</label>
                <select name="product_id" class="form-control" id="productSelect">
                    <option value="">Pilih Produk</option>
                    <!-- Options will be loaded dynamically -->
                </select>
                @error('product_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Jumlah Stok Keluar</label>
                <input type="number" name="quantity" class="form-control" placeholder="Jumlah Stok" value="{{ old('quantity') }}">
                @error('quantity')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Penanggung Jawab</label>
                <input type="text" name="person_taking_stock" class="form-control" placeholder="Nama Orang" value="{{ old('person_taking_stock') }}">
                @error('person_taking_stock')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>            
            <div class="mb-3">
                <label class="form-label">Waktu Keluar</label>
                <input type="date" name="exit_date" class="form-control" value="{{ old('exit_date') }}">
                @error('exit_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea class="form-control" name="notes" placeholder="Description">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-icon-split mb-2">
                <span class="icon text-white-50">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                </span>
                <span class="text">Tambah</span>
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

            const form = document.getElementById('stockExitForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Apa Anda Yakin?',
                    text: "Menambahkan data ke riwayat stok keluar?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText : 'Batal'
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
            title: 'Sukses',
            text: '{{ Session::get('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    @endif
@endsection
