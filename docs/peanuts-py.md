# Peanuts - The Configuration & Performance Elephant (Python Edition)

## 🥜 Overview

Peanuts is the Configuration and Performance Management component of Flask-TSK, inspired by the wise elephant who knows exactly how much food to eat and when to conserve energy. Just as elephants love peanuts and manage their energy efficiently, this system manages configuration "peanuts" and optimizes performance based on system conditions.

## 🎯 Features

### Core Configuration Management
- **Encrypted Configuration Files**: Support for .pnt, peanu.tsk, .peanuts, and .shell formats
- **Priority-Based Loading**: Automatic detection and loading of configuration files
- **Binary and Source Formats**: Both compiled binary and human-readable source formats
- **Environment Integration**: Seamless integration with system environment variables
- **Hierarchical Configuration**: Support for nested configuration sections

### Performance Management
- **Four Performance Modes**: Feast, Balanced, Diet, and Survival modes
- **Adaptive Optimization**: Automatic performance mode switching based on metrics
- **Real-Time Monitoring**: Continuous performance metric collection
- **Resource Management**: Dynamic resource allocation and limits
- **Elephant Service Coordination**: Manages all other elephant services

### Performance Modes
- **Feast Mode**: High performance, all features enabled (score ≥ 0.9)
- **Balanced Mode**: Standard operation (score 0.7-0.9)
- **Diet Mode**: Conservation mode, reduced features (score 0.4-0.7)
- **Survival Mode**: Emergency mode, minimal features only (score < 0.4)

### Performance Metrics
- **Response Times**: Track and analyze request response times
- **Memory Usage**: Monitor memory consumption patterns
- **Database Performance**: Track query execution times
- **Error Rates**: Monitor system error frequencies
- **Cache Efficiency**: Track cache hit/miss ratios

## 🚀 Installation & Setup

### 1. Basic Installation
```python
from elephants.py_ele.peanuts import Peanuts

# Initialize Peanuts
peanuts = Peanuts.get_instance()
```

### 2. Flask-TSK Integration
```python
from flask import Flask
from elephants.py_ele.peanuts import init_peanuts

app = Flask(__name__)
peanuts = init_peanuts(app)
```

### 3. Configuration File Setup
```bash
# Create source configuration file
touch peanu.tsk

# Or use legacy format
touch .peanuts
```

## 📚 Usage Examples

### Configuration Management
```python
# Load configuration file (automatic priority detection)
success = Peanuts.eat()
if success:
    print("🥜 Configuration loaded successfully!")

# Load specific configuration file
success = Peanuts.eat('custom-config.peanu.tsk')

# Get configuration values
db_host = peanuts.get_config_value('database.host', 'localhost')
app_name = peanuts.get_config_value('app.name', 'Flask-TSK')

# Set configuration values
peanuts.set_config('database.port', 5432)
peanuts.set_config('app.debug', True)
```

### Environment Variable Management
```python
# Load encrypted environment
success = Peanuts.load_peanuts_env('.peanuts')

# Get environment variables
api_key = Peanuts.get_peanuts_env('API_KEY', 'default-key')
debug_mode = Peanuts.get_peanuts_env('DEBUG', False)

# Set environment variables
Peanuts.set_peanuts_env('DATABASE_URL', 'postgresql://user:pass@localhost/db')
Peanuts.set_peanuts_env('CACHE_TTL', 3600)

# Save environment to file
env_vars = {
    'DATABASE_URL': 'postgresql://user:pass@localhost/db',
    'API_KEY': 'your-secret-key',
    'DEBUG': True
}
Peanuts.save_peanuts_env(env_vars, '.peanuts')
```

### Performance Monitoring
```python
# Capture request metrics
peanuts.capture_request_metrics(
    response_time=0.15,
    memory_usage=50 * 1024 * 1024  # 50MB
)

# Get performance status
status = peanuts.get_performance_status()
print(f"Mode: {status['mode']}")
print(f"Score: {status['score']:.3f}")
print(f"Avg Response Time: {status['avg_response_time']:.3f}s")

# Trigger adaptive optimization
peanuts.adaptive_optimize()
```

### Performance Mode Management
```python
# Give performance rewards (enables feast mode)
peanuts.give_peanuts('excellent_performance')

# Start diet mode (conservation)
peanuts.start_diet('high_memory_usage')

# Manual mode switching
peanuts.switch_performance_mode(PerformanceMode.FEAST, 0.95)
```

### Configuration File Compilation
```python
# Compile source to binary format
success = Peanuts.compile('peanu.tsk', '.pnt')
if success:
    print("🥜 Configuration compiled to binary format!")

# Compile to legacy shell format
success = Peanuts.shell('.peanuts', '.shell')
if success:
    print("🥜 Configuration shelled successfully!")
```

