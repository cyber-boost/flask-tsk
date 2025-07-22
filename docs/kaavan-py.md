# Kaavan - The Lone Wolf Monitor & Backup Guardian (Python Edition)

## Overview

Kaavan is the Python conversion of the original PHP elephant that provides continuous system monitoring and automated backup capabilities. Named after "The World's Loneliest Elephant" who stood alone for years watching and waiting, Kaavan works in isolation to constantly monitor your application's health and ensure your data is never truly alone when disaster strikes.

## Features

- **Continuous Monitoring**: Real-time system health checks
- **File System Monitoring**: Track changes and detect corruption
- **Cron Job Health Checks**: Monitor scheduled tasks
- **Database Health Verification**: Ensure database connectivity and integrity
- **Disk Space Monitoring**: Prevent storage issues
- **Error Log Analysis**: Detect and alert on system errors
- **Automated Backup System**: Local, S3, and remote backup support
- **Self-Healing Capabilities**: Attempt automatic recovery
- **Alert System**: Email and notification alerts
- **Health Scoring**: Comprehensive system health metrics

## How It Works

### Core Architecture

Kaavan operates as a background monitoring service that continuously watches your system and provides automated backup capabilities. It uses a multi-threaded approach to handle monitoring and backup tasks independently.

### Key Components

#### SystemHealth
```python
@dataclass
class SystemHealth:
    timestamp: int
    files_status: Dict
    database_status: Dict
    cron_status: Dict
    errors_status: Dict
    backups_status: Dict
    overall_score: float
```

#### MonitoringAlert
```python
@dataclass
class MonitoringAlert:
    id: str
    type: str
    severity: str
    message: str
    timestamp: int
    resolved: bool = False
    resolved_at: Optional[int] = None
    metadata: Dict = None
```

#### BackupConfig
```python
@dataclass
class BackupConfig:
    destination: str = "/backups"
    s3_bucket: Optional[str] = None
    retention_days: int = 30
    schedule: str = "daily"
    compression: bool = True
    encryption: bool = False
    verify_backups: bool = True
```

### Monitoring Process

1. **File System Scan**: Check critical files for changes/corruption
2. **Cron Job Verification**: Ensure scheduled tasks are running
3. **Database Health Check**: Verify connectivity and table integrity
4. **Disk Space Analysis**: Monitor storage usage
5. **Error Log Review**: Analyze recent error patterns
6. **Backup Status Check**: Verify backup system health
7. **Health Score Calculation**: Generate overall system health
8. **Alert Generation**: Send notifications for issues

## Flask-TSK Integration

### Initialization

```python
from flask import Flask
from elephants.py_ele.kaavan import init_kaavan

app = Flask(__name__)
kaavan = init_kaavan(app)
```

### Usage in Routes

```python
from elephants.py_ele.kaavan import get_kaavan

@app.route('/system/health')
def get_system_health():
    kaavan = get_kaavan()
    health = kaavan.analyze()
    return jsonify(health)

@app.route('/system/monitor')
def start_monitoring():
    kaavan = get_kaavan()
    results = kaavan.watch()
    return jsonify(results)

@app.route('/backup/start', methods=['POST'])
def start_backup():
    kaavan = get_kaavan()
    backup_type = request.json.get('type', 'full')
    result = kaavan.backup(backup_type)
    return jsonify(result)

@app.route('/alerts')
def get_alerts():
    kaavan = get_kaavan()
    alerts = kaavan.get_alerts(active_only=True)
    return jsonify(alerts)
```

### Configuration

```python
# In your Flask app config
KAAVAN_CONFIG = {
    'destination': '/var/backups',
    's3_bucket': 'my-backup-bucket',
    'retention_days': 30,
    'schedule': 'daily',
    'compression': True,
    'encryption': False,
    'verify_backups': True
}

# Initialize with custom config
kaavan = Kaavan(KAAVAN_CONFIG)
```

## API Reference

### Core Methods

#### `watch()`
Perform a complete system monitoring check.

**Returns:**
```python
{
    'timestamp': 1640995200,
    'files': {
        'status': 'healthy',
        'files_checked': 4,
        'files_modified': 0,
        'files_missing': 0,
        'files_corrupted': 0,
        'issues': []
    },
    'cron': {
        'status': 'healthy',
        'jobs_checked': 3,
        'jobs_failed': 0,
        'jobs_missing': 0,
        'issues': []
    },
    'database': {
        'status': 'healthy',
        'connection': True,
        'tables_checked': 4,
        'tables_corrupted': 0,
        'issues': []
    },
    'disk_space': {
        'status': 'healthy',
        'total_space': 107374182400,
        'used_space': 53687091200,
        'free_space': 53687091200,
        'usage_percent': 50.0,
        'issues': []
    },
    'error_logs': {
        'status': 'healthy',
        'logs_checked': 4,
        'errors_found': 0,
        'critical_errors': 0,
        'issues': []
    },
    'backups': {
        'status': 'healthy',
        'last_backup': 'backup_20241201_120000.tar.gz',
        'backup_age_hours': 12.5,
        'backups_available': 5,
        'issues': []
    },
    'health_score': 0.95
}
```

