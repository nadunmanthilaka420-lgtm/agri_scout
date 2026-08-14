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

          <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 text-white">🌱 Crop Management (MongoDB Catalog)</h2>
            <a href="{{ route('admin.crops.create') }}" class="btn btn-success font-weight-bold">
              <i class="fa fa-plus me-1"></i> Add New Crop
            </a>
          </div>

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success!</strong> {{ session('success') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif

          @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Error!</strong> {{ session('error') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif

          <div class="block margin-bottom-sm">
            <div class="title"><strong>MongoDB Crops Collection</strong></div>
            <div class="table-responsive">
              <table class="table table-striped table-hover align-middle">
                <thead>
                  <tr>
                    <th>Crop Name</th>
                    <th>Variety</th>
                    <th>Source Farm (Oracle)</th>
                    <th>Category</th>
                    <th>Planting Date</th>
                    <th>Expected Harvest</th>
                    <th>Current Stage</th>
                    <th>Area (Acres)</th>
                    <th>Est. Yield</th>
                    <th>Status</th>
                    <th style="min-width: 140px;">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($crops as $c)
                    @php $farm = $farmsMap[$c->farm_id] ?? null; @endphp
                    <tr>
                      <td class="font-weight-bold text-white">{{ $c->crop_name }}</td>
                      <td>{{ $c->variety ?? '-' }}</td>
                      <td>
                        <span class="badge badge-info">
                          {{ $farm->FARM_NAME ?? $farm->FARMNAME ?? 'Farm #' . $c->farm_id }} (ID: {{ $c->farm_id }})
                        </span>
                      </td>
                      <td><span class="badge badge-warning">{{ $c->category }}</span></td>
                      <td>{{ $c->planting_date ?? '-' }}</td>
                      <td>{{ $c->expected_harvest_date ?? '-' }}</td>
                      <td><span class="badge badge-secondary">{{ $c->current_stage ?? '-' }}</span></td>
                      <td>{{ $c->area_acres ? $c->area_acres . ' Acres' : '-' }}</td>
                      <td>{{ $c->estimated_yield ? $c->estimated_yield . ' ' . ($c->yield_unit ?? 'KG') : '-' }}</td>
                      <td>
                        <span class="badge badge-{{ strtoupper($c->status) === 'GROWING' ? 'success' : (strtoupper($c->status) === 'PLANNED' ? 'info' : 'secondary') }}">
                          {{ $c->status }}
                        </span>
                      </td>
                      <td>
                        <div class="d-flex gap-1">
                          <a href="{{ route('admin.crops.edit', $c->_id) }}" class="btn btn-sm btn-info me-1" title="Edit Crop">
                            <i class="fa fa-edit"></i> Edit
                          </a>
                          <form action="{{ route('admin.crops.destroy', $c->_id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this crop document from MongoDB?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete Crop">
                              <i class="fa fa-trash"></i> Delete
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="11" class="text-center text-muted py-4">No crop documents found in MongoDB. Click "Add New Crop" to register one.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>

    @include('admin.footer')
  </body>
</html>
