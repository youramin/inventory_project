<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stock History Entry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .h{
            border: none;
        }
        .header-table td {
            vertical-align: top;
            padding: 5px;
        }
        .logo {
            max-width: 100px; /* Adjust the size of the logo */
        }
        .address {
            font-size: 12px;
            border: none;
        }
        .address p {
            margin: 0;
            margin-right: 600px;
            padding: 5px;
            font-size: 12px;
        }
        .title {
            text-align: center;
            margin: 20px 0;
            font-size: 16px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table.data-table, th, td {
            border: 1px solid black; /* Border for data table and cells */
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table class="header-table">
        <tr class="h">
            <td class="h"><img src="data:{{ $logoMime }};base64,{{ $logoData }}" alt="Company Logo" class="logo"></td>
            <td class="address">
                <p>PT. Vista Media</p>
                <p>Jln. Pulau Kawe No. 40</p>
                <p>Denpasar, Bali</p>
                <p>Phone: +62 361 230000</p>
            </td>
        </tr>
    </table>
    
    <div class="title">Stock History Entry</div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Date</th>
                <th>Product</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Suppplier</th>
                <th>Notes</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @forelse($entries as $index => $entry)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($entry->entry_date)->format('d-m-Y') }}</td>
                    <td>{{ $entry->product->title }}</td>
                    <td>{{ $entry->product->category ? $entry->product->category->name : 'Category not found' }}</td>
                    <td>+{{ $entry->quantity }}</td>
                    <td>{{ $entry->supplier ? $entry->supplier->name : 'Supplier not found' }}</td>
                    <td>{{ $entry->notes }}</td>
                    <td>{{ $entry->user ? $entry->user->name : 'User not found' }}</td>
                </tr>
            @endforeach
            @if($entries->isEmpty())
                <tr>
                    <td colspan="6">No stock history entries found.</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
