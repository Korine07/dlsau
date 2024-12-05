<div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="{{url('calendar')}}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Calendar</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('categories')}}">
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                <span class="menu-title">Categories</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('members')}}">
                <i class="mdi mdi-account-group menu-icon"></i>
                <span class="menu-title">Members</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="mdi mdi-calendar-check menu-icon"></i>
                <span class="menu-title">Reservations</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="pending">Pending Reservation</a></li>
                  <li class="nav-item"> <a class="nav-link" href="confirm">Confirm Reservation</a></li>
                  <li class="nav-item"> <a class="nav-link" href="completed">Completed Reservation</a></li>
                  <li class="nav-item"> <a class="nav-link" href="cancel">Cancel Reservation</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="services">
                <i class="mdi mdi-tools menu-icon"></i>
                <span class="menu-title">Services</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="setup">
                <i class="mdi mdi-tune menu-icon"></i>
                <span class="menu-title">Setup</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="users">
                <i class="menu-icon mdi mdi-floor-plan"></i>
                <span class="menu-title">Users</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                <i class="menu-icon mdi mdi-table"></i>
                <span class="menu-title">Venues</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="{{url('venues/create')}}">Create Venue</a></li>
                  <li class="nav-item"><a class="nav-link" href="{{url('venue_list')}}">Venue List</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                <i class="mdi mdi-file-chart menu-icon"></i>
                <span class="menu-title">Reports</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="reservation-list">Reservation List</a></li>
                  <li class="nav-item"> <a class="nav-link" href="payment-list">Payment List</a></li>
                  <li class="nav-item"> <a class="nav-link" href="service-list">Service List</a></li>
                </ul>
              </div>
            </li>
          </ul>
        </nav>

