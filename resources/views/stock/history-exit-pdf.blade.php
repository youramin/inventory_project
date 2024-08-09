<!DOCTYPE html>
<html>
<head>
    <title>Stock History Exit</title>
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
        img {
            max-width: 100px; /* Set maximum width for images */
            max-height: 100px; /* Set maximum height for images */
            object-fit: cover; /* Ensure the image scales nicely */
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
    
    <div class="title">Stock History Exit</div>

    <table class="data-table">
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
</body>
</html>
