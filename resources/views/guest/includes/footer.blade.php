 <footer class="bg-footer py-5">
     <div class="container">
         <div class="row">
             <div class="col-lg-8">
                 <img src="{{ asset('assets/images/logo.png') }}" alt="" class="logo-dark" height="44" />
                 <p class="text-muted mt-4">Hyper makes it easier to build better websites with
                     <br> great speed. Save hundreds of hours of design
                     <br> and development by using it.
                 </p>

                 <ul class="social-list list-inline mt-3">
                     <li class="list-inline-item text-center">
                         <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i
                                 class="mdi mdi-facebook"></i></a>
                     </li>
                     <li class="list-inline-item text-center">
                         <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                                 class="mdi mdi-google"></i></a>
                     </li>
                     <li class="list-inline-item text-center">
                         <a href="javascript: void(0);" class="social-list-item border-info text-info"><i
                                 class="mdi mdi-twitter"></i></a>
                     </li>
                     <li class="list-inline-item text-center">
                         <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i
                                 class="mdi mdi-github"></i></a>
                     </li>
                 </ul>

             </div>

             <div class="col-lg-2 mt-3 mt-lg-0">
                 <h5 class="text-light">Company</h5>

                 <ul class="list-unstyled ps-0 mb-0 mt-3">
                     <li class="mt-2"><a href="{{ route('about-us') }}" class="text-muted">About Us</a></li>
                     <li class="mt-2"><a href="{{ route('services') }}" class="text-muted">Our Services</a></li>
                     <li class="mt-2"><a href="{{ route('contact-us') }}" class="text-muted">Contact Us</a></li>
                     <li class="mt-2"><a href="{{ route('register') }}" class="text-muted">Get Started</a></li>
                 </ul>

             </div>


             <div class="col-lg-2 mt-3 mt-lg-0">
                 <h5 class="text-light">Discover</h5>

                 <ul class="list-unstyled ps-0 mb-0 mt-3">
                     <li class="mt-2"><a href="{{ route('frequently-asked-questions') }}" class="text-muted">FAQ's</a>
                     </li>
                     <li class="mt-2"><a href="{{ route('privacy-policy') }}" class="text-muted">Privacy Policy</a>
                     </li>
                     <li class="mt-2"><a href="{{ route('cookies-policy') }}" class="text-muted">Cookies Policy</a>
                     </li>
                     <li class="mt-2"><a href="{{ route('terms-and-conditions') }}" class="text-muted">Terms &
                             Conditions</a></li>
                 </ul>
             </div>
         </div>

         <div class="row">
             <div class="col-lg-12">
                 <div class="mt-5">
                     <p class="text-muted mt-4 text-center mb-0">{{ __('Copyright © 2025 Event Dynamics India Pvt Ltd. All rights reserved.') }}</p>
                 </div>
             </div>
         </div>
     </div>
 </footer>
