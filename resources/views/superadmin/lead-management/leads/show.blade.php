@extends('layouts.superadmin')
@section('title', 'Show Lead | Superadmin')
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
                        <a href="{{ route('superadmin.leads.edit', $lead->id) }}" class="btn btn-sm btn-primary"
                            form="leadForm"><i class="bi bi-pen me-1"></i>Edit</a>
                    </div>
                    <h4 class="page-title">Show Lead</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Lead Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.leads.index') }}">Leads</a></li>
                        <li class="breadcrumb-item active">Show Lead</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('superadmin.includes.flash-message')
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <table class="table table-bordered table-sm mb-2">
                    <tr>
                        <th width="20%">Customer Name</th>
                        <td class="text-dark">{{ $lead->name }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Designation</th>
                        <td class="text-dark">{{ $lead->designation }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Company</th>
                        <td class="text-dark">{{ $lead->company }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Email Address</th>
                        <td class="text-dark">{{ $lead->email }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Phone Number</th>
                        <td class="text-dark">{{ $lead->phone }}</td>
                    </tr>
                </table>
                <table class="table table-bordered table-sm mb-2">
                    <tr>
                        <th width="20%">Event Type</th>
                        <td class="text-dark">{{ $lead->event_type }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Event Date</th>
                        <td class="text-dark">{{ $lead->event_date }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Event Location</th>
                        <td class="text-dark">{{ $lead->location }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Budget</th>
                        <td class="text-dark">{{ $lead->budget }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Source</th>
                        <td class="text-dark">{{ ucfirst($lead->source) }}</td>
                    </tr>
                    <tr>
                        <th width="20%">Description</th>
                        <td class="text-dark">{{ $lead->description }}</td>
                    </tr>
                </table>
                <table class="table table-bordered table-sm mb-2">
                    <tr>
                        <td width="50%"><a href="{{ route('superadmin.quotations.create', ['lead_id' => $lead->id]) }}"
                                class="btn btn-sm btn-outline-secondary w-100">Create Quotation</a></td>
                        <td width="50%"><a href="javascript:void(0)" data-bs-toggle="modal"
                                data-bs-target="#activitiesModal" class="btn btn-sm btn-secondary w-100">Lead
                                Activities</a></td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-4">
                <table class="table table-sm mb-2">
                    <tr>
                        <th width="75%">
                            <label for="status">LEAD STATUS</label>
                        </th>
                        <td></td>
                    </tr>
                    <tr>
                        <th width="75%">
                            <select id="statuses" class="form-select form-select-sm" onchange="changeStatus()">
                                <option value="">Select</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" {{ $lead->status == $status ? 'selected' : '' }}>
                                        {{ $status }}</option>
                                @endforeach
                            </select>
                            <form action="{{ route('superadmin.leads.update-status', $lead->id) }}" method="POST"
                                class="d-none" id="leadStatusForm">
                                @csrf
                                @method('PUT')
                                <input type="text" name="status" id="status" class="form-control form-control-sm">
                            </form>
                        </th>
                        <td width="25%" class="text-end">
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#historyModal"
                                class="btn btn-sm btn-warning w-100">History</a>
                        </td>
                    </tr>
                </table>
                <table class="table table-sm mb-2">
                    <tr>
                        <th width="75%">
                            <label for="status">ASSIGNED TO</label>
                        </th>
                        <td></td>
                    </tr>
                    <tr>
                        <th width="75%">
                            <form action="{{ route('superadmin.leads.assign') }}" method="POST" id="assignForm">
                                @csrf
                                <input type="hidden" name="lead_id" id="lead_id" value="{{ $lead->id }}">
                                <select name="assigned_to" id="assigned_to" class="form-select form-select-sm">
                                    <option value="">Select</option>
                                    @foreach ($assignees as $assigne)
                                        <option value="{{ $assigne->id }}"
                                            {{ $lead->assigned_to == $assigne->id ? 'selected' : '' }}>
                                            {{ $assigne->firstname }} {{ $assigne->lastname }}</option>
                                    @endforeach
                                </select>
                            </form>

                        </th>
                        <td width="25%" class="text-end">
                            <button type="submit" form="assignForm" class="btn btn-sm btn-success w-100">Assign</button>
                        </td>
                    </tr>
                </table>
                <table class="table table-sm mb-2">
                    <tr>
                        <th width="75%">
                            <label for="status">TASKS</label>
                        </th>
                        <td></td>
                    </tr>
                    <tr>
                        <th width="75%">
                            <a href="{{ route('superadmin.tasks.create', ['lead_id' => $lead->id]) }}"
                                class="btn btn-sm btn-outline-primary w-100">Add Task</a>
                        </th>
                        <td width="25%" class="text-end">
                            <a href="{{ route('superadmin.tasks.index', ['lead_id' => $lead->id]) }}"
                                class="btn btn-sm btn-primary w-100">View All</a>
                        </td>
                    </tr>
                </table>
                <table class="table table-sm mb-2">
                    <tr>
                        <th width="75%">
                            <label for="status">NOTES</label>
                        </th>
                        <td></td>
                    </tr>
                    <tr>
                        <th width="75%">
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addNoteModal"
                                class="btn btn-sm btn-outline-dark w-100">Add Note</a>
                        </th>
                        <td width="25%" class="text-end">
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#notesModal"
                                class="btn btn-sm btn-dark w-100">View All</a>
                        </td>
                    </tr>
                </table>
                <table class="table table-sm mb-2">
                    <tr>
                        <th width="75%">
                            <label for="status">ATTACHMENTS</label>
                        </th>
                        <td></td>
                    </tr>
                    <tr>
                        <th width="75%">
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addAttachmentModal"
                                class="btn btn-sm btn-outline-danger w-100">Add Attachment</a>
                        </th>
                        <td width="25%" class="text-end">
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#attachmentsModal"
                                class="btn btn-sm btn-danger w-100">View All</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @include('superadmin.lead-management.leads.modals.status.history')
    @include('superadmin.lead-management.leads.modals.tasks.add-tasks')
    @include('superadmin.lead-management.leads.modals.tasks.view-tasks')
    @include('superadmin.lead-management.leads.modals.notes.add-notes')
    @include('superadmin.lead-management.leads.modals.notes.view-notes')
    @include('superadmin.lead-management.leads.modals.attachments.add-attachments')
    @include('superadmin.lead-management.leads.modals.attachments.view-attachments')
    @include('superadmin.lead-management.leads.modals.activities.view-activities')
@endsection
@push('scripts')
    <script>
        function changeStatus() {
            var status = $('#statuses').val();
            $('#status').val(status);
            $('#leadStatusForm').submit();

        }
    </script>
@endpush
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
                        <div class="overlay d-flex justify-content-end p-2" style="position: absolute; top: 0; right: 0; z-index: 2;">
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
@endpush
