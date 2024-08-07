<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\StockExit;

class StockHistoryExitExport implements FromQuery, WithHeadings, WithMapping
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
        return StockExit::query()
            ->when($this->startDate, function ($query) {
                $query->whereDate('exit_date', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('exit_date', '<=', $this->endDate);
            })
            ->with('product.category', 'user');
    }

    public function headings(): array
    {
        return [
            'Waktu',
            'Produk',
            'Kategori',
            'Jumlah Stok',
            'Penanggung Jawab',
            'Keterangan',
            'Pengguna Input',
        ];
    }

    public function map($exit): array
    {
        return [
            \Carbon\Carbon::parse($exit->exit_date)->format('d-m-Y'),
            $exit->product->title,
            $exit->product->category ? $exit->product->category->name : 'Category not found',
            $exit->quantity,
            $exit->person_taking_stock,
            $exit->notes,
            $exit->user ? $exit->user->name : 'User not found',
        ];
    }
}

