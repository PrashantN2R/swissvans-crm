<?php

namespace App\Http\Controllers\Superadmin\LeadManagement;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\LeadAttachment;
use App\Models\LeadNote;
use App\Models\Superadmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
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
        $filter['name']         = $request->name;
        $filter['phone']        = $request->phone;
        $filter['budget']       = $request->budget;
        $filter['source']       = $request->source;
        $filter['event_type']   = $request->event_type;
        $filter['date_from']    = $request->date_from;
        $filter['date_upto']    = $request->date_upto;
        $filter['status']       = $request->status;
        $filter['assigned_to']  = $request->assigned_to;
        $filter['created_by']   = $request->created_by;
        $filter['created_at']   = $request->created_at;

        $leads                  = Lead::query();
        $leads                  = isset($filter['name']) ? $leads->where('name', 'LIKE', '%' . $filter['name'] . '%') : $leads;
        $leads                  = isset($filter['phone']) ? $leads->where('phone', 'LIKE', '%' . $filter['phone'] . '%') : $leads;
        $leads                  = isset($filter['budget']) ? $leads->where('budget', $filter['budget']) : $leads;
        $leads                  = isset($filter['source']) ? $leads->where('source', $filter['source']) : $leads;
        $leads                  = isset($filter['event_type']) ? $leads->where('event_type', 'LIKE', '%' . $filter['event_type'] . '%') : $leads;
        $leads                  = isset($filter['date_from']) ? $leads->where('event_date', '>=', $filter['date_from']) : $leads;
        $leads                  = isset($filter['date_upto']) ? $leads->where('event_date', '<=', $filter['date_upto']) : $leads;
        $leads                  = isset($filter['status']) ? $leads->where('status',  $filter['status']) : $leads;
        $leads                  = isset($filter['created_by']) ? $leads->where('created_by_id',  $filter['created_by']) : $leads;
        $leads                  = isset($filter['created_at']) ? $leads->whereDate('created_at', $filter['created_at']) : $leads;
        $leads                  = isset($filter['assigned_to']) ? $leads->where('assigned_to',  $filter['assigned_to']) : $leads;

        $user                   = $request->user();

        if ($user->hasRole('Administrator')) {
            $leads              = $leads->orderBy('id', 'desc')->paginate(40);
        }

        if ($user->hasRole('Manager')) {
            $leads              = $leads->orderBy('id', 'desc')->paginate(40);
        }

        if ($user->hasRole('Sales Executive')) {
            $leads              = $leads->where('assigned_to', $user->id)->orderBy('id', 'desc')->paginate(40);
        }

        $creators = Superadmin::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Manager', 'Administrator']);
        })->get();

        $assignees = Superadmin::whereHas('roles', function ($query) {
            $query->where('name', 'Sales Executive');
        })->get();

        $statuses  = ['New', 'Contacted', 'Quoted', 'Negotiation', 'Won', 'Lost'];

        return view('superadmin.lead-management.leads.list', compact('filter', 'leads', 'creators', 'assignees', 'statuses'));
    }

    public function kanban(Request $request)
    {
        $user                   = $request->user();

        $new_leads              = $user->hasRole('Sales Executive') ? Lead::where('status', 'New')->where('assigned_to', $user->id)->orderBy('id', 'desc')->get() : Lead::where('status', 'New')->orderBy('id', 'desc')->get();

        $contacted_leads        = $user->hasRole('Sales Executive') ? Lead::where('status', 'Contacted')->where('assigned_to', $user->id)->orderBy('id', 'desc')->get() : Lead::where('status', 'Contacted')->orderBy('id', 'desc')->get();

        $quoted_leads           = $user->hasRole('Sales Executive') ? Lead::where('status', 'Quoted')->where('assigned_to', $user->id)->orderBy('id', 'desc')->get() : Lead::where('status', 'Quoted')->orderBy('id', 'desc')->get();

        $negotiation_leads      = $user->hasRole('Sales Executive') ? Lead::where('status', 'Negotiation')->where('assigned_to', $user->id)->orderBy('id', 'desc')->get() : Lead::where('status', 'Negotiation')->orderBy('id', 'desc')->get();

        $won_leads              = $user->hasRole('Sales Executive') ? Lead::where('status', 'Won')->where('assigned_to', $user->id)->orderBy('id', 'desc')->get() : Lead::where('status', 'Won')->orderBy('id', 'desc')->get();

        $lost_leads             = $user->hasRole('Sales Executive') ? Lead::where('status', 'Lost')->where('assigned_to', $user->id)->orderBy('id', 'desc')->get() : Lead::where('status', 'Lost')->orderBy('id', 'desc')->get();

        return view('superadmin.lead-management.leads.kanban', compact('new_leads', 'contacted_leads', 'quoted_leads', 'negotiation_leads', 'won_leads', 'lost_leads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assignees = Superadmin::whereHas('roles', function ($query) {
            $query->where('name', 'Sales Executive');
        })->get();

        return view('superadmin.lead-management.leads.create', compact('assignees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user                       = $request->user();

        $rules                      = [
            'name'                  => ['required'],
            'designation'           => ['required'],
            'company'               => ['required'],
            'email'                 => ['required'],
            'phone'                 => ['required'],
            'event_type'            => ['required'],
            'event_date'            => ['required'],
            'location'              => ['required'],
            'budget'                => ['required'],
            'source'                => ['required'],
            'assigned_to'           => $user->hasRole('Sales Executive') ? [] : ['required'],
            'description'           => ['required'],
        ];

        $messages                   = [
            'name'                  => 'Please enter customer name.',
            'designation'           => 'Please enter customer designation.',
            'company'               => 'Please enter customer company.',
            'email'                 => 'Please enter customer email address.',
            'phone'                 => 'Please enter customer phone number.',
            'event_type'            => 'Please enter type of event.',
            'event_date'            => 'Please enter date of event.',
            'location'              => 'Please enter location of event.',
            'budget'                => 'Please enter budget of event.',
            'source'                => 'Please select source of event.',
            'assigned_to'           => 'Please select the assignee.',
            'description'           => 'Please enter event description.',
        ];

        $this->validate($request, $rules, $messages);

        $lead                       = Lead::create([
            'name'                  => $request->name,
            'designation'           => $request->designation,
            'company'               => $request->company,
            'email'                 => $request->email,
            'phone'                 => $request->phone,
            'budget'                => $request->budget,
            'event_type'            => $request->event_type,
            'event_date'            => $request->event_date,
            'source'                => $request->source,
            'description'           => $request->description,
            'location'              => $request->location,
            'meta'                  => null,
            'status'                => "New",
            'created_by'            => $user->id,
            'assigned_to'           => $user->hasRole('Sales Executive') ? $user->id : $request->assigned_to,
        ]);

        if (is_array($request->file('attachments')) && !empty($request->file('attachments'))) {

            foreach ($request->file('attachments') as $key => $file) {

                $extension = $file->getClientOriginalExtension();
                $filename  = $file->getClientOriginalName();
                $size      = $file->getSize();

                $file->storeAs('uploads/leads/' . $lead->id, $filename, 'public');

                LeadAttachment::create([
                    'lead_id'       => $lead->id,
                    'attachment'    => $filename,
                    'extension'     => $extension,
                    'size'          => $size,
                    'path'          => asset('storage/uploads/leads/' . $lead->id . '/' . $filename),
                    'created_by'    => $user->roles->first()->name,
                    'created_by_id' => $user->id
                ]);
            }
        }

        return redirect()->route('superadmin.leads.index')->with('success', 'Lead generated sucessfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $assignees = Superadmin::whereHas('roles', function ($query) {
            $query->where('name', 'Sales Executive');
        })->get();

        $lead      = Lead::find($id);

        $statuses  = ['New', 'Contacted', 'Quoted', 'Negotiation', 'Won', 'Lost'];

        return view('superadmin.lead-management.leads.show', compact('assignees', 'lead', 'statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $assignees = Superadmin::whereHas('roles', function ($query) {
            $query->where('name', 'Sales Executive');
        })->get();

        $lead      = Lead::find($id);

        return view('superadmin.lead-management.leads.edit', compact('assignees', 'lead'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user                       = $request->user();

        $rules                      = [
            'name'                  => ['required'],
            'designation'           => ['required'],
            'company'               => ['required'],
            'email'                 => ['required'],
            'phone'                 => ['required'],
            'event_type'            => ['required'],
            'event_date'            => ['required'],
            'location'              => ['required'],
            'budget'                => ['required'],
            'source'                => ['required'],
            'assigned_to'           => $user->hasRole('Sales Executive') ? [] : ['required'],
            'description'           => ['required'],
        ];

        $messages                   = [
            'name'                  => 'Please enter customer name.',
            'designation'           => 'Please enter customer designation.',
            'company'               => 'Please enter customer company.',
            'email'                 => 'Please enter customer email address.',
            'phone'                 => 'Please enter customer phone number.',
            'event_type'            => 'Please enter type of event.',
            'event_date'            => 'Please enter date of event.',
            'location'              => 'Please enter location of event.',
            'budget'                => 'Please enter budget of event.',
            'source'                => 'Please select source of event.',
            'assigned_to'           => 'Please select the assignee.',
            'description'           => 'Please enter event description.',
        ];

        $this->validate($request, $rules, $messages);

        $lead                       = Lead::find($id)->update([
            'name'                  => $request->name,
            'designation'           => $request->designation,
            'company'               => $request->company,
            'email'                 => $request->email,
            'phone'                 => $request->phone,
            'budget'                => $request->budget,
            'event_type'            => $request->event_type,
            'event_date'            => $request->event_date,
            'source'                => $request->source,
            'description'           => $request->description,
            'location'              => $request->location,
            'assigned_to'           => $request->assigned_to,
        ]);

        if (is_array($request->file('attachments')) && !empty($request->file('attachments'))) {

            foreach ($request->file('attachments') as $key => $file) {

                $extension = $file->getClientOriginalExtension();
                $filename  = $file->getClientOriginalName();
                $size      = $file->getSize();

                $file->storeAs('uploads/leads/' . $id, $filename, 'public');

                LeadAttachment::create([
                    'lead_id'       => $id,
                    'attachment'    => $filename,
                    'extension'     => $extension,
                    'size'          => $size,
                    'path'          => asset('storage/uploads/leads/' . $id . '/' . $filename),
                    'created_by'    => $user->roles->first()->name,
                    'created_by_id' => $user->id
                ]);
            }
        }

        return redirect()->route('superadmin.leads.index')->with('success', 'Lead updated sucessfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Lead::find($id)->delete();
        return redirect()->route('superadmin.leads.index')->with('success', 'Lead deleted sucessfully!');
    }

    public function bulkDelete(Request $request)
    {
        Lead::whereIn('id', $request->leads)->delete();
        return response()->json(['success' => 'Leads deleted successfully!'], 200);
    }

    public function deleteAttachment($id)
    {
        LeadAttachment::find($id)->delete();
        return redirect()->back()->with('success', 'Attachment deleted successfully!');
    }

    public function assign(Request $request)
    {
        Lead::find($request->lead_id)->update(['assigned_to' => $request->assigned_to]);
        return redirect()->back()->with('success', 'Lead assigned sucessfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $user               = $request->user();
        $old_status         = Lead::find($id)->status;

        Lead::find($id)->update(['status' => $request->status]);

        $activity           = LeadActivity::create([
            'lead_id'       => $id,
            'type'          => 'Status Changed',
            'old_status'    => $old_status,
            'new_status'    => $request->status,
            'created_by'    => $user->roles->first()->name,
            'created_by_id' => $user->id
        ]);

        return redirect()->back()->with('success', 'Lead status updated sucessfully!');
    }

    public function updateKanbanStatus(Request $request){
        $user               = $request->user();
        $old_status         = Lead::find($request->lead_id)->status;

        Lead::find($request->lead_id)->update(['status' => $request->status]);

        $activity           = LeadActivity::create([
            'lead_id'       => $request->lead_id,
            'type'          => 'Status Changed',
            'old_status'    => $old_status,
            'new_status'    => $request->status,
            'created_by'    => $user->roles->first()->name,
            'created_by_id' => $user->id
        ]);

        return response()->json(['success' => 'Lead status updated sucessfully!'], 200);
    }

    public function saveNote(Request $request, $id)
    {
        $user               = $request->user();

        $note               = LeadNote::create([
            'lead_id'       => $id,
            'note'          => $request->note,
            'created_by'    => $user->roles->first()->name,
            'created_by_id' => $user->id
        ]);

        LeadActivity::create([
            'lead_id'       => $id,
            'type'          => 'Notes Added',
            'old_status'    => null,
            'new_status'    => null,
            'lead_note_id'  => $request->note,
            'created_by'    => $user->roles->first()->name,
            'created_by_id' => $user->id
        ]);

        return redirect()->back()->with('success', 'Note added sucessfully!');
    }

    public function uploadAttachments(Request $request, $id)
    {
        $user               = $request->user();

        foreach ($request->file('attachments') as $key => $file) {

            $extension = $file->getClientOriginalExtension();
            $filename  = $file->getClientOriginalName();
            $size      = $file->getSize();

            $file->storeAs('uploads/leads/' . $id, $filename, 'public');

            LeadAttachment::create([
                'lead_id'       => $id,
                'attachment'    => $filename,
                'extension'     => $extension,
                'size'          => $size,
                'path'          => asset('storage/uploads/leads/' . $id . '/' . $filename),
                'created_by'    => $user->roles->first()->name,
                'created_by_id' => $user->id
            ]);
        }

        $activity           = LeadActivity::create([
            'lead_id'       => $id,
            'type'          => 'Attachment Uploaded',
            'old_status'    => null,
            'new_status'    => null,
            'note_id'       => null,
            'created_by'    => $user->roles->first()->name,
            'created_by_id' => $user->id
        ]);

        return redirect()->back()->with('success', 'Lead attachment(s) uploaded sucessfully!');
    }
}
