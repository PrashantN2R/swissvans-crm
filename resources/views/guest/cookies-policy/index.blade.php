@extends('layouts.guest')
@section('title', 'Hyper Cookies Policy | How We Use Cookies on Our Website')
@section('og-title', 'Hyper Cookies Policy | How We Use Cookies on Our Website')
@section('meta-desc', 'Learn how Hyper uses cookies and tracking technologies to enhance website performance,
    personalize your experience, and provide IT services like software development, cloud solutions, and cybersecurity.')
@section('og-desc', 'Learn how Hyper uses cookies and tracking technologies to enhance website performance, personalize
    your experience, and provide IT services like software development, cloud solutions, and cybersecurity.')
@section('og-type', 'website')
@section('meta-keywords', 'Hyper cookies policy, website cookies, tracking technologies, IT services cookies, software
    development cookies, cloud solutions cookies, cybersecurity cookies, data privacy Hyper')
@section('content')
    <section class="hero-section hero-sm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="mt-md-4">
                        <h2 class="text-white fw-normal mb-2 hero-title">
                            Cookies Policy
                        </h2>
                        <p class="mb-3 font-16 text-white-50">Your privacy matters—here’s how we use cookies on our site.</p>
                    </div>
                </div>
                <div class="col-md-5 offset-md-2 d-none d-md-block">
                    <div class="text-md-end mt-3 mt-md-0">
                        <img src="{{ asset('assets/images/features-2.svg') }}" alt="" class="img-fluid" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="mb-4">Cookies Policy</h2>
                    <p>
                        At <strong>Hyper</strong>, we use cookies and similar technologies to enhance your experience
                        on our website, analyze site performance, and provide personalized content. This Cookies Policy
                        explains
                        how we use these technologies and your options regarding them.
                    </p>

                    <h4 class="mt-4">1. What Are Cookies?</h4>
                    <p>
                        Cookies are small text files stored on your device by your web browser when you visit a website.
                        They
                        help remember your preferences, improve user experience, and provide information about website
                        usage.
                    </p>

                    <h4 class="mt-4">2. Types of Cookies We Use</h4>
                    <p>
                        We may use the following types of cookies:
                    </p>
                    <ul>
                        <li><strong>Essential Cookies:</strong> Necessary for the website to function properly and ensure
                            secure access.</li>
                        <li><strong>Performance Cookies:</strong> Collect anonymous information to help us improve website
                            performance and usability.</li>
                        <li><strong>Functional Cookies:</strong> Remember your preferences, such as language or region
                            settings.</li>
                        <li><strong>Marketing & Analytics Cookies:</strong> Track user behavior for analytics, advertising,
                            and personalized content delivery.</li>
                    </ul>

                    <h4 class="mt-4">3. How We Use Cookies</h4>
                    <p>
                        Cookies allow us to understand how visitors interact with our website, optimize site features,
                        deliver relevant
                        content, and improve our services. They also help in remembering your settings and preferences
                        during future visits.
                    </p>

                    <h4 class="mt-4">4. Third-Party Cookies</h4>
                    <p>
                        We may allow third-party service providers, such as analytics and advertising platforms, to place
                        cookies on
                        our site. These cookies are governed by the respective third-party privacy policies, and we are not
                        responsible
                        for their use of data.
                    </p>

                    <h4 class="mt-4">5. Your Cookie Choices</h4>
                    <p>
                        You can manage or disable cookies through your browser settings at any time. However, please note
                        that
                        disabling certain cookies may affect the functionality and user experience of our website.
                    </p>

                    <h4 class="mt-4">6. Changes to This Cookies Policy</h4>
                    <p>
                        We may update this Cookies Policy from time to time to reflect changes in our practices or legal
                        requirements.
                        We encourage you to review this page periodically for the latest information on how we use cookies.
                    </p>

                    <p class="mt-4">
                        By continuing to use our website, you consent to the use of cookies as described in this policy.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
