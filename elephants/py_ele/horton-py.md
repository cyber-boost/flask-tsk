# Horton - The Faithful Job Queue Worker (Python Edition)

## Overview

Horton is the faithful job queue worker that never abandons a task, no matter how small. Like the elephant who protected the Whos on a speck of dust, Horton gives every job the same dedicated attention and never gives up until the job is done. "A person's a person, no matter how small!"

## Features

### Core Functionality
- **Persistent job queue processing** with database storage
- **Automatic retry with exponential backoff** for failed jobs
- **Job prioritization** (high, normal, low priority queues)
- **Failed job handling** with dead letter queue support
- **Distributed processing** with multiple workers
- **Real-time job status tracking** and monitoring
- **Job scheduling** and delayed execution
- **Worker registration** and management
- **Comprehensive job analytics** and statistics

### Technical Features
- **SQLite database** for persistent job storage
- **Thread-safe queue operations** with priority queues
- **Graceful shutdown** handling with signal management
- **Job result storage** and error tracking
- **Worker heartbeat** monitoring
- **Job cleanup** and maintenance operations
- **Memory integration** for temporary job storage

## Installation

### Dependencies
```bash
# Core dependencies (included with Python)
# - threading
# - queue
# - sqlite3
# - signal
# - uuid
# - time
# - json
```

### Optional Dependencies
```bash
# For enhanced features
pip install redis  # For Redis-based job storage
pip install celery  # For Celery integration
```

## Usage

### Basic Initialization
```python
from elephants.py_ele.horton import Horton

# Initialize Horton with default database
horton = Horton()

# Initialize with custom database path
horton = Horton(db_path="custom_horton.db")
```

### Job Dispatching
```python
# Dispatch a simple job
job_id = horton.dispatch("send_email", {
    'to': 'user@example.com',
    'subject': 'Welcome!',
    'body': 'Welcome to our platform!'
})

print(f"Job dispatched with ID: {job_id}")

# Dispatch with priority
job_id = horton.dispatch("process_payment", {
    'user_id': 123,
    'amount': 99.99
}, queue='high', priority=0)  # High priority

# Schedule job for later execution
job_id = horton.later(3600, "send_reminder", {
    'user_id': 456,
    'message': 'Don\'t forget your appointment!'
})
```

### Job Processing
```python
# Start processing jobs (blocking)
horton.process()

# Process specific queue
horton.process(queue_name='high')

# Process with custom worker ID
horton.process(worker_id='worker_001')
```

### Job Handlers Registration
```python
# Register job handlers
def send_email_handler(data):
    # Implementation for sending email
    print(f"Sending email to: {data['to']}")
    return {'status': 'sent', 'timestamp': time.time()}

def process_payment_handler(data):
    # Implementation for processing payment
    print(f"Processing payment for user: {data['user_id']}")
    return {'status': 'processed', 'amount': data['amount']}

# Register handlers with Horton
horton.register("send_email", send_email_handler)
horton.register("process_payment", process_payment_handler)
```

### Job Status and Management
```python
# Check job status
status = horton.status(job_id)
print(f"Job status: {status['status']}")

# Retry failed job
success = horton.retry(job_id)

# Cancel pending job
success = horton.cancel(job_id)

# Get pending jobs
pending = horton.pending()
print(f"Pending jobs: {len(pending)}")

# Get failed jobs
failed = horton.failed(limit=10)
print(f"Failed jobs: {len(failed)}")
```

### Statistics and Monitoring
```python
# Get Horton's statistics
stats = horton.stats()
print(f"Processed jobs: {stats['processed_jobs']}")
print(f"Failed jobs: {stats['failed_jobs']}")
print(f"Active workers: {stats['active_workers']}")
print(f"Queue sizes: {stats['queue_sizes']}")
```

## Flask-TSK Integration

### App Initialization
```python
from flask import Flask
from elephants.py_ele.horton import init_horton

app = Flask(__name__)

# Initialize Horton
horton = init_horton(app)
```

