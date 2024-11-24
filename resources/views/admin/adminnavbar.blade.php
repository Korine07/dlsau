<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
        
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
              <span class="icon-menu"></span>
            </button>
          </div>
          <div>
            <a class="navbar-brand brand-logo" href="index.html">
              <img src="admin/assets/images/logo.svg" alt="logo" />
            </a>
            <a class="navbar-brand brand-logo-mini" href="index.html">
              <img src="admin/assets/images/logo-mini.svg" alt="logo" />
            </a>
          </div>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-top">
          <ul class="navbar-nav">
            <li class="nav-item fw-semibold d-none d-lg-block ms-0">
              

            </li>
          </ul>
          <ul class="navbar-nav ms-auto">
            
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
              <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  <!-- Profile Photo (Dynamic from Laravel Auth) -->
                  <img class="img-xs rounded-circle" src="{{ Auth::user()->profile_photo_url }}">
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                  <div class="dropdown-header text-center">
                    <!-- Profile Photo for Mobile and Desktop -->
                    <img class="img-md rounded-circle" src="{{ Auth::user()->profile_photo_url }}">
                    
                  </div>

                  <!-- Profile Link -->
                  <a class="dropdown-item" href="{{ route('profile.show') }}">
                      <i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i>Profile
                  </a>

                  <!-- API Tokens (only if Jetstream API features are enabled) -->
                  @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                      <a class="dropdown-item" href="{{ route('api-tokens.index') }}">
                          <i class="dropdown-item-icon mdi mdi-key-variant text-primary me-2"></i>API Tokens
                      </a>
                  @endif

                  <!-- Log Out -->
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item">
                      <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Log Out
                    </button>
                  </form>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
        
      </nav>