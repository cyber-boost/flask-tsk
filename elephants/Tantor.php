<?php
/**
 * <?tusk> TuskPHP Tantor - The Real-Time Messenger
 * ===============================================
 * 
 * 🐘 BACKSTORY: Tantor - Tarzan's Anxious but Loyal Friend
 * -------------------------------------------------------
 * In Disney's Tarzan, Tantor is a big-hearted elephant with anxiety issues
 * who becomes one of Tarzan's closest friends. Despite being afraid of
 * everything (especially piranhas), Tantor always comes through when it
 * matters. He's known for his excellent hearing, ability to trumpet warnings
 * across the jungle, and his unwavering loyalty to his friends.
 * 
 * WHY THIS NAME: Like Tantor who could hear danger from afar and trumpet
 * messages across the jungle, this WebSocket messenger provides real-time
 * communication across your application. Tantor may have been nervous, but
 * he never failed to deliver important messages. This system ensures that
 * notifications, chats, and live updates reach their destination instantly,
 * with the same reliability Tarzan could count on from his elephant friend.
 * 
 * "He's not just any elephant - he's Tantor, and he delivers messages!"
 * 
 * FEATURES:
 * - WebSocket server and client management
 * - Real-time bidirectional communication
 * - Channel-based messaging (public/private)
 * - Presence tracking (who's online)
 * - Message history and persistence
 * - Automatic reconnection handling
 * - Event broadcasting system
 * 
 * @package TuskPHP\Elephants
 * @author  TuskPHP Team
 * @since   1.0.0
 */

namespace TuskPHP\Elephants;

use TuskPHP\{Tusk, Memory, Stomp};

class Tantor {
    
    private $connections = [];
    private $channels = [];
    private $messageQueue = [];
    private $port = 8080;
    private $isRunning = false;
    
    /**
     * Initialize Tantor - The messenger prepares to listen
     */
    public function __construct($port = 8080) {
        $this->port = $port;
        $this->channels = [
            'jungle' => [],     // Public channel - like the jungle drums
            'treehouse' => [],  // Private channel - Tarzan's inner circle
            'emergency' => []   // Urgent alerts - Tantor's warning trumpets
        ];
    }
    
    /**
     * Start the WebSocket server - Tantor begins listening
     */
    public function listen() {
        $this->isRunning = true;
        
        echo "🐘 Tantor is listening on port {$this->port}...\n";
        echo "Despite his nervousness, he won't miss a message!\n\n";
        
        // Create WebSocket server (would use Ratchet/ReactPHP in production)
        $server = $this->createServer();
        
        while ($this->isRunning) {
            // Like Tantor's big ears, always alert
            $this->acceptConnections($server);
            $this->processMessages();
            $this->checkHeartbeats();
        }
    }
    
    /**
     * Send message - Tantor trumpets across the jungle
     */
    public function send($clientId, $message, $channel = 'jungle') {
        if (!isset($this->connections[$clientId])) {
            // Tantor is worried - where did the friend go?
            throw new \Exception("Oh no! I can't find that client! *nervous trumpet*");
        }
        
        $payload = [
            'id' => uniqid('msg_'),
            'channel' => $channel,
            'message' => $message,
            'timestamp' => microtime(true),
            'sender' => 'tantor'
        ];
        
        // Queue message for delivery
        $this->messageQueue[] = [
            'to' => $clientId,
            'payload' => $payload
        ];
        
        // Tantor's reliability - persist important messages
        Memory::remember("tantor_msg_{$payload['id']}", $payload, 3600);
        
        return $payload['id'];
    }
    
    /**
     * Broadcast to channel - Jungle-wide announcement
     */
    public function broadcast($channel, $event, $data = []) {
        if (!isset($this->channels[$channel])) {
            // Tantor creates new channels as needed
            $this->channels[$channel] = [];
        }
        
        $message = [
            'event' => $event,
            'data' => $data,
            'channel' => $channel,
            'timestamp' => microtime(true),
            'trumpeted_by' => 'tantor'
        ];
        
        // Send to all subscribers in the channel
        foreach ($this->channels[$channel] as $clientId) {
            // Even nervous Tantor ensures everyone hears
            $this->send($clientId, $message, $channel);
        }
        
        echo "📢 Tantor broadcasts to {$channel}: {$event}\n";
        
        return count($this->channels[$channel]);
    }
    
