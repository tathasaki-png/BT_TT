<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Realtime Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        document.addEventListener('DOMContentLoaded', () => {
            let token = document.head.querySelector('meta[name="csrf-token"]');
            if (token) {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
            }
        });
    </script>
    <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.3/dist/echo.iife.js"></script>
    <script>
        window.Pusher = Pusher;
    </script>
</head>

<body class="bg-gray-100 h-screen flex flex-col">
    <div class="bg-blue-600 text-white p-4 shadow-md flex justify-between items-center">
        <h1 class="text-xl font-bold">Mini Chat <span id="connection-status" class="text-xs bg-yellow-500 px-2 py-1 rounded ml-2">Connecting...</span></h1>
        <div class="flex items-center space-x-4">
            <div class="text-sm">Logged in as: <strong>{{ Auth::user()->name }}</strong></div>
            <a href="{{ route('logout') }}" class="text-sm bg-red-500 hover:bg-red-600 px-3 py-1 rounded transition">Logout</a>
        </div>
    </div>

    <div class="flex-1 flex overflow-hidden">
        <!-- Sidebar -->
        <div class="w-1/4 bg-white border-right overflow-y-auto">
            <div class="p-4 border-b font-semibold bg-gray-50">Contacts</div>
            <ul>
                @foreach($users as $user)
                <li class="p-4 border-b cursor-pointer hover:bg-blue-50 transition user-item group"
                    data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="font-bold text-gray-800 group-hover:text-blue-600">{{ $user->name }}</div>
                            <div class="text-xs text-gray-500 uppercase">{{ $user->role }}</div>
                        </div>
                        <div class="h-2 w-2 rounded-full bg-gray-300"></div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Chat Area -->
        <div class="flex-1 flex flex-col bg-white">
            <div id="chat-header" class="p-4 border-b font-bold text-gray-700 bg-gray-50">
                Select a contact to start chatting
            </div>

            <div id="messages" class="flex-1 p-4 overflow-y-auto space-y-4">
                <!-- Messages will appear here -->
            </div>

            <div class="p-4 border-t bg-gray-50">
                <form id="chat-form" class="flex space-x-2">
                    <input type="hidden" id="receiver-id" value="">
                    <input type="text" id="message-input"
                        class="flex-1 border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-200 disabled:cursor-not-allowed"
                        placeholder="Select a contact to start chatting..."
                        disabled>
                    <button type="submit"
                        class="bg-gray-400 text-white px-6 py-2 rounded-lg cursor-not-allowed transition disabled:opacity-50"
                        disabled>Send
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Suppress Tailwind CDN warning
        window.TAILWIND_MODE = 'watch';
        
        const userId = {{ Auth::id() }};
        const messagesContainer = document.getElementById('messages');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message-input');
        const receiverInput = document.getElementById('receiver-id');
        const chatHeader = document.getElementById('chat-header');
        const sendBtn = chatForm.querySelector('button');

        // Setup Echo
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ config('broadcasting.connections.reverb.key') }}',
            wsHost: '{{ config('broadcasting.connections.reverb.options.host') }}',
            wsPort: {{ config('broadcasting.connections.reverb.options.port') }},
            wssPort: {{ config('broadcasting.connections.reverb.options.port') }},
            forceTLS: false,
            cluster: 'mt1',
            disableStats: true,
            enabledTransports: ['ws', 'wss'],
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });

        const statusEl = document.getElementById('connection-status');

        // Gắn sự kiện lắng nghe ngay lập tức, Echo sẽ tự động kết nối và đăng ký khi sẵn sàng
        const conn = window.Echo.connector.pusher.connection;
        
        conn.bind('connected', () => {
            statusEl.innerText = 'Connected';
            statusEl.className = 'text-xs bg-green-500 px-2 py-1 rounded ml-2';
        });

        conn.bind('unavailable', () => {
            statusEl.innerText = 'Unavailable (Is Reverb running?)';
            statusEl.className = 'text-xs bg-red-500 px-2 py-1 rounded ml-2';
        });

        conn.bind('error', (err) => {
            console.error('Connection error:', err);
            statusEl.innerText = 'Connection Error';
            statusEl.className = 'text-xs bg-red-800 px-2 py-1 rounded ml-2';
        });

        // Listen for messages on own private channel
        window.Echo.private(`chat.${userId}`)
            .subscribed(() => {
                console.log('Successfully subscribed to private channel chat.' + userId);
            })
            .error((error) => {
                console.error('Subscription error:', error);
                statusEl.innerText = 'Auth Error (Check Console)';
                statusEl.className = 'text-xs bg-orange-500 px-2 py-1 rounded ml-2';
            })
            .listen('MessageSent', (e) => {
                console.log('Message received:', e);
                if (parseInt(receiverInput.value) === e.message.sender_id) {
                    appendMessage(e.message, 'received');
                } else {
                    alert('New message from ' + e.message.sender.name);
                }
            });

        // Handle user selection
        console.log('Chat initialization...');
        document.querySelectorAll('.user-item').forEach(item => {
            console.log('found user item:', item.getAttribute('data-name'));
            item.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                console.log('User clicked:', name, id);

                receiverInput.value = id;
                chatHeader.innerHTML = 'Chat with <span class="text-blue-600">' + name + '</span>';
                messageInput.disabled = false;
                sendBtn.disabled = false;
                messageInput.placeholder = 'Write to ' + name + '...';
                messageInput.focus();

                // Highlight selected user
                document.querySelectorAll('.user-item').forEach(i => {
                    i.classList.remove('bg-blue-100', 'border-l-4', 'border-blue-600');
                });
                this.classList.add('bg-blue-100', 'border-l-4', 'border-blue-600');

                // Dừng auto-refresh cũ nếu có
                if (autoRefreshInterval) {
                    clearInterval(autoRefreshInterval);
                }

                fetchMessages(id);

                // Bắt đầu auto-refresh mỗi 3 giây
                autoRefreshInterval = setInterval(() => {
                    console.log('Auto-refreshing messages from user:', id);
                    fetchMessages(id, false);
                }, 3000);
            });
        });

        let autoRefreshInterval = null;

        function fetchMessages(receiverId, showLoading = true) {
            if (showLoading) {
                messagesContainer.innerHTML = '<div class="text-center text-gray-500">Loading...</div>';
            }
            axios.get(`/messages/${receiverId}`)
                .then(response => {
                    if (showLoading) {
                        messagesContainer.innerHTML = '';
                    }
                    response.data.forEach(msg => {
                        // Kiểm tra xem tin nhắn đã tồn tại chưa (tránh duplicate)
                        if (!document.querySelector(`[data-msg-id="${msg.id}"]`)) {
                            const type = msg.sender_id === userId ? 'sent' : 'received';
                            appendMessage(msg, type);
                        }
                    });
                    scrollToBottom();
                });
        }

        function appendMessage(msg, type) {
            const div = document.createElement('div');
            div.className = `flex ${type === 'sent' ? 'justify-end' : 'justify-start'}`;
            div.setAttribute('data-msg-id', msg.id);

            const innerDiv = document.createElement('div');
            innerDiv.className = `max-w-xs md:max-w-md px-4 py-2 rounded-lg ${
                type === 'sent' ? 'bg-blue-600 text-white rounded-br-none' : 'bg-gray-200 text-gray-800 rounded-bl-none'
            }`;
            innerDiv.innerText = msg.message;

            div.appendChild(innerDiv);
            messagesContainer.appendChild(div);
            scrollToBottom();
        }

        function scrollToBottom() {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Form submission triggered');
            const message = messageInput.value.trim();
            const receiverId = receiverInput.value;

            if (!message) {
                console.warn('Empty message, ignored.');
                return;
            }
            if (!receiverId) {
                console.warn('No receiver selected!');
                alert('Please select a user to chat with first.');
                return;
            }

            console.log('Sending message to:', receiverId);
            const originalValue = messageInput.value;
            messageInput.value = 'Sending...';
            messageInput.disabled = true;
            sendBtn.disabled = true;

            axios.post('/messages', {
                receiver_id: receiverId,
                message: message
            }).then(response => {
                console.log('Message sent successfully:', response.data);
                messageInput.value = '';
                appendMessage(response.data.message, 'sent');
            }).catch(err => {
                console.error('Send error:', err);
                const errorMsg = err.response?.data?.message || err.message || 'Unknown error';
                alert('Failed to send message: ' + errorMsg);
                messageInput.value = originalValue;
            }).finally(() => {
                messageInput.disabled = false;
                sendBtn.disabled = false;
                messageInput.focus();
            });
        });
    </script>
</body>

</html>