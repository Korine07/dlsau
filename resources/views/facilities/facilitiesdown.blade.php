<div class="section properties">
    <div class="container">
      <ul class="properties-filter">
            @foreach ($categories as $categories)
                <li>
                    <a href="#!" data-filter=".{{ strtolower($categories->name) }}">{{ $categories->name }}</a>
                </li>
            @endforeach
            <li>
              <a class="is_active" href="#!" data-filter="*">Show All</a>
            </li>
        </ul>
        
      </ul>
      <!-- Venues List -->
      <div class="row properties-box">
    @foreach ($venues as $venue)
        <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items">
            <div class="item">
                <!-- Display the cover photo if it exists -->
                <!-- Display the cover photo if it exists -->
@if($venue->cover_photo)
    <!-- Display cover photo -->
    <a href="#">
        <img src="{{ asset('storage/' . $venue->cover_photo) }}" alt="Cover Photo">
    </a>
@else
    <p>No cover photo available</p>
@endif

                <span class="category">{{ $venue->venue_capacity }} pax</span>
                <h4><a href="#">{{ $venue->venue_name }}</a></h4>
                <ul>
                    <li>Details: <span>{{ $venue->venue_details }}</span></li>
                </ul>
                <div class="main-button">
                    <a href="#">Schedule a visit</a>
                    <a href="#">Full Info</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
        
      <div class="row">
        <div class="col-lg-12">
          <ul class="pagination">
            <li><a class="is_active" href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">>></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>