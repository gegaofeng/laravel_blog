<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMeRequest;
use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    //
    /**
     * Notes:
     * User:
     * Date:2018/9/2
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showForm()
    {
        return view('blog.contact');
    }

    public function sendContactInfo(ContactMeRequest $request)
    {
        $data = $request->only('name', 'email', 'phone');
        $data['messageLines'] = explode("\n", $request->get('message'));
        //        Mail::queue('email.contact',$data,function($message) use ($data){
        //            $message->subject('Blog Contact Form:'.$data['name'])
        //                ->to(config('blog.contact_email'))
        //                ->replyTo($data['email']);
        //        });
        //直接发送
        //        Mail::to(config('blog.contact_email'))->send(new OrderShipped($data));
        //队列发送
        Mail::to(config('blog.contact_email'))->queue(new OrderShipped($data));
        return back()->withSuccess("Thank you for your message!");
    }
}
