<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Smartphone Store</title>
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
        <h1>My Orders</h1>

        @if($orders->isEmpty())
            <div class="alert alert-info text-center">
                <h4>No orders found</h4>
                <p>You haven't placed any orders yet.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-primary">Start Shopping</a>
            </div>
        @else
            <div class="row">
                @foreach($orders as $order)
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h5>Order #{{ $order->id }}</h5>
                                    <small class="text-muted">Placed on {{ $order->created_at->format('M d, Y') }}</small>
                                </div>
                                <div>
                                    <span class="badge 
                                        @if($order->status === 'pending') bg-warning
                                        @elseif($order->status === 'processing') bg-info
                                        @elseif($order->status === 'shipped') bg-primary
                                        @elseif($order->status === 'delivered') bg-success
                                        @else bg-danger
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6>Items:</h6>
                                        @foreach($order->orderItems as $item)
                                            <div class="d-flex align-items-center mb-2">
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" 
                                                     class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <div>{{ $item->product->name }}</div>
                                                    <small class="text-muted">
                                                        Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                                                    </small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <div class="mb-2">
                                            <strong>Total: ${{ number_format($order->total, 2) }}</strong>
                                        </div>
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="row">
                <div class="col-12">
                    {{ $orders->links() }}
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
