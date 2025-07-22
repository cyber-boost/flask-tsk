# Jumbo - The Massive File Handler (Python Edition)

## Overview

Jumbo is the Python conversion of the original PHP elephant that handles massive file uploads and processing. Named after the famous African elephant who redefined what "large" meant, Jumbo handles files of extraordinary size that would make regular uploaders tremble.

## Features

- **Chunked File Uploads**: No timeout issues with massive files
- **Resume Interrupted Uploads**: Never lose progress on large uploads
- **Progress Tracking**: Real-time progress for massive files
- **Multi-part Upload Support**: Handle files larger than memory limits
- **Automatic Chunk Verification**: SHA256 integrity checking
- **CSV Stream Processing**: Process huge datasets without loading into memory
- **Background Processing**: Non-blocking upload handling

## How It Works

### Core Architecture

Jumbo uses a chunk-based upload system where large files are split into manageable pieces (default 5MB chunks). Each chunk is:

1. **Validated**: SHA256 hash verification
2. **Stored**: Temporarily saved to disk
3. **Tracked**: Progress monitored in memory
4. **Assembled**: Merged into final file when complete

### Key Components

#### UploadSession
```python
@dataclass
class UploadSession:
    id: str
    filename: str
    total_size: int
    chunks_expected: int
    chunks_received: int
    started_at: int
    status: str
    metadata: Dict
```

#### UploadChunk
```python
@dataclass
class UploadChunk:
    upload_id: str
    chunk_number: int
    chunk_data: bytes
    hash: str
    created_at: int
```

### Upload Process

1. **Start Upload**: Client calls `start_upload()` with file info
2. **Receive Chunks**: Client uploads chunks sequentially
3. **Verify Integrity**: Each chunk is hash-verified
4. **Track Progress**: Real-time progress updates
5. **Assemble File**: Merge chunks when complete
6. **Cleanup**: Remove temporary chunks

## Flask-TSK Integration

### Initialization

```python
from flask import Flask
from elephants.py_ele.jumbo import init_jumbo

app = Flask(__name__)
jumbo = init_jumbo(app)
```

### Usage in Routes

```python
from elephants.py_ele.jumbo import get_jumbo

@app.route('/upload/start', methods=['POST'])
def start_upload():
    jumbo = get_jumbo()
    
    data = request.get_json()
    result = jumbo.start_upload(
        filename=data['filename'],
        total_size=data['size'],
        metadata=data.get('metadata', {})
    )
    
    return jsonify(result)

@app.route('/upload/chunk', methods=['POST'])
def upload_chunk():
    jumbo = get_jumbo()
    
    upload_id = request.form['upload_id']
    chunk_number = int(request.form['chunk_number'])
    chunk_data = request.files['chunk'].read()
    
    result = jumbo.upload_chunk(upload_id, chunk_number, chunk_data)
    return jsonify(result)

@app.route('/upload/status/<upload_id>')
def get_upload_status(upload_id):
    jumbo = get_jumbo()
    status = jumbo.get_status(upload_id)
    return jsonify(status)
```

### Configuration

```python
# In your Flask app config
JUMBO_CONFIG = {
    'upload_path': '/var/www/uploads/jumbo/',
    'max_file_size': 5 * 1024 * 1024 * 1024,  # 5GB
    'chunk_size': 5 * 1024 * 1024  # 5MB chunks
}

# Initialize with custom config
jumbo = Jumbo(**JUMBO_CONFIG)
```

## API Reference

### Core Methods

#### `start_upload(filename, total_size, metadata=None)`
Start a new upload session.

**Parameters:**
- `filename`: Name of the file
- `total_size`: Total file size in bytes
- `metadata`: Optional metadata dictionary

**Returns:**
```python
{
    'upload_id': 'jumbo_abc123...',
    'chunk_size': 5242880,
    'total_chunks': 100
}
```

#### `upload_chunk(upload_id, chunk_number, chunk_data)`
Upload a single chunk.

**Parameters:**
- `upload_id`: Upload session ID
- `chunk_number`: Sequential chunk number (0-based)
- `chunk_data`: Binary chunk data

**Returns:**
```python
{
    'status': 'uploading',
    'progress': 45.2
}
# or when complete:
{
    'status': 'completed',
    'path': '/uploads/jumbo/completed/file.zip',
    'size': 524288000,
    'duration': 120
}
```

#### `resume_upload(upload_id)`
Resume an interrupted upload.

**Returns:**
```python
{
    'upload_id': 'jumbo_abc123...',
    'chunks_received': [0, 1, 2, 5, 6],
    'chunks_needed': [3, 4, 7, 8, 9],
    'progress': 50.0
}
```

#### `get_status(upload_id)`
Get upload status and progress.

**Returns:**
```python
{
    'status': 'uploading',
    'progress': 75.5,
    'size_uploaded': 393216000,
    'time_remaining': '2 minutes'
}
```

#### `cancel_upload(upload_id)`
Cancel an active upload.

