@extends('officer.layouts.app')

@section('title', 'Assigned Farms')
@section('page_title', 'Assigned Farm Directory')

@section('content')
<div class="glass-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1 text-white"><i class="bi bi-tree-fill text-success me-2"></i> Field Officer Assigned Farms</h5>
            <p class="text-secondary small mb-0">Retrieved from Oracle Relational Database (FARMS & FARMERS tables)</p>
        </div>
        <span class="badge bg-success bg-opacity-25 text-success px-3 py-2 border border-success border-opacity-25 rounded-pill">
            <i class="bi bi-database me-1"></i> Oracle Database
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle border-secondary border-opacity-25">
            <thead class="table-secondary">
                <tr>
                    <th>Farm Name</th>
                    <th>Farmer Name</th>
                    <th>Location</th>
                    <th>District</th>
                    <th>Area (Acres)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($farms as $f)
                    <tr>
                        <td class="fw-bold text-success">{{ $f->FARM_NAME ?? $f->FARMNAME }}</td>
                        <td>{{ $f->farmer->NAME ?? 'Assigned Farmer' }}</td>
                        <td>{{ $f->LOCATION ?? 'N/A' }}</td>
                        <td><span class="badge bg-dark border border-secondary">{{ $f->DISTRICT ?? 'N/A' }}</span></td>
                        <td>{{ $f->AREA ?? 'N/A' }} Acres</td>
                        <td>
                            <a href="{{ route('officer.farms.show', $f->FARM_ID) }}" class="btn btn-sm btn-primary rounded-3 px-3">
                                <i class="bi bi-eye-fill me-1"></i> View Farm & MongoDB Reports
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-secondary py-4">No farms assigned to your field area.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
