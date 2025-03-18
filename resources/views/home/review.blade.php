<div class="parallax-section">
  <div class="content">
    <h3>Celebrate, Connect, and Create at DLSAU.</h3>
    <h1>Faith, zeal, and community – the foundation of a true Lasallian.</h1>
    <a href="{{url('facilities')}}" class="cta-button">Book Now</a>
  </div>
</div>

<style>
/* Parallax Section */
.parallax-section {
  background-image: url('/assets/images/review-bg.JPG'); 
  background-attachment: fixed; /* Creates the parallax effect */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  height: 100vh; /* Full-screen height */
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  color: white;
  position: relative;
}

/* Content inside the parallax section */
.parallax-section .content {
  z-index: 2;
}

.parallax-section h3 {
  font-size: 18px;
  margin-bottom: 10px;
  font-weight: normal;
  color: #ffffff; /* Change font color for the h3 element */
}

.parallax-section h1 {
  font-size: 32px;
  margin-bottom: 20px;
  color: #ffffff; /* Change font color for the h1 element */
}

.parallax-section .cta-button {
  background-color: #028A0F;
  color: white;
  text-decoration: none;
  padding: 10px 20px;
  border-radius: 5px;
  font-size: 16px;
  font-weight: bold;
}

.parallax-section .cta-button:hover {
  background-color: #0BDA51;
  color: white;
}

/* Optional: Add a semi-transparent overlay */
.parallax-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5); /* Adjust opacity for the overlay */
  z-index: 1;
}
</style>
