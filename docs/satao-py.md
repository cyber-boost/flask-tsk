# Satao - The Security Guardian (Python)

## 🐘 Backstory

Satao was one of Kenya's last great "tuskers" - elephants whose tusks were so large they touched the ground. He lived in Tsavo East National Park and was known for his incredible intelligence, often hiding his massive tusks behind bushes when humans approached, aware that they made him a target. Despite constant protection efforts, poachers killed him in 2014 for his ivory.

Like Satao who could sense danger from miles away, this security system detects threats before they strike, protecting your application's "ivory" - your precious data, user information, and system integrity.

## Overview

Satao is a comprehensive security guardian for Flask applications that provides real-time threat detection, intrusion prevention, and automated security responses. It operates as a Flask extension that monitors all incoming requests and protects against various attack vectors.

## Features

- **Real-time threat detection and monitoring**
- **Intrusion prevention system (IPS)**
- **DDoS attack mitigation**
- **SQL injection and XSS prevention**
- **Brute force attack protection**
- **Security audit logging**
- **Automated threat response**
- **Emergency lockdown capabilities**
- **Trusted IP management**
- **Rate limiting integration**

## Installation

```bash
# Install required dependencies
pip install flask redis sqlite3

# Or add to requirements.txt
flask>=2.0.0
redis>=4.0.0
```

## Basic Usage

### 1. Initialize Satao with Flask App

```python
from flask import Flask
from elephants.satao import Satao

app = Flask(__name__)

# Initialize Satao
satao = Satao(app)

# Or use the factory pattern
def create_app():
    app = Flask(__name__)
    satao = Satao(app)
    return app
```

### 2. Configuration

```python
# In your Flask config
app.config.update({
    'SATAO_ALERT_THRESHOLD': 5,
    'SATAO_EMERGENCY_MODE': False,
    'SATAO_DB_PATH': 'satao_security.db',
    'SATAO_LOG_FILE': 'logs/satao_security.log',
    'SATAO_PEANUTS_FILE': '.peanuts'
})
```

### 3. Using Satao in Routes

```python
@app.route('/admin')
def admin_panel():
    # Satao automatically monitors this request
    # If threats are detected, access will be blocked
    
    # You can also manually check security
    audit = app.satao.audit()
    if audit['threat_level'] == 'critical':
        return "System under attack!", 503
    
    return "Admin panel"
```

## Advanced Usage

### Manual Threat Detection

```python
@app.route('/api/data')
def get_data():
    # Manual security scan
    security_check = app.satao.scan()
    Satao.handle_threat(security_check)
    
    return {"data": "secure_data"}
```

### Adding Trusted IPs

```python
# Add trusted IP addresses or networks
app.satao.add_trusted_ips([
    '192.168.1.100',
    '10.0.0.0/8',
    '172.16.0.0/12'
])
```

### Security Audit

```python
@app.route('/security/audit')
def security_audit():
    audit = app.satao.audit()
    intelligence = app.satao.get_threat_intelligence()
    
    return {
        'audit': audit,
        'intelligence': intelligence
    }
```

### Emergency Lockdown

```python
@app.route('/security/emergency')
def trigger_emergency():
    app.satao.emergency_lockdown("Manual emergency activation")
    return "Emergency lockdown activated"

@app.route('/security/reset')
def reset_emergency():
    app.satao.reset_emergency_mode()
    return "Emergency mode deactivated"
```

## Threat Detection

### SQL Injection Detection

Satao monitors all input data for common SQL injection patterns:

```python
# These would trigger SQL injection detection:
# "'; DROP TABLE users; --"
# "OR 1=1"
# "UNION SELECT * FROM users"
```

### XSS Detection

Satao detects cross-site scripting attempts:

```python
# These would trigger XSS detection:
# "<script>alert('xss')</script>"
# "javascript:alert('xss')"
# "<img src=x onerror=alert('xss')>"
```

### Brute Force Detection

Satao tracks login attempts and blocks IPs with excessive failures:

```python
# After 5 failed login attempts in 5 minutes:
# IP gets temporarily blocked for increasing durations
```

### DDoS Detection

Satao monitors request rates and detects potential DDoS attacks:

```python
# More than 50 requests in 10 seconds triggers DDoS detection
# Rate limiting is automatically applied
```

## Configuration Options

### Flask Configuration

| Option | Default | Description |
|--------|---------|-------------|
| `SATAO_ALERT_THRESHOLD` | 5 | Number of threats before alert |
| `SATAO_EMERGENCY_MODE` | False | Start in emergency mode |
| `SATAO_DB_PATH` | 'satao_security.db' | SQLite database path |
| `SATAO_LOG_FILE` | 'logs/satao_security.log' | Log file path |
| `SATAO_PEANUTS_FILE` | '.peanuts' | Configuration file |

### .peanuts Configuration

```json
{
  "security": {
    "alert_threshold": 5,
    "emergency_mode": false,
    "trusted_ips": [
      "192.168.1.100",
      "10.0.0.0/8"
    ],
    "block_duration": 86400,
    "rate_limit": {
      "requests_per_minute": 60,
      "burst_limit": 100
    }
  }
}
```

## Database Schema

Satao uses SQLite to store security events and blocked IPs:

### blocked_ips Table
```sql
CREATE TABLE blocked_ips (
    ip TEXT PRIMARY KEY,
    time REAL,
    reason TEXT,
    attempts INTEGER,
    expires REAL
);
```

### security_events Table
```sql
CREATE TABLE security_events (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type TEXT,
    ip TEXT,
    reason TEXT,
    user_agent TEXT,
    uri TEXT,
    time REAL,
    threat_level TEXT,
    details TEXT
);
```

