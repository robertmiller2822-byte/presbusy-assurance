@extends('admin.layout')

@section('title', 'Live Chats')

@section('content')
<div class="row g-4">
    {{-- Left column: list of chats --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold">Active Chats</div>
            <div class="card-body p-0" style="max-height: 70vh; overflow-y: auto;">
                @forelse ($chats as $chat)
                    <div class="chat-list-item p-3 border-bottom" 
                         onclick="loadChat({{ $chat->id }})" 
                         style="cursor: pointer; transition: 0.3s;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $chat->visitor_name }}</strong>
                                @if ($chat->status === 'active')
                                    <span class="badge bg-success ms-2">Active</span>
                                @else
                                    <span class="badge bg-secondary ms-2">Closed</span>
                                @endif
                            </div>
                            <span class="badge bg-light text-dark">{{ $chat->messages_count }} msgs</span>
                        </div>
                        <div class="text-muted small">
                            {{ $chat->visitor_email ?? 'No email' }}
                            <br>
                            {{ $chat->created_at->diffForHumans() }}
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">No chats yet.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Right column: chat messages and reply area --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                <span id="chatHeader">Select a chat</span>
                <button id="closeChatBtn" class="btn btn-sm btn-outline-danger d-none" onclick="closeChat()">
                    <i class="fas fa-times"></i> Close Chat
                </button>
            </div>
            <div class="card-body" id="chatMessages" style="height: 400px; overflow-y: auto; background: #f8f9fa;">
                <div class="text-center text-muted p-5">
                    <i class="fas fa-comment-dots fa-3x mb-3"></i>
                    <p>Select a chat from the left to start replying.</p>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="input-group">
                    <input type="text" id="adminReplyInput" class="form-control" placeholder="Type your reply..." disabled>
                    <button class="btn btn-gold" id="sendAdminReply" disabled>
                        <i class="fas fa-paper-plane"></i> Send
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection