@extends('layouts.guest')
@section('title', 'Hyper Terms and Conditions | Website & IT Services Usage')
@section('og-title', 'Hyper Terms and Conditions | Website & IT Services Usage')
@section('meta-desc', 'Read Hyper’s Terms and Conditions to understand the rules, guidelines, and responsibilities for using our IT services, including software development, cloud solutions, and cybersecurity.')
@section('og-desc', 'Read Hyper’s Terms and Conditions to understand the rules, guidelines, and responsibilities for using our IT services, including software development, cloud solutions, and cybersecurity.')
@section('og-type', 'website')
@section('meta-keywords', 'Hyper IT terms and conditions, website terms, software development terms, cloud services terms, cybersecurity terms, IT consulting usage, Hyper IT services guidelines')
@section('content')
    <section class="hero-section hero-sm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="mt-md-4">
                        <h2 class="text-white fw-normal mb-2 hero-title">
                            Terms & Conditions
                        </h2>
                        <p class="mb-3 font-16 text-white-50">Read our Terms and Conditions to know your rights and obligations.</p>
                    </div>
                </div>
                <div class="col-md-5 offset-md-2 d-none d-md-block">
                    <div class="text-md-end mt-3 mt-md-0">
                        <img src="{{ asset('assets/images/terms-and-conditions.svg') }}" alt="" class="img-fluid" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="mb-4">Terms and Conditions</h2>
                    <p>
                        Welcome to <strong>Hyper</strong>. By accessing or using our website and services, you agree to
                        comply with
                        and be bound by these Terms and Conditions. Please read them carefully before using our website.
                    </p>

                    <h4 class="mt-4">1. Use of Website</h4>
                    <p>
                        You agree to use our website and services for lawful purposes only. You must not engage in any
                        activity
                        that could harm the website, compromise security, or interfere with other users’ access and
                        experience.
                    </p>

                    <h4 class="mt-4">2. Intellectual Property</h4>
                    <p>
                        All content on the Hyper website, including text, graphics, logos, images, and software, is the
                        property
                        of Hyper or its content suppliers and is protected by intellectual property laws. You may not
                        reproduce,
                        modify, or distribute any content without our prior written consent.
                    </p>

                    <h4 class="mt-4">3. Services</h4>
                    <p>
                        Hyper provides a range of IT services, including software development, cloud solutions, IT
                        consulting,
                        cybersecurity, and mobile application development. While we strive for accuracy, we do not guarantee
                        that our services will meet all specific requirements or be error-free.
                    </p>

                    <h4 class="mt-4">4. Limitation of Liability</h4>
                    <p>
                        Hyper shall not be held liable for any direct, indirect, incidental, or consequential damages
                        arising
                        from the use or inability to use our website or services. Users agree to use our website and
                        services
                        at their own risk.
                    </p>

                    <h4 class="mt-4">5. Privacy</h4>
                    <p>
                        Your use of our website is also governed by our <a href="/privacy-policy">Privacy Policy</a> and
                        <a href="/cookies-policy">Cookies Policy</a>, which explain how we collect and use your information.
                    </p>

                    <h4 class="mt-4">6. Third-Party Links</h4>
                    <p>
                        Our website may include links to third-party websites. Hyper is not responsible for the content,
                        privacy policies, or practices of these external websites. Use of third-party sites is at your own
                        risk.
                    </p>

                    <h4 class="mt-4">7. Modifications</h4>
                    <p>
                        Hyper reserves the right to modify these Terms and Conditions at any time. Changes will be effective
                        immediately upon posting on the website. We encourage users to review this page periodically for
                        updates.
                    </p>

                    <h4 class="mt-4">8. Governing Law</h4>
                    <p>
                        These Terms and Conditions are governed by and construed in accordance with the laws of the
                        jurisdiction
                        where Hyper operates. Any disputes arising from these terms will be subject to the exclusive
                        jurisdiction
                        of the courts in that jurisdiction.
                    </p>

                    <p class="mt-4">
                        By using Hyper’s website and services, you acknowledge that you have read, understood, and agreed to
                        these Terms and Conditions.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
