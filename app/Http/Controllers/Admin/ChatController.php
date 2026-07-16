<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // Show the admin chat interface
    public function index()
    {
        $chats = Chat::withCount('messages')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.chat', compact('chats'));
    }

    // Fetch messages for a specific chat (admin side)
    public function fetch($id)
    {
        $chat = Chat::with('messages')->findOrFail($id);
        return response()->json($chat);
    }

    // Send a message as admin
    public function send(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'message' => 'required|string',
        ]);

        $message = ChatMessage::create([
            'chat_id' => $request->chat_id,
            'sender' => 'admin',
            'message' => $request->message,
            'is_read' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    // Close a chat
    public function close($id)
    {
        $chat = Chat::findOrFail($id);
        $chat->status = 'closed';
        $chat->save();

        return back()->with('success', 'Chat closed.');
    }
}