@extends('customer.layouts.app')

@section('title', 'Customer Profile')
@section('page_title', 'Customer Account Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="glass-card p-4 p-md-5">
            <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                <div class="bg-pink bg-opacity-25 text-pink rounded-circle p-3 fs-2 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; color: #ec4899;">
                    <i class="bi bi-person-fill text-pink" style="color: #ec4899;"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0 text-white">{{ $user->NAME }}</h4>
                    <span class="badge bg-pink text-white" style="background: #ec4899;">Role: CUSTOMER (ID: #{{ $customer->CUSTOMER_ID ?? 'N/A' }})</span>
                </div>
            </div>

            <form method="POST" action="{{ route('customer.profile.update') }}">
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
                    <input type="text" name="phone" class="form-control bg-dark text-white border-secondary" value="{{ old('phone', $customer->PHONE ?? '') }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary small fw-medium">Delivery Address</label>
                    <textarea name="address" class="form-control bg-dark text-white border-secondary" rows="3" required>{{ old('address', $customer->ADDRESS ?? '') }}</textarea>
                </div>

                <button type="submit" class="btn btn-pink text-white px-4 py-2 rounded-3 fw-bold" style="background: #ec4899;">
                    <i class="bi bi-check-circle me-1"></i> Save Profile Changes
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
