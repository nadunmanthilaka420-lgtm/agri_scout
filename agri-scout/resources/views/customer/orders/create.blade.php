@extends('customer.layouts.app')

@section('title', 'Place Order')
@section('page_title', 'Create Produce Order')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="glass-card p-4 p-md-5">
            <h5 class="fw-bold mb-4 text-white"><i class="bi bi-cart-plus text-pink me-2" style="color: #ec4899;"></i> New Order Entry (Oracle ORDERS)</h5>

            <form method="POST" action="{{ route('customer.orders.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-medium">Produce Crop Name</label>
                    <input type="text" name="crop_name" class="form-control bg-dark text-white border-secondary" value="{{ old('crop_name', $selectedCrop->crop_name ?? '') }}" placeholder="e.g. Mango (Karutha Colomban), Cinnamon" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-secondary small fw-medium">Target Farm (Oracle)</label>
                    <select name="farm_id" class="form-select bg-dark text-white border-secondary" required>
                        <option value="">-- Choose Farm --</option>
                        @foreach($farms as $f)
                            <option value="{{ $f->FARM_ID }}" {{ (isset($selectedCrop) && $selectedCrop->farm_id == $f->FARM_ID) ? 'selected' : '' }}>
                                {{ $f->FARM_NAME ?? $f->FARMNAME }} (Location: {{ $f->LOCATION }}, District: {{ $f->DISTRICT }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-medium">Quantity (KG / Units)</label>
                        <input type="number" step="0.01" min="1" name="quantity" class="form-control bg-dark text-white border-secondary" value="100" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary small fw-medium">Unit Price (LKR per Unit)</label>
                        <input type="number" step="0.01" min="0.01" name="unit_price" class="form-control bg-dark text-white border-secondary" value="450.00" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('customer.orders.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                    <button type="submit" class="btn btn-pink text-white px-4 fw-bold" style="background: #ec4899;">
                        <i class="bi bi-check-circle me-1"></i> Submit Order to Oracle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
