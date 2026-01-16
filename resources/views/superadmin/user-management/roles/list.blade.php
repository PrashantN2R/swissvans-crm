@extends('layouts.superadmin')
@section('title', 'Roles | Superadmin')
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

                        <a href="{{ route('superadmin.roles.create') }}" class="btn btn-sm btn-primary"><i
                                class="bi bi-plus-circle me-1"></i>Add
                            Role</a>
                    </div>
                    <h4 class="page-title">Roles</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">User Management</li>
                        <li class="breadcrumb-item active">Roles</li>
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
                                <form class="row g-2" action="{{ route('superadmin.roles.index') }}">
                                    <div class="col-md-10">
                                        <label for="name" class="form-label">Role</label>
                                        <input type="text" class="form-control form-control-sm"
                                            placeholder="Search by role" name="name" id="name"
                                            value="{{ $filter['name'] }}">
                                    </div>

                                    <div class="col-md-2 text-end">
                                        <label class="form-label text-white d-block opacity-0">Filter
                                            label</label>
                                        <button type="submit" class="btn btn-sm btn-secondary"><i
                                                class="mdi mdi-magnify search-icon">
                                            </i>Search</button>
                                        <a href="{{ route('superadmin.roles.index') }}"
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
                                    <th class="th-primary" width="20%">Role</th>
                                    <th class="th-primary" width="50%">Permission</th>
                                    <th class="th-primary">Date Created</th>
                                    <th class="th-primary"></th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach ($roles as $role)
                                    <tr>
                                        <td class="table-user">
                                            <a href="{{ route('superadmin.roles.show', $role->id) }}"
                                                class="text-body fw-semibold">{{ $role->name }}</a>
                                        </td>

                                        <td>
                                            @foreach ($role->permissions as $permission)
                                                <span
                                                    class="badge badge-dark-lighten mx-1 my-1">{{ $permission->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <i class="uil-calender me-1"></i>
                                            {{ \Carbon\Carbon::parse($role->created_at)->format('M d Y') }}<br>
                                            <i class="uil-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($role->created_at)->format('h:i A') }}
                                        </td>
                                        <td class="text-end">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="dripicons-dots-3 text-primary fs-3"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="{{ route('superadmin.roles.edit', $role->id) }}"
                                                    class="dropdown-item"><i class="uil-pen me-1"></i>
                                                    Edit
                                                    Role</a>
                                                <a href="javascript:void(0);" onclick="confirmDelete({{ $role->id }})"
                                                    class="dropdown-item"><i class="uil-trash-alt me-1"></i>
                                                    Delete
                                                    Role</a>
                                                <form id='delete-form{{ $role->id }}'
                                                    action='{{ route('superadmin.roles.destroy', $role->id) }}'
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
                        {{ $roles->appends(request()->query())->links('pagination::bootstrap-5') }}
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
                    [0, "desc"]
                ],
                columnDefs: [{
                    targets: [0],
                    visible: !0,
                    searchable: !0
                }],
                columns: [{
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
@endpush
