@extends('layouts.superadmin')
@section('title', 'Customers | Superadmin')
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
                        <a href="{{ route('superadmin.customers.create') }}" class="btn btn-sm btn-primary"><i
                                class="bi bi-plus-circle me-1"></i>Add
                            Customer</a>
                    </div>
                    <h4 class="page-title">Customers</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Customer Management</li>
                        <li class="breadcrumb-item active">Customers</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('superadmin.includes.flash-message')

                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                        <div class="card">
                            <div class="card-body">
                                <form class="row g-2" action="{{ route('superadmin.customers.index') }}">
                                    <div class="col-md-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control form-control-sm"
                                            placeholder="Search by name" name="name" id="name"
                                            value="{{ $filter['name'] }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="name" class="form-label">Email
                                            Address</label>
                                        <input type="email" class="form-control form-control-sm"
                                            placeholder="Search by email" name="email" id="email"
                                            value="{{ $filter['email'] }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="name" class="form-label">Phone
                                            Number</label>
                                        <input type="text" class="form-control form-control-sm"
                                            placeholder="Search by phone" name="phone" id="phone"
                                            oninput="this.value = this.value.slice(0, 10)" value="{{ $filter['phone'] }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="statuses" class="form-label">Status</label>
                                        <select name="status" id="statuses" class="form-select form-select-sm">
                                            <option value="">All</option>
                                            <option value="1" {{ $filter['status'] == '1' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="0" {{ $filter['status'] == '0' ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <label class="form-label text-white d-block opacity-0">Filter
                                            label</label>
                                        <button type="submit" class="btn btn-sm btn-secondary"><i
                                                class="mdi mdi-magnify search-icon">
                                            </i>Search</button>
                                        <a href="{{ route('superadmin.customers.index') }}"
                                            class="btn btn-sm btn-dark">Reset</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-md-5 mb-xl-5">
                        <table id="basic-datatable"
                            class="table table-sm align-middle table-row-dashed fs-6 gy-5 dataTable">
                            <thead>
                                <tr>
                                    <th class="all th-primary" width="1%">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="all-rows">
                                            <label class="form-check-label">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th class="th-primary">Customer</th>
                                    <th class="th-primary">Email</th>
                                    <th class="th-primary">Phone</th>
                                    <th class="th-primary">Linked Vehicles</th>
                                    <th class="th-primary">Active</th>
                                    <th class="th-primary">Date Created</th>
                                    <th class="th-primary"></th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach ($users as $user)
                                    <tr>
                                        <td width="1%">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input checkbox-row" name="rows"
                                                    id="customCheck{{ $user->id }}" value="{{ $user->id }}">
                                                <label class="form-check-label"
                                                    for="customCheck{{ $user->id }}">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="table-user">
                                            <a href="{{ route('superadmin.users.show', $user->slug) }}"
                                                class="text-body fw-semibold">{{ $user->fullname }}</a>
                                        </td>
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                        <td>
                                            {{ $user->phone }}
                                        </td>
                                        <td>
                                         {{ count($user->linkedVehicles) }}
                                        </td>
                                        <td>
                                            <div
                                                class="form-check form-switch form-check-custom form-check-primary form-check-solid">
                                                <input class="form-check-input h-20px w-40px status" type="checkbox"
                                                    value="{{ $user->id }}"
                                                    @if ($user->status == true) checked @endif
                                                    id="switch{{ $user->id }}" />
                                                <label class="form-check-label" for="switch{{ $user->id }}">

                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <i class="uil-calender me-1"></i>
                                            {{ \Carbon\Carbon::parse($user->created_at)->format('M d Y') }}<br>
                                            <i class="uil-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($user->created_at)->format('h:i A') }}
                                        </td>
                                        <td class="text-end">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="dripicons-dots-3 text-primary fs-3"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">

                                                <a href="{{ route('superadmin.customers.show', $user->slug) }}"
                                                    class="dropdown-item"><i class="uil uil-eye me-1"></i>
                                                    View
                                                    Customer</a>
                                                <a href="{{ route('superadmin.customers.edit', $user->slug) }}"
                                                    class="dropdown-item"><i class="uil-pen me-1"></i>
                                                    Edit
                                                    Customer</a>
                                                <a href="javascript:void(0);"
                                                    onclick="confirmDelete({{ $user->id }})" class="dropdown-item"><i
                                                        class="uil-trash-alt me-1"></i>
                                                    Delete
                                                    Customer</a>
                                                <form id='delete-form{{ $user->id }}'
                                                    action='{{ route('superadmin.customers.destroy', $user->id) }}'
                                                    method='POST'>
                                                    <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                                    <input type='hidden' name='_method' value='DELETE'>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}

                    </div>

                </div>
            </div>
        </div>
    </div>
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
                paging: !1,
                pageLength: 20,
                lengthChange: !1,
                searching: !1,
                ordering: !0,
                info: !1,
                autoWidth: !1,
                responsive: !0,
                order: [
                    [1, "desc"]
                ],
                columnDefs: [{
                    targets: [0],
                    visible: !0,
                    searchable: !0
                }],
                columns: [{
                    orderable: !1
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !0
                }, {
                    orderable: !1
                }, ]
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
                text: "You want to delete selected rows!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete selected!"
            }).then(t => {
                t.isConfirmed && ($("#delete-all").text("Deleting..."), e.preventDefault(), $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('superadmin.customers.bulk-delete') }}",
                    data: {
                        customers: rows,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(e) {
                        location.reload()
                    }
                }))
            })
        });

        $(".status").change(function() {
            var url = "{{ route('superadmin.customers.change-status', ':id') }}";
            url = url.replace(':id', this.value);
            window.location.href = url;
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
@endpush
