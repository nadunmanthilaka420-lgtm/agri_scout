@extends('officer.layouts.app')

@section('title', 'Farm Crops')
@section('page_title', 'Assigned Farm Crop Records')

@section('content')
<div class="glass-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1 text-white"><i class="bi bi-flower2 text-success me-2"></i> Crop Inventory</h5>
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
                    <th>Assigned Farm</th>
                    <th>Planting Date</th>
                    <th>Growth Stage</th>
                    <th>Expected Harvest</th>
                    <th>Est. Yield</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($crops as $c)
                    @php $farm = $farmsMap[$c->farm_id] ?? null; @endphp
                    <tr>
                        <td class="fw-bold text-warning">{{ $c->crop_name }}</td>
                        <td>{{ $c->variety }}</td>
                        <td>
                            @if($farm)
                                <a href="{{ route('officer.farms.show', $farm->FARM_ID) }}" class="text-info text-decoration-none">
                                    {{ $farm->FARM_NAME ?? $farm->FARMNAME }}
                                </a>
                            @else
                                <span class="text-secondary">Farm #{{ $c->farm_id }}</span>
                            @endif
                        </td>
                        <td>{{ $c->planting_date }}</td>
                        <td><span class="badge bg-info text-dark">{{ $c->current_stage }}</span></td>
                        <td>{{ $c->expected_harvest_date }}</td>
                        <td>{{ $c->estimated_yield }} {{ $c->yield_unit }}</td>
                        <td><span class="badge bg-success">{{ $c->status }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-secondary py-4">No crop records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
