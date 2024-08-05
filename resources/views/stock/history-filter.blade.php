@extends('layouts.app')

@section('content')
<h1>Filtered Stock History</h1>
<p>From: {{ $startDate }} To: {{ $endDate }}</p>
<table>
    <thead>
        <tr>
            <th>Product</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($entries as $entry)
        <tr>
            <td>{{ $entry->product->name }}</td>
            <td>Entry</td>
            <td>{{ $entry->quantity }}</td>
            <td>{{ $entry->created_at }}</td>
        </tr>
        @endforeach

        @foreach($exits as $exit)
        <tr>
            <td>{{ $exit->product->name }}</td>
            <td>Exit</td>
            <td>{{ $exit->quantity }}</td>
            <td>{{ $exit->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Form untuk kembali ke semua history -->
<form action="{{ route('stock.history') }}" method="GET">
    <button type="submit">Back to All History</button>
</form>
@endsection
