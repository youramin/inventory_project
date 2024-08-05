@extends('layouts.app')

@section('title', 'Stock History Exit')

@section('contents')
<div class="container-fluid">
    <!-- Filter Form -->
    <form method="GET" action="{{ route('stock.history.exit') }}">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-4">
                <label for="end_date">End Date:</label>
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
            <span class="text">Download PDF</span>
        </a>
        <a href="{{route('stock.history.exit.excel', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file-excel" aria-hidden="true"></i>
            </span>
            <span class="text">Download Excel</span>
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
                            <th>Date</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Notes</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exits as $index => $exit)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($exit->exit_date)->format('d-m-Y') }}</td>
                                <td>{{ $exit->product->title }}</td>
                                <td>{{ $exit->product->category ? $exit->product->category->name : 'Category not found' }}</td>
                                <td>-{{ $exit->quantity }}</td>
                                <td>{{ $exit->notes }}</td>
                                <td>{{ $exit->user ? $exit->user->name : 'User not found' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No stock history exits found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
