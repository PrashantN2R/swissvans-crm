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

                    <a href="{{ route('superadmin.vehicles.index') }}" class="btn btn-sm btn-dark">Reset</a>
                </div>

            </div>

        </div>
    </div>
</form>
