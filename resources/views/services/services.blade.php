@extends('services.layout')
@section('content')

<!-- Add New Service Modal -->
<div class="modal fade" id="addNewServiceModal" tabindex="-1" aria-labelledby="addNewServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('services') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="mb-3">
                        <label for="name" class="form-label">Service Name</label>
                        <input type="text" name="name" id="name" class="form-control" maxlength="32" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <div class="input-group">
                            <span class="input-group-text">₱</span>
                            <input type="text" name="price" id="price" class="form-control" oninput="formatPrice(this)" required>
                            <div id="price-error" class="alert alert-danger" style="display:none;">
                                Price cannot be 0.00. Please enter a valid price.
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Services List -->
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h4 class="text-dark">Services List</h4>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewServiceModal">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add New
                </button>
                <!-- Search Bar -->
                <div class="input-group ms-3" style="width: 170px;">
                    <input type="text" id="searchPending" class="form-control form-control-sm" placeholder="Search reservations...">
                    <span class="input-group-text text-primary"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>

    <hr style="border: 1px solid green;">

    <!-- Flash Message for Success -->
    @if (session('success'))
        <div id="flash-message" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="custom-table-container">
                <table id="serviceTable" class="table table-striped table-hover text-center">
                    <thead class="table-light">
                        <tr>
                            <th class="table-column-number">#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th class="table-column-action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>₱{{ number_format($item->price, 2) }}</td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                </button>

                                <!-- Delete Button -->
                                <form method="POST" action="{{ url('/services/' . $item->id) }}" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirm delete?')">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                    </button>
                                </form>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Service</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('services/' . $item->id) }}" method="post">
                                                    {!! csrf_field() !!}
                                                    @method("PATCH")
                                                    <div class="mb-3">
                                                        <label for="name-{{ $item->id }}" class="form-label">Service Name</label>
                                                        <input type="text" name="name" id="name-{{ $item->id }}" value="{{ $item->name }}" class="form-control" maxlength="32" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="price-{{ $item->id }}" class="form-label">Price</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">₱</span>
                                                            <input type="text" name="price" id="price-{{ $item->id }}" value="{{ number_format($item->price, 2) }}" class="form-control" oninput="formatPrice(this)" required>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
        let table = $('#serviceTable').DataTable({
            "paging": true,         // Enable pagination
            "searching": true,      // Enable searching but hide the default search bar
            "ordering": true,       // Enable sorting
            "info": true,           // Show "Showing X to Y of Z entries"
            "lengthMenu": [15, 25, 50], // Page length options
            "pageLength": 15,       // Default rows per page
            "order": [[0, "asc"]], // Default sorting by Date (column index 0)

            // Disable sorting for the Action column (last column)
            "columnDefs": [
                { "orderable": false, "targets": [3] },  // Disable sorting for Action column
                { "width": "30%", "targets": 0 },        // # Column
                { "width": "30%", "targets": 1 },        // Left-align Name column
                { "width": "40%", "targets": 2 }         // Action Column
            ],

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
    //format price
    // Price formatting function (allows up to 2 decimal places)
    function formatPrice(input) {
        let value = input.value.replace(/[^0-9.]/g, ''); // Remove non-numeric characters except for decimals
        
        // Allow only 2 decimal places
        let decimalIndex = value.indexOf('.');
        if (decimalIndex !== -1) {
            value = value.slice(0, decimalIndex + 3); // Limit to two decimal places
        }
        
        // Add leading zero if necessary (e.g., ".99" becomes "0.99")
        if (value.indexOf('.') === 0) {
            value = '0' + value;
        }

        input.value = value;
    }

    // Prevent form submission if price is 0.00 or empty
    document.getElementById('service-form').addEventListener('submit', function(event) {
        let price = document.getElementById('price').value;
        const priceError = document.getElementById('price-error');

        // Check if the price is 0.00 or empty
        if (price === '0.00' || price.trim() === '') {
            event.preventDefault(); // Prevent form submission
            priceError.style.display = 'block'; // Show the error message
            document.getElementById('price').setCustomValidity('Please enter a valid price greater than 0.00'); // Set custom validity message
        } else {
            priceError.style.display = 'none'; // Hide the error message if price is valid
            document.getElementById('price').setCustomValidity(''); // Reset the validity message
        }
    });

</script>
<style>
/* Align text data in Name and Price columns to the left */
#serviceTable td:nth-child(2), /* Name column */
#serviceTable td:nth-child(3)  /* Price column */ {
    text-align: left !important;
    padding-left: 15px;
}
#serviceTable th.table-column-number,
#serviceTable td:nth-child(1) {
    text-align: center !important;
}

/* Keep the Action column centered */
#serviceTable td:last-child {
    text-align: center;
}

/* Ensure consistent padding */
#serviceTable th, #servicesTable td {
    padding: 10px;
}

/* Ensure action buttons are evenly spaced */
#serviceTable .table-column-action button {
    display: inline-block;
    width: 80px;
    margin: 2px;
}
.custom-table-container {
    max-height: 600px; /* Set a max height for scrolling */
    overflow-y: auto; /* Enable vertical scrolling */
    overflow-x: auto; /* Enable horizontal scrolling */
    position: relative;
}
#serviceTable thead {
    position: sticky;
    top: 0;
    background: #f8f9fa; /* Light gray background */
    z-index: 101; /* Keep headers above table content */
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Adds slight shadow */
}
#serviceTable thead th {
    position: sticky;
    top: 0;
    background: #ffffff; /* White background */
    z-index: 102; /* Ensure it stays above other elements */
    border-bottom: 2px solid #ddd;
}
</style>
@endsection
