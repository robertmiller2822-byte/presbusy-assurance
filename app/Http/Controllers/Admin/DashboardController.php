<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMessages = ContactMessage::count();
        $unreadMessages = ContactMessage::where('status', 'unread')->count();
        $messages = ContactMessage::latest()->get();

        return view('admin.dashboard', compact('totalMessages', 'unreadMessages', 'messages'));
    }

    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->status = 'read';
        $message->save();

        return back()->with('success', 'Message marked as read.');
    }

    public function deleteMessage($id)
    {
        ContactMessage::destroy($id);
        return back()->with('success', 'Message deleted.');
    }
}