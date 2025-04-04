@extends('venue_list.layout')

@section('content')
<!-- Venues List -->
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h4 class="text-dark">Venue List</h4>
            <div class="d-flex align-items-center">
                <!-- Search Bar -->
                <div class="input-group ms-3" style="width: 170px;">
                    <input type="text" id="searchPending" class="form-control form-control-sm" placeholder="Search venues...">
                    <span class="input-group-text text-primary"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>

    <hr style="border: 1px solid green;">

    <!-- Flash Message -->
    @if (session('success'))
        <div id="flash-message" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="custom-table-container">
                <table id="venueTable" class="table table-striped table-hover text-center">
                    <thead class="table-light">
                        <tr>
                            <th class="table-column-number">#</th>
                            <th>Venue Name</th>
                            <th>Category</th>
                            <th>Partner Price</th>
                            <th>Guest Price</th>
                            <th>Capacity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($venues as $venue)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $venue->venue_name }}</td>
                            <td>{{ $venue->categories->name ?? 'No Category' }}</td>
                            <td>₱{{ number_format($venue->member_price, 2) }}</td>
                            <td>₱{{ number_format($venue->guest_price, 2) }}</td>
                            <td>{{ $venue->venue_capacity }}</td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $venue->id }}">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                </button>

                                <!-- Enable/Disable Button -->
                                @if ($venue->status == 'active')
                                    <form method="POST" action="{{ route('venue.disable', $venue->id) }}" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-warning btn-sm text-white" onclick="return confirm('Are you sure you want to disable this venue?')">
                                            Disable
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('venue.enable', $venue->id) }}" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure you want to enable this venue?')">
                                            Enable
                                        </button>
                                    </form>
                                @endif

                                <!-- Delete Button -->
                                <form method="POST" action="{{ route('venue_list.destroy', $venue->id) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this venue?')">Delete</button>
                                </form>

                            </td>
                        </tr>

                        <!-- Edit Venue Modal -->
                        <div class="modal fade" id="editModal-{{ $venue->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $venue->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Venue</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('venue_list.update', $venue->id) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')

                                            <div class="row d-flex justify-content-center">
                                                <!-- Left Column -->
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="venue_name-{{ $venue->id }}" class="form-label">Venue Name</label>
                                                        <input type="text" name="venue_name" id="venue_name-{{ $venue->id }}" value="{{ $venue->venue_name }}" class="form-control" required>
                                                    </div>
                                                </div>

                                                <!-- Right Column -->
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="venue_category-{{ $venue->id }}" class="form-label">Category</label>
                                                        <select name="venue_category_id" id="venue_category-{{ $venue->id }}" class="form-control" required>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}" {{ $venue->venue_category_id == $category->id ? 'selected' : '' }}>
                                                                    {{ $category->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="venue_capacity-{{ $venue->id }}" class="form-label">Venue Capacity</label>
                                                        <input type="number" name="venue_capacity" id="venue_capacity-{{ $venue->id }}" value="{{ $venue->venue_capacity }}" class="form-control" min="0" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="member_price-{{ $venue->id }}" class="form-label">Member Price</label>
                                                        <input type="number" name="member_price" id="member_price-{{ $venue->id }}" value="{{ $venue->member_price }}" class="form-control" step="0.01" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-3">
                                                        <label for="guest_price-{{ $venue->id }}" class="form-label">Guest Price</label>
                                                        <input type="number" name="guest_price" id="guest_price-{{ $venue->id }}" value="{{ $venue->guest_price }}" class="form-control" step="0.01" required>
                                                    </div>
                                                </div>

                                                <div class="row d-flex justify-content-center">
                                                    <div class="col-md-4">
                                                        <div class="mb-4">
                                                            <label for="venue_description-{{ $venue->id }}" class="form-label">Venue Description</label>
                                                            <textarea name="venue_description" id="venue_description-{{ $venue->id }}" class="form-control textarea-lg" required>{{ $venue->venue_description }}</textarea>
                                                        </div>
                                                    </div>
                                                        
                                                    <div class="col-md-4">
                                                        <div class="mb-4">
                                                            <label for="venue_details-{{ $venue->id }}" class="form-label">Venue Details</label>
                                                            <textarea name="venue_details" id="venue_details-{{ $venue->id }}" class="form-control textarea-lg" required>{{ $venue->venue_details }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <label for="venue_notes-{{ $venue->id }}" class="form-label">Venue Notes</label>
                                                            <textarea name="venue_notes" id="venue_notes-{{ $venue->id }}" class="form-control textarea-lg" required>{{ $venue->venue_notes }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <hr style="border: 1px solid gray;">

                                            <div class="row mt-3">
                                                <!-- Cover Image -->
                                                <div class="col-md-5">
                                                    <label class="form-label">Cover Image</label>
                                                    <div class="mb-2">
                                                        @if($venue->cover_photo)
                                                            <img src="{{ asset('storage/' . $venue->cover_photo) }}" alt="Cover Photo" class="img-thumbnail mb-2" width="150">
                                                            
                                                            <div class="d-flex align-items-center ms-auto"> 
                                                                <input type="checkbox" class="form-check-input m-0 p-0" name="delete_cover_photo" value="1" id="delete_cover_photo_{{ $venue->id }}" style="width: 16px; height: 16px;">
                                                                <label for="delete_cover_photo_{{ $venue->id }}" class="form-check-label m-0 ms-1">Delete Current Cover Photo</label>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <input type="file" name="cover_photo" class="form-control">
                                                    <small class="text-danger cover_photo_error" style="display: none;"></small>
                                                    <small class="text-muted d-block">Max size: 5MB per image.</small>
                                                </div>

                                                <!-- Slider Images -->
                                                <div class="col-md-5">
                                                    <label class="form-label">Slider Images</label>
                                                    <div id="slider-images-container-{{ $venue->id }}">
                                                        @if($venue->slider_images)
                                                            @foreach(json_decode($venue->slider_images, true) as $index => $sliderImage)
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <img src="{{ asset('storage/' . $sliderImage) }}" alt="Slider Image" class="img-thumbnail me-2" width="100">

                                                                    <div class="d-flex align-items-center ms-2">
                                                                        <input type="checkbox" class="form-check-input m-0 p-0" name="delete_slider_images[]" value="{{ $sliderImage }}" id="delete_slider_{{ $loop->index }}" style="width: 16px; height: 16px;">
                                                                        <label for="delete_slider_{{ $loop->index }}" class="form-check-label m-0 ms-1">Delete</label>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>

                                                    <div id="new-slider-images-{{ $venue->id }}">
                                                        <div class="mb-3">
                                                            <input type="file" class="form-control slider-image-input-field" name="slider_images[]" accept="image/*" multiple>
                                                            <small class="text-danger mt-2" style="display: none;">Error message will show here.</small>
                                                            <small class="text-muted d-block">Ctrl + Click to upload multiple files. Max size: 5MB per image.</small>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
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
        let table = $('#venueTable').DataTable({
            "paging": true,         // Enable pagination
            "searching": true,      // Enable searching but hide the default search bar
            "ordering": true,       // Enable sorting
            "info": true,           // Show "Showing X to Y of Z entries"
            "lengthMenu": [10, 20, 30], // Page length options
            "pageLength": 10,       // Default rows per page
            "order": [[0, "asc"]], // Default sorting by Date (column index 0)

            // Disable sorting for the Action column (last column)
            "columnDefs": [
            { "orderable": false, "targets": [6] },  // Disable sorting for Action column
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

    //slider images 
    document.addEventListener("DOMContentLoaded", function () {
    const maxFileSize = 5 * 1024 * 1024; // 5MB in bytes

    function validateFileSize(inputElement, errorElement) {
        let validFiles = new DataTransfer(); // Create a new file list
        let errorMsg = "";

        if (inputElement.files.length > 0) {
            Array.from(inputElement.files).forEach(file => {
                if (file.size > maxFileSize) {
                    errorMsg = "One or more selected files exceed 5MB. Please remove them.";
                } else {
                    validFiles.items.add(file); // Keep only valid files
                }
            });
        }

        if (errorMsg) {
            errorElement.textContent = errorMsg;
            errorElement.style.display = "block";
        } else {
            errorElement.textContent = "";
            errorElement.style.display = "none";
        }

        // Update the input field with only valid files
        inputElement.files = validFiles.files;
    }

    // ✅ Validate Cover Photo Size
    document.querySelectorAll('input[name="cover_photo"]').forEach(input => {
        input.addEventListener("change", function () {
            const errorElement = this.closest(".col-md-5").querySelector(".cover_photo_error");
            validateFileSize(this, errorElement);
        });
    });

    // ✅ Validate Slider Images Size
    document.querySelectorAll('.slider-image-input-field').forEach(input => {
        input.addEventListener("change", function () {
            const errorElement = this.closest(".mb-3").querySelector(".text-danger");
            validateFileSize(this, errorElement);
        });
    });

    // ✅ Handle Add Row for Slider Images
    document.querySelectorAll('.add-slider-image').forEach(button => {
        button.addEventListener("click", function () {
            const venueId = this.dataset.id;
            const container = document.getElementById(`new-slider-images-${venueId}`);
            const totalRows = container.querySelectorAll(".slider-image-input").length;

            if (totalRows < 10) {
                const newRow = document.createElement("div");
                newRow.classList.add("input-group", "mb-2", "slider-image-input");

                newRow.innerHTML = `
                    <input type="file" class="form-control slider-image-input-field" name="slider_images[]" accept="image/*" multiple>
                    <button type="button" class="btn btn-danger remove-slider-row">Remove</button>
                `;

                container.appendChild(newRow);
                updateRemoveButtons(venueId);

                // Attach event listener for file validation
                newRow.querySelector(".slider-image-input-field").addEventListener("change", function () {
                    const errorElement = this.closest(".mb-3").querySelector(".text-danger");
                    validateFileSize(this, errorElement);
                });
            } else {
                alert("You can upload a maximum of 10 images.");
            }
        });
    });

    // ✅ Handle Remove Row for Slider Images
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-slider-row")) {
            event.target.parentElement.remove();
        }
    });

    function updateRemoveButtons(venueId) {
        const rows = document.querySelectorAll(`#new-slider-images-${venueId} .slider-image-input`);
        rows.forEach((row, index) => {
            const removeButton = row.querySelector(".remove-slider-row");
            removeButton.style.display = index > 0 ? "inline-block" : "none";
        });
    }
});

</script>
<style>
    /* Center-align the # column */
#venueTable th.table-column-number,
#venueTable td:nth-child(1) {
    text-align: center !important;
}

/* Center-align all table headers */
#venueTable th {
    text-align: center;
    vertical-align: middle;
}

/* Center-align the Actions column */
#venueTable td:last-child {
    text-align: center;
}

/* Ensure consistent padding */
#venueTable th, #venueTable td {
    padding: 10px;
}
input[type="file"] {
    padding: 6px; /* Reduce internal spacing */
    margin: 0; /* Remove unwanted margin */
    width: 100%; /* Ensure full width */
    box-sizing: border-box; /* Prevent extra width */
}
.textarea-lg {
    min-height: 120px !important; /* Ensures height applies */
    resize: vertical; /* Allows users to resize if needed */
}
.custom-table-container {
    max-height: 600px; /* Set a max height for scrolling */
    overflow-y: auto; /* Enable vertical scrolling */
    overflow-x: auto; /* Enable horizontal scrolling */
    position: relative;
}
#venueTable thead {
    position: sticky;
    top: 0;
    background: #f8f9fa; /* Light gray background */
    z-index: 101; /* Keep headers above table content */
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Adds slight shadow */
}
#venueTable thead th {
    position: sticky;
    top: 0;
    background: #ffffff; /* White background */
    z-index: 102; /* Ensure it stays above other elements */
    border-bottom: 2px solid #ddd;
}

</style>
@endsection
