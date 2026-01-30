@extends('layouts.superadmin')
@section('title', 'Edit Deal | Superadmin')

@section('head')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark"><i
                                class="bi bi-arrow-left me-1"></i>Back</a>
                        <button type="submit" class="btn btn-sm btn-primary" form="dealForm"><i
                                class="bi bi-floppy me-1"></i>Save</button>
                    </div>
                    <h4 class="page-title">Edit Deal</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Deal Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.vehicles.index') }}">Deals</a></li>
                        <li class="breadcrumb-item active">Edit Deal</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('superadmin.includes.flash-message')
            </div>
            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <form action="{{ route('superadmin.deals.update', $deal->id) }}" method="POST" id="dealForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-9">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <label for="customer" class="form-label">Customer </label>
                                    <select name="customer" id="customer" onchange="fetchCustomerDetails(this.value);"
                                        class="form-select form-select-sm @error('customer') is-invalid @enderror select2"
                                        data-toggle="select2">
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ old('customer', $deal->user_id) == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <label for="vehicle" class="form-label">Vehicle </label>
                                    <select name="vehicle" id="vehicle" onchange="fetchVehicleDetails(this.value);"
                                        class="form-select form-select-sm @error('vehicle') is-invalid @enderror select2"
                                        data-toggle="select2">
                                        <option value="">Select Vehicle</option>
                                        @foreach ($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}"
                                                {{ old('vehicle', $deal->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
                                                {{ $vehicle->registration }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vehicle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <label for="salesperson" class="form-label">Salesperson </label>
                                    <select name="salesperson" id="salesperson"
                                        class="form-select form-select-sm @error('salesperson') is-invalid @enderror select2"
                                        data-toggle="select2">
                                        <option value="">Select Salesperson</option>
                                        @foreach ($salespeople as $sale)
                                            <option value="{{ $sale->id }}"
                                                {{ old('salesperson', $deal->salesperson_id) == $sale->id ? 'selected' : '' }}>
                                                {{ $sale->firstname }} {{ $sale->lastname }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('salesperson')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <label for="type" class="form-label">Deal Type </label>
                                    <select name="type" id="type"
                                        class="form-select form-select-sm @error('type') is-invalid @enderror">
                                        <option value="">Select Deal Type</option>
                                        <option value="Sale" {{ old('type', $deal->type) == "Sale" ? "selected" : "" }}>Sale</option>
                                        <option value="Lease" {{ old('type', $deal->type) == "Lease" ? "selected" : "" }}>Lease</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <label for="statuses" class="form-label">Status </label>
                                    <select name="status" id="statuses"
                                        class="form-select form-select-sm @error('status') is-invalid @enderror">
                                        <option value="">Select Status</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}"
                                                {{ old('status', $deal->status) == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <label for="commission" class="form-label">Commission</label>
                                    <input type="number" step="0.01" name="commission" id="commission"
                                        class="form-control form-control-sm @error('commission') is-invalid @enderror"
                                        value="{{ old('commission', $deal->commission) }}">
                                    @error('commission')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        {{-- Deal Pricing Starts Here --}}
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body mb-2 pb-0 row">
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label">Regular Price<span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="number" step="0.01" name="price"
                                            class="form-control form-control-sm" value="{{ old('price', $deal->price) }}">
                                        @error('price')
                                            <span id="price-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">Sale Price<span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="number" step="0.01" name="sale_price"
                                            class="form-control form-control-sm" value="{{ old('sale_price', $deal->sale_price) }}">
                                        @error('sale_price')
                                            <span id="sale_price-error"
                                                class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-body row mt-0 pt-0">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">VAT<span class="text-danger ms-1">*</span></label>
                                        <input type="number" step="0.01" name="vat"
                                            class="form-control form-control-sm" value="{{ old('vat', $deal->vat) }}">
                                        @error('vat')
                                            <span id="vat-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Interest Rate<span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="number" step="0.01" name="interest_rate"
                                            class="form-control form-control-sm" value="{{ old('interest_rate', $deal->interest_rate) }}">
                                        @error('interest_rate')
                                            <span id="interest-rate-error"
                                                class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Deal Pricing Ends Here --}}

                        {{-- Business Lease Starts Here --}}
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12 mb-2">
                                        <label for="is_business_lease" class="form-label">Available
                                            for
                                            Business
                                            Lease<span class="text-danger ms-1">*</span></label>
                                        <select name="is_business_lease" id="is_business_lease"
                                            class="form-select form-select-sm @error('is_business_lease') is-invalid @enderror">
                                            <option value="0"
                                                {{ old('is_business_lease', $deal->is_business_lease) == '0' ? 'selected' : '' }}>No
                                            </option>
                                            <option value="1"
                                                {{ old('is_business_lease', $deal->is_business_lease) == '1' ? 'selected' : '' }}>Yes
                                            </option>
                                        </select>
                                        @error('is_business_lease')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <label for="business_lease_price" class="form-label">Business
                                            Lease Regular
                                            Price</label>
                                        <input type="number" step="0.01" name="business_lease_price"
                                            id="business_lease_price"
                                            class="form-control form-control-sm @error('business_lease_price') is-invalid @enderror"
                                            value="{{ old('business_lease_price', $deal->business_lease_price) }}">
                                        @error('business_lease_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <label for="business_lease_discount_price" class="form-label">Business
                                            Lease
                                            Sale
                                            Price</label>
                                        <input type="number" step="0.01" name="business_lease_discount_price"
                                            id="business_lease_discount_price"
                                            class="form-control form-control-sm @error('business_lease_discount_price') is-invalid @enderror"
                                            value="{{ old('business_lease_discount_price', $deal->business_lease_discount_price) }}">
                                        @error('business_lease_discount_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Business Lease Ends Here --}}

                        {{-- Lease Purchase Starts Here --}}
                        <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                            <div class="card">
                                <div class="card-body row">
                                    <div class="col-md-12  mb-2">
                                        <label for="is_hire_purchase" class="form-label">Available for
                                            Lease
                                            Purchase<span class="text-danger ms-1">*</span></label>
                                        <select name="is_hire_purchase" id="is_hire_purchase"
                                            class="form-select form-select-sm @error('is_hire_purchase') is-invalid @enderror">
                                            <option value="0" {{ old('is_hire_purchase', $deal->is_hire_purchase) == '0' ? 'selected' : '' }}>
                                                No
                                            </option>
                                            <option value="1" {{ old('is_hire_purchase', $deal->is_hire_purchase) == '1' ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                        </select>
                                        @error('is_hire_purchase')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <label for="hire_purchase_price" class="form-label">Hire
                                            Purchase Regular
                                            Price</label>
                                        <input type="number" step="0.01" name="hire_purchase_price"
                                            id="hire_purchase_price"
                                            class="form-control form-control-sm @error('hire_purchase_price') is-invalid @enderror"
                                            value="{{ old('hire_purchase_price', $deal->hire_purchase_price) }}">
                                        @error('hire_purchase_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-2">
                                        <label for="hire_purchase_discount_price" class="form-label">Hire
                                            Purchase
                                            Sale Price</label>
                                        <input type="number" step="0.01" name="hire_purchase_discount_price"
                                            id="hire_purchase_discount_price"
                                            class="form-control form-control-sm @error('hire_purchase_discount_price') is-invalid @enderror"
                                            value="{{ old('hire_purchase_discount_price', $deal->hire_purchase_discount_price) }}">
                                        @error('hire_purchase_discount_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Lease Purchase Ends Here --}}
                        <div class="col-md-12 text-end">
                            <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark"><i
                                class="bi bi-arrow-left me-1"></i>Back</a>
                                <button type="submit" class="btn btn-sm btn-primary" form="dealForm"><i
                                        class="bi bi-floppy me-1"></i>Save</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div id="customer-preview-card" class="card border-0 shadow-lg position-sticky"
                        style="top: 20px; border-radius: 15px; display: none;">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <img id="prev_avatar" src="" class="rounded-circle img-thumbnail shadow-sm"
                                    style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #fff;">
                            </div>
                            <h5 id="prev_name" class="fw-bold mb-1 text-dark"></h5>
                            <p id="prev_email" class="text-muted small mb-3"></p>

                            <hr class="my-3 opacity-25">

                            <div class="text-start">
                                <div class="d-flex align-items-center mb-2">
                                    <img id="prev_flag" src="" width="20" class="me-2 rounded-1 shadow-sm">
                                    <span id="prev_phone" class="small text-secondary"></span>
                                </div>
                                <div class="mb-2">
                                    <i class="mdi mdi-map-marker-outline text-primary me-1"></i>
                                    <span id="prev_location" class="small text-secondary"></span>
                                </div>
                                <div class="mb-0">
                                    <i class="mdi mdi-calendar-blank-outline text-primary me-1"></i>
                                    <span class="small text-muted">Member since: </span>
                                    <span id="prev_created" class="small text-dark fw-medium"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="vehicle-preview-card" class="card border-0 shadow-sm mt-3"
                        style="border-radius: 12px; display: none; overflow: hidden;">
                        <div class="position-relative">
                            <img id="v_prev_thumbnail" src="" class="card-img-top"
                                style="height: 180px; object-fit: cover;">
                            <span id="v_prev_stock_status"
                                class="badge position-absolute top-0 end-0 m-2 px-3 py-2"></span>
                        </div>

                        <div class="card-body">
                            <h5 id="v_prev_variant" class="fw-bold text-primary mb-2"></h5>
                            <hr class="text-light">
                            <div class="row mb-2">
                                <div class="col-12">
                                    <div class="p-2 border rounded bg-light">
                                        <small class="text-muted d-block uppercase font-10">MAKE</small>
                                        <span id="v_prev_make" class="fw-bold text-dark"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="p-2 border rounded bg-light">
                                        <small class="text-muted d-block uppercase font-10">MODEL</small>
                                        <span id="v_prev_model" class="fw-bold text-dark"></span>
                                    </div>
                                </div>
                            </div>



                            <div class="row mb-2">
                                <div class="col-6">
                                    <div class="p-2 border rounded bg-light">
                                        <small class="text-muted d-block uppercase font-10">REGISTRATION</small>
                                        <span id="v_prev_registration" class="fw-bold text-dark"></span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2 border rounded bg-light">
                                        <small class="text-muted d-block uppercase font-10">YEAR</small>
                                        <span id="v_prev_year" class="fw-bold text-dark"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="p-2 border rounded bg-light">
                                        <small class="text-muted d-block uppercase font-10">VIN</small>
                                        <span id="v_prev_vin" class="font-monospace small fw-bold text-dark"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <small class="text-muted d-block">Owner / Customer</small>
                                    <span id="v_prev_customer" class="fw-bold"></span>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">Sale Price</small>
                                    <h4 class="fw-bold text-success mb-0">£<span id="v_prev_sale_price"></span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        function fetchCustomerDetails(customerId) {
            const $card = $('#customer-preview-card');

            if (!customerId) {
                $card.fadeOut(300);
                return;
            }

            let url = "{{ route('superadmin.customers.get-details', ['id' => ':id']) }}";
            url = url.replace(':id', customerId);

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    // You could add a small spinner inside the card here
                },
                success: function(response) {
                    if (response.status === 'success') {
                        const user = response.data;

                        // Map AJAX $data to Preview Card IDs
                        $('#prev_avatar').attr('src', user.avatar);
                        $('#prev_name').text(user.name);
                        $('#prev_email').text(user.email);
                        $('#prev_phone').text(user.dialcode + ' ' + user.phone);
                        $('#prev_flag').attr('src', user.flag);
                        $('#prev_location').text(user.city + (user.zipcode ? ', ' + user.zipcode : ''));
                        $('#prev_created').text(user.created_at);

                        // Apple-style fade reveal
                        $card.fadeIn(400);
                    }
                },
                error: function(xhr) {
                    console.error("Failed to fetch customer.");
                    $card.hide();
                }
            });
        }

        // Trigger on page load if 'old' value exists (e.g. after validation error)
        $(document).ready(function() {
            let selected = $('#customer').val();
            if (selected) fetchCustomerDetails(selected);
        });
    </script>
    <script>
        function fetchVehicleDetails(vehicleId) {
            const $card = $('#vehicle-preview-card');
            if (!vehicleId) {
                $card.fadeOut(300);
                return;
            }

            let url = "{{ route('superadmin.vehicles.get-details', ['id' => ':id']) }}".replace(':id', vehicleId);

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        const v = response.data;

                        // 1. Title and Hierarchy
                        $('#v_prev_make').text(v.manufacturer);
                        $('#v_prev_model').text(v.model);
                        $('#v_prev_variant').text(v.variant);

                        // 2. Technical Data
                        $('#v_prev_registration').text(v.registration);
                        $('#v_prev_year').text(v.year);
                        $('#v_prev_vin').text(v.vin ? v.vin : 'N/A');

                        // 3. Ownership & Visuals
                        $('#v_prev_customer').text(v.customer);
                        $('#v_prev_thumbnail').attr('src', v.thumbnail);
                        $('#v_prev_sale_price').text(parseFloat(v.sale_price).toLocaleString());

                        // 4. Stock Status Styling
                        const statusBadge = $('#v_prev_stock_status');
                        statusBadge.text(v.stock_status);
                        if (v.stock_status === "In Stock") {
                            statusBadge.removeClass('bg-danger').addClass('bg-success');
                        } else {
                            statusBadge.removeClass('bg-success').addClass('bg-danger');
                        }

                        $card.fadeIn(400);
                    }
                },
                error: function(xhr) {
                    console.error("Error fetching vehicle details");
                    $card.hide();
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            // Trigger if there is an initial value (like on Edit pages or after validation fail)
            let selectedVehicle = $('#vehicle').val(); // Ensure your select ID is 'vehicle'
            if (selectedVehicle) fetchVehicleDetails(selectedVehicle);

            // Bind the change event
            $('#vehicle').on('change', function() {
                fetchVehicleDetails($(this).val());
            });
        });
    </script>
@endpush
