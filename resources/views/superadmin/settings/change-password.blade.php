@extends('layouts.superadmin')
@section('title', 'Change Password | Superadmin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">

                    </div>
                    <h4 class="page-title">Change Password</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Settings</li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('superadmin.includes.flash-message')
                <form action="{{ route('superadmin.change-password') }}" method="POST">
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
                                            class="form-control bg-transparent" aria-describedby="currentPasswordError" />
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
                                        <input type="password" placeholder="Please enter new password" name="new_password"
                                            id="new_password" autocomplete="off" class="form-control bg-transparent"
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
