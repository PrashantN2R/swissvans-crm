@extends('layouts.guest')
@section('title', 'Hyper Profile | Manage Your IT Solutions Account')
@section('og-title', 'Hyper Profile | Manage Your IT Solutions Account')
@section('meta-desc', 'Access and manage your Hyper account profile to update personal information, track your IT projects, and customize your services securely.')
@section('og-desc', 'Access and manage your Hyper account profile to update personal information, track your IT projects, and customize your services securely.')
@section('og-type', 'website')
@section('meta-keywords', 'Hyper profile, IT account management, software development account, cloud solutions profile, cybersecurity account settings, Hyper IT services dashboard')
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
                            My Profile
                        </h2>
                        <p class="mb-3 font-16 text-white-50">Manage your profile, preferences, and account settings all in
                            one place.</p>
                    </div>
                </div>
                <div class="col-md-5 offset-md-2">
                    <div class="text-md-end mt-3 mt-md-0">
                        <img src="{{ asset('assets/images/my-profile.svg') }}" alt="" class="img-fluid"
                            style="max-width: 75%" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 bg-light-lighten border-top border-bottom border-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @include('customer.includes.flash-message')
                    <form id="superadminForm" method="POST" action="{{ route('customer.my-account.update', $admin->id) }}"
                        enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <h4 class="text-dark">Personal Details</h4>
                                    </div>
                                    <div class="col-lg-6 mb-2 {{ $errors->has('firstname') ? 'has-error' : '' }}">
                                        <label class="form-label" for="firstname">First Name</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname"
                                            placeholder="Enter First Name"
                                            value="{{ old('firstname', $admin->firstname) }}">
                                        @error('firstname')
                                            <span id="firstname-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb-2 {{ $errors->has('lastname') ? 'has-error' : '' }}">
                                        <label class="form-label" for="lastname">Last Name</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname"
                                            placeholder="Enter Last Name" value="{{ old('lastname', $admin->lastname) }}">
                                        @error('lastname')
                                            <span id="lastname-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb-2 {{ $errors->has('email') ? 'has-error' : '' }}">
                                        <label class="form-label" for="email">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Enter Email Address" value="{{ old('email', $admin->email) }}">
                                        @error('email')
                                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb-2 {{ $errors->has('phone') ? 'has-error' : '' }}">
                                        <label class="form-label" for="phone">Phone Number</label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            placeholder="Enter Phone Number" value="{{ old('phone', $admin->phone) }}">
                                        @error('phone')
                                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        <input id="dial-code" name="dialcode" type="hidden"
                                            value="{{ isset($admin) ? $admin->dialcode : '' }}">
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label class="form-label" for="gender">{{ __('Gender') }}</label>

                                        <select id="gender" class="form-select" name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="Male"
                                                {{ old('gender', $admin->gender) == 'Male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="Female"
                                                {{ old('gender', $admin->gender) == 'Female' ? 'selected' : '' }}>Female
                                            </option>
                                        </select>

                                        @error('gender')
                                            <span id="gender-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb-2">
                                        <label class="form-label" for="statuses">{{ __('Status') }}</label>

                                        <select id="statuses" class="form-select" name="status">
                                            <option value="">Select Status</option>
                                            <option value="1"
                                                {{ old('status', $admin->status) == 1 ? 'selected' : '' }}>
                                                Enable</option>
                                            <option value="0"
                                                {{ old('status', $admin->status) == 0 ? 'selected' : '' }}>
                                                Disable</option>
                                        </select>

                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6">
                                        <label class="form-label" for="avatar">Profile Picture</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="avatar" name="avatar"
                                                onchange="loadPreview(this);">
                                        </div>
                                        @if ($errors->has('avatar'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('avatar') }}</strong>
                                            </span>
                                        @endif
                                        <img id="preview_img" src="{{ $admin->avatar }}" class="mt-2" width="100"
                                            height="100" />
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="card mb-5 mb-xl-10">
                            <div class="card-body border-top p-9">
                                <div class="row">
                                    <div class="col-lg-12 mb-2">
                                        <h4 class="text-dark">Contact Details</h4>
                                    </div>
                                    <div class="col-lg-6 mb-2 {{ $errors->has('address') ? 'has-error' : '' }}">
                                        <label class="form-label" for="address">Address</label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            placeholder="Enter Address" value="{{ old('address', $admin->address) }}">
                                        @error('address')
                                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-2 {{ $errors->has('city') ? 'has-error' : '' }}">
                                        <label class="form-label" for="city">City</label>
                                        <input type="text" class="form-control" id="city" name="city"
                                            placeholder="Enter City" value="{{ old('city', $admin->city) }}">
                                        @error('city')
                                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-2 {{ $errors->has('state') ? 'has-error' : '' }}">
                                        <label class="form-label" for="state">State</label>
                                        <input type="text" class="form-control" id="state" name="state"
                                            placeholder="Enter State" value="{{ old('state', $admin->state) }}">
                                        @error('state')
                                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <label class="form-label" for="country">{{ __('Country') }}</label>

                                        <select id="country" class="form-select" name="iso2">
                                            <option value="">Select Country</option>
                                        </select>

                                        @error('country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6 mb-2 {{ $errors->has('zipcode') ? 'has-error' : '' }}">
                                        <label class="form-label" for="zipcode">Zipcode</label>
                                        <input type="text" class="form-control" id="zipcode" name="zipcode"
                                            placeholder="Enter Zipcode" value="{{ old('zipcode', $admin->zipcode) }}">
                                        @error('zipcode')
                                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12 text-end">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="bi bi-floppy me-1"></i>Update
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        function loadPreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview_img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
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
            initialCountry: "{{ old('iso2', $admin->iso2) }}",
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
