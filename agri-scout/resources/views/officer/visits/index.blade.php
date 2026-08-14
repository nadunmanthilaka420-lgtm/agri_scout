@extends('officer.layouts.app')

@section('title', 'Visits')
@section('page_title', 'Field Inspection Visits')

@section('content')
<div class="glass-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1 text-white"><i class="bi bi-calendar-check-fill text-primary me-2"></i> Field Visits Schedule</h5>
            <p class="text-secondary small mb-0">Retrieved from Oracle Relational Database (OFFICER_VISITS table)</p>
        </div>
        <a href="{{ route('officer.visits.create') }}" class="btn btn-primary px-3 py-2 rounded-3 fw-bold">
            <i class="bi bi-plus-lg me-1"></i> Schedule New Visit
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle border-secondary border-opacity-25">
            <thead class="table-secondary">
                <tr>
                    <th>Visit ID</th>
                    <th>Farm Name</th>
                    <th>Farmer Name</th>
                    <th>Visit Date</th>
                    <th>Visit Type</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($visits as $v)
                    <tr>
                        <td>#{{ $v->VISIT_ID }}</td>
                        <td class="fw-bold text-white">{{ $v->farm->FARM_NAME ?? $v->farm->FARMNAME }}</td>
                        <td>{{ $v->farm->farmer->NAME ?? 'Farmer' }}</td>
                        <td>{{ $v->VISIT_DATE }}</td>
                        <td><span class="badge bg-secondary">{{ $v->VISIT_TYPE }}</span></td>
                        <td>{{ Str::limit($v->PURPOSE, 35) }}</td>
                        <td>
                            <span class="badge bg-{{ $v->STATUS === 'COMPLETED' ? 'success' : ($v->STATUS === 'PENDING' ? 'warning' : 'info') }}">
                                {{ $v->STATUS }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('officer.visits.show', $v->VISIT_ID) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('officer.visits.edit', $v->VISIT_ID) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($v->STATUS !== 'COMPLETED')
                                    <a href="{{ route('officer.visit-reports.create', ['visit_id' => $v->VISIT_ID]) }}" class="btn btn-sm btn-success px-2" title="Submit Report">
                                        <i class="bi bi-journal-plus me-1"></i> Report
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-secondary py-4">No field visits scheduled.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
