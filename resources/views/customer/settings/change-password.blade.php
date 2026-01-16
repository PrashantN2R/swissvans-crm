@extends('layouts.guest')
@section('title', 'Hyper Change Password | Securely Update Your IT Account Password')
@section('og-title', 'Hyper Change Password | Securely Update Your IT Account Password')
@section('meta-desc', 'Change your Hyper account password securely to maintain access to your IT solutions dashboard, manage services, and protect your personal information.')
@section('og-desc', 'Change your Hyper account password securely to maintain access to your IT solutions dashboard, manage services, and protect your personal information.')
@section('og-type', 'website')
@section('meta-keywords', 'Hyper change password, update IT account password, software development account security, cloud solutions password update, cybersecurity account protection, Hyper IT services account security')
@section('content')
    <section class="hero-section hero-sm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="mt-md-4">
                        <h2 class="text-white fw-normal mb-2 hero-title">
                            Change Password
                        </h2>
                        <p class="mb-3 font-16 text-white-50">Keep your account secure by updating your password regularly.
                        </p>
                    </div>
                </div>
                <div class="col-md-5 offset-md-2">
                    <div class="text-md-end mt-3 mt-md-0">
                        <img src="{{ asset('assets/images/change-password.svg') }}" alt="" class="img-fluid"
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
                    @include('customer.includes.flash-message')
                    <form action="{{ route('customer.change-password') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                {{-- Current password starts here --}}
                                <div class="row mb-2">
                                    <label class="col-lg-3 form-label" for="current_password">
                                        <span class="required">Current password</span>
                                        <span class="ms-1" data-bs-toggle="tooltip"
                                            aria-label="Please enter your current password"
                                            data-bs-original-title="Please enter your current password">
                                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span>
                                    </label>

                                    <div class="col-lg-9 fv-row fv-plugins-icon-container">
                                        <div class="input-group">
                                            <input type="password" placeholder="Please enter your current password"
                                                name="current_password" id="current_password" autocomplete="off"
                                                class="form-control bg-transparent"
                                                aria-describedby="currentPasswordError" />
                                            <span class="input-group-text" onclick="toggleCurrentPasswordVisibility()"><span
                                                    class="password-eye"></span></span>

                                        </div>
                                        @error('current_password')
                                            <div class="invalid-feedback" id="currentPasswordError">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- Current password ends here --}}

                                {{-- New password starts here --}}
                                <div class="row mb-2">
                                    <label class="col-lg-3 form-label" for="new_password">
                                        <span class="required">New password</span>
                                        <span class="ms-1" data-bs-toggle="tooltip"
                                            aria-label="Please enter your new password"
                                            data-bs-original-title="Please enter your new password">
                                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span>
                                    </label>

                                    <div class="col-lg-9 fv-row fv-plugins-icon-container">
                                        <div class="input-group">
                                            <input type="password" placeholder="Please enter new password"
                                                name="new_password" id="new_password" autocomplete="off"
                                                class="form-control bg-transparent"
                                                aria-describedby="currentPasswordError" />
                                            <span class="input-group-text" onclick="toggleNewPasswordVisibility()"><span
                                                    class="password-eye"></span></span>

                                        </div>
                                        @error('new_password')
                                            <div class="invalid-feedback" id="currentPasswordError">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- New password ends here --}}

                                {{-- Confirm password starts here --}}
                                <div class="row mb-2">
                                    <label class="col-lg-3 form-label" for="new_password_confirmation">
                                        <span class="required">Confirm password</span>
                                        <span class="ms-1" data-bs-toggle="tooltip"
                                            aria-label="Please re-enter your new password"
                                            data-bs-original-title="Please re-enter your new password">
                                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span>
                                    </label>

                                    <div class="col-lg-9 fv-row fv-plugins-icon-container">
                                        <div class="input-group">
                                            <input type="password" placeholder="Please re-enter new password"
                                                name="new_password_confirmation" id="new_password_confirmation"
                                                autocomplete="off" class="form-control bg-transparent"
                                                aria-describedby="currentPasswordError" />
                                            <span class="input-group-text"
                                                onclick="toggleNewPasswordConfirmationVisibility()"><span
                                                    class="password-eye"></span></span>

                                        </div>
                                    </div>
                                </div>
                                {{-- Confirm password ends here --}}

                                {{-- Update button starts here --}}
                                <div class="row">
                                    <div class="col-sm-12 text-end">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <span class="indicator-label">Update Password</span>
                                        </button>
                                    </div>
                                </div>
                                {{-- Update button ends here --}}
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
        function toggleCurrentPasswordVisibility() {
            const passwordInput = document.getElementById('current_password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';

            } else {
                passwordInput.type = 'password';

            }
        }
    </script>
    <script>
        function toggleNewPasswordVisibility() {
            const passwordInput = document.getElementById('new_password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';

            } else {
                passwordInput.type = 'password';

            }
        }
    </script>
    <script>
        function toggleNewPasswordConfirmationVisibility() {
            const passwordInput = document.getElementById('new_password_confirmation');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';

            } else {
                passwordInput.type = 'password';

            }
        }
    </script>
@endpush