### Route Usage
```python
from flask import request, jsonify
from elephants.py_ele.horton import get_horton

@app.route('/api/jobs/dispatch', methods=['POST'])
def dispatch_job():
    horton = get_horton()
    
    if not horton:
        return jsonify({'error': 'Horton not initialized'}), 500
    
    data = request.get_json()
    job_name = data.get('name')
    job_data = data.get('data', {})
    queue = data.get('queue', 'normal')
    priority = data.get('priority', 0)
    
    job_id = horton.dispatch(job_name, job_data, queue, priority)
    
    return jsonify({
        'success': True,
        'job_id': job_id,
        'message': 'Job dispatched successfully'
    })

@app.route('/api/jobs/schedule', methods=['POST'])
def schedule_job():
    horton = get_horton()
    
    data = request.get_json()
    delay = data.get('delay', 0)  # seconds
    job_name = data.get('name')
    job_data = data.get('data', {})
    queue = data.get('queue', 'normal')
    
    job_id = horton.later(delay, job_name, job_data, queue)
    
    return jsonify({
        'success': True,
        'job_id': job_id,
        'scheduled_at': time.time() + delay
    })

@app.route('/api/jobs/<job_id>/status')
def get_job_status(job_id):
    horton = get_horton()
    
    status = horton.status(job_id)
    
    if not status:
        return jsonify({'error': 'Job not found'}), 404
    
    return jsonify(status)

@app.route('/api/jobs/<job_id>/retry', methods=['POST'])
def retry_job(job_id):
    horton = get_horton()
    
    success = horton.retry(job_id)
    
    return jsonify({
        'success': success,
        'job_id': job_id
    })

@app.route('/api/jobs/<job_id>/cancel', methods=['POST'])
def cancel_job(job_id):
    horton = get_horton()
    
    success = horton.cancel(job_id)
    
    return jsonify({
        'success': success,
        'job_id': job_id
    })

@app.route('/api/jobs/pending')
def get_pending_jobs():
    horton = get_horton()
    
    queue = request.args.get('queue')
    pending = horton.pending(queue)
    
    return jsonify({
        'pending_jobs': pending,
        'count': len(pending)
    })

@app.route('/api/jobs/failed')
def get_failed_jobs():
    horton = get_horton()
    
    limit = int(request.args.get('limit', 50))
    failed = horton.failed(limit)
    
    return jsonify({
        'failed_jobs': failed,
        'count': len(failed)
    })

@app.route('/api/jobs/stats')
def get_job_stats():
    horton = get_horton()
    
    stats = horton.stats()
    
    return jsonify(stats)

@app.route('/api/jobs/clear-completed', methods=['POST'])
def clear_completed_jobs():
    horton = get_horton()
    
    data = request.get_json()
    older_than = data.get('older_than', 3600)  # seconds
    
    cleared_count = horton.clear_completed(older_than)
    
    return jsonify({
        'success': True,
        'cleared_count': cleared_count
    })

@app.route('/api/jobs/flush', methods=['POST'])
def flush_jobs():
    horton = get_horton()
    
    data = request.get_json()
    queue = data.get('queue')  # optional
    
    flushed_count = horton.flush(queue)
    
    return jsonify({
        'success': True,
        'flushed_count': flushed_count
    })

# Worker management routes
@app.route('/api/workers/start', methods=['POST'])
def start_worker():
    horton = get_horton()
    
    data = request.get_json()
    queue = data.get('queue')
    worker_id = data.get('worker_id')
    
    # Start worker in background thread
    import threading
    
    def worker_thread():
        horton.process(queue, worker_id)
    
    thread = threading.Thread(target=worker_thread, daemon=True)
    thread.start()
    
    return jsonify({
        'success': True,
        'worker_id': worker_id,
        'queue': queue
    })

@app.route('/api/workers/stop', methods=['POST'])
def stop_workers():
    horton = get_horton()
    
    horton.stop()
    
    return jsonify({
        'success': True,
        'message': 'Workers stopped gracefully'
    })
```

