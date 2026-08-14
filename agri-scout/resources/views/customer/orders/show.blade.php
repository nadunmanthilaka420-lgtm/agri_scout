@extends('customer.layouts.app')

@section('title', 'Order Details')
@section('page_title', 'Order Details & Verification')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="glass-card p-4 p-md-5 mb-4 border-success border-opacity-50">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                <div>
                    <span class="badge bg-primary me-2">Order #{{ $order->ORDER_ID }}</span>
                    <h4 class="fw-bold text-white d-inline mb-0">{{ $order->CROP_NAME }}</h4>
                </div>
                <span class="badge bg-{{ $order->STATUS === 'COMPLETED' ? 'success' : 'warning' }} px-3 py-2 fs-6">
                    {{ $order->STATUS }}
                </span>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <span class="text-secondary small d-block">Order Date</span>
                    <span class="fw-bold text-white fs-5">{{ $order->ORDER_DATE }}</span>
                </div>
                <div class="col-md-6">
                    <span class="text-secondary small d-block">Order Quantity</span>
                    <span class="fw-bold text-white fs-5">{{ $order->QUANTITY }} {{ $order->UNIT ?? 'KG' }}</span>
                </div>
                <div class="col-md-6">
                    <span class="text-secondary small d-block">Unit Price</span>
                    <span class="fw-bold text-light">LKR {{ number_format($order->UNIT_PRICE, 2) }}</span>
                </div>
                <div class="col-md-6">
                    <span class="text-secondary small d-block">Total Invoice Amount</span>
                    <span class="fw-bold text-success fs-5">LKR {{ number_format($officialTotal ?? $order->TOTAL_AMOUNT, 2) }}</span>
                    <span class="badge bg-dark border border-success text-success d-block mt-1 style='width: fit-content;'" style="font-size: 0.72rem;">
                        <i class="bi bi-cpu me-1"></i> Verified by Oracle CALCULATE_ORDER_TOTAL()
                    </span>
                </div>
            </div>

            @if(strtoupper($order->STATUS) === 'PENDING')
                <div class="mb-4">
                    <form method="POST" action="{{ route('customer.orders.cancel', $order->ORDER_ID) }}" onsubmit="return confirm('Are you sure you want to cancel this order via Oracle CANCEL_ORDER procedure?');">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 py-2 rounded-3 fw-bold">
                            <i class="bi bi-x-circle-fill me-1"></i> Cancel Order via Oracle CANCEL_ORDER Procedure
                        </button>
                    </form>
                </div>
            @endif

            @if($order->farm)
                <div class="p-3 rounded-3 bg-dark border border-secondary border-opacity-25 mb-3">
                    <h6 class="fw-bold text-success mb-2"><i class="bi bi-geo-alt me-1"></i> Origin Farm (Oracle FARMS)</h6>
                    <p class="mb-1 text-white"><strong>Farm:</strong> {{ $order->farm->FARM_NAME ?? $order->farm->FARMNAME }}</p>
                    <p class="mb-1 text-white"><strong>Location:</strong> {{ $order->farm->LOCATION }}, {{ $order->farm->DISTRICT }}</p>
                    <p class="mb-0 text-white"><strong>Farmer:</strong> {{ $order->farm->farmer->NAME ?? 'N/A' }} (Phone: {{ $order->farm->farmer->PHONE ?? 'N/A' }})</p>
                </div>
            @endif

            @if($crop)
                <div class="p-3 rounded-3 bg-body-tertiary">
                    <h6 class="fw-bold text-warning mb-2"><i class="bi bi-flower2 me-1"></i> Crop Catalog Info (MongoDB crops)</h6>
                    <p class="mb-1 text-white"><strong>Variety:</strong> {{ $crop->variety }}</p>
                    <p class="mb-1 text-white"><strong>Category:</strong> {{ $crop->category }}</p>
                    <p class="mb-0 text-white"><strong>Current Stage:</strong> {{ $crop->current_stage }} (Status: {{ $crop->status }})</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
