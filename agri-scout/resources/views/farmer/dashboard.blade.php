@extends('farmer.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Farmer Overview')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4 col-lg">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-secondary small fw-medium text-uppercase">My Farms</span>
                <h2 class="fw-bold mb-0 text-white mt-1">{{ $farmsCount }}</h2>
                <span class="badge bg-success bg-opacity-25 text-success small mt-2"><i class="bi bi-database me-1"></i> Oracle</span>
            </div>
            <div class="rounded-4 p-3 text-success bg-success bg-opacity-10 fs-2">
                <i class="bi bi-tree-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-secondary small fw-medium text-uppercase">My Crops</span>
                <h2 class="fw-bold mb-0 text-white mt-1">{{ $cropsCount }}</h2>
                <span class="badge bg-warning bg-opacity-25 text-warning small mt-2"><i class="bi bi-hdd-network me-1"></i> MongoDB</span>
            </div>
            <div class="rounded-4 p-3 text-warning bg-warning bg-opacity-10 fs-2">
                <i class="bi bi-flower2"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-secondary small fw-medium text-uppercase">Upcoming Visits</span>
                <h2 class="fw-bold mb-0 text-white mt-1">{{ $visitsCount }}</h2>
                <span class="badge bg-info bg-opacity-25 text-info small mt-2"><i class="bi bi-database me-1"></i> Oracle</span>
            </div>
            <div class="rounded-4 p-3 text-info bg-info bg-opacity-10 fs-2">
                <i class="bi bi-calendar-check-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-secondary small fw-medium text-uppercase">Disease Reports</span>
                <h2 class="fw-bold mb-0 text-white mt-1">{{ $diseasesCount }}</h2>
                <span class="badge bg-danger bg-opacity-25 text-danger small mt-2"><i class="bi bi-hdd-network me-1"></i> MongoDB</span>
            </div>
            <div class="rounded-4 p-3 text-danger bg-danger bg-opacity-10 fs-2">
                <i class="bi bi-bug-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-secondary small fw-medium text-uppercase">My Orders</span>
                <h2 class="fw-bold mb-0 text-white mt-1">{{ $ordersCount }}</h2>
                <span class="badge bg-primary bg-opacity-25 text-primary small mt-2"><i class="bi bi-database me-1"></i> Oracle</span>
            </div>
            <div class="rounded-4 p-3 text-primary bg-primary bg-opacity-10 fs-2">
                <i class="bi bi-cart-fill"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="glass-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 text-white"><i class="bi bi-tree text-success me-2"></i> My Registered Farms</h5>
                <a href="{{ route('farmer.farms.index') }}" class="btn btn-sm btn-outline-success rounded-pill">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-hover border-secondary border-opacity-25 mb-0 align-middle">
                    <thead>
                        <tr class="text-secondary small">
                            <th>Farm Name</th>
                            <th>District</th>
                            <th>Area (Acres)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($farms as $f)
                            <tr>
                                <td class="fw-medium text-white">{{ $f->FARM_NAME ?? $f->FARMNAME }}</td>
                                <td>{{ $f->DISTRICT ?? 'N/A' }}</td>
                                <td>{{ $f->AREA ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('farmer.farms.show', $f->FARM_ID) }}" class="btn btn-sm btn-success rounded-3 py-1 px-2 small">
                                        Details <i class="bi bi-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-secondary py-3">No registered farms found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="glass-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 text-white"><i class="bi bi-calendar-event text-info me-2"></i> Officer Field Visits</h5>
                <a href="{{ route('farmer.visits.index') }}" class="btn btn-sm btn-outline-info rounded-pill">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-hover border-secondary border-opacity-25 mb-0 align-middle">
                    <thead>
                        <tr class="text-secondary small">
                            <th>Date</th>
                            <th>Officer</th>
                            <th>Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentVisits as $v)
                            <tr>
                                <td>{{ $v->VISIT_DATE }}</td>
                                <td>{{ $v->officer->FULL_NAME ?? 'Assigned Officer' }}</td>
                                <td><span class="badge bg-secondary">{{ $v->VISIT_TYPE }}</span></td>
                                <td>
                                    <span class="badge bg-{{ $v->STATUS === 'COMPLETED' ? 'success' : 'warning' }}">
                                        {{ $v->STATUS }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-secondary py-3">No officer visits recorded.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
