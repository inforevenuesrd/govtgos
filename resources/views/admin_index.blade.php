<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>District Collector</title>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

    @include('default_style')


</head>


<body class="bg-light">
    @include('employee_headernav')
    <!-- Home Button -->
<div class="main">
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center">
        <h2 class="mb-4 text-center">District Collector Dashboard</h2>
        
    
        <!-- Apply Leave Button -->
        <div class="text-center mb-4">
            <a href="{{ route('admin_today.leave.index') }}" class="btn btn-primary btn-lg">
                Today Leaves
            </a>
            
            <a href="{{ route('employee.leave.index') }}" class="btn btn-primary btn-lg">
                Check Leave Requests
            </a>
            
            <a href="{{ route('collector_peshi.index') }}" class="btn btn-primary btn-lg">
                Collector Peshi File Tracking
            </a>
            
            <a href="{{ route('submit_employee_leave.index') }}" class="btn btn-primary btn-lg">
                Submit Employee Leave
            </a>

            <a href="{{ route('employees.leaves') }}" class="btn btn-primary btn-lg">
                Employees Leaves
            </a>
            
        </div>

        <div class="mt-3" style="max-width: 600px;">
            <div class="input-group">
                <input type="text" id="employeeSearch" class="form-control col-9" placeholder="Search Employee">
                <button id="searchBtn" class="btn btn-success col-3">Search</button>
            </div>

            <ul id="suggestions" class="list-group position-absolute w-100"
                style="z-index: 1000; display:none; max-height: 200px; overflow-y:auto;"></ul>

            <input type="hidden" id="employeeId">
        </div>
        <div class="container">
            <div class="row mt-4 gx-3">
                
                <div class="col-md-3 col-6 mb-3">
                    <a href="{{ route('employees.index', ['status' => 'approved']) }}" class="text-decoration-none">
                        <div class="card text-white bg-success p-2">
                            <div class="card-body p-2 text-center">
                                <h6 class="card-title mb-1">Accepted Leaves</h6>
                                <p class="card-text fs-5 fw-bold mb-0">{{ $acceptedLeavesCount }}</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-6 mb-3">
                    <a href="{{ route('employees.index', ['status' => 'rejected']) }}" class="text-decoration-none">
                        <div class="card text-white bg-danger p-2">
                            <div class="card-body p-2 text-center">
                                <h6 class="card-title mb-1">Rejected Leaves</h6>
                                <p class="card-text fs-5 fw-bold mb-0">{{ $rejectedLeavesCount }}</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-6 mb-3">
                    <a href="{{ route('employees.index', ['status' => 'pending']) }}" class="text-decoration-none">
                        <div class="card text-white bg-warning p-2">
                            <div class="card-body p-2 text-center">
                                <h6 class="card-title mb-1">Pending Leaves</h6>
                                <p class="card-text fs-5 fw-bold mb-0">{{ $pendingLeavesCount }}</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 col-6 mb-3">
                    <a href="{{ route('employees.index') }}" class="text-decoration-none">
                        <div class="card text-white bg-info p-2">
                            <div class="card-body p-2 text-center">
                                <h6 class="card-title mb-1">Total Leaves</h6>
                                <p class="card-text fs-5 fw-bold mb-0">{{ $totalLeavesCount }}</p>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>

@php
$users = App\Models\User::all();
@endphp
    @include('default_script')

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const users = @json($users); // All users from controller
        const searchInput = document.getElementById('employeeSearch');
        const hiddenInput = document.getElementById('employeeId');
        const suggestions = document.getElementById('suggestions');
        const searchBtn = document.getElementById('searchBtn');

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
    </script>
    
</body>

</html>