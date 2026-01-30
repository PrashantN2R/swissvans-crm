@extends('layouts.superadmin')
@section('title', 'Add Vehicle | Superadmin')

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
                                class="bi bi-floppy me-1"></i>Save</button>
                    </div>
                    <h4 class="page-title">Add Vehicle</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Vehicle Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.vehicles.index') }}">Vehicles</a></li>
                        <li class="breadcrumb-item active">Add Vehicle</li>
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

        <form action="{{ route('superadmin.vehicles.store') }}" method="POST" id="vehicleForm"
            enctype="multipart/form-data">
            @csrf
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
                                                {{ old('hpi_mancode') == $man['cap_id'] ? 'selected' : '' }}>
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
                                        value="{{ old('registration') }}" placeholder="Enter Registration Number">
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
                                        value="{{ old('vin') }}">
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
                                        value="{{ old('year') }}">
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
                                        name="title" value="{{ old('title') }}">
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
                                                {{ old('van_type', $selected ?? '') == $type->name ? 'selected' : '' }}>
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
                                        name="short_description" rows="3">{{ old('short_description') }}</textarea>
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
                                    <textarea class="form-control form-control-sm" id="description" name="description" rows="5">{{ old('description') }}</textarea>
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
                                                    {{ old('owner') == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <a class="btn btn-outline-secondary"
                                            href="{{ route('superadmin.customers.create', ['redirect' => 'vehicle']) }}">Add</a>
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
                                            {{ old('stock_status') == 'in_stock' ? 'selected' : '' }}>
                                            In
                                            Stock</option>
                                        <option value="out_of_stock"
                                            {{ old('stock_status') == 'out_of_stock' ? 'selected' : '' }}>
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
                                        <option value="1" {{ old('status') == '1' ? 'selected' : 'selected' }}>
                                            Active</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
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
                            <div class="card">
                                <div class="card-body">
                                    <label class="form-label">Main Thumbnail</label>
                                    <div class="mb-2 text-center border rounded p-1 position-relative"
                                        style="min-height: 150px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa;">
                                        <img id="preview-image" src="" class="img-fluid rounded"
                                            style="max-height: 150px; display: none;">
                                        <span id="thumbnail-info" class="info-badge" style="display: none;"></span>
                                        <div id="preview-text" class="text-muted">No image selected</div>
                                    </div>
                                    <input class="form-control form-control-sm" type="file" name="thumbnail"
                                        id="thumbnail" accept="image/*">
                                </div>
                            </div>
                            {{-- Thumbnail Ends Here --}}

                            {{-- Main Gallary Starts Here --}}
                            <div class="card">
                                <div class="card-body">
                                    <label class="form-label">Vehicle Gallery</label>

                                    <div id="image-slider" class="splide mb-2" style="display: none;">
                                        <div class="splide__track">
                                            <ul class="splide__list" id="gallery-preview-list">
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="gallery-placeholder"
                                        class="text-center text-muted py-4 mb-2 border rounded bg-light">
                                        <i class="bi bi-images fs-2 d-block"></i>
                                        Gallery Preview
                                    </div>

                                    <input class="form-control form-control-sm mb-3" type="file" name="images[]"
                                        id="gallery-input" accept="image/*" multiple>
                                </div>
                            </div>
                            {{-- Main Gallary Ends Here --}}
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
                                            class="form-control form-control-sm" value="{{ old('price') }}">
                                        @error('price')
                                            <span id="price-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">Sale Price<span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="number" step="0.01" name="sale_price"
                                            class="form-control form-control-sm" value="{{ old('sale_price') }}">
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
                                            class="form-control form-control-sm" value="{{ old('vat') }}">
                                        @error('vat')
                                            <span id="vat-error" class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Interest Rate<span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="number" step="0.01" name="interest_rate"
                                            class="form-control form-control-sm" value="{{ old('interest_rate') }}">
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
                                                {{ old('is_business_lease') == '0' ? 'selected' : '' }}>No
                                            </option>
                                            <option value="1"
                                                {{ old('is_business_lease') == '1' ? 'selected' : '' }}>Yes
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
                                            value="{{ old('business_lease_price') }}">
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
                                            value="{{ old('business_lease_discount_price') }}">
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
                                            <option value="0" {{ old('is_hire_purchase') == '0' ? 'selected' : '' }}>
                                                No
                                            </option>
                                            <option value="1" {{ old('is_hire_purchase') == '1' ? 'selected' : '' }}>
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
                                            value="{{ old('hire_purchase_price') }}">
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
                                            value="{{ old('hire_purchase_discount_price') }}">
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
                                    name="meta_title" value="{{ old('meta_title') }}">
                                @error('meta_title')
                                    <span id="meta_title-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2 {{ $errors->has('meta_description') ? 'has-error' : '' }}">
                                <label class="form-label" for="meta_description">Meta
                                    Description</label>
                                <textarea id="meta_description" class="form-control form-control-sm" name="meta_description" rows="8">{{ old('meta_description') }}</textarea>
                                @error('meta_description')
                                    <span id="meta_description-error"
                                        class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2 {{ $errors->has('meta_keywords') ? 'has-error' : '' }}">
                                <label class="form-label" for="meta_keywords">Meta
                                    Keywords</label>
                                <input type="text" class="form-control form-control-sm" id="meta_keywords"
                                    name="meta_keywords" value="{{ old('meta_keywords') }}">
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
                                            class="bi bi-floppy me-1"></i>Save</button>
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
    <script>
        let splideInstance = null;
        let galleryFiles = [];

        // Utility to format file size
        function formatBytes(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Utility to get image dimensions
        function getImageDimensions(file) {
            return new Promise((resolve) => {
                const img = new Image();
                img.onload = () => resolve(`${img.width} × ${img.height} px`);
                img.src = URL.createObjectURL(file);
            });
        }

        // Single Thumbnail Logic
        document.getElementById('thumbnail').onchange = async function() {
            const [file] = this.files;
            const preview = document.getElementById('preview-image');
            const text = document.getElementById('preview-text');
            const infoBadge = document.getElementById('thumbnail-info');

            if (file) {
                const dims = await getImageDimensions(file);
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
                text.style.display = 'none';
                infoBadge.innerHTML = `${formatBytes(file.size)}<br>${dims}`;
                infoBadge.style.display = 'block';
            }
        };

        // Gallery Logic
        const galleryInput = document.getElementById('gallery-input');

        galleryInput.onchange = async function() {
            const newFiles = Array.from(this.files);
            galleryFiles = galleryFiles.concat(newFiles);
            await updateGalleryUI();
        };

        async function updateGalleryUI() {
            const list = document.getElementById('gallery-preview-list');
            const sliderDiv = document.getElementById('image-slider');
            const placeholder = document.getElementById('gallery-placeholder');

            list.innerHTML = '';

            if (galleryFiles.length > 0) {
                placeholder.style.display = 'none';
                sliderDiv.style.display = 'block';

                for (let i = 0; i < galleryFiles.length; i++) {
                    const file = galleryFiles[i];
                    const url = URL.createObjectURL(file);
                    const dims = await getImageDimensions(file);
                    const li = document.createElement('li');
                    li.className = 'splide__slide';
                    li.innerHTML = `
                    <button type="button" class="btn btn-danger btn-xs delete-slide" onclick="removeGalleryImage(${i})">
                        <i class="bi bi-x"></i>
                    </button>
                    <span class="info-badge">${formatBytes(file.size)}<br>${dims}</span>
                    <img src="${url}" class="img-fluid rounded w-100" style="height:200px; object-fit:cover;">
                `;
                    list.appendChild(li);
                }

                syncInput();

                if (splideInstance) splideInstance.destroy();
                splideInstance = new Splide('#image-slider', {
                    type: 'loop',
                    autoplay: true,
                    interval: 3000,
                    arrows: true,
                    pagination: true,
                }).mount();
            } else {
                placeholder.style.display = 'block';
                sliderDiv.style.display = 'none';
                galleryInput.value = '';
            }
        }

        function removeGalleryImage(index) {
            galleryFiles.splice(index, 1);
            updateGalleryUI();
        }

        function syncInput() {
            const dataTransfer = new DataTransfer();
            galleryFiles.forEach(file => dataTransfer.items.add(file));
            galleryInput.files = dataTransfer.files;
        }
    </script>

    <script>
        $(document).ready(function() {

            let oldMan = "{{ old('hpi_mancode') }}";
            let oldMod = "{{ old('hpi_modcode') }}";
            let oldDer = "{{ old('hpi_derivative') }}";

            // -----------------------------------------
            // 1) Load MODELS when manufacturer changes
            // -----------------------------------------
            function loadModels(manCode, callback = null) {
                if (!manCode) {
                    $("#hpi_modcode").html('<option value="">Select Model</option>');
                    return;
                }

                $("#hpi_modcode").html('<option>Loading...</option>');

                $.ajax({
                    url: "{{ route('superadmin.models.hpi-models') }}",
                    type: "GET",
                    data: {
                        manCode: manCode
                    },
                    success: function(response) {

                        $("#hpi_modcode").html('<option value="">Select Model</option>');

                        response.forEach(function(item) {
                            $("#hpi_modcode").append(
                                `<option value="${item.capmod_id}"
                                ${oldMod == item.capmod_id ? 'selected' : ''}>
                                ${item.name}
                            </option>`
                            );
                        });

                        // if (callback) callback();
                    }
                });
            }

            // -----------------------------------------
            // 2) Load DERIVATIVES when model changes
            // -----------------------------------------
            function loadDerivatives(modCode) {
                if (!modCode) {
                    $("#hpi_derivative").html('<option value="">Select Derivative</option>');
                    return;
                }

                $("#hpi_derivative").html('<option>Loading...</option>');

                $.ajax({
                    url: "{{ route('superadmin.derivatives.hpi-derivatives') }}",
                    type: "GET",
                    data: {
                        modCode: modCode
                    },
                    success: function(response) {

                        $("#hpi_derivative").html('<option value="">Select Derivative</option>');

                        response.forEach(function(item) {
                            $("#hpi_derivative").append(
                                `<option value="${item.derivative_id}"
        ${oldDer == item.derivative_id ? 'selected' : ''}>
        ${item.name}
    </option>`
                            );
                        });
                    }
                });
            }

            // -----------------------------------------
            // ON CHANGE EVENTS (STANDARD)
            // -----------------------------------------

            $("#hpi_mancode").on("change", function() {
                let manCode = $(this).val();
                oldMod = ""; // reset if user changes manually
                oldDer = "";
                loadModels(manCode);
                $("#hpi_derivative").html('<option value="">Select Derivative</option>');
            });

            $("#hpi_modcode").on("change", function() {
                let modCode = $(this).val();
                oldDer = "";
                loadDerivatives(modCode);
            });

            // -----------------------------------------
            // 3) AUTO-LOAD OLD VALUES ON VALIDATION FAIL
            // -----------------------------------------
            if (oldMan) {
                // Load models, then load derivatives
                loadModels(oldMan, function() {
                    if (oldMod) {
                        loadDerivatives(oldMod);
                    }
                });
            }

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
