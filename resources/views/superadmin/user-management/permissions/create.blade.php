@extends('layouts.superadmin')
@section('title', 'Create Permission | Superadmin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark"><i
                                class="bi bi-arrow-left me-1"></i>Back</a>
                        <button type="submit" class="btn btn-sm btn-primary" form="superadminForm"><i
                                class="bi bi-floppy me-1"></i>Save</button>
                    </div>
                    <h4 class="page-title">Create Permission</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">User Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.permissions.index') }}">Permissions</a>
                        </li>
                        <li class="breadcrumb-item active">Create Permission</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('superadmin.includes.flash-message')
                <form id="superadminForm" method="POST" action="{{ route('superadmin.permissions.store') }}"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mb-2">
                                    <h5 class="text-dark">Permission Name</h5>
                                </div>
                                <div class="col-sm-12 mb-2 {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter Permission Name" value="{{ old('name') }}">
                                    @error('name')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-5">
                                <div class="col-sm-12 mb-2 d-flex justify-content-between">
                                    <h5 class="text-dark">Permission Roles</h5>
                                    <div>
                                        <span class="btn btn-xs btn-success select-all"><b>Select All</b></span>
                                        <span class="btn btn-xs btn-danger deselect-all"><b>Deselect All</b></span>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2">

                                    <select class="form-control" id="role" name="role[]" multiple="multiple">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}"
                                                {{ in_array($role->name, old('role', [])) || (isset($permission) && $permission->roles->contains($role->name)) ? 'selected' : '' }}>
                                                {{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror

                                </div>
                                {{-- Update button starts here --}}
                                <div class="col-sm-12 text-end">
                                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark"><i
                                            class="bi bi-arrow-left me-1"></i>Back</a>
                                    <button type="submit" class="btn btn-sm btn-primary" form="superadminForm">
                                        <i class="bi bi-floppy me-1"></i>Save
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
            $('#role').select2();
            $('.select-all').on('click', function() {
                $('#role').val(null).trigger('change');
                $('#role > option').prop("selected", "selected");
                $('#role').trigger('change');
            });
            $('.deselect-all').on('click', function() {
                $('#role').val(null).trigger('change');
            });
        });
    </script>
@endpush
