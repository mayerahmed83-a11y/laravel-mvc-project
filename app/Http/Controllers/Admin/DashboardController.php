<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        // Get statistics
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::whereIn('status', ['delivered', 'shipped'])->sum('total');
        
        // User breakdown
        $adminCount = User::where('role', 'admin')->count();
        $customerCount = User::where('role', 'customer')->count();
        
        // Product breakdown
        $productsInStock = Product::where('stock', '>', 0)->count();
        $outOfStockProducts = Product::where('stock', '=', 0)->count();
        
        // Low stock products (stock <= 5)
        $lowStockProducts = Product::where('stock', '>', 0)
                                  ->where('stock', '<=', 5)
                                  ->orderBy('stock', 'asc')
                                  ->limit(10)
                                  ->get();
        
        // Recent orders (last 10)
        $recentOrders = Order::with('user')
                             ->orderBy('created_at', 'desc')
                             ->limit(10)
                             ->get();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalProducts', 
            'totalOrders',
            'totalRevenue',
            'adminCount',
            'customerCount',
            'productsInStock',
            'outOfStockProducts',
            'lowStockProducts',
            'recentOrders'
        ));
    }
}
