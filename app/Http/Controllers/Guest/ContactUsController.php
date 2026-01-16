<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Notifications\ContactFormNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ContactUsController extends Controller
{
    public function index()
    {
        return view('guest.contact-us.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'name'                  => ['required'],
            'email'                 => ['required'],
            'phone'                 => ['required'],
            'subject'               => ['required'],
            'message'               => ['required'],
        ];

        $messages = [
            'name.required'         => 'Please enter your name.',
            'email.required'        => 'Please enter your email.',
            'phone.required'        => 'Please enter your phone.',
            'subject.required'      => 'Please enter your subject.',
            'message.required'      => 'Please enter your message.',
        ];

        $this->validate($request, $rules, $messages);

        $data = $request->all();

        Notification::route('mail', 'webreca@gmail.com')
            ->notify(new ContactFormNotification($data));

        return redirect()->back()->with('success', 'Your message has been successfully submitted. We appreciate you reaching out to us and will get back to you as soon as possible.!');
    }
}
