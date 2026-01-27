@extends('layouts.superadmin')
@section('title', 'Vehicles | Superadmin')
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
                    </div>
                    <h4 class="page-title">Vehicles</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Vehicle Management</li>
                        <li class="breadcrumb-item active">Vehicles</li>
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
                @include('superadmin.vehicles.filter')
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="col-12">
                    <table id="basic-datatable" class="table table-sm align-top table-striped fs-6 gy-5 dataTable">
                        <thead>
                            <tr>
                                <th class="all th-primary" width="1%">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="all-rows">
                                        <label class="form-check-label">&nbsp;</label>
                                    </div>
                                </th>
                                <th class="th-primary" width="20%">Vehicle Details</th>
                                <th class="th-primary text-center" width="12%">Registration</th>
                                <th class="th-primary text-center" width="15%">VIN</th>
                                <th class="th-primary">Pricing</th>
                                <th class="th-primary">Stock Status</th>
                                <th class="th-primary text-center">Status</th>
                                {{-- <th class="th-primary">Added On</th> --}}
                                <th class="th-primary"></th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @foreach ($vehicles as $vehicle)
                                <tr>
                                    <td width="1%">
                                        <div class="form-check" style="margin-left:7.412px !important;">
                                            <input type="checkbox" class="form-check-input checkbox-row" name="rows"
                                                id="customCheck{{ $vehicle->id }}" value="{{ $vehicle->id }}">
                                            <label class="form-check-label"
                                                for="customCheck{{ $vehicle->id }}">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary-lighten rounded-pill"
                                            style="font-size:0.975em !important; min-width:100%; margin-bottom:8px !important; padding: 0.65em 0.65em !important; text-align:left !important">{{ $vehicle->manufacturerData->name }}</span>
                                        <span class="badge badge-secondary-lighten rounded-pill"
                                            style="font-size:0.975em !important; min-width:100%; margin-bottom:8px !important; padding: 0.65em 0.65em !important; text-align:left !important">{{ $vehicle->modelData->name }}</span>
                                        <span class="badge badge-success-lighten rounded-pill"
                                            style="font-size:0.975em !important; min-width:100%; padding: 0.65em 0.65em !important; text-align:left !important">{{ $vehicle->variantData->name }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="uk-plate rounded-pill">
                                            {{ $vehicle->registration }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="vin-plate">
                                            {{ $vehicle->vin }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">

                                            @if ($vehicle->is_business_lease)
                                                <span class="badge bg-primary rounded-pill"
                                                    style="font-size:0.975em !important; min-width:100%; margin-bottom:0px !important; padding: 0.65em 0.65em !important; text-align:left !important">
                                                    <i class="bi bi-check2 me-1"></i> Business Lease
                                                </span>
                                            @endif

                                            @if ($vehicle->is_hire_purchase)
                                                <span class="badge rounded-pill"
                                                    style="font-size:0.975em !important; min-width:100%; margin-bottom:8px !important; padding: 0.65em 0.65em !important; text-align:left !important; background-color: #F633B3 !important;">
                                                    <i class="bi bi-check2 me-1"></i> Hire Purchase
                                                </span>
                                            @endif

                                            @if (!$vehicle->is_business_lease && !$vehicle->is_hire_purchase)
                                                <span class="badge bg-warning rounded-pill"
                                                    style="font-size:0.975em !important; min-width:100%; margin-bottom:0px !important; padding: 0.65em 0.65em !important; text-align:left !important">
                                                    None
                                                </span>
                                            @endif

                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if ($vehicle->stock_status == 'in_stock')
                                            <span class="badge bg-success rounded-pill d-block mb-1"
                                                style="font-size:0.975em !important; min-width:100%; margin-bottom:0px !important; padding: 0.65em 0.65em !important; text-align:center !important">
                                                In Stock
                                            </span>
                                        @else
                                            <span class="badge bg-danger rounded-pill d-block mb-1"
                                                style="font-size:0.975em !important; min-width:100%; margin-bottom:0px !important; padding: 0.65em 0.65em !important; text-align:center !important">
                                                Out Of Stock
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($vehicle->stock_status)
                                            <span class="badge bg-dark rounded-pill d-block mb-1"
                                                style="font-size:0.975em !important; min-width:100%; margin-bottom:0px !important; padding: 0.65em 0.65em !important; text-align:center !important">
                                                Active
                                            </span>
                                        @else
                                            <span class="badge bg-danger rounded-pill d-block mb-1"
                                                style="font-size:0.975em !important; min-width:100%; margin-bottom:0px !important; padding: 0.65em 0.65em !important; text-align:center !important">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    {{-- <td>
                                        <i class="uil-calender me-1"></i>
                                        {{ \Carbon\Carbon::parse($vehicle->created_at)->format('M d Y') }}<br>
                                        <i class="uil-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($vehicle->created_at)->format('h:i A') }}
                                    </td> --}}
                                    <td class="text-end">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical fs-4"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">

                                            <a href="{{ route('superadmin.vehicles.show', $vehicle->id) }}"
                                                class="dropdown-item"><i class="uil uil-eye me-1"></i>
                                                View
                                                Vehicle</a>
                                            <a href="{{ route('superadmin.vehicles.edit', $vehicle->id) }}"
                                                class="dropdown-item"><i class="uil-pen me-1"></i>
                                                Edit
                                                Vehicle</a>
                                            <a href="javascript:void(0);" onclick="confirmDelete({{ $vehicle->id }})"
                                                class="dropdown-item"><i class="uil-trash-alt me-1"></i>
                                                Delete
                                                Vehicle</a>
                                            <form id='delete-form{{ $vehicle->id }}'
                                                action='{{ route('superadmin.vehicles.destroy', $vehicle->id) }}'
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
                    {{ $vehicles->appends(request()->query())->links('pagination::bootstrap-5') }}
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

    <script>
        $("#basic-datatable").DataTable({
            paging: false,
            searching: false,
            info: false,
            responsive: true,
            ordering: true,
            autoWidth: false,
            order: [
                [0, "asc"]
            ],
            columnDefs: [{
                orderable: false,
                targets: -1 // last column (Actions)
            }]
        });


        function confirmDelete(id, msg = false) {
            Swal.fire({
                title: "Are you sure?",
                text: msg == false ? 'This product will be deleted permanently.' :
                    'You want to recover this vehicle.',
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: msg == false ? "Delete" : "Recover",
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("delete-form" + id).submit();
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {

            $("#filter_manufacturer").change(function() {

                let capId = $("#filter_manufacturer option:selected").data("cap-id");
                let selectedModel = "{{ $filter['model'] ?? '' }}";

                $("#filter_model").html('<option value="">Loading...</option>');

                // If Manufacturer = All
                if (!capId) {
                    $("#filter_model").html('<option value="">All</option>');
                    return;
                }

                $.ajax({
                    url: "{{ route('superadmin.models.hpi-models') }}",
                    type: "GET",
                    data: {
                        manCode: capId
                    },
                    success: function(response) {

                        $("#filter_model").html('<option value="">All</option>');

                        response.forEach(function(item) {

                            // MODEL NAME comes from item.name
                            $("#filter_model").append(`
                        <option value="${item.capmod_id}"
                            ${item.name === selectedModel ? 'selected' : ''}>
                            ${item.name}
                        </option>
                    `);

                        });
                    }
                });

            });

        });
    </script>
@endpush
