<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'product_code' => 'required',
            'description' => 'required',
            'category_id' => 'required',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'product_code' => 'required|string|max:50',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Temukan produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Perbarui produk
        $product->update($validated);

        // Kirim pesan sukses
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }


    public function destroy($id)
{
    $product = Product::find($id);

    if ($product) {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    return redirect()->route('products.index')->with('error', 'Product not found.');
}


}
