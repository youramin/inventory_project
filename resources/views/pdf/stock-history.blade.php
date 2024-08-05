<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stock History</title>
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
            padding: 5px; /* Adjusted padding for closer proximity */
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
    
    <div class="title">Stock History</div>
    
    <table class="data-table">
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
            @foreach($entries as $entry)
                <tr>
                    <td>{{ $entry->entry_date }}</td>
                    <td>{{ $entry->product->title }}</td>
                    <td>{{ $entry->product->category->name }}</td>
                    <td>+{{ $entry->quantity }}</td>
                    <td>Entry</td>
                    <td>{{ $entry->notes }}</td>
                    <td>{{ $entry->user ? $entry->user->name : 'N/A' }}</td>  
                </tr>
            @endforeach
            @foreach($exits as $exit)
                <tr>
                    <td>{{ $exit->exit_date }}</td>
                    <td>{{ $exit->product->title }}</td>
                    <td>{{ $exit->product->category->name }}</td>
                    <td>-{{ $exit->quantity }}</td>
                    <td>Exit</td>
                    <td>{{ $exit->notes }}</td>
                    <td>{{ $exit->user ? $exit->user->name : 'N/A' }}</td>  
                </tr>
            @endforeach
            @if($entries->isEmpty() && $exits->isEmpty())
                <tr>
                    <td colspan="7">No stock history found.</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
