# Dumbo - The Lightweight HTTP Flyer (Python Edition)

## 🐘 Overview

Dumbo is the HTTP client component of Flask-TSK, inspired by Disney's beloved flying elephant. Just as Dumbo discovered he could fly with his oversized ears, this HTTP client makes web requests soar with grace and speed. It's lightweight, fast, and turns complex HTTP operations into simple, elegant flights across the web.

## 🪶 Features

### Core HTTP Capabilities
- **Simple Fluent API**: Easy-to-use request methods
- **Automatic Retries**: Exponential backoff with Timothy Mouse's encouragement
- **Response Caching**: Remember previous flights for speed
- **Parallel Requests**: Formation flying for multiple requests
- **Cookie Management**: Persistent session handling
- **Progress Callbacks**: Track large downloads
- **Built-in Error Handling**: Graceful failure management
- **Magic Feather Mode**: Enhanced confidence and capabilities

### HTTP Methods Supported
- **GET**: Basic flights across the web
- **POST**: Carry cargo to destinations
- **PUT**: Update existing cargo
- **DELETE**: Remove cargo
- **PATCH**: Partially update cargo

### Advanced Features
- **Session Management**: Persistent connections
- **Custom Headers**: Flight instructions
- **Timeout Control**: Prevent hanging flights
- **Health Checks**: Verify destinations are reachable
- **Batch Operations**: Multiple requests in parallel

## 🚀 Installation & Setup

### 1. Basic Installation
```python
from elephants.py_ele.dumbo import Dumbo

# Initialize Dumbo
dumbo = Dumbo()
```

### 2. Flask-TSK Integration
```python
from flask import Flask
from elephants.py_ele.dumbo import init_dumbo

app = Flask(__name__)
dumbo = init_dumbo(app)
```

### 3. Quick Start
```python
# Simple GET request
response = dumbo.get('https://api.example.com/data')

# Simple POST request
response = dumbo.post('https://api.example.com/submit', 
                     data={'name': 'Dumbo', 'type': 'elephant'})
```

## 📚 Usage Examples

### Basic HTTP Requests
```python
# GET request with parameters
response = dumbo.get('https://api.example.com/users', 
                    params={'page': 1, 'limit': 10})

print(f"Status: {response.status_code}")
print(f"Body: {response.body}")
print(f"Time: {response.elapsed_time:.2f}s")

# POST request with JSON data
response = dumbo.post('https://api.example.com/users',
                     json_data={'name': 'Dumbo', 'age': 5})

# PUT request to update
response = dumbo.put('https://api.example.com/users/123',
                    json_data={'age': 6})

# DELETE request
response = dumbo.delete('https://api.example.com/users/123')
```

### Fluent API Usage
```python
# Chain methods for configuration
response = (dumbo
    .with_headers({'Authorization': 'Bearer token123'})
    .with_timeout(60)
    .with_retries(5)
    .get('https://api.example.com/protected-data'))
```

### Custom Headers and Cookies
```python
# Set custom headers
dumbo.with_headers({
    'User-Agent': 'Dumbo/1.0',
    'Accept': 'application/json',
    'Authorization': 'Bearer your-token'
})

# Set cookies
dumbo.with_cookies({
    'session_id': 'abc123',
    'user_preference': 'dark_mode'
})

response = dumbo.get('https://api.example.com/profile')
```

### Magic Feather Mode
```python
# Enable enhanced confidence mode
dumbo.with_magic_feather(True)
# This increases retries to 5 and timeout to 60s

# Or disable for faster, less reliable requests
dumbo.with_magic_feather(False)
```

### Parallel Requests (Formation Flying)
```python
# Multiple requests in parallel
requests_list = [
    {
        'key': 'users',
        'url': 'https://api.example.com/users',
        'method': 'GET'
    },
    {
        'key': 'posts',
        'url': 'https://api.example.com/posts',
        'method': 'GET'
    },
    {
        'key': 'create_user',
        'url': 'https://api.example.com/users',
        'method': 'POST',
        'kwargs': {'json_data': {'name': 'New User'}}
    }
]

results = dumbo.fly_formation(requests_list)

for key, response in results.items():
    print(f"{key}: {response.status_code}")
```

