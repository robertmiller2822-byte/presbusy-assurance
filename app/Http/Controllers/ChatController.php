<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // Start a new chat session
    public function start(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $chat = Chat::create([
            'visitor_name' => $request->name,
            'visitor_email' => $request->email,
            'status' => 'active',
        ]);

        return response()->json([
            'chat_id' => $chat->id,
            'name' => $chat->visitor_name,
        ]);
    }

    // Send a message as a visitor
    public function send(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'message' => 'required|string',
        ]);

        $message = ChatMessage::create([
            'chat_id' => $request->chat_id,
            'sender' => 'visitor',
            'message' => $request->message,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    // Fetch messages for a chat (polling)
    public function fetch($chatId)
    {
        $chat = Chat::with('messages')->findOrFail($chatId);

        // Mark messages as read if they are from admin
        $chat->messages()->where('sender', 'admin')->update(['is_read' => true]);

        return response()->json([
            'messages' => $chat->messages,
            'status' => $chat->status,
        ]);
    }
}