    /**
     * Subscribe client to channel - Join Tantor's friend circle
     */
    public function subscribe($clientId, $channel) {
        if (!isset($this->channels[$channel])) {
            $this->channels[$channel] = [];
        }
        
        if (!in_array($clientId, $this->channels[$channel])) {
            $this->channels[$channel][] = $clientId;
            
            // Notify others - "New friend in the jungle!"
            $this->broadcast($channel, 'user_joined', [
                'client_id' => $clientId,
                'total_users' => count($this->channels[$channel])
            ]);
        }
        
        return true;
    }
    
    /**
     * Handle presence - Who's in the jungle with Tantor?
     */
    public function getPresence($channel = null) {
        if ($channel) {
            return [
                'channel' => $channel,
                'online' => count($this->channels[$channel] ?? []),
                'users' => $this->channels[$channel] ?? []
            ];
        }
        
        // Tantor's full jungle census
        $presence = [];
        foreach ($this->channels as $ch => $users) {
            $presence[$ch] = count($users);
        }
        
        return $presence;
    }
    
    /**
     * Emergency alert - Tantor's loudest trumpet!
     */
    public function emergency($message) {
        // When Tantor panics, EVERYONE hears about it
        echo "🚨 TANTOR'S EMERGENCY TRUMPET: {$message}\n";
        
        // Broadcast to all channels
        foreach ($this->channels as $channel => $users) {
            $this->broadcast($channel, 'emergency_alert', [
                'message' => $message,
                'severity' => 'critical',
                'source' => 'tantor_emergency_system'
            ]);
        }
        
        // Log for posterity - even anxious elephants keep records
        Memory::remember('tantor_emergency_' . time(), [
            'message' => $message,
            'timestamp' => microtime(true),
            'recipients' => $this->countAllConnections()
        ], 86400);
    }
    
    /**
     * Handle disconnection - When friends leave the jungle
     */
    private function handleDisconnect($clientId) {
        // Remove from all channels - Tantor is sad to see them go
        foreach ($this->channels as $channel => &$users) {
            $users = array_filter($users, fn($id) => $id !== $clientId);
            
            // Notify others
            if (count($users) > 0) {
                $this->broadcast($channel, 'user_left', [
                    'client_id' => $clientId
                ]);
            }
        }
        
        unset($this->connections[$clientId]);
    }
    
    /**
     * Get statistics - Tantor's nervous monitoring
     */
    public function stats() {
        return [
            'total_connections' => count($this->connections),
            'channels' => array_map('count', $this->channels),
            'queued_messages' => count($this->messageQueue),
            'uptime' => $this->getUptime(),
            'status' => $this->isRunning ? 'listening' : 'sleeping',
            'mood' => count($this->connections) > 10 ? 'anxious' : 'calm'
        ];
    }
    
    /**
     * Create WebSocket server - Tantor prepares his listening post
     */
    private function createServer() {
        $server = stream_socket_server("tcp://0.0.0.0:{$this->port}", $errno, $errstr);
        
        if (!$server) {
            throw new \Exception("Tantor is too nervous! Can't create server: {$errstr} ({$errno})");
        }
        
        stream_set_blocking($server, false);
        echo "🎯 Tantor's server created on port {$this->port}\n";
        
        return $server;
    }
    
    /**
     * Accept new connections - Tantor welcomes new jungle friends
     */
    private function acceptConnections($server) {
        $client = @stream_socket_accept($server, 0);
        
        if ($client) {
            $clientId = uniqid('client_');
            $this->connections[$clientId] = [
                'socket' => $client,
                'handshake' => false,
                'last_ping' => microtime(true),
                'joined_at' => microtime(true),
                'channels' => []
            ];
            
            echo "👋 New friend joined Tantor's jungle: {$clientId}\n";
            
            // Auto-subscribe to jungle channel
            $this->subscribe($clientId, 'jungle');
        }
    }
    
