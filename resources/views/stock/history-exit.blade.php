@extends('layouts.app')

@section('title', 'Riwayat Stok Keluar')

@section('contents')
<div class="container-fluid">
    <!-- Filter Form -->
    <form method="GET" action="{{ route('stock.history.exit') }}">
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
        <a href="{{  route('stock.history.exit.pdf', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-danger btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file-pdf" aria-hidden="true"></i>
            </span>
            <span class="text">Unduh PDF</span>
        </a>
        <a href="{{route('stock.history.exit.excel', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-success btn-icon-split">
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
                            <th>Penanggung Jawab</th>
                            <th>Keterangan</th>
                            <th>Pengguna Input</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exits as $index => $exit)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($exit->exit_date)->format('d-m-Y') }}</td>
                                <td>
                                    @if($exit->product->image)
                                        <img src="{{ asset('storage/' . $exit->product->image) }}" alt="Product Image" style="max-width: 100px;">
                                    @else
                                        Tidak Ada Gambar
                                    @endif
                                </td>
                                <td>{{ $exit->product->title }}</td>
                                <td>{{ $exit->product->category ? $exit->product->category->name : 'Kategori Tidak Ditemukan' }}</td>
                                <td>-{{ $exit->quantity }}</td>
                                <td>{{ $exit->person_taking_stock }}</td>
                                <td>{{ $exit->notes }}</td>
                                <td>{{ $exit->user ? $exit->user->name : 'Pengguna Tidak Ditemukan' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">Tidak ada riwayat stok</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
