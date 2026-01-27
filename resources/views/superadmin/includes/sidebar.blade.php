<div class="leftside-menu">
    <!-- LOGO -->
    <a href="{{ route('superadmin.dashboard') }}" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logos/logo.png') }}" alt="" height="44">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo_sm.png') }}" alt="" height="44">
        </span>
    </a>

    <!-- LOGO -->
    <a href="{{ route('superadmin.dashboard') }}" class="logo text-center logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logos/logo.png') }}" alt="" height="44">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo_sm_dark.png') }}" alt="" height="44">
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav">
            <li class="side-nav-item">
                <a href="{{ route('superadmin.dashboard') }}" class="side-nav-link">
                    <i class="bi bi-speedometer2"></i><span>Dashboard</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('superadmin.leads.index') }}" class="side-nav-link">
                    <i class="bi bi-rocket"></i><span>Lead Management</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('superadmin.tasks.index') }}" class="side-nav-link">
                    <i class="bi bi-list-task"></i><span>Task Management</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('superadmin.quotations.index') }}" class="side-nav-link">
                    <i class="bi bi-receipt"></i><span>Quotations</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('superadmin.vehicles.index') }}" class="side-nav-link">
                    <i class="bi bi-car-front"></i><span>Vehicle Management</span>
                </a>
            </li>



            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#vehicle-management" aria-expanded="false"
                    aria-controls="vehicle-management" class="side-nav-link">
                    <i class="bi bi-sliders"></i>
                    <span>Vehicle Settings</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="vehicle-management">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('superadmin.manufacturers.index') }}"
                                class="dropdown-item">Manufacturers</a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.models.index') }}" class="dropdown-item">Models</a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.derivatives.index') }}" class="dropdown-item">Variants</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#user-management" aria-expanded="false"
                    aria-controls="user-management" class="side-nav-link">
                    <i class="bi bi-person-workspace"></i>
                    <span>User Management</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="user-management">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('superadmin.users.index') }}" class="dropdown-item">Users</a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.roles.index') }}" class="dropdown-item">Roles</a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.permissions.index') }}" class="dropdown-item">Permissions</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="settings"
                    class="side-nav-link">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="settings">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="{{ route('superadmin.my-account.edit', Auth::user()->id) }}"
                                class="dropdown-item">My
                                Profile</a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.password.form') }}" class="dropdown-item">Change Password</a>
                        </li>

                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
