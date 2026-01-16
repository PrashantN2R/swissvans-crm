@extends('layouts.guest')
@section('title', 'Hyper IT Services | Software Development, Cloud Solutions & Cybersecurity')
@section('og-title', 'Hyper IT Services | Software Development, Cloud Solutions & Cybersecurity')
@section('meta-desc', 'Explore Hyper’s comprehensive IT services including software development, cloud solutions,
    cybersecurity, IT consulting, and mobile app development to drive business growth.')
@section('og-desc', 'Explore Hyper’s comprehensive IT services including software development, cloud solutions,
    cybersecurity, IT consulting, and mobile app development to drive business growth.')
@section('og-type', 'website')
@section('meta-keywords', 'Hyper IT services, software development, cloud solutions, IT consulting, cybersecurity,
    mobile app development, enterprise solutions, AI solutions, digital transformation, managed IT services')
@section('content')
    <section class="hero-section hero-sm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="mt-md-4">
                        <h2 class="text-white fw-normal mb-2 hero-title">
                            Our Services
                        </h2>
                        <p class="mb-3 font-16 text-white-50">Empowering businesses with cutting-edge software, cloud, and
                            consulting solutions.</p>
                    </div>
                </div>
                <div class="col-md-5 offset-md-2 d-none d-md-block">
                    <div class="text-md-end mt-3 mt-md-0">
                        <img src="{{ asset('assets/images/services.svg') }}" alt="" class="img-fluid"
                            style="max-width: 60%" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 bg-light-lighten border-top border-bottom border-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h1 class="mt-0"><i class="mdi mdi-tag-multiple"></i></h1>
                        <h3>Choose Simple <span class="text-primary">Our Services</span></h3>
                        <p class="text-muted mt-2">The clean and well commented code allows easy customization of the
                            theme.It's designed for
                            <br>describing your app, agency or business.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row mt-5 pt-3">
                <div class="col-md-4">
                    <div class="card card-pricing">
                        <div class="card-body text-center">
                            <p class="card-pricing-plan-name fw-bold text-uppercase">Standard License </p>
                            <i class="card-pricing-icon dripicons-user text-primary"></i>
                            <h2 class="card-pricing-price">$49 <span>/ License</span></h2>
                            <ul class="card-pricing-features">
                                <li>10 GB Storage</li>
                                <li>500 GB Bandwidth</li>
                                <li>No Domain</li>
                                <li>1 User</li>
                                <li>Email Support</li>
                                <li>24x7 Support</li>
                            </ul>
                            <button class="btn btn-primary mt-4 mb-2 btn-rounded">Choose Plan</button>
                        </div>
                    </div>
                    <!-- end Pricing_card -->
                </div>
                <!-- end col -->

                <div class="col-md-4">
                    <div class="card card-pricing card-pricing-recommended">
                        <div class="card-body text-center">
                            <div class="card-pricing-plan-tag">Recommended</div>
                            <p class="card-pricing-plan-name fw-bold text-uppercase">Multiple License</p>
                            <i class="card-pricing-icon dripicons-briefcase text-primary"></i>
                            <h2 class="card-pricing-price">$99 <span>/ License</span></h2>
                            <ul class="card-pricing-features">
                                <li>50 GB Storage</li>
                                <li>900 GB Bandwidth</li>
                                <li>2 Domain</li>
                                <li>10 User</li>
                                <li>Email Support</li>
                                <li>24x7 Support</li>
                            </ul>
                            <button class="btn btn-primary mt-4 mb-2 btn-rounded">Choose Plan</button>
                        </div>
                    </div>
                    <!-- end Pricing_card -->
                </div>
                <!-- end col -->

                <div class="col-md-4">
                    <div class="card card-pricing">
                        <div class="card-body text-center">
                            <p class="card-pricing-plan-name fw-bold text-uppercase">Extended License</p>
                            <i class="card-pricing-icon dripicons-store text-primary"></i>
                            <h2 class="card-pricing-price">$599 <span>/ License</span></h2>
                            <ul class="card-pricing-features">
                                <li>100 GB Storege</li>
                                <li>Unlimited Bandwidth</li>
                                <li>10 Domain</li>
                                <li>Unlimited User</li>
                                <li>Email Support</li>
                                <li>24x7 Support</li>
                            </ul>
                            <button class="btn btn-primary mt-4 mb-2 btn-rounded">Choose Plan</button>
                        </div>
                    </div>
                    <!-- end Pricing_card -->
                </div>
                <!-- end col -->

            </div>

        </div>
    </section>
@endsection
