#!/usr/bin/env php
<?php

/**
 * Laravel E-commerce Application Health Check
 * This script validates the application setup and identifies potential issues
 */

echo "🔍 Laravel E-commerce Application Health Check\n";
echo "================================================\n\n";

// Check if we're in the Laravel root directory
if (!file_exists('artisan')) {
    echo "❌ Error: Not in Laravel root directory. Please run from project root.\n";
    exit(1);
}

// Load Laravel
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "✅ Laravel Application Loaded\n";

// Check database connection
try {
    DB::connection()->getPdo();
    echo "✅ Database Connection: Working\n";
} catch (Exception $e) {
    echo "❌ Database Connection: Failed - " . $e->getMessage() . "\n";
}

// Check migrations
try {
    $migrations = DB::table('migrations')->get();
    echo "✅ Migrations: " . $migrations->count() . " migrations found\n";
} catch (Exception $e) {
    echo "❌ Migrations: Error - " . $e->getMessage() . "\n";
}

// Check users
try {
    $userCount = App\Models\User::count();
    $adminCount = App\Models\User::where('role', 'admin')->count();
    echo "✅ Users: {$userCount} total, {$adminCount} admins\n";
} catch (Exception $e) {
    echo "❌ Users: Error - " . $e->getMessage() . "\n";
}

// Check products
try {
    $productCount = App\Models\Product::count();
    echo "✅ Products: {$productCount} products found\n";
} catch (Exception $e) {
    echo "❌ Products: Error - " . $e->getMessage() . "\n";
}

// Check orders
try {
    $orderCount = App\Models\Order::count();
    echo "✅ Orders: {$orderCount} orders found\n";
} catch (Exception $e) {
    echo "❌ Orders: Error - " . $e->getMessage() . "\n";
}

// Check storage link
$storagePath = public_path('storage');
if (file_exists($storagePath)) {
    echo "✅ Storage Link: Connected\n";
} else {
    echo "⚠️ Storage Link: Not connected (run: php artisan storage:link)\n";
}

// Check environment
echo "✅ Environment: " . config('app.env') . "\n";
echo "✅ Debug Mode: " . (config('app.debug') ? 'Enabled' : 'Disabled') . "\n";
echo "✅ App Key: " . (config('app.key') ? 'Set' : 'Not Set') . "\n";

// Check important directories
$directories = [
    'storage/app' => storage_path('app'),
    'storage/logs' => storage_path('logs'),
    'storage/framework/cache' => storage_path('framework/cache'),
    'storage/framework/sessions' => storage_path('framework/sessions'),
    'storage/framework/views' => storage_path('framework/views'),
];

foreach ($directories as $name => $path) {
    if (is_dir($path) && is_writable($path)) {
        echo "✅ Directory {$name}: Writable\n";
    } else {
        echo "❌ Directory {$name}: Not writable or missing\n";
    }
}

echo "\n🎉 Health Check Complete!\n";
echo "If you see any ❌ errors above, please address them.\n";
echo "If all shows ✅, your application should be working correctly.\n\n";

// Show quick start info
echo "📋 Quick Start:\n";
echo "- Start server: php artisan serve\n";
echo "- Visit shop: http://127.0.0.1:8000\n";
echo "- Admin login: Check database for admin user credentials\n";
echo "- Admin panel: http://127.0.0.1:8000/admin/dashboard\n";
