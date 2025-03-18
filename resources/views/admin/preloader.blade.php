<!-- ***** Preloader Start ***** -->
<div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
</div>
<!-- ***** Preloader End ***** -->

<style>
/* Fullscreen Preloader */
.js-preloader {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.98); /* Deep dark background */
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 1;
  visibility: visible;
  z-index: 9999;
  transition: opacity 0.3s ease, visibility 0.3s ease;
}

/* Hide preloader when loaded */
.js-preloader.loaded {
  opacity: 0;
  visibility: hidden;
  pointer-events: none;
}

/* Preloader Inner Container */
.preloader-inner {
  position: relative;
  width: 150px;
  height: 40px;
  background: transparent;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Main Sliding Dot */
.preloader-inner .dot {
  position: absolute;
  width: 18px;
  height: 18px;
  background: #00ff66; /* Neon green main dot */
  border-radius: 50%;
  animation: slideDot 2.5s infinite ease-in-out;
}

/* Group of Small Dots */
.preloader-inner .dots {
  display: flex;
  gap: 14px;
  animation: smallDots 2.5s infinite ease-in-out;
}

/* Small Dots Style */
.preloader-inner .dots span {
  width: 14px;
  height: 14px;
  background: #2ea44f; /* Dark green dots */
  border-radius: 50%;
  animation: bounceDots 1.5s infinite alternate ease-in-out;
}

/* Animations */
@keyframes slideDot {
  0% { transform: translateX(0); }
  50% { transform: translateX(100px); }
  100% { transform: translateX(0); }
}

@keyframes smallDots {
  0% { transform: translateX(0); }
  50% { transform: translateX(-30px); }
  100% { transform: translateX(0); }
}

@keyframes bounceDots {
  0% { transform: translateY(0); opacity: 1; }
  50% { transform: translateY(-10px); opacity: 0.7; }
  100% { transform: translateY(0); opacity: 1; }
}
</style>

<script>
  window.addEventListener("load", function () {
    document.getElementById("js-preloader").classList.add("loaded");
  });
</script>
