<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendEmail(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $data = $request->only('name', 'email', 'message');

        // Send plain text email instead of view
        Mail::raw(
            "Name: {$data['name']}\nEmail: {$data['email']}\nMessage:\n{$data['message']}",
            function ($message) use ($data) {
                $message->to('recipient@example.com') // your email
                        ->subject('New Contact Message from ' . $data['name'])
                        ->replyTo($data['email']);
            }
        );

        return back()->with('success', 'Message sent successfully!');
    }
}
