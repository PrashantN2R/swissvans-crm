@extends('layouts.superadmin')
@section('title', 'Edit Vehicle | Superadmin')

@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <style>
        .delete-slide {
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 10;
        }

        .info-badge {
            position: absolute;
            bottom: 5px;
            left: 5px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 3px 8px;
            font-size: 10px;
            border-radius: 4px;
            z-index: 10;
            line-height: 1.2;
        }

        .splide__slide {
            position: relative;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark"><i
                                class="bi bi-arrow-left me-1"></i>Back</a>
                        <button type="submit" class="btn btn-sm btn-primary" form="vehicleForm"><i
                                class="bi bi-floppy me-1"></i>Update</button>
                    </div>
                    <h4 class="page-title">Edit Vehicle</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Vehicle Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.vehicles.index') }}">Vehicles</a></li>
                        <li class="breadcrumb-item active">Edit Vehicle</li>
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

        <form action="{{ route('superadmin.vehicles.update', $vehicle->id) }}" method="POST" id="vehicleForm"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-9">
                    <div class="row">

                        {{-- CAP Manufacturer Starts Here --}}
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <label for="hpi_mancode" class="form-label">CAP Manufacturer <span
                                            class="text-danger ms-1">*</span></label>
                                    <select name="hpi_mancode" id="hpi_mancode"
                                        class="form-select form-select-sm @error('hpi_mancode') is-invalid @enderror">
                                        <option value="">Select Manufacturer</option>
                                        @foreach ($manufacturers as $man)
                                            <option value="{{ $man['cap_id'] }}"
                                                {{ old('hpi_mancode', $vehicle->hpi_mancode) == $man['cap_id'] ? 'selected' : '' }}>
                                                {{ $man['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('hpi_mancode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- CAP Manufacturer Ends Here --}}

                        {{-- CAP Model Starts Here --}}
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <label for="hpi_modcode" class="form-label">CAP Model<span
                                            class="text-danger ms-1">*</span></label>
                                    <select name="hpi_modcode" id="hpi_modcode"
                                        class="form-select form-select-sm @error('hpi_modcode') is-invalid @enderror">
                                        <option value="">Select Model</option>
                                        {{-- populated via AJAX --}}
                                    </select>
                                    @error('hpi_modcode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- CAP Model Ends Here --}}

                        {{-- CAP Derivative Starts Here --}}
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <label for="hpi_derivative" class="form-label">CAP Derivative<span
                                            class="text-danger ms-1">*</span></label>
                                    <select name="hpi_derivative" id="hpi_derivative"
                                        class="form-select form-select-sm @error('hpi_derivative') is-invalid @enderror">
                                        <option value="">Select Derivative</option>
                                        {{-- populated via AJAX --}}
                                    </select>
                                    @error('hpi_derivative')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- CAP Derivative Ends Here --}}

                        {{-- Registration Number Starts Here --}}
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <label for="registration" class="form-label">Registration Number<span
                                            class="text-danger ms-1">*</span></label>
                                    <input type="text" name="registration" id="registration"
                                        class="form-control form-control-sm @error('registration') is-invalid @enderror"
                                        value="{{ old('registration', $vehicle->registration) }}"
                                        placeholder="Enter Registration Number">
                                    @error('registration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- Registration Number Ends Here --}}

                        {{-- VIN Starts Here --}}
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <label for="vin" class="form-label">VIN<span
                                            class="text-danger ms-1">*</span></label>
                                    <input type="text" name="vin" id="vin" placeholder="Enter VIN"
                                        class="form-control form-control-sm @error('vin') is-invalid @enderror"
                                        value="{{ old('vin', $vehicle->vin) }}">
                                    @error('vin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- VIN Ends Here --}}

                        {{-- Year Starts Here --}}
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <label for="year" class="form-label">Year<span
                                            class="text-danger ms-1">*</span></label>
                                    <input type="text" name="year" id="year" placeholder="Enter Model Year"
                                        class="form-control form-control-sm @error('year') is-invalid @enderror"
                                        value="{{ old('year', $vehicle->year) }}">
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- Year Starts Here --}}

                        {{-- Vehicle Title Starts Here --}}
                        <div class="col-sm-8">
                            <div class="card">
                                <div class="card-body">
                                    <label class="form-label" for="title">Vehicle Title<span
                                            class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control form-control-sm" id="title"
                                        name="title" value="{{ old('title', $vehicle->title) }}">
                                    @error('title')
                                        <span id="title-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- Vehicle Title Ends Here --}}

                        {{-- Vehicle Type Starts Here --}}
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <label class="form-label" for="van_type">Vehicle Type</label>
                                    <select name="van_type" id="van_type" class="form-select form-select-sm">
                                        <option value="">Any Type</option>
                                        @foreach ($van_type as $type)
                                            <option value="{{ $type->name }}"
                                                {{ old('van_type', $vehicle->van_type ?? '') == $type->name ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('van_type')
                                        <span id="van-type-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- Vehicle Type Ends Here --}}

                        {{-- Vehicle Short Description Starts Here --}}
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <label for="short_description" class="form-label">Short Description <span
                                            class="text-danger ms-1">*</span></label>
                                    <textarea id="short_description" class="form-control form-control-sm @error('short_description') is-invalid @enderror"
                                        name="short_description" rows="3">{{ old('short_description', $vehicle->short_description) }}</textarea>
                                    @error('short_description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- Vehicle Short Description Ends Here --}}

                        {{-- Vehicle Long Description Starts Here --}}
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <label class="form-label" for="description">Full Description<span
                                            class="text-danger ms-1">*</span></label>
                                    <textarea class="form-control form-control-sm" id="description" name="description" rows="5">{{ old('description', $vehicle->description) }}</textarea>
                                    @error('description')
                                        <span id="description-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- Vehicle Long Description Ends Here --}}
                    </div>
                </div>
                <div class="col-3">
                    <div class="row">
                        {{-- Owner Starts Here --}}
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <label for="owner" class="form-label">Current Owner </label>
                                    <div class="input-group">
                                        <select name="owner" id="owner"
                                            class="form-select form-select-sm @error('owner') is-invalid @enderror">
                                            <option value="">Select Owner</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ old('owner', $vehicle->user_id) == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->firstname }} {{ $customer->lastname }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <a class="btn btn-outline-secondary"
                                            href="{{ route('superadmin.customers.create', ['redirect' => 'vehicle', 'vehicle_id' => $vehicle->id]) }}">Add</a>
                                    </div>
                                    @error('owner')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- Owner Ends Here --}}

                        {{-- Stock Status Starts Here --}}
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <label class="form-label">Stock Status</label>
                                    <select name="stock_status" id="stock_status"
                                        class="form-select form-select-sm @error('stock_status') is-invalid @enderror">
                                        <option value="">Select Stock Status</option>
                                        <option value="in_stock"
                                            {{ old('stock_status', $vehicle->stock_status) == 'in_stock' ? 'selected' : '' }}>
                                            In
                                            Stock</option>
                                        <option value="out_of_stock"
                                            {{ old('stock_status', $vehicle->stock_status) == 'out_of_stock' ? 'selected' : '' }}>
                                            Out
                                            of Stock</option>
                                    </select>
                                    @error('stock_status')
                                        <span id="stock-status-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- Stock Status Ends Here --}}

                        {{-- Stock Status Starts Here --}}
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <label class="form-label">Vehicle Status</label>
                                    <select name="status" id="statuses"
                                        class="form-select form-select-sm @error('status') is-invalid @enderror">
                                        <option value="">Select Vehicle Status</option>
                                        <option value="1"
                                            {{ old('status', $vehicle->status) == '1' ? 'selected' : 'selected' }}>
                                            Active</option>
                                        <option value="0"
                                            {{ old('status', $vehicle->status) == '0' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    @error('status')
                                        <span id="status-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- Stock Status Ends Here --}}

                        <div class="col-md-12">
                            {{-- Thumbnail Starts Here --}}
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <label class="form-label fw-bold text-secondary small">Main Thumbnail</label>

                                    <div class="mb-3 text-center border rounded position-relative" id="preview-container"
                                        style="height: 180px; display: flex; align-items: center; justify-content: center; background-color: #fbfbfb; overflow: hidden;">

                                        <img id="preview-image"
                                            src="{{ isset($vehicle->thumbnail) ? $vehicle->thumbnail_path : '' }}"
                                            class="img-fluid"
                                            style="max-height: 100%; width: auto; object-fit: contain; {{ isset($vehicle->thumbnail) ? 'display: block;' : 'display: none;' }}">

                                        <span id="thumbnail-info" class="info-badge"
                                            @if (isset($vehicle->thumbnail)) style="display: none;" @endif></span>

                                        @if (!isset($vehicle->thumbnail))
                                            <div id="preview-text"
                                                class="text-muted d-flex flex-column align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    fill="currentColor" class="bi bi-image mb-2 opacity-50"
                                                    viewBox="0 0 16 16">
                                                    <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                                    <path
                                                        d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z" />
                                                </svg>
                                                <span class="small uppercase">No Thumbnail uploaded</span>
                                            </div>
                                        @endif
                                    </div>

                                    <input class="form-control form-control-sm shadow-none" type="file"
                                        name="thumbnail" id="thumbnail" accept="image/*">
                                </div>
                            </div>
                            {{-- Thumbnail Ends Here --}}

                            {{-- Main Gallery Starts Here --}}
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <label class="form-label fw-bold text-secondary small">Vehicle Gallery</label>

                                    <div id="image-slider" class="splide mb-3"
                                        style="{{ $vehicle->images->count() > 0 ? 'display: block;' : 'display: none;' }}">
                                        <div class="splide__track">
                                            <ul class="splide__list" id="gallery-preview-list">
                                                @foreach ($vehicle->images as $image)
                                                    <li class="splide__slide p-1">
                                                        <div class="position-relative border rounded overflow-hidden shadow-sm"
                                                            style="height: 120px; background: #f8f9fa;">
                                                            <img src="{{ $image->full_path }}" class="w-100 h-100"
                                                                style="object-fit: cover;"
                                                                alt="{{ $image->alt ?? 'Vehicle Image' }}">

                                                            <div class="position-absolute top-0 end-0 p-1">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm py-0 px-1 opacity-75 hover-opacity-100"
                                                                    onclick="removeGalleryImage({{ $image->id }}, this)">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    <div id="gallery-placeholder"
                                        class="text-center text-muted py-5 mb-3 border rounded bg-light"
                                        style="{{ $vehicle->images->count() > 0 ? 'display: none;' : 'display: block;' }}">
                                        <i class="bi bi-images fs-1 d-block opacity-25 mb-2"></i>
                                        <span class="small text-uppercase fw-semibold">No Gallery Images Found</span>
                                    </div>

                                    <input class="form-control form-control-sm shadow-none" type="file"
                                        name="images[]" id="gallery-input" accept="image/*" multiple>

                                    <div class="form-text small text-muted">You can select multiple images to upload.</div>
                                </div>
                            </div>
                            {{-- Main Gallery Ends Here --}}
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="row">
                        {{-- Vehicle Pricing Starts Here --}}
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body mb-2 pb-0 row">
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label">Regular Price<span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="number" step="0.01" name="price"
                                            class="form-control form-control-sm"
                                            value="{{ old('price', $vehicle->price) }}">
                                        @error('price')
                                            <span id="price-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">Sale Price<span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="number" step="0.01" name="sale_price"
                                            class="form-control form-control-sm"
                                            value="{{ old('sale_price', $vehicle->sale_price) }}">
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
                                            class="form-control form-control-sm" value="{{ old('vat', $vehicle->vat) }}">
                                        @error('vat')
                                            <span id="vat-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Interest Rate<span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="number" step="0.01" name="interest_rate"
                                            class="form-control form-control-sm"
                                            value="{{ old('interest_rate', $vehicle->interest_rate) }}">
                                        @error('interest_rate')
                                            <span id="interest-rate-error"
                                                class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Vehicle Pricing Ends Here --}}

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
                                                {{ old('is_business_lease', $vehicle->is_business_lease) == '0' ? 'selected' : '' }}>
                                                No
                                            </option>
                                            <option value="1"
                                                {{ old('is_business_lease', $vehicle->is_business_lease) == '1' ? 'selected' : '' }}>
                                                Yes
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
                                            value="{{ old('business_lease_price', $vehicle->business_lease_price) }}">
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
                                            value="{{ old('business_lease_discount_price', $vehicle->business_lease_discount_price) }}">
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
                                            <option value="0"
                                                {{ old('is_hire_purchase', $vehicle->is_hire_purchase) == '0' ? 'selected' : '' }}>
                                                No
                                            </option>
                                            <option value="1"
                                                {{ old('is_hire_purchase', $vehicle->is_hire_purchase) == '1' ? 'selected' : '' }}>
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
                                            value="{{ old('hire_purchase_price', $vehicle->hire_purchase_price) }}">
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
                                            value="{{ old('hire_purchase_discount_price', $vehicle->hire_purchase_discount_price) }}">
                                        @error('hire_purchase_discount_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Lease Purchase Ends Here --}}
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-body row">
                            <div class="col-md-12 mb-2 {{ $errors->has('meta_title') ? 'has-error' : '' }}">
                                <label class="form-label" for="meta_title">Meta
                                    Title</label>
                                <input type="text" class="form-control form-control-sm" id="meta_title"
                                    name="meta_title" value="{{ old('meta_title', $vehicle->meta_title) }}">
                                @error('meta_title')
                                    <span id="meta_title-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2 {{ $errors->has('meta_description') ? 'has-error' : '' }}">
                                <label class="form-label" for="meta_description">Meta
                                    Description</label>
                                <textarea id="meta_description" class="form-control form-control-sm" name="meta_description" rows="8">{{ old('meta_description', $vehicle->meta_description) }}</textarea>
                                @error('meta_description')
                                    <span id="meta_description-error"
                                        class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2 {{ $errors->has('meta_keywords') ? 'has-error' : '' }}">
                                <label class="form-label" for="meta_keywords">Meta
                                    Keywords</label>
                                <input type="text" class="form-control form-control-sm" id="meta_keywords"
                                    name="meta_keywords" value="{{ old('meta_keywords', $vehicle->meta_keywords) }}">
                                @error('meta_keywords')
                                    <span id="meta_keywords-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer row">
                            <div class="col-12 text-end">
                                <div class="page-title-right">
                                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark"><i
                                            class="bi bi-arrow-left me-1"></i>Back</a>
                                    <button type="submit" class="btn btn-sm btn-primary" form="vehicleForm"><i
                                            class="bi bi-floppy me-1"></i>Update</button>
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
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Initialize Splide
            var elms = document.getElementsByClassName('splide');
            for (var i = 0, len = elms.length; i < len; i++) {
                new Splide(elms[i], {
                    type: 'loop', // Use 'loop' so it doesn't stop at the last slide
                    perPage: 1,
                    gap: '10px',
                    pagination: false,
                    arrows: true,
                    autoplay: true, // Enables autoplay
                    interval: 3000, // Time between transitions (3 seconds)
                    pauseOnHover: true, // Good UX: stop moving when user hovers
                    resetProgress: false,
                    breakpoints: {
                        640: {
                            perPage: 1,
                        },
                    }
                }).mount();
            }

            // 2. Logic for Thumbnail Preview
            const thumbnailInput = document.getElementById('thumbnail');
            const previewImage = document.getElementById('preview-image');
            const previewText = document.getElementById('preview-text');

            thumbnailInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                        if (previewText) previewText.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                }
            });
        });

        function removeGalleryImage(imageId, button) {
            // 1. Trigger SweetAlert2 Confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                // 2. Only proceed if user clicked "Yes"
                if (result.isConfirmed) {

                    const $btn = $(button);
                    $btn.prop('disabled', true); // Disable button

                    $.ajax({
                        url: '{{ route('superadmin.vehicles.delete-attachment') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'PUT',
                            id: imageId
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // 3. Success Feedback
                                Swal.fire(
                                    'Deleted!',
                                    'Your image has been removed.',
                                    'success'
                                );

                                const $slide = $btn.closest('.splide__slide');
                                $slide.fadeOut(300, function() {
                                    $(this).remove();
                                    if (window.mainSplide) window.mainSplide.refresh();

                                    if ($('#gallery-preview-list').children().length === 0) {
                                        $('#image-slider').hide();
                                        $('#gallery-placeholder').fadeIn();
                                    }
                                });
                            }
                        },
                        error: function(xhr) {
                            $btn.prop('disabled', false);
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON ? xhr.responseJSON.message : 'Server Error',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
    <script>
        document.getElementById('gallery-input').addEventListener('change', function(event) {
            const files = event.target.files;
            const list = document.getElementById('gallery-preview-list');
            const sliderDiv = document.getElementById('image-slider');
            const placeholder = document.getElementById('gallery-placeholder');

            if (files.length > 0) {
                // Show slider, hide "No Images" placeholder
                sliderDiv.style.display = 'block';
                placeholder.style.display = 'none';

                Array.from(files).forEach(file => {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        // Create the HTML for a new Splide slide
                        const li = document.createElement('li');
                        li.className = 'splide__slide p-1';
                        li.innerHTML = `
                    <div class="position-relative border rounded overflow-hidden shadow-sm" style="height: 120px; background: #f8f9fa;">
                        <img src="${e.target.result}" class="w-100 h-100" style="object-fit: cover;">
                        <div class="position-absolute top-0 end-0 p-1">
                            <span class="badge bg-warning text-dark">New</span>
                        </div>
                    </div>
                `;
                        list.appendChild(li);

                        // Refresh Splide to recognize the new elements
                        // Assuming you stored your splide instance in a variable named 'mainSplide'
                        if (window.mainSplide) {
                            window.mainSplide.refresh();
                        }
                    };
                    reader.readAsDataURL(file);
                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {

            const selectedMan = "{{ old('hpi_mancode', $vehicle->hpi_mancode) }}";
            const selectedMod = "{{ old('hpi_modcode', $vehicle->hpi_modcode) }}";
            const selectedDer = "{{ old('hpi_derivative', $vehicle->hpi_derivative) }}";

            /* ================================
               LOAD MODELS
            =================================*/
            function loadModels(manCode, preselect = null, callback = null) {

                if (!manCode) return;

                // Already loaded from blade
                if ($("#hpi_modcode option").length > 1) {
                    if (callback) callback();
                    return;
                }

                $("#hpi_modcode").html('<option>Loading...</option>');

                $.ajax({
                    url: "{{ route('superadmin.models.hpi-models') }}",
                    type: "GET",
                    data: {
                        manCode
                    },
                    success: function(list) {

                        let html = '<option value="">Select Model</option>';

                        list.forEach(row => {
                            let selected = (preselect && row.capmod_id == preselect) ?
                                'selected' : '';
                            html +=
                                `<option value="${row.capmod_id}" ${selected}>${row.name}</option>`;
                        });

                        $("#hpi_modcode").html(html);

                        if (callback) callback();
                    }
                });
            }

            /* ================================
               LOAD DERIVATIVES
            =================================*/
            function loadDerivatives(modCode, preselect = null) {

                if (!modCode) return;

                // Already loaded from blade
                if ($("#hpi_derivative option").length > 1) return;

                $("#hpi_derivative").html('<option>Loading...</option>');

                $.ajax({
                    url: "{{ route('superadmin.derivatives.hpi-derivatives') }}",
                    type: "GET",
                    data: {
                        modCode
                    },
                    success: function(list) {

                        let html = '<option value="">Select Derivative</option>';

                        list.forEach(row => {
                            let selected = (preselect && row.derivative_id == preselect) ?
                                'selected' : '';
                            html +=
                                `<option value="${row.derivative_id}" ${selected}>${row.name}</option>`;
                        });

                        $("#hpi_derivative").html(html);
                    }
                });
            }

            /* ================================
               ON PAGE LOAD (EDIT MODE)
            =================================*/
            if (selectedMan) {

                $("#hpi_mancode").val(selectedMan);

                loadModels(selectedMan, selectedMod, function() {

                    if (selectedMod) {
                        $("#hpi_modcode").val(selectedMod);

                        loadDerivatives(selectedMod, selectedDer);

                        if (selectedDer) {
                            $("#hpi_derivative").val(selectedDer);
                        }
                    }
                });
            }

            /* ================================
               USER CHANGES MANUFACTURER
            =================================*/
            $("#hpi_mancode").on("change", function() {

                let manCode = $(this).val();

                $("#hpi_modcode").html('<option value="">Select Model</option>');
                $("#hpi_derivative").html('<option value="">Select Derivative</option>');

                if (!manCode) return;

                loadModels(manCode);
            });

            /* ================================
               USER CHANGES MODEL
            =================================*/
            $("#hpi_modcode").on("change", function() {

                let modCode = $(this).val();

                $("#hpi_derivative").html('<option value="">Select Derivative</option>');

                if (!modCode) return;

                loadDerivatives(modCode);
            });

        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.0/tinymce.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea#description',
            height: 360,
            plugins: 'image code link lists table',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | removeformat | help',
            images_upload_url: "{{ route('superadmin.vehicles.content-images-upload') }}",
            images_upload_credentials: true,
            menubar: false,
            automatic_uploads: true,
            relative_urls: false,
            remove_script_host: false,
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px } .variable {cursor: default;background-color: #65b9dd;color: #FFF;padding: 2px 8px;border-radius: 3px;font-weight: bold;font-style: normal;font-size: 10px;display: inline-block;line-height: 12px;}',
        });
    </script>
    <script>
        tinymce.init({
            selector: 'textarea#short_description',
            height: 200,
            plugins: 'image code link lists table',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | removeformat | help',
            images_upload_url: "{{ route('superadmin.vehicles.content-images-upload') }}",
            images_upload_credentials: true,
            menubar: false,
            automatic_uploads: true,
            relative_urls: false,
            remove_script_host: false,
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px } .variable {cursor: default;background-color: #65b9dd;color: #FFF;padding: 2px 8px;border-radius: 3px;font-weight: bold;font-style: normal;font-size: 10px;display: inline-block;line-height: 12px;}',
        });
    </script>
    <script>
        $(document).ready(function() {

            function toggleBusinessLease() {
                let val = $("#is_business_lease").val();

                if (val == "1") {
                    $("#business_lease_price").prop("disabled", false);
                    $("#business_lease_discount_price").prop("disabled", false);
                } else {
                    $("#business_lease_price").prop("disabled", true).val("");
                    $("#business_lease_discount_price").prop("disabled", true).val("");
                }
            }

            function toggleHirePurchase() {
                let val = $("#is_hire_purchase").val();

                if (val == "1") {
                    $("#hire_purchase_price").prop("disabled", false);
                    $("#hire_purchase_discount_price").prop("disabled", false);
                } else {
                    $("#hire_purchase_price").prop("disabled", true).val("");
                    $("#hire_purchase_discount_price").prop("disabled", true).val("");
                }
            }

            // Run on page load (important for old() values)
            toggleBusinessLease();
            toggleHirePurchase();

            // Run when dropdown changes
            $("#is_business_lease").on("change", toggleBusinessLease);
            $("#is_hire_purchase").on("change", toggleHirePurchase);

        });
    </script>
@endpush
