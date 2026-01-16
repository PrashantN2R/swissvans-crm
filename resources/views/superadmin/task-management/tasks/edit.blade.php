@extends('layouts.superadmin')
@section('title', 'Edit Task | Superadmin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark"><i
                                class="bi bi-arrow-left me-1"></i>Back</a>
                        <button type="submit" class="btn btn-sm btn-primary" form="taskForm"><i
                                class="bi bi-floppy me-1"></i>Update</button>
                    </div>
                    <h4 class="page-title">Edit Task</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item">Task Management</li>
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.tasks.index') }}">Tasks</a></li>
                        <li class="breadcrumb-item active">Edit Task</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @include('superadmin.includes.flash-message')
            </div>
            <div class="col-lg-8">
                <form id="taskForm" method="POST" action="{{ route('superadmin.tasks.update', $task->id) }}"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="lead_id" id="lead_id" value="{{ $lead->id }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 mb-2 {{ $errors->has('type') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="type">Task Type <span
                                            class="text-danger">*</span></label>
                                    <select name="type" id="type" class="form-select">
                                        <option value="">Select Type</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type }}"
                                                {{ old('type', $task->type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <span id="type-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-2 {{ $errors->has('due_date') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="due_date">Due Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="due_date" name="due_date"
                                        placeholder="Enter Due Date" value="{{ old('due_date', $task->due_date) }}">
                                    @error('due_date')
                                        <span id="due_date-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 mb-2 {{ $errors->has('task') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="task">Task Description<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="task" name="task" placeholder="Write Task Description" rows="5">{{ old('task', $task->task) }}</textarea>
                                    @error('task')
                                        <span id="task-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-2 {{ $errors->has('priority') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="priority">Priority <span
                                            class="text-danger">*</span></label>
                                    <select name="priority" id="priority" class="form-select">
                                        <option value="">Select Priority</option>
                                        @foreach ($priorities as $priority)
                                            <option value="{{ $priority }}"
                                                {{ old('priority', $task->priority) == $priority ? 'selected' : '' }}>{{ $priority }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('priority')
                                        <span id="priority-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 mb-2 {{ $errors->has('assigned_to') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="assigned_to">Assigned To <span
                                            class="text-danger">*</span></label>
                                    <select name="assigned_to" id="assigned_to" class="form-select">
                                        <option value="">Select Assignee</option>
                                        @foreach ($assignees as $assignee)
                                            <option value="{{ $assignee->id }}"
                                                {{ old('assigned_to', $task->assigned_to) == $assignee->id ? 'selected' : '' }}>
                                                {{ $assignee->firstname }} {{ $assignee->lastname }}</option>
                                        @endforeach
                                    </select>
                                    @error('assigned_to')
                                        <span id="assigned_to-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 mb-2 {{ $errors->has('status') ? 'has-error' : '' }}">
                                    <label class="col-form-label" for="status">Status <span
                                            class="text-danger">*</span></label>
                                    <select name="status" id="statuses" class="form-select">
                                        <option value="">Select Status</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}"
                                                {{ old('status', $task->status) == $status ? 'selected' : '' }}>{{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <span id="status-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4">
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
                        <td class="text-dark">{{ $lead->assigned_to ? $lead->assignee->firstname . ' ' . $lead->assignee->lastname : 'Not Assigned'  }}</td>
                    </tr>
                    <tr>
                        <th width="40%">Description</th>
                        <td class="text-dark">{{ $lead->description }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-12 text-end">
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark"><i
                        class="bi bi-arrow-left me-1"></i>Back</a>
                <button type="submit" class="btn btn-sm btn-primary" form="taskForm">
                    <i class="bi bi-floppy me-1"></i>Update
                </button>
            </div>
        </div>
    </div>
@endsection
