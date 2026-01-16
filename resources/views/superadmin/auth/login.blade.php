<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login | SwissVans Superadmin</title>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="description" content="SwissVans CRM Foundation - Vehicle-First Architecture." />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{ asset('assets/css/app-dark.css') }}" rel="stylesheet" type="text/css" id="dark-style" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />

    <style>
        /* 1. Container setup: Ensure the right side is a 'stage' for the video */
        .auth-fluid-right {
            position: relative;
            padding: 0 !important;
            overflow: hidden;
            /* This crops the 'zoomed' video */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* 2. The Video Background Logic */
        .video-background-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            /* Allows clicks to pass through if needed */
            z-index: 0;
        }

        /* 3. The "Cover" Hack: Ensures no black bars regardless of screen size */
        .video-background-wrapper iframe {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100vw;
            height: 100vh;
            transform: translate(-50%, -50%);
            object-fit: cover;
        }

        /* 4. Ratio adjustment for different screens */
        @media (min-aspect-ratio: 16/9) {
            .video-background-wrapper iframe {
                height: 56.25vw;
                /* (9/16 * 100) */
            }
        }

        @media (max-aspect-ratio: 16/9) {
            .video-background-wrapper iframe {
                width: 177.78vh;
                /* (16/9 * 100) */
            }
        }

        /* 5. Visual Overlay for readability */
        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            /* Darkens video so text pops */
            z-index: 1;
        }

        .auth-user-testimonial {
            position: relative;
            z-index: 2;
            /* Sits above the video and overlay */
        }
    </style>
</head>

<body class="authentication-bg pb-0" data-layout-config='{"darkMode":false}'>

    <div class="auth-fluid">
        <div class="auth-fluid-form-box">
            <div class="align-items-center d-flex h-100">
                <div class="card-body">

                    <div class="auth-brand text-center text-lg-start">
                        <a href="/superadmin" class="logo-dark">
                            <span><img src="{{ asset('assets/images/logos/logo.png') }}" alt="SwissVans"
                                    height="57"></span>
                        </a>
                    </div>

                    <h4 class="mt-0">Sign In</h4>
                    <p class="text-muted mb-4">Enter your credentials to access the SwissVans CRM Foundation.</p>

                    <form action="{{ route('superadmin.login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email"
                                value="{{ old('email', 'admin@admin.com') }}" name="email" id="email"
                                autocomplete="email" autofocus placeholder="Enter your email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <a href="{{ route('superadmin.password.request') }}" class="text-muted float-end">
                                <small>Forgot your password?</small>
                            </a>
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter your password" name="password" autocomplete="current-password"
                                    value="password">
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                        </div>

                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-primary" type="submit">
                                <i class="mdi mdi-login"></i> Log In
                            </button>
                        </div>
                    </form>
                    <footer class="footer footer-alt">
                        <p class="fs-6 mb-0">{{ __('Copyright © 2026 Swiss Vans.') }}</p>
                        <p class="fs-6 mt-0 text-muted">Vehicle-First Architecture</p>
                    </footer>

                </div>
            </div>
        </div>


        <div class="auth-fluid-right">
            <div class="video-background-wrapper">
                <iframe
                    src="https://www.youtube.com/embed/7VryWaaDQTI?autoplay=1&mute=1&controls=0&playsinline=1&loop=1&playlist=7VryWaaDQTI"
                    frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
                </iframe>
            </div>
            <div class="video-overlay"></div>

            <div class="auth-user-testimonial text-center">
                <h4 class="mt-0 fw-light text-white">Welcome Back!<br>

                </h4>
                <h1 class="mt-0 fw-light text-white">
                    <span class="strong h2 welcome-text text-white">SWISSVANS CRM</span>
                </h1>
                <h5 class="text-white-50">Vehicle-First Asset Management & Relationship Ledger</h5>
            </div>
        </div>

    </div>
    </div>
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

</body>

</html>
