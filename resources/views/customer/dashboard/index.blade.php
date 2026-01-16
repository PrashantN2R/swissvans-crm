@extends('layouts.guest')
@section('title', 'Hyper Dashboard | Manage Your IT Solutions & Services')
@section('og-title', 'Hyper Dashboard | Manage Your IT Solutions & Services')
@section('meta-desc', 'Access your Hyper dashboard to monitor IT projects, manage services, track progress, and stay on
    top of all your IT solutions in one place.')
@section('og-desc', 'Access your Hyper dashboard to monitor IT projects, manage services, track progress, and stay on
    top of all your IT solutions in one place.')
@section('og-type', 'website')
@section('meta-keywords', 'Hyper dashboard, IT account management, software development dashboard, cloud solutions
    tracking, cybersecurity project management, Hyper IT services overview')
@section('content')
    <section class="hero-section hero-sm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="mt-md-4">
                        <h2 class="text-white fw-normal mb-2 hero-title">
                            Your Dashboard
                        </h2>
                        <p class="mb-3 font-16 text-white-50">Overview of your account, performance, and key metrics at a
                            glance.</p>
                    </div>
                </div>
                <div class="col-md-5 offset-md-2">
                    <div class="text-md-end mt-3 mt-md-0">
                        <img src="{{ asset('assets/images/home.svg') }}" alt="" class="img-fluid"
                            style="max-width: 75%" />
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
