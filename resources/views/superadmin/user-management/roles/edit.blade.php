@extends('layouts.superadmin')
@section('title', 'Edit Role | Superadmin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark"><i
                                class="bi bi-arrow-left me-1"></i>Back</a>
                        <button type="submit" class="btn btn-sm btn-primary" form="superadminForm"><i
                                class="bi bi-floppy me-1"></i>Update</button>
                    </div>
                    <h4 class="page-title">Edit Role</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">User Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.roles.index') }}">Roles</a></li>
                        <li class="breadcrumb-item active">Edit Role</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('superadmin.includes.flash-message')
                <form id="superadminForm" method="POST" action="{{ route('superadmin.roles.update', $role->id) }}"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h5 class="text-dark">Role Name</h5>
                                </div>
                                <div class="col-sm-12 {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter Role Name" value="{{ old('name', $role->name) }}">
                                    @error('name')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 d-flex justify-content-between">
                                    <h5 class="text-dark">Role Permissions</h5>
                                    <div>
                                        <span class="btn btn-xs btn-success select-all"><b>Select All</b></span>
                                        <span class="btn btn-xs btn-danger deselect-all"><b>Deselect All</b></span>
                                    </div>
                                </div>
                                <div class="col-sm-12">

                                    <select class="form-control" id="permission" name="permission[]" multiple="multiple">
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->name }}"
                                                {{ in_array($permission->name, old('permission') ? (array) old('permission') : $role->permissions->pluck('name')->toArray()) ? 'selected' : '' }}>
                                                {{ $permission->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('permission')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror

                                </div>
                                {{-- Update button starts here --}}
                                <div class="col-sm-12 text-end mt-2">
                                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark"><i
                                            class="bi bi-arrow-left me-1"></i>Back</a>
                                    <button type="submit" class="btn btn-sm btn-primary" form="superadminForm">
                                        <i class="bi bi-floppy me-1"></i>Update
                                    </button>
                                </div>
                                {{-- Update button ends here --}}
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#permission').select2();
            $('.select-all').on('click', function() {
                $('#permission').val(null).trigger('change');
                $('#permission > option').prop("selected", "selected");
                $('#permission').trigger('change');
            });
            $('.deselect-all').on('click', function() {
                $('#permission').val(null).trigger('change');
            });
        });
    </script>
@endpush
