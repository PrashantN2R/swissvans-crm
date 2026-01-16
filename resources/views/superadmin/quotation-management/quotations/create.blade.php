@extends('layouts.superadmin')
@section('title', 'Create Quotation | Superadmin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark"><i
                                class="bi bi-arrow-left me-1"></i>Back</a>
                        <button type="submit" class="btn btn-sm btn-primary" form="quotationForm"><i
                                class="bi bi-floppy me-1"></i>Save</button>
                    </div>
                    <h4 class="page-title">Create Quotation</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Quotation Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.quotations.index') }}">Quotations</a></li>
                        <li class="breadcrumb-item active">Create Quotation</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('superadmin.includes.flash-message')
            </div>
            <div class="col-12">
                <div class="accordion custom-accordion" id="custom-accordion-one">
                    <div class="card mb-0">
                        <div class="card-header" id="headingFive">
                            <h5 class="m-0">
                                <a class="custom-accordion-title collapsed d-block py-1" data-bs-toggle="collapse"
                                    href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Lead Details<i class="mdi mdi-chevron-down accordion-arrow"></i>
                                </a>
                            </h5>
                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive"
                            data-bs-parent="#custom-accordion-one">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <table class="table table-bordered table-sm mb-2">
                                            <tr>
                                                <th width="40%">Customer Name</th>
                                                <td class="text-dark">{{ $lead->name }}</td>
                                            </tr>
                                            <tr>
                                                <th width="40%">Designation</th>
                                                <td class="text-dark">{{ $lead->designation }}</td>
                                            </tr>
                                            <tr>
                                                <th width="40%">Company</th>
                                                <td class="text-dark">{{ $lead->company }}</td>
                                            </tr>
                                            <tr>
                                                <th width="40%">Email Address</th>
                                                <td class="text-dark">{{ $lead->email }}</td>
                                            </tr>
                                            <tr>
                                                <th width="40%">Phone Number</th>
                                                <td class="text-dark">{{ $lead->phone }}</td>
                                            </tr>
                                            <tr>
                                                <th width="40%">Assigned To</th>
                                                <td class="text-dark">
                                                    {{ $lead->assigned_to ? $lead->assignee->firstname . ' ' . $lead->assignee->lastname : 'Not Assigned' }}
                                                </td>
                                            </tr>
                                        </table>

                                    </div>
                                    <div class="col-lg-6">
                                        <table class="table table-bordered table-sm mb-2">
                                            <tr>
                                                <th width="40%">Event Type</th>
                                                <td class="text-dark">{{ $lead->event_type }}</td>
                                            </tr>
                                            <tr>
                                                <th width="40%">Event Date</th>
                                                <td class="text-dark">{{ $lead->event_date }}</td>
                                            </tr>
                                            <tr>
                                                <th width="40%">Event Location</th>
                                                <td class="text-dark">{{ $lead->location }}</td>
                                            </tr>
                                            <tr>
                                                <th width="40%">Budget</th>
                                                <td class="text-dark">{{ $lead->budget }}</td>
                                            </tr>
                                            <tr>
                                                <th width="40%">Source</th>
                                                <td class="text-dark">{{ ucfirst($lead->source) }}</td>
                                            </tr>
                                            <tr>
                                                <th width="40%">Description</th>
                                                <td class="text-dark">{{ $lead->description }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <form class="row" action="{{ route('superadmin.quotations.store') }}" method="POST" id="quotationForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-body pb-0 mb-0">
                            <div class="row">
                                <input type="hidden" name="lead_id" id="lead_id" value="{{ $lead->id }}">
                                <div class="col-lg-6 mb-2 {{ $errors->has('quote_date') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="quote_date">Quotation Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="quote_date" name="quote_date"
                                        placeholder="Enter Due Date" value="{{ old('quote_date') }}">
                                    @error('quote_date')
                                        <span id="quote_date-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-2 {{ $errors->has('expiry_date') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="expiry_date">Expiry Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="expiry_date" name="expiry_date"
                                        placeholder="Enter Due Date" value="{{ old('expiry_date') }}">
                                    @error('expiry_date')
                                        <span id="expiry_date-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 mb-2 {{ $errors->has('note') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="note">Note</label>
                                    <textarea class="form-control" id="note" name="note" placeholder="Write Note here" rows="3">{{ old('note') }}</textarea>
                                    @error('note')
                                        <span id="note-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-2 {{ $errors->has('assigned_to') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="assigned_to">Assigned To <span
                                            class="text-danger">*</span></label>
                                    <select name="assigned_to" id="assigned_to" class="form-select">
                                        <option value="">Select Assignee</option>
                                        @foreach ($assignees as $assignee)
                                            <option value="{{ $assignee->id }}"
                                                {{ old('assigned_to') == $assignee->id ? 'selected' : '' }}>
                                                {{ $assignee->firstname }} {{ $assignee->lastname }}</option>
                                        @endforeach
                                    </select>
                                    @error('assigned_to')
                                        <span id="assigned_to-error"
                                            class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-2 {{ $errors->has('status') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="status">Status <span
                                            class="text-danger">*</span></label>
                                    <select name="status" id="statuses" class="form-select">
                                        <option value="">Select Status</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}"
                                                {{ old('status') == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <span id="status-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class='col-lg-12'>
                                    <label class="col-form-label" for="items">Quotation Items <span
                                            class="text-danger">*</span></label>
                                    <table id="item" class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th width="44%">Item</th>
                                                <th width="13%">Unit</th>
                                                <th width="13%">Rate</th>
                                                <th width="13%">Quantity</th>
                                                <th width="13%">Amount</th>
                                                <th class="text-end"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="item-row0">
                                                <td><input type="text" name="item[0][item]" placeholder="Item"
                                                        class="form-control" id="item_0" required></td>
                                                <td><input type="text" name="item[0][unit]" placeholder="Unit"
                                                        class="form-control" id="unit_0" required></td>
                                                <td><input type="number" name="item[0][rate]" placeholder="Rate"
                                                        class="form-control" id="rate_0" required step="any"></td>
                                                <td><input type="number" name="item[0][quantity]" placeholder="Quantity"
                                                        class="form-control" id="quantity_0" required step="any">
                                                </td>
                                                <td><input type="number" name="item[0][amount]" placeholder="Amount"
                                                        class="form-control" id="amount_0" required step="any"></td>
                                                <td class="text-end"><button type="button"
                                                        onclick="$('#item-row0').remove();" class="btn btn-danger"><i
                                                            class="bi bi-dash"></i></button></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="text-end" style="border-bottom: none;" colspan="6"><button
                                                        type="button" onclick="addItem();" data-toggle="tooltip"
                                                        title="Add Item" class="btn btn-primary"
                                                        data-original-title="Add Item"><i class="bi bi-plus"></i></button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer bg-dark text-white">
                            <div class="d-flex justify-content-between">
                                <span>Total</span>
                                <span id="total">5000</span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-12 text-end">
                                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark"><i
                                            class="bi bi-arrow-left me-1"></i>Back</a>
                                    <button type="submit" class="btn btn-sm btn-primary" form="quotationForm">
                                        <i class="bi bi-floppy me-1"></i>Save
                                    </button>
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
    <script>
        var item_row = {{ isset($quotation) ? count($quotation->items) : 1 }}

        function addItem() {
            if (item_row < 50) {
                html = '<tr id="item-row' + item_row + '">';
                html += '<td><input type="text" name="item[' + item_row +
                    '][item]" placeholder="Item" class="form-control" id="item_' + item_row + '" required></td>';
                html += '<td><input type="text" name="item[' + item_row +
                    '][unit]" placeholder="Unit" class="form-control" id="unit_' + item_row + '" required></td>';
                html += '<td><input type="number" name="item[' + item_row +
                    '][rate]" placeholder="Rate" class="form-control" id="rate_' + item_row + '" required step="any"></td>';
                html += '<td><input type="number" name="item[' + item_row +
                    '][quantity]" placeholder="Quantity" class="form-control" id="quantity_' + item_row +
                    '" required step="any"></td>';
                html += '<td><input type="number" name="item[' + item_row +
                    '][amount]" placeholder="Amount" class="form-control" id="amount_' + item_row +
                    '" required step="any"></td>';
                html += '<td class="text-end"><button type="button" onclick="$(\'#item-row' + item_row +
                    '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="bi bi-dash"></i></button></td>';
                html += '<tr>';
                $('#item tbody').append(html);
                item_row++;
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const viewportMeta = document.querySelector('meta[name="viewport"]');
            if (viewportMeta) {
                // Set a fixed width or a width that simulates a desktop view
                // For example, 980px is a common breakpoint for desktop views
                viewportMeta.setAttribute('content', 'width=980');
                // Or, to use the device's actual width but prevent scaling, you could use:
                // viewportMeta.setAttribute('content', 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes');
            }
        });
    </script>
@endpush
