@extends('farmer.layouts.app')

@section('title', 'My Orders')
@section('page_title', 'Farm Produce Orders')

@section('content')
<div class="glass-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1 text-white"><i class="bi bi-cart-check-fill text-primary me-2"></i> Received Customer Orders</h5>
            <p class="text-secondary small mb-0">Retrieved from Oracle Relational Database (ORDERS table)</p>
        </div>
        <span class="badge bg-primary bg-opacity-25 text-primary px-3 py-2 border border-primary border-opacity-25 rounded-pill">
            <i class="bi bi-database me-1"></i> Oracle Database
        </span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle border-secondary border-opacity-25">
            <thead class="table-secondary">
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Customer Name</th>
                    <th>Farm</th>
                    <th>Crop Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th style="width: 170px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $o)
                    <tr>
                        <td>#{{ $o->ORDER_ID }}</td>
                        <td>{{ $o->ORDER_DATE }}</td>
                        <td class="fw-bold text-white">{{ $o->customer->FULL_NAME ?? ($o->customer->NAME ?? 'Customer') }}</td>
                        <td>{{ $o->farm->FARM_NAME ?? $o->farm->FARMNAME }}</td>
                        <td><span class="badge bg-warning text-dark">{{ $o->CROP_NAME }}</span></td>
                        <td>{{ $o->QUANTITY }} {{ $o->UNIT ?? 'KG' }}</td>
                        <td>LKR {{ number_format($o->UNIT_PRICE, 2) }}</td>
                        <td class="fw-bold text-success">LKR {{ number_format($o->TOTAL_AMOUNT, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ strtoupper($o->STATUS) === 'COMPLETED' ? 'success' : (strtoupper($o->STATUS) === 'PENDING' ? 'warning' : 'danger') }}">
                                {{ $o->STATUS }}
                            </span>
                        </td>
                        <td>
                            @if(strtoupper($o->STATUS) === 'COMPLETED')
                                <span class="badge bg-success text-white py-2 px-3">
                                    <i class="bi bi-check-circle-fill me-1"></i> Completed
                                </span>
                            @else
                                <form action="{{ route('farmer.orders.update_status', $o->ORDER_ID) }}" method="POST" onsubmit="return confirm('Did you complete the order?');">
                                    @csrf
                                    <input type="hidden" name="status" value="COMPLETED">
                                    <button type="submit" class="btn btn-sm btn-success fw-bold px-3 py-1">
                                        <i class="bi bi-check2-circle me-1"></i> Complete Order
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-secondary py-4">No customer orders placed for your farm produce.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
