@extends('officer.layouts.app')

@section('title', 'Disease Incident Details')
@section('page_title', 'Disease Incident & Follow-up Log')

@section('content')
<div class="row g-4">
    <div class="col-lg-7">
        <div class="glass-card p-4 h-100 border-danger border-opacity-50">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom border-secondary border-opacity-25">
                <div>
                    <span class="badge bg-danger mb-1">Severity: {{ $report->disease['severity'] ?? 'MEDIUM' }}</span>
                    <h4 class="fw-bold text-white mb-0">{{ $report->disease['name'] ?? 'Disease' }}</h4>
                    <span class="text-warning small">Crop: {{ $report->crop_name }} (Farm #{{ $report->farm_id }})</span>
                </div>
                <span class="badge bg-{{ $report->status === 'RESOLVED' ? 'success' : 'warning' }} px-3 py-2 fs-6">
                    {{ $report->status }}
                </span>
            </div>

            <div class="mb-3">
                <span class="text-secondary small d-block">Description</span>
                <p class="text-light p-3 rounded-3 bg-dark border border-secondary border-opacity-25 mb-0">{{ $report->description }}</p>
            </div>

            @if(isset($report->disease['symptoms']) && count($report->disease['symptoms']) > 0)
                <div class="mb-3">
                    <span class="text-secondary small d-block mb-1">Observed Symptoms</span>
                    <ul class="text-warning small mb-0 ps-3">
                        @foreach($report->disease['symptoms'] as $sym)
                            <li>{{ $sym }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="p-3 rounded-3 bg-body-tertiary mb-4">
                <span class="text-info fw-bold small d-block mb-1"><i class="bi bi-bandaid me-1"></i> Recommended Treatment</span>
                <p class="text-white small mb-0">{{ $report->treatment['recommended'] ?? 'N/A' }}</p>
            </div>

            <div>
                <h6 class="fw-bold text-white mb-3"><i class="bi bi-clock-history text-info me-2"></i> Follow-up Observations Log (MongoDB Nested Array)</h6>
                @forelse($report->follow_ups ?? [] as $f)
                    <div class="p-3 rounded-3 bg-dark border border-secondary border-opacity-25 mb-2">
                        <div class="d-flex justify-content-between text-secondary small mb-1">
                            <span><i class="bi bi-calendar-event me-1"></i> {{ $f['date'] }}</span>
                            <span class="badge bg-{{ $f['status'] === 'RESOLVED' ? 'success' : 'warning' }}">{{ $f['status'] }}</span>
                        </div>
                        <p class="text-light mb-0 small">{{ $f['remarks'] }}</p>
                    </div>
                @empty
                    <p class="text-secondary small">No follow-ups added yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Add Follow-up Form -->
    <div class="col-lg-5">
        <div class="glass-card p-4 border-warning border-opacity-50">
            <h5 class="fw-bold mb-3 text-white"><i class="bi bi-plus-circle text-warning me-2"></i> Add Follow-up Entry</h5>
            <p class="text-secondary small mb-4">Appends a new follow-up object directly into MongoDB document's `follow_ups` array without altering relational tables.</p>

            <form method="POST" action="{{ route('officer.diseases.follow-up', $report->_id) }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-medium">Updated Incident Status</label>
                    <select name="status" class="form-select bg-dark text-white border-secondary" required>
                        <option value="OPEN" {{ $report->status === 'OPEN' ? 'selected' : '' }}>OPEN</option>
                        <option value="IMPROVING" {{ $report->status === 'IMPROVING' ? 'selected' : '' }}>IMPROVING</option>
                        <option value="MONITORING" {{ $report->status === 'MONITORING' ? 'selected' : '' }}>MONITORING</option>
                        <option value="RESOLVED" {{ $report->status === 'RESOLVED' ? 'selected' : '' }}>RESOLVED</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary small fw-medium">Officer Inspection Remarks</label>
                    <textarea name="remarks" class="form-control bg-dark text-white border-secondary" rows="4" placeholder="e.g. Symptoms reduced after fungicide treatment..." required></textarea>
                </div>

                <button type="submit" class="btn btn-warning w-100 fw-bold text-dark py-2">
                    <i class="bi bi-hdd-network me-1"></i> Append Follow-up to MongoDB
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
