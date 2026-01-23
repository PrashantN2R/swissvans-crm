@extends('layouts.superadmin')
@section('title', 'Manufacturers | Superadmin')

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
                    <h4 class="page-title">Manufacturers</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Vehicle Settings</li>
                        <li class="breadcrumb-item active">Manufacturers</li>
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
                        <form action="{{ route('superadmin.manufacturers.index') }}" method="GET">
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="col-form-label">Name</label>
                                    <input type="text" class="form-control form-control-sm" name="name"
                                        value="{{ $filter['name'] ?? '' }}" placeholder="Search by name">
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="col-form-label">Status</label>
                                    <select name="status" class="form-control form-control-sm">
                                        <option value="">All</option>
                                        <option value="active" {{ ($filter['status'] ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ ($filter['status'] ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="col-form-label text-white">Action</label>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-sm btn-secondary w-50">
                                            <i class="mdi mdi-magnify search-icon"></i> Search
                                        </button>
                                        <a href="{{ route('superadmin.manufacturers.index') }}" class="btn btn-sm btn-dark w-50">Reset</a>
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
                        <tr>
                            <th class="text-primary">Manufacturer</th>
                            <th>Delivery Charge (£)</th>
                            <th>Status</th>
                            <th class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($manufacturers as $item)
                            <tr>
                                <td class="fw-semibold">
                                    <a href="javascript:void(0)" class="text-primary fw-semibold"
                                        onclick="document.getElementById('model{{ $item->id }}').submit();">
                                        {{ $item->name }}
                                    </a>
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm delivery-charge-input"
                                        data-id="{{ $item->id }}" value="{{ $item->delivery_charge }}" min="0"
                                        step="0.01" style="width:110px;">
                                </td>
                                <td>
                                     <input class="status-toggle" type="checkbox" data-id="{{ $item->id }}" id="switch{{ $item->id }}"
                                            @checked($item->status) data-switch="none"/>
                                    <label for="switch{{ $item->id }}" data-on-label="ON" data-off-label="OFF"></label>
                                </td>
                                <td class="text-end">
                                    <form method="GET" action="{{ route('superadmin.models.index') }}" class="d-none" id="model{{ $item->id }}">
                                        <input type="hidden" name="manufacturer" value="{{ $item->name }}">
                                    </form>
                                    <button type="submit" form="model{{ $item->id }}" class="btn btn-primary btn-sm">Models</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $manufacturers->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Safe URL generation
        const updateChargeUrl = "{{ route('superadmin.manufacturers.index') }}".split('?')[0].replace(/\/+$/, '') + '/update-delivery-charge/';
        const updateStatusUrl = "{{ route('superadmin.manufacturers.index') }}".split('?')[0].replace(/\/+$/, '') + '/change-status/';

        // Configure a beautiful Success Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // ---- Update Delivery Charge ----
        $(".delivery-charge-input").on("change", function() {
            let id = $(this).data("id");
            let value = $(this).val();

            $.ajax({
                url: updateChargeUrl + id,
                type: "POST",
                data: {
                    delivery_charge: value,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Delivery charge updated',
                        background: '#f0fff4', // Soft green background
                        iconColor: '#38a169'
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: xhr.responseJSON?.message ?? "Something went wrong.",
                        confirmButtonColor: '#3085d6',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        }
                    });
                }
            });
        });

        // ---- Update Status Toggle ----
        $(".status-toggle").on("change", function() {
            let id = $(this).data("id");
            let status = $(this).prop('checked') ? 1 : 0;

            $.ajax({
                url: updateStatusUrl + id,
                type: "GET",
                data: {
                    status: status,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Status changed successfully',
                        background: '#f0fff4',
                        iconColor: '#38a169'
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: 'Could not sync the status change.',
                        confirmButtonColor: '#d33'
                    });
                }
            });
        });
    });
</script>
@endpush