### File Downloads with Progress
```python
def progress_callback(percent, downloaded, total):
    print(f"Downloaded: {percent:.1f}% ({downloaded}/{total} bytes)")

# Download a file with progress tracking
success = dumbo.download(
    'https://example.com/large-file.zip',
    'downloads/large-file.zip',
    progress_callback
)

if success:
    print("🪶 Dumbo successfully delivered the cargo!")
else:
    print("🪶 Dumbo had trouble with this delivery")
```

### Health Checks and Pinging
```python
# Check if a URL is reachable
if dumbo.can_reach('https://api.example.com/health'):
    print("🪶 Destination is reachable!")
else:
    print("🪶 Cannot reach destination")

# Detailed ping information
ping_info = dumbo.ping('https://api.example.com/health')
print(f"Reachable: {ping_info['reachable']}")
print(f"Response Time: {ping_info['response_time']:.2f}s")
print(f"Status Code: {ping_info['status_code']}")

# Batch ping multiple URLs
urls = [
    'https://api1.example.com/health',
    'https://api2.example.com/health',
    'https://api3.example.com/health'
]

batch_results = dumbo.batch_ping(urls)
for url, result in batch_results.items():
    status = "✅" if result['reachable'] else "❌"
    print(f"{status} {url}: {result.get('response_time', 'N/A')}s")
```

## 🔧 Configuration Options

### Timeout and Retry Settings
```python
# Custom timeout (seconds)
dumbo.with_timeout(120)

# Custom retry count
dumbo.with_retries(10)

# Magic feather mode (increases both)
dumbo.with_magic_feather(True)  # timeout=60, retries=5
```

### Session Configuration
```python
# Get current session info
info = dumbo.get_session_info()
print(f"Headers: {info['headers']}")
print(f"Cookies: {info['cookies']}")
print(f"Timeout: {info['timeout']}s")
print(f"Retries: {info['retries']}")
```

## 🎯 Response Handling

### DumboResponse Object
```python
response = dumbo.get('https://api.example.com/data')

# Basic properties
print(f"Status: {response.status_code}")
print(f"Body: {response.body}")
print(f"URL: {response.url}")
print(f"Time: {response.elapsed_time:.2f}s")

# Headers and cookies
print(f"Content-Type: {response.content_type}")
print(f"Cookies: {response.cookies}")

# JSON data (if available)
if response.json_data:
    print(f"JSON: {response.json_data}")
```

### Error Handling
```python
try:
    response = dumbo.get('https://api.example.com/data')
    if response.status_code == 200:
        print("🪶 Successful flight!")
    else:
        print(f"🪶 Flight completed but with status {response.status_code}")
except Exception as e:
    print(f"🪶 Dumbo couldn't complete the flight: {e}")
```

## 🗄️ Caching System

### Automatic Caching
Dumbo automatically caches successful responses (status 200) for 5 minutes:

```python
# First request - hits the network
response1 = dumbo.get('https://api.example.com/data')

# Second request - served from cache
response2 = dumbo.get('https://api.example.com/data')

# Clear cache if needed
dumbo.clear_cache()
```

### Cache Integration
Dumbo integrates with Flask-TSK's Memory system for caching:
- **Cache Key**: Generated from URL, method, and parameters
- **Cache Duration**: 5 minutes for successful responses
- **Cache Invalidation**: Automatic on cache clear

## 🔄 Retry Mechanism

### Exponential Backoff
Dumbo uses exponential backoff for retries:

```python
# Retry sequence with exponential backoff
# Attempt 1: Immediate
# Attempt 2: Wait 2 seconds
# Attempt 3: Wait 4 seconds
# Attempt 4: Wait 8 seconds
# Attempt 5: Wait 16 seconds (capped at 30s max)
```

### Retry Configuration
```python
# Set custom retry count
dumbo.with_retries(5)

# Magic feather mode increases retries
dumbo.with_magic_feather(True)  # 5 retries
dumbo.with_magic_feather(False)  # 3 retries
```

## 🎨 Convenience Functions

