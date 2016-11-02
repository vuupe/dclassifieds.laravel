<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Mail;

class ContactController extends Controller
{
    public function index()
    {
        //set page title
        $title = [config('dc.site_domain')];
        $title[] = trans('contact.Contact Us Page Title');

        return view('contact.contact', ['title' => $title]);
    }

    public function postcontact(Request $request)
    {
        //validate form
        $rules = [
            'contact_name'      => 'required|string|max:255',
            'contact_mail'      => 'required|email|max:255',
            'contact_message'   => 'required|min:' . config('dc.site_contact_min_words')
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        //send activation mail
        Mail::send('emails.contact', ['params' => $request->all()], function ($m) {
            $m->from(config('dc.site_contact_mail'), config('dc.site_domain'));
            $m->to(config('dc.site_contact_mail'))->subject(trans('contact.New Contact Us Requiest'));
        });

        session()->flash('message', trans('contact.Your message was send.'));
        return redirect(route('info'));
    }
}