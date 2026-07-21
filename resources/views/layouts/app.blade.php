<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('android-chrome-512x512.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <title>@yield('title')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body>

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Page Content -->
    @yield('content')

    <!-- Footer -->
    @include('partials.footer')

    <!-- Live Chat Widget -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chat state
        let chatId = null;
        let visitorName = '';

        // Create chat modal dynamically
        const chatHTML = `
        <div id="chatModal" style="display: none; position: fixed; bottom: 110px; right: 20px; width: 360px; max-width: 90vw; max-height: 480px; background: #fff; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); z-index: 9999; flex-direction: column; overflow: hidden; border: 1px solid #eee;">
            <div style="background: #0B1F3A; color: #fff; padding: 14px 20px; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 600;"><span style="color: #D4AF37;">Prestbury</span> Support</span>
                <span id="chatCloseBtn" style="cursor: pointer; font-size: 1.4rem;">&times;</span>
            </div>
            <div id="chatLoginForm" style="padding: 20px;">
                <p style="font-size: 0.9rem; color: #555;">Hello! How can we help you today?</p>
                <input type="text" id="chatNameInput" class="form-control mb-2" placeholder="Your Name *">
                <input type="email" id="chatEmailInput" class="form-control mb-2" placeholder="Your Email (optional)">
                <button id="chatStartBtn" class="btn btn-gold w-100">Start Chat</button>
            </div>
            <div id="chatMessagesArea" style="display: none; flex: 1; padding: 15px; overflow-y: auto; max-height: 280px; background: #f8f9fa; flex-direction: column;">
                <div id="chatMessageList"></div>
            </div>
            <div id="chatInputArea" style="display: none; padding: 10px; background: #fff; border-top: 1px solid #ddd; gap: 8px; align-items: center;">
                <input type="text" id="chatVisitorInput" class="form-control" placeholder="Type a message...">
                <button id="chatSendBtn" class="btn btn-gold" style="padding: 8px 16px;">Send</button>
            </div>
            <div id="chatStatus" style="display: none; text-align: center; padding: 10px; font-size: 0.85rem; background: #f8f9fa; color: #888; border-top: 1px solid #eee;">
                Chat closed by admin
            </div>
        </div>
        `;

        document.body.insertAdjacentHTML('beforeend', chatHTML);

        const modal = document.getElementById('chatModal');
        const loginForm = document.getElementById('chatLoginForm');
        const messagesArea = document.getElementById('chatMessagesArea');
        const inputArea = document.getElementById('chatInputArea');
        const statusDiv = document.getElementById('chatStatus');

        // Open chat function (called from floating button)
        window.openChat = function() {
            if (modal.style.display === 'flex') {
                modal.style.display = 'none';
            } else {
                modal.style.display = 'flex';
                if (!chatId) {
                    loginForm.style.display = 'block';
                    messagesArea.style.display = 'none';
                    inputArea.style.display = 'none';
                    statusDiv.style.display = 'none';
                }
            }
        };

        document.getElementById('chatCloseBtn').addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Start chat
        document.getElementById('chatStartBtn').addEventListener('click', function() {
            const name = document.getElementById('chatNameInput').value.trim();
            const email = document.getElementById('chatEmailInput').value.trim();

            if (!name) {
                alert('Please enter your name.');
                return;
            }

            fetch('/chat/start', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name: name, email: email })
            })
            .then(res => res.json())
            .then(data => {
                chatId = data.chat_id;
                visitorName = data.name;
                loginForm.style.display = 'none';
                messagesArea.style.display = 'flex';
                inputArea.style.display = 'flex';
                statusDiv.style.display = 'none';
                document.getElementById('chatMessageList').innerHTML = '<div class="text-muted text-center small">Chat started. Say hello!</div>';
                fetchMessages();
                startPolling();
            });
        });

        // Send message (visitor)
        function sendVisitorMessage() {
            const input = document.getElementById('chatVisitorInput');
            const msg = input.value.trim();
            if (!msg || !chatId) return;

            fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                },
                body: JSON.stringify({ chat_id: chatId, message: msg })
            })
            .then(() => {
                input.value = '';
                fetchMessages();
            });
        }

        document.getElementById('chatSendBtn').addEventListener('click', sendVisitorMessage);
        document.getElementById('chatVisitorInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') sendVisitorMessage();
        });

        // Fetch messages
        function fetchMessages() {
            if (!chatId) return;
            fetch(`/chat/fetch/${chatId}`)
                .then(res => res.json())
                .then(data => {
                    let html = '';
                    data.messages.forEach(msg => {
                        if (msg.sender === 'admin') {
                            html += `<div class="d-flex justify-content-start mb-2"><div class="bg-primary text-white p-2 rounded" style="max-width: 80%;">${msg.message}<div class="small text-light opacity-50">${new Date(msg.created_at).toLocaleTimeString()}</div></div></div>`;
                        } else {
                            html += `<div class="d-flex justify-content-end mb-2"><div class="bg-white p-2 rounded shadow-sm" style="max-width: 80%;">${msg.message}<div class="small text-muted">${new Date(msg.created_at).toLocaleTimeString()}</div></div></div>`;
                        }
                    });
                    document.getElementById('chatMessageList').innerHTML = html || '<div class="text-muted text-center small">No messages yet.</div>';
                    document.getElementById('chatMessagesArea').scrollTop = document.getElementById('chatMessagesArea').scrollHeight;

                    if (data.status === 'closed') {
                        inputArea.style.display = 'none';
                        statusDiv.style.display = 'block';
                    }
                });
        }

        let pollingInterval = null;
        function startPolling() {
            if (pollingInterval) clearInterval(pollingInterval);
            pollingInterval = setInterval(fetchMessages, 5000);
        }
    });

    // Override the floating button click to open chat
    // The existing chat button in layout currently uses onclick="openChat()"
    </script>

</body>
</html>