# Tantor - The Real-Time Messenger (Python Edition)

## Overview

Tantor is the real-time WebSocket messenger that provides instant communication across your application. Like the anxious but loyal elephant from Disney's Tarzan, Tantor may be nervous but never fails to deliver important messages. With excellent hearing and the ability to trumpet warnings across the jungle, Tantor ensures that notifications, chats, and live updates reach their destination instantly.

## Features

### Core Functionality
- **WebSocket server and client management** with async/await support
- **Real-time bidirectional communication** for instant messaging
- **Channel-based messaging** (public, private, emergency channels)
- **Presence tracking** to know who's online
- **Message history and persistence** with Memory integration
- **Automatic reconnection handling** for reliable connections
- **Event broadcasting system** for system-wide notifications
- **Heartbeat monitoring** to detect disconnected clients
- **Emergency alert system** for critical notifications

### Technical Features
- **Async/await architecture** for high-performance WebSocket handling
- **Channel management** with subscriber tracking
- **Message queuing** for reliable delivery
- **Connection lifecycle management** with proper cleanup
- **Event handler system** for custom message processing
- **Statistics and monitoring** for system health
- **Test client generation** for development and testing

## Installation

### Dependencies
```bash
# Required for WebSocket functionality
pip install websockets

# Optional for enhanced features
pip install asyncio-mqtt  # For MQTT integration
pip install redis  # For Redis-based message persistence
```

## Usage

### Basic Server Setup
```python
from elephants.py_ele.tantor import Tantor
import asyncio

# Create Tantor instance
tantor = Tantor(port=8080, host="0.0.0.0")

# Start the server
async def main():
    await tantor.start()

# Run the server
asyncio.run(main())
```

### Flask-TSK Integration
```python
from flask import Flask
from elephants.py_ele.tantor import init_tantor

app = Flask(__name__)

# Initialize Tantor
tantor = init_tantor(app, port=8080, host="0.0.0.0")

# Start Tantor in background thread
import threading
import asyncio

def run_tantor():
    asyncio.run(tantor.start())

tantor_thread = threading.Thread(target=run_tantor, daemon=True)
tantor_thread.start()
```

### Basic Messaging
```python
from elephants.py_ele.tantor import get_tantor

# Get Tantor instance
tantor = get_tantor()

# Send message to specific client
message_id = await tantor.send("client_123", "Hello from Tantor!", "jungle")

# Broadcast to channel
recipients = await tantor.broadcast("jungle", "announcement", {
    "message": "Important announcement!",
    "priority": "high"
})
```

### Channel Management
```python
# Subscribe client to channel
await tantor.subscribe("client_123", "treehouse")

# Unsubscribe from channel
await tantor.unsubscribe("client_123", "jungle")

# Get presence information
presence = tantor.get_presence("jungle")
print(f"Users in jungle: {presence['online']}")
```

### Emergency Alerts
```python
# Send emergency alert to all channels
recipients = await tantor.emergency("Critical system alert!")
print(f"Emergency sent to {recipients} recipients")
```

## Flask-TSK Integration

### App Initialization
```python
from flask import Flask
from elephants.py_ele.tantor import init_tantor
import threading
import asyncio

app = Flask(__name__)

# Initialize Tantor
tantor = init_tantor(app, port=8080)

# Start Tantor in background
def run_tantor_server():
    asyncio.run(tantor.start())

tantor_thread = threading.Thread(target=run_tantor_server, daemon=True)
tantor_thread.start()
```

