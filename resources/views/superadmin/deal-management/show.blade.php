@extends('layouts.superadmin')
@section('title', 'Show Deal | Superadmin')
@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/css/lightgallery-bundle.min.css" />
      <style>
                                .hover-link {
                                    transition: all 0.2s ease;
                                }

                                .hover-link:hover {
                                    color: #0d6efd !important;
                                    transform: translateX(3px);
                                }

                                /* Ensures icons are centered perfectly in the circle */
                                .bi {
                                    line-height: 1;
                                }
                            </style>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e0e0e0;
            border-radius: 10px;
        }

        .bg-soft-secondary {
            background-color: #f8f9fa;
        }
    </style>
    <style>
        /* Custom styling for your vehicle scrollbar */
        #vehicle-gallery::-webkit-scrollbar {
            height: 5px;
        }

        #vehicle-gallery::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #vehicle-gallery::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 10px;
        }

        #vehicle-gallery::-webkit-scrollbar-thumb:hover {
            background: #999;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">

        {{-- Header --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark">
                            <i class="bi bi-arrow-left me-1"></i>Back
                        </a>
                    </div>
                    <h4 class="page-title">Show Deal</h4>
                </div>
            </div>
        </div>

        {{-- Flash --}}
        <div class="row">
            <div class="col-12">
                @include('superadmin.includes.flash-message')
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        {{-- Invoice Header --}}
                        <div class="clearfix">
                            <div class="float-start mb-3">
                                <img src="{{ asset('assets/images/logos/logo.png') }}" height="36">
                            </div>
                            <div class="float-end">
                                <h4 class="m-0 d-print-none">Deal</h4>
                            </div>
                        </div>

                        {{-- Deal Info Header --}}
                        <div class="row align-items-center mb-4">
                            <div class="col-sm-7">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-md bg-soft-primary border border-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 60px; height: 60px; background-color: #eef2f7;">
                                        <span class="h4 text-primary fw-bold">{{ $deal->user->initials }}</span>
                                    </div>

                                    <div>
                                        <h4 class="mb-1 fw-bold">Welcome back, {{ $deal->user->name }}!</h4>
                                        <p class="text-muted mb-0">
                                            Reviewing the breakdown for your <span class="text-dark fw-medium">Vehicle
                                                Deal</span>.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="p-3 bg-light rounded-3 mt-3 mt-sm-0">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted small text-uppercase fw-semibold">Deal Number</span>
                                        <span class="fw-bold text-dark">#{{ $deal->deal_number }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted small text-uppercase fw-semibold">Date Created</span>
                                        <span>{{ $deal->created_at->format('d M, Y') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-muted small text-uppercase fw-semibold">Deal Status</span>
                                        @php
                                            $statusClass = match ($deal->status) {
                                                'Completed' => 'bg-success',
                                                'Pending' => 'bg-warning',
                                                'Cancelled' => 'bg-danger',
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }} rounded-pill px-3"
                                            style="font-size:0.875em !important; margin-bottom:0px !important; text-align:center !important">{{ $deal->status }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-2 opacity-50">



                        <div class="row mt-4 g-4">
                            {{-- Customer Details --}}
                            <div class="col-sm-4">
                                <div class="card"
                                    style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border-left: 4px solid #eef2f7 !important;">
                                    <div class="card-body p-2">
                                        <h6
                                            class="text-dark text-uppercase fw-bold mb-3 small d-flex align-items-center">
                                            Customer Profile
                                        </h6>

                                        <div class="d-flex flex-column gap-2">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-dark bg-opacity-10 p-2 rounded-circle me-3 d-flex align-items-center justify-content-center"
                                                    style="width: 35px; height: 35px;">
                                                    <i class="bi bi-person text-white"></i>
                                                </div>
                                                <span
                                                    class="fw-semibold text-dark text-truncate hover-link"><a href="{{ route('superadmin.customers.show', $deal->user->slug) }}" class="text-dark">{{ $deal->user->name }}</a></span>
                                            </div>

                                            <a href="mailto:{{ $deal->user->email }}"
                                                class="text-decoration-none d-flex align-items-center text-muted hover-link">
                                                <div class="bg-dark bg-opacity-10 p-2 rounded-circle me-3 d-flex align-items-center justify-content-center"
                                                    style="width: 35px; height: 35px;">
                                                    <i class="bi bi-envelope text-white"></i>
                                                </div>
                                                <span class="text-muted strong small">{{ $deal->user->email }}</span>
                                            </a>

                                            <a href="tel:+{{ $deal->user->dialcode }} {{ $deal->user->phone }}"
                                                class="text-decoration-none d-flex align-items-center text-muted hover-link">
                                                <div class="bg-dark bg-opacity-10 p-2 rounded-circle me-3 d-flex align-items-center justify-content-center"
                                                    style="width: 35px; height: 35px;">
                                                    <i class="bi bi-telephone text-white"></i>
                                                </div>
                                                <span class="text-muted strong small">{{ $deal->user->dialcode }}
                                                    {{ $deal->user->phone }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            {{-- Vehicle Information & Dynamic Gallery --}}
                            <div class="col-sm-8">
                                <div class="card" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border-left: 4px solid #eef2f7 !important;">
                                    <div class="card-body p-1">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="position-relative overflow-hidden rounded-3 shadow-sm border"
                                                    style="height: 190px;">
                                                    @php $firstImg = $deal->vehicle->images->first()->full_path ?? asset('assets/images/no-car.png'); @endphp
                                                    <img id="main-preview" src="{{ $firstImg }}" class="w-100 h-100"
                                                        style="object-fit: cover; transition: all 0.4s ease-in-out;">

                                                    <div
                                                        style="position: absolute; bottom: 3px; left: 0; right: 0; display: flex; justify-content: center;">
                                                        <div class="deal-plate">
                                                            {{ strtoupper($deal->vehicle->registration) }}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-7 d-flex flex-column">
                                                <h5 class="mb-1 fw-bold text-dark">
                                                    {{ $deal->vehicle->manufacturerData->name }}
                                                    {{ $deal->vehicle->modelData->name }}
                                                </h5>
                                                <p class="mb-2 text-muted">
                                                    <span class="badge bg-dark text-white border me-1 px-2 py-2"
                                                        style="font-size: 0.62rem !important;">{{ $deal->vehicle->variantData->name }}</span>
                                                    <span class="badge bg-soft-primary border me-1 px-2 py-2"
                                                        style="font-size: 0.62rem !important;background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: #ffffff;"><span
                                                            class="strong">Year: </span>{{ $deal->vehicle->year }}</span>
                                                    <span class="badge text-dark border me-1 px-2 py-2"
                                                        style="font-size: 0.62rem !important;background: linear-gradient(145deg, #f2f2f2, #cfcfcf);"><span
                                                            class="strong text-dark">VIN:
                                                        </span>{{ $deal->vehicle->vin }}</span>

                                                </p>

                                                <div id="vehicle-gallery"
                                                    class="d-flex gap-1 overflow-auto pb-2 custom-scrollbar">
                                                    @forelse($deal->vehicle->images as $image)
                                                        <a href="{{ $image->full_path }}" data-lg-size="1600-1067"
                                                            class="flex-shrink-0 gallery-item"
                                                            data-sub-html="<h4>{{ $deal->vehicle->manufacturer }}</h4><p>{{ $image->alt }}</p>">
                                                            <img src="{{ $image->full_path }}" alt="{{ $image->alt }}"
                                                                class="rounded-2 border"
                                                                style="width: 60px; height: 45px; object-fit: cover; cursor: pointer;"
                                                                onmouseover="document.getElementById('main-preview').src='{{ $image->full_path }}'">
                                                        </a>
                                                    @empty
                                                        <div class="text-muted small italic">No images available.</div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- Pricing Table --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table mt-4">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Description</th>
                                                <th class="text-end">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            {{-- SALE --}}
                                            @if ($deal->type === 'Sale')
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <b>Vehicle Sale</b><br>
                                                        {{ $deal->vehicle->manufacturer }}
                                                        {{ $deal->vehicle->model }}
                                                    </td>
                                                    <td class="text-end">
                                                        £{{ number_format($deal->sale_price, 2) }}
                                                    </td>
                                                </tr>
                                            @endif

                                            {{-- BUSINESS LEASE --}}
                                            @if ($deal->type === 'Lease' && $deal->is_business_lease)
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <b>Business Lease</b><br>
                                                        Initial Rental:
                                                        {{ $deal->initial_rental_months }} Months<br>
                                                        Monthly Rental
                                                    </td>
                                                    <td class="text-end">
                                                        £{{ number_format($deal->business_lease_monthly_price, 2) }}
                                                    </td>
                                                </tr>
                                            @endif

                                            {{-- HIRE PURCHASE LEASE --}}
                                            @if ($deal->type === 'Lease' && $deal->is_hire_purchase)
                                                <tr>
                                                    <td>{{ $deal->is_business_lease ? 2 : 1 }}</td>
                                                    <td>
                                                        <b>Hire Purchase Lease</b><br>
                                                        Deposit Paid<br>
                                                        Monthly Instalments
                                                    </td>
                                                    <td class="text-end">
                                                        £{{ number_format($deal->hire_purchase_monthly_price, 2) }}
                                                    </td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- TOTALS --}}
                        <div class="row mt-4">

                            {{-- SALE TOTAL --}}
                            @if ($deal->type === 'Sale')
                                @php
                                    $vatAmount = ($deal->sale_price * $deal->vat) / 100;
                                    $grandTotal = $deal->sale_price + $vatAmount;
                                @endphp

                                <div class="col-sm-6 offset-sm-6">
                                    <p><b>Sub Total:</b>
                                        <span class="float-end">£{{ number_format($deal->sale_price, 2) }}</span>
                                    </p>
                                    <p><b>VAT ({{ $deal->vat }}%):</b>
                                        <span class="float-end">£{{ number_format($vatAmount, 2) }}</span>
                                    </p>
                                    <hr>
                                    <h3>£{{ number_format($grandTotal, 2) }}</h3>
                                </div>
                            @endif

                            {{-- BUSINESS LEASE TOTAL --}}
                            @if ($deal->type === 'Lease' && $deal->is_business_lease)
                                @php
                                    $initialRental = $deal->business_lease_monthly_price * $deal->initial_rental_months;

                                    $vatAmount = ($initialRental * $deal->vat) / 100;
                                    $totalPayable = $initialRental + $vatAmount;
                                @endphp

                                <div class="col-sm-6">
                                    <h6 class="text-muted">Business Lease Total</h6>
                                    <p><b>Initial Rental:</b>
                                        <span class="float-end">
                                            £{{ number_format($initialRental, 2) }}
                                        </span>
                                    </p>
                                    <p><b>VAT ({{ $deal->vat }}%):</b>
                                        <span class="float-end">
                                            £{{ number_format($vatAmount, 2) }}
                                        </span>
                                    </p>
                                    <hr>
                                    <h4>
                                        £{{ number_format($totalPayable, 2) }}
                                    </h4>
                                </div>
                            @endif

                            {{-- HIRE PURCHASE TOTAL --}}
                            @if ($deal->type === 'Lease' && $deal->is_hire_purchase)
                                @php
                                    $hpVat = ($deal->hire_purchase_total * $deal->vat) / 100;
                                    $hpGrandTotal = $deal->hire_purchase_total + $hpVat;
                                @endphp

                                <div class="col-sm-6">
                                    <h6 class="text-muted">Hire Purchase Total</h6>
                                    <p><b>Sub Total:</b>
                                        <span class="float-end">
                                            £{{ number_format($deal->hire_purchase_total, 2) }}
                                        </span>
                                    </p>
                                    <p><b>VAT ({{ $deal->vat }}%):</b>
                                        <span class="float-end">
                                            £{{ number_format($hpVat, 2) }}
                                        </span>
                                    </p>
                                    <hr>
                                    <h4>
                                        £{{ number_format($hpGrandTotal, 2) }}
                                    </h4>
                                </div>
                            @endif

                        </div>

                        {{-- Actions --}}
                        <div class="d-print-none mt-4 text-end">
                            <a href="javascript:window.print()" class="btn btn-primary">
                                <i class="mdi mdi-printer"></i> Print
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/lightgallery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/thumbnail/lg-thumbnail.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/zoom/lg-zoom.min.js"></script>

    {{-- Add the Autoplay Plugin to your scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.2/plugins/autoplay/lg-autoplay.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const el = document.getElementById('vehicle-gallery');
            if (el) {
                lightGallery(el, {
                    plugins: [lgThumbnail, lgZoom, lgAutoplay],
                    speed: 500,
                    // Autoplay settings
                    autoplay: true,
                    slideShowAutoplay: true,
                    pauseOnHover: true,
                    progressBar: true,
                    autoplayVideoOnNext: true,
                    // Appearance
                    mode: 'lg-fade',
                    selector: '.gallery-item'
                });
            }
        });
    </script>
@endpush
