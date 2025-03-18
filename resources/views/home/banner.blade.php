<div class="main-banner">
    <div class="owl-carousel owl-banner">
        <!-- First Item -->
        <div class="item item-1" style="background-image: url('assets/images/banner1.JPG');">
            <div class="header-text">
                <span class="category">Welcome, <em>Lasallians!</em></span>
                <h2>Experience the Best Facilities</h2>
            </div>
        </div>

        <!-- Second Item -->
        <div class="item item-2" style="background-image: url('assets/images/banner2.JPG');">
            <div class="header-text">
                <span class="category">Welcome, <em>Lasallians!</em></span>
                <h2>Your Events, Our Venues</h2>
            </div>
        </div>

        <!-- Third Item -->
        <div class="item item-3" style="background-image: url('assets/images/banner3.JPG');">
            <div class="header-text">
                <span class="category">Welcome, <em>Lasallians!</em></span>
                <h2>Book With Ease</h2>
            </div>
        </div>

        <!-- Fourth Item -->
        <div class="item item-4" style="background-image: url('assets/images/banner4.JPG');">
            <div class="header-text">
                <span class="category">Welcome, <em>Lasallians!</em></span>
                
            </div>
        </div>

        <!-- Fifth Item -->
        <div class="item item-5" style="background-image: url('assets/images/banner5.JPG');">
            <div class="header-text">
                <span class="category">Welcome, <em>Lasallians!</em></span>
                
            </div>
        </div>
    </div>
    <!-- Next/Previous Buttons 
    <button class="custom-prev">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="custom-next">
        <i class="fas fa-chevron-right"></i>
    </button>-->
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Owl Carousel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
    $(document).ready(function(){
        var owl = $(".owl-banner").owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            smartSpeed: 800,
            dots: false,
            nav: false,
        });

        // Custom navigation buttons
        $(".custom-prev").click(function () {
            owl.trigger("prev.owl.carousel");
        });

        $(".custom-next").click(function () {
            owl.trigger("next.owl.carousel");
        });
    });
</script>


<style>
.item-1, .item-2, .item-3, .item-4, .item-5 {
    background-size: cover;
    background-position: center;
    height: 87vh; /* Full height for banner */
    transition: none !important; /* Disable transitions */
    transform: none !important;  /* Disable any transform effects */
}

.header-text {
    color: white; /* Adjust text color for readability */
    
    padding: 20px;
    position: relative;
    top: 50%;
    transform: translateY(-50%);
    transition: none !important; /* Disable transitions on text */
}

.item:hover {
    transition: none !important; /* Ensure no hover transitions */
    transform: none !important;  /* Prevent scaling or moving on hover */
}
.custom-prev, .custom-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.5);
    border: none;
    color: white;
    font-size: 24px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
    transition: 0.3s ease;
    z-index: 1000;
}

.custom-prev {
    left: 20px;
}

.custom-next {
    right: 20px;
}

.custom-prev:hover, .custom-next:hover {
    background: rgba(0, 0, 0, 0.8);
}

</style>
