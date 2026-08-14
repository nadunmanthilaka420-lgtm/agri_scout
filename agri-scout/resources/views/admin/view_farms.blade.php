<!DOCTYPE html>
<html>
  <head>
    @include('admin.css')
    <style>
      .farm-table-container {
        width: 95%;
        margin: 35px auto;
        padding: 25px;
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #dce8dc;
        box-shadow: 0 10px 30px rgba(46, 125, 50, 0.12);
        overflow-x: auto;
      }
      .farm-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-family: "Segoe UI", Arial, sans-serif;
        font-size: 14px;
      }
      .farm-table thead th {
        padding: 16px 18px;
        text-align: left;
        color: #ffffff;
        font-weight: 600;
        background: linear-gradient(135deg, #2e7d32, #1b5e20);
        white-space: nowrap;
      }
      .farm-table tbody tr {
        background: #ffffff;
        transition: background 0.3s ease;
      }
      .farm-table tbody tr:nth-child(even) {
        background: #f7fbf7;
      }
      .farm-table tbody tr:hover {
        background: #e8f5e9;
      }
      .farm-table tbody td {
        padding: 15px 18px;
        color: #455a64;
        border-bottom: 1px solid #e2ebe2;
        vertical-align: middle;
      }
      .farm-name {
        color: #1b5e20;
        font-weight: 700;
      }
      .farmer-name {
        color: #2e7d32;
        font-weight: 600;
      }
      .farm-icon {
        display: inline-flex;
        width: 32px;
        height: 32px;
        margin-right: 8px;
        align-items: center;
        justify-content: center;
        background: #e8f5e9;
        border-radius: 50%;
        font-size: 16px;
      }
    </style>
  </head>
  <body>
    @include('admin.header')
    @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h2 class="h5 no-margin-bottom">Registered Farms Directory</h2>
              <a href="{{ route('admin.add_farm') }}" class="btn btn-success btn-sm">+ Add New Farm</a>
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

            <div class="farm-table-container">
              <table class="farm-table">
                <thead>
                  <tr>
                    <th>Farm ID</th>
                    <th>🌾 Farm Name</th>
                    <th>📍 Location / District</th>
                    <th>📐 Area</th>
                    <th>👨‍🌾 Farmer Owner</th>
                    <th>📧 Contact Email</th>
                    <th>📋 Officer Visits</th>
                    <th style="width: 160px;">Admin Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($farms as $farm)
                    @php
                      $fid = $farm->FARM_ID;
                      $fname = $farm->FARM_NAME ?? ($farm->FARMNAME ?? 'N/A');
                      $loc = $farm->LOCATION ?? 'N/A';
                      $dist = $farm->DISTRICT ?? '';
                      $locationFull = $dist ? "{$loc} ({$dist})" : $loc;
                      $areaVal = $farm->AREA ? "{$farm->AREA} Acres" : 'N/A';
                      $farmerName = $farm->farmer->NAME ?? 'N/A';
                      $farmerEmail = $farm->farmer->EMAIL ?? 'N/A';
                      $farmerPhone = $farm->farmer->PHONE ?? 'N/A';
                      $visitsCount = isset($farm->visits) ? $farm->visits->count() : 0;
                    @endphp
                    <tr>
                      <td><strong>#{{ $fid }}</strong></td>
                      <td class="farm-name">
                        <span class="farm-icon">🌱</span>
                        {{ $fname }}
                      </td>
                      <td class="farm-location">
                        📍 {{ $locationFull }}
                      </td>
                      <td>
                        <span class="badge badge-secondary">{{ $areaVal }}</span>
                      </td>
                      <td class="farmer-name">
                        {{ $farmerName }}
                        @if($farmerPhone !== 'N/A')
                          <br><small class="text-muted">📞 {{ $farmerPhone }}</small>
                        @endif
                      </td>
                      <td class="farmer-email">
                        <a href="mailto:{{ $farmerEmail }}" class="text-info">{{ $farmerEmail }}</a>
                      </td>
                      <td>
                        <span class="badge badge-info">{{ $visitsCount }} Visits</span>
                      </td>
                      <td>
                        <div class="d-flex gap-1 align-items-center">
                          <!-- Edit Modal Trigger Button -->
                          <button type="button" class="btn btn-sm btn-info me-1" data-toggle="modal" data-target="#editModal{{ $fid }}">
                            Edit
                          </button>

                          <!-- Delete Form -->
                          <form action="{{ route('admin.delete_farm', $fid) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete Farm #{{ $fid }} ({{ $fname }})?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                              Delete
                            </button>
                          </form>
                        </div>

                        <!-- Modal for Admin Farm Edit -->
                        <div class="modal fade" id="editModal{{ $fid }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $fid }}" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content bg-dark text-white">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel{{ $fid }}">Edit Farm #{{ $fid }} Details</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="{{ route('admin.update_farm', $fid) }}" method="POST">
                                @csrf
                                <div class="modal-body text-left">
                                  <div class="form-group mb-3">
                                    <label class="form-label font-weight-bold">Farm Name</label>
                                    <input type="text" name="farmname" class="form-control bg-secondary text-white border-0" value="{{ $fname }}" required>
                                  </div>

                                  <div class="form-group mb-3">
                                    <label class="form-label font-weight-bold">Location</label>
                                    <input type="text" name="location" class="form-control bg-secondary text-white border-0" value="{{ $loc }}" required>
                                  </div>

                                  <div class="form-group mb-3">
                                    <label class="form-label font-weight-bold">District</label>
                                    <input type="text" name="district" class="form-control bg-secondary text-white border-0" value="{{ $dist }}">
                                  </div>

                                  <div class="form-group mb-3">
                                    <label class="form-label font-weight-bold">Area Size (Acres)</label>
                                    <input type="text" name="area" class="form-control bg-secondary text-white border-0" value="{{ $farm->AREA }}">
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
                      <td colspan="8" class="text-center text-muted py-4">🌱 No farms registered in system.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    @include('admin.footer')
  </body>
</html>
