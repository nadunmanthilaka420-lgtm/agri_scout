@extends('customer.layouts.app')

@section('title', 'Browse Crops')
@section('page_title', 'Browse Fresh Produce Crops')

@section('content')
<div class="glass-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1 text-white"><i class="bi bi-shop text-warning me-2"></i> Produce Marketplace</h5>
            <p class="text-secondary small mb-0">Browse MongoDB Crop Catalog with Oracle Farm Verification</p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-warning bg-opacity-25 text-warning px-2 py-1 border border-warning border-opacity-25 rounded">MongoDB Crops</span>
            <span class="badge bg-success bg-opacity-25 text-success px-2 py-1 border border-success border-opacity-25 rounded">Oracle Farms</span>
        </div>
    </div>

    <div class="row g-4">
        @forelse($crops as $c)
            @php $farm = $farmsMap[$c->farm_id] ?? null; @endphp
            <div class="col-md-6 col-lg-4">
                <div class="p-4 rounded-4 bg-dark border border-secondary border-opacity-25 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-dark border border-warning text-warning">{{ $c->category }}</span>
                            <span class="badge bg-success">{{ $c->status }}</span>
                        </div>

                        <h5 class="fw-bold text-white mb-1">{{ $c->crop_name }}</h5>
                        <p class="text-secondary small mb-3">Variety: {{ $c->variety }}</p>

                        <div class="p-3 rounded-3 bg-light mb-3 small" style="color: #000000 !important;">
                            <p class="mb-1" style="color: #000000 !important;"><strong style="color: #000000 !important;">Source Farm:</strong> {{ $farm->FARM_NAME ?? $farm->FARMNAME ?? 'Hillwood Farm' }}</p>
                            <p class="mb-1" style="color: #000000 !important;"><strong style="color: #000000 !important;">Location:</strong> {{ $farm->LOCATION ?? 'Kandy' }}</p>
                            <p class="mb-1" style="color: #000000 !important;"><strong style="color: #000000 !important;">Expected Harvest:</strong> {{ $c->expected_harvest_date }}</p>
                            <p class="mb-0" style="color: #000000 !important;"><strong style="color: #000000 !important;">Estimated Yield:</strong> {{ $c->estimated_yield }} {{ $c->yield_unit }}</p>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-3 pt-2 border-top border-secondary border-opacity-25">
                        <a href="{{ route('customer.crops.show', $c->_id) }}" class="btn btn-outline-info btn-sm w-50 rounded-3">
                            <i class="bi bi-eye me-1"></i> Details
                        </a>
                        <a href="{{ route('customer.orders.create', ['crop_id' => $c->_id]) }}" class="btn btn-pink btn-sm w-50 text-white rounded-3 fw-bold" style="background: #ec4899;">
                            <i class="bi bi-bag-plus me-1"></i> Order
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-secondary py-5">
                No crops currently listed in the marketplace.
            </div>
        @endforelse
    </div>
</div>
@endsection