    /**
     * Process message queue - Tantor delivers all his messages
     */
    private function processMessages() {
        while (!empty($this->messageQueue)) {
            $queuedMessage = array_shift($this->messageQueue);
            $clientId = $queuedMessage['to'];
            $payload = $queuedMessage['payload'];
            
            if (isset($this->connections[$clientId])) {
                $this->deliverMessage($clientId, $payload);
            } else {
                echo "⚠️ Tantor lost a friend: {$clientId} - message dropped\n";
            }
        }
        
        // Read incoming messages from all clients
        foreach ($this->connections as $clientId => $connection) {
            $this->readClientMessage($clientId, $connection['socket']);
        }
    }
    
    /**
     * Deliver message to specific client - Tantor's careful delivery
     */
    private function deliverMessage($clientId, $payload) {
        $connection = $this->connections[$clientId];
        $socket = $connection['socket'];
        
        if (!$connection['handshake']) {
            // Need to complete WebSocket handshake first
            $this->performHandshake($clientId, $socket);
            return;
        }
        
        $jsonPayload = json_encode($payload);
        $frame = $this->createWebSocketFrame($jsonPayload);
        
        $result = @fwrite($socket, $frame);
        
        if ($result === false) {
            echo "💔 Tantor couldn't deliver to {$clientId} - connection lost\n";
            $this->handleDisconnect($clientId);
        } else {
            echo "📨 Tantor delivered message to {$clientId}\n";
        }
    }
    
    /**
     * Read messages from clients - Tantor listens carefully
     */
    private function readClientMessage($clientId, $socket) {
        $data = @fread($socket, 1024);
        
        if ($data === false || $data === '') {
            return;
        }
        
        if (!$this->connections[$clientId]['handshake']) {
            // Handle WebSocket handshake
            if (strpos($data, 'Upgrade: websocket') !== false) {
                $this->performHandshake($clientId, $socket, $data);
            }
            return;
        }
        
        // Decode WebSocket frame
        $message = $this->decodeWebSocketFrame($data);
        
        if ($message) {
            $this->handleClientMessage($clientId, $message);
        }
    }
    
    /**
     * Handle incoming client messages - Tantor processes jungle chatter
     */
    private function handleClientMessage($clientId, $message) {
        $decoded = json_decode($message, true);
        
        if (!$decoded) {
            echo "🤔 Tantor doesn't understand: {$message}\n";
            return;
        }
        
        $action = $decoded['action'] ?? 'chat';
        
        switch ($action) {
            case 'join_channel':
                $channel = $decoded['channel'] ?? 'jungle';
                $this->subscribe($clientId, $channel);
                break;
                
            case 'leave_channel':
                $channel = $decoded['channel'] ?? 'jungle';
                $this->unsubscribe($clientId, $channel);
                break;
                
            case 'broadcast':
                $channel = $decoded['channel'] ?? 'jungle';
                $event = $decoded['event'] ?? 'message';
                $data = $decoded['data'] ?? [];
                $this->broadcast($channel, $event, $data);
                break;
                
            case 'ping':
                $this->connections[$clientId]['last_ping'] = microtime(true);
                $this->send($clientId, ['pong' => true], 'system');
                break;
                
            default:
                echo "🐘 Tantor heard: {$message} from {$clientId}\n";
        }
    }
    
    /**
     * Unsubscribe from channel - Leave Tantor's friend group
     */
    public function unsubscribe($clientId, $channel) {
        if (isset($this->channels[$channel])) {
            $this->channels[$channel] = array_filter(
                $this->channels[$channel], 
                fn($id) => $id !== $clientId
            );
            
            // Notify others
            $this->broadcast($channel, 'user_left', [
                'client_id' => $clientId,
                'total_users' => count($this->channels[$channel])
            ]);
        }
        
        return true;
    }
    