## 🎯 Configuration File Formats

### Source Format (peanu.tsk)
```ini
# 🥜 TuskPHP Configuration
# Generated: 2024-12-19 10:30:00

[database]
host = localhost
port = 5432
name = tusksk_db
user = tusksk_user
password = "secure_password"

[app]
name = "Flask-TSK Application"
url = "https://example.com"
env = production
debug = false

[mail]
host = smtp.gmail.com
port = 587
username = "noreply@example.com"
password = "app_password"
from = "noreply@example.com"

[tusk]
version = "2.0.0"
elder_path = "/path/to/elder"
api_key = "your-tusk-api-key"
```

### Binary Format (.pnt)
The binary format is a compressed, encrypted version of the configuration:
- **Magic Header**: `PNUT`
- **Version**: 1 byte
- **Length**: 4 bytes
- **Compressed Data**: Gzip-compressed JSON configuration

### Legacy Formats
- **.peanuts**: Legacy encrypted format
- **.shell**: Legacy shell format with `SHEL` magic header

## 🔧 Performance Optimization

### Automatic Mode Switching
```python
# Peanuts automatically switches modes based on performance score
# Score ≥ 0.9: Feast Mode (all features enabled)
# Score 0.7-0.9: Balanced Mode (standard operation)
# Score 0.4-0.7: Diet Mode (conservation mode)
# Score < 0.4: Survival Mode (emergency mode)

# Monitor mode changes
peanuts.logger.info(f"Current mode: {peanuts.performance_mode.value}")
```

### Performance Scoring
```python
# Performance score is calculated from multiple factors:
factors = {
    'response_time': 0.3,    # 30% weight
    'memory_usage': 0.2,     # 20% weight
    'error_rate': 0.2,       # 20% weight
    'db_performance': 0.2,   # 20% weight
    'cache_efficiency': 0.1  # 10% weight
}

# Get detailed scoring
score = peanuts.calculate_performance_score()
print(f"Overall performance score: {score:.3f}")
```

### Elephant Service Management
```python
# Feast Mode: All services enabled
peanuts.enable_all_elephant_services()
# - Satao: Security monitoring
# - Horton: Job processing
# - Jumbo: Large uploads
# - Tantor: WebSocket support
# - Heffalump: Search indexing
# - Koshik: Audio processing
# - Happy: Image processing
# - Tai: Video embedding
# - Elmer: Theme generation
# - Babar: CMS features
# - Dumbo: HTTP client
# - Stampy: App installation
# - Kaavan: Monitoring & backups

# Diet Mode: Essential services only
peanuts.disable_non_essential_services()
# - Satao: Security monitoring (kept)
# - Memory: Basic caching (kept)
# - TuskDb: Database access (kept)
# - Herd: Authentication (kept)
# - All others: Disabled

# Survival Mode: Critical services only
peanuts.enable_only_essential_services()
# - Satao: Basic security only
# - Memory: Emergency cache only
# - TuskDb: Read-only mode
# - Herd: Basic auth only
```

## 🗄️ Cache Management

### Cache Decision Logic
```python
# Determine if route should be cached
route = {'h1': 'home', 'h2': 'index'}
should_cache = Peanuts.should_use_cache(route)

# Get cache TTL based on performance mode and content type
ttl = Peanuts.get_cache_ttl('home')  # Longer TTL for static pages
ttl = Peanuts.get_cache_ttl('dashboard')  # Shorter TTL for dynamic pages
```

### Cache TTL by Mode
```python
# Feast Mode: 2 hours (7200 seconds)
# Balanced Mode: 30 minutes (1800 seconds)
# Diet Mode: 5 minutes (300 seconds)
# Survival Mode: 1 minute (60 seconds)

# Content-specific adjustments:
# - Static pages (about, contact): 2x TTL
# - Dynamic pages (dashboard, profile): 0.5x TTL
# - Home page: Full TTL
```

## 🔐 Security Features

### Encrypted Configuration
```python
# Configuration files are encrypted using AES-256-CTR
# Encryption key sources (in priority order):
# 1. PEANUTS_KEY environment variable
# 2. System-specific hash
# 3. Fallback key (not recommended for production)

# Binary files are read-only (644 permissions)
# Source files should be protected with appropriate permissions
```

### Environment Variable Security
```python
# Sensitive data is encrypted in .peanuts files
# Environment variables are set securely
# Configuration values are validated before use
```

## 📊 Performance Monitoring

### Metric Collection
```python
# Response time tracking
peanuts.metrics.response_times.append(0.15)

# Memory usage tracking
peanuts.metrics.memory_usage.append(50 * 1024 * 1024)

# Database query time tracking
peanuts.metrics.db_query_times.append(0.025)

# Error rate tracking
if Memory:
    Memory.remember('peanuts_error_count', 
                   Memory.recall('peanuts_error_count', 0) + 1)

# Cache efficiency tracking
if Memory:
    Memory.remember('peanuts_cache_hits', 
                   Memory.recall('peanuts_cache_hits', 0) + 1)
```

