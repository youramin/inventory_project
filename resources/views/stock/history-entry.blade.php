@extends('layouts.app')

@section('title', 'Riwayat Stok Masuk')

@section('contents')
<div class="container-fluid">
    <hr>
    <!-- Filter Form -->
    <form method="GET" action="{{ route('stock.history.entry') }}">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="start_date">Waktu Awal:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4">
                <label for="end_date">Waktu Akhir:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fa fa-filter" aria-hidden="true"></i>
                    </span>
                    <span class="text">Filter</span>
                </button> 
            </div>
        </div>
    </form>

    <!-- Download Buttons -->
    <div class="mb-3">
        <a href="{{ route('stock.history.entry.pdf', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-danger btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file-pdf" aria-hidden="true"></i>
            </span>
            <span class="text">Unduh PDF</span>
        </a>
        <a href="{{ route('stock.history.entry.excel', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file-excel" aria-hidden="true"></i>
            </span>
            <span class="text">Unduh Excel</span>
        </a>
    </div>

    <div class="card shadow mb-4"> 
        <div class="card-body">
            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Waktu</th>
                            <th>Gambar</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Jumlah Stok</th>
                            <th>Harga Satuan</th>
                            <th>Harga Total</th>
                            <th>Pemasok</th>
                            <th>Keterangan</th>
                            <th>Pengguna Input</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entries as $index => $entry)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($entry->entry_date)->format('d-m-Y') }}</td>
                                <td>
                                    @if($entry->product->image)
                                        <img src="{{ asset('storage/' . $entry->product->image) }}" alt="Product Image" style="max-width: 100px;">
                                    @else
                                        Tidak Ada Gambar
                                    @endif
                                </td>
                                <td>{{ $entry->product->title }}</td>
                                <td>{{ $entry->product->category ? $entry->product->category->category_code : 'Kategori Tidak Ditemukan' }}</td>
                                <td>+{{ $entry->quantity }}</td>
                                <td>{{ $entry->unit_price ? number_format($entry->unit_price, 2) : 'Harga Tidak Ditemukan' }}</td>
                                <td>{{ $entry->total_price ? number_format($entry->total_price, 2) : 'Harga Tidak Ditemukan' }}</td>
                                <td>{{ $entry->supplier ? $entry->supplier->name : 'Pemasok Tidak Ditemukan' }}</td>
                                <td>{{ $entry->notes }}</td>
                                <td>{{ $entry->user ? $entry->user->name : 'Pengguna Tidak Ditemukan' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11">Tidak ada riwayat stok</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
