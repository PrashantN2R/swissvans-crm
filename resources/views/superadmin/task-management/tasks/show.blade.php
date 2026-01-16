@extends('layouts.superadmin')
@section('title', 'Show Task | Superadmin')
@section('head')
    <link href="{{ asset('assets/js/plugins/intl-tel-input/css/intlTelInput.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark"><i
                                class="bi bi-arrow-left me-1"></i>Back</a>
                        <a href="{{ route('superadmin.tasks.edit', $lead->id) }}" class="btn btn-sm btn-primary"
                            form="leadForm"><i class="bi bi-pen me-1"></i>Edit</a>
                    </div>
                    <h4 class="page-title">Show Task</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Task Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.tasks.index') }}">Tasks</a></li>
                        <li class="breadcrumb-item active">Show Task</li>
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
            <div class="col-lg-6">
                <table class="table table-bordered table-sm mb-2">
                    <tr>
                        <th width="40%">Task Type</th>
                        <td class="text-dark">{{ $task->type }}</td>
                    </tr>
                    <tr>
                        <th width="40%">Due Date</th>
                        <td class="text-dark">{{ \Carbon\Carbon::parse($task->due_date)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th width="40%">Priority</th>
                        <td class="text-dark">{{ $task->priority }}</td>
                    </tr>
                    <tr>
                        <th width="40%">Status</th>
                        <td class="text-dark">{{ $task->status }}</td>
                    </tr>
                    <tr>
                        <th width="40%">Assigned To</th>
                        <td class="text-dark">
                            {{ $task->assigned_to ? $task->assignee->firstname . ' ' . $task->assignee->lastname : 'Not Assigned' }}
                        </td>
                    </tr>
                    <tr>
                        <th width="40%">Task Description</th>
                        <td class="text-dark">{{ $task->task }}</td>
                    </tr>
                </table>
            </div>
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
                </table>
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
                        <th width="40%">Assigned To</th>
                        <td class="text-dark">
                            {{ $lead->assigned_to ? $lead->assignee->firstname . ' ' . $lead->assignee->lastname : 'Not Assigned' }}
                        </td>
                    </tr>
                    <tr>
                        <th width="40%">Description</th>
                        <td class="text-dark">{{ $lead->description }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
