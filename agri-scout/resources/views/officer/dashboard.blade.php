@extends('officer.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Field Officer Command Center')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-4 col-lg">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-secondary small fw-medium text-uppercase">Assigned Farms</span>
                <h2 class="fw-bold mb-0 text-white mt-1">{{ $assignedFarmsCount }}</h2>
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
                <span class="text-secondary small fw-medium text-uppercase">Today's Visits</span>
                <h2 class="fw-bold mb-0 text-white mt-1">{{ $todaysVisitsCount }}</h2>
                <span class="badge bg-primary bg-opacity-25 text-primary small mt-2"><i class="bi bi-calendar-event me-1"></i> Today</span>
            </div>
            <div class="rounded-4 p-3 text-primary bg-primary bg-opacity-10 fs-2">
                <i class="bi bi-calendar-day-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-secondary small fw-medium text-uppercase">Pending Visits</span>
                <h2 class="fw-bold mb-0 text-white mt-1">{{ $pendingVisitsCount }}</h2>
                <span class="badge bg-warning bg-opacity-25 text-warning small mt-2"><i class="bi bi-clock-history me-1"></i> Pending</span>
            </div>
            <div class="rounded-4 p-3 text-warning bg-warning bg-opacity-10 fs-2">
                <i class="bi bi-hourglass-split"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-secondary small fw-medium text-uppercase">Completed Visits</span>
                <h2 class="fw-bold mb-0 text-white mt-1">{{ $completedVisitsCount }}</h2>
                <span class="badge bg-info bg-opacity-25 text-info small mt-2"><i class="bi bi-check2-circle me-1"></i> Completed</span>
            </div>
            <div class="rounded-4 p-3 text-info bg-info bg-opacity-10 fs-2">
                <i class="bi bi-clipboard-check-fill"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg">
        <div class="glass-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <span class="text-secondary small fw-medium text-uppercase">Disease Reports</span>
                <h2 class="fw-bold mb-0 text-white mt-1">{{ $diseaseReportsCount }}</h2>
                <span class="badge bg-danger bg-opacity-25 text-danger small mt-2"><i class="bi bi-hdd-network me-1"></i> MongoDB</span>
            </div>
            <div class="rounded-4 p-3 text-danger bg-danger bg-opacity-10 fs-2">
                <i class="bi bi-bug-fill"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="glass-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 text-white"><i class="bi bi-calendar-check text-primary me-2"></i> Field Visits Schedule</h5>
                <a href="{{ route('officer.visits.create') }}" class="btn btn-sm btn-primary rounded-pill">+ Schedule Visit</a>
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle border-secondary border-opacity-25 mb-0">
                    <thead>
                        <tr class="text-secondary small">
                            <th>Date</th>
                            <th>Farm Name</th>
                            <th>Purpose</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentVisits as $v)
                            <tr>
                                <td>{{ $v->VISIT_DATE }}</td>
                                <td class="fw-bold text-white">{{ $v->farm->FARM_NAME ?? $v->farm->FARMNAME }}</td>
                                <td>{{ Str::limit($v->PURPOSE, 30) }}</td>
                                <td>
                                    <span class="badge bg-{{ $v->STATUS === 'COMPLETED' ? 'success' : 'warning' }}">
                                        {{ $v->STATUS }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('officer.visits.show', $v->VISIT_ID) }}" class="btn btn-sm btn-outline-info rounded-3 py-1 px-2">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-secondary py-3">No field visits scheduled.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="glass-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 text-white"><i class="bi bi-tree text-success me-2"></i> Assigned Farms</h5>
                <a href="{{ route('officer.farms.index') }}" class="btn btn-sm btn-outline-success rounded-pill">View All</a>
            </div>
            @forelse($assignedFarms as $f)
                <div class="p-3 mb-2 rounded-3 bg-dark border border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-1 text-success">{{ $f->FARM_NAME ?? $f->FARMNAME }}</h6>
                        <span class="text-secondary small"><i class="bi bi-geo-alt me-1"></i> {{ $f->LOCATION }}, {{ $f->DISTRICT }}</span>
                    </div>
                    <a href="{{ route('officer.farms.show', $f->FARM_ID) }}" class="btn btn-sm btn-dark border-secondary">
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            @empty
                <p class="text-secondary text-center py-3 mb-0">No assigned farms found.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
