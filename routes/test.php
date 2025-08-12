<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

Route::get('/test-app', function () {
    try {
        // Test database connection
        $userCount = User::count();
        $productCount = Product::count();
        $orderCount = Order::count();
        
        // Test admin user exists
        $adminUser = User::where('role', 'admin')->first();
        
        // Test product relationships
        $product = Product::first();
        $productOrderItems = $product ? $product->orderItems->count() : 0;
        
        // Test order relationships
        $order = Order::first();
        $orderUser = $order ? $order->user->name ?? 'No user' : 'No order';
        
        return response()->json([
            'status' => 'success',
            'message' => 'Application is working correctly!',
            'data' => [
                'users' => $userCount,
                'products' => $productCount,
                'orders' => $orderCount,
                'admin_exists' => $adminUser ? 'Yes' : 'No',
                'admin_email' => $adminUser ? $adminUser->email : 'None',
                'sample_product_order_items' => $productOrderItems,
                'sample_order_user' => $orderUser,
                'database_connection' => 'Working',
                'app_env' => config('app.env'),
                'app_debug' => config('app.debug') ? 'On' : 'Off',
            ]
        ], 200);
        
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Application has issues!',
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});
