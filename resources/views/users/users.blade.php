@extends('users.layout')
@section('content')

<!-- Add New User Modal -->
<div class="modal fade" id="addNewUserModal" tabindex="-1" aria-labelledby="addNewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('users') }}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="mb-3">
                        <label for="usertype" class="form-label">Role</label>
                        <select name="usertype" id="usertype" class="form-control" required>
                            <option value="" disabled selected>Select Role</option>
                            <option value="1">Admin</option>
                            <option value="0">Staff</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" maxlength="16" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" maxlength="16" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" maxlength="32" required>
                        <div id="email-error" class="alert alert-danger" style="display:none;">
                            Please enter a valid email address.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" minlength="8" required>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        <div id="password-error" class="alert alert-danger" style="display:none;">
                            Passwords do not match. Please make sure both passwords are the same.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="profile_photo" class="form-label">Profile Photo</label>
                        <input type="file" name="profile_photo" id="profile_photo" class="form-control" accept="image/*" required>
                        <div id="profile-photo-error" class="alert alert-danger" style="display:none;">
                            File size must not exceed 5MB.
                        </div>
                        @if ($errors->has('profile_photo'))
        <div class="alert alert-danger">
            {{ $errors->first('profile_photo') }}
        </div>
    @endif
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Users List -->
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h4 class="text-dark">Users List</h4>
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewUserModal">
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
                <table id="userTable" class="table table-striped table-hover text-center">
                    <thead class="table-light">
                        <tr>
                            <th class="table-column-number">#</th>
                            <th>Role</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th class="table-column-action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->usertype == 1 ? 'Admin' : 'Staff' }}</td>
                            <td class="user-name">{{ $item->name }}</td>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $item->id }}">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                </button>

                                <!-- Delete Button -->
                                <form method="POST" action="{{ url('/users/' . $item->id) }}" style="display:inline">
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
                                                <h5 class="modal-title">Edit User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('users/' . $item->id) }}" method="post" enctype="multipart/form-data">
                                                    {!! csrf_field() !!}
                                                    @method("PATCH")
                                                    <div class="mb-3">
                                                        <label for="usertype" class="form-label">Role</label>
                                                        <select name="usertype" id="usertype" class="form-control" required>
                                                            <option value="1" {{ $item->usertype == 1 ? 'selected' : '' }}>Admin</option>
                                                            <option value="0" {{ $item->usertype == 0 ? 'selected' : '' }}>Staff</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text" name="name" id="name" value="{{ $item->name }}" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="username" class="form-label">Username</label>
                                                        <input type="text" name="username" id="username" value="{{ $item->username }}" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" name="email" id="email" value="{{ $item->email }}" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="profile_photo" class="form-label">Profile Photo</label>
                                                        @if ($item->profile_photo_path)
                                                            <img src="{{ asset('storage/' . $item->profile_photo_path) }}" alt="Profile Photo" width="100" class="mb-2">
                                                        @else
                                                            <p>No photo uploaded.</p>
                                                        @endif
                                                        <input type="file" name="profile_photo" id="profile_photo" class="form-control">
                                                        <div id="profile-photo-error-{{ $item->id }}" class="alert alert-danger" style="display:none;">
        File size must not exceed 5MB.
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
    document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ JavaScript Loaded!");

    const fileInput = document.getElementById("profile_photo");
    const fileError = document.getElementById("profile-photo-error");
    const form = document.querySelector("#addNewUserModal form"); // Select the form inside the modal
    const maxSize = 5 * 1024 * 1024; // 5MB in bytes

    if (!fileInput) {
        console.log("❌ File input NOT found!");
        return;
    } else {
        console.log("✅ File input found!");
    }

    fileInput.addEventListener("change", function () {
        if (fileInput.files.length > 0) {
            const fileSize = fileInput.files[0].size;
            console.log("📏 File Size:", fileSize);

            if (fileSize > maxSize) {
                fileError.style.display = "block"; // Show error message
                fileError.textContent = "🚨 The file size must not exceed 5MB.";
                fileInput.classList.add("is-invalid"); // Add red border
                fileInput.value = ""; // Clear the input
            } else {
                fileError.style.display = "none"; // Hide error
                fileInput.classList.remove("is-invalid"); // Remove red border
            }
        }
    });

    form.addEventListener("submit", function (event) {
        if (fileInput.files.length > 0 && fileInput.files[0].size > maxSize) {
            event.preventDefault(); 
            console.log("Form submission blocked due to large file size!");
            fileError.style.display = "block"; // Show error message
            fileError.textContent = "The file size must not exceed 5MB.";
            fileInput.classList.add("is-invalid"); // Add red border
        }
    });

    // ✅ Reset errors when modal is closed
    document.getElementById("addNewUserModal").addEventListener("hidden.bs.modal", function () {
        fileError.style.display = "none"; // Hide error message
        fileInput.classList.remove("is-invalid"); // Remove red border
        fileInput.value = ""; // Clear the file input when the modal is closed
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const maxSize = 5 * 1024 * 1024; // 5MB in bytes

    document.querySelectorAll(".modal").forEach((modal) => {
        modal.addEventListener("shown.bs.modal", function () {
            const fileInput = modal.querySelector("input[type='file']");
            const fileError = modal.querySelector(".alert-danger");
            const form = modal.querySelector("form"); // Select the form in the modal

            if (fileInput) {
                fileInput.addEventListener("change", function () {
                    if (fileInput.files.length > 0) {
                        const fileSize = fileInput.files[0].size;

                        if (fileSize > maxSize) {
                            fileError.style.display = "block"; // Show error message
                            fileError.textContent = "The file size must not exceed 5MB.";
                            fileInput.classList.add("is-invalid"); // Add red border
                            fileInput.value = ""; // Clear the input
                        } else {
                            fileError.style.display = "none"; // Hide error
                            fileInput.classList.remove("is-invalid"); // Remove red border
                        }
                    }
                });

                // Prevent form submission if file is too large
                form.addEventListener("submit", function (event) {
                    if (fileInput.files.length > 0 && fileInput.files[0].size > maxSize) {
                        event.preventDefault(); // Prevent form submission
                        fileError.style.display = "block"; // Show error message
                        fileError.textContent = "The file size must not exceed 5MB.";
                        fileInput.classList.add("is-invalid"); // Add red border
                    }
                });
            }
        });

        // Reset errors when the modal is closed
        modal.addEventListener("hidden.bs.modal", function () {
            const fileInput = modal.querySelector("input[type='file']");
            const fileError = modal.querySelector(".alert-danger");
            if (fileError) fileError.style.display = "none"; // Hide error message
            if (fileInput) fileInput.classList.remove("is-invalid"); // Remove red border
            if (fileInput) fileInput.value = ""; // Clear the file input when the modal is closed
        });
    });
});

   $(document).ready(function() {
        let table = $('#userTable').DataTable({
            "paging": true,         // Enable pagination
            "searching": true,      // Enable searching but hide the default search bar
            "ordering": true,       // Enable sorting
            "info": true,           // Show "Showing X to Y of Z entries"
            "lengthMenu": [15, 25, 50], // Page length options
            "pageLength": 15,       // Default rows per page
            "order": [[0, "asc"]], // Default sorting by Date (column index 0)

            // Disable sorting for the Action column (last column)
            "columnDefs": [
            { "orderable": false, "targets": [5] },  // Disable sorting for Action column
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
    // Password Match Validation
    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        const errorMessage = document.getElementById('password-error');
        
        // Check if passwords match
        if (password !== passwordConfirmation) {
            errorMessage.style.display = 'block'; // Show error if passwords do not match
        } else {
            errorMessage.style.display = 'none'; // Hide error if passwords match
        }
    });

    document.getElementById('service-form').addEventListener('submit', function(event) {
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        const errorMessage = document.getElementById('password-error');

        // Prevent form submission if passwords don't match
        if (password !== passwordConfirmation) {
            event.preventDefault(); // Prevent form submission
            errorMessage.style.display = 'block'; // Show error message
        }
    });
    //email
    document.getElementById('email').addEventListener('input', function() {
        const email = document.getElementById('email').value;
        const emailError = document.getElementById('email-error');
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;  // Email validation regex

        // Check if the email matches the correct pattern
        if (!emailPattern.test(email)) {
            emailError.style.display = 'block'; // Show error message
        } else {
            emailError.style.display = 'none'; // Hide error message
        }
    });
</script>
<style>
/* Center align the # column */
#userTable th.table-column-number,
#userTable td:nth-child(1) {
    text-align: center !important;
}

/* Center align all table headers */
#userTable th {
    text-align: center;
    vertical-align: middle;
}

/* Center align the Action column */
#userTable td:last-child {
    text-align: center;
}

/* Ensure consistent padding */
#userTable th, #userTable td {
    padding: 10px;
}
.custom-table-container {
    max-height: 600px; /* Set a max height for scrolling */
    overflow-y: auto; /* Enable vertical scrolling */
    overflow-x: auto; /* Enable horizontal scrolling */
    position: relative;
}
#userTable thead {
    position: sticky;
    top: 0;
    background: #f8f9fa; /* Light gray background */
    z-index: 101; /* Keep headers above table content */
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Adds slight shadow */
}
#userTable thead th {
    position: sticky;
    top: 0;
    background: #ffffff; /* White background */
    z-index: 102; /* Ensure it stays above other elements */
    border-bottom: 2px solid #ddd;
}
</style>
 
@endsection
