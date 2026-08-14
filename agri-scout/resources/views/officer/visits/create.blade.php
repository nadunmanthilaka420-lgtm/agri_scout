@extends('officer.layouts.app')

@section('title', 'Schedule Visit')
@section('page_title', 'Schedule New Field Visit')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="glass-card p-4 p-md-5">
            <h5 class="fw-bold mb-4 text-white"><i class="bi bi-calendar-plus text-primary me-2"></i> New Visit Entry (Oracle OFFICER_VISITS)</h5>

            <form method="POST" action="{{ route('officer.visits.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-medium">Select Target Farm</label>
                    <select name="farm_id" class="form-select bg-dark text-white border-secondary" required>
                        <option value="">-- Choose Farm --</option>
                        @foreach($farms as $f)
                            <option value="{{ $f->FARM_ID }}">{{ $f->FARM_NAME ?? $f->FARMNAME }} (Owner: {{ $f->farmer->NAME ?? 'N/A' }}, Location: {{ $f->LOCATION }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-medium">Visit Date</label>
                        <input type="date" name="visit_date" class="form-control bg-dark text-white border-secondary" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-medium">Visit Type</label>
                        <select name="visit_type" class="form-select bg-dark text-white border-secondary" required>
                            <option value="ROUTINE_INSPECTION">Routine Inspection</option>
                            <option value="DISEASE_OUTBREAK">Disease Outbreak Check</option>
                            <option value="PEST_CONTROL">Pest Control Monitoring</option>
                            <option value="SOIL_WATER_TEST">Soil & Irrigation Assessment</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary small fw-medium">Visit Purpose / Notes</label>
                    <textarea name="purpose" class="form-control bg-dark text-white border-secondary" rows="3" placeholder="Describe the specific purpose of this field inspection..." required></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('officer.visits.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">
                        <i class="bi bi-check-circle me-1"></i> Save Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
