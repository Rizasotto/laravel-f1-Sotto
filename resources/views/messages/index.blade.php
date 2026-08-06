@extends('layouts.app')

@section('title', 'Messaging')

@section('extra-styles')
<style>
    /* Messaging Wrapper */
    .messaging-wrapper {
        background: #f8f9fa;
        min-height: calc(100vh - 100px);
    }

    .messaging-container {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 0;
        min-height: calc(100vh - 100px);
    }

    /* Conversations Sidebar */
    .conversations-sidebar {
        background: white;
        border-right: 1px solid #e0e0e0;
        display: flex;
        flex-direction: column;
    }

    .conversations-header {
        padding: 20px;
        border-bottom: 1px solid #e0e0e0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .conversations-header h2 {
        font-size: 18px;
        margin-bottom: 12px;
    }

    .conversations-search {
        display: flex;
        gap: 8px;
    }

    .conversations-search input {
        flex: 1;
        padding: 8px 12px;
        border: none;
        border-radius: 20px;
        font-size: 12px;
    }

    .conversations-list {
        flex: 1;
        overflow-y: auto;
    }

    .conversation-item {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .conversation-item:hover {
        background: #f8f9fa;
    }

    .conversation-item.active {
        background: #e8eef7;
        border-left: 4px solid #667eea;
    }

    .conversation-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #667eea;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .conversation-header-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    .conversation-name {
        font-weight: 600;
        color: #333;
        font-size: 13px;
    }

    .conversation-time {
        font-size: 11px;
        color: #999;
    }

    .conversation-preview {
        font-size: 12px;
        color: #666;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .conversation-unread {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        background: #667eea;
        color: white;
        border-radius: 50%;
        font-size: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    /* Chat Area */
    .chat-area {
        display: flex;
        flex-direction: column;
        background: white;
    }

    .chat-header {
        padding: 20px;
        border-bottom: 1px solid #e0e0e0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-header-info h3 {
        font-size: 16px;
        margin-bottom: 3px;
    }

    .chat-header-status {
        font-size: 12px;
        opacity: 0.9;
    }

    .chat-header-actions {
        display: flex;
        gap: 10px;
    }

    .chat-header-btn {
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.2s ease;
    }

    .chat-header-btn:hover {
        background: rgba(255,255,255,0.3);
    }

    /* Messages */
    .messages-container {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .message {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
    }

    .message.sent {
        justify-content: flex-end;
    }

    .message-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #667eea;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 12px;
        flex-shrink: 0;
    }

    .message.sent .message-avatar {
        order: 2;
    }

    .message-content {
        max-width: 60%;
    }

    .message.sent .message-content {
        align-items: flex-end;
    }

    .message-bubble {
        padding: 12px 15px;
        border-radius: 12px;
        word-wrap: break-word;
        font-size: 14px;
        line-height: 1.4;
    }

    .message.received .message-bubble {
        background: #f0f0f0;
        color: #333;
        border-radius: 12px 12px 12px 4px;
    }

    .message.sent .message-bubble {
        background: #667eea;
        color: white;
        border-radius: 12px 12px 4px 12px;
    }

    .message-time {
        font-size: 11px;
        color: #999;
        margin-top: 4px;
        text-align: center;
    }

    .message.sent .message-time {
        text-align: right;
    }

    /* Empty Chat State */
    .empty-messages {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #999;
    }

    .empty-messages-icon {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .empty-messages p {
        font-size: 14px;
        margin-bottom: 10px;
    }

    /* Message Input */
    .message-input-area {
        padding: 20px;
        border-top: 1px solid #e0e0e0;
        background: #f8f9fa;
    }

    .message-input-form {
        display: flex;
        gap: 10px;
        align-items: flex-end;
    }

    .message-input-field {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .message-input-field textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        resize: vertical;
        min-height: 44px;
        max-height: 120px;
        transition: all 0.2s ease;
    }

    .message-input-field textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .message-actions {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        width: 44px;
        height: 44px;
        border: none;
        background: #e0e0e0;
        border-radius: 8px;
        cursor: pointer;
        font-size: 18px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .action-btn:hover {
        background: #d0d0d0;
    }

    .send-btn {
        background: #667eea;
        color: white;
    }

    .send-btn:hover {
        background: #764ba2;
    }

    .send-btn:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    /* No Conversations */
    .no-conversations {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        background: white;
    }

    .no-conversations-icon {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .no-conversations p {
        color: #999;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .messaging-container {
            grid-template-columns: 1fr;
        }

        .conversations-sidebar {
            display: none;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 100;
        }

        .conversations-sidebar.show {
            display: flex;
        }

        .message-content {
            max-width: 85%;
        }

        .chat-header-actions {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="messaging-wrapper">
    <div class="messaging-container">
        <!-- Conversations Sidebar -->
        <div class="conversations-sidebar" id="conversationsSidebar">
            <div class="conversations-header">
                <h2>💬 Messages</h2>
                <div class="conversations-search">
                    <input type="text" placeholder="Search..." id="searchConversations">
                </div>
            </div>

            <div class="conversations-list">
                <!-- Conversation Items -->
                @php
                    $conversations = [
                        ['id' => 1, 'name' => 'Sarah Chen', 'type' => 'artist', 'preview' => 'Question about custom commission...', 'time' => '2h ago', 'unread' => 2],
                        ['id' => 2, 'name' => 'Mike Photography', 'type' => 'artist', 'preview' => 'Artwork ready for shipment!', 'time' => '1d ago', 'unread' => 0],
                        ['id' => 3, 'name' => 'Emma Joseph', 'type' => 'buyer', 'preview' => 'Is this still available?', 'time' => '3d ago', 'unread' => 0],
                        ['id' => 4, 'name' => 'Admin Support', 'type' => 'admin', 'preview' => 'We received your support ticket...', 'time' => '1w ago', 'unread' => 0],
                    ];
                @endphp

                @forelse($conversations as $conv)
                <div class="conversation-item {{ $loop->first ? 'active' : '' }}" onclick="selectConversation({{ $conv['id'] }})">
                    <div class="conversation-avatar">{{ substr($conv['name'], 0, 1) }}</div>
                    <div class="conversation-header-info">
                        <span class="conversation-name">{{ $conv['name'] }}</span>
                        <span class="conversation-time">{{ $conv['time'] }}</span>
                    </div>
                    <div class="conversation-preview">{{ $conv['preview'] }}</div>
                    @if($conv['unread'] > 0)
                        <div class="conversation-unread">{{ $conv['unread'] }}</div>
                    @endif
                </div>
                @empty
                <div style="padding: 20px; text-align: center; color: #999;">
                    <p>No conversations yet</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Chat Area -->
        <div class="chat-area" id="chatArea">
            <!-- Chat with Sarah Chen (default) -->
            <div class="chat-header">
                <div class="chat-header-info">
                    <h3>Sarah Chen</h3>
                    <div class="chat-header-status">🟢 Online • Artist</div>
                </div>
                <div class="chat-header-actions">
                    <button class="chat-header-btn">📞 Call</button>
                    <button class="chat-header-btn">ℹ️ Info</button>
                    <button class="chat-header-btn">⋯</button>
                </div>
            </div>

            <div class="messages-container">
                <!-- Messages -->
                <div class="message received">
                    <div class="message-avatar">S</div>
                    <div class="message-content">
                        <div class="message-bubble">Hi! I'm interested in your artwork. Do you do custom commissions?</div>
                        <div class="message-time">2:30 PM</div>
                    </div>
                </div>

                <div class="message received">
                    <div class="message-avatar">S</div>
                    <div class="message-content">
                        <div class="message-bubble">What's your typical turnaround time?</div>
                        <div class="message-time">2:31 PM</div>
                    </div>
                </div>

                <div class="message sent">
                    <div class="message-content">
                        <div class="message-bubble">Yes, I do custom commissions! Usually takes 2-3 weeks depending on the complexity.</div>
                        <div class="message-time">2:45 PM</div>
                    </div>
                    <div class="message-avatar">Y</div>
                </div>

                <div class="message sent">
                    <div class="message-content">
                        <div class="message-bubble">Could you share your portfolio or examples? I'd love to see your work before deciding.</div>
                        <div class="message-time">2:46 PM</div>
                    </div>
                    <div class="message-avatar">Y</div>
                </div>

                <div class="message received">
                    <div class="message-avatar">S</div>
                    <div class="message-content">
                        <div class="message-bubble">Of course! You can check all my works on my profile or I can send you a direct link.</div>
                        <div class="message-time">3:15 PM</div>
                    </div>
                </div>

                <div class="message received">
                    <div class="message-avatar">S</div>
                    <div class="message-content">
                        <div class="message-bubble">How much would a commission cost roughly?</div>
                        <div class="message-time">3:16 PM</div>
                    </div>
                </div>
            </div>

            <!-- Message Input -->
            <div class="message-input-area">
                <form class="message-input-form" onsubmit="sendMessage(event)">
                    <div class="message-input-field">
                        <textarea id="messageInput" placeholder="Type your message..." rows="1"></textarea>
                    </div>
                    <div class="message-actions">
                        <button type="button" class="action-btn">📎</button>
                        <button type="button" class="action-btn">😊</button>
                        <button type="submit" class="action-btn send-btn">📤</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- No Chat Selected (shown on mobile when sidebar is active) -->
        <div class="no-conversations" id="noChatSelected" style="display: none;">
            <div class="no-conversations-icon">💬</div>
            <p>Select a conversation to start messaging</p>
        </div>
    </div>
</div>

<script>
function selectConversation(convId) {
    // Update active conversation
    document.querySelectorAll('.conversation-item').forEach(el => {
        el.classList.remove('active');
    });
    event.currentTarget.classList.add('active');

    // Show chat area on mobile
    if (window.innerWidth <= 768) {
        document.getElementById('conversationsSidebar').classList.remove('show');
    }
}

function sendMessage(e) {
    e.preventDefault();
    const input = document.getElementById('messageInput');
    const message = input.value.trim();

    if (!message) return;

    // Add message to chat
    const container = document.querySelector('.messages-container');
    const messageEl = document.createElement('div');
    messageEl.className = 'message sent';
    messageEl.innerHTML = `
        <div class="message-content">
            <div class="message-bubble">${message}</div>
            <div class="message-time">Now</div>
        </div>
        <div class="message-avatar">Y</div>
    `;
    container.appendChild(messageEl);

    // Scroll to bottom
    container.scrollTop = container.scrollHeight;

    // Clear input
    input.value = '';
    input.focus();

    // Simulate response
    setTimeout(() => {
        const responseEl = document.createElement('div');
        responseEl.className = 'message received';
        responseEl.innerHTML = `
            <div class="message-avatar">S</div>
            <div class="message-content">
                <div class="message-bubble">Thanks for your message! I'll get back to you soon.</div>
                <div class="message-time">Now</div>
            </div>
        `;
        container.appendChild(responseEl);
        container.scrollTop = container.scrollHeight;
    }, 1000);
}

// Auto-resize textarea
const textarea = document.getElementById('messageInput');
textarea.addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});
</script>
@endsection
