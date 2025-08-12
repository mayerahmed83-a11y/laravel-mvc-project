@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">📊 Admin Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small text-white-50">Total Users</div>
                            <div class="h2">{{ $totalUsers }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.users.index') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small text-white-50">Total Products</div>
                            <div class="h2">{{ $totalProducts }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-box fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('admin.products.index') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small text-white-50">Total Orders</div>
                            <div class="h2">{{ $totalOrders }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-shopping-cart fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#orders">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="small text-white-50">Total Revenue</div>
                            <div class="h2">${{ number_format($totalRevenue, 2) }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#revenue">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-tachometer-alt me-1"></i>
                    Quick Actions
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-success w-100">
                                <i class="fas fa-plus me-2"></i>Add New Product
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-user-plus me-2"></i>Add New User
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-info w-100">
                                <i class="fas fa-boxes me-2"></i>Manage Products
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-warning w-100">
                                <i class="fas fa-users-cog me-2"></i>Manage Users
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Low Stock Alert -->
        @if($lowStockProducts->count() > 0)
        <div class="col-xl-6 mb-4">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Low Stock Alert ({{ $lowStockProducts->count() }} items)
                </div>
                <div class="card-body">
                    @foreach($lowStockProducts as $product)
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <div>
                            <strong>{{ $product->name }}</strong><br>
                            <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-danger">{{ $product->stock }} left</span><br>
                            <small class="text-muted">${{ number_format($product->price, 2) }}</small>
                        </div>
                    </div>
                    @endforeach
                    <div class="mt-3">
                        <a href="{{ route('admin.products.index') }}?low_stock=1" class="btn btn-sm btn-outline-danger">
                            View All Low Stock Items
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Orders -->
        <div class="col-xl-{{ $lowStockProducts->count() > 0 ? '6' : '12' }} mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-shopping-cart me-1"></i>
                    Recent Orders ({{ $recentOrders->count() }} orders)
                </div>
                <div class="card-body">
                    @if($recentOrders->count() > 0)
                        @foreach($recentOrders as $order)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <div>
                                <strong>Order #{{ $order->id }}</strong><br>
                                <small class="text-muted">{{ $order->user->name }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($order->status) }}
                                </span><br>
                                <small class="text-muted">${{ number_format($order->total, 2) }}</small><br>
                                <small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted">No recent orders found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- System Information -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    System Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h6>Admin Users</h6>
                            <p class="mb-0">{{ $adminCount }} administrators</p>
                        </div>
                        <div class="col-md-3">
                            <h6>Customer Users</h6>
                            <p class="mb-0">{{ $customerCount }} customers</p>
                        </div>
                        <div class="col-md-3">
                            <h6>Products in Stock</h6>
                            <p class="mb-0">{{ $productsInStock }} available</p>
                        </div>
                        <div class="col-md-3">
                            <h6>Out of Stock</h6>
                            <p class="mb-0">{{ $outOfStockProducts }} products</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// You can add charts here in the future
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh dashboard every 5 minutes
    setTimeout(function() {
        location.reload();
    }, 300000);
});
</script>
@endsection
