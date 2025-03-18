@extends('calendar.layout')

@section('content')
<div class="container mt-4">
    <div class="row d-flex flex-wrap">
        <!-- Holiday List -->
        <div id="holiday-container" class="col-md-5 col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-dark">Holiday List</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addHolidayModal">
                    <i class="fa fa-plus" aria-hidden="true"></i> Add Holiday
                </button>
            </div>
                <hr style="border: 1px solid green;">

                <!-- Flash Messages -->
                <div id="flash-container"></div>

                <!-- Holiday List Table -->
                <div class="custom-table-container">
                    <table id="holidayTable" class="table table-striped table-hover text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Reason</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="holiday-list">
                            <!-- Populated dynamically via AJAX -->
                        </tbody>
                    </table>
                </div>
                <!-- Custom Page Length Control & Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <!-- Left: Rows Per Page Dropdown -->
                    <div class="d-flex align-items-center">
                        <label for="custom-page-length" class="me-2 mb-0 text-gray">Rows per page:</label>
                        <select id="custom-page-length" class="form-select form-select-sm" style="width: auto;">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <!-- Pagination: Moved Below -->
                    <div id="custom-pagination" class="d-flex align-items-center">
                        <span id="page-info" class="text-gray me-2"></span>
                        <button id="prev-page" class="btn btn-light btn-sm me-1" disabled>❮</button>
                        <button id="next-page" class="btn btn-light btn-sm ms">❯</button>
                    </div>
                </div>

        </div>

        <!-- Calendar Section -->
        <div id="calendar-container" class="col-md-9 col-12">
                <div id="calendar" class="shadow-sm p-3 bg-white rounded"></div>
        </div>
                <!-- Legend Section -->
                <div class="legend-container mt-4">
                    <div class="d-flex justify-content-start">
                        <div class="d-flex align-items-center mb-2 me-3">
                            <span class="legend-circle" style="background-color: #ffc107;"></span>
                            <span class="ms-2">Pending</span>
                        </div>
                        <div class="d-flex align-items-center mb-2 me-3">
                            <span class="legend-circle" style="background-color: #fd7e14;"></span>
                            <span class="ms-2">Confirmed</span>
                        </div>
                        <div class="d-flex align-items-center mb-2 me-3">
                            <span class="legend-circle" style="background-color: #007bff;"></span>
                            <span class="ms-2">Completed</span>
                        </div>
                        <div class="d-flex align-items-center mb-2 me-3">
                            <span class="legend-circle" style="background-color: #dc3545;"></span>
                            <span class="ms-2">Cancelled</span>
                        </div>
                        <div class="d-flex align-items-center mb-2 me-3">
                            <span class="legend-circle" style="background-color: #28a745;"></span>
                            <span class="ms-2">Holidays</span>
                        </div>
                    </div>
                </div>

        <!-- Add Holiday Modal -->
        <div class="modal fade" id="addHolidayModal" tabindex="-1" aria-labelledby="addHolidayModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addHolidayModalLabel">Add New Holiday</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="holiday-form">
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" id="date" name="date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason</label>
                                <input type="text" id="reason" name="reason" class="form-control" required maxlength="32">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Holiday Modal -->
        <div class="modal fade" id="editHolidayModal" tabindex="-1" aria-labelledby="editHolidayModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editHolidayModalLabel">Edit Holiday</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="edit-holiday-form">
                            <input type="hidden" id="edit-holiday-id">
                            <div class="mb-3">
                                <label for="edit-date" class="form-label">Date</label>
                                <input type="date" id="edit-date" name="date" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-reason" class="form-label">Reason</label>
                                <input type="text" id="edit-reason" name="reason" class="form-control" required maxlength="32">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Event Details Modal -->
        <div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-custom">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="event-title">Event Details</h5>
                        </div>
                        <div class="modal-body" id="event-description">
                            <!-- Event details will be injected here dynamically -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar v6 - Correct Import -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/locales-all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    console.log("FullCalendar is initializing...");

    var calendarEl = document.getElementById("calendar");

    if (!calendarEl) {
        console.error("Calendar element not found!");
        return;
    }

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay"
        },
        firstDay: 1, // 0 = Sunday, 1 = Monday
        events: "/calendar-events", // Fetch holidays + reservations from Laravel
        editable: false,
        selectable: true,

        eventDidMount: function(info) {
            if (info.event.id.includes("holiday-")) {
                info.el.style.backgroundColor = "#28a745";
                info.el.style.borderColor = "#28a745";
                info.el.style.color = "#ffffff";
            } else {
                let statusColor = info.event.backgroundColor; // Get status color
                let titleContainer = document.createElement("div");

                // Get the check-in time from extendedProps
                let checkInTime = info.event.extendedProps.check_in_time || "";

                titleContainer.style.backgroundColor = statusColor; // Set container color
                titleContainer.style.color = "#ffffff"; // White text
                titleContainer.style.padding = "10px";
                titleContainer.style.borderRadius = "4px";
                titleContainer.style.width = "100%";
                titleContainer.style.boxSizing = "border-box";
                titleContainer.style.height = "23px";
                titleContainer.style.lineHeight = "5px";
                
                titleContainer.innerText = info.event.title; // Show venue name

                // Format display: "10:30 AM Rizal Hall" (No bold)
                titleContainer.innerText = `${checkInTime} ${info.event.title}`;

                info.el.innerHTML = "";
                info.el.appendChild(titleContainer);
            }
        },

        eventClick: function(info) {
            console.log("Event clicked:", info.event);

            // Function to format time to 12-hour format
            function formatTime(timeString) {
                let time = new Date(`1970-01-01T${timeString}`);
                return time.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });
            }

            let eventModal = document.getElementById("eventDetailsModal");

            let eventDate = new Date(info.event.start);
            let localDate = eventDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

            // Check if the event is a holiday
            if (info.event.id.includes("holiday-")) {
                document.getElementById("event-title").innerText = "Holiday";
                document.getElementById("event-description").innerHTML = `
                    <p><strong>Date:</strong> ${localDate}</p>
                    <p><strong>Reason:</strong> ${info.event.title}</p>
                `;
            } 
            // Otherwise, it's a reservation
            else {
                let statusColor = info.event.backgroundColor || "#6c757d";

                document.getElementById("event-title").innerText = "Reservation Details";
                document.getElementById("event-description").innerHTML = `
                    <p><strong>Venue:</strong> ${info.event.title}</p>
                    <p><strong>Date:</strong> ${localDate}</p>
                    <p><strong>Check-in:</strong> ${info.event.extendedProps.check_in_time}</p>
                    <p><strong>Check-out:</strong> ${info.event.extendedProps.check_out_time}</p>
                    <p><strong>Customer:</strong> ${info.event.extendedProps.first_name} ${info.event.extendedProps.last_name}</p>
                    <p><strong>Status:</strong> <span class="badge" style="background-color: ${statusColor}; color: #fff; padding: 5px 10px;">${info.event.extendedProps.status}</span></p>
                `;
            }
            // Get clicked position
            let x = info.jsEvent.clientX;
            let y = info.jsEvent.clientY;

            // Position the modal near the clicked event
            let modal = document.querySelector(".modal-dialog-custom");
            modal.style.position = "absolute";
            modal.style.left = `${x}px`;
            modal.style.top = `${y}px`;
            modal.style.zIndex = "1050";
            modal.style.display = "block"; // Ensure modal is visible

             // Show the modal
            let bootstrapModal = new bootstrap.Modal(eventModal, { backdrop: 'static', keyboard: true });
            bootstrapModal.show();

            // ✅ Close modal when clicking outside
            eventModal.addEventListener("click", function(event) {
                if (event.target === eventModal) {
                    bootstrapModal.hide();
                }
            });
        }
    });

    calendar.render();

    // **✅ Scroll Up/Down to Change Months**
    calendarEl.addEventListener("wheel", function (event) {
        if (event.deltaY < 0) {
            calendar.prev(); // Scroll Up → Previous Month
        } else {
            calendar.next(); // Scroll Down → Next Month
        }
        event.preventDefault(); // Prevent default scrolling
    });

    console.log("Rendering calendar...");

    calendar.render();

    function showFlashMessage(message, type = "success") {
        const flashContainer = document.getElementById("flash-container");
        flashContainer.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        setTimeout(() => {
            flashContainer.innerHTML = "";
        }, 2000);
    }

    // Function to load holiday list
    function loadHolidayList() {
        fetch("/holidays")
        .then(response => response.json())
        .then(data => {
            let holidayTable = $('#holidayTable').DataTable();
            holidayTable.clear(); // Clear existing table data

            data.forEach(holiday => {
                holidayTable.row.add([
                    holiday.date,
                    holiday.reason,
                    `
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton${holiday.id}" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-cog"></i> <!-- Gear Icon -->
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton${holiday.id}">
                            <li>
                                <button class="dropdown-item edit-btn" data-id="${holiday.id}" data-date="${holiday.date}" data-reason="${holiday.reason}">
                                    <i class="fa fa-pencil"></i> Edit
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item text-danger delete-btn" data-id="${holiday.id}">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </li>
                        </ul>
                    </div>
                    `
                ]).draw(false);
            });

            attachEventListeners();
        })
        .catch(error => console.error("Error fetching holidays:", error));
    }

    // Run this when the page loads
    loadHolidayList();

    function attachEventListeners() {
        document.querySelectorAll(".edit-btn").forEach(button => {
            button.addEventListener("click", function () {
                let id = this.getAttribute("data-id");
                let date = this.getAttribute("data-date");
                let reason = this.getAttribute("data-reason");

                document.getElementById("edit-holiday-id").value = id;
                document.getElementById("edit-date").value = date;
                document.getElementById("edit-reason").value = reason;

                let editModal = new bootstrap.Modal(document.getElementById("editHolidayModal"));
                editModal.show();
            });
        });

        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function () {
                let id = this.getAttribute("data-id");
                deleteHoliday(id);
            });
        });
    }

    function deleteHoliday(id) {
        if (!confirm("Are you sure you want to delete this holiday?")) return;

        fetch(`/holidays/${id}`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            }
        })
        .then(response => response.json())
        .then(data => {
            showFlashMessage(data.message, "danger");
            loadHolidayList(); // Reload the table after deletion
            calendar.refetchEvents();
        })
        .catch(error => console.error("Error deleting holiday:", error));
    }

    document.getElementById("holiday-form").addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = { date: document.getElementById("date").value, reason: document.getElementById("reason").value };

        fetch("/holidays", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            showFlashMessage(data.message);
            loadHolidayList();
            calendar.refetchEvents();

            // ✅ Close the modal properly
            const addModal = bootstrap.Modal.getInstance(document.getElementById("addHolidayModal"));
            addModal.hide();

            // ✅ Ensure backdrop is removed and body class is reset
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.classList.remove('modal-open');

            // ✅ Reset the form
            document.getElementById("holiday-form").reset();
        })
        .catch(error => console.error("Error adding holiday:", error));
    });

    // Handle holiday form submission
    document.getElementById("edit-holiday-form").addEventListener("submit", function (e) {
        e.preventDefault();

        const id = document.getElementById("edit-holiday-id").value;
        const formData = {
            date: document.getElementById("edit-date").value,
            reason: document.getElementById("edit-reason").value,
        };

        fetch(`/holidays/${id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            showFlashMessage(data.message);
            loadHolidayList();
            calendar.refetchEvents();

            const editModal = bootstrap.Modal.getInstance(document.getElementById("editHolidayModal"));
            editModal.hide();

            document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());
            document.body.classList.remove("modal-open");
        })
        .catch(error => console.error("Error updating holiday:", error));
    });
});
    //datatable
    $(document).ready(function() {
    let table = $('#holidayTable').DataTable({
        "paging": true,        // Enable pagination
        "searching": false,    // Disable search bar
        "ordering": true,      // Enable sorting
        "info": true,         // Hide "Showing X to Y of Z entries"
        "lengthMenu": [10, 25, 50], // Hide default "Show X entries" dropdown
        "pageLength": 10,       // Default page size
        "order": [[0, "asc"]], // Default sort by Date (column index 0)

        "columnDefs": [
            { "orderable": false, "targets": [2] },  // Disable sorting for Action column
        ],

        "dom": 't' // ✅ Removes built-in pagination controls (Only table remains)
    });

    // ✅ Ensure page info is updated on load
    function updatePagination() {
        let pageInfo = table.page.info();
        $('#page-info').text(`${pageInfo.start + 1} - ${pageInfo.end} of ${pageInfo.recordsTotal}`);

        // Enable/disable pagination buttons
        $('#prev-page').prop('disabled', pageInfo.page === 0);
        $('#next-page').prop('disabled', pageInfo.page >= pageInfo.pages - 1);
    }

    // ✅ Call `updatePagination` after DataTable is initialized
    updatePagination();

    // ✅ Handle rows per page change
    $('#custom-page-length').on('change', function() {
        let newLength = $(this).val();
        table.page.len(newLength).draw();
        updatePagination();
    });

    // ✅ Handle previous page button
    $('#prev-page').on('click', function() {
        table.page('previous').draw('page');
        updatePagination();
    });

    // ✅ Handle next page button
    $('#next-page').on('click', function() {
        table.page('next').draw('page');
        updatePagination();
    });

    // ✅ Update pagination after each page change
    table.on('draw', function() {
        updatePagination();
    });
});


</script>

<style>
    
    .form-group {
        margin-bottom: 15px;
    }
    /* Legend Styles */
.mt-4 {
    margin-top: 1.5rem !important;
}

.me-2 {
    margin-right: 0.5rem !important;
}

.d-flex {
    display: flex !important;
}

.flex-column {
    flex-direction: column !important;
}

.mb-2 {
    margin-bottom: 0.5rem !important;
}

.text-dark {
    color: #343a40 !important;
}
.modal-dialog-custom {
    position: absolute;
    max-width: 350px;
    z-index: 1050;
    transform: none !important;
}
.modal.show {
    display: block !important; /* Ensures it stays visible */
}
.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.1) !important; /* Darker black */
}
.legend-circle {
    width: 20px;
    height: 20px;
    display: inline-block;
    border-radius: 50%;
    margin-right: 5px;
}
.legend-container {
    text-align: left; /* Align the legend to the left */
    margin-left: 500px; /* Add a margin from the left */
}
#custom-page-length {
    display: inline-block;
    margin-left: 5px;
}

#custom-pagination {
    display: flex;
    align-items: center;

    margin-top: 10px;
}

#prev-page, #next-page {
    padding: 5px 12px;
    border-radius: 4px;
    border: 1px solid #ddd;
}
.custom-table-container {
    max-height: 400px; /* Set a max height for scrolling */
    overflow-y: auto; /* Enable vertical scrolling */
    overflow-x: auto; /* Enable horizontal scrolling */
    position: relative;
    min-width: 100%;
}
#holidayTable th, #holidayTable td {
    white-space: nowrap; /* Prevent text wrapping */
    padding: 10px; /* Add space */
}
#holidayTable td:nth-child(2) {
    word-wrap: break-word; /* Wrap long words */
    max-width: 200px; /* Prevent overflow */
    white-space: normal;
    max-width: 250px;
}

#holidayTable thead {
    position: sticky;
    top: 0;
    background: #f8f9fa; /* Light gray background */
    z-index: 101; /* Keep headers above table content */
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Adds slight shadow */
}
#holidayTable thead th {
    position: sticky;
    top: 0;
    background: #ffffff; /* White background */
    z-index: 102; /* Ensure it stays above other elements */
    border-bottom: 2px solid #ddd;
}
.table-responsive {
    overflow-x: auto;
    overflow-y: auto; /* Enables vertical scrolling */
    width: 100%;
    max-height: 500px; /* Set the maximum height */
}
.justify-content-start {
    margin-left: 100px;
}
/* Ensure the dropdown menu is visible */
.dropdown-menu {
    position: absolute !important;
    will-change: transform;
    z-index: 1050; /* Ensure dropdown appears above table */
}

/* Fix Bootstrap dropdown overflow inside table */
.table-responsive {
    overflow: visible !important;
}

/* Align dropdown inside table */
td .dropdown {
    display: inline-block;
}

/* Improve gear icon button */
.btn-light.dropdown-toggle {
    border: none;
    background: transparent;
    padding: 4px 8px;
}

/* Style dropdown items */
.dropdown-menu .dropdown-item {
    padding: 8px 12px;
    font-size: 14px;
}
@media (max-width: 768px) {
    #holiday-container {
        width: 100%;
        margin-bottom: 20px;
    }
    .legend-container {
        text-align: center;
        margin-left: 0 !important;
        width: 100%;
    }
}
#holiday-container {
    flex: 0 0 40%; /* Increase the width */
    max-width: 40%;
}
#calendar-container {
    flex: 0 0 60%; /* Adjust calendar width */
    max-width: 60%;
}

@media (min-width: 992px) { /* Large screens */
    #holiday-container {
        max-width: 30%; /* Allow more space */
    }
    #calendar-container {
        max-width: 70%; /* Calendar gets more space */
    }
}
@media (max-width: 768px) { /* Small screens */
    #holiday-container {
        width: 100%;
        margin-bottom: 20px;
    }
    #calendar-container {
        width: 100%;
    }
}
</style>
@endsection
