<!DOCTYPE html>
<html>
  <head>
    @include('admin.css')
  </head>
  <body>
    @include('admin.header')
    @include('admin.sidebar')
    <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h2 class="h5 no-margin-bottom">Field Officers Directory</h2>
              <a href="{{ route('admin.add_officer') }}" class="btn btn-success btn-sm">+ Add New Field Officer</a>
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

            <section class="no-padding-top no-padding-bottom">
              <div class="row">
                <div class="col-md-12">
                  <div class="block">
                    <div class="block-header">
                      <h3 class="block-title">Field Officers Roster</h3>
                    </div>
                    <div class="block-body">
                      <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                          <thead>
                            <tr>
                              <th>Emp No</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Phone</th>
                              <th>Assigned Area</th>
                              <th>Field Visits</th>
                              <th>Status</th>
                              <th style="width: 160px;">Admin Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse($officers as $officer)
                              @php
                                $oid = $officer->OFFICER_ID ?? ($officer->officer_id ?? 'N/A');
                                $empNo = $officer->EMPLOYEE_NO ?? ($officer->employee_no ?? 'N/A');
                                $name = $officer->FULL_NAME ?? ($officer->full_name ?? ($officer->NAME ?? 'N/A'));
                                $email = $officer->EMAIL ?? ($officer->email ?? 'N/A');
                                $phone = $officer->PHONE ?? ($officer->phone ?? 'N/A');
                                $area = $officer->ASSIGNED_AREA ?? ($officer->assigned_area ?? 'N/A');
                                $visitsCount = isset($officer->visits) ? $officer->visits->count() : 0;
                                $status = strtoupper($officer->STATUS ?? ($officer->user->STATUS ?? 'ACTIVE'));
                              @endphp
                              <tr>
                                <td><span class="badge badge-secondary">{{ $empNo }}</span></td>
                                <td><strong>{{ $name }}</strong></td>
                                <td><a href="mailto:{{ $email }}" class="text-info">{{ $email }}</a></td>
                                <td>{{ $phone }}</td>
                                <td><span class="badge badge-outline-info">📍 {{ $area }}</span></td>
                                <td><span class="badge badge-info">{{ $visitsCount }} Visits</span></td>
                                <td>
                                  @if($status === 'ACTIVE' || $status === 'ON_FIELD')
                                    <span class="badge badge-success">{{ $status }}</span>
                                  @else
                                    <span class="badge badge-warning">{{ $status }}</span>
                                  @endif
                                </td>
                                <td>
                                  <div class="d-flex gap-1 align-items-center">
                                    <!-- Edit Modal Trigger Button -->
                                    <button type="button" class="btn btn-sm btn-info me-1" data-toggle="modal" data-target="#editModal{{ $oid }}">
                                      Edit
                                    </button>

                                    <!-- Delete Form -->
                                    <form action="{{ route('admin.delete_officer', $oid) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete Field Officer #{{ $empNo }} ({{ $name }})?');" style="display:inline;">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="btn btn-sm btn-danger">
                                        Delete
                                      </button>
                                    </form>
                                  </div>

                                  <!-- Modal for Admin Officer Edit -->
                                  <div class="modal fade" id="editModal{{ $oid }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $oid }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                      <div class="modal-content bg-dark text-white">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="modalLabel{{ $oid }}">Edit Field Officer #{{ $empNo }}</h5>
                                          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form action="{{ route('admin.update_officer', $oid) }}" method="POST">
                                          @csrf
                                          <div class="modal-body text-left">
                                            <div class="form-group mb-3">
                                              <label class="form-label font-weight-bold">Employee Number</label>
                                              <input type="text" name="employee_no" class="form-control bg-secondary text-white border-0" value="{{ $empNo }}" required>
                                            </div>

                                            <div class="form-group mb-3">
                                              <label class="form-label font-weight-bold">Full Name</label>
                                              <input type="text" name="name" class="form-control bg-secondary text-white border-0" value="{{ $name }}" required>
                                            </div>

                                            <div class="form-group mb-3">
                                              <label class="form-label font-weight-bold">Phone Number</label>
                                              <input type="text" name="phone" class="form-control bg-secondary text-white border-0" value="{{ $phone }}" required>
                                            </div>

                                            <div class="form-group mb-3">
                                              <label class="form-label font-weight-bold">Email Address</label>
                                              <input type="email" name="email" class="form-control bg-secondary text-white border-0" value="{{ $email }}" required>
                                            </div>

                                            <div class="form-group mb-3">
                                              <label class="form-label font-weight-bold">Assigned Area / Region</label>
                                              <input type="text" name="area" class="form-control bg-secondary text-white border-0" value="{{ $area }}" required>
                                            </div>

                                            <div class="form-group mb-3">
                                              <label class="form-label font-weight-bold">Status</label>
                                              <select name="status" class="form-control bg-secondary text-white border-0">
                                                <option value="ACTIVE" {{ $status === 'ACTIVE' ? 'selected' : '' }}>ACTIVE</option>
                                                <option value="ON_FIELD" {{ $status === 'ON_FIELD' ? 'selected' : '' }}>ON_FIELD</option>
                                                <option value="INACTIVE" {{ $status === 'INACTIVE' ? 'selected' : '' }}>INACTIVE</option>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
                                <td colspan="8" class="text-center text-muted py-4">No field officers registered.</td>
                              </tr>
                            @endforelse
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
    </div>
    @include('admin.footer')
  </body>
</html>
