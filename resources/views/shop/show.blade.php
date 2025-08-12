<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Smartphone Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">📱 Smartphone Store</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop.index') }}">Shop</a>
                    </li>
                </ul>
                
                <div class="navbar-nav">
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
        </div>
    </nav>

    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Shop</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-6">
                <img src="{{ $product->image_url }}" class="img-fluid rounded" alt="{{ $product->name }}">
            </div>
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
                <h5 class="text-muted">{{ $product->brand }}</h5>
                <h2 class="text-primary mt-3">${{ number_format($product->price, 2) }}</h2>
                
                <div class="mb-3">
                    @if($product->stock > 0)
                        <span class="badge bg-success">{{ $product->stock }} in stock</span>
                    @else
                        <span class="badge bg-danger">Out of stock</span>
                    @endif
                </div>

                <div class="mb-4">
                    <h5>Description</h5>
                    <p>{{ $product->description }}</p>
                </div>

                @auth
                    @if($product->stock > 0)
                        <form method="POST" action="{{ route('cart.add', $product) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width: 100px;">
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Add to Cart</button>
                        </form>
                    @else
                        <button class="btn btn-secondary btn-lg" disabled>Out of Stock</button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login to Purchase</a>
                @endauth

                <div class="mt-4">
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">← Back to Shop</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
