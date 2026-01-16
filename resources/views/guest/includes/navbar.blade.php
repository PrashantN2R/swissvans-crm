 <nav class="navbar navbar-expand-lg py-lg-3">
     <div class="container">

         <!-- logo -->
         <a href="{{ route('index') }}" class="navbar-brand me-lg-5">
             <img src="{{ asset('assets/images/logos/logo.png') }}" alt="" class="logo-dark" height="44" />
         </a>

         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
             aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
             <i class="mdi mdi-menu"></i>
         </button>

         <!-- menus -->
         <div class="collapse navbar-collapse" id="navbarNavDropdown">

             <!-- left menu -->
             <ul class="navbar-nav me-auto align-items-center">
                 <li class="nav-item mx-lg-1">
                     <a class="nav-link active" href="{{ route('index') }}">Home</a>
                 </li>
                 <li class="nav-item mx-lg-1">
                     <a class="nav-link" href="{{ route('about-us') }}">About Us</a>
                 </li>
                 <li class="nav-item mx-lg-1">
                     <a class="nav-link" href="{{ route('services') }}">Services</a>
                 </li>
                 <li class="nav-item mx-lg-1">
                     <a class="nav-link" href="{{ route('frequently-asked-questions') }}">FAQs</a>
                 </li>
                 <li class="nav-item mx-lg-1">
                     <a class="nav-link" href="{{ route('contact-us') }}">Contact Us</a>
                 </li>
             </ul>

             <!-- right menu -->
             <ul class="navbar-nav ms-auto align-items-center">
                 @guest
                     <li class="nav-item me-0">
                         @if (Route::has('login'))
                             <a href="{{ route('login') }}" class="nav-link d-lg-none">Login</a>
                         @endif
                         @if (Route::has('register'))
                             <a href="{{ route('register') }}" class="nav-link d-lg-none">Register</a>
                         @endif
                         @if (Route::has('login'))
                             <a href="{{ route('login') }}" class="btn btn-primary d-none d-lg-inline-flex me-1">
                                 Login
                             </a>
                         @endif
                         @if (Route::has('register'))
                             <a href="{{ route('register') }}" class="btn btn-warning d-none d-lg-inline-flex">
                                 Register
                             </a>
                         @endif
                     </li>
                 @else
                     @include('customer.includes.profile-card')
                 @endguest
             </ul>

         </div>
     </div>
 </nav>
