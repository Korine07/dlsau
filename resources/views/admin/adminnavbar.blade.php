<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
    <div class="navbar-brand-wrapper d-flex align-items-center">

        <!-- Centered logo relative to sidebar -->
        <div class="d-flex flex-grow-1 justify-content-center">
            <a class="navbar-brand brand-logo" href="{{url('dashboard')}}">
                <img src="admin/assets/images/DLSAU.png" alt="logo" />
            </a>
        </div>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-top">
        <ul class="navbar-nav navbar-title">
            <li class="nav-item fw-semibold d-none d-lg-block ms-0">
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <a class="nav-link d-flex align-items-center" id="UserDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <!-- Profile Photo -->
                    @if(Auth::check())
                        <img class="img-xs rounded-circle me-2" src="{{ Auth::user()->profile_photo_url }}" alt="User Profile">
                        <span class="fw-bold">{{ Auth::user()->username }}</span>
                    @else
                        <img class="img-xs rounded-circle me-2" src="{{ asset('default-profile.png') }}" alt="Default Profile">
                        <span class="fw-bold">Guest</span>
                    @endif
                    <i class="mdi mdi-chevron-down ms-2"></i> <!-- Dropdown Icon -->
                </a>
                <ul class="dropdown-menu dropdown-menu-end navbar-dropdown" aria-labelledby="UserDropdown">
                    <li class="dropdown-header text-center">
                        <!-- Profile Photo -->
                        @if(Auth::check())
                            <img class="img-fluid rounded-circle mb-2" 
                                src="{{ Auth::user()->profile_photo_url }}" 
                                style="width: 50px; height: 50px; object-fit: cover;" 
                                alt="User Profile">
                        @else
                            <img class="img-fluid rounded-circle mb-2" 
                                src="{{ asset('default-profile.png') }}" 
                                style="width: 50px; height: 50px; object-fit: cover;" 
                                alt="Default Profile">
                        @endif

                        <!-- Display Username & Email -->
                        @if(Auth::check())
                            <p class="mb-0 fw-bold">{{ Auth::user()->username }}</p>
                            <p class="text-muted small">{{ Auth::user()->email }}</p>
                        @else
                            <p class="mb-0 fw-bold">Guest</p>
                            <p class="text-muted small">Not logged in</p>
                        @endif
                    </li>

                    @if(Auth::check())
                        <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="mdi mdi-account-outline text-primary me-2"></i> Profile</a></li>

                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <li><a class="dropdown-item" href="{{ route('api-tokens.index') }}"><i class="mdi mdi-key-variant text-primary me-2"></i> API Tokens</a></li>
                        @endif

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item"><i class="mdi mdi-power text-primary me-2"></i> Log Out</button>
                            </form>
                        </li>
                    @endif
                </ul>
            </li>
        </ul>
    </div>
</nav>