#### `backup(backup_type='full')`
Perform system backup.

**Parameters:**
- `backup_type`: 'full', 'incremental', 'database', or 'intelligent'

**Returns:**
```python
{
    'status': 'success',
    'backup_path': '/backups/full_backup_20241201_120000.tar.gz',
    'size': 1073741824,
    'timestamp': '20241201_120000'
}
```

#### `analyze()`
Generate comprehensive health analysis.

**Returns:**
```python
{
    'timestamp': 1640995200,
    'overall_health': 'healthy',
    'components': {
        'files': {...},
        'database': {...},
        'cron': {...},
        'errors': {...},
        'backups': {...}
    },
    'recommendations': [
        'Consider increasing backup frequency',
        'Monitor disk space usage'
    ],
    'alerts': []
}
```

#### `send_alert(issue, severity='warning', metadata=None)`
Send monitoring alert.

**Parameters:**
- `issue`: Description of the issue
- `severity`: 'info', 'warning', 'error', or 'critical'
- `metadata`: Additional context data

#### `get_alerts(active_only=True)`
Get monitoring alerts.

**Returns:**
```python
[
    {
        'id': 'kaavan_alert_1640995200_1',
        'type': 'disk_space_warning',
        'severity': 'warning',
        'message': 'Disk space usage at 85%',
        'timestamp': 1640995200,
        'resolved': False,
        'metadata': {'usage_percent': 85.0}
    }
]
```

#### `resolve_alert(alert_id)`
Mark an alert as resolved.

#### `heal(issue)`
Attempt automatic recovery.

**Returns:**
```python
{
    'status': 'attempted',
    'issue': 'database_connection_failed',
    'actions_taken': ['restart_database_service'],
    'success': True
}
```

## Monitoring Components

### File System Monitoring

```python
# Check critical application files
critical_files = [
    '/var/www/html/index.php',
    '/var/www/html/config.php',
    '/var/log/nginx/error.log',
    '/etc/nginx/nginx.conf'
]

# Kaavan monitors:
# - File existence
# - File integrity (SHA256 hashes)
# - File modifications
# - File corruption
```

### Cron Job Monitoring

```python
# Kaavan checks:
# - Cron service status
# - Important job existence
# - Job execution history
# - Failed job detection

important_jobs = [
    'backup_daily',
    'log_rotation',
    'system_cleanup'
]
```

### Database Health Monitoring

```python
# Kaavan verifies:
# - Database connectivity
# - Table integrity
# - Query performance
# - Connection pool health

# Important tables checked:
important_tables = ['users', 'content', 'settings', 'logs']
```

### Disk Space Monitoring

```python
# Kaavan monitors:
# - Total disk space
# - Used space percentage
# - Available space
# - Growth trends

# Thresholds:
# - Warning: >80% usage
# - Critical: >90% usage
```

### Error Log Analysis

```python
# Kaavan analyzes:
# - Nginx error logs
# - Apache error logs
# - PHP error logs
# - System logs

# Metrics tracked:
# - Error frequency
# - Critical error count
# - Error patterns
# - Recent error trends
```

## Backup System

### Backup Types

#### Full Backup
```python
# Complete system backup
result = kaavan.backup('full')
# Creates: /backups/full_backup_20241201_120000.tar.gz
```

#### Database Backup
```python
# Database-only backup
result = kaavan.backup('database')
# Creates: /backups/database_backup_20241201_120000.sql
```

#### Incremental Backup
```python
# Incremental backup (future implementation)
result = kaavan.backup('incremental')
```

#### Intelligent Backup
```python
# Automatic backup type selection
result = kaavan.backup('intelligent')
# Chooses based on last backup time and system state
```

### Backup Configuration

```python
backup_config = {
    'destination': '/var/backups',
    's3_bucket': 'my-backup-bucket',
    'retention_days': 30,
    'schedule': 'daily',
    'compression': True,
    'encryption': False,
    'verify_backups': True
}
```

### S3 Integration

```python
# Configure S3 backup destination
import boto3

s3_client = boto3.client('s3')
# Kaavan will automatically upload backups to S3
```

## Alert System

### Alert Severities

- **Info**: Informational messages
- **Warning**: Potential issues
- **Error**: Active problems
- **Critical**: System-threatening issues

### Email Alerts

