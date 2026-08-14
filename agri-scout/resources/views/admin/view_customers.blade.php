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
              <h2 class="h5 no-margin-bottom">Registered Customers Directory</h2>
              <span class="badge badge-info">Admin Account Management</span>
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
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Phone</th>
                        <th>Delivery Address</th>
                        <th>Orders Placed</th>
                        <th>Status</th>
                        <th style="width: 180px;">Admin Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($customers as $customer)
                        @php
                          $cid = $customer->CUSTOMER_ID ?? ($customer->USER_ID ?? $customer->user_id);
                          $name = $customer->FULL_NAME ?? ($customer->NAME ?? ($customer->user->NAME ?? 'N/A'));
                          $email = $customer->EMAIL ?? ($customer->user->EMAIL ?? 'N/A');
                          $phone = $customer->PHONE ?? 'N/A';
                          $address = $customer->ADDRESS ?? 'N/A';
                          $ordersCount = isset($customer->orders) ? $customer->orders->count() : 0;
                          $status = strtoupper($customer->STATUS ?? ($customer->user->STATUS ?? 'ACTIVE'));
                        @endphp
                        <tr>
                          <td><strong>#{{ $cid }}</strong></td>
                          <td><strong>{{ $name }}</strong></td>
                          <td><a href="mailto:{{ $email }}" class="text-info">{{ $email }}</a></td>
                          <td>{{ $phone }}</td>
                          <td>{{ $address }}</td>
                          <td>
                            <span class="badge badge-primary font-weight-bold">{{ $ordersCount }} Orders</span>
                          </td>
                          <td>
                            @if($status === 'ACTIVE')
                              <span class="badge badge-success">ACTIVE</span>
                            @elseif($status === 'INACTIVE')
                              <span class="badge badge-warning">INACTIVE</span>
                            @else
                              <span class="badge badge-danger">{{ $status }}</span>
                            @endif
                          </td>
                          <td>
                            <div class="d-flex gap-1 align-items-center">
                              <!-- Status Modal Trigger Button -->
                              <button type="button" class="btn btn-sm btn-info me-1" data-toggle="modal" data-target="#editModal{{ $cid }}">
                                Status
                              </button>

                              <!-- Delete Form -->
                              <form action="{{ route('admin.delete_customer', $cid) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete customer account #{{ $cid }} ({{ $name }})?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                  Delete
                                </button>
                              </form>
                            </div>

                            <!-- Modal for Admin Status Update -->
                            <div class="modal fade" id="editModal{{ $cid }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $cid }}" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content bg-dark text-white">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel{{ $cid }}">Manage Customer Account #{{ $cid }}</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form action="{{ route('admin.update_customer_status', $cid) }}" method="POST">
                                    @csrf
                                    <div class="modal-body text-left">
                                      <p class="mb-1"><strong>Name:</strong> {{ $name }}</p>
                                      <p class="mb-1"><strong>Email:</strong> {{ $email }}</p>
                                      <p class="mb-3"><strong>Phone:</strong> {{ $phone }}</p>

                                      <div class="form-group mb-3">
                                        <label class="form-label font-weight-bold">Account Access Status</label>
                                        <select name="status" class="form-control bg-secondary text-white border-0" required>
                                          <option value="ACTIVE" {{ $status === 'ACTIVE' ? 'selected' : '' }}>ACTIVE (Full System Access)</option>
                                          <option value="INACTIVE" {{ $status === 'INACTIVE' ? 'selected' : '' }}>INACTIVE (Suspended Access)</option>
                                          <option value="BLOCKED" {{ $status === 'BLOCKED' ? 'selected' : '' }}>BLOCKED (Blocked Account)</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                      <button type="submit" class="btn btn-success font-weight-bold">Update Status</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>

                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="8" class="text-center text-muted py-4">No registered customers found.</td>
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
