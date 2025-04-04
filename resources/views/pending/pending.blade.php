@extends('pending.layout')

@section('content')
<!-- Pending Reservations Header -->
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h4 class="text-dark">Pending Reservations</h4>
            <div class="d-flex align-items-center">
                <!-- Search Bar -->
                <div class="input-group">
                    <input type="text" id="searchPending" class="form-control form-control-sm" placeholder="Search reservations...">
                    <span class="input-group-text text-primary"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>

    <hr style="border: 1px solid yellow;">

    <!-- Flash Message for Success -->
    <div id="flash-message-container">
        @if (session('success') && !request()->ajax())
            <div id="flash-message" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>


    <!-- Pending Reservations Table -->
    <div class="row">
        <div class="col-lg-12">
            <div class="custom-table-container">
                <table id="pendingTable" class="table table-striped table-hover text-center">
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
                        @foreach ($pendingReservations as $reservation)
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
                                        <i class="fa fa-cog"></i> <!-- Gear icon -->
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#editModal-{{ $reservation->id }}">
                                                <i class="fa fa-pencil-square-o"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ url('/reservations/delete/' . $reservation->id) }}">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <input type="hidden" name="redirect_to" value="{{ url()->current() }}">
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this reservation?')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal-{{ $reservation->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $reservation->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Reservation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <!-- Display Validation Errors -->
                                                @if($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif

                                                <form action="{{ route('reservations.update', $reservation->id) }}" method="post" class="edit-reservation-form" data-reservation-id="{{ $reservation->id }}">
                                                    {!! csrf_field() !!}
                                                    @method("PATCH")

                                                    <input type="hidden" class="venue-id" value="{{ $reservation->venue_id }}" 
                                                        data-price-per-hour="{{ $reservation->memtyp === 'member' ? $reservation->venue->member_price : $reservation->venue->guest_price }}">
                                                    
                                                    <!-- Add this hidden input field here -->
                                                    <input type="hidden" name="removed_services" id="removed_services_{{ $reservation->id }}" value="">

                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-5">
                                                            <div class="mb-3">
                                                                <label class="form-label">First Name</label>
                                                                <input type="text" name="first_name" value="{{ $reservation->first_name }}" class="form-control" required pattern="^[a-zA-Z\s]+$" title="First name can only contain letters and spaces">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="mb-3">
                                                                <label class="form-label">Last Name</label>
                                                                <input type="text" name="last_name" value="{{ $reservation->last_name }}" class="form-control" required pattern="^[a-zA-Z\s]+$" title="Last name can only contain letters and spaces">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-5">
                                                            <div class="mb-3">
                                                                <label class="form-label">Email</label>
                                                                <input type="email" name="email" value="{{ $reservation->email }}" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="mb-3">
                                                                <label class="form-label">Contact Number</label>
                                                                <input type="text" name="phone" value="{{ $reservation->phone }}" class="form-control" pattern="^(09|\+639)\d{9}$" title="Contact number should be a valid phone number (e.g., 09123456789 or +639123456789)" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-10">
                                                            <div class="mb-3">
                                                                <label class="form-label">Additional Services</label>
                                                                <div id="service-container-{{ $reservation->id }}">
                                                                    @if($reservation->services->isNotEmpty())
                                                                        @foreach($reservation->services as $service)
                                                                            <div class="d-flex align-items-center mb-2 service-row">
                                                                                <select name="services[]" class="form-control me-2 service-dropdown"
                                                                                    data-reservation-id="{{ $reservation->id }}">
                                                                                    <option value="">None</option>
                                                                                    @foreach ($services as $availableService)
                                                                                        <option value="{{ $availableService->id }}" data-price="{{ $availableService->price }}"
                                                                                            {{ $service->id == $availableService->id ? 'selected' : '' }}>
                                                                                            {{ $availableService->name }} - ₱{{ number_format($availableService->price, 2) }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                                <input type="number" name="quantities[]" class="form-control service-quantity me-2"
                                                                                    value="{{ $service->pivot->quantity }}" min="1"
                                                                                    data-reservation-id="{{ $reservation->id }}">
                                                                                <button type="button" class="btn btn-danger btn-sm remove-service" data-reservation-id="{{ $reservation->id }}">
                                                                                    <i class="fa fa-trash"></i>
                                                                                </button>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <p class="text-muted">No additional services selected.</p>
                                                                    @endif
                                                                </div>
                                                                <button type="button" class="btn btn-primary btn-sm add-service" data-reservation-id="{{ $reservation->id }}">
                                                                    <i class="fa fa-plus"></i> Add Service
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-5">
                                                            <div class="mb-3">
                                                                <label class="form-label">Check-in Date</label>
                                                                <input type="text" name="check_in_date" id="check_in_date_{{ $reservation->id }}" 
                                                                    value="{{ $reservation->check_in_date }}" 
                                                                    class="form-control flatpickr-date" placeholder="Select date">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="mb-3">
                                                                <label class="form-label">Check-in Time</label>
                                                                <input type="text" name="check_in_time" id="check_in_time_{{ $reservation->id }}" 
                                                                    value="{{ $reservation->check_in_time }}" 
                                                                    class="form-control flatpickr-time" placeholder="Select time">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-md-5">
                                                            <div class="mb-3">
                                                                <label class="form-label">Check-out Date</label>
                                                                <input type="text" name="check_out_date" id="check_out_date_{{ $reservation->id }}" 
                                                                    value="{{ $reservation->check_out_date }}" 
                                                                    class="form-control flatpickr-date" placeholder="Select date">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="mb-3">
                                                                <label class="form-label">Check-out Time</label>
                                                                <input type="text" name="check_out_time" id="check_out_time_{{ $reservation->id }}" 
                                                                    value="{{ $reservation->check_out_time }}" 
                                                                    class="form-control flatpickr-time" placeholder="Select time">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Total Price</label>
                                                        <input type="text" name="total_price" class="form-control total-price"
                                                            value="₱{{ number_format($reservation->total_price, 2) }}" readonly
                                                            data-reservation-id="{{ $reservation->id }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="form-control">
                                                            <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                            <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                            <option value="completed" {{ $reservation->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                            <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                        </select>
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
        let table = $('#pendingTable').DataTable({
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

    //services
    document.addEventListener("DOMContentLoaded", function () {
        // Add new service row
        document.querySelectorAll(".add-service").forEach(button => {
            button.addEventListener("click", function () {
                let reservationId = this.getAttribute("data-reservation-id");
                let container = document.getElementById(`service-container-${reservationId}`);

                let serviceDropdownHTML = `
                    <div class="d-flex align-items-center mb-2 service-row">
                        <select name="services[]" class="form-control me-2 service-dropdown" data-reservation-id="${reservationId}">
                            <option value="">None</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" data-price="{{ $service->price }}">{{ $service->name }} - ₱{{ number_format($service->price, 2) }}</option>
                            @endforeach
                        </select>
                        <input type="number" name="quantities[]" class="form-control service-quantity me-2" value="1" min="1" data-reservation-id="${reservationId}">
                        <button type="button" class="btn btn-danger btn-sm remove-service" data-reservation-id="${reservationId}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>`;

                container.insertAdjacentHTML("beforeend", serviceDropdownHTML);
            });
        });

       // Track removed services
        document.addEventListener("click", function (event) {
            if (event.target.closest(".remove-service")) {
                let row = event.target.closest(".service-row");
                let serviceDropdown = row.querySelector(".service-dropdown");
                let removedServiceId = serviceDropdown.value;

                let reservationId = serviceDropdown.getAttribute("data-reservation-id");
                let removedServicesInput = document.querySelector(`#removed_services_${reservationId}`);

                if (removedServiceId) {
                    let removedServices = removedServicesInput.value ? removedServicesInput.value.split(",") : [];
                    removedServices.push(removedServiceId);
                    removedServicesInput.value = removedServices.join(",");
                }

                row.remove();
                updateTotalPrice(reservationId);
            }
        });

         // Update total price when services are changed
        document.addEventListener("input", function (event) {
            if (event.target.matches(".service-dropdown") || event.target.matches(".service-quantity")) {
                let reservationId = event.target.getAttribute("data-reservation-id");
                updateTotalPrice(reservationId);
            }
        });

        // Update total price when time changes
        document.querySelectorAll(".flatpickr-time, .flatpickr-date").forEach(input => {
            input.addEventListener("change", function () {
                let modal = this.closest('.modal');
                let reservationId = modal.querySelector('.total-price').getAttribute("data-reservation-id");
                updateTotalPrice(reservationId);
            });
        });

        function updateTotalPrice(reservationId) {
            let modal = document.querySelector(`#editModal-${reservationId}`);
            let totalPriceField = modal.querySelector(`.total-price[data-reservation-id="${reservationId}"]`);
            let hiddenTotalPriceField = modal.querySelector(`input[name="total_price"]`);
            let pricePerHour = parseFloat(modal.querySelector(".venue-id").getAttribute("data-price-per-hour"));

            let checkInDate = modal.querySelector(`#check_in_date_${reservationId}`).value;
            let checkOutDate = modal.querySelector(`#check_out_date_${reservationId}`).value;
            let checkInTime = modal.querySelector(`#check_in_time_${reservationId}`).value;
            let checkOutTime = modal.querySelector(`#check_out_time_${reservationId}`).value;

            if (checkInDate && checkOutDate && checkInTime && checkOutTime) {
                let checkIn = new Date(`${checkInDate}T${checkInTime}`);
                let checkOut = new Date(`${checkOutDate}T${checkOutTime}`);
                let totalHours = (checkOut - checkIn) / 1000 / 60 / 60; // Convert milliseconds to hours

                if (totalHours > 0) {
                    let totalBasePrice = totalHours * pricePerHour;
                    let totalServiceCost = 0;

                    modal.querySelectorAll(`.service-dropdown[data-reservation-id="${reservationId}"]`).forEach((dropdown, index) => {
                        let servicePrice = parseFloat(dropdown.options[dropdown.selectedIndex].getAttribute("data-price")) || 0;
                        let quantity = parseInt(modal.querySelectorAll(`.service-quantity[data-reservation-id="${reservationId}"]`)[index].value) || 1;
                        totalServiceCost += servicePrice * quantity;
                    });

                    let finalTotal = totalBasePrice + totalServiceCost;
                    totalPriceField.value = `₱${finalTotal.toFixed(2)}`;
                    hiddenTotalPriceField.value = finalTotal.toFixed(2);
                }
            }
        } 
    });

    //flatpicker
    document.addEventListener("DOMContentLoaded", function() {
        let holidays = @json($holidays->pluck('date')->toArray() ?? []);
        
        document.querySelectorAll(".flatpickr-date").forEach(function(input) {
            let modal = input.closest('.modal');
            let reservationDate = input.value; // Get the current reservation date
            let today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

            flatpickr(input, {
                dateFormat: "Y-m-d",
                minDate: reservationDate < today ? reservationDate : "today", // Allow past dates for existing reservations
                disable: holidays // Disable holidays dynamically
            });
        });

        // Initialize Flatpickr for Time Pickers
        flatpickr(".flatpickr-time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            minTime: "08:00",
            maxTime: "22:00",
        });

        // Prevent selecting an earlier check-out date
        document.querySelectorAll(".flatpickr-date").forEach(function(input) {
            input.addEventListener("change", function() {
                let modal = this.closest('.modal');
                let checkInDate = modal.querySelector('input[name="check_in_date"]').value;
                let checkOutDate = modal.querySelector('input[name="check_out_date"]');

                checkOutDate.flatpickr({
                    minDate: checkInDate
                });
            });
        });
    });

    //update price for when time is change
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".flatpickr-time, .flatpickr-date").forEach(input => {
            input.addEventListener("change", function () {
                let modal = this.closest('.modal');
                let reservationId = modal.querySelector('.total-price').getAttribute("data-reservation-id");
                
                let checkInDate = modal.querySelector(`#check_in_date_${reservationId}`).value;
                let checkOutDate = modal.querySelector(`#check_out_date_${reservationId}`).value;
                let checkInTime = modal.querySelector(`#check_in_time_${reservationId}`).value;
                let checkOutTime = modal.querySelector(`#check_out_time_${reservationId}`).value;
                let totalPriceField = modal.querySelector(`.total-price[data-reservation-id="${reservationId}"]`);
                let hiddenTotalPriceField = modal.querySelector(`input[name="total_price"]`);

                let pricePerHour = parseFloat(modal.querySelector(".venue-id").getAttribute("data-price-per-hour"));
                
                if (checkInDate && checkOutDate && checkInTime && checkOutTime) {
                    let checkIn = new Date(`${checkInDate}T${checkInTime}`);
                    let checkOut = new Date(`${checkOutDate}T${checkOutTime}`);

                    let daysBooked = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24)) || 1;

                    let hoursPerDay = (new Date(`1970-01-01T${checkOutTime}`) - new Date(`1970-01-01T${checkInTime}`)) / (1000 * 60 * 60);

                    let totalHours = hoursPerDay * daysBooked;

                    if (totalHours > 0) {
                        let totalBasePrice = totalHours * pricePerHour;
                        let totalServiceCost = 0;

                        modal.querySelectorAll(`.service-dropdown[data-reservation-id="${reservationId}"]`).forEach((dropdown, index) => {
                            let servicePrice = parseFloat(dropdown.options[dropdown.selectedIndex].getAttribute("data-price")) || 0;
                            let quantity = parseInt(modal.querySelectorAll(`.service-quantity[data-reservation-id="${reservationId}"]`)[index].value) || 1;
                            totalServiceCost += servicePrice * quantity;
                        });

                        let finalTotal = totalBasePrice + totalServiceCost;
                        totalPriceField.value = `₱${finalTotal.toFixed(2)}`;
                        hiddenTotalPriceField.value = finalTotal.toFixed(2); // Ensure hidden input gets updated
                    }
                }
            });
        });
    });
    // Refresh table data after successful form submission
    $(document).on('submit', '.edit-reservation-form', function(e) {
    e.preventDefault();

    let form = $(this);
    let formData = form.serializeArray();

    // Convert total_price to a number (remove ₱ symbol)
    formData.forEach(function(field) {
        if (field.name === "total_price") {
            field.value = field.value.replace(/[^\d.]/g, ""); // Remove ₱ and non-numeric characters
        }
    });

    $.ajax({
        url: form.attr('action'),
        method: 'POST', // Laravel will detect `_method="PATCH"`
        data: $.param(formData), // Serialize the modified data
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            $('.modal').modal('hide'); // Close modal

            // Remove existing flash message before adding a new one
            $("#flash-message").remove();

            let flashMessage = `<div id="flash-message" class="alert alert-success alert-dismissible fade show" role="alert">
                                    ${response.success}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`;
            $("#flash-message-container").append(flashMessage);

            setTimeout(function() {
                $("#flash-message").fadeOut("slow", function() { $(this).remove(); });
            }, 3000); // Hide after 3 seconds

            location.reload(true); // Refresh the page to update data
        },
        error: function(xhr) {
            alert('Error updating reservation: ' + xhr.responseText);
        }
    });
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
    max-width: 95% !important; 
    width: 100%;
}
.table-responsive {
    overflow-x: auto;
    overflow-y: auto; 
    width: 100%;
    max-height: 650px; 
}
.status-badge.pending {
    background-color: #FFC107 !important; 
    color: #000 !important;
}
.custom-table-container {
    max-height: 500px; 
    overflow-y: auto; 
    overflow-x: auto; 
    position: relative;
}
#pendingTable thead {
    position: sticky;
    top: 0;
    background: #f8f9fa; 
    z-index: 101; 
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); 
}
#pendingTable thead th {
    position: sticky;
    top: 0;
    background: #ffffff; 
    z-index: 102; 
    border-bottom: 2px solid #ddd;
}
.btn-sm.dropdown-toggle {
    background: transparent;
    border: none;
    padding: 4px 8px;
    font-size: 16px;
}
.btn-sm.dropdown-toggle:focus {
    box-shadow: none;
}
.dropdown-menu {
    position: absolute !important;
    will-change: transform;
    z-index: 1050; 
}
.dropdown-item {
    display: flex;
    align-items: center;
    gap: 8px; 
    padding: 8px 12px;
    transition: background 0.3s ease-in-out;
}
.dropdown-item:hover {
    background: rgba(40, 167, 69, 0.2); 
    color: #28a745;
}
.table-responsive {
    overflow: visible !important;
}

</style>
@endsection
