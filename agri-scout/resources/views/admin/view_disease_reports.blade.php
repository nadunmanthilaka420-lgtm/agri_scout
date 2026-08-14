<!DOCTYPE html>
<html>
  <head>
    @include('admin.css')
  </head>
  <body>
    @include('admin.header')
    @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h2 class="h5 no-margin-bottom">Crop Disease Reports & Outbreaks (MongoDB)</h2>
              <span class="badge badge-info">Admin Full Control</span>
            </div>

            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif

            @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif

            <div class="row mt-3">
              <div class="col-lg-12">
                <div class="table-responsive">
                  <table class="table table-striped table-hover align-middle">
                    <thead>
                      <tr>
                        <th>Farm ID</th>
                        <th>Crop Name</th>
                        <th>Disease</th>
                        <th>Severity</th>
                        <th>Reported By</th>
                        <th>Reported Date</th>
                        <th>Symptoms</th>
                        <th>Treatment</th>
                        <th>Status</th>
                        <th style="width: 180px;">Admin Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($diseaseReports as $report)
                        <tr>
                          <td><strong>#{{ $report->farm_id ?? 'N/A' }}</strong></td>
                          <td><span class="badge badge-secondary">{{ $report->crop_name ?? 'N/A' }}</span></td>
                          <td>
                            <strong>
                              @if(is_array($report->disease))
                                {{ $report->disease['name'] ?? 'N/A' }}
                              @else
                                {{ $report->disease ?? 'N/A' }}
                              @endif
                            </strong>
                          </td>
                          <td>
                            @php
                              $sev = 'UNKNOWN';
                              if (is_array($report->disease) && isset($report->disease['severity'])) {
                                  $sev = strtoupper($report->disease['severity']);
                              } elseif (is_string($report->severity)) {
                                  $sev = strtoupper($report->severity);
                              }
                            @endphp
                            @if($sev === 'HIGH' || $sev === 'CRITICAL')
                              <span class="badge badge-danger">{{ $sev }}</span>
                            @elseif($sev === 'MEDIUM')
                              <span class="badge badge-warning">{{ $sev }}</span>
                            @else
                              <span class="badge badge-info">{{ $sev }}</span>
                            @endif
                          </td>
                          <td>
                            @if(is_array($report->reported_by))
                              {{ $report->reported_by['name'] ?? ($report->reported_by['role'] ?? json_encode($report->reported_by)) }}
                            @else
                              {{ $report->reported_by ?? 'N/A' }}
                            @endif
                          </td>
                          <td>{{ $report->reported_date ?? ($report->created_at ?? 'N/A') }}</td>
                          <td>
                            @if(is_array($report->symptoms))
                              {{ implode(', ', $report->symptoms) }}
                            @elseif(is_array($report->disease) && isset($report->disease['symptoms']) && is_array($report->disease['symptoms']))
                              {{ implode(', ', $report->disease['symptoms']) }}
                            @else
                              {{ $report->symptoms ?? 'N/A' }}
                            @endif
                          </td>
                          <td>
                            @if(is_array($report->treatment))
                              {{ $report->treatment['recommended'] ?? implode(', ', array_filter(array_map(fn($k, $v) => is_scalar($v) ? "$k: $v" : null, array_keys($report->treatment), $report->treatment))) }}
                            @else
                              {{ $report->treatment ?? 'N/A' }}
                            @endif
                          </td>
                          <td>
                            @php
                              $st = strtoupper($report->status ?? 'OPEN');
                            @endphp
                            @if($st === 'RESOLVED' || $st === 'CLOSED')
                              <span class="badge badge-success">{{ $st }}</span>
                            @elseif($st === 'IN_PROGRESS')
                              <span class="badge badge-warning">{{ $st }}</span>
                            @else
                              <span class="badge badge-danger">{{ $st }}</span>
                            @endif
                          </td>
                          <td>
                            <div class="d-flex gap-1 align-items-center">
                              <!-- Status Modal Trigger Button -->
                              <button type="button" class="btn btn-sm btn-info me-1" data-toggle="modal" data-target="#editModal{{ $report->id }}">
                                Manage
                              </button>

                              <!-- Delete Form -->
                              <form action="{{ route('admin.delete_disease_report', $report->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this disease report?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                  Delete
                                </button>
                              </form>
                            </div>

                            <!-- Modal for Admin Status Update & Notes -->
                            <div class="modal fade" id="editModal{{ $report->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $report->id }}" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content bg-dark text-white">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel{{ $report->id }}">Manage Disease Report #{{ $report->id }}</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form action="{{ route('admin.update_disease_status', $report->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body text-left">
                                      <p class="mb-2"><strong>Crop:</strong> {{ $report->crop_name }} (Farm #{{ $report->farm_id }})</p>
                                      <p class="mb-3"><strong>Description:</strong> {{ $report->description ?? 'N/A' }}</p>

                                      <div class="form-group mb-3">
                                        <label class="form-label font-weight-bold">Report Status</label>
                                        <select name="status" class="form-control bg-secondary text-white border-0" required>
                                          <option value="OPEN" {{ strtoupper($report->status) === 'OPEN' ? 'selected' : '' }}>OPEN (Active Outbreak)</option>
                                          <option value="IN_PROGRESS" {{ strtoupper($report->status) === 'IN_PROGRESS' ? 'selected' : '' }}>IN_PROGRESS (Treatment Applied)</option>
                                          <option value="RESOLVED" {{ strtoupper($report->status) === 'RESOLVED' ? 'selected' : '' }}>RESOLVED (Recovered)</option>
                                          <option value="CLOSED" {{ strtoupper($report->status) === 'CLOSED' ? 'selected' : '' }}>CLOSED (Case Closed)</option>
                                        </select>
                                      </div>

                                      <div class="form-group mb-3">
                                        <label class="form-label font-weight-bold">Admin Follow-Up Note / Treatment Remark</label>
                                        <textarea name="remarks" class="form-control bg-secondary text-white border-0" rows="3" placeholder="Enter follow-up observations or recommended treatment instructions..."></textarea>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-success font-weight-bold">Save Changes</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>

                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="10" class="text-center text-muted py-4">No crop disease reports recorded.</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    @include('admin.footer')
  </body>
</html>
