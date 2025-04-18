@php
    use Illuminate\Support\Str;
@endphp

<div class="section properties">
    <div class="container">
        <!-- Categories Filter -->
        <ul class="properties-filter">
            <li>
                <a class="is_active" href="javascript:void(0)" data-filter="*">Show All</a>
            </li>
            @foreach ($categories as $category)
                <li>
                    <a href="javascript:void(0)" data-filter="{{ $category->name }}">{{ $category->name }}</a>
                </li>
            @endforeach
        </ul>

        <!-- Venues List -->
        <div class="row properties-box">
            @foreach ($venues as $venue)
                <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items {{ strtolower(str_replace(' ', '-', $venue->categories->name ?? 'uncategorized')) }}">
                    <div class="item venue-card">
                        <!-- Display the cover photo if it exists -->
                        @if($venue->cover_photo)
                            
                                <img src="{{ asset('storage/' . $venue->cover_photo) }}" alt="Cover Photo" class="venue-card img-fluid">
                            
                        @else
                            <p>No cover photo available</p>
                        @endif

                        <div class="venue-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ $venue->venue_name }}</a></h4>
                            <span class="category">{{ $venue->venue_capacity }} pax</span>
                        </div>

                        <ul>
                            <li> 
                                <span class="venue-details">
                                    {{ Str::limit($venue->venue_details, 60, '...') }}
                                </span>
                            </li>
                        </ul>

                        <div class="main-button">
                            @if($venue->status == 'active')
                                <a href="{{ route('booking.show', $venue->id) }}">Book Now</a>
                            @else
                                <a href="javascript:void(0)" class="btn btn-secondary disabled">Unavailable</a>
                            @endif
                            <a href="javascript:void(0)" 
                            class="btn btn-info full-info-btn" 
                            data-bs-toggle="modal" 
                            data-bs-target="#venueInfoModal"
                            data-name="{{ $venue->venue_name }}"
                            data-description="{{ $venue->venue_description }}"
                            data-details="{{ $venue->venue_details }}"
                            data-capacity="{{ $venue->venue_capacity }}"
                            data-guest-price="{{ $venue->guest_price }}"
                            data-member-price="{{ $venue->member_price }}"
                            data-notes="{{ $venue->venue_notes }}">
                            Full Info
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Venue Info Modal -->
        <div class="modal fade" id="venueInfoModal" tabindex="-1" aria-labelledby="venueInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <h4 id="venueName" class="text-dark fw-semibold mb-2"></h4>
                        <p id="venueDescription" class="text-muted mb-3"></p>

                        <ul class="list-unstyled">
                            <li><strong>Details:</strong> <span id="venueDetails"></span></li>
                            <li><strong>Capacity:</strong> <span id="venueCapacity"></span> pax</li>
                            <li><strong>Notes:</strong> <span id="venueNotes"></span></li>
                        </ul>

                        <!-- Pricing Table -->
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>Guest Price</th>
                                        <th>Member Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>₱<span id="guestPrice"></span></td>
                                        <td>₱<span id="memberPrice"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success w-30" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- Pagination -->
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-center">
                {{ $venues->onEachSide(1)->links('pagination::custom') }} 
            </div>
        </div>

        <!-- Floating Help Button -->
        <button id="helpButton" class="btn btn-success help-button" data-bs-toggle="modal" data-bs-target="#helpModal"
            data-bs-toggle="tooltip" data-bs-placement="left" title="Guide on How to use the Facilities Page.">
            <i class="fas fa-question-circle"></i>
        </button>

        <!-- Help Modal -->
        <div class="modal fade" id="helpModal" tabindex="-1" aria-labelledby="helpModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="helpModalLabel">Facilities Page Guide</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <h5 class="section-title">📌 Categories & Filtering</h5>
                        <p class="mb-3">Venues are categorized based on their proximity. Click on a category to filter the venues.</p>

                        <h5 class="section-title">📌 Booking a Venue</h5>
                        <p class="mb-3">Each venue card has two options:</p>
                        <ul class="guide-list">
                            <li><strong>Full Info:</strong> View complete details about the venue.</li>
                            <li><strong>Book Now:</strong> Proceed to the reservation process.</li>
                        </ul>

                        <h5 class="section-title">📌 Reservation Process</h5>
                        <p class="mb-3">After selecting a venue, clicking <strong>Book Now</strong> will take you to the reservation form where you can provide booking details.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery for Filtering -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
    $('.properties-filter a').on('click', function (e) {
        e.preventDefault();

        $('.properties-filter a').removeClass('is_active');
        $(this).addClass('is_active');

        let category = $(this).data('filter');

        if (category === '*') {
            category = ''; // Show all venues
        }

        $('.properties-box').fadeOut(300, function () {
            $.ajax({
                url: "{{ route('facilities.index') }}",
                method: "GET",
                data: { category: category },
                success: function (response) {
                    let venuesHtml = '';

                    if (response.venues.length > 0) {
                        response.venues.forEach(venue => {
                            let categoryName = venue.categories ? venue.categories.name.toLowerCase().replace(/ /g, '-') : 'uncategorized';

                            venuesHtml += `
                                <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items ${categoryName}">
                                    <div class="item venue-card">
                                        <a href="#">
                                            <img src="${venue.cover_photo ? '/storage/' + venue.cover_photo : ''}" alt="Cover Photo" class="venue-card img-fluid">
                                        </a>
                                        <div class="venue-header d-flex justify-content-between align-items-center">
                                            <h4 class="mb-0">${venue.venue_name}</h4>
                                            <span class="category">${venue.venue_capacity} pax</span>
                                        </div>
                                        <ul>
                                            <li> 
                                                <span class="venue-details">${venue.venue_details.substring(0, 60)}...</span>
                                            </li>
                                        </ul>
                                        <div class="main-button">
                                            ${venue.status === 'active' 
                                                ? `<a href="/booking/${venue.id}" class="btn btn-primary">Book Now</a>` 
                                                : `<a href="javascript:void(0)" class="btn btn-secondary disabled">Unavailable</a>`
                                            }
                                            <a href="javascript:void(0)" 
                                                class="btn btn-info full-info-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#venueInfoModal"
                                                data-name="${venue.venue_name}"
                                                data-description="${venue.venue_description}"
                                                data-details="${venue.venue_details}"
                                                data-capacity="${venue.venue_capacity}"
                                                data-guest-price="${venue.guest_price}"
                                                data-member-price="${venue.member_price}"
                                                data-notes="${venue.venue_notes}">
                                                Full Info
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        // ✅ Show pagination only if venues exist
                        $('#paginationContainer').removeClass('hidden');

                    } else {
                        venuesHtml = '<p class="text-center w-100">No venues found for this category.</p>';

                        // ❌ Hide pagination if no venues are found
                        $('#paginationContainer').addClass('hidden');
                    }

                    // Update content
                    $('.properties-box').html(venuesHtml).fadeIn(300);

                    // ✅ Adjust height dynamically
                    adjustContainerHeight();
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    });

    function adjustContainerHeight() {
        let propertiesBox = $('.properties-box');
        let venueItems = $('.properties-items');

        if (venueItems.length > 0) {
            let rowHeight = venueItems.first().outerHeight(true);
            let numRows = Math.ceil(venueItems.length / 3); // Assuming 3 columns per row
            let totalHeight = rowHeight * numRows + 50; // Add extra padding

            propertiesBox.css('min-height', totalHeight + 'px');
        } else {
            propertiesBox.css('min-height', '300px'); // Set a default when no items exist
        }
    }
});

    document.addEventListener("DOMContentLoaded", function () {
    const venueInfoModal = document.getElementById('venueInfoModal');

    venueInfoModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget; // Button that triggered the modal

      // Extract data attributes from the button
      const venueName = button.getAttribute('data-name');
      const venueDescription = button.getAttribute('data-description');
      const venueDetails = button.getAttribute('data-details');
      const venueCapacity = button.getAttribute('data-capacity');
      const guestPrice = button.getAttribute('data-guest-price');
      const memberPrice = button.getAttribute('data-member-price');
      const venueNotes = button.getAttribute('data-notes');

      // Populate the modal with the extracted data
      document.getElementById('venueName').textContent = venueName;
      document.getElementById('venueDescription').textContent = venueDescription;
      document.getElementById('venueDetails').textContent = venueDetails;
      document.getElementById('venueCapacity').textContent = venueCapacity;
      document.getElementById('guestPrice').textContent = parseFloat(guestPrice).toFixed(2);
      document.getElementById('memberPrice').textContent = parseFloat(memberPrice).toFixed(2);
      document.getElementById('venueNotes').textContent = venueNotes;
    });
  });

  //floating button
  
</script>

<style>
.full-info-btn:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); 
}
.properties-items {
    display: flex;
    flex-wrap: wrap;
    align-items: stretch; 
}
.properties-items .item {
    height: 100%; 
    display: flex;
    flex-direction: column;
    justify-content: space-between; 
    background: #fff; 
    border-radius: 10px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    padding: 20px;
}
.venue-card img {
    width: 100%; 
    height: 250px; 
    object-fit: cover; 
    border-radius: 10px; 
}
.main-button {
    margin-top: auto; 
}
.venue-card {
    width: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%; /* Ensures all venue cards are the same height */
    min-height: 150px; /* Adjust as needed */
}

.venue-card:hover {
    box-shadow: 0 0 15px rgba(0, 250, 0, 0.5); 
    transform: scale(1.05);
}

.venue-card:hover img {
    filter: brightness(1.1);
}
.venue-card:hover img {
    transform: scale(1.1);
}
.modal.fade .modal-dialog {
    transform: translateY(-10px);
    opacity: 0;
    transition: all 0.2s ease-in-out;
}

.modal.show .modal-dialog {
    transform: translateY(0);
    opacity: 1;
}
.modal-content {
    border-radius: 8px;
}
.modal-header {
    border-bottom: 1px solid #ddd;
}
.list-unstyled li {
    padding: 4px 0;
}
#bookNowBtn {
    font-size: 16px;
    padding: 10px;
}
.table {
    font-size: 16px;
    border-radius: 8px;
}

.table thead {
    background: #f8f9fa;
    font-weight: bold;
}
.properties-box {
    min-height: 1000px; /* Adjust as needed */
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.properties-box.fade-out {
    opacity: 0;
}
#paginationContainer {
    margin-top: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Hide pagination when no venues are found */
#paginationContainer.hidden {
    display: none;
}

/* Floating Help Button (Bottom Left) */
.help-button {
    position: fixed;
    bottom: 20px;
    left: 20px;  /* Moved to the left */
    z-index: 1000;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    background-color: #28a745; /* Green */
    color: white;
    border: none;
    transition: transform 0.2s ease-in-out, background 0.3s ease-in-out;
}

.help-button:hover {
    transform: scale(1.1);
    background: #218838; /* Slightly darker green */
}
.modal-body {
        padding: 20px;
    }

    .section-title {
        margin-bottom: 10px;
        margin-top: 10px;
        font-weight: bold;
    }

    .guide-list {
        padding-left: 20px;
        margin-bottom: 20px;
    }

    .guide-list li {
        margin-bottom: 10px;
    }
    /* Position modal above the floating button */
/* Position the modal above the floating button */
#helpModal .modal-dialog {
    position: fixed;
    bottom: 80px; /* Adjust this value to set the distance above the button */
    left: 20px; /* Align with the floating button */
    transform: translateY(0);
    width: 320px; /* Adjust modal width if necessary */
    max-width: 90%; /* Ensures it doesn't overflow on smaller screens */
}

/* Responsive Adjustment */
@media (max-width: 768px) {
    #helpModal .modal-dialog {
        bottom: 100px; /* Increase space for smaller screens */
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
    }
}
/* Make the modal backdrop lighter */
.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.2) !important; /* Adjust the last value (0.2) for transparency */
}


</style>


