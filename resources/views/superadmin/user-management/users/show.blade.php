@extends('layouts.superadmin')
@section('title', 'Show User | Superadmin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark"><i
                                class="bi bi-arrow-left me-1"></i>Back</a>
                    </div>
                    <h4 class="page-title">Show User</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">User Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Show User</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('superadmin.includes.flash-message')
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ $user->avatar }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">

                        <h4 class="mb-0 mt-2">{{ $user->firstname }} {{ $user->lastname }}</h4>
                        <p class="text-muted font-14">
                            @foreach ($user->roles as $role)
                                @switch($role->name)
                                    @case('Administrator')
                                        <span class="text-muted">{{ $role->name }}</span>
                                    @break

                                    @case('superadmin Team')
                                        <span class="text-muted">{{ $role->name }}</span>
                                    @break

                                    @default
                                        <span class="text-muted">{{ $role->name }}</span>
                                @endswitch
                            @endforeach
                        </p>

                        <a href="{{ route('superadmin.users.edit', $user->slug) }}" class="btn btn-success btn-sm">
                            <i class="uil-pen">
                            </i>
                            Edit</a>
                        <a href="javascript:void(0);" onclick="confirmDelete({{ $user->id }})"
                            class="btn btn-danger btn-sm">
                            <i class="uil-trash-alt">
                            </i>
                            Delete</a>
                        <form id='delete-form{{ $user->id }}'
                            action='{{ route('superadmin.users.destroy', $user->id) }}' method='POST'>
                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                            <input type='hidden' name='_method' value='DELETE'>
                        </form>
                        <p class="text-muted font-14 mt-2">Date Joined :
                            {{ \Carbon\Carbon::parse($user->created_at)->format('l, M d h:i A') }}</p>
                        <div class="text-start mt-3">
                            <ul class="list-group list-unstyled">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Full Name</div>
                                    </div>
                                    <span>{{ $user->fullname }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Gender</div>
                                    </div>
                                    <span>{{ $user->gender }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Email</div>
                                    </div>
                                    <span>{{ $user->email }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Contact Number</div>
                                    </div>
                                    <span>{{ $user->dialcode }} {{ $user->phone }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Address</div>
                                    </div>
                                    <span>{{ $user->address }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">City</div>
                                    </div>
                                    <span>{{ $user->city }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">State</div>
                                    </div>
                                    <span>{{ $user->state }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Country</div>
                                    </div>
                                    <span>{{ $user->country }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Zipcode</div>
                                    </div>
                                    <span>{{ $user->zipcode }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(e) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete it!"
            }).then(t => {
                t.isConfirmed && document.getElementById("delete-form" + e).submit()
            })
        }
    </script>
@endpush
