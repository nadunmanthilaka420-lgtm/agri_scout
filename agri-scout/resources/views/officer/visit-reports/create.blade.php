@extends('officer.layouts.app')

@section('title', 'Submit Inspection Report')
@section('page_title', 'File Detailed MongoDB Visit Report')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="glass-card p-4 p-md-5 border-warning border-opacity-50">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                <div>
                    <h5 class="fw-bold mb-0 text-white"><i class="bi bi-journal-plus text-warning me-2"></i> Field Visit Inspection Report</h5>
                    <p class="text-secondary small mb-0">Will be saved into MongoDB (visit_reports collection)</p>
                </div>
                <span class="badge bg-warning bg-opacity-25 text-warning px-3 py-2 rounded-pill">
                    <i class="bi bi-hdd-network me-1"></i> MongoDB Document
                </span>
            </div>

            <form method="POST" action="{{ route('officer.visit-reports.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="form-label text-secondary small fw-medium">Target Scheduled Visit</label>
                    <select name="visit_id" class="form-select bg-dark text-white border-secondary" required>
                        <option value="">-- Select Completed Visit --</option>
                        @foreach($visits as $v)
                            <option value="{{ $v->VISIT_ID }}" {{ (isset($selectedVisit) && $selectedVisit->VISIT_ID == $v->VISIT_ID) ? 'selected' : '' }}>
                                Visit #{{ $v->VISIT_ID }} - {{ $v->farm->FARM_NAME ?? $v->farm->FARMNAME }} (Date: {{ $v->VISIT_DATE }}, Purpose: {{ Str::limit($v->PURPOSE, 30) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="p-3 rounded-3 bg-dark border border-secondary border-opacity-25 mb-4">
                    <h6 class="fw-bold text-info mb-3"><i class="bi bi-cloud-sun me-1"></i> Weather & Environmental Observations</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label text-secondary small">Condition</label>
                            <input type="text" name="weather_condition" class="form-control bg-dark text-white border-secondary" placeholder="e.g. Sunny, Rainy, Humid" value="Sunny">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small">Temperature (°C)</label>
                            <input type="number" name="temperature" class="form-control bg-dark text-white border-secondary" value="30">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-secondary small">Humidity (%)</label>
                            <input type="number" name="humidity" class="form-control bg-dark text-white border-secondary" value="65">
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-medium">Crop Health Condition</label>
                        <select name="crop_condition" class="form-select bg-dark text-white border-secondary" required>
                            <option value="Healthy & Vigorous">Healthy & Vigorous</option>
                            <option value="Minor Stress Detected">Minor Stress Detected</option>
                            <option value="Moderate Pest/Disease Damage">Moderate Pest/Disease Damage</option>
                            <option value="Severe Crop Distress">Severe Crop Distress</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-medium">Soil Condition</label>
                        <select name="soil_condition" class="form-select bg-dark text-white border-secondary" required>
                            <option value="Optimal Moisture & Fertile">Optimal Moisture & Fertile</option>
                            <option value="Dry / Needs Irrigation">Dry / Needs Irrigation</option>
                            <option value="Waterlogged">Waterlogged</option>
                            <option value="Nutrient Deficient">Nutrient Deficient</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-secondary small fw-medium">Irrigation System Status</label>
                        <select name="irrigation_status" class="form-select bg-dark text-white border-secondary" required>
                            <option value="Adequate / Operational">Adequate / Operational</option>
                            <option value="Inadequate Supply">Inadequate Supply</option>
                            <option value="Drip Lines Damaged">Drip Lines Damaged</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="form-check form-switch p-3 rounded bg-dark border border-secondary border-opacity-25 ps-5">
                            <input class="form-check-input" type="checkbox" name="fertilizer_applied" id="fertilizer_applied" checked>
                            <label class="form-check-label text-white fw-medium" for="fertilizer_applied">Fertilizer Recently Applied</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch p-3 rounded bg-dark border border-secondary border-opacity-25 ps-5">
                            <input class="form-check-input" type="checkbox" name="pest_detected" id="pest_detected">
                            <label class="form-check-label text-white fw-medium" for="pest_detected">Active Pests Detected</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-medium">Field Remarks & Findings</label>
                    <textarea name="remarks" class="form-control bg-dark text-white border-secondary" rows="3" placeholder="Enter detailed inspection findings..." required></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary small fw-medium">Officer Recommendations (One per line)</label>
                    <textarea name="recommendations" class="form-control bg-dark text-white border-secondary" rows="3" placeholder="Apply organic fertilizer&#10;Maintain drip irrigation&#10;Monitor lower leaves for spots"></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('officer.visits.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                    <button type="submit" class="btn btn-warning px-4 fw-bold text-dark">
                        <i class="bi bi-hdd-network me-1"></i> Submit Report to MongoDB
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
