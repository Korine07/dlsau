@extends('categories.layout')
@section('content')
<!-- Add New Category Modal -->
<div class="modal fade" id="addNewUserModal" tabindex="-1" aria-labelledby="addNewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('categories') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="mb-3">
                        <label for="name" class="form-label">Enter Category:</label>
                        <input type="text" name="name" id="name" class="form-control" required maxlength="32">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Categories List -->
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h4 class="text-dark">Categories List</h4>
            <div class="d-flex align-items-center">
                <!-- Add New Button -->
                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addNewUserModal">
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
                <table id="categoryTable" class="table table-striped table-hover text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                </button>

                                <!-- Delete Button -->
                                <form method="POST" action="{{ url('/categories/' . $item->id) }}" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirm delete?')">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                    </button>
                                </form>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('categories/' . $item->id) }}" method="post">
                                                    {!! csrf_field() !!}
                                                    @method("PATCH")
                                                    <div class="mb-3">
                                                        <label for="name-{{ $item->id }}" class="form-label">Name</label>
                                                        <input type="text" name="name" id="name-{{ $item->id }}" value="{{ $item->name }}" class="form-control" required maxlength="32">
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
        let table = $('#categoryTable').DataTable({
            "paging": true,         // Enable pagination
            "searching": true,      // Enable searching but hide the default search bar
            "ordering": true,       // Enable sorting
            "info": true,           // Show "Showing X to Y of Z entries"
            "lengthMenu": [15, 25, 50], // Page length options
            "pageLength": 15,       // Default rows per page
            "order": [[0, "asc"]], // Default sorting by Date (column index 0)

            // Disable sorting for the Action column (last column)
            "columnDefs": [
                { "orderable": false, "targets": [2] },  // Disable sorting for Action column
                { "width": "10%", "targets": 0 },        // # Column
                { "width": "40%", "targets": 1, "className": "text-start" }, // Left-align Name column
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
</script>
<style>
/* Ensure the table header stays centered */
#categoryTable th {
    text-align: center;
}

/* Left-align text in the Name column */
#categoryTable td:nth-child(2) { 
    text-align: left !important;
}

/* Keep Action buttons centered */
#categoryTable td:last-child {
    text-align: center !important;
}

/* Add consistent padding for better readability */
#categoryTable th, #categoryTable td {
    padding: 10px;
}
.custom-table-container {
    max-height: 600px; /* Set a max height for scrolling */
    overflow-y: auto; /* Enable vertical scrolling */
    overflow-x: auto; /* Enable horizontal scrolling */
    position: relative;
}
#categoryTable thead {
    position: sticky;
    top: 0;
    background: #f8f9fa; /* Light gray background */
    z-index: 101; /* Keep headers above table content */
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Adds slight shadow */
}
#categoryTable thead th {
    position: sticky;
    top: 0;
    background: #ffffff; /* White background */
    z-index: 102; /* Ensure it stays above other elements */
    border-bottom: 2px solid #ddd;
}
</style>
@endsection
