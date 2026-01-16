@extends('layouts.superadmin')
@section('title', 'Dashboard | Superadmin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">

                    </div>
                    <h4 class="page-title h4">Welcome to @foreach (Auth::user('superadmin')->roles as $role)
                            {{ $role->name }}
                        @endforeach Dashboard</h4>
                </div>
            </div>
        </div>
    </div>
@endsection
