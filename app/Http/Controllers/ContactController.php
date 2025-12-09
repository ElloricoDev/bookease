<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    /**
     * Display the Contact Us page
     */
    public function index()
    {
        return view('user.contact');
    }

    /**
     * Store a new contact message
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $userId = session('user_id');

        ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'user_id' => $userId,
            'status' => 'new',
        ]);

        // Create notification for admin (we'll create a system notification)
        // Note: This assumes admin notifications are stored differently or we create a system-wide notification
        // For now, we'll just store the message and admins can view it in the contact messages section

        return redirect()->back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}
