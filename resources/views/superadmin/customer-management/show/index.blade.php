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
                        <a href="#contact-details" data-bs-toggle="tab" aria-expanded="false"
                            class="nav-link rounded-0 active">
                            <i class="mdi mdi-account-details d-md-none d-block"></i>
                            <span class="d-none d-md-block">Contact Details</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#notes" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                            <i class="mdi mdi-notebook-edit d-md-none d-block"></i>
                            <span class="d-none d-md-block">Notes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#linked-vehicles" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                            <i class="mdi mdi-car d-md-none d-block"></i>
                            <span class="d-none d-md-block">Linked Vehicles</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#linked-sales" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                            <i class="mdi mdi-cash-register d-md-none d-block"></i>
                            <span class="d-none d-md-block">Linked Sales</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    @include('superadmin.customer-management.show.contact-details')

                    <div class="tab-pane" id="notes">
                        <h5>Customer Internal Notes</h5>
                        <textarea class="form-control" rows="5" placeholder="Add specific delivery instructions or preferences..."></textarea>
                    </div>

                    <div class="tab-pane" id="linked-vehicles">
                        <div class="alert alert-light border-0">
                            <h5 class="text-muted">Registered Vehicles</h5>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Make/Model</th>
                                        <th>Year</th>
                                        <th>VIN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tesla Model 3</td>
                                        <td>2023</td>
                                        <td><code class="text-uppercase">5yj3e1ea6pf...</code></td>
                                    </tr>
                                </tbody>
                            </table>
                            <small class="text-info">* To edit vehicle details, go to the Inventory Module.</small>
                        </div>
                    </div>

                    <div class="tab-pane" id="linked-sales">
                        <div class="alert alert-light border-0">
                            <h5 class="text-muted">Transaction History</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Invoice #8842 - Completed</span>
                                    <strong>$42,500.00</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Service Order #102 - Pending</span>
                                    <strong>$1,200.00</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
