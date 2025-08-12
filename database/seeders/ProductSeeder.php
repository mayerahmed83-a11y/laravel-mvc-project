<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'The latest iPhone with advanced A17 Pro chip, titanium design, and pro camera system.',
                'price' => 999.99,
                'stock' => 50,
                'brand' => 'Apple',
                'image_url' => 'https://via.placeholder.com/300x300?text=iPhone+15+Pro',
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Premium Android smartphone with S Pen, 200MP camera, and AI features.',
                'price' => 1199.99,
                'stock' => 35,
                'brand' => 'Samsung',
                'image_url' => 'https://via.placeholder.com/300x300?text=Galaxy+S24+Ultra',
            ],
            [
                'name' => 'Google Pixel 8 Pro',
                'description' => 'Google\'s flagship with Magic Eraser, AI photography, and pure Android experience.',
                'price' => 899.99,
                'stock' => 25,
                'brand' => 'Google',
                'image_url' => 'https://via.placeholder.com/300x300?text=Pixel+8+Pro',
            ],
            [
                'name' => 'OnePlus 12',
                'description' => 'Flagship killer with Snapdragon 8 Gen 3, 100W fast charging, and OxygenOS.',
                'price' => 799.99,
                'stock' => 40,
                'brand' => 'OnePlus',
                'image_url' => 'https://via.placeholder.com/300x300?text=OnePlus+12',
            ],
            [
                'name' => 'Xiaomi 14 Ultra',
                'description' => 'Photography-focused smartphone with Leica camera system and premium build.',
                'price' => 1099.99,
                'stock' => 20,
                'brand' => 'Xiaomi',
                'image_url' => 'https://via.placeholder.com/300x300?text=Xiaomi+14+Ultra',
            ],
            [
                'name' => 'iPhone 14',
                'description' => 'Previous generation iPhone with A15 Bionic chip and dual camera system.',
                'price' => 699.99,
                'stock' => 60,
                'brand' => 'Apple',
                'image_url' => 'https://via.placeholder.com/300x300?text=iPhone+14',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
