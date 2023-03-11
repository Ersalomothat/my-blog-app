<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function store(Request $req)
    {
        $data = $req->validate([
            'name' => 'required|string|min:4|max:18',
            'email' => 'required|email|unique:contact_messages,email',
            'subject' => 'string',
            'message' => 'required|string|max:500,min:4'
        ]);

        $contact_msg = ContactMessage::create($data);
        if ($contact_msg) {
            return back()->with('success', 'Your response has been recorded');
        }
        return back()->with('error', 'There are some went wrong! :(');
    }
}
