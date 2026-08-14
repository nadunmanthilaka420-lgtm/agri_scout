<!DOCTYPE html>
<html>
  <head>
    @include('admin.css')
    <style>
      .crop-form-wrapper {
          max-width: 720px;
          margin: 30px auto;
          padding: 30px;
          background: #ffffff;
          border-radius: 16px;
          border: 1px solid #dce8dc;
          box-shadow: 0 10px 30px rgba(34, 90, 45, 0.12);
      }
      .crop-form-title h2 {
          color: #1b5e20;
          font-size: 26px;
          font-weight: 700;
          margin-bottom: 20px;
      }
      .form-group label {
          color: #2e5d34;
          font-size: 14px;
          font-weight: 600;
          margin-bottom: 6px;
          display: block;
      }
      .form-group input, .form-group select {
          width: 100%;
          height: 44px;
          padding: 0 15px;
          border: 1.5px solid #cfdccf;
          border-radius: 8px;
          background: #fafffa;
          color: #263238;
          font-size: 15px;
          outline: none;
      }
      .form-group input:focus, .form-group select:focus {
          border-color: #43a047;
          background: #ffffff;
          box-shadow: 0 0 0 4px rgba(67, 160, 71, 0.12);
      }
      .btn-submit-crop {
          width: 100%;
          height: 48px;
          border: none;
          border-radius: 8px;
          background: linear-gradient(135deg, #43a047, #1b5e20);
          color: white;
          font-size: 16px;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.3s ease;
      }
      .btn-submit-crop:hover {
          background: linear-gradient(135deg, #66bb6a, #2e7d32);
          transform: translateY(-2px);
      }
    </style>
  </head>
  <body>
    @include('admin.header')
    @include('admin.sidebar')
    
    <div class="page-content">
      <div class="page-header">
        <div class="container-fluid">
          
          <div class="crop-form-wrapper">
            <div class="crop-form-title">
              <h2>✏️ Edit Crop Specification</h2>
              <p class="text-muted">Update MongoDB crop document linked to Oracle Farm #{{ $crop->farm_id }}.</p>
            </div>

            @if (isset($errors) && $errors->any())
              <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            @if (session('error'))
              <div class="alert alert-danger mb-4">
                {{ session('error') }}
              </div>
            @endif

            <form action="{{ route('admin.crops.update', $crop->_id) }}" method="POST">
              @csrf
              @method('PUT')

              <!-- Oracle Farm Selection -->
              <div class="form-group mb-3">
                <label for="farm_id">Oracle Farm *</label>
                <select id="farm_id" name="farm_id" class="form-control" required>
                  <option value="">-- Select Oracle Farm --</option>
                  @foreach($farms as $farm)
                    <option value="{{ $farm->FARM_ID }}" {{ old('farm_id', $crop->farm_id) == $farm->FARM_ID ? 'selected' : '' }}>
                      {{ $farm->FARM_NAME ?? $farm->FARMNAME }} - {{ $farm->LOCATION }} (ID: {{ $farm->FARM_ID }})
                    </option>
                  @endforeach
                </select>
              </div>

              <!-- Crop Name -->
              <div class="form-group mb-3">
                <label for="crop_name">Crop Name *</label>
                <input type="text" id="crop_name" name="crop_name" value="{{ old('crop_name', $crop->crop_name) }}" required>
              </div>

              <div class="row">
                <!-- Variety -->
                <div class="col-md-6 form-group mb-3">
                  <label for="variety">Variety</label>
                  <input type="text" id="variety" name="variety" value="{{ old('variety', $crop->variety) }}">
                </div>
                <!-- Category -->
                <div class="col-md-6 form-group mb-3">
                  <label for="category">Category</label>
                  <select id="category" name="category">
                    <option value="Fruit" {{ old('category', $crop->category) == 'Fruit' ? 'selected' : '' }}>Fruit</option>
                    <option value="Vegetable" {{ old('category', $crop->category) == 'Vegetable' ? 'selected' : '' }}>Vegetable</option>
                    <option value="Grain" {{ old('category', $crop->category) == 'Grain' ? 'selected' : '' }}>Grain</option>
                    <option value="Other" {{ old('category', $crop->category) == 'Other' ? 'selected' : '' }}>Other</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <!-- Planting Date -->
                <div class="col-md-6 form-group mb-3">
                  <label for="planting_date">Planting Date</label>
                  <input type="date" id="planting_date" name="planting_date" value="{{ old('planting_date', $crop->planting_date) }}">
                </div>
                <!-- Expected Harvest Date -->
                <div class="col-md-6 form-group mb-3">
                  <label for="expected_harvest_date">Expected Harvest Date</label>
                  <input type="date" id="expected_harvest_date" name="expected_harvest_date" value="{{ old('expected_harvest_date', $crop->expected_harvest_date) }}">
                </div>
              </div>

              <div class="row">
                <!-- Current Stage -->
                <div class="col-md-6 form-group mb-3">
                  <label for="current_stage">Current Stage</label>
                  <select id="current_stage" name="current_stage">
                    <option value="PLANNED" {{ old('current_stage', $crop->current_stage) == 'PLANNED' ? 'selected' : '' }}>PLANNED</option>
                    <option value="GROWING" {{ old('current_stage', $crop->current_stage) == 'GROWING' ? 'selected' : '' }}>GROWING</option>
                    <option value="HARVESTED" {{ old('current_stage', $crop->current_stage) == 'HARVESTED' ? 'selected' : '' }}>HARVESTED</option>
                    <option value="CANCELLED" {{ old('current_stage', $crop->current_stage) == 'CANCELLED' ? 'selected' : '' }}>CANCELLED</option>
                  </select>
                </div>
                <!-- Status -->
                <div class="col-md-6 form-group mb-3">
                  <label for="status">Status *</label>
                  <select id="status" name="status" required>
                    <option value="GROWING" {{ old('status', $crop->status) == 'GROWING' ? 'selected' : '' }}>GROWING</option>
                    <option value="PLANNED" {{ old('status', $crop->status) == 'PLANNED' ? 'selected' : '' }}>PLANNED</option>
                    <option value="HARVESTED" {{ old('status', $crop->status) == 'HARVESTED' ? 'selected' : '' }}>HARVESTED</option>
                    <option value="CANCELLED" {{ old('status', $crop->status) == 'CANCELLED' ? 'selected' : '' }}>CANCELLED</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <!-- Area (Acres) -->
                <div class="col-md-4 form-group mb-3">
                  <label for="area_acres">Area (Acres)</label>
                  <input type="number" step="0.01" id="area_acres" name="area_acres" value="{{ old('area_acres', $crop->area_acres) }}">
                </div>
                <!-- Estimated Yield -->
                <div class="col-md-4 form-group mb-3">
                  <label for="estimated_yield">Estimated Yield</label>
                  <input type="number" step="0.01" id="estimated_yield" name="estimated_yield" value="{{ old('estimated_yield', $crop->estimated_yield) }}">
                </div>
                <!-- Yield Unit -->
                <div class="col-md-4 form-group mb-3">
                  <label for="yield_unit">Yield Unit</label>
                  <input type="text" id="yield_unit" name="yield_unit" value="{{ old('yield_unit', $crop->yield_unit) }}">
                </div>
              </div>

              <div class="mt-4 d-flex justify-content-between gap-2">
                <a href="{{ route('admin.crops.index') }}" class="btn btn-secondary px-4 py-2">Cancel</a>
                <button type="submit" class="btn-submit-crop style-override">
                  💾 Update Crop Document
                </button>
              </div>

            </form>
          </div>

        </div>
      </div>
    </div>

    @include('admin.footer')
  </body>
</html>
