@extends('customer.layouts.app')

@section('title', 'Crop Details')
@section('page_title', 'Crop & Origin Farm Intelligence')

@section('content')
<div class="row g-4 justify-content-center">
    <!-- MongoDB Crop Details -->
    <div class="col-lg-6">
        <div class="glass-card p-4 h-100 border-warning border-opacity-50">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 text-white"><i class="bi bi-flower2 text-warning me-2"></i> MongoDB Crop Specifications</h5>
                <span class="badge bg-warning text-dark">MongoDB</span>
            </div>

            <div class="mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                <span class="badge bg-dark border border-warning text-warning mb-1">{{ $crop->category }}</span>
                <h3 class="fw-bold text-white mb-0">{{ $crop->crop_name }}</h3>
                <span class="text-secondary">Variety: {{ $crop->variety }}</span>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-6">
                    <span class="text-secondary small d-block">Planting Date</span>
                    <span class="fw-bold text-white">{{ $crop->planting_date }}</span>
                </div>
                <div class="col-6">
                    <span class="text-secondary small d-block">Expected Harvest</span>
                    <span class="fw-bold text-white">{{ $crop->expected_harvest_date }}</span>
                </div>
                <div class="col-6">
                    <span class="text-secondary small d-block">Growth Stage</span>
                    <span class="badge bg-info text-dark fs-6">{{ $crop->current_stage }}</span>
                </div>
                <div class="col-6">
                    <span class="text-secondary small d-block">Estimated Total Yield</span>
                    <span class="fw-bold text-success fs-6">{{ $crop->estimated_yield }} {{ $crop->yield_unit }}</span>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top border-secondary border-opacity-25">
                <a href="{{ route('customer.orders.create', ['crop_id' => $crop->_id]) }}" class="btn btn-pink text-white w-100 py-2 rounded-3 fw-bold" style="background: #ec4899;">
                    <i class="bi bi-bag-check-fill me-2"></i> Place Order for this Crop
                </a>
            </div>
        </div>
    </div>

    <!-- Oracle Farm & Farmer Information -->
    <div class="col-lg-6">
        <div class="glass-card p-4 h-100 border-success border-opacity-50">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 text-white"><i class="bi bi-tree text-success me-2"></i> Oracle Origin Farm & Farmer</h5>
                <span class="badge bg-success">Oracle 21c</span>
            </div>

            @if($farm)
                <div class="p-3 rounded-3 bg-dark border border-secondary border-opacity-25 mb-4">
                    <h6 class="fw-bold text-success mb-2"><i class="bi bi-geo-alt me-1"></i> Farm Details (Oracle FARMS)</h6>
                    <p class="mb-1 text-white"><strong>Farm Name:</strong> {{ $farm->FARM_NAME ?? $farm->FARMNAME }}</p>
                    <p class="mb-1 text-white"><strong>Location:</strong> {{ $farm->LOCATION }}, {{ $farm->DISTRICT }}</p>
                    <p class="mb-0 text-white"><strong>Farm Area:</strong> {{ $farm->AREA }} Acres</p>
                </div>
            @else
                <div class="p-3 rounded-3 bg-dark text-secondary mb-4">Origin farm information not linked in Oracle.</div>
            @endif

            @if($farmer)
                <div class="p-3 rounded-3 bg-dark border border-secondary border-opacity-25">
                    <h6 class="fw-bold text-info mb-2"><i class="bi bi-person-circle me-1"></i> Farmer Profile (Oracle FARMERS)</h6>
                    <p class="mb-1 text-white"><strong>Farmer Name:</strong> {{ $farmer->NAME }}</p>
                    <p class="mb-1 text-white"><strong>Contact Phone:</strong> {{ $farmer->PHONE }}</p>
                    <p class="mb-0 text-white"><strong>Address:</strong> {{ $farmer->ADDRESS }}</p>
                </div>
            @else
                <div class="p-3 rounded-3 bg-dark text-secondary">Farmer contact details pending assignment.</div>
            @endif
        </div>
    </div>
</div>
@endsection
