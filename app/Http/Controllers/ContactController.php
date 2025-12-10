<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\Notification;

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

        $contactMessage = ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'user_id' => $userId,
            'status' => 'new',
        ]);

        // Create notification for admin
        Notification::createNotification(
            'system',
            'New Contact Message',
            'A new message received from ' . $contactMessage->name . ' (Subject: ' . $contactMessage->subject . ')',
            null, // No specific user_id for admin notification
            null,
            null
        );

        return redirect()->back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}
