<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display all products for customers
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Brand filter
        if ($request->has('brand') && $request->brand) {
            $query->where('brand', $request->brand);
        }

        // Price filter
        if ($request->has('price_min') && $request->price_min) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->has('price_max') && $request->price_max) {
            $query->where('price', '<=', $request->price_max);
        }

        // Only show products in stock
        $query->where('stock', '>', 0);

        $products = $query->paginate(12);
        $brands = Product::select('brand')->distinct()->pluck('brand');

        return view('shop.index', compact('products', 'brands'));
    }

    /**
     * Show product details
     */
    public function show(Product $product)
    {
        return view('shop.show', compact('product'));
    }
}
