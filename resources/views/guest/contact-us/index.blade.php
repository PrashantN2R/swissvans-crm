@extends('layouts.guest')
@section('title', 'Contact Hyper | Get in Touch with IT Solutions Experts')
@section('og-title', 'Contact Hyper | Get in Touch with IT Solutions Experts')
@section('meta-desc',
    'Reach out to Hyper for inquiries, support, or to discuss your IT project. Our team is ready to
    provide expert solutions in software development, cloud services, and cybersecurity.')
@section('og-desc',
    'Reach out to Hyper for inquiries, support, or to discuss your IT project. Our team is ready to
    provide expert solutions in software development, cloud services, and cybersecurity.')
@section('og-type', 'website')
@section('meta-keywords',
    'Hyper IT company contact, IT support, software development inquiries, cloud solutions
    contact, cybersecurity support, IT consulting contact, technology solutions inquiries')
@section('head')
    <link href="{{ asset('assets/js/plugins/intl-tel-input/css/intlTelInput.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <section class="hero-section hero-sm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="mt-md-4">
                        <h2 class="text-white fw-normal mb-2 hero-title">
                            Contact Us
                        </h2>
                        <p class="mb-3 font-16 text-white-50">Have questions? Our team is ready to assist you.</p>
                    </div>
                </div>
                <div class="col-md-5 offset-md-2 d-none d-md-block">
                    <div class="text-md-end mt-3 mt-md-0">
                        <img src="{{ asset('assets/images/contact-us.svg') }}" alt="" class="img-fluid" />
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
                        <h3>Get In <span class="text-primary">Touch</span></h3>
                        <p class="mt-2">Please fill out the following form and we will get back to you shortly.
                            For more
                            <br>information please contact us.
                        </p>
                    </div>
                </div>
            </div>
            @include('customer.includes.flash-message')
            <div class="row align-items-center mt-3">
                <div class="col-md-4">
                    <p><span class="fw-bold">Customer Support:</span><br> <span class="d-block mt-1">+1 234 56 7894</span>
                    </p>
                    <p class="mt-4"><span class="fw-bold">Email Address:</span><br> <span
                            class="d-block mt-1">info@gmail.com</span></p>
                    <p class="mt-4"><span class="fw-bold">Office Address:</span><br> <span class="d-block mt-1">4461 Cedar
                            Street Moro, AR 72368</span></p>
                    <p class="mt-4"><span class="fw-bold">Office Time:</span><br> <span class="d-block mt-1">9:00AM To
                            6:00PM</span></p>
                </div>

                <div class="col-md-8">

                    <form action="{{ route('contact-us.save') }}" method="POST">
                        @csrf
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <div class="mb-2">
                                    <label for="fullname" class="form-label">Your Name</label>
                                    <input class="form-control form-control-light" type="text" id="fullname"
                                        name="name" value="{{ old('name') }}" placeholder="Name...">
                                    @error('name')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <select id="country" class="d-none" name="iso2">
                                <option value="">Select Country</option>
                            </select>
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label for="emailaddress" class="form-label">Your Email</label>
                                    <input class="form-control form-control-light" type="email" name="email"
                                        value="{{ old('email') }}" id="emailaddress" placeholder="Enter you email...">
                                    @error('email')
                                        <span id="email-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-2">
                                    <label for="phone" class="form-label">Your Phone</label>
                                    <input class="form-control form-control-light" type="text" name="phone"
                                        value="{{ old('phone') }}" id="phone" placeholder="Enter you phone...">
                                    <input id="dial-code" name="dialcode" type="hidden">
                                    @error('phone')
                                        <span id="phone-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-lg-12">
                                <div class="mb-2">
                                    <label for="subject" class="form-label">Your Subject</label>
                                    <input class="form-control form-control-light" type="text" id="subject"
                                        name="subject" value="{{ old('subject') }}" placeholder="Enter subject...">
                                    @error('subject')
                                        <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-lg-12">
                                <div class="mb-2">
                                    <label for="comments" class="form-label">Message</label>
                                    <textarea id="comments" rows="4" class="form-control form-control-light"
                                        placeholder="Type your message here..." name="message">{{ old('message') }}</textarea>
                                    @error('message')
                                        <span id="message-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">Send a Message <i
                                        class="mdi mdi-telegram ms-1"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/plugins/intl-tel-input/js/intlTelInput.min.js') }}"></script>
    <script>
        var countryData = window.intlTelInputGlobals.getCountryData(),
            input = document.querySelector("#phone"),
            dialCode = document.querySelector("#dial-code");
        countryDropdown = document.querySelector("#country");

        for (var i = 0; i < countryData.length; i++) {
            var country = countryData[i];
            var optionNode = document.createElement("option");
            optionNode.value = country.iso2;
            var textNode = document.createTextNode(country.name);
            optionNode.appendChild(textNode);
            countryDropdown.appendChild(optionNode);
        }

        var iti = window.intlTelInput(input, {
            initialCountry: "{{ old('iso2', 'IN') }}",
            utilsScript: "{{ asset('assets/js/plugins/intl-tel-input/js/utils.js') }}"
        });

        dialCode.value = '+' + iti.getSelectedCountryData().dialCode;
        countryDropdown.value = iti.getSelectedCountryData().iso2;

        input.addEventListener('countrychange', function(e) {
            dialCode.value = '+' + iti.getSelectedCountryData().dialCode;
            countryDropdown.value = iti.getSelectedCountryData().iso2;
        });

        countryDropdown.addEventListener('change', function() {
            iti.setCountry(this.value);
        });
    </script>
@endpush
