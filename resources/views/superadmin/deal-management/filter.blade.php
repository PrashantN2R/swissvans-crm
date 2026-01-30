<form action="{{ route('superadmin.deals.index') }}" method="GET">
    <div class="card">
        <div class="card-body">
            <div class="row g-3">

                {{-- Deal Number --}}
                <div class="col-md-3">
                    <label class="col-form-label">Deal Number</label>
                    <input type="text" name="deal_number" class="form-control form-control-sm"
                        value="{{ request('deal_number') }}" placeholder="Search Deal No...">
                </div>

                {{-- Registration No (Vehicle Relation) --}}
                <div class="col-md-3">
                    <label class="col-form-label">Registration No</label>
                    <input type="text" name="registration" class="form-control form-control-sm"
                        value="{{ request('registration') }}" placeholder="Search Registration...">
                </div>

                {{-- VIN Number (Vehicle Relation) --}}
                <div class="col-md-3">
                    <label class="col-form-label">VIN Number</label>
                    <input type="text" name="vin" class="form-control form-control-sm"
                        value="{{ request('vin') }}" placeholder="Search VIN...">
                </div>

                {{-- Customer Selection --}}
                <div class="col-md-3">
                    <label class="col-form-label">Customer</label>
                    <select name="user_id" class="form-select form-select-sm">
                        <option value="">All Customers</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" @selected(request('user_id') == $customer->id)>
                                {{ $customer->firstname }} {{ $customer->lastname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Manufacturer (Make) --}}
                <div class="col-md-3">
                    <label class="col-form-label">Manufacturer</label>
                    <select name="make" id="filter_manufacturer" class="form-select form-select-sm">
                        <option value="">All</option>
                        @foreach ($manufacturers as $man)
                            <option value="{{ $man->cap_id }}" @selected(request('make') == $man->cap_id)>
                                {{ $man->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Model --}}
                <div class="col-md-3">
                    <label class="col-form-label">Model</label>
                    <select name="model" id="filter_model" class="form-select form-select-sm">
                        <option value="">All</option>
                        @foreach ($fillmodels as $fmod)
                            <option value="{{ $fmod->capmod_id }}" @selected(request('model') == $fmod->capmod_id)>
                                {{ $fmod->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Derivative --}}
                <div class="col-md-3">
                    <label class="col-form-label">Derivative</label>
                    <input type="text" name="derivative" class="form-control form-control-sm"
                        value="{{ request('derivative') }}" placeholder="e.g. M Sport">
                </div>

                {{-- Deal Status --}}
                <div class="col-md-3">
                    <label class="col-form-label">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All</option>
                        <option value="Draft" @selected(request('status') == 'Draft')>Draft</option>
                        <option value="Pending" @selected(request('status') == 'Pending')>Pending</option>
                        <option value="Completed" @selected(request('status') == 'Completed')>Completed</option>
                        <option value="Cancelled" @selected(request('status') == 'Cancelled')>Cancelled</option>
                    </select>
                </div>

                {{-- Transaction Type --}}
                <div class="col-md-3">
                    <label class="col-form-label">Transaction Type</label>
                    <select name="type" class="form-select form-select-sm">
                        <option value="">All</option>
                        <option value="Sale" @selected(request('type') == 'Sale')>Standard Sale</option>
                        <option value="Lease" @selected(request('type') == 'Lease')>Lease Agreement</option>
                    </select>
                </div>

                {{-- Finance Path --}}
                <div class="col-md-3">
                    <label class="col-form-label">Finance Path</label>
                    <select name="finance_path" class="form-select form-select-sm">
                        <option value="">All</option>
                        <option value="business" @selected(request('finance_path') == 'business')>Business Lease</option>
                        <option value="hp" @selected(request('finance_path') == 'hp')>Hire Purchase</option>
                    </select>
                </div>

                {{-- Date From --}}
                <div class="col-md-3">
                    <label class="col-form-label">From Date</label>
                    <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
                </div>

                {{-- Date To --}}
                <div class="col-md-3">
                    <label class="col-form-label">To Date</label>
                    <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
                </div>

                {{-- Salesperson Filter --}}
                <div class="col-md-3">
                    <label class="col-form-label">Assigned Salesperson</label>
                    <select name="salesperson_id" class="form-select form-select-sm">
                        <option value="">All Staff</option>
                        @foreach($salespeople as $staff)
                            <option value="{{ $staff->id }}" @selected(request('salesperson_id') == $staff->id)>
                                {{ $staff->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Action Buttons --}}
                <div class="col-md-9 text-end">
                    <label class="col-form-label d-block text-white">&nbsp;</label>
                    <button type="submit" class="btn btn-sm btn-secondary">
                        <i class="mdi mdi-magnify search-icon"></i> Search
                    </button>
                    <a href="{{ route('superadmin.deals.index') }}" class="btn btn-sm btn-dark">Reset</a>
                </div>

            </div>
        </div>
    </div>
</form>
