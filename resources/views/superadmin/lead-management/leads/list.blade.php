@extends('layouts.superadmin')
@section('title', 'Leads | Superadmin')
@section('head')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="javascript:void(0);" class="btn btn-sm btn-flex btn-danger" style="display: none;"
                            id="delete-all">Delete Selected</a>
                            <a href="{{ route('superadmin.leads.kanban') }}" class="btn btn-sm btn-dark"><i
                                class="bi bi-kanban me-1"></i>Kanban</a>
                        <a href="{{ route('superadmin.leads.create') }}" class="btn btn-sm btn-primary"><i
                                class="bi bi-plus-circle me-1"></i>Add
                            Lead</a>
                    </div>
                    <h4 class="page-title">Leads</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Lead Management</li>
                        <li class="breadcrumb-item active">Leads</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('superadmin.includes.flash-message')
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="row g-2" action="{{ route('superadmin.leads.index') }}">
                            <div class="col-md-3">
                                <label for="name" class="col-form-label">Name</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Search by name"
                                    name="name" id="name" value="{{ $filter['name'] }}">
                            </div>

                            <div class="col-md-3">
                                <label for="name" class="col-form-label">Phone
                                    Number</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Search by phone"
                                    name="phone" id="phone" oninput="this.value = this.value.slice(0, 10)"
                                    value="{{ $filter['phone'] }}">
                            </div>
                            <div class="col-md-3">
                                <label for="budget" class="col-form-label">Budget</label>
                                <input type="number" class="form-control form-control-sm" placeholder="Search by budget"
                                    name="budget" id="budget" value="{{ $filter['budget'] }}">
                            </div>
                            <div class="col-md-3">
                                <label for="source" class="col-form-label">Source</label>
                                <select class="form-select form-select-sm" name="source" id="source">
                                    <option value="">All</option>
                                    <option value="crm" {{ $filter['source'] == "crm" ? 'selected' : '' }}>CRM</option>
                                    <option value="website" {{ $filter['source'] == "website" ? 'selected' : '' }}>Website</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="event_type" class="col-form-label">Event Type</label>
                                <input type="text" class="form-control form-control-sm"
                                    placeholder="Search by event type" name="event_type" id="event_type"
                                    value="{{ $filter['event_type'] }}">
                            </div>
                            <div class="col-md-3">
                                <label for="date_from" class="col-form-label">Date From</label>
                                <input type="date" class="form-control form-control-sm" placeholder="Search by date from"
                                    name="date_from" id="date_from" value="{{ $filter['date_from'] }}">
                            </div>
                            <div class="col-md-3">
                                <label for="date_upto" class="col-form-label">Date Upto</label>
                                <input type="date" class="form-control form-control-sm" placeholder="Search by date upto"
                                    name="date_upto" id="date_upto" value="{{ $filter['date_upto'] }}">
                            </div>
                            <div class="col-md-3">
                                <label for="statuses" class="col-form-label">Status</label>
                                <select name="status" id="statuses" class="form-select form-select-sm">
                                    <option value="">All</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status }}"
                                            {{ $filter['status'] == $status ? 'selected' : '' }}>{{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="assigned_to" class="col-form-label">Assigned To</label>
                                <select class="form-select form-select-sm" name="assigned_to" id="assigned_to">
                                    <option value="">All</option>
                                    @foreach ($assignees as $assignee)
                                        <option value="{{ $assignee->id }}"
                                            {{ $filter['assigned_to'] == $assignee->id ? 'selected' : '' }}>
                                            {{ $assignee->firstname }} {{ $assignee->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="col-md-3">
                                <label for="created_by" class="col-form-label">Created By</label>
                                <select class="form-select form-select-sm" name="created_by" id="created_by">
                                    <option value="">All</option>
                                    @foreach ($creators as $creator)
                                        <option value="{{ $creator->id }}"
                                            {{ $filter['created_by'] == $creator->id ? 'selected' : '' }}>
                                            {{ $creator->firstname }} {{ $creator->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="col-md-3">
                                <label for="created_at" class="col-form-label">Created At</label>
                                <input type="date" class="form-control form-control-sm"
                                    placeholder="Search by created at" name="created_at" id="created_at"
                                    value="{{ $filter['created_at'] }}">
                            </div>
                            <div class="col-md-3 text-end">
                                <label class="col-form-label text-white d-block opacity-0">Filter
                                    label</label>
                                <button type="submit" class="btn btn-sm btn-secondary"><i
                                        class="mdi mdi-magnify search-icon">
                                    </i>Search</button>
                                <a href="{{ route('superadmin.leads.index') }}" class="btn btn-sm btn-dark">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <table id="basic-datatable" class="table table-sm align-middle table-row-dashed fs-6 gy-5 dataTable">
                    <thead>
                        <tr>
                            <th class="all th-primary" width="1%">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="all-rows">
                                    <label class="form-check-label">&nbsp;</label>
                                </div>
                            </th>
                            <th class="th-primary d-none">ID</th>
                            <th class="th-primary">Customer</th>
                            <th class="th-primary">Event Type</th>
                            <th class="th-primary">Event Date</th>
                            <th class="th-primary">Budget</th>
                            <th class="th-primary">Source</th>
                            <th class="th-primary">Status</th>
                            <th class="th-primary">Assigned To</th>
                            <th class="th-primary">Created By</th>
                            <th class="th-primary"></th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach ($leads as $lead)
                            <tr>
                                <td width="1%">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input checkbox-row" name="rows"
                                            id="customCheck{{ $lead->id }}" value="{{ $lead->id }}">
                                        <label class="form-check-label"
                                            for="customCheck{{ $lead->id }}">&nbsp;</label>
                                    </div>
                                </td>
                                <td class="d-none">{{ $lead->id }}</td>
                                <td>
                                    <a href="{{ route('superadmin.leads.show', $lead->id) }}"
                                        class="text-body fw-semibold">{{ $lead->name }}</a>
                                    <br>
                                    <small style="font-size:0.7rem;"><i class="uil-envelope me-1"></i>{{ $lead->email }}</small>
                                    <br>
                                    <small style="font-size:0.7rem;"><i class="uil-mobile-android me-1"></i>{{ $lead->phone }}</small>
                                </td>
                                <td>{{ $lead->event_type }}</td>
                                <td>{{ \Carbon\Carbon::parse($lead->event_date)->format('d-m-Y') }}
                                </td>
                                <td>₹ {{ number_format($lead->budget) }}</td>
                                <td>{{ ucfirst($lead->source) }}</td>
                                <td>{{ $lead->status }}</td>
                                <td>
                                    @if ($lead->assigned_to)
                                        {{ $lead->assignee->firstname }} {{ $lead->assignee->lastname }}
                                    @else
                                        <button type="button" class="btn btn-xs w-100 btn-outline-primary assign-btn"
                                            data-id="{{ $lead->id }}" data-bs-toggle="modal"
                                            data-bs-target="#assignModal">
                                            Assign
                                        </button>
                                    @endif
                                </td>
                                <td><i class="uil-user me-1"></i>
                                    {{ $lead->creator->firstname }} {{ $lead->creator->lastname }}<br>
                                    <i class="uil-calender me-1"></i>
                                    {{ \Carbon\Carbon::parse($lead->created_at)->format('M d Y') }}<br>
                                    <i class="uil-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($lead->created_at)->format('h:i A') }}
                                </td>
                                <td class="text-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical fs-4"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">

                                        <a href="{{ route('superadmin.leads.show', $lead->id) }}"
                                            class="dropdown-item"><i class="uil uil-eye me-1"></i>
                                            View
                                            Lead</a>
                                        <a href="{{ route('superadmin.leads.edit', $lead->id) }}"
                                            class="dropdown-item"><i class="uil-pen me-1"></i>
                                            Edit
                                            Lead</a>
                                        <a href="javascript:void(0);" onclick="confirmDelete({{ $lead->id }})"
                                            class="dropdown-item"><i class="uil-trash-alt me-1"></i>
                                            Delete
                                            Lead</a>
                                        <form id='delete-form{{ $lead->id }}'
                                            action='{{ route('superadmin.leads.destroy', $lead->id) }}' method='POST'>
                                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                            <input type='hidden' name='_method' value='DELETE'>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $leads->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    @include('superadmin.lead-management.leads.assign')
@endsection
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap4.min.js') }}"></script>


    <!-- Datatable Init js -->
    <script>
        $(function() {
            $("#basic-datatable").DataTable({
                paging: false,
                pageLength: 20,
                lengthChange: false,
                searching: false,
                ordering: true,
                info: false,
                autoWidth: false,
                responsive: true,
                order: [
                    [1, "desc"] // Order by hidden ID column
                ],
                columnDefs: [{
                        targets: 1,
                        visible: false,
                        searchable: false
                    }, // hide ID column
                    {
                        targets: 0,
                        orderable: false
                    }, // checkbox column not orderable
                    {
                        targets: -1,
                        orderable: false
                    } // action column not orderable
                ]
            });
        });
    </script>
    <script>
        function confirmDelete(e) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete it!"
            }).then(t => {
                t.isConfirmed && document.getElementById("delete-form" + e).submit()
            })
        }
    </script>
    <script type="text/javascript">
        $("#all-rows").change(function() {
            var c = [];
            this.checked ? ($(".checkbox-row").prop("checked", !0), $("input:checkbox[name=rows]:checked").each(
                function() {
                    c.push($(this).val())
                }), $("#delete-all").css("display", "inline")) : ($(".checkbox-row").prop("checked", !1),
                c = [], $("#delete-all").css("display", "none"))
        });

        $(".checkbox-row").change(function() {
            rows = [], $("input:checkbox[name=rows]:checked").each(function() {
                rows.push($(this).val())
            }), 0 == rows.length ? $("#delete-all").css("display", "none") : $("#delete-all").css("display",
                "inline")
        });

        $("#delete-all").click(function(e) {
            rows = [], $("input:checkbox[name=rows]:checked").each(function() {
                rows.push($(this).val())
            }), Swal.fire({
                title: "Are you sure?",
                text: "You want to delete selected leads!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete selected!"
            }).then(t => {
                t.isConfirmed && ($("#delete-all").text("Deleting..."), e.preventDefault(), $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('superadmin.leads.bulk-delete') }}",
                    data: {
                        leads: rows,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(e) {
                        location.reload()
                    }
                }))
            })
        });


        function confirmDelete(e) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete it!"
            }).then(t => {
                t.isConfirmed && document.getElementById("delete-form" + e).submit()
            })
        }
    </script>
    <script>
        $(document).on('click', '.assign-btn', function() {
            var id = $(this).data('id');
            $('#lead_id').val(id);
        });
    </script>
@endpush
