<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    @include('default_style')
</head>

<body class="bg-light">

<div class="main">
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center">
        <h1 class="mb-4 text-center">Orders Issued By District Collector / CCLA / Government </h1>


        @if($records->count() > 0)
            <!-- Task Table -->
            <div class="table-responsive w-100">
<table id="PostingTable" class="table table-bordered table-striped text-center bg-white shadow w-100" style="min-width: 1000px;">
                    <thead class="table-dark">
                        <tr>
                            <th>S.No</th>
                            <th>Order Type</th>
                            <th>Subject</th>
                            <th>Order Number</th>
                            <th>Order Date</th>
                            <th>Link</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $index => $order)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $order->order_type }}</td>
                                <td>{{ $order->subject }}</td>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                                <td> @if($order->link) <a href="{{ $order->link }}" target="_blank">View Document</a>
                                @else - @endif</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
    @include('default_script')

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {

            $('#PostingTable').DataTable().destroy(); // destroy previous instance if any
            $('#PostingTable').DataTable({
                paging: false,
                searching: true,
                ordering: true,
                scrollY: '500px', // Enable vertical scrolling
                scrollX: true, // Enable horizontal scrolling
                scrollCollapse: true, // Collapse the table when data is less
                fixedHeader: true,
            });
        });
        
        
    </script>
</body>

</html>