### Route Usage
```python
from flask import request, jsonify
from elephants.py_ele.tantor import get_tantor
import asyncio

@app.route('/api/tantor/send', methods=['POST'])
def send_message():
    tantor = get_tantor()
    
    if not tantor:
        return jsonify({'error': 'Tantor not initialized'}), 500
    
    data = request.get_json()
    client_id = data.get('client_id')
    message = data.get('message')
    channel = data.get('channel', 'jungle')
    
    # Run async function in sync context
    async def send_async():
        return await tantor.send(client_id, message, channel)
    
    message_id = asyncio.run(send_async())
    
    return jsonify({
        'success': True,
        'message_id': message_id
    })

@app.route('/api/tantor/broadcast', methods=['POST'])
def broadcast_message():
    tantor = get_tantor()
    
    data = request.get_json()
    channel = data.get('channel', 'jungle')
    event = data.get('event', 'message')
    data_payload = data.get('data', {})
    
    async def broadcast_async():
        return await tantor.broadcast(channel, event, data_payload)
    
    recipients = asyncio.run(broadcast_async())
    
    return jsonify({
        'success': True,
        'recipients': recipients,
        'channel': channel
    })

@app.route('/api/tantor/subscribe', methods=['POST'])
def subscribe_to_channel():
    tantor = get_tantor()
    
    data = request.get_json()
    client_id = data.get('client_id')
    channel = data.get('channel', 'jungle')
    
    async def subscribe_async():
        return await tantor.subscribe(client_id, channel)
    
    success = asyncio.run(subscribe_async())
    
    return jsonify({
        'success': success,
        'client_id': client_id,
        'channel': channel
    })

@app.route('/api/tantor/unsubscribe', methods=['POST'])
def unsubscribe_from_channel():
    tantor = get_tantor()
    
    data = request.get_json()
    client_id = data.get('client_id')
    channel = data.get('channel', 'jungle')
    
    async def unsubscribe_async():
        return await tantor.unsubscribe(client_id, channel)
    
    success = asyncio.run(unsubscribe_async())
    
    return jsonify({
        'success': success,
        'client_id': client_id,
        'channel': channel
    })

@app.route('/api/tantor/presence')
def get_presence():
    tantor = get_tantor()
    
    channel = request.args.get('channel')
    presence = tantor.get_presence(channel)
    
    return jsonify(presence)

@app.route('/api/tantor/emergency', methods=['POST'])
def send_emergency():
    tantor = get_tantor()
    
    data = request.get_json()
    message = data.get('message', 'Emergency alert!')
    
    async def emergency_async():
        return await tantor.emergency(message)
    
    recipients = asyncio.run(emergency_async())
    
    return jsonify({
        'success': True,
        'recipients': recipients,
        'message': message
    })

@app.route('/api/tantor/stats')
def get_stats():
    tantor = get_tantor()
    
    if not tantor:
        return jsonify({'error': 'Tantor not initialized'}), 500
    
    stats = tantor.stats()
    return jsonify(stats)

@app.route('/api/tantor/client/<client_id>')
def get_client_info(client_id):
    tantor = get_tantor()
    
    if not tantor:
        return jsonify({'error': 'Tantor not initialized'}), 500
    
    info = tantor.get_client_info(client_id)
    
    if not info:
        return jsonify({'error': 'Client not found'}), 404
    
    return jsonify(info)
```

## WebSocket Client Usage

### JavaScript Client
```javascript
// Connect to Tantor
const ws = new WebSocket('ws://localhost:8080');

ws.onopen = function() {
    console.log('Connected to Tantor! 🐘');
    
    // Join channel
    ws.send(JSON.stringify({
        action: 'join_channel',
        channel: 'jungle'
    }));
};

ws.onmessage = function(event) {
    const data = JSON.parse(event.data);
    console.log('Received:', data);
    
    // Handle different message types
    if (data.event === 'welcome') {
        console.log('Welcome message:', data.message);
    } else if (data.event === 'emergency_alert') {
        console.log('Emergency:', data.data.message);
    }
};

// Send message
function sendMessage(message, channel = 'jungle') {
    ws.send(JSON.stringify({
        action: 'broadcast',
        channel: channel,
        event: 'chat_message',
        data: { message: message }
    }));
}

// Send ping
function ping() {
    ws.send(JSON.stringify({
        action: 'ping'
    }));
}
```

### Python Client
```python
import asyncio
import websockets
import json

async def tantor_client():
    uri = "ws://localhost:8080"
    
    async with websockets.connect(uri) as websocket:
        # Join channel
        await websocket.send(json.dumps({
            'action': 'join_channel',
            'channel': 'jungle'
        }))
        
        # Send message
        await websocket.send(json.dumps({
            'action': 'broadcast',
            'channel': 'jungle',
            'event': 'chat_message',
            'data': {'message': 'Hello from Python client!'}
        }))
        
        # Listen for messages
        async for message in websocket:
            data = json.loads(message)
            print(f"Received: {data}")

# Run client
asyncio.run(tantor_client())
```

## Channel Types

### Public Channels
```python
# Jungle channel - everyone can join
await tantor.subscribe("client_123", "jungle")

# General announcements
await tantor.broadcast("jungle", "announcement", {
    "message": "Welcome to the jungle!",
    "type": "welcome"
})
```