#### `verify_chunk(upload_id, chunk_number, expected_hash=None)`
Verify chunk integrity.

### Utility Methods

#### `stream_csv(filepath, callback, chunk_size=1000)`
Process large CSV files in chunks.

```python
def process_chunk(chunk, row_count):
    # Process chunk of rows
    for row in chunk:
        # Do something with each row
        pass

jumbo.stream_csv('large_file.csv', process_chunk, 1000)
```

#### `get_statistics()`
Get upload statistics.

**Returns:**
```python
{
    'active_uploads': 3,
    'total_active_size': 1572864000,
    'average_speed': 1048576,
    'uploads_today': 5,
    'uploads_this_week': 25
}
```

## Client-Side Integration

### JavaScript Upload Client

```javascript
class JumboUploader {
    constructor(uploadId, chunkSize, totalChunks) {
        this.uploadId = uploadId;
        this.chunkSize = chunkSize;
        this.totalChunks = totalChunks;
        this.currentChunk = 0;
    }
    
    async uploadFile(file) {
        // Start upload
        const startResponse = await fetch('/upload/start', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                filename: file.name,
                size: file.size,
                metadata: {type: file.type}
            })
        });
        
        const {upload_id, chunk_size, total_chunks} = await startResponse.json();
        
        // Upload chunks
        for (let i = 0; i < total_chunks; i++) {
            const start = i * chunk_size;
            const end = Math.min(start + chunk_size, file.size);
            const chunk = file.slice(start, end);
            
            const formData = new FormData();
            formData.append('upload_id', upload_id);
            formData.append('chunk_number', i);
            formData.append('chunk', chunk);
            
            const response = await fetch('/upload/chunk', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.status === 'completed') {
                console.log('Upload complete!', result.path);
                break;
            }
            
            // Update progress
            this.updateProgress(result.progress);
        }
    }
    
    updateProgress(progress) {
        // Update UI progress bar
        document.getElementById('progress').style.width = progress + '%';
    }
}
```

## Error Handling

Jumbo includes comprehensive error handling:

```python
try:
    result = jumbo.upload_chunk(upload_id, chunk_number, chunk_data)
except ValueError as e:
    # Handle validation errors
    return jsonify({'error': str(e)}), 400
except RuntimeError as e:
    # Handle system errors
    return jsonify({'error': str(e)}), 500
```

## Performance Considerations

### Memory Management
- Chunks are streamed to disk, not held in memory
- Large files don't impact PHP memory limits
- Background processing prevents blocking

### Disk Space
- Temporary chunks are cleaned up automatically
- Configurable retention policies
- Abandoned uploads moved to recovery directory

### Network Optimization
- Configurable chunk sizes (default 5MB)
- Resume capability for network interruptions
- Progress tracking for user feedback

## Security Features

- **Hash Verification**: SHA256 integrity checking
- **File Type Validation**: MIME type verification
- **Size Limits**: Configurable maximum file sizes
- **Path Sanitization**: Secure file path handling
- **Access Control**: Integration with Flask-TSK permissions

## Monitoring and Logging

Jumbo provides comprehensive monitoring:

```python
# Get system statistics
stats = jumbo.get_statistics()

# Monitor active uploads
for upload_id, upload in jumbo.active_uploads.items():
    print(f"Upload {upload_id}: {upload.chunks_received}/{upload.chunks_expected} chunks")
```

## Integration with Other Elephants

Jumbo works seamlessly with other Flask-TSK elephants:

- **Babar**: Store uploaded files in CMS
- **Kaavan**: Monitor upload system health
- **Koshik**: Audio notifications for upload completion

## Example Use Cases

### Large Video Uploads
```python
# Handle 4K video uploads
video_upload = jumbo.start_upload('movie_4k.mp4', 2147483648)  # 2GB
```

### CSV Data Processing
```python
# Process massive datasets
def process_user_data(chunk, row_count):
    for user in chunk:
        # Process user data
        db.insert_user(user)

jumbo.stream_csv('users_1m.csv', process_user_data, 1000)
```

### Backup File Uploads
```python
# Handle database backups
backup_upload = jumbo.start_upload('db_backup.sql', 1073741824)  # 1GB
```

## Troubleshooting

### Common Issues

1. **Chunk Verification Failed**
   - Check network stability
   - Verify chunk size configuration
   - Review server disk space

2. **Upload Stuck**
   - Check for abandoned uploads
   - Verify memory availability
   - Review error logs

3. **Performance Issues**
   - Adjust chunk size
   - Monitor disk I/O
   - Check network bandwidth

### Debug Mode

Enable debug logging:

```python
import logging
logging.getLogger('jumbo').setLevel(logging.DEBUG)
```

## Future Enhancements

- S3/Cloud storage integration
- Parallel chunk processing
- Advanced compression options
- Real-time progress WebSocket updates
- Multi-file upload support
- Advanced retry mechanisms

---

*"The bigger they are, the better Jumbo handles them!"* - Jumbo's motto for handling massive files with elephant-sized reliability. 