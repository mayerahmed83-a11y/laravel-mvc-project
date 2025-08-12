@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mt-4">👤 User Details: {{ $user->name }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">{{ $user->name }}</li>
            </ol>
        </div>
        <div>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-2"></i>Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Users
            </a>
        </div>
    </div>

    <div class="row">
        <!-- User Information -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user me-1"></i>User Information
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; font-size: 32px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                    
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Role:</strong></td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-crown me-1"></i>Administrator
                                    </span>
                                @else
                                    <span class="badge bg-success">
                                        <i class="fas fa-user me-1"></i>Customer
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Joined:</strong></td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Last Updated:</strong></td>
                            <td>{{ $user->updated_at->format('M d, Y') }}</td>
                        </tr>
                    </table>

                    @if($user->id !== auth()->id())
                    <div class="mt-3">
                        @if($user->role === 'customer')
                            <form method="POST" action="{{ route('admin.users.promote', $user) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success btn-sm w-100 mb-2"
                                        onclick="return confirm('Are you sure you want to promote {{ $user->name }} to admin?')">
                                    <i class="fas fa-arrow-up me-1"></i>Promote to Admin
                                </button>
                            </form>
                        @elseif($user->role === 'admin')
                            <form method="POST" action="{{ route('admin.users.demote', $user) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning btn-sm w-100 mb-2"
                                        onclick="return confirm('Are you sure you want to demote {{ $user->name }} to customer?')">
                                    <i class="fas fa-arrow-down me-1"></i>Demote to Customer
                                </button>
                            </form>
                        @endif
                        
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100"
                                    onclick="return confirm('Are you sure you want to delete {{ $user->name }}? This action cannot be undone.')">
                                <i class="fas fa-trash me-1"></i>Delete User
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Statistics -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>Order Statistics
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h4 class="text-primary">{{ $orders->total() }}</h4>
                            <p class="text-muted">Total Orders</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-success">${{ number_format($user->orders->sum('total'), 2) }}</h4>
                            <p class="text-muted">Total Spent</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-warning">{{ $user->orders->where('status', 'pending')->count() }}</h4>
                            <p class="text-muted">Pending Orders</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-info">{{ $user->orders->where('status', 'delivered')->count() }}</h4>
                            <p class="text-muted">Delivered Orders</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order History -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-shopping-cart me-1"></i>Order History ({{ $orders->total() }} orders)
                </div>
                <div class="card-body">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Items</th>
                                        <th>Total Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td><strong>#{{ $order->id }}</strong></td>
                                        <td>{{ $order->created_at->format('M d, Y g:i A') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'pending' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->orderItems->count() }} items</td>
                                        <td>${{ number_format($order->total, 2) }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-info" type="button" 
                                                    data-bs-toggle="collapse" data-bs-target="#order-{{ $order->id }}" 
                                                    aria-expanded="false">
                                                <i class="fas fa-eye"></i> View Details
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="collapse" id="order-{{ $order->id }}">
                                        <td colspan="6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6>Order Items:</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Product</th>
                                                                    <th>Quantity</th>
                                                                    <th>Unit Price</th>
                                                                    <th>Subtotal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($order->orderItems as $item)
                                                                <tr>
                                                                    <td>{{ $item->product->name }}</td>
                                                                    <td>{{ $item->quantity }}</td>
                                                                    <td>${{ number_format($item->price, 2) }}</td>
                                                                    <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No orders found</h5>
                            <p class="text-muted">This user hasn't placed any orders yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