## Job Handler Examples

### Email Handler
```python
def send_email_handler(data):
    """Handle email sending jobs"""
    try:
        # Extract email data
        to_email = data.get('to')
        subject = data.get('subject')
        body = data.get('body')
        
        # Send email (implementation depends on your email service)
        # send_email(to_email, subject, body)
        
        return {
            'status': 'sent',
            'to': to_email,
            'timestamp': time.time()
        }
    
    except Exception as e:
        raise Exception(f"Failed to send email: {str(e)}")
```

### Image Processing Handler
```python
def process_image_handler(data):
    """Handle image processing jobs"""
    try:
        image_path = data.get('image_path')
        operation = data.get('operation')
        
        # Process image based on operation
        if operation == 'resize':
            # Resize image
            pass
        elif operation == 'filter':
            # Apply filter
            pass
        
        return {
            'status': 'processed',
            'image_path': image_path,
            'operation': operation
        }
    
    except Exception as e:
        raise Exception(f"Failed to process image: {str(e)}")
```

### Data Backup Handler
```python
def backup_data_handler(data):
    """Handle data backup jobs"""
    try:
        source = data.get('source')
        destination = data.get('destination')
        
        # Perform backup
        # backup_data(source, destination)
        
        return {
            'status': 'backed_up',
            'source': source,
            'destination': destination,
            'timestamp': time.time()
        }
    
    except Exception as e:
        raise Exception(f"Failed to backup data: {str(e)}")
```

## Configuration

### Environment Variables
```bash
# Database configuration
HORTON_DB_PATH=horton.db

# Job processing configuration
HORTON_MAX_RETRIES=3
HORTON_RETRY_DELAY=60

# Worker configuration
HORTON_WORKER_TIMEOUT=300
HORTON_HEARTBEAT_INTERVAL=30
```

### Configuration File
```python
# config.py
HORTON_CONFIG = {
    'db_path': 'horton.db',
    'max_retries': 3,
    'retry_delay': 60,
    'worker_timeout': 300,
    'heartbeat_interval': 30,
    'cleanup_interval': 3600
}
```

## Job Priority System

### Priority Levels
```python
# High priority jobs (processed first)
job_id = horton.dispatch("critical_alert", data, queue='high', priority=0)

# Normal priority jobs
job_id = horton.dispatch("regular_task", data, queue='normal', priority=5)

# Low priority jobs (processed last)
job_id = horton.dispatch("maintenance_task", data, queue='low', priority=10)
```

### Queue Management
```python
# Check queue sizes
stats = horton.stats()
print(f"High priority queue: {stats['queue_sizes']['high']} jobs")
print(f"Normal priority queue: {stats['queue_sizes']['normal']} jobs")
print(f"Low priority queue: {stats['queue_sizes']['low']} jobs")

# Flush specific queue
horton.flush('low')  # Clear all low priority jobs
```

## Error Handling and Retry Logic

### Automatic Retry
```python
# Jobs are automatically retried on failure
def failing_handler(data):
    # This will fail and be retried
    raise Exception("Temporary failure")

horton.register("failing_job", failing_handler)

# Job will be retried up to max_retries times with exponential backoff
```

### Manual Retry
```python
# Manually retry a failed job
failed_jobs = horton.failed(limit=10)
for job in failed_jobs:
    if job['name'] == 'important_job':
        horton.retry(job['id'])
```

### Dead Letter Queue
```python
# Failed jobs after max retries are moved to dead letter queue
def handle_dead_letter_job(job):
    # Custom handling for permanently failed jobs
    print(f"Job {job['id']} permanently failed: {job['error']}")
    
    # Could send notification, log to external system, etc.
    send_alert(f"Job {job['name']} failed permanently")
```

## Worker Management

