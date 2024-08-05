<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockHistoryExport implements FromCollection, WithHeadings
{
    protected $entries;
    protected $exits;

    public function __construct($entries, $exits)
    {
        $this->entries = $entries;
        $this->exits = $exits;
    }

    public function collection()
    {
        $data = [];

        foreach ($this->entries as $entry) {
            $data[] = [
                $entry->entry_date,
                $entry->product->title,
                $entry->product->category->name,
                '+' . $entry->quantity,
                'Entry',
                $entry->notes,
                $entry->user ? $entry->user->name : 'N/A',
            ];
        }

        foreach ($this->exits as $exit) {
            $data[] = [
                $exit->exit_date,
                $exit->product->title,
                $exit->product->category->name,
                '-' . $exit->quantity,
                'Exit',
                $exit->notes,
                $exit->user ? $exit->user->name : 'N/A',
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Date',
            'Product',
            'Category',
            'Quantity',
            'Entry/Exit',
            'Notes',
            'User'
        ];
    }
}

