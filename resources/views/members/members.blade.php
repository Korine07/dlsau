@extends('members.layout')
@section('content')

<!-- Add New Member Modal -->
<div class="modal fade" id="addNewMemberModal" tabindex="-1" aria-labelledby="addNewMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('members') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="memtyp" class="form-label">Member Type</label>
                        <select name="memtyp" id="memtyp" class="form-control" required>
                            <option value="" disabled selected>Select a Member Type</option>
                            <option value="student" {{ old('memtyp') == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="employee" {{ old('memtyp') == 'employee' ? 'selected' : '' }}>Employee</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="idnum" class="form-label">ID Number</label>
                        <input type="text" name="idnum" id="idnum" class="form-control" value="{{ old('idnum') }}">
                        @if($errors->has('idnum'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('idnum') }}
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Members List -->
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h4 class="text-dark">Members List</h4>
            <div class="d-flex align-items-center">
                <!-- Add New Button -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewMemberModal">
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
                <table id="memberTable" class="table table-striped table-hover text-center">
                    <thead class="table-light">
                        <tr>
                            <th class="table-column-number">#</th>
                            <th>Name</th>
                            <th>Member Type</th>
                            <th>ID Number</th>
                            <th class="table-column-action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->last_name }}, {{ $item->first_name }}</td>
                            <td>{{ $item->memtyp }}</td>
                            <td>{{ $item->idnum ?? 'N/A' }}</td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                </button>
                                <!-- Delete Button -->
                                <form method="POST" action="{{ url('/members/' . $item->id) }}" style="display:inline">
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
                                                <h5 class="modal-title">Edit Member</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('members/' . $item->id) }}" method="post">
                                                    {!! csrf_field() !!}
                                                    @method("PATCH")
                                                    <div class="mb-3">
                                                        <label for="last_name-{{ $item->id }}" class="form-label">Last Name</label>
                                                        <input type="text" name="last_name" id="last_name-{{ $item->id }}" value="{{ $item->last_name }}" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="first_name-{{ $item->id }}" class="form-label">First Name</label>
                                                        <input type="text" name="first_name" id="first_name-{{ $item->id }}" value="{{ $item->first_name }}" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="memtyp-{{ $item->id }}" class="form-label">Member Type</label>
                                                        <select name="memtyp" id="memtyp-{{ $item->id }}" class="form-control" required>
                                                            <option value="student" {{ $item->memtyp == 'student' ? 'selected' : '' }}>Student</option>
                                                            <option value="employee" {{ $item->memtyp == 'employee' ? 'selected' : '' }}>Employee</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="idnum-{{ $item->id }}" class="form-label">ID Number</label>
                                                        <input type="text" name="idnum" id="idnum-{{ $item->id }}" value="{{ $item->idnum }}" class="form-control">
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
        let table = $('#memberTable').DataTable({
            "paging": true,         // Enable pagination
            "searching": true,      // Enable searching but hide the default search bar
            "ordering": true,       // Enable sorting
            "info": true,           // Show "Showing X to Y of Z entries"
            "lengthMenu": [15, 25, 50], // Page length options
            "pageLength": 15,       // Default rows per page
            "order": [[0, "asc"]], // Default sorting by Date (column index 0)

            // Disable sorting for the Action column (last column)
            "columnDefs": [
            { "orderable": false, "targets": [4] },  // Disable sorting for Action column
            { "className": "text-start", "targets": [1, 2, 3] } 
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
/* Center align the # column */
#memberTable th.table-column-number,
#memberTable td:nth-child(1) {
    text-align: center !important;
}

/* Center align all table headers */
#memberTable th {
    text-align: center;
    vertical-align: middle;
}

/* Left-align Name, Member Type, and ID Number columns */
#memberTable td:nth-child(2), /* Name column */
#memberTable td:nth-child(3), /* Member Type column */
#memberTable td:nth-child(4)  /* ID Number column */ {
    text-align: left !important;
    padding-left: 15px;
}

/* Center align the Action column */
#memberTable td:last-child {
    text-align: center;
}

/* Ensure consistent padding */
#memberTable th, #memberTable td {
    padding: 10px;
}
.custom-table-container {
    max-height: 600px; /* Set a max height for scrolling */
    overflow-y: auto; /* Enable vertical scrolling */
    overflow-x: auto; /* Enable horizontal scrolling */
    position: relative;
}
#memberTable thead {
    position: sticky;
    top: 0;
    background: #f8f9fa; /* Light gray background */
    z-index: 101; /* Keep headers above table content */
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Adds slight shadow */
}
#memberTable thead th {
    position: sticky;
    top: 0;
    background: #ffffff; /* White background */
    z-index: 102; /* Ensure it stays above other elements */
    border-bottom: 2px solid #ddd;
}
</style>
@endsection
