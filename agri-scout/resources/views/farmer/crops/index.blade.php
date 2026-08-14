@extends('farmer.layouts.app')

@section('title', 'My Crops')
@section('page_title', 'My Active Crops')

@section('content')
<div class="glass-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1 text-white"><i class="bi bi-flower2 text-warning me-2"></i> Farm Crop Records</h5>
            <p class="text-secondary small mb-0">Retrieved from MongoDB Document Store (crops collection)</p>
        </div>
        <span class="badge bg-warning bg-opacity-25 text-warning px-3 py-2 border border-warning border-opacity-25 rounded-pill">
            <i class="bi bi-hdd-network me-1"></i> MongoDB Collection
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle border-secondary border-opacity-25">
            <thead class="table-secondary">
                <tr>
                    <th>Crop Name</th>
                    <th>Variety</th>
                    <th>Category</th>
                    <th>Planting Date</th>
                    <th>Expected Harvest</th>
                    <th>Stage</th>
                    <th>Yield Estimate</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($crops as $c)
                    <tr>
                        <td class="fw-bold text-warning">{{ $c->crop_name }}</td>
                        <td>{{ $c->variety ?? 'N/A' }}</td>
                        <td><span class="badge bg-dark border border-secondary">{{ $c->category }}</span></td>
                        <td>{{ $c->planting_date }}</td>
                        <td>{{ $c->expected_harvest_date }}</td>
                        <td><span class="badge bg-info text-dark">{{ $c->current_stage }}</span></td>
                        <td>{{ $c->estimated_yield }} {{ $c->yield_unit }}</td>
                        <td><span class="badge bg-success">{{ $c->status }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-secondary py-4">No crops recorded in MongoDB for your farms.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
