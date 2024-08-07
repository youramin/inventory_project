<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockEntry;
use App\Models\StockExit;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockHistoryExport;
use App\Exports\StockHistoryEntryExport;
use App\Exports\StockHistoryExitExport;

class StockController extends Controller
{
    public function entry()
    {
        $products = Product::all();
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('stock.entry', compact('products', 'categories', 'suppliers'));
    }

    public function storeEntry(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'entry_date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'unit_price' => 'nullable|numeric|min:0',
        ]);

        $product = Product::findOrFail($request->product_id);

        $unitPrice = $request->unit_price ?? 0; // Default to 0 if not provided
        $totalPrice = $unitPrice * $request->quantity;

        $stockEntry = StockEntry::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'notes' => $request->notes,
            'category_id' => $request->category_id,
            'entry_date' => $request->entry_date,
            'user_id' => auth()->id(),
            'supplier_id' => $request->supplier_id,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
            
        ]);

        $product->stock_quantity += $request->quantity;
        $product->save();

        return redirect()->route('stock.entry')->with('success', 'Stock entry recorded successfully.');
    }

    public function exit()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('stock.exit', compact('products', 'categories'));
    }

    public function storeExit(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'exit_date' => 'required|date',
            'category_id' => 'nullable|exists:categories,id',
            'person_taking_stock' => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);
        if ($product->stock_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock available.');
        }

        $stockExit = StockExit::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'notes' => $request->notes,
            'category_id' => $request->category_id,
            'exit_date' => $request->exit_date,
            'user_id' => auth()->id(),
            'person_taking_stock' => $request->person_taking_stock,
        ]);

        $product->stock_quantity -= $request->quantity;
        $product->save();

        return redirect()->route('stock.exit')->with('success', 'Stock exit recorded successfully.');
    }

    public function getProductsByCategory($categoryId)
    {
        $products = Product::where('category_id', $categoryId)->get();
        return response()->json(['products' => $products]);
    }

    public function stock()
    {
        $products = Product::all();
        return view('stock.stock', compact('products'));
    }

    public function summary()
    {
        $products = Product::with('category')
            ->withSum('stockEntries', 'quantity')
            ->withSum('stockExits', 'quantity')
            ->get();

        $products = $products->map(function ($product) {
            $latestEntry = $product->stockEntries()->orderBy('entry_date', 'desc')->first();
            $latestExit = $product->stockExits()->orderBy('exit_date', 'desc')->first();
            $latestDate = null;

            if ($latestEntry && $latestExit) {
                $latestDate = $latestEntry->entry_date > $latestExit->exit_date ? $latestEntry->entry_date : $latestExit->exit_date;
            } elseif ($latestEntry) {
                $latestDate = $latestEntry->entry_date;
            } elseif ($latestExit) {
                $latestDate = $latestExit->exit_date;
            }

            // Set latest stock update as a Carbon instance
            $product->latest_stock_update = $latestDate ? \Carbon\Carbon::parse($latestDate) : null;

            // Calculate current stock
            $product->current_stock = ($product->stock_entries_sum_quantity ?? 0) - ($product->stock_exits_sum_quantity ?? 0);

            return $product;
        });

        return view('stock.summary', compact('products'));
    }

    public function history()
    {
        $entries = StockEntry::with('product.category', 'user')->get();
        $exits = StockExit::with('product.category', 'user')->get();

        return view('stock.history', compact('entries', 'exits'));
    }

    public function indexHistoryEntry(Request $request)
    {
        $query = StockEntry::query();

        // Apply date filter if present
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereBetween('entry_date', [$startDate, $endDate]);
        }

        $entries = $query->get();

        return view('stock.history-entry', compact('entries'));
    }

    public function indexHistoryExit(Request $request)
    {
        $query = StockExit::query();

        // Apply date filter if present
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereBetween('exit_date', [$startDate, $endDate]);
        }

        $exits = $query->get();

        return view('stock.history-exit', compact('exits'));
    }

    // Download Pdf for Stock History Entry
    public function downloadHistoryEntryPdf(Request $request)
    {
        $query = StockEntry::query();

        // Apply date filter if present
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereBetween('entry_date', [$startDate, $endDate]);
        }

        $entries = $query->with('product.category', 'user')->get();

        $logoPath = public_path('logo/logo-vm.png');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoMime = mime_content_type($logoPath);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $pdf = new Dompdf($options);

        $pdf->loadHtml(view('stock.history-entry-pdf', compact('entries', 'logoData', 'logoMime'))->render());
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        return $pdf->stream('stock_history_entry.pdf');
    }

    // Download Excel for Stock History Entry
    public function downloadHistoryEntryExcel(Request $request)
    {
        return Excel::download(new StockHistoryEntryExport($request->all()), 'stock_history_entry.xlsx');
    }

    // Download PDF for Stock History Exit
    public function downloadHistoryExitPdf(Request $request)
    {
        $query = StockExit::query();

        // Apply date filter if present
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereBetween('exit_date', [$startDate, $endDate]);
        }

        $exits = $query->with('product.category', 'user')->get();

        $logoPath = public_path('logo/logo-vm.png');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoMime = mime_content_type($logoPath);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $pdf = new Dompdf($options);

        $pdf->loadHtml(view('stock.history-exit-pdf', compact('exits', 'logoData', 'logoMime'))->render());
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        return $pdf->stream('stock_history_exit.pdf');
    }

    // Download Excel for Stock History Exit
    public function downloadHistoryExitExcel(Request $request)
    {
        return Excel::download(new StockHistoryExitExport($request->all()), 'stock_history_exit.xlsx');
    }


    public function filterHistory(Request $request)
    {
        $date = $request->input('date');
        $month = $request->input('month');
        $year = $request->input('year');
        $filterCategory = $request->input('filterCategory');

        $entriesQuery = StockEntry::with('product.category', 'user');
        $exitsQuery = StockExit::with('product.category', 'user');

        if ($date) {
            list($year, $month, $day) = explode('-', $date);
            $entriesQuery->whereYear('entry_date', $year)
                         ->whereMonth('entry_date', $month)
                         ->whereDay('entry_date', $day);
            $exitsQuery->whereYear('exit_date', $year)
                       ->whereMonth('exit_date', $month)
                       ->whereDay('exit_date', $day);
        } elseif ($month && $year) {
            $entriesQuery->whereYear('entry_date', $year)
                         ->whereMonth('entry_date', $month);
            $exitsQuery->whereYear('exit_date', $year)
                       ->whereMonth('exit_date', $month);
        } elseif ($year) {
            $entriesQuery->whereYear('entry_date', $year);
            $exitsQuery->whereYear('exit_date', $year);
        }

        if ($filterCategory === 'entry') {
            $entries = $entriesQuery->orderBy('entry_date', 'desc')->get();
            $exits = collect(); // Empty collection for exits
        } elseif ($filterCategory === 'exit') {
            $entries = collect(); // Empty collection for entries
            $exits = $exitsQuery->orderBy('exit_date', 'desc')->get();
        } else {
            $entries = $entriesQuery->orderBy('entry_date', 'desc')->get();
            $exits = $exitsQuery->orderBy('exit_date', 'desc')->get();
        }

        return view('stock.history', compact('entries', 'exits', 'date', 'month', 'year'));
    }

    public function generatePDF(Request $request)
    {
        $date = $request->query('date');
        $month = $request->query('month');
        $year = $request->query('year');
        $filterCategory = $request->query('filterCategory');

        $entriesQuery = StockEntry::with('product.category', 'user');
        $exitsQuery = StockExit::with('product.category', 'user');

        if ($date) {
            list($year, $month, $day) = explode('-', $date);
            $entriesQuery->whereYear('entry_date', $year)
                         ->whereMonth('entry_date', $month)
                         ->whereDay('entry_date', $day);
            $exitsQuery->whereYear('exit_date', $year)
                       ->whereMonth('exit_date', $month)
                       ->whereDay('exit_date', $day);
        } elseif ($month && $year) {
            $entriesQuery->whereYear('entry_date', $year)
                         ->whereMonth('entry_date', $month);
            $exitsQuery->whereYear('exit_date', $year)
                       ->whereMonth('exit_date', $month);
        } elseif ($year) {
            $entriesQuery->whereYear('entry_date', $year);
            $exitsQuery->whereYear('exit_date', $year);
        }

        if ($filterCategory === 'entry') {
            $entries = $entriesQuery->get();
            $exits = collect(); // Empty collection for exits
        } elseif ($filterCategory === 'exit') {
            $entries = collect(); // Empty collection for entries
            $exits = $exitsQuery->get();
        } else {
            $entries = $entriesQuery->get();
            $exits = $exitsQuery->get();
        }

        $logoPath = public_path('logo/logo-vm.png');
        $logoData = base64_encode(file_get_contents($logoPath));
        $logoMime = mime_content_type($logoPath);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $pdf = new Dompdf($options);

        $pdf->loadHtml(view('pdf.stock-history', compact('entries', 'exits', 'logoData', 'logoMime'))->render());
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        return $pdf->stream('stock-history.pdf');
    }

    public function exportExcel(Request $request)
    {
        $date = $request->query('date');
        $month = $request->query('month');
        $year = $request->query('year');
        $filterCategory = $request->query('filterCategory');

        $entriesQuery = StockEntry::with('product.category', 'user');
        $exitsQuery = StockExit::with('product.category', 'user');

        if ($date) {
            list($year, $month, $day) = explode('-', $date);
            $entriesQuery->whereYear('entry_date', $year)
                         ->whereMonth('entry_date', $month)
                         ->whereDay('entry_date', $day);
            $exitsQuery->whereYear('exit_date', $year)
                       ->whereMonth('exit_date', $month)
                       ->whereDay('exit_date', $day);
        } elseif ($month && $year) {
            $entriesQuery->whereYear('entry_date', $year)
                         ->whereMonth('entry_date', $month);
            $exitsQuery->whereYear('exit_date', $year)
                       ->whereMonth('exit_date', $month);
        } elseif ($year) {
            $entriesQuery->whereYear('entry_date', $year);
            $exitsQuery->whereYear('exit_date', $year);
        }

        if ($filterCategory === 'entry') {
            $entries = $entriesQuery->get();
            $exits = collect(); // Empty collection for exits
        } elseif ($filterCategory === 'exit') {
            $entries = collect(); // Empty collection for entries
            $exits = $exitsQuery->get();
        } else {
            $entries = $entriesQuery->get();
            $exits = $exitsQuery->get();
        }

        return Excel::download(new StockHistoryExport($entries, $exits), 'stock-history.xlsx');
    }
}
