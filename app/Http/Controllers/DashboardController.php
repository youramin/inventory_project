<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockEntry;
use App\Models\StockExit;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalStockEntry = StockEntry::sum('quantity');
        $totalStockExit = StockExit::sum('quantity');
        $currentStock = $totalStockEntry - $totalStockExit;

        return view('dashboard', compact('totalProducts', 'totalStockEntry', 'totalStockExit', 'currentStock'));
    }
}
