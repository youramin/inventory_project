@extends('layouts.app')

@section('title', 'Stock History')

@section('styles')
<!-- Include Font Awesome CSS for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
@endsection

@section('contents')
<div class="container-fluid">
    <form action="{{ route('filterHistory') }}" method="GET" class="form-inline mb-4">
        <div class="form-group mb-2">
            <label for="date" class="mr-2">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ request('date') }}">
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <label for="month" class="mr-2">Month</label>
            <input type="number" class="form-control" id="month" name="month" value="{{ request('month') }}" min="1" max="12">
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <label for="year" class="mr-2">Year</label>
            <input type="number" class="form-control" id="year" name="year" value="{{ request('year') }}" min="2000" max="{{ date('Y') }}">
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <label for="filterCategory" class="mr-2">Category</label>
            <select id="filterCategory" name="filterCategory" class="form-control">
                <option value="">All</option>
                <option value="entry" {{ request('filterCategory') === 'entry' ? 'selected' : '' }}>Entry</option>
                <option value="exit" {{ request('filterCategory') === 'exit' ? 'selected' : '' }}>Exit</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary btn-icon-split mb-2">
            <span class="icon text-white-50">
                <i class="fa fa-filter" aria-hidden="true"></i>
            </span>
            <span class="text">Filter</span>
        </button>        
    </form>

    <div class="mb-4">
        <!-- Update the route with parameters for PDF generation -->
        <a href="{{ route('generate.pdf', ['date' => request('date'), 'month' => request('month'), 'year' => request('year')]) }}" class="btn btn-danger btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file-pdf" aria-hidden="true"></i>
            </span>
            <span class="text">Generated PDF</span>
        </a>
        <!-- Add link to export Excel -->
        <a href="{{route('export.excel', ['date' => request('date'), 'month' => request('month'), 'year' => request('year')]) }}" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-file-excel" aria-hidden="true"></i>
            </span>
            <span class="text">Generated Excel</span>
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Stock History</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="stock-history-table">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Entry/Exit</th>
                            <th>Notes</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Render entries and exits -->
                        @foreach($entries as $entry)
                            <tr>
                                <td>{{ $entry->entry_date }}</td>
                                <td>{{ $entry->product->title }}</td>
                                <td>{{ $entry->product->category ? $entry->product->category->name : 'Category not found' }}</td>
                                <td>+{{ $entry->quantity }}</td>
                                <td>Entry</td>
                                <td>{{ $entry->notes }}</td>
                                <td>{{ $entry->user ? $entry->user->name : 'User not found' }}</td>                       
                            </tr>
                        @endforeach
                        @foreach($exits as $exit)
                            <tr>
                                <td>{{ $exit->exit_date }}</td>
                                <td>{{ $exit->product->title }}</td>
                                <td>{{ $exit->product->category ? $exit->product->category->name : 'Category not found' }}</td>
                                <td>-{{ $exit->quantity }}</td>
                                <td>Exit</td>
                                <td>{{ $exit->notes }}</td>
                                <td>{{ $exit->user ? $exit->user->name : 'User not found' }}</td>
                            </tr>
                        @endforeach
                        @if($entries->isEmpty() && $exits->isEmpty())
                            <tr>
                                <td colspan="7">No stock history found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection