<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;

use App\Models\Employee;

class MailController extends Controller
{
    //http://localhost:8000/api/mails/send/10
    public function sendMail($days)
    {
        $doctors = Employee::where('type', 2)->get();

        $emails = array();
        foreach ($doctors as  $doctor) {
            $emails[] = $doctor->email;
        }

        $data = [
            //'subject' => 'Test Mail',
            'subject' => 'Exam Paper Time Remaining.',
            //'body' => 'This is a test message!!',
            'body' =>  $days . ' days left to submit exam questions',
        ];
        try {
            //send to one user mail
            //Mail::to('image1693@gmail.com')->send(new MailNotify($data));
            //send to multiple users mail
            Mail::to($emails)->send(new MailNotify($data));
            return response()->json(['Great check your mail box']);
        } catch (\Exception $e) {
            // return response()->json(['Sorry somthing went wrong!!']);
            dd($e->getMessage());
            return response()->json([$e]);
        }
    }
}
