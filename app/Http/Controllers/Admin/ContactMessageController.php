<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Carbon\Carbon;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of contact messages
     */
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'all'); // all, new, read, replied, archived
        
        $query = ContactMessage::with('user')
            ->orderBy('created_at', 'desc');

        // Apply filter
        if ($filter !== 'all') {
            $query->where('status', $filter);
        }

        $messages = $query->paginate(20);
        $newCount = ContactMessage::where('status', 'new')->count();

        return view('admin.contact_messages', compact('messages', 'newCount', 'filter'));
    }

    /**
     * Show a specific contact message
     */
    public function show($id)
    {
        $message = ContactMessage::with('user')->findOrFail($id);
        
        // Mark as read if it's new
        if ($message->status === 'new') {
            $message->markAsRead();
        }

        return view('admin.contact_message_detail', compact('message'));
    }

    /**
     * Update message status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:new,read,replied,archived',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $message = ContactMessage::findOrFail($id);
        
        $updateData = ['status' => $request->status];
        
        if ($request->status === 'read' && !$message->read_at) {
            $updateData['read_at'] = Carbon::now();
        }
        
        if ($request->filled('admin_notes')) {
            $updateData['admin_notes'] = $request->admin_notes;
        }

        $message->update($updateData);

        return redirect()->route('admin.contact_messages')->with('success', 'Message status updated successfully.');
    }

    /**
     * Delete a contact message
     */
    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.contact_messages')->with('success', 'Message deleted successfully.');
    }
}
