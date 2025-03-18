@php
    use Illuminate\Support\Str;
@endphp

<div class="properties section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 offset-lg-4">
                <div class="section-heading text-center">
                    <h6>| Top Venues</h6>
                    <h2>Our Facilities</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($venues as $venue)
                <div class="col-lg-4 col-md-6">
                    <div class="item">
                        <!-- Display venue cover photo -->
                        @if($venue->cover_photo)
                            <a href="{{ route('booking.show', $venue->id) }}"><img src="{{ asset('storage/' . $venue->cover_photo) }}" alt="Cover Photo"></a>
                        @else
                            <p>No cover photo available</p>
                        @endif

                        <div class="venue-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><a href="{{ route('booking.show', $venue->id) }}">{{ $venue->venue_name }}</a></h4>
                            <span class="category">{{ $venue->venue_capacity }} pax</span>
                        </div>
                        
                        <ul>
                            <li> 
                                <span class="venue-details">
                                    {{ Str::limit($venue->venue_details, 53, '...') }}
                                </span>
                            </li>
                        </ul>

                        <!--<p><strong>Bookings:</strong> {{ $venue->reservations_count }}</p>  Display booking count -->

                        <div class="main-button">
                            <a href="{{ route('booking.show', $venue->id) }}">Book Now</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const headings = document.querySelectorAll(".section-heading h6, .section-heading h2");

    const observer = new IntersectionObserver(
        function (entries) {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("show"); // Add animation when visible
                } else {
                    entry.target.classList.remove("show"); // Remove when out of view
                }
            });
        },
        { threshold: 0.3 } // Animation triggers when 30% of the element is visible
    );

    headings.forEach((heading) => {
        heading.classList.add("hidden"); // Initially hidden
        observer.observe(heading);
    });
});

</script>


<style>
.properties {
    background-color: #f9f9f9; /* Light gray background */
    padding: 50px 0; /* Add padding for spacing */
}

.section-heading {
    margin-bottom: 30px;
}

.item {
    background-color: #ffffff; /* White background for individual venue cards */
    border: 1px solid #ddd; /* Border for each card */
    border-radius: 10px; /* Rounded corners */
    padding: 20px;
    margin-bottom: 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Default shadow */
    transition: all 0.3s ease; /* Smooth transition for hover effects */
}

.item:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* Deeper shadow on hover */
    transform: translateY(-5px); /* Slightly lift the card on hover */
    background-color: #f8f8f8; /* Optional: Slightly change background color on hover */
}

/* For the image inside the card */
.item img {
    border-radius: 10px; /* Match border radius of the card */
    transition: transform 0.3s ease; /* Smooth zoom-in effect for the image */
}

.item:hover img {
    transform: scale(1.05); /* Slightly zoom in the image on hover */
}
/* Default state (hidden, outside viewport) */
.hidden {
    opacity: 0;
    transform: translateX(-100px); /* Move from left */
    transition: all 0.8s ease-out;
}

/* Appears from left when visible */
.show {
    opacity: 1;
    transform: translateX(0);
}
</style>

