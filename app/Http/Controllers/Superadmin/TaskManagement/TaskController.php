<?php

namespace App\Http\Controllers\Superadmin\TaskManagement;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Superadmin;
use App\Models\Task;
use App\Models\TaskAttachment;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:superadmin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter                 = [];
        $filter['lead_id']      = $request->lead_id;
        $filter['name']         = $request->name;
        $filter['email']        = $request->email;
        $filter['phone']        = $request->phone;
        $filter['type']         = $request->type;
        $filter['priority']     = $request->priority;
        $filter['due_date']     = $request->due_date;
        $filter['status']       = $request->status;
        $filter['created_at']   = $request->created_at;
        $filter['created_by']   = $request->created_by;
        $filter['assigned_to']  = $request->assigned_to;

        $tasks                  = Task::query();
        $tasks                  = isset($filter['lead_id']) ? $tasks->where('lead_id', $filter['lead_id']) : $tasks;
        if (isset($filter['name'])) {
            $name               = $filter['name'];
            $tasks              = $tasks->whereHas('lead', function ($query) use ($name) {
                $query->where('name', 'LIKE', '%' . $name . '%');
            });
        }
        if (isset($filter['email'])) {
            $email              = $filter['email'];
            $tasks              = $tasks->whereHas('lead', function ($query) use ($email) {
                $query->where('email', 'LIKE', '%' . $email . '%');
            });
        }
        if (isset($filter['phone'])) {
            $phone              = $filter['phone'];
            $tasks              = $tasks->whereHas('lead', function ($query) use ($phone) {
                $query->where('phone', 'LIKE', '%' . $phone . '%');
            });
        }

        $tasks                  = isset($filter['type']) ? $tasks->where('type', $filter['type']) : $tasks;
        $tasks                  = isset($filter['priority']) ? $tasks->where('priority', $filter['priority']) : $tasks;
        $tasks                  = isset($filter['due_date']) ? $tasks->whereDate('due_date', $filter['due_date']) : $tasks;
        $tasks                  = isset($filter['status']) ? $tasks->where('status', $filter['status']) : $tasks;
        $tasks                  = isset($filter['created_at']) ? $tasks->whereDate('created_at', $filter['created_at']) : $tasks;
        $tasks                  = isset($filter['created_by']) ? $tasks->where('created_by_id', $filter['created_by']) : $tasks;
        $tasks                  = isset($filter['assigned_to']) ? $tasks->where('assigned_to', $filter['assigned_to']) : $tasks;

        $user                   = $request->user();

        if ($user->hasRole('Administrator')) {
            $tasks              = $tasks->orderBy('id', 'desc')->paginate(40);
        }

        if ($user->hasRole('Manager')) {
            $tasks              = $tasks->paginate(40);
        }

        if ($user->hasRole('Sales Executive')) {
            $tasks              = $tasks->where('assigned_to', $user->id)->paginate(40);
        }

        $creators = Superadmin::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Manager', 'Administrator']);
        })->get();

        $assignees = Superadmin::whereHas('roles', function ($query) {
            $query->where('name', 'Sales Executive');
        })->get();

        $types                  = ['Call', 'Email', 'Meeting', 'Follow Up', 'General', 'Visit'];
        $statuses               = ['Pending', 'In Progress', 'Completed', 'Cancelled'];
        $priorities             = ['Low', 'Medium', 'High'];
        return view('superadmin.task-management.tasks.list', compact('tasks', 'filter', 'creators', 'assignees', 'types', 'statuses', 'priorities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $lead       = Lead::find($request->lead_id);
        $assignees = Superadmin::whereHas('roles', function ($query) {
            $query->where('name', 'Sales Executive');
        })->get();

        $types                  = ['Call', 'Email', 'Meeting', 'Follow Up', 'General', 'Visit'];
        $statuses               = ['Pending', 'In Progress', 'Completed', 'Cancelled'];
        $priorities             = ['Low', 'Medium', 'High'];
        return view('superadmin.task-management.tasks.create', compact('lead', 'assignees', 'types', 'statuses', 'priorities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task       = Task::find($id);
        $lead       = Lead::find($task->lead_id);
        $assignees = Superadmin::whereHas('roles', function ($query) {
            $query->where('name', 'Sales Executive');
        })->get();

        $types                  = ['Call', 'Email', 'Meeting', 'Follow Up', 'General', 'Visit'];
        $statuses               = ['Pending', 'In Progress', 'Completed', 'Cancelled'];
        $priorities             = ['Low', 'Medium', 'High'];
        return view('superadmin.task-management.tasks.show', compact('task', 'lead', 'assignees', 'types', 'statuses', 'priorities'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task       = Task::find($id);
        $lead       = Lead::find($task->lead_id);
        $assignees = Superadmin::whereHas('roles', function ($query) {
            $query->where('name', 'Sales Executive');
        })->get();

        $types                  = ['Call', 'Email', 'Meeting', 'Follow Up', 'General', 'Visit'];
        $statuses               = ['Pending', 'In Progress', 'Completed', 'Cancelled'];
        $priorities             = ['Low', 'Medium', 'High'];
        return view('superadmin.task-management.tasks.edit', compact('task', 'lead', 'assignees', 'types', 'statuses', 'priorities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Task::find($id)->delete();
        return redirect()->route('superadmin.tasks.index')->with('success', 'Task deleted sucessfully!');
    }

    public function bulkDelete(Request $request)
    {
        Task::whereIn('id', $request->tasks)->delete();
        return response()->json(['success' => 'Tasks deleted successfully!'], 200);
    }

    public function deleteAttachment($id)
    {
        TaskAttachment::find($id)->delete();
        return redirect()->back()->with('success', 'Attachment deleted successfully!');
    }
}
