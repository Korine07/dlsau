@extends('completed.layout')

@section('content')
<!-- Completed Reservations Header -->
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h4 class="text-dark">Completed Reservations</h4>
            <div class="d-flex align-items-center">
                <!-- Search Bar -->
                <div class="input-group">
                    <input type="text" id="searchPending" class="form-control form-control-sm" placeholder="Search reservations...">
                    <span class="input-group-text text-primary"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>

    <hr style="border: 1px solid blue;">

    <!-- Flash Message for Success -->
    @if (session('success'))
        <div id="flash-message" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Completed Reservations Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="custom-table-container">
                <table id="completedTable" class="table table-striped table-hover text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Venue</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Service</th>
                            <th>Member</th>
                            <th>Activity</th>
                            <th>Balance</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($completedReservations as $reservation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $reservation->created_at->format('Y-m-d') }}</td>
                            <td>{{ $reservation->first_name }} {{ $reservation->last_name }}</td>
                            <td>{{ $reservation->email }}</td>
                            <td>{{ $reservation->phone }}</td>
                            <td>{{ $reservation->venue->venue_name }}</td>
                            <td>{{ $reservation->check_in_date }} {{ $reservation->check_in_time }}</td>
                            <td>{{ $reservation->check_out_date }} {{ $reservation->check_out_time }}</td>
                            <td>
                                @if($reservation->services->isNotEmpty())
                                    @foreach($reservation->services as $service)
                                        {{ $service->name }} (Hrs: {{ $service->pivot->quantity }})<br>
                                    @endforeach
                                @else
                                    None
                                @endif
                            </td>
                            <td>{{ ucfirst($reservation->memtyp) }}</td>
                            <td>
                                <span class="activity-tooltip" data-bs-toggle="tooltip" data-bs-placement="top" 
                                    title="{{ $reservation->activity_nature ?? 'Not specified' }}">
                                    {{ Str::limit($reservation->activity_nature ?? 'Not specified', 16, '...') }}
                                </span>
                            </td>
                            <td>₱{{ number_format($reservation->total_price, 2) }}</td>
                            <td>
                                <span class="badge status-badge {{ strtolower($reservation->status) }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td> 
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-cog"></i> <!-- Gear Icon -->
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <form action="{{ route('reservations.send-completed-email', ['id' => $reservation->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-primary">
                                                    <i class="fa fa-envelope"></i> Send Email
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-info" href="{{ route('receipt.view', ['id' => $reservation->id]) }}" target="_blank">
                                                <i class="fa fa-file-text"></i> Receipt
                                            </a>
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('reservations.archive', $reservation->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="dropdown-item text-warning" onclick="return confirm('Are you sure you want to archive this reservation?')">
                                                    <i class="fa fa-archive"></i> Archive
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

            <!-- Custom Page Length Control & Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-2">
                <!-- Left: Rows Per Page Dropdown -->
                <div class="d-flex align-items-center">
                    <label for="custom-page-length" class="me-2 mb-0 text-gray">Rows per page:</label>
                    <select id="custom-page-length" class="form-select form-select-sm" style="width: auto;">
                        <option value="15" selected>15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <!-- Pagination: Moved Below -->
                <div id="custom-pagination" class="d-flex align-items-center">
                    <span id="custom-page-info" class="text-gray me-2"></span>
                    <button id="prev-page" class="btn btn-light btn-sm me-1" disabled>❮</button>
                    <button id="next-page" class="btn btn-light btn-sm ms">❯</button>
                </div>
            </div>

</div>
<script>
    $(document).ready(function() {
        let table = $('#completedTable').DataTable({
            "paging": true,         // Enable pagination
            "searching": true,      // Enable searching but hide the default search bar
            "ordering": true,       // Enable sorting
            "info": true,           // Show "Showing X to Y of Z entries"
            "lengthMenu": [15, 25, 50], // Page length options
            "pageLength": 15,       // Default rows per page
            "order": [[0, "asc"]], // Default sorting by Date (column index 0)

            // Disable sorting for the Action column (last column)
            "columnDefs": [{ "orderable": false, "targets": [13] }],

            // ✅ Hide the default search bar and move pagination controls outside
            "dom": "t" // Only show the table (without built-in pagination controls)
        });

        // ✅ Custom Page Length Selector
        $('#custom-page-length').on('change', function() {
            let newLength = $(this).val();
            table.page.len(newLength).draw();
            updatePagination();
        });

        // ✅ Custom Pagination Controls
        function updatePagination() {
            let pageInfo = table.page.info();
            $('#custom-page-info').text(`Showing ${pageInfo.start + 1} to ${pageInfo.end} of ${pageInfo.recordsTotal}`);

            $('#prev-page').prop('disabled', pageInfo.page === 0);
            $('#next-page').prop('disabled', pageInfo.page >= pageInfo.pages - 1);
        }

        $('#prev-page').on('click', function() {
            table.page('previous').draw('page');
            updatePagination();
        });

        $('#next-page').on('click', function() {
            table.page('next').draw('page');
            updatePagination();
        });

        // ✅ Bind the custom search bar to DataTables search function
        $('#searchPending').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Initialize pagination info
        updatePagination();
    });
    //activity
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
<style>
.container {
    max-width: 95% !important; /* Adjust width to 95% of the viewport */
    width: 100%;
}
.table-responsive {
    overflow-x: auto;
    overflow-y: auto; /* Enables vertical scrolling */
    width: 100%;
    max-height: 650px; /* Set the maximum height */
}
.status-badge.completed {
    background-color: #007BFF !important; /* Green */
    color: #fff !important;
}
.custom-table-container {
    max-height: 500px; 
    overflow-y: auto; 
    overflow-x: auto; 
    position: relative;
}
#completedTable thead {
    position: sticky;
    top: 0;
    background: #f8f9fa; /* Light gray background */
    z-index: 101; /* Keep headers above table content */
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Adds slight shadow */
}
#completedTable thead th {
    position: sticky;
    top: 0;
    background: #ffffff; /* White background */
    z-index: 102; /* Ensure it stays above other elements */
    border-bottom: 2px solid #ddd;
}
/* Style the action dropdown button */
.btn-sm.dropdown-toggle {
    background: transparent;
    border: none;
    padding: 4px 8px;
    font-size: 16px;
}

/* Remove outline when clicked */
.btn-sm.dropdown-toggle:focus {
    box-shadow: none;
}

/* Style the dropdown menu */
.dropdown-menu {
    position: absolute !important;
    will-change: transform;
    z-index: 1050;
}

/* Style dropdown items */
.dropdown-item {
    display: flex;
    align-items: center;
    gap: 8px; /* Space between icon and text */
    padding: 8px 12px;
    transition: background 0.3s ease-in-out;
}

/* Hover effect */
.dropdown-item:hover {
    background: rgba(40, 167, 69, 0.2); /* Light green hover effect */
    color: #28a745;
}
.table-responsive {
    overflow: visible !important;
}

</style>
@endsection
