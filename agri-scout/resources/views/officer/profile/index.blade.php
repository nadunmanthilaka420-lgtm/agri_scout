@extends('officer.layouts.app')

@section('title', 'Officer Profile')
@section('page_title', 'Field Officer Account Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="glass-card p-4 p-md-5">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                <div class="bg-primary bg-opacity-25 text-primary rounded-circle p-3 fs-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0 text-white">{{ $user->NAME }}</h4>
                    <span class="badge bg-primary text-white">Role: FIELD_OFFICER (Employee: {{ $officer->EMPLOYEE_NO ?? 'OFF-0001' }})</span>
                </div>
            </div>

            <form method="POST" action="{{ route('officer.profile.update') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-medium">Full Name</label>
                    <input type="text" name="name" class="form-control bg-dark text-white border-secondary" value="{{ old('name', $user->NAME) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-medium">Email Address (Read Only)</label>
                    <input type="email" class="form-control bg-dark text-secondary border-secondary" value="{{ $user->EMAIL }}" readonly disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-medium">Phone Number</label>
                    <input type="text" name="phone" class="form-control bg-dark text-white border-secondary" value="{{ old('phone', $officer->PHONE ?? '') }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary small fw-medium">Assigned Geographic Area</label>
                    <input type="text" name="assigned_area" class="form-control bg-dark text-white border-secondary" value="{{ old('assigned_area', $officer->ASSIGNED_AREA ?? '') }}" required>
                </div>

                <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 fw-bold">
                    <i class="bi bi-check-circle me-1"></i> Save Officer Profile
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
