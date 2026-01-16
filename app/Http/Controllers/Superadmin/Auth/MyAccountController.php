<?php

namespace App\Http\Controllers\Superadmin\Auth;

use App\Models\Superadmin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class MyAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:superadmin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Superadmin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Superadmin $admin)
    {
        $id             = Auth::guard('superadmin')->id();
        $admin          = Superadmin::find($id);
        $admin->avatar  = isset($admin->avatar_path) ? $admin->avatar_path : "https://placehold.co/150x150/E3E1FF/0266DA?text=" . $admin->initials;
        return view('superadmin.settings.my-account', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'firstname' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:superadmins,email,' . $id],
            'phone'     => ['required', 'min:8', 'unique:superadmins,phone,' . $id],
            'status'    => ['required']
        ]);

        $superadmin                  = Superadmin::find($id);
        $superadmin->firstname       = $request->firstname;
        $superadmin->lastname        = $request->lastname;
        $superadmin->email           = $request->email;
        $superadmin->dialcode        = $request->dialcode;
        $superadmin->phone           = $request->phone;
        $superadmin->iso2            = $request->iso2;
        $superadmin->status          = $request->status;
        $superadmin->address         = $request->address;
        $superadmin->city            = $request->city;
        $superadmin->state           = $request->state;
        $superadmin->zipcode         = $request->zipcode;
        $superadmin->save();

        $superadmin                  = Superadmin::find($id);

        if ($request->hasFile('avatar')) {
            $image                    = $request->file('avatar');

            $extension                = $image->getClientOriginalExtension();
            $timestamp                = now()->format('Ymd_His');
            $fileName                 = "{$timestamp}.{$extension}";

            $filePath                 = $image->storeAs("uploads/superadmins/" . $superadmin->slug, $fileName, 'public');

            Superadmin::find($superadmin->id)->update([
                'avatar'              => $fileName,
                'avatar_path'         => URL::asset('storage/' . $filePath)
            ]);
        }

        return redirect()->route('superadmin.my-account.edit', $superadmin->id)->with('success', 'Account updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Superadmin $admin)
    {
        //
    }
}
