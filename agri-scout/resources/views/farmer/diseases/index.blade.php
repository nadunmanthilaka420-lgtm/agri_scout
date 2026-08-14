@extends('farmer.layouts.app')

@section('title', 'Disease Reports')
@section('page_title', 'Farm Disease Incidents')

@section('content')
<div class="glass-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1 text-white"><i class="bi bi-bug-fill text-danger me-2"></i> Disease & Pest Inspections</h5>
            <p class="text-secondary small mb-0">Retrieved from MongoDB Document Store (disease_reports collection)</p>
        </div>
        <span class="badge bg-danger bg-opacity-25 text-danger px-3 py-2 border border-danger border-opacity-25 rounded-pill">
            <i class="bi bi-hdd-network me-1"></i> MongoDB Collection
        </span>
    </div>

    <div class="row g-4">
        @forelse($diseaseReports as $d)
            <div class="col-md-6">
                <div class="p-4 rounded-4 bg-dark border border-danger border-opacity-25 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-danger mb-1">Severity: {{ $d->disease['severity'] ?? 'MEDIUM' }}</span>
                            <h5 class="fw-bold text-white mb-0">{{ $d->disease['name'] ?? 'Disease' }}</h5>
                            <span class="text-warning small">Crop: {{ $d->crop_name }}</span>
                        </div>
                        <span class="badge bg-{{ $d->status === 'RESOLVED' ? 'success' : 'warning' }} px-3 py-2">
                            Status: {{ $d->status }}
                        </span>
                    </div>

                    <p class="text-secondary small mb-3">{{ $d->description }}</p>

                    <div class="p-3 rounded-3 bg-body-tertiary mb-3">
                        <span class="text-info fw-bold small d-block mb-1"><i class="bi bi-bandaid me-1"></i> Recommended Treatment</span>
                        <p class="text-light small mb-0">{{ $d->treatment['recommended'] ?? 'No treatment recorded.' }}</p>
                    </div>

                    @if(isset($d->follow_ups) && count($d->follow_ups) > 0)
                        <div class="mt-3">
                            <span class="text-secondary small fw-bold d-block mb-2"><i class="bi bi-clock-history me-1"></i> Officer Follow-ups</span>
                            @foreach($d->follow_ups as $f)
                                <div class="p-2 rounded bg-black bg-opacity-50 small mb-1">
                                    <span class="text-info">{{ $f['date'] }}</span> — <span class="text-warning">{{ $f['status'] }}</span>: {{ $f['remarks'] }}
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-3 pt-2 border-top border-secondary border-opacity-25 text-secondary small d-flex justify-content-between">
                        <span>Reported Date: {{ $d->reported_date }}</span>
                        <span>Role: {{ $d->reported_by['role'] ?? 'OFFICER' }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="p-5 text-center text-secondary">
                    <i class="bi bi-shield-check fs-1 text-success d-block mb-2"></i>
                    No disease incidents reported for your farm crops.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
