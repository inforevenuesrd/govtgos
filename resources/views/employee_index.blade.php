<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Employee</title>

  <!-- Bootstrap + DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.7/css/responsive.bootstrap5.css">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <style>
    #suggestions li:hover {
      cursor: pointer;
      background-color: #f8f9fa;
    }

    /* Style the + toggle icon */
    table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control:before {
      background-color: #0d6efd;
      color: white;
      border: none;
      font-weight: bold;
      box-shadow: none;
    }

    /* Optional: make table fit small screens nicely */
    .dataTables_wrapper .dataTables_filter {
      float: right;
      text-align: right;
    }
    .dataTables_wrapper .dataTables_length {
      float: left;
    }
  </style>
</head>

<body class="bg-light">
  @include('employee_headernav')

  <div class="main">
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center">
      <h2 class="mb-4 text-center">Employee Dashboard</h2>

        <div class="row mb-4">
            <!-- Employee Details Card -->
            <div class="col-lg-4 col-md-5 mb-3">
                <div class="card shadow h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Employee Details</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Employee Id:</strong> {{ $user->employee_id }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Department:</strong> {{ $user->department }}</p>
                        <p><strong>Designation:</strong> {{ $user->designation ?? 'N/A' }}</p>
                        <p><strong>Mobile:</strong> {{ $user->mobile ?? 'N/A' }}</p>
                        <p><strong>Working Place:</strong> {{ $user->working_place ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        
            <!-- Leaves Summary Card -->
            <div class="col-lg-8 col-md-7 mb-3">
                <div class="card shadow h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Leave Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 text-center">
                            {{-- Casual Leaves --}}
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="p-3 border rounded">
                                    <h4 class="text-success">
                                        {{ $currentYearSummary['sanctionedByType']['casual'] ?? 0 }} / {{ $casualQuota }}
                                    </h4>
                                    <p class="mb-0">Casual Leaves</p>
                                </div>
                            </div>
        
                            {{-- Remaining Casual Leaves --}}
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="p-3 border rounded">
                                    <h4 class="text-warning">{{ $remainingLeaves }}</h4>
                                    <p class="mb-0">Remaining Casual ({{ $yearlyQuota }})</p>
                                </div>
                            </div>
        
                            {{-- Optional Leaves --}}
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="p-3 border rounded">
                                    <h4 class="text-info">
                                        {{ $currentYearSummary['sanctionedByType']['optional'] ?? 0 }} / {{ $optionalQuota }}
                                    </h4>
                                    <p class="mb-0">Optional Leaves</p>
                                </div>
                            </div>
        
                            {{-- Remaining Optional Leaves --}}
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="p-3 border rounded">
                                    <h4 class="text-warning">{{ $remainingOptionalLeaves }}</h4>
                                    <p class="mb-0">Remaining Optional ({{ $optionalQuota }})</p>
                                </div>
                            </div>
                            
                            {{-- Half Pay Leaves --}}
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="p-3 border rounded">
                                    <h4 class="text-warning">
                                        {{ $currentYearSummary['halfDayCount'] }}
                                    </h4>
                                    <p class="mb-0">Approved Half-Day Leaves</p>
                                </div>
                            </div>
        
                            {{-- Rejected Leaves --}}
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="p-3 border rounded">
                                    <h4 class="text-danger">{{ $currentYearSummary['rejectedLeaves'] }}</h4>
                                    <p class="mb-0">Rejected Leaves</p>
                                </div>
                            </div>
        
                            {{-- Total Leaves Taken --}}
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="p-3 border rounded">
                                    <h4 class="text-primary">{{ $currentYearSummary['totalLeaves'] }}</h4>
                                    <p class="mb-0">Total Leaves Taken</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Apply Leave Button -->
        <div class="text-center mb-4">
            <a href="{{ route('leave_permission.index') }}" class="btn btn-primary btn-lg">
              Apply Leave
            </a>
          
            <a href="{{ route('employee.leave.index') }}" class="btn btn-primary btn-lg">
              Leave Requests
            </a>
          
            @if(auth()->user()->role == '8')
              <a href="{{ route('admin_today.leave.index') }}" class="btn btn-primary btn-lg">
                  Today Leaves
              </a>

              <div class="mt-3 position-relative" style="max-width: 400px;">
                  <input type="text" id="employeeSearch" class="form-control" placeholder="Search Employee">
                  
                  <!-- Suggestions dropdown -->
                  <ul id="suggestions" class="list-group position-absolute w-100" 
                      style="z-index: 1000; display:none; max-height: 200px; overflow-y:auto;"></ul>

                  <input type="hidden" id="employeeId">
                  <button id="searchBtn" class="btn btn-success mt-2">Search</button>
              </div>
            @endif
        </div>

      <!-- Leave Requests -->
      <div class="card shadow w-100">
        <div class="card-header bg-dark text-white">
          <h5 class="mb-0">Your Leave Requests</h5>
        </div>
        <div class="card-body">
          <!-- ✅ wrap table in responsive container -->
          <div class="table-responsive">
            <table id="PostingTable" class="table table-bordered table-striped nowrap" style="width:100%">
              <thead class="table-dark">
                <tr>
                  <th></th> <!-- Placeholder for + icon -->
                  <th>S.No</th>
                  <th>Leave Type</th>
                  <th>From Date</th>
                  <th>To Date</th>
                  <th>No. of Days</th>
                  <th>Present With</th>
                  <th>Remarks</th>
                  <th>Status</th>
                  <th>Applied On</th>
                </tr>
              </thead>
              <tbody>
                @if($leaveRequests->count())
                  @forelse ($leaveRequests as $key => $leave)
                    @php
                      $transaction = App\Models\LeaveRequestTransaction::where('leave_request_id', $leave->id)->latest()->first();
                      $leaveType = null;
                      if ($leave->leave_type_breakdown) {
                          $breakdown = json_decode($leave->leave_type_breakdown, true);
                          $counts = array_count_values($breakdown);
                          $formatted = [];
                          foreach ($counts as $type => $count) {
                              $formatted[] = ucfirst(str_replace('_', ' ', $type)) . " ({$count})";
                          }
                          $leaveType = implode(', ', $formatted);
                      } else {
                          $leaveType = ucfirst($leave->leave_type) ?: '-';
                      }
                    @endphp
                    <tr>
                      <td class="dtr-control"></td>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $leaveType ?? '-' }}</td>
                      <td>{{ \Carbon\Carbon::parse($leave->from_date)->format('d-m-y') }}</td>
                      <td>{{ \Carbon\Carbon::parse($leave->to_date)->format('d-m-y') }}</td>
                      <td>{{ $leave->leave_days }}</td>
                      <td>
                        @php
                          $forwardedToUser = $transaction ? App\Models\User::find($transaction->forwarded_to) : null;
                        @endphp
                        {{ $forwardedToUser ? 
                          $forwardedToUser->name . ' (' . 
                          $forwardedToUser->designation . ', ' . 
                          $forwardedToUser->department . ', ' . 
                          $forwardedToUser->working_place . ')' 
                          : '-' 
                        }}
                      </td>
                      <td>{{ $transaction ? $transaction->remarks : '' }}</td>
                      <td>
                        @php
                          $approvedDates = is_array($leave->approved_dates)
                              ? $leave->approved_dates
                              : json_decode($leave->approved_dates, true);
                          if (is_string($approvedDates)) {
                              $approvedDates = [$approvedDates];
                          }
                        @endphp
                        @if ($leave->leave_status == 'approved')
                          <span class="badge bg-success">Accepted</span>
                          @if($approvedDates)
                            {{ implode(', ', $approvedDates) }}
                          @endif
                        @elseif ($leave->leave_status == 'rejected')
                          <span class="badge bg-danger">Rejected</span>
                        @else
                          <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                      </td>
                      <td>{{ $leave->created_at->format('d-m-Y') }}</td>
                    </tr>
                  @empty
                  <tr>
                    <td colspan="10" class="text-center">No leave requests found.</td>
                  </tr>
                  @endforelse
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

  <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/responsive/3.0.7/js/dataTables.responsive.js"></script>
  <script src="https://cdn.datatables.net/responsive/3.0.7/js/responsive.bootstrap5.js"></script>

  <script>
    $(document).ready(function () {
      $('#PostingTable').DataTable({
        responsive: {
          details: {
            type: 'column',
            target: 0 // column index for + icon
          }
        },
        columnDefs: [
          { className: 'dtr-control', orderable: false, targets: 0 },
          { responsivePriority: 1, targets: 1 }, // S.No
          { responsivePriority: 2, targets: 2 }, // Leave Type
          { responsivePriority: 3, targets: 3 }, // From Date
          { responsivePriority: 4, targets: 4 }, // To Date
          // Hide these first
          { responsivePriority: 10001, targets: 5 },
          { responsivePriority: 10002, targets: 6 },
          { responsivePriority: 10003, targets: 7 },
          { responsivePriority: 10004, targets: 8 },
          { responsivePriority: 10005, targets: 9 },
        ],
        order: [[9, 'desc']],
        pageLength: 10,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search leave..."
        }
      });
    });
    const users = @json($users); // All users from controller
    const searchInput = document.getElementById('employeeSearch');
    const hiddenInput = document.getElementById('employeeId');
    const suggestions = document.getElementById('suggestions');
    const searchBtn = document.getElementById('searchBtn');
  if(searchInput){

  
    // Create simple autocomplete
    searchInput.addEventListener('input', function () {
        let val = this.value.toLowerCase();
        suggestions.innerHTML = '';

        if (val.length === 0) {
            suggestions.style.display = 'none';
            hiddenInput.value = '';
            return;
        }

        let filtered = users.filter(u => u.name.toLowerCase().includes(val));

        if (filtered.length > 0) {
            suggestions.style.display = 'block';
            filtered.forEach(u => {
                let li = document.createElement('li');
                li.classList.add('list-group-item', 'list-group-item-action');
                li.textContent = `${u.name} - ${u.department ?? ''} - ${u.designation ?? ''}`;
                li.dataset.id = u.id;
                li.dataset.name = u.name; // keep only name for search input

                li.addEventListener('click', function () {
                    searchInput.value = this.dataset.name; // only fill employee name
                    hiddenInput.value = this.dataset.id;
                    suggestions.style.display = 'none';
                });

                suggestions.appendChild(li);
            });
        } else {
            suggestions.style.display = 'none';
            hiddenInput.value = '';
        }
    });

    // Redirect on search click
    searchBtn.addEventListener('click', function () {
        const id = hiddenInput.value;
        if (id) {
            window.location.href = "{{ route('leave.details', ':id') }}".replace(':id', id);
        } else {
            alert('Please select a valid employee name.');
        }
    });

    document.addEventListener('click', function (e) {
        if (!searchInput.contains(e.target) && !suggestions.contains(e.target)) {
            suggestions.style.display = 'none';
        }
    });
  
  }

  </script>
</body>
</html>
