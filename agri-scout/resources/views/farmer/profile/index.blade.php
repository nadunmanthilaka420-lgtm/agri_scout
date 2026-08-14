@extends('farmer.layouts.app')

@section('title', 'Farmer Profile')
@section('page_title', 'Account Profile Settings')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="glass-card p-4 p-md-5">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                <div class="bg-success bg-opacity-25 text-success rounded-circle p-3 fs-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0 text-white">{{ $user->NAME }}</h4>
                    <span class="badge bg-success text-white">Role: FARMER (Oracle USERS + FARMERS)</span>
                </div>
            </div>

            <form method="POST" action="{{ route('farmer.profile.update') }}">
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
                    <input type="text" name="phone" class="form-control bg-dark text-white border-secondary" value="{{ old('phone', $farmer->PHONE ?? '') }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary small fw-medium">Address</label>
                    <textarea name="address" class="form-control bg-dark text-white border-secondary" rows="3" required>{{ old('address', $farmer->ADDRESS ?? '') }}</textarea>
                </div>

                <button type="submit" class="btn btn-success px-4 py-2 rounded-3 fw-bold">
                    <i class="bi bi-check-circle me-1"></i> Save Profile Changes
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
