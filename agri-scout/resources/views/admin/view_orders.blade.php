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

                <section class="no-padding-top no-padding-bottom">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="block">
                    <div class="block-header">
                      <h3 class="block-title">Orders</h3>
                    </div>
                    <div class="block-body">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Order ID</th>
                            <th>Customer ID</th>
                            <th>Farm ID</th>
                            <th>Crop Name</th>

                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                            <th>Order Date</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($orders as $order)
                            <tr>
                              <td>{{ $order->ORDER_ID }}</td>
                              <td>{{ $order->CUSTOMER_ID }}</td>
                              <td>{{ $order->FARM_ID }}</td>
                              <td>{{ $order->CROP_NAME }}</td>

                              <td>{{ $order->QUANTITY }}</td>
                              <td>{{ $order->UNIT }}</td>
                              <td>{{ $order->UNIT_PRICE }}</td>
                              <td>{{ $order->TOTAL_AMOUNT }}</td>
                              <td>{{ $order->ORDER_DATE }}</td>
                              <td>{{ $order->STATUS }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          </div>
          </div>

        @include('admin.footer')
  </body>
</html>
