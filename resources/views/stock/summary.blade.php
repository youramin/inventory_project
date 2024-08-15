@extends('layouts.app')

@section('title', 'Ringkasan Stok')

@section('contents')

    <p class="mb-4">Tabel ini memberikan gambaran mengenai pemasukan stok, pengeluaran stok, dan tingkat stok saat ini untuk setiap produk.</p>

    <!-- Stock Summary Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Rincian Stok Keseluruhan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Stok Masuk</th>
                            <th>Stok Keluar</th>
                            <th>Sisa Stok</th>
                            <th>Terakhir di Perbarui</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
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
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data produk</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
