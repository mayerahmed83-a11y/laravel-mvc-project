<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Smartphone Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
        }
        .feature-card {
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .product-card {
            transition: transform 0.3s ease;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="bi bi-phone"></i> 📱 Smartphone Store
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">Home</a>
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
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                        @endif
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            Cart 
                            @if(session('cart') && count(session('cart')) > 0)
                                <span class="badge bg-primary">{{ count(session('cart')) }}</span>
                            @endif
                        </a>
                        <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 76px;">
            <div class="container">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 76px;">
            <div class="container">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Welcome to Smartphone Store</h1>
                    <p class="lead mb-4">Discover the latest smartphones from top brands. Find your perfect device with our curated collection of premium phones.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('shop.index') }}" class="btn btn-light btn-lg">Shop Now</a>
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">Join Us</a>
                        @endguest
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="https://via.placeholder.com/500x400?text=Latest+Smartphones" alt="Smartphones" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="display-5 fw-bold">Why Choose Us?</h2>
                    <p class="lead text-muted">We provide the best smartphone shopping experience</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card feature-card h-100 text-center p-4">
                        <div class="card-body">
                            <div class="text-primary mb-3">
                                <i class="bi bi-truck" style="font-size: 3rem;">🚚</i>
                            </div>
                            <h5 class="card-title">Fast Delivery</h5>
                            <p class="card-text">Get your new smartphone delivered quickly with our express shipping options.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card feature-card h-100 text-center p-4">
                        <div class="card-body">
                            <div class="text-primary mb-3">
                                <i class="bi bi-shield-check" style="font-size: 3rem;">🛡️</i>
                            </div>
                            <h5 class="card-title">Warranty Protection</h5>
                            <p class="card-text">All products come with manufacturer warranty and our additional protection plans.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card feature-card h-100 text-center p-4">
                        <div class="card-body">
                            <div class="text-primary mb-3">
                                <i class="bi bi-headset" style="font-size: 3rem;">🎧</i>
                            </div>
                            <h5 class="card-title">24/7 Support</h5>
                            <p class="card-text">Our customer support team is available around the clock to help you.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="display-5 fw-bold">Featured Products</h2>
                    <p class="lead text-muted">Check out our most popular smartphones</p>
                </div>
            </div>
            <div class="row">
                @forelse($featuredProducts as $product)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card product-card h-100">
                            <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="text-muted small">{{ $product->brand }}</p>
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="text-primary mb-0">${{ number_format($product->price, 2) }}</h4>
                                        <span class="badge bg-secondary">{{ $product->stock }} in stock</span>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('product.show', $product) }}" class="btn btn-outline-primary">View Details</a>
                                        @auth
                                            @if($product->stock > 0)
                                                <form method="POST" action="{{ route('cart.add', $product) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                                                </form>
                                            @else
                                                <button class="btn btn-secondary w-100" disabled>Out of Stock</button>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-primary w-100">Login to Buy</a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <h4>No products available at the moment</h4>
                            <p>Please check back later for our latest smartphone collection.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            @if($featuredProducts->count() > 0)
                <div class="text-center mt-4">
                    <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">View All Products</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-5 bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3 class="fw-bold mb-3">Stay Updated</h3>
                    <p class="mb-4">Get notified about new arrivals, special offers, and exclusive deals.</p>
                </div>
                <div class="col-lg-6">
                    <form class="d-flex gap-2">
                        <input type="email" class="form-control" placeholder="Enter your email address" required>
                        <button class="btn btn-primary" type="submit">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>📱 Smartphone Store</h5>
                    <p class="text-muted">Your trusted partner for the latest smartphones and mobile technology.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">&copy; {{ date('Y') }} Smartphone Store. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
