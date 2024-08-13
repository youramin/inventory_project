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
            max-width: 100px; 
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
            border: 1px solid black; 
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px; 
            max-height: 100px; 
            object-fit: cover; 
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
                            <img src="data:image/{{ pathinfo($entry->product->image, PATHINFO_EXTENSION) }};base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $entry->product->image))) }}" alt="Product Image">
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
</body>
</html>
