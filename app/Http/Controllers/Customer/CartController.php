<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the cart
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        // Calculate total and get product details
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }
        
        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);
        
        // Check if product has enough stock
        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Not enough stock available.');
        }
        
        $cart = session()->get('cart', []);
        
        // If product already in cart, update quantity
        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;
            
            // Check if new quantity exceeds stock
            if ($newQuantity > $product->stock) {
                return redirect()->back()->with('error', 'Cannot add more items. Not enough stock available.');
            }
            
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            // Add new product to cart
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image_url' => $product->image_url,
                'brand' => $product->brand,
                'stock' => $product->stock,
            ];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, Product $product)
    {
        $quantity = $request->input('quantity');
        
        if ($quantity <= 0) {
            return $this->remove($product);
        }
        
        // Check stock availability
        if ($quantity > $product->stock) {
            return redirect()->back()->with('error', 'Not enough stock available.');
        }
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $quantity;
            session()->put('cart', $cart);
            
            return redirect()->back()->with('success', 'Cart updated successfully!');
        }
        
        return redirect()->back()->with('error', 'Product not found in cart.');
    }

    /**
     * Remove product from cart
     */
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
            
            return redirect()->back()->with('success', 'Product removed from cart.');
        }
        
        return redirect()->back()->with('error', 'Product not found in cart.');
    }

    /**
     * Checkout process
     */
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        
        try {
            DB::beginTransaction();
            
            // Calculate total
            $total = 0;
            foreach ($cart as $id => $details) {
                $total += $details['price'] * $details['quantity'];
            }
            
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'pending',
            ]);
            
            // Create order items and update product stock
            foreach ($cart as $productId => $details) {
                $product = Product::find($productId);
                
                // Check stock availability again
                if ($product->stock < $details['quantity']) {
                    throw new \Exception("Not enough stock for {$product->name}");
                }
                
                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);
                
                // Update product stock
                $product->decreaseStock($details['quantity']);
            }
            
            // Clear cart
            session()->forget('cart');
            
            // Update order status to processing
            $order->update(['status' => 'processing']);
            
            DB::commit();
            
            return redirect()->route('orders.show', $order)
                ->with('success', 'Order placed successfully! Order ID: ' . $order->id);
                
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }
}
