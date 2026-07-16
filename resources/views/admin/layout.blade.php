<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .admin-sidebar { background: var(--primary); min-height: 100vh; }
        .admin-sidebar a { color: rgba(255,255,255,0.7); text-decoration: none; display: block; padding: 12px 20px; border-radius: 8px; }
        .admin-sidebar a:hover, .admin-sidebar a.active { background: var(--gold); color: #fff; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 admin-sidebar p-3">
                <h4 class="text-white mb-4"><span class="gold-text">Presbusy</span> Admin</h4>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>
                <a href="{{ route('admin.chats') }}" class="{{ request()->routeIs('admin.chats') ? 'active' : '' }}">💬 Live Chat</a>
                <a href="/">🌐 View Site</a>
                <form action="{{ route('admin.logout') }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-outline-light w-100">Logout</button>
                </form>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- CHAT JAVASCRIPT – loaded on every admin page                --}}
    {{-- ============================================================ --}}
    <script>
        // Global variable for the currently selected chat
        window.currentChatId = null;

        // Load chat messages when a chat is clicked
        window.loadChat = function(chatId) {
            window.currentChatId = chatId;

            const header = document.getElementById('chatHeader');
            const messagesDiv = document.getElementById('chatMessages');
            const input = document.getElementById('adminReplyInput');
            const sendBtn = document.getElementById('sendAdminReply');

            if (!messagesDiv) return;

            header.innerText = 'Loading...';
            messagesDiv.innerHTML = '<div class="text-center p-5">Loading messages...</div>';
            if (input) input.disabled = false;
            if (sendBtn) sendBtn.disabled = false;

            fetch('/admin/chat/fetch/' + chatId)
                .then(res => res.json())
                .then(data => {
                    header.innerText = data.visitor_name;
                    let html = '';
                    data.messages.forEach(msg => {
                        if (msg.sender === 'admin') {
                            html += `<div class="d-flex justify-content-end mb-2">
                                        <div class="bg-primary text-white p-2 rounded" style="max-width: 70%;">
                                            ${msg.message}
                                            <div class="small text-light opacity-50">${new Date(msg.created_at).toLocaleTimeString()}</div>
                                        </div>
                                    </div>`;
                        } else {
                            html += `<div class="d-flex justify-content-start mb-2">
                                        <div class="bg-white p-2 rounded shadow-sm" style="max-width: 70%;">
                                            ${msg.message}
                                            <div class="small text-muted">${new Date(msg.created_at).toLocaleTimeString()}</div>
                                        </div>
                                    </div>`;
                        }
                    });
                    messagesDiv.innerHTML = html;
                    messagesDiv.scrollTop = messagesDiv.scrollHeight;

                    const closeBtn = document.getElementById('closeChatBtn');
                    if (closeBtn) {
                        if (data.status === 'active') closeBtn.classList.remove('d-none');
                        else closeBtn.classList.add('d-none');
                    }
                })
                .catch(error => {
                    console.error('Error loading chat:', error);
                    messagesDiv.innerHTML = '<div class="text-center text-danger p-5">Error loading messages.</div>';
                });
        };

        // Send a message as admin
        window.sendAdminMessage = function() {
            const input = document.getElementById('adminReplyInput');
            const message = input.value.trim();
            if (!message || !window.currentChatId) return;

            fetch('/admin/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    chat_id: window.currentChatId,
                    message: message
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    input.value = '';
                    window.loadChat(window.currentChatId);
                }
            })
            .catch(error => {
                console.error('Send error:', error);
                alert('Failed to send message.');
            });
        };

        // Close a chat
        window.closeChat = function() {
            if (!window.currentChatId) return;
            if (confirm('Close this chat?')) {
                window.location.href = '/admin/chat/close/' + window.currentChatId;
            }
        };

        // Auto‑refresh messages every 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            // Attach event listeners to the send button and input
            const sendBtn = document.getElementById('sendAdminReply');
            const input = document.getElementById('adminReplyInput');
            if (sendBtn) sendBtn.addEventListener('click', window.sendAdminMessage);
            if (input) {
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') window.sendAdminMessage();
                });
            }

            // Polling for new messages
            setInterval(function() {
                if (window.currentChatId) {
                    fetch('/admin/chat/fetch/' + window.currentChatId)
                        .then(res => res.json())
                        .then(data => {
                            const messagesDiv = document.getElementById('chatMessages');
                            if (!messagesDiv) return;
                            let html = '';
                            data.messages.forEach(msg => {
                                if (msg.sender === 'admin') {
                                    html += `<div class="d-flex justify-content-end mb-2">
                                                <div class="bg-primary text-white p-2 rounded" style="max-width: 70%;">
                                                    ${msg.message}
                                                    <div class="small text-light opacity-50">${new Date(msg.created_at).toLocaleTimeString()}</div>
                                                </div>
                                            </div>`;
                                } else {
                                    html += `<div class="d-flex justify-content-start mb-2">
                                                <div class="bg-white p-2 rounded shadow-sm" style="max-width: 70%;">
                                                    ${msg.message}
                                                    <div class="small text-muted">${new Date(msg.created_at).toLocaleTimeString()}</div>
                                                </div>
                                            </div>`;
                                }
                            });
                            messagesDiv.innerHTML = html;
                            messagesDiv.scrollTop = messagesDiv.scrollHeight;
                        })
                        .catch(error => console.error('Refresh error:', error));
                }
            }, 5000);
        });
    </script>

    @stack('scripts')
</body>
</html>