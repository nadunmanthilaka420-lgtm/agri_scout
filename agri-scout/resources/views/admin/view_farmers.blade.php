<!DOCTYPE html>
<html>
  <head>
    @include('admin.css')

<style>
    /* =================================
       FARMER TABLE
       ================================= */

    .farmer-table-container {
        width: 95%;
        margin: 35px auto;
        background: #ffffff;
        border-radius: 18px;
        padding: 25px;

        box-shadow: 0 10px 30px rgba(46, 125, 50, 0.12);

        border: 1px solid #dce8dc;

        animation: tableAppear 0.6s ease-out;
        overflow-x: auto;
    }

    /* Table */
    .farmer-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;

        font-family: "Segoe UI", Arial, sans-serif;
        font-size: 14px;
    }

    /* Header */
    .farmer-table thead th {
        background: linear-gradient(
            135deg,
            #2e7d32,
            #1b5e20
        );

        color: #ffffff;

        padding: 16px 18px;

        text-align: left;

        font-weight: 600;

        border: none;
    }

    /* Rounded header corners */
    .farmer-table thead th:first-child {
        border-radius: 10px 0 0 0;
    }

    .farmer-table thead th:last-child {
        border-radius: 0 10px 0 0;
    }

    /* Table Rows */
    .farmer-table tbody tr {
        background: #ffffff;

        transition:
            background 0.3s ease,
            transform 0.3s ease,
            box-shadow 0.3s ease;
    }

    .farmer-table tbody tr:nth-child(even) {
        background: #f7fbf7;
    }

    /* Hover */
    .farmer-table tbody tr:hover {
        background: #e8f5e9;

        transform: translateX(4px);

        box-shadow:
            0 5px 15px rgba(46, 125, 50, 0.10);
    }

    /* Cells */
    .farmer-table tbody td {
        padding: 15px 18px;

        border-bottom: 1px solid #e3ebe3;

        color: #37474f;

        vertical-align: middle;
    }

    /* Farmer Name */
    .farmer-name {
        color: #1b5e20;
        font-weight: 600;
    }

    /* Phone */
    .farmer-phone {
        color: #455a64;
    }

    /* Email */
    .farmer-email {
        color: #2e7d32;
    }

    /* Address */
    .farmer-address {
        color: #607d8b;
    }

    /* Last row */
    .farmer-table tbody tr:last-child td:first-child {
        border-radius: 0 0 0 10px;
    }

    .farmer-table tbody tr:last-child td:last-child {
        border-radius: 0 0 10px 0;
    }

    /* Empty message */
    .no-farmers {
        text-align: center;
        padding: 35px;

        color: #78909c;
        font-size: 15px;
    }

    /* Animation */
    @keyframes tableAppear {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Mobile */
    @media (max-width: 700px) {

        .farmer-table-container {
            width: 92%;
            padding: 15px;
        }

        .farmer-table {
            min-width: 650px;
        }
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
              <h2 class="h5 no-margin-bottom">Registered Farmers Directory</h2>
              <a href="{{ route('admin.add_farmer') }}" class="btn btn-success btn-sm">+ Add New Farmer</a>
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

<div class="farmer-table-container">

    <table class="farmer-table">

        <thead>
            <tr>
                <th>🆔 ID</th>
                <th>👨‍🌾 Name</th>
                <th>📞 Phone</th>
                <th>📧 Email</th>
                <th>📍 Address</th>
                <th>🏡 Farms</th>
                <th style="width: 150px;">⚙️ Actions</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($farmers as $farmer)
                @php
                  $fid = $farmer->FARMER_ID ?? ($farmer->farmer_id ?? 'N/A');
                  $fname = $farmer->NAME ?? ($farmer->name ?? 'N/A');
                  $fphone = $farmer->PHONE ?? ($farmer->phone ?? 'N/A');
                  $femail = $farmer->EMAIL ?? ($farmer->email ?? 'N/A');
                  $faddress = $farmer->ADDRESS ?? ($farmer->address ?? 'N/A');
                  $farmsCount = isset($farmer->farms) ? $farmer->farms->count() : 0;
                @endphp
                <tr>

                    <td>
                      <strong>#{{ $fid }}</strong>
                    </td>

                    <td class="farmer-name">
                        🌱 {{ $fname }}
                    </td>

                    <td class="farmer-phone">
                        {{ $fphone }}
                    </td>

                    <td class="farmer-email">
                         <a href="mailto:{{ $femail }}" class="text-success">{{ $femail }}</a>
                    </td>

                    <td class="farmer-address">
                         {{ $faddress }}
                    </td>

                    <td>
                      <span class="badge badge-info">{{ $farmsCount }} Farms</span>
                    </td>

                    <td>
                      <div class="d-flex gap-1 align-items-center">
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-sm btn-info me-1" data-toggle="modal" data-target="#editModal{{ $fid }}">
                          Edit
                        </button>

                        <!-- Delete Form -->
                        <form action="{{ route('admin.delete_farmer', $fid) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete farmer #{{ $fid }} ({{ $fname }})?');" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger">
                            Delete
                          </button>
                        </form>
                      </div>

                      <!-- Edit Farmer Modal -->
                      <div class="modal fade" id="editModal{{ $fid }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $fid }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content bg-dark text-white">
                            <div class="modal-header">
                              <h5 class="modal-title" id="modalLabel{{ $fid }}">Edit Farmer #{{ $fid }}</h5>
                              <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="{{ route('admin.update_farmer', $fid) }}" method="POST">
                              @csrf
                              <div class="modal-body text-left">
                                <div class="form-group mb-3">
                                  <label class="form-label font-weight-bold">Farmer Name</label>
                                  <input type="text" name="name" class="form-control bg-secondary text-white border-0" value="{{ $fname }}" required>
                                </div>

                                <div class="form-group mb-3">
                                  <label class="form-label font-weight-bold">Phone Number</label>
                                  <input type="text" name="phone" class="form-control bg-secondary text-white border-0" value="{{ $fphone }}" required>
                                </div>

                                <div class="form-group mb-3">
                                  <label class="form-label font-weight-bold">Email Address</label>
                                  <input type="email" name="email" class="form-control bg-secondary text-white border-0" value="{{ $femail }}" required>
                                </div>

                                <div class="form-group mb-3">
                                  <label class="form-label font-weight-bold">Address</label>
                                  <input type="text" name="address" class="form-control bg-secondary text-white border-0" value="{{ $faddress }}" required>
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
                    <td colspan="7" class="no-farmers">No farmer records available.</td>
                </tr>
            @endforelse

        </tbody>

    </table>

</div>


          </div>
        </div>

        @include('admin.footer')
  </body>
</html>
