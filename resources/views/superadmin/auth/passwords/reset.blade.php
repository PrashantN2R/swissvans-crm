<!DOCTYPE html>
<html lang="en">

<head>
    <title>Reset Password | Superadmin</title>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- SEO Meta -->
    <meta name="description" content="Your project description here." />
    <meta name="keywords" content="keyword1, keyword2, keyword3" />

    <!-- Open Graph / Facebook -->
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Your Project Title" />
    <meta property="og:description" content="Your project description here." />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="Your Site Name" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Your Project Title" />
    <meta name="twitter:description" content="Your project description here." />

    <link rel="canonical" href="{{ url()->current() }}" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{ asset('assets/css/app-dark.css') }}" rel="stylesheet" type="text/css" id="dark-style" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />


</head>

<body class="authentication-bg" data-layout-config='{"darkMode":false}'>

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-5 col-lg-6">
                    <div class="card">

                        <div class="card-header pt-3 pb-3 text-center bg-white">
                            <a href="index.html">
                                <span><img src="{{ asset('assets/images/logos/logo.png') }}" alt="logo"
                                        height="44"></span>
                            </a>
                        </div>

                        <div class="card-body p-4">
                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 fw-bold">{{ __('Reset Password') }}</h4>
                            </div>
                            <form method="POST" action="{{ route('superadmin.password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('Email address') }}</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                        value="{{ old('email') }}" name="email" id="email" autocomplete="email"
                                        autofocus placeholder="Enter your email">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">

                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Enter your password" name="password"
                                            autocomplete="current-password">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">

                                    <label for="password-confirm"
                                        class="form-label">{{ __('Confirm Password') }}</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password-confirm" class="form-control"
                                            placeholder="Confirm your password" name="password_confirmation">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 mb-0 text-center d-grid">
                                    <button class="btn btn-primary" type="submit"> {{ __('Reset Password') }}
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <footer class="footer footer-alt text-white">
        {{ __('Copyright © 2026 Swiss Vans. All rights reserved.') }}
    </footer>

    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

</body>

</html>
