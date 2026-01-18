<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    @include('default_style')
</head>

<body class="bg-light">
    <!-- Home Button -->
    @include('headernav')

<div class="main">
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center">
    <a href="{{ route('order_tracking.index') }}" target="_blank" class="btn btn-primary">Orders List</a>    
    <h1 class="mb-4 text-center">Orders Issued By District Collector / CCLA / Government </h1>
        
        @if(session()->has('success'))
            <div class="alert alert-success mt-3">
                {{ session()->get('success') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-success mt-3">
                {{ session()->get('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Task Form -->
        <div class="card shadow p-4 mb-4" style="width: 100%; max-width: 1300px;">
            <form action="{{ route('order_tracking.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="department" class="form-label">Department</label>
                        <select class="form-select" id="department" name="department">
                            <option value="">Select</option>
                            <option value="Revenue">Revenue</option>
                            <option value="Irrigation">Irrigation</option>
                            <option value="Networking">Networking</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="order_type" class="form-label">Order Type</label>
                        <select class="form-select" id="order_type" name="order_type">
                            <option value="">Select</option>
                            <option value="Annual Grade Increment">Annual Grade Increment</option>
                            <option value="Leave">Leave</option>
                            <option value="Surrender Leave">Surrender Leave</option>
                            <option value="Promotion">Promotion</option>
                            <option value="Transfer and Posting">Transfer and Posting</option>
                            <option value="Fulla Additional Charge">Full Additional Charge</option>
                            <option value="Special Grade Post Scale">Special Grade Post Scale</option>
                            <option value="Waiting Period">Waiting Period</option>
                            <option value="Deputation">Deputation</option>
                            <option value="Show Cause Notice">Show Cause Notice</option>
                            <option value="Memo">Memo</option>
                            <option value="Article of Charges">Article of Charges</option>
                            <option value="Suspension">Suspension</option>
                            <option value="Reinstatement">Reinstatement</option>
                            <option value="Individual Application">Individual Application</option>
                            <option value="Inquiry Report">Inquiry Report</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="subject" class="form-label">Subject</label>
                        <textarea class="form-control" rows="2" name="subject" placeholder="subject"
                        required></textarea>
                    </div>
                    <div class="col-md-4">
                        <label for="order_number" class="Form-label">Order Number</label>
                        <input type="text" class="form-control" name="order_number" placeholder="Order_number" required>
                    </div>
                    <div class="col-md-4">
                        <label for="order_date" class="Form-label">Order Date</label>
                        <input type="date" class="form-control" name="order_date" placeholder="Order_date" required>
                    </div>

                    <div class="col-md-4">
                        <label for="link" class="form-label"> Upload GO</label>
                        <input type="file" class="form-control" name="link" id="link" accept="application/pdf">
                    </div>
                    
                </div>
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary mt-3 w-50">Submit</button>
                </div>
            </form>
        </div>

        
    </div>
</div>
    @include('default_script')
</body>

</html>