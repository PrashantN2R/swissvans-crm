@extends('layouts.superadmin')
@section('title', 'Deals | Superadmin')

@section('head')
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .deal-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #f1f1f1;
            transition: all 0.3s ease;
        }

        .deal-card:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .text-apple-grey {
            color: #86868b;
        }

        .deal-no-badge {
            background: #f5f5f7;
            color: #1d1d1f;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Header Section --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="javascript:void(0);" class="btn btn-sm btn-danger" style="display: none;"
                            id="delete-all">
                            <i class="bi bi-trash me-1"></i> Delete Selected
                        </a>
                        <a href="{{ route('superadmin.deals.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Create New Deal
                        </a>
                    </div>
                    <h4 class="page-title">Deal Management</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Deals</li>
                    </ol>
                </div>
            </div>
        </div>

        {{-- Flash Messages --}}
        <div class="row">
            <div class="col-12">
                @include('superadmin.includes.flash-message')
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="row">
            <div class="col-12">
                @include('superadmin.deal-management.filter')
            </div>
        </div>



        {{-- Data Table --}}
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table id="basic-datatable" class="table table-sm align-top table-striped fs-6 gy-5 dataTable">
                        <thead>
                            <tr>
                                <th width="1%" class="ps-3 th-primary">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="all-rows">
                                    </div>
                                </th>
                                <th class="th-primary" width="10%">Deal No.</th>
                                <th class="th-primary" width="20%">Vehicle Details</th>
                                <th class="th-primary text-center">Registration & VIN</th>
                                <th class="th-primary" width="20%">Customer & Salesperson</th>
                                <th class="th-primary" width="15%">Financials</th>
                                <th class="th-primary" width="10%" class="text-center">Status</th>
                                <th class="th-primary" width="5%"></th>
                            </tr>
                        </thead>
                        <tbody class="fw-medium">
                            @forelse ($deals as $deal)
                                <tr>
                                    <td class="ps-3">
                                        <div class="form-check">
                                            {{-- Checkbox disabled if immutable to prevent accidental bulk selection for deletion --}}
                                            <input type="checkbox" class="form-check-input checkbox-row" name="rows"
                                                value="{{ $deal->id }}" {{ $deal->is_immutable ? 'disabled' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary-lighten rounded-pill" style="font-size:0.975em !important; min-width:100%; margin-bottom:8px !important; padding: 0.65em 0.65em !important; text-align:left !important">
                                            <i class="uil-angle-right-b me-1"></i><a href="{{ route('superadmin.deals.show', $deal->id) }}">{{ $deal->deal_number }}</a></span>
                                        <span class="badge badge-secondary-lighten rounded-pill"
                                        style="font-size:0.975em !important; min-width:100%; margin-bottom:8px !important; padding: 0.65em 0.65em !important; text-align:left !important">
                                            <i class="bi bi-calendar-event me-1"></i>
                                            {{ $deal->created_at->format('d-m-Y h:i A') }}
                                    </span>
                                    </td>
                                     <td>
                                    <span class="badge badge-primary-lighten rounded-pill"
                                        style="font-size:0.975em !important; min-width:100%; margin-bottom:8px !important; padding: 0.65em 0.65em !important; text-align:left !important">{{ $deal->vehicle->manufacturerData->name }}</span>
                                    <span class="badge badge-secondary-lighten rounded-pill"
                                        style="font-size:0.975em !important; min-width:100%; margin-bottom:8px !important; padding: 0.65em 0.65em !important; text-align:left !important">{{ $deal->vehicle->modelData->name }}</span>
                                    <span class="badge badge-success-lighten rounded-pill"
                                        style="font-size:0.975em !important; min-width:100%; padding: 0.65em 0.65em !important; text-align:left !important">{{ $deal->vehicle->variantData->name }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="uk-plate rounded-pill">
                                        {{ $deal->vehicle->registration }}
                                    </div>
                                    <div class="vin-plate">
                                        {{ $deal->vehicle->vin }}
                                    </div>
                                </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark fw-bold">{{ $deal->user->firstname }}
                                                {{ $deal->user->lastname }}</span>
                                            <span class="small text-primary"><i class="bi bi-person-badge me-1"></i>
                                                {{ $deal->salesperson->name ?? 'Unassigned' }}</span>
                                        </div>
                                    </td>
                                    {{-- <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark">{{ $deal->vehicle->manufacturerData->name }}
                                                {{ $deal->vehicle->modelData->name }}</span>
                                            <span
                                                class="small text-apple-grey fw-normal">{{ $deal->vehicle->registration }}
                                                | {{ $deal->vehicle->vin }}</span>
                                        </div>
                                    </td> --}}
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark">£{{ number_format($deal->sale_price, 2) }}</span>
                                            @if ($deal->is_business_lease)
                                                <span class="badge bg-soft-info text-info rounded-pill small"
                                                    style="width:fit-content">Business Lease</span>
                                            @elseif($deal->is_hire_purchase)
                                                <span class="badge bg-soft-warning text-warning rounded-pill small"
                                                    style="width:fit-content">Hire Purchase</span>
                                            @else
                                                <span class="badge bg-soft-secondary text-secondary rounded-pill small"
                                                    style="width:fit-content">Standard Sale</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $statusClass = match ($deal->status) {
                                                'Completed' => 'bg-success',
                                                'Pending' => 'bg-warning',
                                                'Cancelled' => 'bg-danger',
                                                default => 'bg-secondary',
                                            };
                                        @endphp
                                        <span
                                            class="badge {{ $statusClass }} rounded-pill px-3" style="font-size:0.975em !important; min-width:100%; margin-bottom:0px !important; padding: 0.65em 0.65em !important; text-align:center !important">{{ $deal->status }}</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical fs-4"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3">
                                                <a href="{{ route('superadmin.deals.show', $deal->id) }}"
                                                    class="dropdown-item">
                                                    <i class="bi bi-eye me-2"></i> View Details
                                                </a>

                                                @if (!$deal->is_immutable)
                                                    <a href="{{ route('superadmin.deals.edit', $deal->id) }}"
                                                        class="dropdown-item">
                                                        <i class="bi bi-pencil me-2"></i> Edit Deal
                                                    </a>

                                                    <form action="{{ route('superadmin.deals.complete', $deal->id) }}"
                                                        method="POST" id="complete-form{{ $deal->id }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button"
                                                            onclick="confirmComplete({{ $deal->id }})"
                                                            class="dropdown-item text-success">
                                                            <i class="bi bi-check-circle me-2"></i> Finalize & Lock
                                                        </button>
                                                    </form>

                                                    <div class="dropdown-divider"></div>

                                                    <a href="javascript:void(0);"
                                                        onclick="confirmDelete({{ $deal->id }})"
                                                        class="dropdown-item text-danger">
                                                        <i class="bi bi-trash me-2"></i> Delete
                                                    </a>
                                                    <form id="delete-form{{ $deal->id }}"
                                                        action="{{ route('superadmin.deals.destroy', $deal->id) }}"
                                                        method="POST" class="d-none">
                                                        @csrf @method('DELETE')
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">No deals found matching
                                        your criteria.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $deals->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Toggle Bulk Delete Button
        $(document).on('change', '#all-rows, .checkbox-row', function() {
            if ($('#all-rows').is(':checked')) $('.checkbox-row:not(:disabled)').prop('checked', true);
            const checkedCount = $('.checkbox-row:checked').length;
            checkedCount > 0 ? $('#delete-all').fadeIn() : $('#delete-all').fadeOut();
        });

        // Delete Confirmation
        function confirmDelete(id) {
            Swal.fire({
                title: "Delete Deal?",
                text: "This action cannot be undone. Draft records will be removed.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                confirmButtonText: "Yes, delete"
            }).then((result) => {
                if (result.isConfirmed) document.getElementById("delete-form" + id).submit();
            });
        }

        // Completion/Locking Confirmation
        function confirmComplete(id) {
            Swal.fire({
                title: "Finalize Deal?",
                text: "Once completed, this deal becomes IMMUTABLE. You will not be able to edit these financial details again.",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#198754",
                confirmButtonText: "Complete & Lock"
            }).then((result) => {
                if (result.isConfirmed) document.getElementById("complete-form" + id).submit();
            });
        }

        // Bulk Delete Action
        $('#delete-all').click(function() {
            let ids = [];
            $('.checkbox-row:checked').each(function() {
                ids.push($(this).val());
            });

            Swal.fire({
                title: "Bulk Delete?",
                text: `Delete ${ids.length} selected deals? Completed deals will be skipped automatically.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete selected"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post("{{ route('superadmin.deals.bulk-delete') }}", {
                        ids: ids,
                        _token: "{{ csrf_token() }}"
                    }, () => location.reload());
                }
            });
        });
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
