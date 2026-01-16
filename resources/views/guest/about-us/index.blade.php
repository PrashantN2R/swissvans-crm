@extends('layouts.guest')
@section('title', 'About Hyper | Innovative IT Solutions | Software Development & Cloud Services')
@section('og-title', 'About Hyper | Innovative IT Solutions | Software Development & Cloud Services')
@section('meta-desc', 'Learn about Hyper, a leading IT company delivering software development, cloud solutions, cybersecurity, and IT consulting services to empower businesses worldwide.')
@section('og-desc', 'Learn about Hyper, a leading IT company delivering software development, cloud solutions, cybersecurity, and IT consulting services to empower businesses worldwide.')
@section('og-type', 'website')
@section('meta-keywords', 'Hyper IT company, software development, cloud solutions, cybersecurity, IT consulting, mobile app development, technology solutions, digital transformation, IT services')
@section('content')
    <section class="hero-section hero-sm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="mt-md-4">
                        <h2 class="text-white fw-normal mb-2 hero-title">
                            About Us
                        </h2>
                        <p class="mb-3 font-16 text-white-50">Your trusted IT partner—delivering technology that drives
                            efficiency, innovation, and sustainable business growth.</p>
                    </div>
                </div>
                <div class="col-md-5 offset-md-2 d-none d-md-block">
                    <div class="text-md-end mt-3 mt-md-0">
                        <img src="{{ asset('assets/images/about-us.svg') }}" alt="" class="img-fluid"
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
                        <h1 class="mt-0"><i class="mdi mdi-infinity"></i></h1>
                        <p class="mt-2">At Hyper, we believe technology has the power to transform businesses and create
                            meaningful impact. Since our inception, our mission has been to deliver innovative, reliable,
                            and future-ready IT solutions that help organizations thrive in the digital age.</p>
                        <p>We specialize in software development, cloud solutions, IT consulting, cybersecurity, mobile app
                            development, data analytics, artificial intelligence (AI) & machine learning (ML), enterprise
                            solutions, DevOps, digital transformation, and managed IT services. By combining deep technical
                            expertise with a strong understanding of business needs, we deliver solutions that are both
                            innovative and practical. Our approach is simple yet powerful—listening to our clients,
                            understanding their challenges, and crafting tailored strategies that drive measurable results.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="text-center p-3">
                        <div class="avatar-sm m-auto">
                            <span class="avatar-title bg-primary-lighten rounded-circle">
                                <i class="uil uil-award text-primary font-24"></i>
                            </span>
                        </div>
                        <h4 class="mt-3">Proven Expertise</h4>
                        <p class="mt-2 mb-0">Our certified professionals bring years of hands-on experience
                            across industries and technologies.</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="text-center p-3">
                        <div class="avatar-sm m-auto">
                            <span class="avatar-title bg-primary-lighten rounded-circle">
                                <i class="uil uil-cog text-primary font-24"></i>
                            </span>
                        </div>
                        <h4 class="mt-3">Tailored Solutions</h4>
                        <p class="mt-2 mb-0">We design customized IT strategies aligned with your unique business
                            goals and challenges.</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="text-center p-3">
                        <div class="avatar-sm m-auto">
                            <span class="avatar-title bg-primary-lighten rounded-circle">
                                <i class="uil uil-lightbulb-alt text-primary font-24"></i>
                            </span>
                        </div>
                        <h4 class="mt-3">Innovation-Driven</h4>
                        <p class="mt-2 mb-0">By embracing the latest technologies, we deliver future-ready and
                            scalable IT solutions.</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="text-center p-3">
                        <div class="avatar-sm m-auto">
                            <span class="avatar-title bg-primary-lighten rounded-circle">
                                <i class="uil uil-headphones text-primary font-24"></i>
                            </span>
                        </div>
                        <h4 class="mt-3">Reliable Support</h4>
                        <p class="mt-2 mb-0">Our dedicated support team ensures smooth operations with minimal
                            downtime.</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="text-center p-3">
                        <div class="avatar-sm m-auto">
                            <span class="avatar-title bg-primary-lighten rounded-circle">
                                <i class="uil uil-shield-check text-primary font-24"></i>
                            </span>
                        </div>
                        <h4 class="mt-3">Security First</h4>
                        <p class="mt-2 mb-0">We prioritize data protection and compliance to keep your business
                            safe and secure.</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="text-center p-3">
                        <div class="avatar-sm m-auto">
                            <span class="avatar-title bg-primary-lighten rounded-circle">
                                <i class="uil uil-users-alt text-primary font-24"></i>
                            </span>
                        </div>
                        <h4 class="mt-3">Client-Centric Approach</h4>
                        <p class="mt-2 mb-0">We focus on building long-term partnerships by delivering measurable
                            value and growth.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 bg-light-lighten border-top border-bottom border-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="avatar-sm m-auto mb-3">
                        <span class="avatar-title bg-primary-lighten rounded-circle">
                            <i class="mdi mdi-rocket-launch-outline text-primary font-24"></i>
                        </span>
                    </div>
                    <h4 class="card-title mb-3">Our Mission</h4>
                    <p class="card-text">
                        To empower businesses through technology by delivering scalable, efficient,
                        and secure IT solutions. We aim to simplify complexities, drive innovation,
                        and build sustainable growth paths for organizations of all sizes.
                        Our mission is not just about solving today’s challenges but preparing
                        our clients for the opportunities of tomorrow.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 bg-light-lighten border-top border-bottom border-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="avatar-sm m-auto mb-3">
                        <span class="avatar-title bg-success-lighten rounded-circle">
                            <i class="mdi mdi-eye-outline text-success font-24"></i>
                        </span>
                    </div>
                    <h4 class="card-title mb-3">Our Vision</h4>
                    <p class="card-text">
                        To be recognized as a trusted global IT partner, leading businesses through
                        digital transformation and innovation. We envision a future where technology
                        empowers organizations to operate smarter, adapt faster, and create lasting
                        value. Our vision is to foster a connected, sustainable, and intelligent digital
                        ecosystem that benefits businesses, communities, and industries worldwide.
                        By anticipating trends, embracing emerging technologies, and maintaining
                        unwavering dedication to excellence, we aim to shape a smarter and more
                        resilient future for our clients and partners.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
