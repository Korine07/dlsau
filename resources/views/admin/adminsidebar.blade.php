<div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="{{url('dashboard')}}">
                <i class="mdi mdi-view-dashboard menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
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
            <!--<li class="nav-item">
              <a class="nav-link" href="{{url('members')}}">
                <i class="mdi mdi-account-group menu-icon"></i>
                <span class="menu-title">Members</span>
              </a>
            </li>-->
            <li class="nav-item">
              <a class="nav-link toggle-dropdown">
                <i class="mdi mdi-calendar-check menu-icon"></i>
                <span class="menu-title">Reservations</span>
                <i class="mdi mdi-chevron-down menu-arrow"></i>
              </a>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('pending.reservations') }}">Pending reservation</a>
                <li class="nav-item"> <a class="nav-link" href="{{ route('confirmed.reservations') }}">Confirmed Reservation</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('completed.reservations') }}">Completed Reservation</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('cancelled.reservations') }}">Cancelled Reservation</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('archived.reservations') }}">Archived Reservation</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('services')}}">
                <i class="mdi mdi-tools menu-icon"></i>
                <span class="menu-title">Services</span>
              </a>
            </li>
            <!--<li class="nav-item">
              <a class="nav-link" href="setup">
                <i class="mdi mdi-tune menu-icon"></i>
                <span class="menu-title">Setup</span>
              </a>
            </li>-->
            <li class="nav-item">
              <a class="nav-link" href="users">
                <i class="menu-icon mdi mdi-floor-plan"></i>
                <span class="menu-title">Users</span>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link toggle-dropdown">
                <i class="menu-icon mdi mdi-table"></i>
                <span class="menu-title">Venues</span>
                <i class="mdi mdi-chevron-down menu-arrow"></i>
              </a>
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"><a class="nav-link" href="{{url('venues')}}">Create Venue</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('venue_list')}}">Venue List</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link toggle-dropdown">
                <i class="mdi mdi-file-chart menu-icon"></i>
                <span class="menu-title">Reports</span>
                <i class="mdi mdi-chevron-down menu-arrow"></i>
              </a>
              <ul class="nav flex-column sub-menu">
                <!--<li class="nav-item"> <a class="nav-link" href="{{ route('reservation.list') }}">Reservation List</a></li>-->
                <li class="nav-item"> <a class="nav-link" href="{{ route('venue.reservation.list') }}">Venue Reservation List</a></li>
                <!--<li class="nav-item"> <a class="nav-link" href="{{ route('reservation.archived') }}">Archived List</a></li>-->
                <li class="nav-item"> <a class="nav-link" href="{{ route('services.list') }}">Service List</a></li>
              </ul>
            </li>
          </ul>
        </nav>

        <script>
    document.addEventListener("DOMContentLoaded", function () {
        var dropdowns = document.querySelectorAll(".toggle-dropdown");

        dropdowns.forEach(function (dropdown) {
            dropdown.addEventListener("click", function () {
                var submenu = this.nextElementSibling;
                var arrow = this.querySelector(".menu-arrow");

                submenu.classList.toggle("open");
                arrow.classList.toggle("rotate");

                // Save open/closed state in localStorage
                var menuTitle = this.querySelector(".menu-title").innerText;
                var isOpen = submenu.classList.contains("open");
                localStorage.setItem(menuTitle, isOpen);
            });
        });

        // Function to highlight active menu items
        function highlightActiveLinks() {
            var currentUrl = window.location.pathname; // Get only the path without domain
            var links = document.querySelectorAll(".nav-link");

            links.forEach(function (link) {
                var linkPath = new URL(link.href, window.location.origin).pathname; // Get only the path

                if (linkPath === currentUrl) {
                    link.classList.add("active");

                    // If this is a submenu item, open the parent dropdown correctly
                    var parentSubMenu = link.closest(".sub-menu");
                    if (parentSubMenu) {
                        parentSubMenu.classList.add("open");
                        parentSubMenu.previousElementSibling.classList.add("active");
                        parentSubMenu.previousElementSibling.querySelector(".menu-arrow").classList.add("rotate");
                    }
                }
            });
        }

        // Highlight active links on page load
        highlightActiveLinks();

        // Restore menu state from localStorage
        dropdowns.forEach(function (dropdown) {
            var menuTitle = dropdown.querySelector(".menu-title").innerText;
            var isOpen = localStorage.getItem(menuTitle) === "true";
            if (isOpen) {
                dropdown.nextElementSibling.classList.add("open");
                dropdown.querySelector(".menu-arrow").classList.add("rotate");
            }
        });
    });
</script>




<style>
  .container-fluid {
    background: #ffffff;
  }
  
  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 220px; /* Ensure it matches navbar width */
    height: 100vh; /* Full height */
    background: #ffffff;
    font-family: "Manrope", sans-serif;
    font-weight: 500;
    padding-top: 97px; /* Push down to match navbar */
    z-index: 11;
    box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.1);
}

.sidebar .nav {
    padding-left: 10px;
    list-style: none;
}

.sidebar .nav-item {
    margin-bottom: 10px;
}

.sidebar .nav-link {
    color: #333;
    padding: 10px 15px;
    display: flex;
    align-items: center;
    transition: 0.3s ease-in-out;
    cursor: pointer;
}

.sidebar .nav-link:hover {
    background: rgba(40, 167, 69, 0.2); /* Slightly darker green */
    color: #28a745; /* Bootstrap Green */
    border-radius: 5px;
}

.sidebar .sub-menu {
    display: none;
    padding-left: 20px;
    margin-top: 5px;
}

.sidebar .sub-menu.open {
  display: block;
}

.sidebar .sub-menu .nav-item .nav-link {
    padding: 8px 15px;
    display: flex;
    align-items: center;
    transition: all 0.3s ease-in-out;
    border-radius: 20px; /* Make both sides rounded */
}

.sidebar .nav-link.active {
    color: #087830 !important;
    font-weight: bold !important;
    border-radius: 5px;
}
.sidebar .sub-menu .nav-item .nav-link.active {
    color: #087830 !important;
    font-weight: bold !important;
    border-radius: 20px;
}
.menu-arrow {
        transition: transform 0.3s ease-in-out;
    }

    .menu-arrow.rotate {
        transform: rotate(180deg);
    }

</style>