@extends('layouts.superadmin')
@section('title', 'Edit Lead | Superadmin')
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
                        <button type="submit" class="btn btn-sm btn-primary" form="leadForm"><i
                                class="bi bi-floppy me-1"></i>Update</button>
                    </div>
                    <h4 class="page-title">Edit Lead</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Lead Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.leads.index') }}">Leads</a></li>
                        <li class="breadcrumb-item active">Edit Lead</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('superadmin.includes.flash-message')
                <form id="leadForm" method="POST" action="{{ route('superadmin.leads.update', $lead->id) }}"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 mb-2 {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="name">Customer Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter Customer Name" value="{{ old('name', $lead->name) }}">
                                    @error('name')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4 mb-2 {{ $errors->has('designation') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="designation">Designation <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="designation" name="designation"
                                        placeholder="Enter Designation"
                                        value="{{ old('designation', $lead->designation) }}">
                                    @error('designation')
                                        <span id="designation-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4 mb-2 {{ $errors->has('company') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="company">Company <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="company" name="company"
                                        placeholder="Enter Company" value="{{ old('company', $lead->company) }}">
                                    @error('company')
                                        <span id="company-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4 mb-2 {{ $errors->has('email') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="email">Email Address <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter Email Address" value="{{ old('email', $lead->email) }}">
                                    @error('email')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-4 mb-2 {{ $errors->has('phone') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="phone">Phone Number <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Enter Phone Number" value="{{ old('phone', $lead->phone) }}">
                                    @error('phone')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4 mb-2 {{ $errors->has('event_type') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="event_type">Event Type <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="event_type" name="event_type"
                                        placeholder="Enter Event Type"
                                        value="{{ old('event_type', $lead->event_type) }}">
                                    @error('event_type')
                                        <span id="event_type-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4 mb-2 {{ $errors->has('event_date') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="event_date">Event Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="event_date" name="event_date"
                                        placeholder="Enter Event Date"
                                        value="{{ old('event_date', $lead->event_date) }}">
                                    @error('event_date')
                                        <span id="event_date-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4 mb-2 {{ $errors->has('location') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="location">Event Location <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="location" name="location"
                                        placeholder="Enter Event Location"
                                        value="{{ old('location', $lead->location) }}">
                                    @error('location')
                                        <span id="location-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4 mb-2 {{ $errors->has('budget') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="budget">Budget <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="budget" name="budget"
                                        placeholder="Enter Budget" value="{{ old('budget', $lead->budget) }}">
                                    @error('budget')
                                        <span id="budget-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-4 mb-2 {{ $errors->has('source') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="source">Source <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" name="source" id="source">
                                        <option value="">Please Select</option>
                                        <option value="crm"
                                            {{ old('source', $lead->source) == 'crm' ? 'selected' : '' }}>CRM</option>
                                        <option value="website"
                                            {{ old('source', $lead->source) == 'website' ? 'selected' : '' }}>Website
                                        </option>
                                    </select>
                                    @error('source')
                                        <span id="source-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-8 mb-2 {{ $errors->has('assigned_to') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="assigned_to">Assigned To <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" name="assigned_to" id="assigned_to">
                                        <option value="">Please Select</option>
                                        @foreach ($assignees as $assignee)
                                            <option value="{{ $assignee->id }}"
                                                {{ old('assigned_to', $lead->assigned_to) == $assignee->id ? 'selected' : '' }}>
                                                {{ $assignee->firstname }} {{ $assignee->lastname }}</option>
                                        @endforeach
                                    </select>
                                    @error('assigned_to')
                                        <span id="assigned_to-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 mb-2 {{ $errors->has('description') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="description">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter description">{{ old('description', $lead->description) }}</textarea>
                                    @error('description')
                                        <span id="description-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 mb-2 {{ $errors->has('attachments') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="attachments">Attachments</label>
                                    <input type="file" name="attachments[]" id="attachments"
                                        class="form-control bg-transparent" multiple />
                                    @error('attachments')
                                        <span id="attachments-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <div id="attachmentPreview" class="d-flex flex-wrap gap-2"></div>
                                </div>
                                @if (count($lead->attachments) > 0)
                                    <div class="col-lg-12 mb-2">
                                        @include('superadmin.lead-management.leads.attachments')
                                    </div>
                                @endif
                                <div class="col-lg-12 text-end">
                                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark"><i
                                            class="bi bi-arrow-left me-1"></i>Back</a>
                                    <button type="submit" class="btn btn-sm btn-primary" form="leadForm">
                                        <i class="bi bi-floppy me-1"></i>Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach ($lead->attachments as $key => $attachment)
        <form id='attachment-form{{ $attachment->id }}'
            action='{{ route('superadmin.leads.delete-attachment', $attachment->id) }}' method='POST'>
            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
            <input type='hidden' name='_method' value='DELETE'>
        </form>
    @endforeach
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            let selectedFiles = [];

            $('#attachments').on('change', function() {
                selectedFiles = Array.from(this.files);
                renderPreviews();
            });

            function renderPreviews() {
                const previewContainer = $('#attachmentPreview');
                previewContainer.empty();

                selectedFiles.forEach((file, index) => {
                    const fileName = file.name;
                    const fileType = file.type;
                    const fileExt = fileName.split('.').pop().toLowerCase();

                    const card = $(`
                    <div class="card shadow-sm" style="width: 180px; position: relative;" id="file-card-${index}">
                        <div class="overlay d-flex justify-content-between p-2" style="position: absolute; top: 0; right: 0; z-index: 2;">
                            <button type="button" class="btn btn-xs btn-icon btn-danger remove-file" data-index="${index}" style="border-radius: 50%;">
                                <i class="bi bi-x fs-4"></i>
                            </button>
                        </div>
                        <div class="card-body text-center p-2 d-flex flex-column align-items-center justify-content-center" style="height: 150px;">
                            <div class="mb-2" id="file-preview-${index}"></div>
                            <div class="text-truncate w-100" title="${fileName}" style="font-size: 0.85rem;">${fileName}</div>
                        </div>
                    </div>
                `);

                    const previewTarget = card.find(`#file-preview-${index}`);

                    if (fileType.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewTarget.html(
                                `<img src="${e.target.result}" class="img-fluid rounded" style="max-height: 80px;">`
                            );
                        };
                        reader.readAsDataURL(file);
                    } else if (fileType.startsWith('video/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewTarget.html(`
                            <video src="${e.target.result}" controls style="max-height: 80px; width: 100%; border-radius: 6px;">
                                Your browser does not support the video tag.
                            </video>
                        `);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        let iconClass = 'bi-file-earmark-fill';
                        let iconColor = 'text-secondary';

                        if (fileExt === 'pdf') {
                            iconClass = 'bi-file-earmark-pdf-fill';
                            iconColor = 'text-danger';
                        } else if (['doc', 'docx'].includes(fileExt)) {
                            iconClass = 'bi-file-earmark-word-fill';
                            iconColor = 'text-primary';
                        } else if (['xls', 'xlsx', 'csv'].includes(fileExt)) {
                            iconClass = 'bi-file-earmark-excel-fill';
                            iconColor = 'text-success';
                        } else if (['ppt', 'pptx'].includes(fileExt)) {
                            iconClass = 'bi-file-earmark-slides-fill';
                            iconColor = 'text-warning';
                        } else if (fileExt === 'txt') {
                            iconClass = 'bi-file-earmark-text-fill';
                            iconColor = 'text-muted';
                        }

                        previewTarget.html(`<i class="bi ${iconClass} ${iconColor} fs-1"></i>`);
                    }

                    previewContainer.append(card);
                });

                // SweetAlert confirmation on delete
                $('.remove-file').on('click', function() {
                    const indexToRemove = $(this).data('index');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This file will be removed from the upload list.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, remove it!',
                        cancelButtonText: 'Cancel',

                    }).then((result) => {
                        if (result.isConfirmed) {
                            selectedFiles.splice(indexToRemove, 1);
                            updateInputFiles();
                            renderPreviews();

                        }
                    });
                });
            }

            function updateInputFiles() {
                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => dataTransfer.items.add(file));
                $('#attachments')[0].files = dataTransfer.files;
            }
        });
    </script>
    <script>
        function confirmAttachmentDelete(e) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This file will be removed from the upload list.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel',
            }).then(t => {
                t.isConfirmed && document.getElementById("attachment-form" + e).submit()
            })
        }
    </script>
@endpush
