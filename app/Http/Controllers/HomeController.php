<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Display the home page with featured products
     */
    public function index()
    {
        // Get featured products (first 6 products with stock > 0)
        $featuredProducts = Product::where('stock', '>', 0)
            ->take(6)
            ->get();

        return view('home', compact('featuredProducts'));
    }
}