    /**
     * Perform WebSocket handshake - Tantor's greeting ritual
     */
    private function performHandshake($clientId, $socket, $request = null) {
        if (!$request) {
            return false;
        }
        
        // Extract WebSocket key
        preg_match('/Sec-WebSocket-Key: (.*)\\r\\n/', $request, $matches);
        
        if (empty($matches[1])) {
            echo "❌ Tantor couldn't find WebSocket key for {$clientId}\n";
            return false;
        }
        
        $key = trim($matches[1]);
        $acceptKey = base64_encode(sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
        
        $response = "HTTP/1.1 101 Switching Protocols\r\n";
        $response .= "Upgrade: websocket\r\n";
        $response .= "Connection: Upgrade\r\n";
        $response .= "Sec-WebSocket-Accept: {$acceptKey}\r\n\r\n";
        
        fwrite($socket, $response);
        
        $this->connections[$clientId]['handshake'] = true;
        echo "🤝 Tantor completed handshake with {$clientId}\n";
        
        // Send welcome message
        $this->send($clientId, [
            'event' => 'welcome',
            'message' => 'Welcome to Tantor\'s jungle! 🐘',
            'client_id' => $clientId
        ], 'system');
        
        return true;
    }
    
    /**
     * Create WebSocket frame - Tantor's message packaging
     */
    private function createWebSocketFrame($data) {
        $length = strlen($data);
        $frame = chr(129); // Text frame, final
        
        if ($length <= 125) {
            $frame .= chr($length);
        } elseif ($length <= 65535) {
            $frame .= chr(126) . pack('n', $length);
        } else {
            $frame .= chr(127) . pack('J', $length);
        }
        
        return $frame . $data;
    }
    
    /**
     * Decode WebSocket frame - Tantor's message unwrapping
     */
    private function decodeWebSocketFrame($data) {
        if (strlen($data) < 2) {
            return false;
        }
        
        $firstByte = ord($data[0]);
        $secondByte = ord($data[1]);
        
        $opcode = $firstByte & 15;
        $masked = ($secondByte & 128) == 128;
        $length = $secondByte & 127;
        
        if ($opcode == 8) {
            // Connection close
            return false;
        }
        
        $offset = 2;
        
        if ($length == 126) {
            $length = unpack('n', substr($data, $offset, 2))[1];
            $offset += 2;
        } elseif ($length == 127) {
            $length = unpack('J', substr($data, $offset, 8))[1];
            $offset += 8;
        }
        
        if ($masked) {
            $mask = substr($data, $offset, 4);
            $offset += 4;
            $payload = '';
            
            for ($i = 0; $i < $length; $i++) {
                $payload .= chr(ord($data[$offset + $i]) ^ ord($mask[$i % 4]));
            }
        } else {
            $payload = substr($data, $offset, $length);
        }
        
        return $payload;
    }
    
    /**
     * Check heartbeats - Tantor's wellness checks
     */
    private function checkHeartbeats() {
        $now = microtime(true);
        $timeout = 30; // 30 seconds
        
        foreach ($this->connections as $clientId => $connection) {
            if (($now - $connection['last_ping']) > $timeout) {
                echo "💔 Tantor lost contact with {$clientId} - removing\n";
                $this->handleDisconnect($clientId);
            }
        }
        
        // Send ping to all connected clients every 10 seconds
        static $lastPing = 0;
        if (($now - $lastPing) > 10) {
            foreach ($this->connections as $clientId => $connection) {
                if ($connection['handshake']) {
                    $this->send($clientId, ['ping' => true], 'system');
                }
            }
            $lastPing = $now;
        }
    }
    
    /**
     * Count all connections across channels - Tantor's census
     */
    private function countAllConnections() {
        return count($this->connections);
    }
    
    /**
     * Get uptime - How long has Tantor been listening?
     */
    private function getUptime() {
        static $startTime = null;
        
        if ($startTime === null) {
            $startTime = microtime(true);
        }
        
        return microtime(true) - $startTime;
    }
    
    /**
     * Stop the server - Tantor needs a rest
     */
    public function stop() {
        $this->isRunning = false;
        
        // Notify all clients
        foreach ($this->connections as $clientId => $connection) {
            $this->send($clientId, [
                'event' => 'server_shutdown',
                'message' => 'Tantor is going to sleep. Goodbye! 🐘💤'
            ], 'system');
        }
        
        echo "💤 Tantor is going to sleep...\n";
    }
    
    /**
     * Get client info - Tantor remembers his friends
     */
    public function getClientInfo($clientId) {
        if (!isset($this->connections[$clientId])) {
            return null;
        }
        
        $connection = $this->connections[$clientId];
        $clientChannels = [];
        
        foreach ($this->channels as $channel => $users) {
            if (in_array($clientId, $users)) {
                $clientChannels[] = $channel;
            }
        }
        
        return [
            'client_id' => $clientId,
            'connected_at' => $connection['joined_at'],
            'last_ping' => $connection['last_ping'],
            'channels' => $clientChannels,
            'uptime' => microtime(true) - $connection['joined_at']
        ];
    }
    
    /**
     * Create a simple WebSocket client for testing - Tantor's practice buddy
     */
    public static function createTestClient($port = 8080) {
        $html = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>🐘 Tantor WebSocket Test Client</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f0f8ff; }
        .container { max-width: 800px; margin: 0 auto; }
        .messages { border: 1px solid #ddd; height: 300px; overflow-y: auto; padding: 10px; background: white; margin: 10px 0; }
        .controls { margin: 10px 0; }
        input, button { padding: 8px; margin: 5px; }
        .elephant { font-size: 2em; text-align: center; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="elephant">🐘 Tantor's Jungle Chat</div>
        
        <div class="controls">
            <button onclick="connect()">Connect to Tantor</button>
            <button onclick="disconnect()">Disconnect</button>
            <span id="status">Disconnected</span>
        </div>
        
        <div class="controls">
            <input type="text" id="messageInput" placeholder="Type your message..." onkeypress="if(event.key==='Enter')sendMessage()">
            <button onclick="sendMessage()">Send Message</button>
        </div>
        
        <div class="controls">
            <select id="channelSelect">
                <option value="jungle">🌿 Jungle (Public)</option>
                <option value="treehouse">🏠 Treehouse (Private)</option>
                <option value="emergency">🚨 Emergency</option>
            </select>
            <button onclick="joinChannel()">Join Channel</button>
        </div>
        
        <div id="messages" class="messages">
            <div><em>🐘 Tantor is waiting for you to connect...</em></div>
        </div>
    </div>

    <script>
        let ws = null;
        let clientId = null;
        
        function connect() {
            ws = new WebSocket('ws://localhost:{$port}');
            
            ws.onopen = function() {
                document.getElementById('status').textContent = 'Connected to Tantor! 🐘';
                addMessage('🎉 Connected to Tantor\'s jungle!');
            };
            
            ws.onmessage = function(event) {
                const data = JSON.parse(event.data);
                if (data.client_id) clientId = data.client_id;
                addMessage('📨 ' + JSON.stringify(data, null, 2));
            };
            
            ws.onclose = function() {
                document.getElementById('status').textContent = 'Disconnected';
                addMessage('👋 Disconnected from Tantor');
            };
            
            ws.onerror = function(error) {
                addMessage('❌ Error: ' + error);
            };
        }
        
        function disconnect() {
            if (ws) {
                ws.close();
                ws = null;
            }
        }
        
        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();
            
            if (message && ws && ws.readyState === WebSocket.OPEN) {
                ws.send(JSON.stringify({
                    action: 'broadcast',
                    channel: document.getElementById('channelSelect').value,
                    event: 'chat_message',
                    data: { message: message, from: clientId || 'unknown' }
                }));
                
                input.value = '';
                addMessage('📤 Sent: ' + message);
            }
        }
        
        function joinChannel() {
            const channel = document.getElementById('channelSelect').value;
            
            if (ws && ws.readyState === WebSocket.OPEN) {
                ws.send(JSON.stringify({
                    action: 'join_channel',
                    channel: channel
                }));
                
                addMessage('🚪 Joining channel: ' + channel);
            }
        }
        
        function addMessage(message) {
            const messages = document.getElementById('messages');
            const div = document.createElement('div');
            div.innerHTML = '<small>' + new Date().toLocaleTimeString() + '</small> ' + message;
            messages.appendChild(div);
            messages.scrollTop = messages.scrollHeight;
        }
    </script>
</body>
</html>
HTML;
        
        file_put_contents('tantor-test-client.html', $html);
        echo "🧪 Test client created: tantor-test-client.html\n";
        echo "📂 Open in browser to test Tantor's WebSocket server!\n";
        
        return 'tantor-test-client.html';
    }
} 