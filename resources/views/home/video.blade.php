<div class="video-section">
    <div class="container text-center">
        <div class="video-container">
            <iframe 
                width="100%" 
                height="500" 
                src="https://www.youtube.com/embed/L1XSWpXFWd4?autoplay=1&mute=1" 
                title="YouTube video player" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
            </iframe>
        </div>
    </div>
</div>
<style>
.video-section {
    padding: 50px 0;
    background-color: #FFFFFF; /* Dark green color */
    color: #fff; /* White text for contrast */
}

.video-container {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
    height: 0;
    overflow: hidden;
    background-color: #000; /* Optional: Background color inside the video container */
    border-radius: 10px; /* Optional: Rounded corners */
}

.video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}
</style>
