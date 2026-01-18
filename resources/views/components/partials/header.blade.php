<div class="header mb-3 d-flex justify-content-between align-items-center px-3">
    <!-- Back Button -->
    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>

    <!-- Title -->
    <h5 class="fw-bold text-center m-0">Revenue Employees Management, Sangareddy</h5>

    <!-- Dropdowns -->
    <div class="d-flex gap-3">

        <!-- Employee Management -->
        <div class="dropdown">
            <button class="btn dropdown-toggle rounded-pill px-4 py-2 border-0 text-white" type="button" data-bs-toggle="dropdown" style="background-color: #2c3e50;">
                <i class="fas fa-users me-1"></i> Employee Management
            </button>
            <ul class="dropdown-menu shadow-lg">
                <li><a class="dropdown-item" href="{{ route('allemployees') }}">Employee Data</a></li>
                <li><a class="dropdown-item" href="{{ route('new.employee') }}">Employee Data Entry</a></li>
                <li><a class="dropdown-item" href="{{ route('posting.index') }}">Posting</a></li>
                <li><a class="dropdown-item" href="{{ route('working-periods.index') }}">Working Periods</a></li>
            </ul>
        </div>

        <!-- File Management -->
        <div class="dropdown">
            <button class="btn dropdown-toggle rounded-pill px-4 py-2 border-0 text-white" type="button" data-bs-toggle="dropdown" style="background-color: #2c3e50;">
                <i class="fas fa-folder me-1"></i> File Management
            </button>
            <ul class="dropdown-menu shadow-lg">
                <li><a class="dropdown-item" href="{{ route('file.index') }}">File Inventory</a></li>
                <li><a class="dropdown-item" href="{{ route('tracking.index') }}">File Tracking</a></li>
            </ul>
        </div>

        <!-- Task Management -->
        <div class="dropdown">
            <button class="btn dropdown-toggle rounded-pill px-4 py-2 border-0 text-white" type="button" data-bs-toggle="dropdown" style="background-color: #2c3e50;">
                <i class="fas fa-tasks me-1"></i> Task Management
            </button>
            <ul class="dropdown-menu shadow-lg">
                <li><a class="dropdown-item" href="{{ route('task.index') }}">Task Management</a></li>
            </ul>
        </div>

        <!-- User -->
        <div class="dropdown">
            <button class="btn dropdown-toggle rounded-pill px-4 py-2 border-0 text-white" type="button" data-bs-toggle="dropdown" style="background-color: #2c3e50;">
                <i class="fas fa-user me-1"></i> User
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg">
                <li><span class="dropdown-item disabled text-primary fw-bold">{{ Auth::user()->name }}</span></li>
                <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-1"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</div>


<style>
    .dropdown-menu {
        background-color: #2c3e50 !important;
        border: none;
    }

    .dropdown-item {
        color: #fff !important;
    }

    .dropdown-item:hover {
        background-color: #1a252f !important;
        color: #fff !important;
    }

    .dropdown:hover .dropdown-menu {
        display: block !important;
    }

    .dropdown-toggle::after {
        display: none; /* Optional: hides the default dropdown arrow */
    }
</style>
