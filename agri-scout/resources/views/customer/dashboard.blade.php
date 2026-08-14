@extends('customer.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Customer Produce Hub')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-secondary small fw-medium text-uppercase">Available Crops</span>
                <h2 class="fw-bold mb-0 text-white mt-1">{{ $availableCropsCount }}</h2>
                <span class="badge bg-warning bg-opacity-25 text-warning small mt-2"><i class="bi bi-hdd-network me-1"></i> MongoDB</span>
            </div>
            <div class="rounded-4 p-3 text-warning bg-warning bg-opacity-10 fs-2">
                <i class="bi bi-flower2"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-secondary small fw-medium text-uppercase">My Orders</span>
                <h2 class="fw-bold mb-0 text-white mt-1">{{ $myOrdersCount }}</h2>
                <span class="badge bg-primary bg-opacity-25 text-primary small mt-2"><i class="bi bi-database me-1"></i> Oracle</span>
            </div>
            <div class="rounded-4 p-3 text-primary bg-primary bg-opacity-10 fs-2">
                <i class="bi bi-bag-check-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-secondary small fw-medium text-uppercase">Pending Orders</span>
                <h2 class="fw-bold mb-0 text-white mt-1">{{ $pendingOrdersCount }}</h2>
                <span class="badge bg-warning bg-opacity-25 text-warning small mt-2">Processing</span>
            </div>
            <div class="rounded-4 p-3 text-warning bg-warning bg-opacity-10 fs-2">
                <i class="bi bi-hourglass-split"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-secondary small fw-medium text-uppercase">Completed Orders</span>
                <h2 class="fw-bold mb-0 text-white mt-1">{{ $completedOrdersCount }}</h2>
                <span class="badge bg-success bg-opacity-25 text-success small mt-2">Delivered</span>
            </div>
            <div class="rounded-4 p-3 text-success bg-success bg-opacity-10 fs-2">
                <i class="bi bi-check-circle-fill"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Featured MongoDB Crops -->
    <div class="col-lg-7">
        <div class="glass-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 text-white"><i class="bi bi-shop text-warning me-2"></i> Marketplace Crops (MongoDB)</h5>
                <a href="{{ route('customer.crops.index') }}" class="btn btn-sm btn-outline-warning rounded-pill">Browse All</a>
            </div>

            <div class="row g-3">
                @forelse($featuredCrops as $c)
                    @php $farm = $farmsMap[$c->farm_id] ?? null; @endphp
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-dark border border-secondary border-opacity-25 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="badge bg-dark border border-secondary text-warning mb-1">{{ $c->category }}</span>
                                    <h6 class="fw-bold text-white mb-0">{{ $c->crop_name }}</h6>
                                    <span class="text-secondary small">{{ $c->variety }}</span>
                                </div>
                                <span class="badge bg-success">{{ $c->status }}</span>
                            </div>

                            <p class="text-secondary small mb-2">
                                <i class="bi bi-geo-alt text-danger me-1"></i> Farm: {{ $farm->FARM_NAME ?? $farm->FARMNAME ?? 'Hillwood Farm' }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-secondary border-opacity-25">
                                <span class="text-info small fw-bold">Est: {{ $c->estimated_yield }} {{ $c->yield_unit }}</span>
                                <a href="{{ route('customer.crops.show', $c->_id) }}" class="btn btn-sm btn-pink text-white rounded-3 px-3" style="background: #ec4899;">
                                    View Crop <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-secondary py-4">No produce available in marketplace.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- My Recent Orders -->
    <div class="col-lg-5">
        <div class="glass-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 text-white"><i class="bi bi-bag-check text-primary me-2"></i> Recent Orders (Oracle)</h5>
                <a href="{{ route('customer.orders.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">View All</a>
            </div>

            @forelse($recentOrders as $o)
                <div class="p-3 mb-2 rounded-3 bg-dark border border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-1 text-white">#{{ $o->ORDER_ID }} - {{ $o->CROP_NAME }}</h6>
                        <span class="text-secondary small">{{ $o->QUANTITY }} {{ $o->UNIT ?? 'KG' }} | LKR {{ number_format($o->TOTAL_AMOUNT, 2) }}</span>
                    </div>
                    <span class="badge bg-{{ $o->STATUS === 'COMPLETED' ? 'success' : 'warning' }}">
                        {{ $o->STATUS }}
                    </span>
                </div>
            @empty
                <p class="text-secondary text-center py-3 mb-0">No recent orders placed.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
