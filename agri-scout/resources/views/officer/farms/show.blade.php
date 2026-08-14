@extends('officer.layouts.app')

@section('title', 'Farm Overview')
@section('page_title', 'Farm & Crop Intelligence')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-lg-5">
        <div class="glass-card p-4 h-100 border-primary border-opacity-50">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 text-white"><i class="bi bi-building text-primary me-2"></i> Oracle Relational Data</h5>
                <span class="badge bg-primary">Oracle 21c</span>
            </div>

            <div class="mb-3 pb-3 border-bottom border-secondary border-opacity-25">
                <span class="text-secondary small">Farm Name</span>
                <h4 class="fw-bold text-primary mb-0">{{ $farm->FARM_NAME ?? $farm->FARMNAME }}</h4>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-6">
                    <span class="text-secondary small">Location</span>
                    <p class="fw-bold text-white mb-0">{{ $farm->LOCATION }}</p>
                </div>
                <div class="col-6">
                    <span class="text-secondary small">District</span>
                    <p class="fw-bold text-white mb-0">{{ $farm->DISTRICT }}</p>
                </div>
                <div class="col-6">
                    <span class="text-secondary small">Total Area</span>
                    <p class="fw-bold text-white mb-0">{{ $farm->AREA }} Acres</p>
                </div>
                <div class="col-6">
                    <span class="text-secondary small">Farm ID</span>
                    <p class="fw-bold text-white mb-0">#{{ $farm->FARM_ID }}</p>
                </div>
            </div>

            @if($farm->farmer)
                <div class="p-3 rounded-3 bg-dark border border-secondary border-opacity-25 mt-3">
                    <h6 class="fw-bold text-success mb-2"><i class="bi bi-person-circle me-1"></i> Farmer Contacts (Oracle)</h6>
                    <p class="mb-1 text-white"><strong>Name:</strong> {{ $farm->farmer->NAME }}</p>
                    <p class="mb-1 text-white"><strong>Phone:</strong> {{ $farm->farmer->PHONE }}</p>
                    <p class="mb-0 text-white"><strong>Address:</strong> {{ $farm->farmer->ADDRESS }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-7">
        <div class="glass-card p-4 h-100 border-warning border-opacity-50">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 text-white"><i class="bi bi-flower2 text-warning me-2"></i> MongoDB Crops & Incident Records</h5>
                <span class="badge bg-warning text-dark">MongoDB</span>
            </div>

            <div class="mb-4">
                <h6 class="fw-bold text-warning mb-2"><i class="bi bi-sprout me-1"></i> Active Crops (crops)</h6>
                <div class="table-responsive">
                    <table class="table table-dark table-sm table-bordered align-middle">
                        <thead>
                            <tr class="text-secondary small">
                                <th>Crop</th>
                                <th>Variety</th>
                                <th>Stage</th>
                                <th>Est. Yield</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($crops as $c)
                                <tr>
                                    <td class="fw-bold text-warning">{{ $c->crop_name }}</td>
                                    <td>{{ $c->variety }}</td>
                                    <td><span class="badge bg-info text-dark">{{ $c->current_stage }}</span></td>
                                    <td>{{ $c->estimated_yield }} {{ $c->yield_unit }}</td>
                                    <td><span class="badge bg-success">{{ $c->status }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-secondary py-2">No crops logged in MongoDB for this farm.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <h6 class="fw-bold text-danger mb-2"><i class="bi bi-bug-fill me-1"></i> Disease Incidents (disease_reports)</h6>
                @forelse($diseaseReports as $d)
                    <div class="p-2 mb-2 rounded bg-dark border border-danger border-opacity-25 small">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold text-danger">{{ $d->disease['name'] ?? 'Disease' }} ({{ $d->crop_name }})</span>
                            <span class="badge bg-danger">{{ $d->status }}</span>
                        </div>
                        <p class="mb-0 text-light mt-1">{{ $d->description }}</p>
                    </div>
                @empty
                    <p class="text-secondary small">No disease incidents logged in MongoDB.</p>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection
