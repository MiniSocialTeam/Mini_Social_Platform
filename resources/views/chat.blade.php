<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="p-6">

<div id="chat-box" style="border:1px solid #ccc; height:400px; overflow-y:auto; padding:16px; margin-bottom:16px; border-radius:8px;"></div>

<div style="display:flex; gap:8px;">
    <input id="msg-input" type="text" placeholder="Type a message..." style="flex:1; padding:8px; border:1px solid #ccc; border-radius:6px;" />
    <button id="send-btn" onclick="sendMessage()">Send</button>
</div>

<script>
// ✅ Safe variable passing (handles null/undefined)
const receiverId = @json($receiverId ?? 0);
const senderId = @json(auth()->user()?->user_id ?? 0);
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

function appendMessage(text, isMine) {
    const box = document.getElementById('chat-box');
    const div = document.createElement('div');
    div.style.cssText = 'margin-bottom:8px;text-align:' + (isMine ? 'right' : 'left');
    const span = document.createElement('span');
    span.style.cssText = 'display:inline-block;padding:8px 12px;border-radius:16px;background:' + (isMine ? '#0084ff' : '#e5e5ea') + ';color:' + (isMine ? '#fff' : '#000') + ';max-width:70%;word-wrap:break-word;';
    span.textContent = text;
    div.appendChild(span);
    box.appendChild(div);
    box.scrollTop = box.scrollHeight;
}

async function sendMessage() {
    const input = document.getElementById('msg-input');
    const btn = document.getElementById('send-btn');
    const text = input.value.trim();
    if (!text) return;

    // Disable button while sending
    input.disabled = true;
    btn.disabled = true;
    btn.textContent = 'Sending...';

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

    } catch (err) {
        console.error('❌ Send failed:', err);
        alert('Failed to send: ' + err.message);
    } finally {
        // Re-enable inputs
        input.disabled = false;
        btn.disabled = false;
        btn.textContent = 'Send';
        input.focus();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // ✅ Load old messages with error handling
    fetch('/messages/' + receiverId)
        .then(res => {
            if (!res.ok) throw new Error('Failed to load messages');
            return res.json();
        })
        .then(msgs => msgs.forEach(m => appendMessage(m.message, m.sender_id === senderId)))
        .catch(err => console.error('Load error:', err));

    // ✅ Real-time listener with Laravel Echo
   // ✅ Real-time listener with Laravel Echo
if (window.Echo) {
    const users = [senderId, receiverId].sort((a, b) => a - b);
    const conversationId = users[0] + '_' + users[1];

    console.log('🔔 Subscribing to: chat.' + conversationId);

    window.Echo.private('chat.' + conversationId)
        // ✅ DOT PREFIX required for broadcastAs() events
        .listen('.message.sent', (event) => {
    console.log('=== MESSAGE RECEIVED ===');
    console.log('event.sender_id:', event.sender_id, '(type:', typeof event.sender_id, ')');
    console.log('senderId:', senderId, '(type:', typeof senderId, ')');
    console.log('Comparison result:', event.sender_id != senderId);
    console.log('Message text:', event.message);
    
    if (event.sender_id != senderId) {
        console.log('✅ Appending to DOM...');
        appendMessage(event.message, false);
    }
})
        
    // Optional: Debug subscription success
    Echo.connector.pusher.connection.bind('state_change', (states) => {
        if (states.current === 'connected') {
            console.log('✅ Pusher connected');
        }
    });
} else {
    console.warn('⚠️ Laravel Echo not loaded — real-time disabled');
}
});
</script>
</body>
</html>