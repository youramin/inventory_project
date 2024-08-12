<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockEntry;
use App\Models\StockExit;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalStockEntry = StockEntry::sum('quantity');
        $totalStockExit = StockExit::sum('quantity');
        $currentStock = $totalStockEntry - $totalStockExit;

        // Ambil kategori dan jumlah stok per kategori
        $categories = Category::withCount('products')->get();
        $categoryNames = $categories->pluck('name');
        $productCounts = $categories->pluck('products_count');

        return view('dashboard', compact('totalProducts', 'totalStockEntry', 'totalStockExit', 'currentStock', 'categoryNames', 'productCounts'));
    }
}
