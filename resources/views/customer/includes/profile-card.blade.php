<li class="dropdown notification-list">
    <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" id="topbar-userdrop"
        href="#" role="button" aria-haspopup="true" aria-expanded="false">
        <span class="account-user-avatar">
            <img src="{{ isset(Auth::user()->avatar_path) ? Auth::user()->avatar_path : 'https://placehold.co/150x150/E3E1FF/0266DA?text=' . Auth::user()->initials }}"
                alt="user-image" class="rounded-circle">
        </span>
        <span>
            <span class="account-user-name">{{ Auth::user()->fullname }}</span>
            <span class="account-position">
                Customer
            </span>
        </span>
    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown"
        aria-labelledby="topbar-userdrop">
        <!-- item-->
        <div class="dropdown-header noti-title">
            <h4 class="text-overflow text-primary m-0">Welcome !</h4>
        </div>

        <!-- item-->
        <a href="{{ route('customer.home') }}" class="dropdown-item notify-item">

            <span>Dashboard</span>
        </a>
        <a href="{{ route('customer.my-account.edit', Auth::user()->id) }}" class="dropdown-item notify-item">

            <span>My Profile</span>
        </a>

        <!-- item-->
        <a href="{{ route('customer.password.form') }}" class="dropdown-item notify-item">

            <span>Change Password</span>
        </a>

        <!-- item-->
        <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            class="dropdown-item notify-item">

            <span>Logout</span>
        </a>

        <form id="logout-form"
            action="{{ 'App\Models\User' == Auth::getProvider()->getModel() ? route('logout') : route('logout') }}"
            method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>

    </div>
</li>
