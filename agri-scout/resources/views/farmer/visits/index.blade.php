@extends('farmer.layouts.app')

@section('title', 'Visit Reports')
@section('page_title', 'Field Officer Inspection Visits')

@section('content')
<div class="glass-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1 text-white"><i class="bi bi-calendar-check-fill text-info me-2"></i> Field Visits & Reports</h5>
            <p class="text-secondary small mb-0">Oracle Visits + MongoDB Detailed Inspection Reports Joined in Laravel</p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-success bg-opacity-25 text-success px-2 py-1 border border-success border-opacity-25 rounded">Oracle</span>
            <span class="badge bg-warning bg-opacity-25 text-warning px-2 py-1 border border-warning border-opacity-25 rounded">MongoDB</span>
        </div>
    </div>

    <div class="row g-4">
        @forelse($visits as $v)
            @php $rep = $visitReportsMap[(int)$v->VISIT_ID] ?? null; @endphp
            <div class="col-12">
                <div class="p-4 rounded-4 bg-dark border border-info border-opacity-25">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-3 border-bottom border-secondary border-opacity-25">
                        <div>
                            <span class="badge bg-info text-dark me-2">Visit #{{ $v->VISIT_ID }}</span>
                            <h5 class="fw-bold text-white d-inline mb-0">{{ $v->farm->FARM_NAME ?? $v->farm->FARMNAME }}</h5>
                            <span class="text-secondary ms-2 small">({{ $v->VISIT_DATE }})</span>
                        </div>
                        <div>
                            <span class="badge bg-secondary me-2">{{ $v->VISIT_TYPE }}</span>
                            <span class="badge bg-{{ $v->STATUS === 'COMPLETED' ? 'success' : 'warning' }} px-3 py-2">
                                {{ $v->STATUS }}
                            </span>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <span class="text-secondary small">Field Officer</span>
                            <p class="fw-bold text-white mb-0">{{ $v->officer->FULL_NAME ?? 'Assigned Officer' }}</p>
                        </div>
                        <div class="col-md-8">
                            <span class="text-secondary small">Visit Purpose (Oracle)</span>
                            <p class="text-light mb-0">{{ $v->PURPOSE }}</p>
                        </div>
                    </div>

                    @if($rep)
                        <div class="p-3 rounded-3 bg-body-tertiary border border-warning border-opacity-25 mt-3">
                            <h6 class="fw-bold text-warning mb-2"><i class="bi bi-hdd-network me-1"></i> MongoDB Field Report (visit_id={{ $v->VISIT_ID }})</h6>
                            <div class="row g-2 mb-2 text-white small">
                                <div class="col-md-3"><strong>Weather:</strong> {{ $rep->weather['condition'] ?? 'N/A' }} ({{ $rep->weather['temperature'] ?? 30 }}°C)</div>
                                <div class="col-md-3"><strong>Crop Condition:</strong> <span class="text-success">{{ $rep->crop_condition }}</span></div>
                                <div class="col-md-3"><strong>Soil:</strong> {{ $rep->soil_condition }}</div>
                                <div class="col-md-3"><strong>Irrigation:</strong> {{ $rep->irrigation_status }}</div>
                            </div>
                            <p class="text-light small mb-2"><strong>Remarks:</strong> {{ $rep->remarks }}</p>
                            @if(isset($rep->recommendations) && count($rep->recommendations) > 0)
                                <div class="small">
                                    <strong class="text-info">Officer Recommendations:</strong>
                                    <ul class="mb-0 text-light ps-3">
                                        @foreach($rep->recommendations as $rec)
                                            <li>{{ $rec }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="p-3 rounded-3 bg-secondary bg-opacity-10 text-secondary small mt-3">
                            <i class="bi bi-info-circle me-1"></i> No detailed MongoDB inspection report filed yet for this visit.
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-secondary py-5">
                No officer inspection visits logged.
            </div>
        @endforelse
    </div>
</div>
@endsection
