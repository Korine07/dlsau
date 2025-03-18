<button id="backToTop" class="back-to-top">
    <i class="fas fa-arrow-up"></i>
</button>

  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/counter.js"></script>
  <script src="assets/js/custom.js"></script>

  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>

  <script>
document.addEventListener("DOMContentLoaded", function () {
    const backToTopButton = document.getElementById("backToTop");

    // Show or Hide the button when scrolling
    window.addEventListener("scroll", function () {
        if (window.scrollY > 200) { // Show button after scrolling 300px
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
    display: none; /* Initially hidden */
    justify-content: center;
    align-items: center;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    transition: opacity 0.3s ease-in-out;
}
.back-to-top:hover {
  box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3); /* Increase shadow */
}
.back-to-top.show {
    display: flex;
    opacity: 1;
}

</style>