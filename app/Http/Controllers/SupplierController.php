<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        // Only allow access to create supplier for authenticated users
        if (Auth::check()) {
            return view('suppliers.create');
        }
        
        return redirect()->route('login')->with('error', 'You need to be logged in to create a supplier.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
        ]);

        Supplier::create($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    public function edit(Supplier $supplier)
    {
        // Only allow editing for admin users
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('suppliers.edit', compact('supplier'));
        }
        
        return redirect()->route('suppliers.index')->with('error', 'You do not have permission to edit suppliers.');
    }

    public function update(Request $request, Supplier $supplier)
    {
        // Only allow updating for admin users
        if (Auth::check() && Auth::user()->role === 'admin') {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'email' => 'nullable|email',
                'address' => 'nullable|string',
            ]);

            $supplier->update($request->all());
            return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
        }
        
        return redirect()->route('suppliers.index')->with('error', 'You do not have permission to update suppliers.');
    }

    public function destroy(Supplier $supplier)
    {
        // Only allow deleting for admin users
        if (Auth::check() && Auth::user()->role === 'admin') {
            $supplier->delete();
            return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
        }

        return redirect()->route('suppliers.index')->with('error', 'You do not have permission to delete suppliers.');
    }
}
