@extends('layouts.superadmin')
@section('title', 'Deriatives | Superadmin')

@section('head')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Deriatives</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Vehicle Settings</li>
                        <li class="breadcrumb-item active">Deriatives</li>
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
                <div class="card card-flush mb-5">
                    <div class="card-body pt-3">
                        <form method="GET" action="{{ route('superadmin.derivatives.index') }}">
                                <div class="row align-items-end">

                                    <div class="col-md-3 mb-2">
                                        <label class="col-form-label text-white">Derivative Name</label>
                                        <input type="text" name="name" class="form-control form-control-sm"
                                            value="{{ $filter['name'] ?? '' }}" placeholder="Search by derivative name">
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        <label class="col-form-label text-white">Manufacturer</label>
                                        <select name="manufacturer" id="filter_manufacturer" class="form-select form-select-sm">
                                            <option value="">All</option>
                                            @foreach ($manufacturers as $man)
                                                <option value="{{ $man->name }}" data-cap-id="{{ $man->cap_id }}"
                                                    @selected(($filter['manufacturer'] ?? '') == $man->name)>
                                                    {{ $man->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        <label class="col-form-label text-white">Model</label>
                                        <select name="model" id="filter_model" class="form-select form-select-sm">
                                            <option value="">All</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        <label class="col-form-label text-white">Discount (%)</label>
                                        <input type="number" step="0.01" name="discount"
                                            value="{{ $filter['discount'] ?? '' }}" class="form-control form-control-sm"
                                            placeholder="e.g. 5.00">
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <label class="col-form-label text-white">Action</label>
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-sm btn-secondary w-50">
                                                <i class="ki-outline ki-magnifier"></i> Search
                                            </button>
                                            <a href="{{ route('superadmin.derivatives.index') }}"
                                                class="btn btn-sm btn-dark w-50 border border-secondary">Clear</a>
                                        </div>
                                    </div>

                                </div>
                            </form>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <table id="basic-datatable" class="table table-sm align-middle table-row-dashed fs-6 gy-5 dataTable">
                   <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">

                                        <th class="min-w-250px th-primary">Manufacturer</th>
                                          <th class="min-w-250px th-primary">Model</th>
                                         <th class="min-w-250px th-primary">Variant</th>
                                        <th class="min-w-100px th-primary">Discount (%)</th>
                                        <th class="min-w-100px th-primary">Profit (£)</th>
                                    </tr>
                                </thead>

                                <tbody class="fw-semibold text-gray-600">
                                    @foreach ($derivatives as $item)
                                        @php
                                            $manufacturer = \App\Models\Manufacturer::where(
                                                'cap_id',
                                                $item->cap_id,
                                            )->first();
                                            $model = \App\Models\Model::where('capmod_id', $item->capmod_id)->first();
                                        @endphp

                                        <tr>

                                            <td>
                                                 <span class="text-gray-900 fw-bold fs-6">
                                                        {{ $manufacturer->name ?? '-' }}
                                                    </span>
                                            </td>
                                             <td>




                                               <span class="text-muted fs-7">
                                                        {{ $model->name ?? '-' }}
                                                    </span>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)"
                                                        class="fw-semibold text-primary opacity-75-hover fs-7">
                                                        {{ $item->name }}
                                                    </a>
                                                    <div class="small text-muted">
                                                        INTRODUCED: {{ \Carbon\Carbon::parse($item->introduced)->format('d/m/Y') }}
                                                    </div>
                                            </td>

                                            <td>
                                                <input type="number" class="form-control form-control-sm discount-input bg-light-success border-success-subtle"
                                                    data-id="{{ $item->id }}" value="{{ $item->discount_percent }}"
                                                    min="0" max="100" step="0.01" style="width: 100%; font-weight: bold;">
                                            </td>

                                            <td>
                                                <input type="number" class="form-control form-control-sm profit-input bg-light-primary border-primary-subtle"
                                                    data-id="{{ $item->id }}" value="{{ $item->profit }}"
                                                    min="0" step="0.01" style="width: 100%; font-weight: bold;">
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                </table>
                {{ $derivatives->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // 1. Initialize DataTable
            $("#derivatives-table").DataTable({
                paging: false,
                searching: false,
                info: false,
                ordering: true,
                autoWidth: false,
                responsive: true,
                order: [[0, "asc"]],
                columnDefs: [{ orderable: false, targets: [2, 3] }]
            });

            // 2. Beautiful Toast Configuration
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });

            // 3. Safe URL base generation
            // We strip any trailing slashes or "index" to get a clean base
            const baseDerivativeUrl = "{{ route('superadmin.derivatives.index') }}".split('?')[0].replace(/\/+$/, '');
            const updateDiscountUrl = baseDerivativeUrl + '/update-discount/';
            const updateProfitUrl = baseDerivativeUrl + '/update-profit/';

            // ---- Update Discount (%) ----
            $(".discount-input").on("change", function() {
                let id = $(this).data("id");
                let value = $(this).val();

                $.ajax({
                    url: updateDiscountUrl + id,
                    type: "POST",
                    data: {
                        discount_percent: value,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Discount updated successfully',
                            background: '#f0fff4',
                            iconColor: '#38a169'
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: xhr.responseJSON?.message ?? "Could not update discount."
                        });
                    }
                });
            });

            // ---- Update Profit (£) ----
            $(".profit-input").on("change", function() {
                let id = $(this).data("id");
                let value = $(this).val();

                $.ajax({
                    url: updateProfitUrl + id,
                    type: "POST",
                    data: {
                        profit: value,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Profit updated successfully',
                            background: '#f0faff', // Soft blue for profit
                            iconColor: '#009ef7'
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: xhr.responseJSON?.message ?? "Could not update profit."
                        });
                    }
                });
            });

            // 4. Model Loading Logic
            function loadModels() {
                let capId = $("#filter_manufacturer option:selected").data("cap-id");
                let selectedModel = @json($filter['model'] ?? '');

                if (!capId) {
                    $("#filter_model").html('<option value="">All</option>');
                    return;
                }

                $("#filter_model").html('<option value="">Loading...</option>');

                $.ajax({
                    url: "{{ route('superadmin.models.hpi-models') }}",
                    type: "GET",
                    data: { manCode: capId },
                    success: function(response) {
                        $("#filter_model").html('<option value="">All</option>');
                        response.forEach(function(item) {
                            $("#filter_model").append(`
                                <option value="${item.name}" ${item.name === selectedModel ? 'selected' : ''}>
                                    ${item.name}
                                </option>
                            `);
                        });
                    }
                });
            }

            $("#filter_manufacturer").change(function() {
                loadModels();
            });

            if($("#filter_manufacturer").val() != "") {
                loadModels();
            }
        });

        // Global function for delete (keep outside document.ready)
        function confirmDelete(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "This derivative will be deleted permanently.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("delete-form" + id).submit();
                }
            });
        }
    </script>
@endpush

