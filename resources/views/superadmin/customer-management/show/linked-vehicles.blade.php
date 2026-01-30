<div class="tab-pane" id="linked-vehicles">
    <div class="row">
        <div class="col-12">
            @if (count($user->linkedVehicles) > 0)
                <table id="basic-datatable" class="table table-sm align-top table-striped fs-6 gy-5 dataTable">
                    <thead>
                        <tr>
                            <th class="th-primary" width="20%">Vehicle Details</th>
                            <th class="th-primary text-center" width="12%">Registration</th>
                            <th class="th-primary text-center" width="15%">VIN</th>
                            <th class="th-primary">Pricing</th>
                            <th class="th-primary">Stock Status</th>
                            <th class="th-primary text-center">Status</th>
                            <th class="th-primary"></th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach ($user->linkedVehicles as $vehicle)
                            <tr>
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

                                <td class="text-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical fs-4"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
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
            @else
                <div class="text-center py-5">
                    <h4 class="text-muted">No Linked Vehicles Found.</h4>
                </div>
            @endif
        </div>
    </div>
</div>
