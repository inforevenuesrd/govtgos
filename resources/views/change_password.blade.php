<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <link rel="stylesheet" href="{{ asset('css/task.css') }}"> -->
    @include('default_style')

    
</head>
<body>
    @include('headernav')

    <div class="main">
        <div class="container-fluid d-flex flex-column justify-content-center align-items-center">
            <h1 class="mb-4 text-center">Change Password</h1>
            
            <div class="card shadow p-4 mb-4">
                <form action="{{ route('password.change.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control" name="name" placeholder="User Name" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Old Password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="new_password" placeholder="Enter New Password" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="new_password_confirmation" placeholder="Re-enter New Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>

    @include('default_script')

</body>
</html>
