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
          <div class="container-fluid"></div>
        </div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <h2>Add Officer</h2>
              <form action="{{ url('new_officer') }}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="employee_no">Employee No</label>
                  <input type="number" class="form-control" id="employee_no" name="employee_no" required>
                </div>

                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                  <label for="phone">Phone</label>
                  <input type="number" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                  <label for="area">Assigned Area</label>
                  <input type="text" class="form-control" id="area" name="area" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Officer</button>
              </form>
            </div>
          </div>
        </div>
        @include('admin.footer')
  </body>
</html>
