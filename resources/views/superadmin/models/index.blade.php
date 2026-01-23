@extends('layouts.superadmin')
@section('title', 'Models | Superadmin')

@section('head')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Models</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Vehicle Settings</li>
                        <li class="breadcrumb-item active">Models</li>
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
            <div class="col-12">
                 <div class="card card-flush">
                        <div class="card-body pt-3">
                            <form action="{{ route('superadmin.models.index') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="col-form-label">Model Name</label>
                                        <input type="text" class="form-control form-control-sm" name="name"
                                            value="{{ $filter['name'] ?? '' }}" placeholder="Search by name">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="col-form-label">Manufacturer</label>
                                        <select name="manufacturer" class="form-control form-control-sm">
                                            <option value="">All</option>
                                            @foreach ($manufacturers as $man)
                                                <option value="{{ $man->name }}" @selected(($filter['manufacturer'] ?? '') == $man->name)>
                                                    {{ $man->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="col-form-label">CAP ID</label>
                                        <input type="text" class="form-control form-control-sm" name="cap_id"
                                            value="{{ $filter['cap_id'] ?? '' }}" placeholder="Search by CAP ID">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="col-form-label">Status</label>
                                        <select name="status" class="form-control form-control-sm">
                                            <option value="">All</option>
                                            <option value="active" {{ ($filter['status'] ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ ($filter['status'] ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-sm btn-secondary"><i class="mdi mdi-magnify search-icon"></i>Search</button>
                                    <a href="{{ route('superadmin.models.index') }}" class="btn btn-sm btn-dark">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>

            <div class="col-12">
                <table id="basic-datatable" class="table table-sm align-middle table-row-dashed fs-6 gy-5 dataTable">
                   <thead>
                        <tr>
                            <th class="th-primary" width="10%">Manufacturer</th>
                            <th class="th-primary" width="40%">Model</th>
                            <th class="th-primary" width="15%">Discount (%)</th>
                            <th class="th-primary" width="15%">Profit (£)</th>
                            <th class="th-primary text-center" width="10%">Status</th>
                            <th class="text-end th-primary" width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($models as $item)
                            <tr>
                                <td> <span class="fw-bold text-body">{{ $item->manufacturer ?? '-' }}</span></td>
                                <td>
                                       <a href="{{ route('superadmin.models.show', $item->id) }}" class="text-muted font-13">{{ $item->name }}</a>
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm discount-input"
                                        data-id="{{ $item->id }}" value="{{ $item->discount_percent }}"
                                        min="0" max="100" step="0.01" style="width: 100%; font-weight: bold;">
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm profit-input"
                                        data-id="{{ $item->id }}" value="{{ $item->profit }}"
                                        min="0" step="0.01" style="width: 100%; font-weight: bold;">
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" id="switch{{ $item->id }}" value="{{ $item->id }}"
                                           onchange="callStatusUpdate({{ $item->id }})"
                                           @checked($item->status) data-switch="none"/>
                                    <label for="switch{{ $item->id }}" data-on-label="ON" data-off-label="OFF"></label>
                                </td>
                                <td class="text-end">
                                    <form method="GET" action="{{ route('superadmin.derivatives.index') }}" id="derivative{{ $item->id }}">
                                        <input type="hidden" name="manufacturer" value="{{ $item->manufacturer }}">
                                        <input type="hidden" name="model" value="{{ $item->name }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Derivatives</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $models->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            if ($("#basic-datatable").length > 0) {
                $("#basic-datatable").DataTable({
                    paging: false,
                    searching: false,
                    info: false,
                    ordering: true,
                    autoWidth: false,
                    responsive: true
                });
            }
        });

        // 1. UPDATE DISCOUNT
        $(".discount-input").on("change", function() {
            let id = $(this).data("id");
            let value = $(this).val();
            let url = "{{ route('superadmin.models.update-discount', ['id' => '_ID_']) }}".replace('_ID_', id);

            $.ajax({
                url: url,
                type: "POST",
                data: { discount_percent: value, _token: "{{ csrf_token() }}" },
                success: function(res) {
                    Swal.fire({ icon: "success", title: "Updated", text: "Discount updated.", timer: 1000, showConfirmButton: false, toast: true, position: 'top-end' });
                },
                error: function(xhr) {
                    Swal.fire({ icon: "error", title: "Error", text: "Failed to update discount." });
                }
            });
        });

        // 2. UPDATE PROFIT
        $(".profit-input").on("change", function() {
            let id = $(this).data("id");
            let value = $(this).val();
            let url = "{{ route('superadmin.models.update-profit', ['id' => '_ID_']) }}".replace('_ID_', id);

            $.ajax({
                url: url,
                type: "POST",
                data: { profit: value, _token: "{{ csrf_token() }}" },
                success: function(res) {
                    Swal.fire({ icon: "success", title: "Updated", text: "Profit updated.", timer: 1000, showConfirmButton: false, toast: true, position: 'top-end' });
                },
                error: function(xhr) {
                    Swal.fire({ icon: "error", title: "Error", text: "Failed to update profit." });
                }
            });
        });

        // 3. UPDATE STATUS
        function callStatusUpdate(id) {
            let checkbox = $('#switch' + id);
            let statusValue = checkbox.is(':checked') ? 1 : 0;
            let url = "{{ route('superadmin.models.change-status', ['id' => '_ID_']) }}".replace('_ID_', id);

            $.ajax({
                url: url,
                type: "GET",
                data: { status: statusValue },
                success: function(res) {
                    Swal.fire({
                        icon: statusValue === 1 ? "success" : "warning",
                        title: statusValue === 1 ? "Model Activated" : "Model Deactivated",
                        timer: 1500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                },
                error: function(xhr) {
                    checkbox.prop('checked', !statusValue);
                    Swal.fire({ icon: "error", title: "Error", text: "Could not change status." });
                }
            });
        }
    </script>
@endpush