### Private Channels
```python
# Treehouse channel - private conversations
await tantor.subscribe("client_123", "treehouse")

# Private messages
await tantor.broadcast("treehouse", "private_message", {
    "message": "Secret message",
    "recipients": ["client_123", "client_456"]
})
```

### Emergency Channels
```python
# Emergency channel - critical alerts
await tantor.subscribe("client_123", "emergency")

# Emergency broadcast
await tantor.emergency("System is down! Immediate attention required!")
```

## Event Handling

### Custom Event Handlers
```python
# Register event handler
def handle_user_joined(data):
    print(f"User {data['client_id']} joined channel {data['channel']}")

tantor.on_event('user_joined', handle_user_joined)

# Async event handler
async def handle_emergency(data):
    print(f"Emergency alert: {data['message']}")
    # Send notification to admin
    await send_admin_notification(data)

tantor.on_event('emergency_alert', handle_emergency)
```

### Built-in Events
- `welcome` - Client connection welcome
- `user_joined` - User joined channel
- `user_left` - User left channel
- `emergency_alert` - Emergency notification
- `server_shutdown` - Server shutdown notification
- `ping/pong` - Heartbeat messages

## Configuration

### Environment Variables
```bash
# Server configuration
TANTOR_PORT=8080
TANTOR_HOST=0.0.0.0

# Channel configuration
TANTOR_DEFAULT_CHANNEL=jungle
TANTOR_HEARTBEAT_INTERVAL=30

# Message persistence
TANTOR_MESSAGE_TTL=3600
TANTOR_EMERGENCY_TTL=86400
```

### Configuration File
```python
# config.py
TANTOR_CONFIG = {
    'port': 8080,
    'host': '0.0.0.0',
    'default_channel': 'jungle',
    'heartbeat_interval': 30,
    'message_ttl': 3600,
    'emergency_ttl': 86400,
    'max_connections': 1000,
    'max_message_size': 1024 * 1024  # 1MB
}
```

## Integration with Other Elephants

### Happy Integration
```python
# Notify when image processing is complete
async def notify_image_processed(user_id, image_path, filter_name):
    tantor = get_tantor()
    
    await tantor.broadcast("user_notifications", "image_processed", {
        "user_id": user_id,
        "image_path": image_path,
        "filter_name": filter_name,
        "status": "completed"
    })

# Register with Happy
happy = get_happy()
happy.on_processing_complete = notify_image_processed
```

### Heffalump Integration
```python
# Notify when search indexing is complete
async def notify_search_indexed(content_id, status):
    tantor = get_tantor()
    
    await tantor.broadcast("system_notifications", "search_indexed", {
        "content_id": content_id,
        "status": status,
        "timestamp": time.time()
    })

# Register with Heffalump
heffalump = get_heffalump()
heffalump.on_index_complete = notify_search_indexed
```

### Horton Integration
```python
# Notify when job status changes
async def notify_job_status(job_id, status, result=None):
    tantor = get_tantor()
    
    await tantor.broadcast("job_notifications", "job_status_changed", {
        "job_id": job_id,
        "status": status,
        "result": result,
        "timestamp": time.time()
    })

# Register with Horton
horton = get_horton()
horton.on_job_status_change = notify_job_status
```

## Performance Optimization

### Connection Management
```python
# Monitor connection limits
def check_connection_limits():
    stats = tantor.stats()
    
    if stats['total_connections'] > 1000:
        print("Warning: High connection count")
        # Implement connection limiting
    
    if stats['queued_messages'] > 100:
        print("Warning: Message queue backlog")
        # Implement message prioritization
```

### Message Batching
```python
# Batch multiple messages
async def batch_broadcast(channel, messages):
    for message in messages:
        await tantor.broadcast(channel, message['event'], message['data'])
        await asyncio.sleep(0.01)  # Small delay to prevent flooding
```

### Channel Optimization
```python
# Clean up empty channels
async def cleanup_channels():
    for channel_name, channel in tantor.channels.items():
        if not channel.subscribers and channel_name not in ['jungle', 'emergency']:
            del tantor.channels[channel_name]
            print(f"Cleaned up empty channel: {channel_name}")
```

## Testing

### Test Client Generation
```python
# Generate test client
tantor = Tantor(8080)
test_client_path = tantor.create_test_client_html(8080)
print(f"Test client created: {test_client_path}")
```

