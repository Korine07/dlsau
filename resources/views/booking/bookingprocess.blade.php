<div class="single-property section">
    <div class="container">
        <div class="container mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('facilities.index') }}">Facilities</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Booking</li>
                </ol>
            </nav>
        </div>
    
        <div class="row">
            <!-- Main Content Section -->
            <div class="col-lg-8 mb-4">
                <div class="main-image mb-3">
                @if($venue->slider_images && is_array(json_decode($venue->slider_images, true)))
                    <div id="venueSlider" class="carousel slide mb-4" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach(json_decode($venue->slider_images, true) as $index => $image)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image) }}" class="d-block w-100 rounded" alt="Venue Image">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#venueSlider" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#venueSlider" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                @else
                    <p>No slider images available.</p>
                @endif
                </div>
                <div class="main-content">
                    <span class="category badge bg-success mb-3" style="color: white;">{{ $venue->categories->name ?? 'Uncategorized' }}</span>
                    <h4>{{ $venue->venue_name }}</h4>
                    <p>{{ $venue->venue_description }}</p>
                </div>
                <!-- Terms and Conditions Button -->
                <div class="mt-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#termsModal">
                        View Terms and Conditions
                    </button>
                </div>
            </div>

            <!-- Info Table Section -->
            <div class="col-lg-4">
                <div class="info-table p-3 border rounded">
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex align-items-center">
                            <img src="{{ asset('assets/images/info-icon-01.png') }}" alt="" class="icon">
                            <strong>Capacity: </strong> {{ $venue->venue_capacity }}
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <img src="{{ asset('assets/images/info-icon-03.png') }}" alt="" class="icon">
                            <strong>Partner Price: </strong> ₱{{ number_format($venue->member_price, 2) }}
                        </li>

                        <li class="mb-3 d-flex align-items-center">
                            <img src="{{ asset('assets/images/info-icon-03.png') }}" alt="" class="icon">
                            <strong>Guest Price: </strong> ₱{{ number_format($venue->guest_price, 2) }}
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <img src="{{ asset('assets/images/info-icon-02.png') }}" alt="" class="icon">
                            <div class="details-content">
                                <strong>Details: </strong> 
                                <p class="expandable-text">{{ $venue->venue_details }}</p>
                            </div>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <img src="{{ asset('assets/images/info-icon-04.png') }}" alt="" class="icon">
                            <div class="details-content">
                                <strong>Venue Notes: </strong> 
                                <p class="expandable-text">{{ $venue->venue_notes }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <p class="mb-3">By booking this venue, you agree to the following terms and conditions:</p>
                <ul class="terms-list">
                    <li><strong>1.</strong> The facility shall only be used for activities prescribed for it. There may be restrictions on the use because its construction may not be suitable to the activity.</li>
                    <li><strong>2.</strong> Reservation shall be made at least one week before the scheduled time of use. In other words, request should have been submitted to the Scheduling Office within the above mentioned lead time.</li>
                    <li><strong>3.</strong> Accommodation is on a first come, first serve basis only.</li>
                    <li><strong>4.</strong> Should it be used by the University, reservation will be revoked at least three days before the schedule of use.</li>
                    <li><strong>5.</strong> Activities that collect fees from the participants shall be charged for the use of the facility.</li>
                    <li><strong>6.</strong> Teacher/adviser is preferable in transacting business with the Scheduling Officer on the use of the facility.</li>
                    <li><strong>7.</strong> No equipment, fixture & furniture shall be taken out from the facility for whatever reason.</li>
                    <li><strong>8.</strong> User shall compose its marshals or discipline monitors during the time of use.</li>
                    <li><strong>9.</strong> No student or outsider shall be allowed to use the facility in the absence of the adviser/teacher or discipline monitor.</li>
                    <li><strong>10.</strong> No food & drinks shall be served inside the facility for sanitary purposes. However, scheduling office may allow at the Scheduling Officer’s own look out.</li>
                    <li><strong>11.</strong> Candies & chewing gum are strictly not allowed inside the facility.</li>
                    <li><strong>12.</strong> No posters & streamers are allowed to be posted or hung on walls, columns, doors and windows for their protection and preservation. However, scheduling office may allow it at the Scheduling Officer’s own look out.</li>
                    <li><strong>13.</strong> For use without charges, lights shall be minimized if natural light is sufficient to illuminate the facility.</li>
                    <li><strong>14.</strong> Damages incurred due to misuse and/or violation of the rules will be charged against the user.  Charges depend on the extent of the damage.  Organization may also be banned from using the facility.</li>
                    <li><strong>15.</strong> User shall inform the Scheduling Office after using the facility so that the former can evaluate the usage, issue clearance to user and close it immediately.</li>
                    <li><strong>16.</strong> Feet off on all walls and on the back of chairs.</li>
                    <li><strong>17.</strong> No standing on chairs and armrests. Likewise, sitting on armrest is not allowed.</li>
                    <li><strong>18.</strong> Standing audience is not allowed.</li>
                    <li><strong>19.</strong> Cleanliness and orderliness shall be observed at all times during the time of use and shall be left clean and orderly.</li>
                    <li><strong>20.</strong> The facility has its own prescribed capacity.  Over crowding is discouraged. Thus, requesting party shall issue control tickets to the participants.</li>
                    <li><strong>21.</strong> Back drafts are allowed but it should only be placed on the space provided for.</li>
                    <li><strong>22.</strong> Violators will be suspended to use the facility for the remaining time of the school year.</li>
                </ul>
                <p class="mt-3">Please ensure you have read and understood these terms before proceeding with your booking.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


    <div class="container mt-5">
        <div class="row">
                <!-- Calendar Section -->
                <div class="col-lg-8">
                    <div class="calendar-container">
                        <div id="calendar"></div>
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

                </div>

                <!-- Booking Form Section -->
                <div class="col-lg-4">
                        <div class="form-container">
                            <h4 class="event-title">Book Event</h4>
                            <div class="form-container">
                            <form action="{{ route('booking.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="venue_id" value="{{ $venue->id }}">
                                <div class="row">
                                    <!-- First Name -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="first_name">First Name</label>
                                            <input type="text" name="first_name" class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" pattern="[A-Za-z\s]+" title="First name should only contain letters and spaces." 
                                            value="{{ old('first_name') }}" required>
                                            @if ($errors->has('first_name'))
                                                <div class="invalid-feedback">{{ $errors->first('first_name') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Last Name -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" name="last_name" class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" pattern="[A-Za-z\s]+" title="Last name should only contain letters and spaces."  
                                            value="{{ old('last_name') }}" required>
                                            @if ($errors->has('last_name'))
                                                <div class="invalid-feedback">{{ $errors->first('last_name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="email">Email Address
                                                <i class="fas fa-info-circle ms-2" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="right" 
                                                title="Email must be a Gmail or Yahoo address (e.g., example@gmail.com or example@yahoo.com).">
                                                </i>
                                            </label>
                                            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                                            value="{{ old('email') }}" required>
                                            @if ($errors->has('email'))
                                                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Contact -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="phone">Contact Number
                                                <i class="fas fa-info-circle ms-2" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="right" 
                                                title="Please enter a valid Philippine phone number (e.g., 09123456789).">
                                                </i>
                                            </label>
                                            <input 
                                                type="text" 
                                                name="phone" 
                                                id="phone" 
                                                class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                                pattern="^(09|\+639)\d{9}$"
                                                title="Please enter a valid Philippine phone number starting with 09."
                                                value="{{ old('phone') }}" required>
                                            <div id="contactError" class="text-danger mt-2" style="display: none;">
                                                Please enter numbers only!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Capacity -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="expected_guests">Expected Guests</label>
                                            <input 
                                                type="number" 
                                                name="expected_guests" 
                                                id="expected_guests" 
                                                class="form-control {{ $errors->has('expected_guests') ? 'is-invalid' : '' }}"
                                                data-capacity="{{ $venue->venue_capacity }}" 
                                                value="{{ old('expected_guests') }}" required>
                                            <small>Capacity Maximum: {{ $venue->venue_capacity }}</small>
                                            <div id="guestsError" class="text-danger mt-2" style="display: none;">Number of guests exceeds the venue's capacity!</div>
                                        </div>
                                    </div>

                                    <!-- Member -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="memtyp">Select Member Type
                                                <i class="fas fa-info-circle ms-2" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="right" 
                                                title="Select 'Partner' if you are a student or staff member of the university. Guests are external visitors.">
                                                </i>
                                            </label>
                                            <select name="memtyp" class="form-select" id="memtyp" required>
                                                <option value="" disabled selected></option>
                                                <option value="guest">Guest</option>
                                                <option value="member">Partner</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label for="activity_nature">Nature of Activity</label>
                                            <div class="d-flex align-items-center">
                                                <input type="text" 
                                                    name="activity_nature" 
                                                    class="form-control {{ $errors->has('activity_nature') ? 'is-invalid' : '' }}"
                                                    id="activity_nature"
                                                    maxlength="64"
                                                    value="{{ old('activity_nature') }}"
                                                    required
                                                    aria-describedby="activity_nature_help">
                                                <i class="fas fa-info-circle ms-2" id="tooltip-icon" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="right" 
                                                title="You can enter Co-curricular Activity, University Activity, or other." 
                                                style="cursor: pointer;"></i>
                                            </div>
                                            <!-- Error message for activity nature -->
                                            @if ($errors->has('activity_nature'))
                                                <small class="form-text text-danger">{{ $errors->first('activity_nature') }}</small>
                                            @else
                                                <small id="activity_nature_help" class="form-text">Specify the nature of the activity.</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Check-in Date -->
                                    <div class="form-group mb-3">
                                        <label for="check_in_datetime">Check-in Date
                                            <i class="fas fa-info-circle ms-2" 
                                            data-bs-toggle="tooltip" 
                                            data-bs-placement="right" 
                                            title="Ensure no overlapping reservations—check the calendar before selecting a date.">
                                            </i>
                                        </label>
                                        <input type="text" id="check_in_datetime" name="check_in_date" class="form-select custom-input" placeholder="Select Date">
                                        <div class="text-danger validation-message" id="checkInDateError" style="display: none;">
                                            Please fill out this field.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Check-in Time -->
                                    <div class="form-group mb-3">
                                        <label for="check_in_time">Check-in Time
                                            <i class="fas fa-info-circle ms-2" 
                                            data-bs-toggle="tooltip" 
                                            data-bs-placement="right" 
                                            title="Ensure no overlapping reservations—check the calendar before selecting a time.">
                                            </i>
                                        </label>
                                        <div class="input-group">
                                            <select id="check_in_time" name="check_in_time" class="form-select" required disabled>
                                                <option value="">Select Time</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Check-out Date -->
                                    <div class="form-group mb-3">
                                        <label for="check_out_datetime">Check-out Date</label>
                                        <input type="text" id="check_out_datetime" name="check_out_date" class="form-select custom-input" placeholder="Select Date">
                                        <div class="text-danger validation-message" id="checkOutDateError" style="display: none;">
                                            Please fill out this field.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Check-out Time -->
                                    <div class="form-group mb-3">
                                        <label for="check_out_time">Check-out Time</label>
                                        <div class="input-group">
                                            <select id="check_out_time" name="check_out_time" class="form-select" required disabled>
                                                <option value="">Select Time</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label>Additional Services
                                            <i class="fas fa-info-circle ms-2" 
                                            data-bs-toggle="tooltip" 
                                            data-bs-placement="right" 
                                            title="If you accidentally click the 'Add Service', you can remove it by clicking the 'Remove' button.">
                                            </i>
                                        </label>
                                        <div id="services-container">
                                            <!-- Service selection will be added dynamically here -->
                                        </div>
                                        <button type="button" id="add-service" class="btn btn-sm btn-secondary mt-2">Add Service</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Total Hours</label>
                                        <input type="text" id="total_hours" name="total_hours" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Total Price</label>
                                        <input type="text" id="total_price" name="total_price" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check mb-3">
                            <input type="checkbox" name="terms" class="form-check-input" id="terms" required>
                            <label for="terms" class="form-check-label">
                                I agree with your terms and conditions
                            </label>
                        </div>
                        <div id="termsError" class="text-danger mb-3" style="display: none;">
                            Please agree to the terms and conditions before submitting.
                        </div>

                        <button type="submit" class="btn btn-success w-100">Book Now</button>
                        </form>
                    </div>
                    </div>
                </div>
        </div>
    </div>
    <!-- Event Details Modal -->
    <div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-custom">
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
    <!-- Help Button -->
    <button id="helpButton" type="button" class="help-button" data-bs-toggle="modal" data-bs-target="#helpModal"
        data-bs-toggle="tooltip" data-bs-placement="left" title="Click to View Booking Guide">
        <i class="fas fa-question-circle"></i>
    </button>

    <!-- Booking Guide Modal -->
    <div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="helpModalLabel">How to Reserve</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <h5 class="modal-section-title">📅 Step 1: Check Availability</h5>
                    <ul class="modal-list">
                        <li>View the calendar to see available dates and times.</li>
                        <li>Click on a reservation in the calendar to view its details.</li>
                        <li>If your preferred date and time are available, proceed to the next step.</li>
                    </ul>

                    <h5 class="modal-section-title">⚠️ Step 2: Check the Details Before Submitting</h5>
                    <ul class="modal-list">
                        <li>Double-check the details before submitting.</li>
                        <li>Some fields have info icons 🛈 — hover over them for formatting tips.</li>
                    </ul>

                    <h5 class="modal-section-title">🎯 Step 3: Additional Options</h5>
                    <ul class="modal-list">
                        <li>You can add extra services if needed.</li>
                        <li>If you accidentally click "Add Service", make sure to remove it.</li>
                    </ul>

                    <h5 class="modal-section-title">💰 Step 4: Confirmation</h5>
                    <ul class="modal-list">
                        <li>Once you submit, your booking request will be reviewed.</li>
                    </ul>

                    <p class="success-message">
                        <i class="fas fa-check-circle text-success"></i> If your reservation is successful, you will receive an email confirmation.  
                        Please check your inbox (or spam folder) for further instructions.
                    </p>

                    <p class="modal-note"><strong>Note:</strong> Please be reminded that the lead time for a successful reservation is 3 days prior to the date of use.</p>
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

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");

    if (!calendarEl) {
        console.error("Calendar element not found!");
        return;
    }

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
    });
    
    //flatpickr
    document.addEventListener("DOMContentLoaded", function () {
        let holidays = [];

        // ✅ Fetch holidays first before initializing Flatpickr and FullCalendar
        fetch("/get-holidays")
            .then(response => response.json())
            .then(data => {
                holidays = data.map(dateStr => dateStr); // Ensure correct date format
                initializeFlatpickr(); // ✅ Initialize Flatpickr after getting holidays
                initializeCalendar(); // ✅ Initialize FullCalendar after fetching holidays
            })
            .catch(error => console.error("❌ Failed to fetch holidays:", error));

        function initializeFlatpickr() {
            flatpickr("#check_in_datetime", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: "today",
                time_24hr: false,
                defaultHour: 7,
                minTime: "08:00",
                maxTime: "22:00",
                disable: holidays, // ✅ Disable holidays dynamically
                onChange: function (selectedDates, dateStr) {
                    updateCheckInOutFields("check_in", dateStr);
                }
            });

            flatpickr("#check_out_datetime", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: "today",
                time_24hr: false,
                defaultHour: 7,
                minTime: "08:00",
                maxTime: "22:00",
                disable: holidays, // ✅ Disable holidays dynamically
                onChange: function (selectedDates, dateStr) {
                    updateCheckInOutFields("check_out", dateStr);
                }
            });
        }

        function initializeCalendar() {
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
                events: function(fetchInfo, successCallback, failureCallback) {
                    fetch("/calendar-events", { cache: "no-store" })
                        .then(response => response.json())
                        .then(events => {
                            successCallback(events);
                        })
                        .catch(error => {
                            console.error("❌ Failed to fetch events:", error);
                            failureCallback(error);
                        });
                },
                
                eventDidMount: function(info) {
                    if (info.event.id.includes("holiday-")) {
                        info.el.style.backgroundColor = "#28a745";
                        info.el.style.borderColor = "#28a745";
                        info.el.style.color = "#ffffff";

                        // Add a class to center the text
                        info.el.classList.add("holiday-event");
                    } else {
                        let statusColor = info.event.backgroundColor;
                        let titleContainer = document.createElement("div");

                        // Get the check-in time from extendedProps
                        let checkInTime = info.event.extendedProps.check_in_time || "";

                        titleContainer.style.backgroundColor = statusColor;
                        info.el.style.borderColor = statusColor;
                        titleContainer.style.color = "#ffffff";
                        titleContainer.style.padding = "10px";
                        titleContainer.style.borderRadius = "4px";
                        titleContainer.style.width = "100%";
                        titleContainer.style.boxSizing = "border-box";
                        titleContainer.style.height = "23px";
                        titleContainer.style.lineHeight = "5px";

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
                    let modalContent = document.querySelector(".modal-dialog-custom");

                    let startDate = new Date(info.event.startStr);
                    let endDate = new Date(info.event.endStr);

                    endDate.setDate(endDate.getDate() - 1);

                    let formattedStartDate = startDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                    let formattedEndDate = endDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

                    if (info.event.id.startsWith("holiday-")) {
                        document.getElementById("event-title").innerText = info.event.title;
                        document.getElementById("event-description").innerHTML = `
                            <p><strong>Start Date:</strong> ${formattedStartDate}</p>
                            <p><strong>End Date:</strong> ${formattedEndDate}</p>
                            <p><strong>Reason:</strong> ${info.event.title}</p>
                        `;
                    } else {
                        let statusColor = info.event.backgroundColor || "#6c757d";

                        document.getElementById("event-title").innerText = info.event.extendedProps.activity || "No Activity Provided";
                        document.getElementById("event-description").innerHTML = `
                            <p><strong>Venue:</strong> ${info.event.title}</p>
                            <p><strong>Date:</strong> ${formattedStartDate}</p>
                            <p><strong>Check-in:</strong> ${info.event.extendedProps.check_in_time}</p>
                            <p><strong>Check-out:</strong> ${info.event.extendedProps.check_out_time}</p>
                            <p><strong>Status:</strong> <span class="badge" style="background-color: ${statusColor}; color: #fff; padding: 5px 10px;">${info.event.extendedProps.status}</span></p>
                        `;
                    }

                    let x = info.jsEvent.clientX;
                    let y = info.jsEvent.clientY;

                    modalContent.style.position = "absolute";
                    modalContent.style.left = `${x + 10}px`;
                    modalContent.style.top = `${y + 10}px`;
                    modalContent.style.zIndex = "1050";
                    modalContent.style.display = "block";

                    let bootstrapModal = new bootstrap.Modal(eventModal, { backdrop: true, keyboard: true });
                    bootstrapModal.show();

                    document.addEventListener("click", function(event) {
                        if (!modalContent.contains(event.target) && event.target !== info.el) {
                            bootstrapModal.hide();
                        }
                    }, { once: true });
                }
            });

            calendar.render();
        }

        function updateCheckInOutFields(type, datetime) {
            let date = datetime.split(" ")[0];
            let time = datetime.split(" ")[1];

            if (type === "check_in") {
                document.getElementById("check_in_date").value = date;
                document.getElementById("check_in_time").value = time;
            } else if (type === "check_out") {
                document.getElementById("check_out_date").value = date;
                document.getElementById("check_out_time").value = time;
            }

            calculateTotalHoursAndPrice();
        }

        document.getElementById("memtyp").addEventListener("change", calculateTotalHoursAndPrice);
    });
    function calculateTotalHoursAndPrice() {
    let checkInDate = document.getElementById("check_in_datetime").value;
    let checkOutDate = document.getElementById("check_out_datetime").value;
    let checkInTime = document.getElementById("check_in_time").value;
    let checkOutTime = document.getElementById("check_out_time").value;
    let memberType = document.getElementById("memtyp").value;

    if (checkInDate && checkOutDate && checkInTime && checkOutTime) {
        // Convert input values to Date objects
        let checkInDateTime = new Date(`${checkInDate}T${checkInTime}:00`);
        let checkOutDateTime = new Date(`${checkOutDate}T${checkOutTime}:00`);

        // Calculate total days (counting properly)
        let totalDays = Math.round((checkOutDateTime - checkInDateTime) / (1000 * 60 * 60 * 24)) + 1;

        // Ensure totalDays is at least 1
        if (totalDays < 1) {
            totalDays = 1;
        }

        // Calculate daily hours correctly
        let checkInTimeOnly = new Date(`1970-01-01T${checkInTime}:00`);
        let checkOutTimeOnly = new Date(`1970-01-01T${checkOutTime}:00`);
        let dailyHours = (checkOutTimeOnly - checkInTimeOnly) / (1000 * 60 * 60); // Convert ms to hours

        // Ensure dailyHours is positive
        if (dailyHours <= 0) {
            dailyHours = 0;
        }

        // ✅ NEW FIX: Ensure only "full" selected days are multiplied
        let totalHours = (totalDays - 1) * dailyHours + dailyHours;

        // Fix rounding issues
        totalHours = Math.round(totalHours * 100) / 100;

        // Display total hours
        document.getElementById("total_hours").value = totalHours.toFixed(2);

        // Calculate total price
        let memberPrice = parseFloat("{{ $venue->member_price }}");
        let guestPrice = parseFloat("{{ $venue->guest_price }}");
        let pricePerHour = (memberType === "member") ? memberPrice : guestPrice;
        let baseTotalPrice = totalHours * pricePerHour;

        document.getElementById("total_price").setAttribute("data-base-price", baseTotalPrice);
        document.getElementById("total_price").value = `₱${baseTotalPrice.toFixed(2)}`;

        updateTotalPrice();
    }
}


    //dropdown
    document.addEventListener("DOMContentLoaded", function () {
        let venueId = document.querySelector("input[name='venue_id']").value;
        let holidays = [];
        let checkOutPicker;

        // ✅ Fetch Holidays & Initialize Flatpickr
        fetch("/get-holidays")
            .then(response => response.json())
            .then(data => {
                holidays = data.map(dateStr => dateStr);
                initializeFlatpickr(); // Call only after holidays are fetched
            })
            .catch(error => console.error("❌ Failed to fetch holidays:", error));

        function fetchAvailableTimes(date, targetDropdownId) {
            return new Promise((resolve, reject) => {
                let dropdown = document.getElementById(targetDropdownId);
                if (!dropdown) return;

                fetch(`/get-available-times?date=${date}&venue_id=${venueId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            console.error("❌ Error fetching available times:", data.error);
                            return;
                        }

                        dropdown.innerHTML = '<option value="">Select Time</option>'; // Reset dropdown

                        let times = data.availableTimes;
                        times.forEach(time => {
                            let formattedTime = convertToAMPM(time);
                            let option = document.createElement("option");
                            option.value = time;
                            option.textContent = formattedTime;
                            dropdown.appendChild(option);
                        });

                        dropdown.disabled = times.length === 0;
                        resolve(times);
                    })
                    .catch(error => {
                    console.error("❌ Fetch error:", error);
                    reject(error);
                    });
            });
        }

        document.getElementById("check_in_time").addEventListener("change", function () {
            let selectedTime = this.value;
            let checkOutDropdown = document.getElementById("check_out_time");

            // Clear previous options
            checkOutDropdown.innerHTML = '<option value="">Select Time</option>';

            // Get all available times
            fetchAvailableTimes(document.getElementById("check_in_datetime").value, "check_out_time")
                .then(times => {
                    times.forEach(time => {
                        if (time > selectedTime) { // Only allow times after check-in
                            let option = document.createElement("option");
                            option.value = time;
                            option.textContent = convertToAMPM(time);
                            checkOutDropdown.appendChild(option);
                        }
                    });
                });
        });


        // ✅ Convert 24-hour format to 12-hour format with AM/PM
        function convertToAMPM(timeString) {
            let [hour, minute] = timeString.split(":");
            hour = parseInt(hour);
            let period = hour >= 12 ? "PM" : "AM";
            hour = hour % 12 || 12; // Convert 0 to 12 for midnight
            return `${hour}:${minute} ${period}`;
        }

        function initializeFlatpickr() {
            flatpickr("#check_in_datetime", {
                enableTime: false,
                dateFormat: "Y-m-d",
                minDate: "today",
                disable: holidays, 
                onChange: function (selectedDates, dateStr) {
                    console.log("Fetching available check-in times for:", dateStr);
                    fetchAvailableTimes(dateStr, "check_in_time");

                    if (checkOutPicker) {
                        checkOutPicker.set("minDate", dateStr);
                    }
                }
            });

            checkOutPicker = flatpickr("#check_out_datetime", {
                enableTime: false,
                dateFormat: "Y-m-d",
                minDate: "today", // Default to today
                disable: holidays
            });
        }

        document.getElementById("check_in_time").addEventListener("change", calculateTotalHoursAndPrice);
        document.getElementById("check_out_time").addEventListener("change", calculateTotalHoursAndPrice);
        document.getElementById("memtyp").addEventListener("change", calculateTotalHoursAndPrice);
    });

    //capacity
    document.addEventListener("DOMContentLoaded", function () {
        let expectedGuestsInput = document.getElementById("expected_guests");
        let guestsError = document.getElementById("guestsError");

        if (!expectedGuestsInput || !guestsError) {
            console.error("Expected guests input or error message element not found!");
            return;
        }

        expectedGuestsInput.addEventListener("input", function () {
            let maxCapacity = parseInt(expectedGuestsInput.getAttribute("data-capacity"), 10);
            let enteredGuests = parseInt(expectedGuestsInput.value, 10);

            if (enteredGuests > maxCapacity) {
                guestsError.style.display = "block"; // Show error message
                expectedGuestsInput.classList.add("is-invalid"); // Add red border
            } else {
                guestsError.style.display = "none"; // Hide error message
                expectedGuestsInput.classList.remove("is-invalid"); // Remove red border
            }
        });
    });

    //contact validation
    document.addEventListener("DOMContentLoaded", function () {
        let contactInput = document.getElementById("phone");
        let contactError = document.getElementById("contactError");

        if (!contactInput || !contactError) {
            console.error("Contact number input or error message element not found!");
            return;
        }

        contactInput.addEventListener("input", function () {
            let phoneNumber = contactInput.value;
            
            // Check if input contains non-numeric characters
            if (!/^\d*$/.test(phoneNumber)) {
                contactError.style.display = "block"; // Show error message
                contactInput.classList.add("is-invalid"); // Add red border
            } else {
                contactError.style.display = "none"; // Hide error message
                contactInput.classList.remove("is-invalid"); // Remove red border
            }
        });

        // Prevent non-numeric characters from being typed
        contactInput.addEventListener("keypress", function (event) {
            if (!/[0-9]/.test(event.key)) {
                event.preventDefault();
            }
        });
    });

     //terms and conditions checkbox
     document.addEventListener("DOMContentLoaded", function () {
        let form = document.querySelector("form"); // Get the booking form
        let termsCheckbox = document.getElementById("terms"); // Checkbox for agreement
        let termsError = document.getElementById("termsError"); // Error message container

        form.addEventListener("submit", function (event) {
            if (!termsCheckbox.checked) {
                event.preventDefault(); // Stop form submission
                termsError.style.display = "block"; // Show error message
                termsCheckbox.classList.add("is-invalid"); // Add red border
            } else {
                termsError.style.display = "none"; // Hide error message
                termsCheckbox.classList.remove("is-invalid"); // Remove red border
            }
        });

        // Remove error when checkbox is checked
        termsCheckbox.addEventListener("change", function () {
            if (termsCheckbox.checked) {
                termsError.style.display = "none";
                termsCheckbox.classList.remove("is-invalid");
            }
        });
    });

    //services
    document.addEventListener("DOMContentLoaded", function () {
        let servicesContainer = document.getElementById("services-container");
        let addServiceButton = document.getElementById("add-service");

        let services = @json($services); // Fetch services from the Blade variable

        function createServiceRow() {
            let div = document.createElement("div");
            div.classList.add("service-row", "d-flex", "align-items-center", "mb-2");

            let select = document.createElement("select");
            select.classList.add("form-control", "service-select", "me-2");
            select.name = "services[]"; // Make it an array
            select.innerHTML = '<option value="">None</option>';
            services.forEach(service => {
                let option = document.createElement("option");
                option.value = service.id;
                option.dataset.price = service.price;
                option.textContent = `${service.name} - ₱${service.price}`;
                select.appendChild(option);
            });

            let quantity = document.createElement("input");
            quantity.type = "number";
            quantity.name = "quantities[]"; // Make it an array
            quantity.classList.add("form-control", "service-quantity", "me-2");
            quantity.placeholder = "Hrs";
            quantity.min = 1;
            quantity.disabled = true;

            let removeButton = document.createElement("button");
            removeButton.type = "button";
            removeButton.classList.add("btn", "btn-danger", "btn-sm");
            removeButton.textContent = "Remove";

            removeButton.addEventListener("click", function () {
                div.remove();
                updateTotalPrice();
            });

            select.addEventListener("change", function () {
                quantity.disabled = this.value === "";
                if (this.value) {
                    quantity.value = 1;
                } else {
                    quantity.value = "";
                }
                updateTotalPrice();
            });

            quantity.addEventListener("input", updateTotalPrice);

            div.appendChild(select);
            div.appendChild(quantity);
            div.appendChild(removeButton);
            servicesContainer.appendChild(div);
        }

        addServiceButton.addEventListener("click", createServiceRow);

        function updateTotalPrice() {
            let basePrice = parseFloat(document.getElementById("total_price").getAttribute("data-base-price")) || 0;
            let serviceRows = document.querySelectorAll(".service-row");
            let serviceTotal = 0;

            serviceRows.forEach(row => {
                let select = row.querySelector(".service-select");
                let quantity = row.querySelector(".service-quantity");

                if (select.value && quantity.value) {
                    let servicePrice = parseFloat(select.selectedOptions[0].dataset.price);
                    let qty = parseInt(quantity.value);
                    serviceTotal += servicePrice * qty;
                }
            });

            let finalTotal = basePrice + serviceTotal;
            document.getElementById("total_price").value = `₱${finalTotal.toFixed(2)}`;
        }
    });

    //nature of activity
    document.addEventListener('DOMContentLoaded', function () {
        var form = document.querySelector('form');  // Select the form
        var activityInput = document.getElementById('activity_nature'); // Select the activity input field
        var activityHelp = document.getElementById('activity_nature_help'); // The small element for error message

        // Handle real-time input validation for character limit
        activityInput.addEventListener("input", function () {
            let inputLength = this.value.length;
            if (inputLength > 64) {
                this.setCustomValidity("Please enter no more than 64 characters.");
            } else {
                this.setCustomValidity(""); // Clear any previous validation error
            }
        });

        // Handle form submission to check if activity input is empty
        form.addEventListener('submit', function(event) {
            // Check if the activity input is empty
            if (activityInput.value.trim() === "") {
                // Prevent form submission
                event.preventDefault();
                // Show error message
                activityHelp.textContent = "This field is required!";
                activityHelp.style.color = "red";  // Make the error message red
                activityInput.classList.add("is-invalid"); // Add invalid class (optional)
            } else {
                // Clear the error message if input is not empty
                activityHelp.textContent = ""; // Clear the message
                activityInput.classList.remove("is-invalid"); // Remove invalid class (optional)
            }
        });
    });
    //check in and out validation
    document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const submitButton = form.querySelector("button[type='submit']");
    const checkInDate = document.getElementById("check_in_datetime");
    const checkOutDate = document.getElementById("check_out_datetime");

    // Error messages
    const checkInDateError = document.getElementById("checkInDateError");
    const checkOutDateError = document.getElementById("checkOutDateError");

    function validateForm(event) {
        let valid = true;

        // Check-in Date Validation
        if (!checkInDate.value.trim()) {
            checkInDateError.style.display = "block";
            checkInDate.classList.add("is-invalid");
            valid = false;
        } else {
            checkInDateError.style.display = "none";
            checkInDate.classList.remove("is-invalid");
        }

        // Check-out Date Validation
        if (!checkOutDate.value.trim()) {
            checkOutDateError.style.display = "block";
            checkOutDate.classList.add("is-invalid");
            valid = false;
        } else {
            checkOutDateError.style.display = "none";
            checkOutDate.classList.remove("is-invalid");
        }

        // 🚨 Prevent form submission if validation fails
        if (!valid) {
            event.preventDefault();
            event.stopPropagation();
            return false; // Ensures the form does NOT submit
        }
    }

    // Attach event listener to form submit
    form.addEventListener("submit", validateForm);

    // Remove error messages when user corrects the field
    [checkInDate, checkOutDate].forEach(input => {
        input.addEventListener("change", function () {
            if (this.value.trim()) {
                document.getElementById(this.id + "Error").style.display = "none";
                this.classList.remove("is-invalid");
            }
        });
    });

    // Disable submit button initially & enable only if all fields are filled
    function checkFields() {
        if (checkInDate.value.trim() && checkOutDate.value.trim()) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    }

    [checkInDate, checkOutDate].forEach(input => {
        input.addEventListener("change", checkFields);
    });

    checkFields(); // Run on page load in case form is prefilled
});

    //member type
    document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const emailInput = document.querySelector("input[name='email']");
    const memtypSelect = document.getElementById("memtyp");
    const checkInTime = document.getElementById("check_in_time");
    const checkOutTime = document.getElementById("check_out_time");
    const contactInput = document.getElementById("phone");

    // Create error message elements
    const emailError = document.createElement("div");
    emailError.classList.add("invalid-feedback");
    emailError.style.display = "none";
    emailInput.parentNode.appendChild(emailError);

    const memtypError = document.createElement("div");
    memtypError.classList.add("invalid-feedback");
    memtypError.style.display = "none";
    memtypSelect.parentNode.appendChild(memtypError);

    const checkOutTimeError = document.createElement("div");
    checkOutTimeError.classList.add("invalid-feedback");
    checkOutTimeError.style.display = "none";
    checkOutTime.parentNode.appendChild(checkOutTimeError);

    const contactError = document.createElement("div");
    contactError.classList.add("invalid-feedback");
    contactError.style.display = "none";
    contactInput.parentNode.appendChild(contactError);

    form.addEventListener("submit", function (event) {
        let isValid = true;

        // ✅ Email Validation
        const emailValue = emailInput.value;
        if (!emailValue.includes("@") || !emailValue.includes(".")) {
            event.preventDefault();
            emailInput.classList.add("is-invalid");
            emailError.textContent = "Please include '@' and '.' in the email address.";
            emailError.style.display = "block";
            isValid = false;
        } else {
            emailInput.classList.remove("is-invalid");
            emailError.style.display = "none";
        }

        // ✅ Member Type Validation
        if (!memtypSelect.value) {
            event.preventDefault();
            memtypSelect.classList.add("is-invalid");
            memtypError.textContent = "Please select a Member Type.";
            memtypError.style.display = "block";
            isValid = false;
        } else {
            memtypSelect.classList.remove("is-invalid");
            memtypError.style.display = "none";
        }

        // ✅ Contact Number Validation
        const contactValue = contactInput.value.trim();
        const phonePattern = /^(09|\+639)\d{9}$/;

        if (!phonePattern.test(contactValue)) {
            event.preventDefault();
            contactInput.classList.add("is-invalid");
            contactError.textContent = "Please enter a valid Philippine phone number (e.g., 09123456789 or +639123456789).";
            contactError.style.display = "block";
            isValid = false;
        } else {
            contactInput.classList.remove("is-invalid");
            contactError.style.display = "none";
        }

        // ✅ Check-Out Time Validation
        if (checkInTime.value && checkOutTime.value) {
            const checkInDateTime = new Date(`1970-01-01T${checkInTime.value}`);
            const checkOutDateTime = new Date(`1970-01-01T${checkOutTime.value}`);

            if (checkOutDateTime <= checkInDateTime) {
                event.preventDefault();
                checkOutTime.classList.add("is-invalid");
                checkOutTimeError.textContent = "The check-out time must be later than the check-in time.";
                checkOutTimeError.style.display = "block";
                isValid = false;
            } else {
                checkOutTime.classList.remove("is-invalid");
                checkOutTimeError.style.display = "none";
            }
        }

        return isValid;
    });

    // ✅ Hide error messages when user corrects input
    emailInput.addEventListener("input", function () {
        if (emailInput.value.includes("@") && emailInput.value.includes(".")) {
            emailInput.classList.remove("is-invalid");
            emailError.style.display = "none";
        }
    });

    memtypSelect.addEventListener("change", function () {
        if (memtypSelect.value) {
            memtypSelect.classList.remove("is-invalid");
            memtypError.style.display = "none";
        }
    });

    contactInput.addEventListener("input", function () {
        if (/^(09|\+639)\d{9}$/.test(contactInput.value.trim())) {
            contactInput.classList.remove("is-invalid");
            contactError.style.display = "none";
        }
    });

    checkOutTime.addEventListener("change", function () {
        if (checkInTime.value && checkOutTime.value) {
            const checkInDateTime = new Date(`1970-01-01T${checkInTime.value}`);
            const checkOutDateTime = new Date(`1970-01-01T${checkOutTime.value}`);

            if (checkOutDateTime > checkInDateTime) {
                checkOutTime.classList.remove("is-invalid");
                checkOutTimeError.style.display = "none";
            }
        }
    });
});



</script>

<style>
    /* Calendar Container */
.calendar-container {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    min-height: 525px;
}

    .form-container {
        background-color: #333;
        color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-container label {
        color: #fff;
        font-size: 14px;
    }

    .form-container input,
    .form-container select {
        background-color: #1e1e1e;
        color: #fff;
        border: 1px solid #555;
        padding: 8px;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-container button {
        background-color: #28a745;
        color: #fff;
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    .form-container button:hover {
        background-color: #218838;
    }
    .invalid-feedback {
    color: #dc3545;
    font-size: 0.875em;
    margin-top: 0.25rem;
    display: none; /* Hide by default */
}

.form-check-input:invalid ~ .invalid-feedback {
    display: block; /* Show when invalid */
}

.is-invalid {
    border-color: #dc3545; /* Red border for invalid input */
    background-color: #f8d7da; /* Light red background */
}
.text-danger {
    font-size: 0.875em;
}
input[type="time"]::-webkit-datetime-edit-ampm-field {
    display: none;
}

input[type="time"] {
    cursor: pointer;
}
.carousel-item {
    width: 100%;
    min-height: 300px; /* Minimum height */
    max-height: 500px; /* Maximum height */
    object-fit: cover;
    border-radius: 10px;
}
.modal-content {
    border-radius: 10px;
}

.modal-body ul {
    padding-left: 20px;
}

.modal-body ul li {
    margin-bottom: 10px;
}
.modal-dialog-custom {
    position: absolute;
    max-width: 350px;
    z-index: 1050;
    transform: none !important;
    display: none; /* Hide by default */
}
.modal.show {
    display: block !important; /* Ensures it stays visible */
}
.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.1) !important; /* Lighter background */
}

.form-control:disabled {
    background-color: #1e1e1e !important; /* Light red background */
    color: #aaa !important; /* Dark red text */
    opacity: 1 !important; /* Ensure full visibility */
    cursor: not-allowed;
}
.form-container input, .form-container select {
    background-color: #1e1e1e;
    color: #aaa;
    border: 1px solid #555;
    padding: 8px;
    border-radius: 4px;
    font-size: 14px;
}

.fc-theme-standard .fc-scrollgrid {
  color: #000; /* Change to black or any desired color */
}
.fc-daygrid-day-number {
  color: #000000 !important; /* Change day number color */
  
}
.fc-toolbar-title {
  color: #000000 !important; /* Change title text color */
}
.fc-col-header-cell-cushion {
  color: #000000 !important; /* Change this to your preferred color */
  font-weight: bold;
  font-size: 16px;
  text-decoration: none !important;
}
.fc .fc-daygrid-day-number {
  text-decoration: none !important;
}
.fc .fc-day-today .fc-daygrid-day-number {
  background-color: #ff2c2c; /* Change this color to your preference */
  color: white !important; /* White number inside */
  border-radius: 50%; /* Makes it circular */
  padding: 5px; /* Adjust padding for circle size */
  display: inline-block; /* Ensures proper centering */
  width: 30px; /* Set specific width */
  height: 30px; /* Set specific height */
  display: flex; /* Ensures proper alignment */
  align-items: center; /* Center the text vertically */
  justify-content: center; /* Center the text horizontally */
}
/* Add gray encircle effect when hovering over a day */
.fc-daygrid-day:hover .fc-daygrid-day-number {
  background-color: gray; /* Gray background on hover */
  color: white !important; /* Text color */
  border-radius: 50%; /* Make it a circle */
  padding: 5px; /* Adjust padding */
  font-size: 16px; /* Adjust font size */
  width: 30px; /* Circle width */
  height: 30px; /* Circle height */
  display: flex; /* Ensures proper alignment */
  align-items: center; /* Center the text vertically */
  justify-content: center; /* Center the text horizontally */
  transition: all 0.2s ease-in-out; /* Smooth transition */
}
.event-title {
    color: white; /* Change this to any color you prefer */
}
/* Remove border and background */
.input-group {
    background-color: #1e1e1e; /* Match form background */
    border-radius: 4px;
}

/* Dropdown field */
.form-control.no-border {
    background-color: #1e1e1e !important;
    color: #fff !important;
    border: none !important;
    box-shadow: none !important;
}

/* Icon styling */
.custom-icon {
    background: transparent !important;
    color: #fff !important;
    cursor: pointer;
    padding: 10px;
}

/* Make sure the icon has no border */
.custom-icon.no-border {
    border: none !important;
    box-shadow: none !important;
}

/* Ensure icon aligns properly */
.custom-icon i {
    font-size: 16px; /* Adjust icon size */
}

/* Change color when hovered */
.custom-icon:hover {
    color: #bbb !important; /* Light gray */
}
.custom-input {
    background-color: #1e1e1e; /* Dark background */
    color: #fff; /* White text */
    border: 1px solid #555;
    padding-right: 40px; /* Space for the icon */
    border-radius: 4px;
    text-align: left;
}
.custom-input::placeholder {
    color: #aaa; /* Light gray text */
}
.legend-circle {
    width: 20px;
    height: 20px;
    display: inline-block;
    border-radius: 50%;
    margin-right: 5px;
}
.fc-event, .fc-event-dot {
    background-color: #ffffff;
}
.fc-event {
    border: none !important;
    
}
.holiday-event .fc-event-title {
    display: flex;
    justify-content: center;  /* Center horizontally */
    align-items: center;      /* Center vertically */
    height: 100%;             /* Ensure it takes up full height */
    text-align: center;       /* Center text */
    font-size: 14px;          /* Optional: Adjust font size */
}
.fc-timegrid-event {
    min-height: 30px; /* Ensure that each event has a minimum height */
    max-height: 80px; /* Limit the maximum height of events */
    overflow: hidden; /* Prevent text overflow */
    text-overflow: ellipsis; /* Add ellipsis if the text overflows */
    white-space: nowrap; /* Prevent text from wrapping */
}
.fc-timegrid-day > .fc-timegrid-event-harness {
    display: flex;
    flex-direction: column;
    justify-content: flex-start; /* Align events to the top of the cell */
    align-items: stretch;
}
.fc-timegrid-event .fc-event-title {
    font-size: 12px; /* Ensure the font is small enough to fit inside the event */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap; /* Prevent title from wrapping to the next line */
}

.icon {
    max-width: 52px;
    margin-right: 10px;
}
.details-content {
    flex: 1; /* Ensures content takes up remaining space */
}

/* Prevents sudden overflow */
.expandable-text {
    white-space: normal; /* Allows multi-line expansion */
    overflow-wrap: break-word;
}

/* Optional: Add a max height & scrolling for very long text */
.expandable-text {
    max-height: 125px;
    overflow-y: auto;
    padding-right: 5px;
}
#activity_nature_help {
    color: white;  /* Make text color white */
}
.is-invalid {
    border-color: red; /* Change the border color to red */
}
.validation-message {
    font-size: 0.875rem;
    color: red;
    margin-top: 5px;
}
.form-select {
    background-color: #1e1e1e !important; /* Dark background */
    color: #fff !important; /* White text */
    border: 1px solid #555 !important; /* Dark border */
}
.main-content {
    color: white;
}
/* Floating Help Button */
.help-button {
    position: fixed;
    bottom: 20px;
    left: 20px;
    background: #28a745;
    color: white;
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    font-size: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    z-index: 1050;
    transition: all 0.3s ease;
}

.help-button:hover {
    background: #218838;
    transform: scale(1.1);
}

/* Modal Content */
.modal-content {
    border-radius: 10px;
    padding: 15px;
    overflow-y: auto;
    max-height: 80vh;
}

/* Section Titles */
.modal-section-title {
    margin-top: 15px;
    font-weight: bold;
    font-size: 16px;
}

/* List Spacing */
.modal-list {
    padding-left: 25px;
    margin-bottom: 15px;
}

.modal-list li {
    margin-bottom: 10px;
}

/* Extra Note */
.modal-note {
    font-size: 14px;
    color: #555;
    margin-top: 15px;
}
/* Position modal above the floating button */
#helpModal .modal-dialog {
    position: fixed;
    bottom: 70px; /* Moves it above the button */
    left: 20px; /* Align with the button */
    transform: translateY(0);
    width: 400px; /* Adjust width as needed */
    max-width: 85%; /* Ensure it fits on smaller screens */
}

/* Ensure proper positioning on mobile */
@media (max-width: 768px) {
    #helpModal .modal-dialog {
        bottom: 100px; /* Adjust for mobile */
        left: 50%;
        transform: translateX(-50%);
        width: 95%;
        height: auto; /* Allows dynamic height */
        max-height: 80vh; /* Limits height to 80% of the viewport */
        overflow-y: auto;
    }
}
.modal-body ul li {
    margin-bottom: 10px;
    margin-top: 10px;
    font-size: 14px;
}
.modal-header {
    font-size: 13px;
}

</style>