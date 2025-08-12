<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Hash;

class AdminDashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if not exists
        if (!User::where('role', 'admin')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

        // Create customer users
        if (User::where('role', 'customer')->count() < 3) {
            User::create([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]);

            User::create([
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]);

            User::create([
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]);
        }

        // Create sample products
        if (Product::count() < 5) {
            $products = [
                [
                    'name' => 'iPhone 15 Pro',
                    'description' => 'Latest Apple iPhone with advanced features',
                    'price' => 1199.99,
                    'stock' => 15,
                    'brand' => 'Apple',
                ],
                [
                    'name' => 'Samsung Galaxy S24 Ultra',
                    'description' => 'Premium Samsung smartphone with S Pen',
                    'price' => 1299.99,
                    'stock' => 2, // Low stock
                    'brand' => 'Samsung',
                ],
                [
                    'name' => 'Google Pixel 8 Pro',
                    'description' => 'Google smartphone with AI features',
                    'price' => 999.99,
                    'stock' => 8,
                    'brand' => 'Google',
                ],
                [
                    'name' => 'OnePlus 12',
                    'description' => 'High-performance Android smartphone',
                    'price' => 799.99,
                    'stock' => 4, // Low stock
                    'brand' => 'OnePlus',
                ],
                [
                    'name' => 'Xiaomi 14 Ultra',
                    'description' => 'Premium Xiaomi phone with Leica cameras',
                    'price' => 899.99,
                    'stock' => 0, // Out of stock
                    'brand' => 'Xiaomi',
                ],
            ];

            foreach ($products as $product) {
                Product::create($product);
            }
        }

        // Create sample orders
        if (Order::count() < 5) {
            $customers = User::where('role', 'customer')->get();
            $products = Product::all();

            if ($customers->count() > 0 && $products->count() > 0) {
                // Order 1 - Delivered
                $order1 = Order::create([
                    'user_id' => $customers->random()->id,
                    'status' => 'delivered',
                    'total' => 0,
                ]);

                $item1 = OrderItem::create([
                    'order_id' => $order1->id,
                    'product_id' => $products->first()->id,
                    'quantity' => 1,
                    'price' => $products->first()->price,
                ]);

                $order1->update(['total' => $item1->quantity * $item1->price]);

                // Order 2 - Pending
                $order2 = Order::create([
                    'user_id' => $customers->random()->id,
                    'status' => 'pending',
                    'total' => 0,
                ]);

                $item2 = OrderItem::create([
                    'order_id' => $order2->id,
                    'product_id' => $products->skip(1)->first()->id,
                    'quantity' => 2,
                    'price' => $products->skip(1)->first()->price,
                ]);

                $order2->update(['total' => $item2->quantity * $item2->price]);

                // Order 3 - Delivered
                $order3 = Order::create([
                    'user_id' => $customers->random()->id,
                    'status' => 'delivered',
                    'total' => 0,
                ]);

                $item3 = OrderItem::create([
                    'order_id' => $order3->id,
                    'product_id' => $products->skip(2)->first()->id,
                    'quantity' => 1,
                    'price' => $products->skip(2)->first()->price,
                ]);

                $order3->update(['total' => $item3->quantity * $item3->price]);
            }
        }
    }
}