### Performance Recommendations
```python
# Get optimization recommendations
recommendations = peanuts.get_optimization_recommendations()
for rec in recommendations:
    print(f"💡 {rec}")

# Common recommendations:
# - "Consider enabling caching for database queries"
# - "Review slow database queries and add indexes"
# - "Optimize image sizes and enable compression"
# - "Response times are high - consider code optimization"
```

## 🔧 Configuration Methods

### Configuration File Detection
```python
# Priority order for configuration files:
# 1. .pnt (preferred binary format)
# 2. peanu.tsk (source file)
# 3. .peanuts (legacy encrypted)
# 4. .shell (legacy shell format)

# Automatic detection
success = Peanuts.eat()  # Automatically finds and loads config

# Manual specification
success = Peanuts.eat('custom-config.peanu.tsk')
```

### Configuration Value Access
```python
# Get configuration values with dot notation
db_host = peanuts.get_config_value('database.host', 'localhost')
app_name = peanuts.get_config_value('app.name', 'Default App')

# Set configuration values
peanuts.set_config('database.port', 5432)
peanuts.set_config('app.debug', True)

# Get entire configuration
config = peanuts.get_config()
print(f"Database: {config['database']['host']}")
```

## 🎯 Best Practices

### Configuration Management
1. **Use Source Files for Development**: peanu.tsk for easy editing
2. **Compile for Production**: Use .pnt binary format for security
3. **Environment-Specific Configs**: Different configs for dev/staging/prod
4. **Secure Sensitive Data**: Use encrypted .peanuts files for secrets
5. **Version Control**: Keep source files in version control, exclude binaries

### Performance Optimization
1. **Monitor Performance**: Regularly check performance status
2. **Adapt to Load**: Let Peanuts automatically adjust performance modes
3. **Cache Strategically**: Use appropriate cache TTLs for different content
4. **Resource Management**: Monitor memory and database performance
5. **Error Tracking**: Keep error rates low for optimal performance

### Security
1. **Encrypt Sensitive Data**: Use .peanuts files for API keys and passwords
2. **File Permissions**: Set appropriate permissions on configuration files
3. **Environment Variables**: Use environment variables for sensitive data
4. **Key Management**: Secure encryption key storage
5. **Access Control**: Limit access to configuration files

## 🔮 Advanced Usage

### Custom Performance Metrics
```python
# Add custom performance metrics
peanuts.metrics.custom_metrics = {
    'api_calls': 0,
    'cache_misses': 0,
    'slow_queries': 0
}

# Track custom metrics
peanuts.metrics.custom_metrics['api_calls'] += 1
```

### Performance Mode Hooks
```python
# Custom mode switching logic
def custom_mode_switch(old_mode, new_mode, score):
    print(f"Mode changed from {old_mode} to {new_mode} (score: {score})")
    # Custom logic here

# Override default mode switching
peanuts.log_mode_switch = custom_mode_switch
```

### Configuration Validation
```python
# Validate configuration before applying
def validate_config(config):
    required_keys = ['database.host', 'database.name', 'app.name']
    for key in required_keys:
        if not peanuts.get_config_value(key):
            raise ValueError(f"Missing required configuration: {key}")

# Apply validation
validate_config(peanuts.get_config())
```

## 🔮 Future Enhancements

### Planned Features
- **Advanced Encryption**: Support for hardware security modules
- **Configuration Validation**: Schema-based configuration validation
- **Performance Analytics**: Detailed performance analytics dashboard
- **Auto-Scaling**: Automatic resource scaling based on performance
- **Configuration Templates**: Pre-built configuration templates
- **Multi-Environment Support**: Better support for multiple environments

### Integration Opportunities
- **Monitoring Systems**: Prometheus, Grafana integration
- **Configuration Management**: Ansible, Terraform integration
- **Secrets Management**: HashiCorp Vault, AWS Secrets Manager
- **Performance Tools**: APM tools integration
- **Container Platforms**: Docker, Kubernetes integration

## 📖 Conclusion

Peanuts brings the same wisdom and efficiency that elephants bring to managing their energy. With its comprehensive configuration management, adaptive performance optimization, and intelligent resource management, Peanuts provides the foundation for a robust, scalable Flask-TSK application.

Whether you're managing configuration files, optimizing performance, or coordinating elephant services, Peanuts provides the intelligence and automation needed to keep your application running smoothly and efficiently.

*"Just as elephants know exactly how much to eat and when to conserve energy, Peanuts knows exactly how to configure and optimize your application."* 