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
            <h2 class="h5 no-margin-bottom">Visit Reports</h2>
            <div class="row mt-3">
              <div class="col-lg-12">
                <div class="table-responsive">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Visit ID</th>
                        <th>Farm ID</th>
                        <th>Officer ID</th>
                        <th>Report Date</th>
                        <th>Weather Conditions</th>
                        <th>Crop Condition</th>
                        <th>Soil Condition</th>
                        <th>Irrigation Status</th>
                        <th>Fertilizer Applied</th>
                        <th>Pest Detected</th>
                        <th>Remarks</th>
                        <th>Recommendations</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($visitReports as $report)
                        <tr>
                          <td>{{ $report->visit_id ?? 'N/A' }}</td>
                          <td>{{ $report->farm_id ?? 'N/A' }}</td>
                          <td>{{ $report->officer_id ?? 'N/A' }}</td>
                          <td>{{ $report->report_date ?? ($report->reported_date ?? 'N/A') }}</td>
                          <td>
                            @if(is_array($report->weather))
                              {{ $report->weather['condition'] ?? implode(', ', array_filter(array_map(fn($k, $v) => is_scalar($v) ? "$k: $v" : null, array_keys($report->weather), $report->weather))) }}
                            @else
                              {{ $report->weather ?? 'N/A' }}
                            @endif
                          </td>
                          <td>
                            @if(is_array($report->crop_condition))
                              {{ implode(', ', $report->crop_condition) }}
                            @else
                              {{ $report->crop_condition ?? 'N/A' }}
                            @endif
                          </td>
                          <td>
                            @if(is_array($report->soil_condition))
                              {{ implode(', ', $report->soil_condition) }}
                            @else
                              {{ $report->soil_condition ?? 'N/A' }}
                            @endif
                          </td>
                          <td>
                            @if(is_array($report->irrigation_status))
                              {{ implode(', ', $report->irrigation_status) }}
                            @else
                              {{ $report->irrigation_status ?? 'N/A' }}
                            @endif
                          </td>
                          <td>
                            @if(is_bool($report->fertilizer_applied) || is_numeric($report->fertilizer_applied))
                              {{ $report->fertilizer_applied ? 'Yes' : 'No' }}
                            @elseif(is_array($report->fertilizer_applied))
                              {{ implode(', ', $report->fertilizer_applied) }}
                            @else
                              {{ $report->fertilizer_applied ?? 'N/A' }}
                            @endif
                          </td>
                          <td>
                            @if(is_bool($report->pest_detected) || is_numeric($report->pest_detected))
                              {{ $report->pest_detected ? 'Yes' : 'No' }}
                            @elseif(is_array($report->pest_detected))
                              {{ implode(', ', $report->pest_detected) }}
                            @else
                              {{ $report->pest_detected ?? 'N/A' }}
                            @endif
                          </td>
                          <td>
                            @if(is_array($report->remarks))
                              {{ implode(', ', $report->remarks) }}
                            @else
                              {{ $report->remarks ?? 'N/A' }}
                            @endif
                          </td>
                          <td>
                            @if(is_array($report->recommendations))
                              {{ implode(', ', $report->recommendations) }}
                            @else
                              {{ $report->recommendations ?? 'N/A' }}
                            @endif
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="12" class="text-center text-muted py-4">No visit reports recorded.</td>
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
