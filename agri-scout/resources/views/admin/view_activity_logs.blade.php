<!DOCTYPE html>
<html>
  <head>
    @include('admin.css')

    <style>
        /* Activity Logs Block */
        .block {
            background: #ffffff;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        }

        /* Header */
        .block-header {
            padding-bottom: 15px;
            margin-bottom: 20px;
            border-bottom: 1px solid #eeeeee;
        }

        .block-title {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
            color: #333333;
        }

        /* Table */
        .block .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            background: #ffffff;
        }

        /* Table Header */
        .block .table thead th {
            background: #343a40;
            color: #ffffff;
            padding: 14px 12px;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
            border: none;
            white-space: nowrap;
        }

        /* Table Body */
        .block .table tbody td {
            padding: 13px 12px;
            color: #555555;
            font-size: 14px;
            border-bottom: 1px solid #eeeeee;
            vertical-align: middle;
        }

        /* Alternate rows */
        .block .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        /* Hover effect */
        .block .table tbody tr:hover {
            background-color: #eef6ff;
            transition: 0.2s ease;
        }

        /* Description column */
        .block .table tbody td:nth-child(5) {
            max-width: 300px;
            word-wrap: break-word;
            white-space: normal;
        }

        /* User Agent column */
        .block .table tbody td:nth-child(8) {
            max-width: 280px;
            word-wrap: break-word;
            white-space: normal;
        }

        /* First header corner */
        .block .table thead th:first-child {
            border-top-left-radius: 6px;
        }

        /* Last header corner */
        .block .table thead th:last-child {
            border-top-right-radius: 6px;
        }

        /* Responsive table */
        @media (max-width: 992px) {
            .block {
                overflow-x: auto;
            }

            .block .table {
                min-width: 1000px;
            }
        }

        /* Mobile */
        @media (max-width: 576px) {
            .block {
                padding: 15px;
            }

            .block-title {
                font-size: 18px;
            }
        }
    </style>


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
                    <h3 class="block-title">Activity Logs</h3>
                  </div>
                  <div class="block-body">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>User ID</th>
                          <th>User Role</th>
                          <th>Action</th>
                          <th>Module</th>
                          <th>Description</th>
                          <th>Record ID</th>
                          <th>IP Address</th>
                          <th>User Agent</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($activityLogs as $log)
                          <tr>
                            <td>{{ $log->user_id }}</td>
                            <td>{{ $log->user_role }}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{ $log->module }}</td>
                            <td>{{ $log->description }}</td>
                            <td>{{ $log->record_id }}</td>
                            <td>{{ $log->ip_address }}</td>
                            <td>{{ $log->user_agent }}</td>
                          </tr>
                        @endforeach
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
