@extends('customer.layouts.app')

@section('title', 'My Orders')
@section('page_title', 'My Placed Orders')

@section('content')
<div class="glass-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1 text-white"><i class="bi bi-bag-check-fill text-pink me-2" style="color: #ec4899;"></i> My Purchase Orders</h5>
            <p class="text-secondary small mb-0">Retrieved from Oracle Relational Database (ORDERS table)</p>
        </div>
        <a href="{{ route('customer.orders.create') }}" class="btn btn-pink text-white px-3 py-2 rounded-3 fw-bold" style="background: #ec4899;">
            <i class="bi bi-plus-lg me-1"></i> Create New Order
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle border-secondary border-opacity-25">
            <thead class="table-secondary">
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Produce Crop</th>
                    <th>Origin Farm</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $o)
                    <tr>
                        <td>#{{ $o->ORDER_ID }}</td>
                        <td>{{ $o->ORDER_DATE }}</td>
                        <td class="fw-bold text-warning">{{ $o->CROP_NAME }}</td>
                        <td>{{ $o->farm->FARM_NAME ?? $o->farm->FARMNAME }}</td>
                        <td>{{ $o->QUANTITY }} {{ $o->UNIT ?? 'KG' }}</td>
                        <td>LKR {{ number_format($o->UNIT_PRICE, 2) }}</td>
                        <td class="fw-bold text-success">LKR {{ number_format($o->TOTAL_AMOUNT, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $o->STATUS === 'COMPLETED' ? 'success' : 'warning' }}">
                                {{ $o->STATUS }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('customer.orders.show', $o->ORDER_ID) }}" class="btn btn-sm btn-outline-info rounded-3 px-2">
                                    View <i class="bi bi-arrow-right"></i>
                                </a>
                                @if(strtoupper($o->STATUS) === 'PENDING')
                                    <form method="POST" action="{{ route('customer.orders.cancel', $o->ORDER_ID) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this order via Oracle CANCEL_ORDER procedure?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-2">
                                            <i class="bi bi-x-circle me-1"></i> Cancel
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-secondary py-4">You have not placed any produce orders yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
