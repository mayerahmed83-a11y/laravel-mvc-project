<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Smartphone Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('shop.index') }}">📱 Smartphone Store</a>
            
            <div class="navbar-nav ms-auto">
                @guest
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                @else
                    @if(auth()->user()->role === 'admin')
                        <a class="nav-link" href="{{ route('admin.products.index') }}">Admin Panel</a>
                    @endif
                    <a class="nav-link" href="{{ route('cart.index') }}">
                        Cart 
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="badge bg-primary">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                    <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Shopping Cart</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(empty($cart))
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <h4>Your cart is empty</h4>
                        <p>Browse our products and add items to your cart.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-primary">Continue Shopping</a>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>Cart Items</h5>
                        </div>
                        <div class="card-body">
                            @foreach($cart as $id => $details)
                                <div class="row align-items-center mb-3 border-bottom pb-3">
                                    <div class="col-md-2">
                                        <img src="{{ $details['image_url'] }}" alt="{{ $details['name'] }}" 
                                             class="img-fluid" style="max-height: 80px;">
                                    </div>
                                    <div class="col-md-4">
                                        <h6>{{ $details['name'] }}</h6>
                                        <small class="text-muted">{{ $details['brand'] }}</small>
                                        <br>
                                        <small class="text-success">Stock: {{ $details['stock'] }}</small>
                                    </div>
                                    <div class="col-md-2">
                                        <strong>${{ number_format($details['price'], 2) }}</strong>
                                    </div>
                                    <div class="col-md-3">
                                        <form method="POST" action="{{ route('cart.update', $id) }}" class="d-flex align-items-center">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $details['quantity'] }}" 
                                                   min="1" max="{{ $details['stock'] }}" class="form-control form-control-sm me-2" style="width: 70px;">
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                                        </form>
                                    </div>
                                    <div class="col-md-1">
                                        <form method="POST" action="{{ route('cart.remove', $id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Remove this item?')">×</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Items ({{ count($cart) }})</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Shipping</span>
                                <span class="text-success">FREE</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total</strong>
                                <strong>${{ number_format($total, 2) }}</strong>
                            </div>
                            
                            <form method="POST" action="{{ route('checkout') }}">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 mb-2" 
                                        onclick="return confirm('Confirm your order?')">
                                    Proceed to Checkout
                                </button>
                            </form>
                            
                            <a href="{{ route('shop.index') }}" class="btn btn-outline-primary w-100">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