### Quick Requests
```python
from elephants.py_ele.dumbo import get, post, download_file, ping_url

# Quick GET
response = get('https://api.example.com/data')

# Quick POST
response = post('https://api.example.com/submit', 
               data={'name': 'Dumbo'})

# Quick download
success = download_file('https://example.com/file.zip', 
                       'downloads/file.zip')

# Quick ping
ping_info = ping_url('https://api.example.com/health')
```

## 🔐 Security Features

### SSL/TLS Handling
```python
# SSL verification is disabled by default for load balancer compatibility
# This can be overridden in the session configuration
```

### Header Security
```python
# Set secure headers
dumbo.with_headers({
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-Token': 'your-csrf-token'
})
```

## 📊 Performance Monitoring

### Response Timing
```python
response = dumbo.get('https://api.example.com/data')
print(f"Flight time: {response.elapsed_time:.3f} seconds")
```

### Batch Performance
```python
import time

start_time = time.time()
results = dumbo.fly_formation(requests_list)
total_time = time.time() - start_time

print(f"Formation flight completed in {total_time:.2f}s")
print(f"Average time per request: {total_time/len(requests_list):.2f}s")
```

## 🐛 Debugging and Logging

### Logging Configuration
```python
import logging

# Configure Dumbo's logger
logging.getLogger('dumbo').setLevel(logging.DEBUG)

# Now you'll see detailed flight information
response = dumbo.get('https://api.example.com/data')
```

### Error Information
```python
try:
    response = dumbo.get('https://api.example.com/data')
except Exception as e:
    print(f"Error type: {type(e).__name__}")
    print(f"Error message: {str(e)}")
    # Dumbo logs detailed information automatically
```

## 🔮 Advanced Usage

### Custom Session Configuration
```python
# Create Dumbo with custom settings
dumbo = Dumbo(
    timeout=60,
    retries=5,
    magic_feather=True
)

# Configure session
dumbo.session.verify = True  # Enable SSL verification
dumbo.session.max_redirects = 5
```

### Request Interceptors
```python
# You can extend Dumbo's session for custom behavior
def custom_request_prep(request):
    request.headers['X-Custom-Header'] = 'Dumbo-Flight'
    return request

# Apply to session (advanced usage)
# dumbo.session.hooks['request'].append(custom_request_prep)
```

## 🎯 Best Practices

### Performance
1. **Use Formation Flying**: Group related requests for parallel execution
2. **Enable Caching**: Let Dumbo remember successful flights
3. **Set Appropriate Timeouts**: Balance speed vs reliability
4. **Use Magic Feather**: Enable for important requests

### Error Handling
1. **Always Check Status Codes**: Don't assume success
2. **Handle Exceptions**: Wrap requests in try-catch blocks
3. **Use Retries**: Let Dumbo handle temporary failures
4. **Log Errors**: Monitor for patterns in failures

### Security
1. **Validate URLs**: Ensure destinations are safe
2. **Use HTTPS**: Prefer secure connections
3. **Sanitize Input**: Clean data before sending
4. **Monitor Headers**: Be careful with sensitive information

## 🔮 Future Enhancements

### Planned Features
- **Request/Response Interceptors**: Custom middleware support
- **Rate Limiting**: Automatic rate limit handling
- **Circuit Breaker**: Prevent cascade failures
- **Metrics Collection**: Detailed performance metrics
- **WebSocket Support**: Real-time communication
- **GraphQL Support**: Native GraphQL client capabilities

### Integration Opportunities
- **Load Balancers**: Automatic health checking
- **API Gateways**: Seamless integration
- **Monitoring Systems**: Prometheus, Datadog integration
- **Testing Frameworks**: Mock server support

## 📖 Conclusion

Dumbo brings the same grace and reliability that the flying elephant brought to the circus. With its simple API, automatic retries, parallel processing, and intelligent caching, Dumbo makes HTTP requests as effortless as flying through the air.

Whether you're making simple API calls or orchestrating complex microservice communications, Dumbo provides the tools you need to soar across the web with confidence and style.

*"The very things that held you down are gonna carry you up!"* 