### security_alerts Table
```sql
CREATE TABLE security_alerts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    level TEXT,
    reason TEXT,
    ip TEXT,
    created_at TEXT
);
```

## Integration with Flask-TSK

### 1. Register with Flask-TSK

```python
# In your Flask-TSK app initialization
from flask_tsk import FlaskTSK
from elephants.satao import Satao

app = FlaskTSK(__name__)

# Register Satao
satao = Satao(app)
app.register_elephant('satao', satao)
```

### 2. Use with TuskLang Commands

```tusk
# In your .tsk files
security {
    monitor = true
    alert_threshold = 5
    emergency_mode = false
}

# Satao will automatically load these settings
```

### 3. CLI Integration

```bash
# Check security status
tsk security audit

# View blocked IPs
tsk security blocked

# Reset emergency mode
tsk security reset

# View threat intelligence
tsk security intelligence
```

## API Reference

### Core Methods

#### `Satao(app=None)`
Initialize Satao with optional Flask app.

#### `init_app(app)`
Initialize Satao with Flask app (factory pattern).

#### `monitor_request()`
Monitor incoming request for threats (called automatically).

#### `audit()`
Get security audit information.

#### `emergency_lockdown(reason)`
Activate emergency lockdown mode.

#### `reset_emergency_mode()`
Deactivate emergency mode.

### Threat Detection Methods

#### `detect_sql_injection()`
Detect SQL injection attempts.

#### `detect_xss()`
Detect XSS attempts.

#### `detect_brute_force()`
Detect brute force attacks.

#### `detect_ddos()`
Detect DDoS attacks.

#### `detect_malicious_uploads()`
Detect malicious file uploads.

#### `detect_anomalies()`
Detect suspicious activity.

### IP Management Methods

#### `block_attacker(ip, reason)`
Block an IP address.

#### `is_ip_blocked(ip)`
Check if IP is blocked.

#### `is_trusted(ip)`
Check if IP is trusted.

#### `add_trusted_ips(ips)`
Add trusted IP addresses.

#### `cleanup_expired_blocks()`
Remove expired IP blocks.

### Intelligence Methods

#### `get_threat_intelligence()`
Get comprehensive threat intelligence.

#### `get_known_attackers()`
Get list of known attackers.

#### `get_attack_patterns()`
Get known attack patterns.

#### `get_known_vulnerabilities()`
Get system vulnerabilities.

#### `get_security_recommendations()`
Get security recommendations.

## Logging

Satao provides comprehensive logging:

```python
# Security events are logged to the configured log file
# Log levels: INFO, WARNING, ERROR, CRITICAL

# Example log entries:
# 2024-01-15 10:30:45 - satao - INFO - Security event: sql_injection from 192.168.1.100
# 2024-01-15 10:31:00 - satao - CRITICAL - EMERGENCY LOCKDOWN ACTIVATED: Multiple threats
```

## Performance Considerations

- **Memory Usage**: Satao keeps recent threats and rate limits in memory for fast access
- **Database**: SQLite database for persistent storage of events and blocked IPs
- **CPU**: Pattern matching is optimized with compiled regex patterns
- **Network**: Minimal overhead, only logs and blocks when threats are detected

## Security Best Practices

1. **Regular Audits**: Run security audits regularly
2. **Monitor Logs**: Check security logs for unusual activity
3. **Update Patterns**: Keep threat patterns updated
4. **Backup Data**: Regularly backup security database
5. **Test Responses**: Test emergency procedures
6. **Review Blocks**: Regularly review and clean blocked IPs

## Troubleshooting

### Common Issues

1. **False Positives**: Adjust patterns or add trusted IPs
2. **Performance Issues**: Increase rate limits or optimize patterns
3. **Database Errors**: Check file permissions and disk space
4. **Emergency Mode Stuck**: Use `reset_emergency_mode()`

### Debug Mode

```python
# Enable debug logging
app.config['SATAO_DEBUG'] = True

# Check threat detection in real-time
@app.before_request
def debug_satao():
    if app.config.get('SATAO_DEBUG'):
        print(f"Satao monitoring: {request.method} {request.path}")
```

## Examples

### Complete Flask App with Satao

```python
from flask import Flask, request, jsonify
from elephants.satao import Satao

app = Flask(__name__)

# Configure Satao
app.config.update({
    'SATAO_ALERT_THRESHOLD': 3,
    'SATAO_DB_PATH': 'security.db',
    'SATAO_LOG_FILE': 'logs/security.log'
})

# Initialize Satao
satao = Satao(app)

# Add trusted IPs
satao.add_trusted_ips(['127.0.0.1', '192.168.1.0/24'])

@app.route('/')
def home():
    return "Welcome to the secure application!"

@app.route('/admin')
def admin():
    # Satao automatically protects this endpoint
    return "Admin panel"

@app.route('/api/data')
def api_data():
    # Manual security check
    security_check = satao.scan()
    Satao.handle_threat(security_check)
    
    return jsonify({"data": "secure"})

@app.route('/security/status')
def security_status():
    return jsonify(satao.audit())

if __name__ == '__main__':
    app.run(debug=False)  # Always disable debug in production
```

### Integration with Flask-TSK

```python
from flask_tsk import FlaskTSK
from elephants.satao import Satao

def create_app():
    app = FlaskTSK(__name__)
    
    # Load TuskLang configuration
    app.load_config('.peanuts')
    
    # Initialize Satao
    satao = Satao(app)
    app.register_elephant('satao', satao)
    
    return app

app = create_app()
```

## Conclusion

Satao provides comprehensive security protection for Flask applications, operating like the legendary elephant who protected his herd. With real-time threat detection, automated responses, and comprehensive logging, Satao helps ensure your application's security and integrity.

Remember: "In memory of Satao - may his wisdom protect what cannot be replaced." 