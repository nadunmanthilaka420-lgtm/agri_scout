@extends('officer.layouts.app')

@section('title', 'Disease Reports')
@section('page_title', 'Pest & Disease Incidents')

@section('content')
<div class="glass-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1 text-white"><i class="bi bi-bug-fill text-danger me-2"></i> Disease Incident Directory</h5>
            <p class="text-secondary small mb-0">Stored in MongoDB Document Store (disease_reports collection)</p>
        </div>
        <a href="{{ route('officer.diseases.create') }}" class="btn btn-danger px-3 py-2 rounded-3 fw-bold">
            <i class="bi bi-plus-lg me-1"></i> Register Disease Incident
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle border-secondary border-opacity-25">
            <thead class="table-secondary">
                <tr>
                    <th>Reported Date</th>
                    <th>Crop Name</th>
                    <th>Disease</th>
                    <th>Severity</th>
                    <th>Status</th>
                    <th>Follow-ups</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($diseaseReports as $d)
                    <tr>
                        <td>{{ $d->reported_date }}</td>
                        <td class="fw-bold text-warning">{{ $d->crop_name }}</td>
                        <td class="fw-bold text-danger">{{ $d->disease['name'] ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ ($d->disease['severity'] ?? '') === 'HIGH' ? 'danger' : 'warning' }}">
                                {{ $d->disease['severity'] ?? 'MEDIUM' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $d->status === 'RESOLVED' ? 'success' : 'danger' }}">
                                {{ $d->status }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ count($d->follow_ups ?? []) }} entries
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('officer.diseases.show', $d->_id) }}" class="btn btn-sm btn-outline-info px-3">
                                View & Add Follow-up <i class="bi bi-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-secondary py-4">No disease incidents logged in MongoDB.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