```python
# Configure email alerts
EMAIL_CONFIG = {
    'smtp_server': 'smtp.gmail.com',
    'smtp_port': 587,
    'username': 'alerts@myapp.com',
    'password': 'secure_password',
    'recipients': ['admin@myapp.com']
}
```

### Alert Management

```python
# Get active alerts
alerts = kaavan.get_alerts(active_only=True)

# Resolve an alert
kaavan.resolve_alert('alert_id_123')

# Clear all alerts
for alert in alerts:
    kaavan.resolve_alert(alert['id'])
```

## Health Scoring

Kaavan calculates an overall health score (0.0 to 1.0) based on:

- File system health (20%)
- Database health (20%)
- Cron job health (15%)
- Disk space health (15%)
- Error log health (15%)
- Backup health (15%)

### Health Score Interpretation

- **0.9-1.0**: Excellent health
- **0.8-0.9**: Good health
- **0.7-0.8**: Fair health
- **0.6-0.7**: Poor health
- **<0.6**: Critical health

## Integration with Other Elephants

Kaavan works seamlessly with other Flask-TSK elephants:

- **Jumbo**: Monitor upload system health
- **Babar**: Backup CMS content and files
- **Koshik**: Send audio alerts for critical issues

## Example Use Cases

### Production Monitoring

```python
# Continuous production monitoring
@app.route('/monitor/start')
def start_production_monitoring():
    kaavan = get_kaavan()
    
    # Start background monitoring
    def monitor_worker():
        while True:
            results = kaavan.watch()
            if results['health_score'] < 0.8:
                kaavan.send_alert("System health degraded", "warning", results)
            time.sleep(300)  # Check every 5 minutes
    
    thread = threading.Thread(target=monitor_worker, daemon=True)
    thread.start()
    
    return jsonify({"status": "monitoring_started"})
```

### Automated Backup Schedule

```python
# Schedule daily backups
import schedule

def daily_backup():
    kaavan = get_kaavan()
    result = kaavan.backup('full')
    if result['status'] == 'success':
        kaavan.send_alert("Daily backup completed successfully", "info", result)
    else:
        kaavan.send_alert("Daily backup failed", "error", result)

schedule.every().day.at("02:00").do(daily_backup)
```

### Disaster Recovery

```python
# Automated disaster recovery
@app.route('/recovery/attempt')
def attempt_recovery():
    kaavan = get_kaavan()
    
    # Check system health
    health = kaavan.analyze()
    
    if health['overall_health'] == 'critical':
        # Attempt recovery
        recovery_result = kaavan.heal('system_critical')
        
        if recovery_result['success']:
            kaavan.send_alert("System recovery successful", "info", recovery_result)
        else:
            kaavan.send_alert("System recovery failed", "critical", recovery_result)
    
    return jsonify(health)
```

## Configuration Examples

### Development Environment

```python
DEV_CONFIG = {
    'destination': './backups',
    'retention_days': 7,
    'schedule': 'daily',
    'compression': True,
    'verify_backups': False
}
```

### Production Environment

```python
PROD_CONFIG = {
    'destination': '/var/backups',
    's3_bucket': 'prod-backups-2024',
    'retention_days': 90,
    'schedule': 'daily',
    'compression': True,
    'encryption': True,
    'verify_backups': True
}
```

## Troubleshooting

### Common Issues

1. **Monitoring Not Starting**
   - Check thread permissions
   - Verify configuration
   - Review error logs

2. **Backup Failures**
   - Check disk space
   - Verify file permissions
   - Review S3 credentials

3. **Alert Spam**
   - Adjust alert thresholds
   - Configure alert cooldowns
   - Review monitoring frequency

### Debug Mode

```python
import logging
logging.getLogger('kaavan').setLevel(logging.DEBUG)
```

## Performance Considerations

### Monitoring Frequency
- Default: Every 5 minutes
- Configurable based on system load
- Adaptive frequency based on health score

### Resource Usage
- Low memory footprint
- Minimal CPU usage
- Efficient file system scanning

### Scalability
- Thread-safe operations
- Configurable monitoring scope
- Support for multiple environments

## Security Features

- **Encrypted Backups**: Optional backup encryption
- **Secure Alerts**: Encrypted email notifications
- **Access Control**: Integration with Flask-TSK permissions
- **Audit Logging**: Complete monitoring audit trail

## Future Enhancements

- **Machine Learning**: Predictive failure detection
- **Advanced Recovery**: Automated system recovery
- **Cloud Integration**: Multi-cloud backup support
- **Real-time Dashboards**: Web-based monitoring interface
- **API Monitoring**: Application endpoint health checks
- **Performance Metrics**: Detailed performance analysis

---

*"We are all like Kaavan" - standing guard over what matters most.* - Kaavan's mission to ensure your system never stands alone when disaster strikes. 