### Unit Testing
```python
import pytest
import asyncio

@pytest.mark.asyncio
async def test_tantor_messaging():
    tantor = Tantor(8081)  # Use different port for testing
    
    # Test message sending
    message_id = await tantor.send("test_client", "Hello", "test")
    assert message_id is not None
    
    # Test broadcasting
    recipients = await tantor.broadcast("test", "test_event", {"data": "test"})
    assert recipients == 0  # No subscribers yet
    
    # Test subscription
    success = await tantor.subscribe("test_client", "test")
    assert success is True
    
    # Test presence
    presence = tantor.get_presence("test")
    assert presence['online'] == 1
```

### Integration Testing
```python
import asyncio
import websockets

async def test_websocket_connection():
    # Start Tantor server
    tantor = Tantor(8082)
    server_task = asyncio.create_task(tantor.start())
    
    # Wait for server to start
    await asyncio.sleep(1)
    
    # Connect client
    async with websockets.connect('ws://localhost:8082') as websocket:
        # Send message
        await websocket.send(json.dumps({
            'action': 'join_channel',
            'channel': 'test'
        }))
        
        # Receive response
        response = await websocket.recv()
        data = json.loads(response)
        assert data['event'] == 'welcome'
    
    # Stop server
    server_task.cancel()
```

## Troubleshooting

### Common Issues

1. **WebSocket Connection Failed**
   ```python
   # Check if server is running
   import socket
   
   def check_server(host, port):
       try:
           sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
           result = sock.connect_ex((host, port))
           sock.close()
           return result == 0
       except Exception:
           return False
   ```

2. **High Memory Usage**
   ```python
   # Monitor memory usage
   import psutil
   
   def monitor_memory():
       process = psutil.Process()
       memory_info = process.memory_info()
       print(f"Memory usage: {memory_info.rss / 1024 / 1024:.2f} MB")
   ```

3. **Connection Drops**
   ```python
   # Implement reconnection logic
   async def reconnect_client():
       while True:
           try:
               async with websockets.connect('ws://localhost:8080') as ws:
                   # Handle connection
                   pass
           except Exception as e:
               print(f"Connection lost: {e}")
               await asyncio.sleep(5)  # Wait before reconnecting
   ```

4. **Message Queue Backlog**
   ```python
   # Monitor queue size
   def check_queue_health():
       stats = tantor.stats()
       if stats['queued_messages'] > 100:
           print("Queue backlog detected")
           # Implement queue processing optimization
   ```

### Debug Mode
```python
import logging

# Enable debug logging
logging.basicConfig(level=logging.DEBUG)

# Debug WebSocket connections
async def debug_connection(client_id):
    info = tantor.get_client_info(client_id)
    print(f"Client info: {info}")
    
    stats = tantor.stats()
    print(f"Server stats: {stats}")
```

## Security Considerations

### Authentication
```python
# Implement client authentication
async def authenticate_client(client_id, token):
    # Verify token with your auth system
    if verify_token(token):
        tantor.connections[client_id].user_data['authenticated'] = True
        return True
    return False
```

### Rate Limiting
```python
# Implement rate limiting
from collections import defaultdict
import time

message_counts = defaultdict(list)

def check_rate_limit(client_id, limit=10, window=60):
    now = time.time()
    message_counts[client_id] = [
        timestamp for timestamp in message_counts[client_id]
        if now - timestamp < window
    ]
    
    if len(message_counts[client_id]) >= limit:
        return False
    
    message_counts[client_id].append(now)
    return True
```

### Message Validation
```python
# Validate incoming messages
def validate_message(message):
    if len(message) > 1024 * 1024:  # 1MB limit
        return False
    
    # Check for malicious content
    if '<script>' in message.lower():
        return False
    
    return True
```

## Future Enhancements

- **MQTT integration** for IoT messaging
- **Redis pub/sub** for distributed messaging
- **Message encryption** for secure communications
- **Message persistence** with database storage
- **Load balancing** for multiple Tantor instances
- **Message queuing** with priority levels
- **Real-time analytics** and monitoring
- **Mobile push notifications** integration

## Contributing

To contribute to Tantor's development:

1. Follow the anxious but reliable principles
2. Maintain the "never fail to deliver" attitude
3. Include comprehensive error handling
4. Add performance optimizations
5. Test with various client types and loads

## License

Tantor is part of the TuskPHP ecosystem and follows the same licensing terms as the main project.

---

*"He's not just any elephant - he's Tantor, and he delivers messages!"* 🐘📢 