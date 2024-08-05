@extends('layouts.app')

@section('title', 'Stock Summary')

@section('contents')

    <p class="mb-4">This table provides an overview of stock entries, exits, and current stock levels for each product.</p>

    <!-- Stock Summary Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Stock Summary</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Stock Entries</th>
                            <th>Stock Exits</th>
                            <th>Current Stock</th>
                            <th>Last Stock Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->stock_entries_sum_quantity ?? 0 }}</td>
                                <td>{{ $product->stock_exits_sum_quantity ?? 0 }}</td>
                                <td>{{ $product->current_stock }}</td>
                                <td>
                                    @if ($product->latest_stock_update)
                                        {{ $product->latest_stock_update->format('Y-m-d') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
