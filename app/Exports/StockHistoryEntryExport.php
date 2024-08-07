<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\StockEntry;

class StockHistoryEntryExport implements FromQuery, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($filters)
    {
        $this->startDate = $filters['start_date'] ?? null;
        $this->endDate = $filters['end_date'] ?? null;
    }

    public function query()
    {
        return StockEntry::query()
            ->when($this->startDate, function ($query) {
                $query->whereDate('entry_date', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('entry_date', '<=', $this->endDate);
            })
            ->with('product.category', 'supplier', 'user');
    }

    public function headings(): array
    {
        return [
            'Waktu',
            'Produk',
            'Kategori',
            'Jumlah Stok',
            'Harga Satuan',
            'Harga Total',
            'Pemasok',
            'Keterangan',
            'Pengguna Input',

        ];
    }

    public function map($entry): array
    {
        return [
            \Carbon\Carbon::parse($entry->entry_date)->format('d-m-Y'),
            $entry->product->title,
            $entry->product->category ? $entry->product->category->name : 'Category not found',
            $entry->quantity,
            $entry->unit_price,
            $entry->unit_price * $entry->quantity,
            $entry->supplier ? $entry->supplier->name : 'Supplier not found',
            $entry->notes,
            $entry->user ? $entry->user->name : 'User not found',
        ];
    }
}

