<?php

namespace App\Http\Controllers\Superadmin\QuotationManagement;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Quotation;
use App\Models\Superadmin;
use Illuminate\Http\Request;

class QuotationController extends Controller
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
        $filter['quote_date']   = $request->quote_date;
        $filter['status']       = $request->status;
        $filter['created_at']   = $request->created_at;
        $filter['created_by']   = $request->created_by;
        $filter['assigned_to']  = $request->assigned_to;

        $quotations                  = Quotation::query();
        $quotations                  = isset($filter['lead_id']) ? $quotations->where('lead_id', $filter['lead_id']) : $quotations;
        if (isset($filter['name'])) {
            $name               = $filter['name'];
            $quotations              = $quotations->whereHas('lead', function ($query) use ($name) {
                $query->where('name', 'LIKE', '%' . $name . '%');
            });
        }
        if (isset($filter['email'])) {
            $email              = $filter['email'];
            $quotations              = $quotations->whereHas('lead', function ($query) use ($email) {
                $query->where('email', 'LIKE', '%' . $email . '%');
            });
        }
        if (isset($filter['phone'])) {
            $phone              = $filter['phone'];
            $quotations              = $quotations->whereHas('lead', function ($query) use ($phone) {
                $query->where('phone', 'LIKE', '%' . $phone . '%');
            });
        }

        $quotations                  = isset($filter['type']) ? $quotations->where('type', $filter['type']) : $quotations;
        $quotations                  = isset($filter['quote_date']) ? $quotations->whereDate('quote_date', $filter['quote_date']) : $quotations;
        $quotations                  = isset($filter['status']) ? $quotations->where('status', $filter['status']) : $quotations;
        $quotations                  = isset($filter['created_at']) ? $quotations->whereDate('created_at', $filter['created_at']) : $quotations;
        $quotations                  = isset($filter['created_by']) ? $quotations->where('created_by_id', $filter['created_by']) : $quotations;
        $quotations                  = isset($filter['assigned_to']) ? $quotations->where('assigned_to', $filter['assigned_to']) : $quotations;

        $user                   = $request->user();

        if ($user->hasRole('Administrator')) {
            $quotations              = $quotations->orderBy('id', 'desc')->paginate(40);
        }

        if ($user->hasRole('Manager')) {
            $quotations              = $quotations->paginate(40);
        }

        if ($user->hasRole('Sales Executive')) {
            $quotations              = $quotations->where('assigned_to', $user->id)->paginate(40);
        }

        $creators = Superadmin::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Manager', 'Administrator']);
        })->get();

        $assignees = Superadmin::whereHas('roles', function ($query) {
            $query->where('name', 'Sales Executive');
        })->get();

        $statuses               = ['Pending', 'Sent', 'Accepted', 'Declined'];

        return view('superadmin.quotation-management.quotations.list', compact('quotations', 'filter', 'creators', 'assignees', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $lead       = Lead::find($request->lead_id);
        $assignees  = Superadmin::whereHas('roles', function ($query) {
            $query->where('name', 'Sales Executive');
        })->get();

        $statuses               = ['Pending', 'Sent', 'Accepted', 'Declined'];
        return view('superadmin.quotation-management.quotations.create', compact('lead', 'assignees', 'statuses'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quotation  = Quotation::find($id);
        $lead       = Lead::find($quotation->lead_id);
        $assignees  = Superadmin::whereHas('roles', function ($query) {
            $query->where('name', 'Sales Executive');
        })->get();

        $statuses               = ['Pending', 'Sent', 'Accepted', 'Declined'];
        return view('superadmin.quotation-management.quotations.edit', compact('quotation', 'lead', 'assignees', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        Quotation::find($id)->delete();
        return redirect()->route('superadmin.quotations.index')->with('success', 'Quotation deleted sucessfully!');
    }

    public function bulkDelete(Request $request)
    {
        Quotation::whereIn('id', $request->quotations)->delete();
        return response()->json(['success' => 'Quotations deleted successfully!'], 200);
    }
}
