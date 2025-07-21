<?php
/**
 * live-chat.php
 * Enhanced chat widget with real-time messaging simulation
 */
?>

<section class="tusk-utility-live-chat" id="live-chat">
    <div class="utility-container">
        <h2>💬 Live Chat Support</h2>
        <p>Get instant help from our support team</p>
        
        <div class="chat-container">
            <div class="chat-header">
                <div class="agent-info">
                    <div class="agent-avatar">👩‍💼</div>
                    <div class="agent-details">
                        <strong>Sarah Johnson</strong>
                        <span class="status online">● Online</span>
                    </div>
                </div>
                <button class="chat-minimize" onclick="toggleChat()">−</button>
            </div>
            
            <div class="chat-messages" id="chat-messages">
                <div class="chat-message bot">
                    <div class="message-avatar">🤖</div>
                    <div class="message-content">
                        <p>Hello! Welcome to TuskPHP support. How can I help you today?</p>
                        <span class="message-time">2:30 PM</span>
                    </div>
                </div>
            </div>
            
            <div class="chat-input-container">
                <input type="text" id="chat-input" class="chat-input" 
                       placeholder="Type your message..." maxlength="500">
                <button class="chat-send" onclick="sendMessage()">📤</button>
            </div>
            
            <div class="typing-indicator" id="typing-indicator" style="display: none;">
                <span>Sarah is typing</span>
                <div class="typing-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="chat-quick-actions">
            <h3>Quick Help</h3>
            <div class="quick-buttons">
                <button class="quick-btn" onclick="quickMessage('I need help with installation')">
                    🔧 Installation Help
                </button>
                <button class="quick-btn" onclick="quickMessage('I have a billing question')">
                    💳 Billing Support
                </button>
                <button class="quick-btn" onclick="quickMessage('I found a bug')">
                    🐛 Report Bug
                </button>
                <button class="quick-btn" onclick="quickMessage('I need documentation')">
                    📚 Documentation
                </button>
            </div>
        </div>
    </div>
</section>

<script>
const chatResponses = [
    "Thanks for reaching out! Let me help you with that.",
    "I understand your concern. Here's what I can do for you...",
    "That's a great question! Let me provide you with the information.",
    "I'd be happy to assist you with this issue.",
    "Let me check our knowledge base for the best solution.",
    "I'll connect you with a specialist who can help with this specific topic.",
    "Here's a helpful resource that should answer your question:",
    "Would you like me to schedule a call with our technical team?"
];

function sendMessage() {
    const input = document.getElementById('chat-input');
    const message = input.value.trim();
    
    if (message) {
        addMessage(message, 'user');
        input.value = '';
        
        // Show typing indicator
        showTyping();
        
        // Simulate bot response
        setTimeout(() => {
            hideTyping();
            const response = chatResponses[Math.floor(Math.random() * chatResponses.length)];
            addMessage(response, 'bot');
        }, 1500 + Math.random() * 1000);
    }
}

function quickMessage(message) {
    document.getElementById('chat-input').value = message;
    sendMessage();
}

function addMessage(text, sender) {
    const messagesContainer = document.getElementById('chat-messages');
    const messageDiv = document.createElement('div');
    messageDiv.className = `chat-message ${sender}`;
    
    const avatar = sender === 'user' ? '👤' : '👩‍💼';
    const time = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    
    messageDiv.innerHTML = `
        <div class="message-avatar">${avatar}</div>
        <div class="message-content">
            <p>${text}</p>
            <span class="message-time">${time}</span>
        </div>
    `;
    
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function showTyping() {
    document.getElementById('typing-indicator').style.display = 'flex';
    document.getElementById('chat-messages').scrollTop = document.getElementById('chat-messages').scrollHeight;
}

function hideTyping() {
    document.getElementById('typing-indicator').style.display = 'none';
}

function toggleChat() {
    const chatContainer = document.querySelector('.chat-container');
    chatContainer.classList.toggle('minimized');
}

// Send message on Enter key
document.getElementById('chat-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});

// Auto-scroll to bottom on new messages
const observer = new MutationObserver(() => {
    const messages = document.getElementById('chat-messages');
    messages.scrollTop = messages.scrollHeight;
});

observer.observe(document.getElementById('chat-messages'), {
    childList: true,
    subtree: true
});
</script>