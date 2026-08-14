@extends('farmer.layouts.app')

@section('title', 'Farm Details')
@section('page_title', 'Farm Details & Integration')

@section('content')
<div class="row g-4 mb-4">
    <!-- Oracle Relational Data -->
    <div class="col-lg-5">
        <div class="glass-card p-4 h-100 border-success border-opacity-50">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 text-white"><i class="bi bi-database-fill text-success me-2"></i> Oracle Relational Data</h5>
                <span class="badge bg-success bg-opacity-25 text-success">Oracle 21c</span>
            </div>

            <div class="mb-3 pb-3 border-bottom border-secondary border-opacity-25">
                <span class="text-secondary small">Farm Name</span>
                <h4 class="fw-bold text-success mb-0">{{ $farm->FARM_NAME ?? $farm->FARMNAME }}</h4>
            </div>

            <div class="row g-3">
                <div class="col-6">
                    <span class="text-secondary small">Farm ID</span>
                    <p class="fw-bold text-white mb-0">#{{ $farm->FARM_ID }}</p>
                </div>
                <div class="col-6">
                    <span class="text-secondary small">Location</span>
                    <p class="fw-bold text-white mb-0">{{ $farm->LOCATION ?? 'N/A' }}</p>
                </div>
                <div class="col-6">
                    <span class="text-secondary small">District</span>
                    <p class="fw-bold text-white mb-0">{{ $farm->DISTRICT ?? 'N/A' }}</p>
                </div>
                <div class="col-6">
                    <span class="text-secondary small">Total Area</span>
                    <p class="fw-bold text-white mb-0">{{ $farm->AREA }} Acres</p>
                </div>
            </div>

            @if($farm->farmer)
                <div class="mt-4 pt-3 border-top border-secondary border-opacity-25">
                    <h6 class="fw-bold text-secondary mb-2"><i class="bi bi-person-fill me-1"></i> Farmer Profile (Oracle)</h6>
                    <p class="mb-1 text-white"><strong>Name:</strong> {{ $farm->farmer->NAME }}</p>
                    <p class="mb-1 text-white"><strong>Phone:</strong> {{ $farm->farmer->PHONE }}</p>
                    <p class="mb-0 text-white"><strong>Email:</strong> {{ $farm->farmer->EMAIL }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- MongoDB Non-Relational Data -->
    <div class="col-lg-7">
        <div class="glass-card p-4 h-100 border-warning border-opacity-50">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0 text-white"><i class="bi bi-hdd-network-fill text-warning me-2"></i> MongoDB Flexible Collections</h5>
                <span class="badge bg-warning bg-opacity-25 text-warning">MongoDB Document Store</span>
            </div>

            <!-- Crops from MongoDB -->
            <div class="mb-4">
                <h6 class="fw-bold text-warning mb-2"><i class="bi bi-flower2 me-1"></i> Crops (crops collection: farm_id={{ $farm->FARM_ID }})</h6>
                <div class="table-responsive">
                    <table class="table table-dark table-sm table-bordered align-middle">
                        <thead>
                            <tr class="text-secondary small">
                                <th>Crop Name</th>
                                <th>Variety</th>
                                <th>Stage</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($crops as $c)
                                <tr>
                                    <td class="fw-medium text-warning">{{ $c->crop_name }}</td>
                                    <td>{{ $c->variety ?? 'N/A' }}</td>
                                    <td>{{ $c->current_stage ?? 'N/A' }}</td>
                                    <td><span class="badge bg-success">{{ $c->status }}</span></td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-secondary py-2">No crops recorded in MongoDB for this farm.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Disease Reports from MongoDB -->
            <div class="mb-4">
                <h6 class="fw-bold text-danger mb-2"><i class="bi bi-bug-fill me-1"></i> Disease Incidents (disease_reports)</h6>
                @forelse($diseaseReports as $d)
                    <div class="p-2 mb-2 rounded bg-dark border border-danger border-opacity-25 small">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold text-danger">{{ $d->disease['name'] ?? 'Incident' }} ({{ $d->crop_name }})</span>
                            <span class="badge bg-danger">{{ $d->status }}</span>
                        </div>
                        <p class="mb-1 text-secondary mt-1">{{ $d->description }}</p>
                        <span class="text-info">Recommended Treatment: {{ $d->treatment['recommended'] ?? 'N/A' }}</span>
                    </div>
                @empty
                    <p class="text-secondary small">No disease incidents logged in MongoDB.</p>
                @endforelse
            </div>

            <!-- Visit Reports from MongoDB -->
            <div>
                <h6 class="fw-bold text-info mb-2"><i class="bi bi-clipboard-data-fill me-1"></i> Field Visit Reports (visit_reports)</h6>
                @forelse($visitReports as $vr)
                    <div class="p-2 mb-2 rounded bg-dark border border-info border-opacity-25 small">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold text-info">Visit #{{ $vr->visit_id }} ({{ $vr->report_date }})</span>
                            <span class="badge bg-info">Crop: {{ $vr->crop_condition }}</span>
                        </div>
                        <p class="mb-1 text-light mt-1">{{ $vr->remarks }}</p>
                    </div>
                @empty
                    <p class="text-secondary small">No detailed visit reports filed in MongoDB.</p>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection
