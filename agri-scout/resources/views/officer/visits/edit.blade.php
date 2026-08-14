@extends('officer.layouts.app')

@section('title', 'Edit Visit')
@section('page_title', 'Update Field Visit Record')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="glass-card p-4 p-md-5">
            <h5 class="fw-bold mb-4 text-white"><i class="bi bi-pencil-square text-warning me-2"></i> Update Visit #{{ $visit->VISIT_ID }}</h5>

            <form method="POST" action="{{ route('officer.visits.update', $visit->VISIT_ID) }}">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-medium">Visit Date</label>
                        <input type="date" name="visit_date" class="form-control bg-dark text-white border-secondary" value="{{ old('visit_date', $visit->VISIT_DATE) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-medium">Status</label>
                        <select name="status" class="form-select bg-dark text-white border-secondary" required>
                            <option value="PENDING" {{ $visit->STATUS === 'PENDING' ? 'selected' : '' }}>PENDING</option>
                            <option value="IN_PROGRESS" {{ $visit->STATUS === 'IN_PROGRESS' ? 'selected' : '' }}>IN PROGRESS</option>
                            <option value="COMPLETED" {{ $visit->STATUS === 'COMPLETED' ? 'selected' : '' }}>COMPLETED</option>
                            <option value="CANCELLED" {{ $visit->STATUS === 'CANCELLED' ? 'selected' : '' }}>CANCELLED</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-medium">Visit Type</label>
                    <select name="visit_type" class="form-select bg-dark text-white border-secondary" required>
                        <option value="ROUTINE_INSPECTION" {{ $visit->VISIT_TYPE === 'ROUTINE_INSPECTION' ? 'selected' : '' }}>Routine Inspection</option>
                        <option value="DISEASE_OUTBREAK" {{ $visit->VISIT_TYPE === 'DISEASE_OUTBREAK' ? 'selected' : '' }}>Disease Outbreak Check</option>
                        <option value="PEST_CONTROL" {{ $visit->VISIT_TYPE === 'PEST_CONTROL' ? 'selected' : '' }}>Pest Control Monitoring</option>
                        <option value="SOIL_WATER_TEST" {{ $visit->VISIT_TYPE === 'SOIL_WATER_TEST' ? 'selected' : '' }}>Soil & Irrigation Assessment</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary small fw-medium">Purpose / Remarks</label>
                    <textarea name="purpose" class="form-control bg-dark text-white border-secondary" rows="3" required>{{ old('purpose', $visit->PURPOSE) }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('officer.visits.show', $visit->VISIT_ID) }}" class="btn btn-outline-secondary px-4">Cancel</a>
                    <button type="submit" class="btn btn-warning px-4 fw-bold text-dark">
                        <i class="bi bi-check-circle me-1"></i> Update Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