### Multiple Workers
```python
import threading

# Start multiple workers
def start_workers():
    workers = []
    
    # High priority worker
    high_worker = threading.Thread(
        target=lambda: horton.process('high', 'worker_high_001'),
        daemon=True
    )
    workers.append(high_worker)
    
    # Normal priority worker
    normal_worker = threading.Thread(
        target=lambda: horton.process('normal', 'worker_normal_001'),
        daemon=True
    )
    workers.append(normal_worker)
    
    # Start all workers
    for worker in workers:
        worker.start()
    
    return workers

workers = start_workers()
```

### Worker Health Monitoring
```python
def monitor_workers():
    """Monitor worker health and restart if needed"""
    while True:
        stats = horton.stats()
        
        if stats['active_workers'] == 0:
            print("No active workers, restarting...")
            start_workers()
        
        time.sleep(60)  # Check every minute

# Start monitoring in background
monitor_thread = threading.Thread(target=monitor_workers, daemon=True)
monitor_thread.start()
```

## Integration with Other Elephants

### Happy Integration
```python
# Dispatch image processing jobs to Happy
def process_image_with_happy(image_path, filter_name):
    job_id = horton.dispatch("happy_filter", {
        'image_path': image_path,
        'filter_name': filter_name,
        'user_id': 123
    })
    return job_id

# Happy job handler
def happy_filter_handler(data):
    from elephants.py_ele.happy import get_happy
    
    happy = get_happy()
    if not happy:
        raise Exception("Happy not available")
    
    result = happy.apply_filter(
        data['image_path'], 
        data['filter_name']
    )
    
    return {
        'success': result.success,
        'output_path': result.output_path
    }

horton.register("happy_filter", happy_filter_handler)
```

### Heffalump Integration
```python
# Dispatch search indexing jobs
def index_content_with_heffalump(content_id, content, metadata):
    job_id = horton.dispatch("heffalump_index", {
        'content_id': content_id,
        'content': content,
        'metadata': metadata
    })
    return job_id

# Heffalump job handler
def heffalump_index_handler(data):
    from elephants.py_ele.heffalump import get_heffalump
    
    heffalump = get_heffalump()
    if not heffalump:
        raise Exception("Heffalump not available")
    
    success = heffalump.index(
        data['content_id'],
        data['content'],
        data['metadata']
    )
    
    return {'success': success}

horton.register("heffalump_index", heffalump_index_handler)
```

### Babar Integration
```python
# Dispatch content publishing jobs
def publish_content_with_babar(content_id, publish_data):
    job_id = horton.dispatch("babar_publish", {
        'content_id': content_id,
        'publish_data': publish_data
    })
    return job_id

# Babar job handler
def babar_publish_handler(data):
    from elephants.py_ele.babar import get_babar
    
    babar = get_babar()
    if not babar:
        raise Exception("Babar not available")
    
    result = babar.publish(data['content_id'])
    
    return result

horton.register("babar_publish", babar_publish_handler)
```

## Performance Optimization

### Batch Processing
```python
def batch_process_jobs(job_list, batch_size=10):
    """Process multiple jobs in batches"""
    results = []
    
    for i in range(0, len(job_list), batch_size):
        batch = job_list[i:i + batch_size]
        
        # Dispatch batch jobs
        job_ids = []
        for job_data in batch:
            job_id = horton.dispatch(
                job_data['name'],
                job_data['data'],
                job_data.get('queue', 'normal')
            )
            job_ids.append(job_id)
        
        # Wait for batch completion
        for job_id in job_ids:
            while True:
                status = horton.status(job_id)
                if status['status'] in ['completed', 'failed']:
                    results.append(status)
                    break
                time.sleep(1)
    
    return results
```

### Queue Optimization
```python
def optimize_queue_processing():
    """Optimize queue processing based on load"""
    stats = horton.stats()
    
    # Adjust worker allocation based on queue sizes
    high_queue_size = stats['queue_sizes']['high']
    normal_queue_size = stats['queue_sizes']['normal']
    
    if high_queue_size > 10:
        # Start additional high priority workers
        start_high_priority_workers(2)
    
    if normal_queue_size > 50:
        # Start additional normal priority workers
        start_normal_priority_workers(3)
```

