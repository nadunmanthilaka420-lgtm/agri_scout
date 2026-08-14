@extends('officer.layouts.app')

@section('title', 'Register Disease Report')
@section('page_title', 'Register New Crop Disease Incident')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="glass-card p-4 p-md-5 border-danger border-opacity-50">
            <h5 class="fw-bold mb-4 text-white"><i class="bi bi-bug-fill text-danger me-2"></i> Disease Incident Registration (MongoDB)</h5>

            <form method="POST" action="{{ route('officer.diseases.store') }}">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-medium">Affected Farm</label>
                        <select name="farm_id" class="form-select bg-dark text-white border-secondary" required>
                            <option value="">-- Choose Farm --</option>
                            @foreach($farms as $f)
                                <option value="{{ $f->FARM_ID }}">{{ $f->FARM_NAME ?? $f->FARMNAME }} ({{ $f->LOCATION }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-medium">Crop Name</label>
                        <input type="text" name="crop_name" class="form-control bg-dark text-white border-secondary" placeholder="e.g. Mango, Cinnamon, Paddy" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-medium">Disease / Pest Name</label>
                        <input type="text" name="disease_name" class="form-control bg-dark text-white border-secondary" placeholder="e.g. Anthracnose, Leaf Rust" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-medium">Severity Level</label>
                        <select name="severity" class="form-select bg-dark text-white border-secondary" required>
                            <option value="LOW">LOW</option>
                            <option value="MEDIUM" selected>MEDIUM</option>
                            <option value="HIGH">HIGH</option>
                            <option value="CRITICAL">CRITICAL</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-medium">Symptoms Observed (One per line)</label>
                    <textarea name="symptoms" class="form-control bg-dark text-white border-secondary" rows="2" placeholder="Black spots on leaves&#10;Dark lesions on fruit"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-medium">Detailed Incident Description</label>
                    <textarea name="description" class="form-control bg-dark text-white border-secondary" rows="3" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary small fw-medium">Recommended Treatment Plan</label>
                    <textarea name="treatment" class="form-control bg-dark text-white border-secondary" rows="2" placeholder="e.g. Copper-based fungicide spray every 7 days"></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('officer.diseases.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                    <button type="submit" class="btn btn-danger px-4 fw-bold">
                        <i class="bi bi-hdd-network me-1"></i> Save to MongoDB
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
