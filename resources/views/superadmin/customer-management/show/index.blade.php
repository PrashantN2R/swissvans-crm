@extends('layouts.superadmin')
@section('title', 'Show Customer | Superadmin')
@section('head')
    <link href="{{ asset('assets/js/plugins/intl-tel-input/css/intlTelInput.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark"><i
                                class="bi bi-arrow-left me-1"></i>Back</a>
                        <button type="submit" class="btn btn-sm btn-primary" form="superadminForm"><i
                                class="bi bi-floppy me-1"></i>Update</button>
                    </div>
                    <h4 class="page-title">Show Customer</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Customer Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.customers.index') }}">Customers</a></li>
                        <li class="breadcrumb-item active">Show Customer</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                    <li class="nav-item">
                        <a href="#contact-details" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link rounded-0 active">
                            <span>Customer Details</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#notes" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                            <span>Customer Notes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#linked-vehicles" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                            <span>Linked Vehicles</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#linked-sales" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                            <span>Linked Sales</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">

                    @include('superadmin.customer-management.show.contact-details')

                    @include('superadmin.customer-management.show.notes')

                    @include('superadmin.customer-management.show.linked-vehicles')

                    @include('superadmin.customer-management.show.linked-sales')

                </div>
            </div>
        </div>
    </div>
@endsection
