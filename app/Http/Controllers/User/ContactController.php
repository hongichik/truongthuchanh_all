<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\HomeSetting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $homeSettings = HomeSetting::first();
        
        return view('user.contact', compact('homeSettings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($request->all());

        return redirect()->back()->with('success', 'Tin nhắn của bạn đã được gửi thành công! Chúng tôi sẽ phản hồi bạn trong thời gian sớm nhất.');
    }
}