<!-- Map Section Before Footer -->
<div class="map-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="map-container">
                    <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3859.7311346594247!2d120.99598627634417!3d14.67119378582355!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b6a2b78fd96f%3A0xf64909861b56b1b9!2sDe%20La%20Salle%20Araneta%20University!5e0!3m2!1sen!2sph!4v1732618328991!5m2!1sen!2sph" width="100%" height="500px" frameborder="0" style="border:0; border-radius: 10px; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15);"                    width="100%"
                        height="350"
                        style="border:0; border-radius: 10px;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Back to Top Button -->
<button id="backToTop" class="back-to-top">
    <i class="fas fa-arrow-up"></i>
</button>


<!-- Footer -->
<footer>
    <div class="container">
      <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
            <p>Copyright © 2024 All rights reserved.
          </div>
      </div>
    </div>
</footer>

<!-- Scripts -->
<!-- Bootstrap core JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/isotope.min.js"></script>
<script src="assets/js/owl-carousel.js"></script>
<script src="assets/js/counter.js"></script>
<script src="assets/js/custom.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const backToTopButton = document.getElementById("backToTop");

    // Show or Hide the button when scrolling
    window.addEventListener("scroll", function () {
        if (window.scrollY > 300) { // Show button after scrolling 300px
            backToTopButton.classList.add("show");
        } else {
            backToTopButton.classList.remove("show");
        }
    });

    // Scroll to top when the button is clicked
    backToTopButton.addEventListener("click", function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth" // Smooth scrolling effect
        });
    });
});
</script>


<style>
/* Map Section Styling */
.map-section {
    background-color: #f9f9f9;
    padding: 50px 0;
}

.map-container {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}
/* Back to Top Button */
.back-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background-color: #ffffff; 
    color: green;
    border: none;
    border-radius: 50px;
    width: 50px;
    height: 50px;
    font-size: 20px;
    cursor: pointer;
    display: none; 
    justify-content: center;
    align-items: center;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    transition: opacity 0.3s ease-in-out;
}

.back-to-top:hover {
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3); /* Increase shadow */
}

/* Show button when scrolling */
.back-to-top.show {
    display: flex;
    opacity: 1;
}

</style>
