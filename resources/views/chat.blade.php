<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .chat-container {
            width: 100%;
            max-width: 600px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            height: 90vh;
            max-height: 800px;
            overflow: hidden;
        }

        .chat-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 16px 16px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .chat-header h2 {
            font-size: 18px;
            font-weight: 600;
        }

        .online-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            background: #4ade80;
            border-radius: 50%;
            margin-left: 8px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        #chat-box {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            background: #f8f9fa;
        }

        .message-group {
            display: flex;
            margin-bottom: 12px;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message-group.own {
            justify-content: flex-end;
        }

        .message-bubble {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 18px;
            word-wrap: break-word;
            line-height: 1.4;
            font-size: 14px;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .message-bubble.own {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom-right-radius: 4px;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        .message-bubble.other {
            background: white;
            color: #333;
            border: 1px solid #e5e7eb;
            border-bottom-left-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .message-timestamp {
            font-size: 11px;
            opacity: 0.7;
        }

        .typing-indicator {
            display: flex;
            gap: 4px;
            align-items: center;
            padding: 12px 16px;
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #667eea;
            animation: typing 1.4s infinite;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {
            0%, 60%, 100% { opacity: 0.3; transform: translateY(0); }
            30% { opacity: 1; transform: translateY(-10px); }
        }

        .input-area {
            border-top: 1px solid #e5e7eb;
            padding: 16px;
            background: white;
            border-radius: 0 0 16px 16px;
            display: flex;
            gap: 12px;
            align-items: flex-end;
        }

        #msg-input {
            flex: 1;
            padding: 12px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 24px;
            font-size: 14px;
            font-family: inherit;
            resize: none;
            max-height: 100px;
            transition: all 0.3s ease;
        }

        #msg-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        #msg-input::placeholder {
            color: #9ca3af;
        }

        #send-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s ease;
            font-weight: 600;
            flex-shrink: 0;
        }

        #send-btn:hover:not(:disabled) {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        #send-btn:active:not(:disabled) {
            transform: scale(0.95);
        }

        #send-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #9ca3af;
            text-align: center;
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 16px;
            opacity: 0.3;
        }

        /* Scrollbar styling */
        #chat-box::-webkit-scrollbar {
            width: 6px;
        }

        #chat-box::-webkit-scrollbar-track {
            background: transparent;
        }

        #chat-box::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }

        #chat-box::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        @media (max-width: 480px) {
            .chat-container {
                border-radius: 8px;
            }

            .message-bubble {
                max-width: 85%;
            }
        }
    </style>
</head>
<body>

<div class="chat-container">
    <div style="background: white; padding: 12px 20px; border-bottom: 1px solid #e5e7eb; display: flex; gap: 15px; align-items: center;">
        <div style="display: flex; gap: 8px; align-items: center;">
            <span style="font-weight: 600; color: #333;">Chat as:</span>
            <div style="padding: 6px 12px; background: #f0f0f0; border-radius: 6px; font-size: 13px;">
                <strong>{{ auth()->user()->first_name }}</strong> (User {{ auth()->user()->user_id }})
            </div>
        </div>
        <div style="display: flex; gap: 8px; align-items: center;">
            <span style="color: #999;">↔</span>
            <div style="padding: 6px 12px; background: #f0f0f0; border-radius: 6px; font-size: 13px;">
                @if($receiver)
                    <strong>{{ $receiver->first_name }}</strong> (User {{ $receiver->user_id }})
                @else
                    Unknown User
                @endif
            </div>
        </div>
    </div>

    <div class="chat-header">
        <h2>Messages <span class="online-indicator"></span></h2>
        <span id="connection-status" style="font-size: 12px; opacity: 0.8;">● Connected</span>
    </div>

    <div id="chat-box">
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <p>No messages yet. Start the conversation!</p>
        </div>
    </div>

    <div id="typing-area" style="display:none; padding: 12px 20px;">
        <div style="color: #667eea; font-size: 13px; font-weight: 500; margin-bottom: 8px;">Typing...</div>
        <div class="typing-indicator">
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
        </div>
    </div>

    <div class="input-area">
        <input id="msg-input" type="text" placeholder="Type a message..." />
        <button id="send-btn" title="Send message">→</button>
    </div>
</div>

<script>
// ✅ Safe variable passing (handles null/undefined)
const receiverId = @json($receiverId ?? 0);
const senderId = @json(auth()->user()?->user_id ?? 0);
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

let messagesLoaded = false;
let typingTimeout;

function getTimeString(date = new Date()) {
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    return `${hours}:${minutes}`;
}

function clearEmptyState() {
    const emptyState = document.querySelector('.empty-state');
    if (emptyState) {
        emptyState.remove();
    }
}

function appendMessage(text, isMine, timestamp = null) {
    console.log('📨 appendMessage called with:', { text, isMine, timestamp });
    
    try {
        clearEmptyState();
        const box = document.getElementById('chat-box');
        
        if (!box) {
            console.error('❌ CRITICAL: chat-box element not found!');
            return;
        }
        
        console.log('✅ Found chat-box:', box);
        
        const messageGroup = document.createElement('div');
        messageGroup.className = `message-group ${isMine ? 'own' : ''}`;

        const bubble = document.createElement('div');
        bubble.className = `message-bubble ${isMine ? 'own' : 'other'}`;

        const messageText = document.createElement('span');
        messageText.textContent = text;

        const timeSpan = document.createElement('span');
        timeSpan.className = 'message-timestamp';
        timeSpan.textContent = timestamp || getTimeString();

        bubble.appendChild(messageText);
        bubble.appendChild(timeSpan);
        messageGroup.appendChild(bubble);
        
        console.log('✅ Created message element:', messageGroup);
        
        box.appendChild(messageGroup);
        box.scrollTop = box.scrollHeight;
        
        console.log('✅ Message appended to DOM, scrolled to bottom');
    } catch (err) {
        console.error('❌ Error in appendMessage:', err);
        console.error('Stack:', err.stack);
    }
}