## Troubleshooting

### Common Issues

1. **Database Lock Errors**
   ```python
   # Use connection pooling or separate connections
   import sqlite3
   
   def get_db_connection():
       return sqlite3.connect('horton.db', timeout=20)
   ```

2. **Worker Thread Issues**
   ```python
   # Ensure proper thread cleanup
   def cleanup_workers():
       horton.stop()
       time.sleep(5)  # Wait for graceful shutdown
   ```

3. **Memory Issues with Large Jobs**
   ```python
   # Process large jobs in chunks
   def process_large_job(data):
       chunk_size = 1000
       items = data.get('items', [])
       
       for i in range(0, len(items), chunk_size):
           chunk = items[i:i + chunk_size]
           # Process chunk
           time.sleep(0.1)  # Prevent memory buildup
   ```

4. **Job Stuck in Processing**
   ```python
   # Check for stuck jobs
   def check_stuck_jobs():
       pending = horton.pending()
       current_time = time.time()
       
       for job in pending:
           if current_time - job['created_at'] > 3600:  # 1 hour
               print(f"Stuck job: {job['id']}")
               # Consider retry or cancellation
   ```

### Debug Mode
```python
import logging

# Enable debug logging
logging.basicConfig(level=logging.DEBUG)

# Debug job processing
def debug_job_processing():
    def debug_handler(data):
        print(f"Processing job with data: {data}")
        # Process job
        print("Job completed successfully")
        return {'status': 'success'}
    
    horton.register("debug_job", debug_handler)
    
    job_id = horton.dispatch("debug_job", {'test': 'data'})
    print(f"Debug job dispatched: {job_id}")
```

## Monitoring and Alerting

### Health Checks
```python
def health_check():
    """Perform health check on Horton"""
    try:
        stats = horton.stats()
        
        # Check if workers are active
        if stats['active_workers'] == 0:
            send_alert("No active Horton workers")
        
        # Check for high failure rate
        if stats['failed_jobs'] > stats['processed_jobs'] * 0.1:
            send_alert("High job failure rate detected")
        
        # Check queue sizes
        for queue, size in stats['queue_sizes'].items():
            if size > 100:
                send_alert(f"Large queue size: {queue} has {size} jobs")
        
        return True
    
    except Exception as e:
        send_alert(f"Horton health check failed: {e}")
        return False
```

### Metrics Collection
```python
def collect_metrics():
    """Collect Horton metrics for monitoring"""
    stats = horton.stats()
    
    metrics = {
        'horton_processed_jobs_total': stats['processed_jobs'],
        'horton_failed_jobs_total': stats['failed_jobs'],
        'horton_active_workers': stats['active_workers'],
        'horton_queue_size_high': stats['queue_sizes']['high'],
        'horton_queue_size_normal': stats['queue_sizes']['normal'],
        'horton_queue_size_low': stats['queue_sizes']['low'],
        'horton_uptime_seconds': stats['uptime']
    }
    
    return metrics
```

## Future Enhancements

- **Redis backend** for distributed job processing
- **Celery integration** for advanced task management
- **Job dependencies** and workflow support
- **Real-time job progress** tracking
- **Advanced scheduling** with cron-like expressions
- **Job result caching** and storage
- **Distributed worker** coordination
- **Job priority learning** based on usage patterns

## Contributing

To contribute to Horton's development:

1. Follow the faithful and reliable principles
2. Maintain the "never give up" attitude
3. Include comprehensive error handling
4. Add performance optimizations
5. Test with various job types and loads

## License

Horton is part of the TuskPHP ecosystem and follows the same licensing terms as the main project.

---

*"I meant what I said, and I said what I meant. An elephant's faithful, one hundred percent!"* 🐘💪 