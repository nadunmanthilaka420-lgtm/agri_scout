@extends('officer.layouts.app')

@section('title', 'Visit Details')
@section('page_title', 'Field Visit Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="glass-card p-4 p-md-5 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                <div>
                    <span class="badge bg-primary me-2">Visit #{{ $visit->VISIT_ID }}</span>
                    <h4 class="fw-bold text-white d-inline mb-0">{{ $visit->farm->FARM_NAME ?? $visit->farm->FARMNAME }}</h4>
                </div>
                <div>
                    <a href="{{ route('officer.visits.edit', $visit->VISIT_ID) }}" class="btn btn-sm btn-outline-warning me-2">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </a>
                    @if($visit->STATUS !== 'COMPLETED')
                        <a href="{{ route('officer.visit-reports.create', ['visit_id' => $visit->VISIT_ID]) }}" class="btn btn-sm btn-success">
                            <i class="bi bi-journal-plus me-1"></i> File MongoDB Report
                        </a>
                    @endif
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <span class="text-secondary small d-block">Scheduled Date</span>
                    <span class="fw-bold text-white fs-5">{{ $visit->VISIT_DATE }}</span>
                </div>
                <div class="col-md-6">
                    <span class="text-secondary small d-block">Current Status</span>
                    <span class="badge bg-{{ $visit->STATUS === 'COMPLETED' ? 'success' : 'warning' }} fs-6 mt-1">
                        {{ $visit->STATUS }}
                    </span>
                </div>
                <div class="col-md-6">
                    <span class="text-secondary small d-block">Visit Type</span>
                    <span class="fw-bold text-info">{{ $visit->VISIT_TYPE }}</span>
                </div>
                <div class="col-md-6">
                    <span class="text-secondary small d-block">Assigned Officer</span>
                    <span class="fw-bold text-white">{{ $visit->officer->FULL_NAME ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="mb-4">
                <span class="text-secondary small d-block mb-1">Purpose / Notes</span>
                <p class="text-light p-3 rounded-3 bg-dark border border-secondary border-opacity-25 mb-0">{{ $visit->PURPOSE }}</p>
            </div>

            @if($visit->farm)
                <div class="p-3 rounded-3 bg-body-tertiary">
                    <h6 class="fw-bold text-success mb-2"><i class="bi bi-tree me-1"></i> Farm Information</h6>
                    <p class="mb-1 text-white"><strong>Location:</strong> {{ $visit->farm->LOCATION }}, {{ $visit->farm->DISTRICT }}</p>
                    <p class="mb-0 text-white"><strong>Farmer Name:</strong> {{ $visit->farm->farmer->NAME ?? 'N/A' }} (Phone: {{ $visit->farm->farmer->PHONE ?? 'N/A' }})</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
