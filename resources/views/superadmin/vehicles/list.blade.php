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
                <form action="{{ route('superadmin.vehicles.index') }}" method="GET">
                    <input type="hidden" name="is_delete" value="{{ request()->get('is_delete') }}">
                    <div class="card">
                        <div class="card-body">

                            <div class="row g-3">

                                {{-- Product Title --}}
                                <div class="col-md-3">
                                    <label class="col-form-label">Product Title</label>
                                    <input type="text" name="title" class="form-control form-control-sm"
                                        value="{{ request('title') }}" placeholder="Search title...">
                                </div>

                                 {{-- Registration --}}
                                <div class="col-md-3">
                                    <label class="col-form-label">Registration No</label>
                                    <input type="text" name="registration" class="form-control form-control-sm"
                                        value="{{ request('registration') }}" placeholder="Search By Registration No">
                                </div>

                                 {{-- Year --}}
                                <div class="col-md-3">
                                    <label class="col-form-label">Year</label>
                                    <input type="text" name="year" class="form-control form-control-sm"
                                        value="{{ request('year') }}" placeholder="Search By Year">
                                </div>

                                 {{-- Status --}}
                                <div class="col-md-3">
                                    <label class="col-form-label">Status</label>
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="">All</option>
                                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>

                                <!-- Manufacturer -->
                                <div class="col-md-3">
                                    <label class="col-form-label">Manufacturer</label>
                                    <select name="manufacturer" id="filter_manufacturer" class="form-select form-select-sm">
                                        <option value="">All</option>
                                        @foreach ($manufacturers as $man)
                                            <option value="{{ $man->cap_id }}" data-cap-id="{{ $man->cap_id }}"
                                                @selected((request('manufacturer') ?? '') == $man->cap_id)>
                                                {{ $man->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Model -->
                                <div class="col-md-3">
                                    <label class="col-form-label">Model</label>
                                    <select name="model" id="filter_model" class="form-select form-select-sm">
                                        <option value="">All</option>

                                        @if (count($fillmodels) > 0)
                                            @foreach ($fillmodels as $fmod)
                                                <option value="{{ $fmod->capmod_id }}" @selected((request('model') ?? '') == $fmod->capmod_id)>
                                                    {{ $fmod->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                </div>



                                {{-- Lease Type --}}
                                <div class="col-md-3">
                                    <label class="col-form-label">Lease Type</label>
                                    <select name="lease" class="form-select form-select-sm">
                                        <option value="">All</option>
                                        <option value="business" {{ request('lease') == 'business' ? 'selected' : '' }}>
                                            Business Lease
                                        </option>
                                        <option value="hp" {{ request('lease') == 'hp' ? 'selected' : '' }}>Hire
                                            Purchase</option>
                                    </select>
                                </div>



                                {{-- Buttons --}}
                                <div class="col-md-3 text-end">
                                    <label class="col-form-label d-block text-white">&nbsp;</label>
                                    <button type="submit" class="btn btn-sm btn-secondary">
                                        <i class="mdi mdi-magnify search-icon"></i> Search
                                    </button>

                                    <a href="{{ route('superadmin.vehicles.index') }}"
                                        class="btn btn-sm btn-dark">Reset</a>
                                </div>

                            </div>

                        </div>
                    </div>
                </form>
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
                    targets: 5
                }, // actions column
            ]
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