function showTypingIndicator() {
    document.getElementById('typing-area').style.display = 'flex';
}

function hideTypingIndicator() {
    document.getElementById('typing-area').style.display = 'none';
}

function updateConnectionStatus(connected) {
    const statusEl = document.getElementById('connection-status');
    if (connected) {
        statusEl.textContent = '● Connected';
        statusEl.style.color = '#4ade80';
    } else {
        statusEl.textContent = '● Disconnected';
        statusEl.style.color = '#f87171';
    }
}

async function sendMessage() {
    const input = document.getElementById('msg-input');
    const btn = document.getElementById('send-btn');
    const text = input.value.trim();
    if (!text) return;

    // Disable button while sending
    input.disabled = true;
    btn.disabled = true;

    try {
        const res = await fetch('/send-message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ receiver_id: receiverId, message: text })
        });

        // ✅ Handle non-JSON responses (like 500 HTML error pages)
        const contentType = res.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const errorText = await res.text();
            throw new Error(`Server returned ${res.status}: ${errorText.substring(0, 300)}`);
        }

        const msg = await res.json();

        if (!res.ok) {
            throw new Error(msg.error || msg.message || `Error ${res.status}`);
        }

        // ✅ Success: append message locally
        appendMessage(msg.message, true);
        input.value = '';
        input.focus();

    } catch (err) {
        console.error('❌ Send failed:', err);
        alert('Failed to send: ' + err.message);
    } finally {
        // Re-enable inputs
        input.disabled = false;
        btn.disabled = false;
    }
}

// Send message on Enter key
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Chat page initialized');
    console.log('📊 senderId:', senderId);
    console.log('📊 receiverId:', receiverId);
    
    const input = document.getElementById('msg-input');
    const btn = document.getElementById('send-btn');
    
    if (!input || !btn) {
        console.error('❌ Chat inputs not found!');
        return;
    }
    
    console.log('✅ Found chat inputs');

    input.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    btn.addEventListener('click', sendMessage);

    // Auto-resize textarea
    input.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 100) + 'px';
    });

    // ✅ Load old messages with error handling
    fetch('/messages/' + receiverId)
        .then(res => {
            console.log('📥 Fetch messages response:', res.status);
            if (!res.ok) throw new Error('Failed to load messages');
            return res.json();
        })
        .then(msgs => {
            console.log('📦 Loaded messages:', msgs);
            messagesLoaded = true;
            msgs.forEach(m => {
                const timeStr = m.created_at ? new Date(m.created_at).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }) : getTimeString();
                console.log('📨 Appending old message:', { text: m.message, senderIsMe: m.sender_id === senderId });
                appendMessage(m.message, m.sender_id === senderId, timeStr);
            });
            console.log('✅ All old messages loaded');
        })
        .catch(err => console.error('❌ Load error:', err));

    // ✅ Real-time listener with Laravel Echo
    if (window.Echo) {
        const users = [senderId, receiverId].sort((a, b) => a - b);
        const conversationId = users[0] + '_' + users[1];
        console.log('🔔 Subscribing to: chat.' + conversationId);

        const channel = window.Echo.private('chat.' + conversationId);

        // Listen for messages
        channel.listen('.message.sent', (event) => {
            console.log('🔔 === MESSAGE RECEIVED ===');
            console.log('📦 Full event object:', event);
            console.log('📊 event.sender_id:', event.sender_id, 'type:', typeof event.sender_id);
            console.log('👤 senderId:', senderId, 'type:', typeof senderId);
            console.log('📝 event.message:', event.message);
            
            hideTypingIndicator();

            // Debug: check if sender IDs match
            const isSameUser = event.sender_id == senderId;
            console.log('🔍 Is same user?', isSameUser, '(will skip if true)');

            if (event.sender_id != senderId) {
                console.log('✅ Different user - appending to DOM...');
                console.log('📨 Calling appendMessage with:', event.message);
                appendMessage(event.message, false);
                console.log('✅ appendMessage completed');
            } else {
                console.log('⏭️ Skipped: message from self');
            }
        });

        // Listen for typing
        channel.listenForWhisper('typing', (e) => {
            if (e.typing) {
                showTypingIndicator();
                clearTimeout(typingTimeout);
                typingTimeout = setTimeout(hideTypingIndicator, 3000);
            }
        });

        // Connection status monitoring
        window.Echo.connector.pusher.connection.bind('state_change', (states) => {
            if (states.current === 'connected') {
                console.log('✅ Pusher connected');
                updateConnectionStatus(true);
            } else {
                console.log('⚠️ Pusher disconnected');
                updateConnectionStatus(false);
            }
        });
    } else {
        console.warn('⚠️ Laravel Echo not loaded — real-time disabled');
    }

    input.focus();
});
</script>
</body>
</html>