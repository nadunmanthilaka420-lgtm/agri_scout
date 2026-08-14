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
            <section class="no-padding-top no-padding-bottom">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-md-12">
                    <div class="block">
                      <div class="block-header">
                        <h3 class="block-title">Crops</h3>
                      </div>
                      <div class="block-body">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Crop Name</th>
                              <th>Variety</th>
                              <th>Category</th>
                              <th>Planting Date</th>
                              <th>Expected Harvest Date</th>
                              <th>Current Stage</th>
                              <th>Estimated Yield</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($crops as $crop)
                              <tr>
                                <td>{{ $crop->crop_name }}</td>
                                <td>{{ $crop->variety }}</td>
                                <td>{{ $crop->category }}</td>
                                <td>{{ $crop->planting_date}}</td>
                                <td>{{ $crop->expected_harvest_date }}</td>
                                <td>{{ $crop->current_stage }}</td>
                                <td>{{ $crop->estimated_yield}}</td>
                                <td>{{ $crop->status }}</td>
                              </tr>
                            @endforeach
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
