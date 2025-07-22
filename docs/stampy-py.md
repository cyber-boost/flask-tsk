# Stampy - The App Installer (Python)

## 🐘 Backstory

In The Simpsons episode "Bart Gets an Elephant," Bart wins Stampy from a radio contest. Stampy quickly proves to be more than the family can handle - eating enormous amounts of food, destroying fences, and generally causing chaos. Despite the mayhem, Stampy is lovable and eventually finds a home at an animal refuge. His brief stay with the Simpsons was memorable for his size, appetite, and ability to "install" himself anywhere.

Like Stampy who could break through any barrier and make himself at home anywhere, this installer helps you quickly "stomp" pre-built apps into your project. Stampy was too big to ignore and changed everything when he arrived - just like these powerful app installations that transform your project instantly.

## Overview

Stampy is a powerful app installer for Flask-TSK that allows you to quickly install pre-built applications with a single command. It handles dependency resolution, configuration, database setup, and post-installation tasks automatically.

## Features

- **One-command app installations**
- **Pre-built application templates**
- **Dependency resolution**
- **Database migration handling**
- **Configuration wizards**
- **Rollback support**
- **App marketplace integration**
- **Automatic backup creation**
- **Package integrity verification**

## Installation

```bash
# Install required dependencies
pip install flask requests pyyaml

# Or add to requirements.txt
flask>=2.0.0
requests>=2.25.0
pyyaml>=5.4.0
```

## Basic Usage

### 1. Initialize Stampy with Flask App

```python
from flask import Flask
from elephants.stampy import Stampy

app = Flask(__name__)

# Initialize Stampy
stampy = Stampy(app)

# Or use the factory pattern
def create_app():
    app = Flask(__name__)
    stampy = Stampy(app)
    return app
```

### 2. Install an App

```python
# Install a blog platform
success = app.stampy.install('blog')

# Install with force (overwrite existing)
success = app.stampy.install('reddit', {'force': True})

# Quick install (non-interactive)
success = app.stampy.stomp('shop')
```

### 3. List Available Apps

```python
# View app catalog
app.stampy.catalog()
```

### 4. Uninstall an App

```python
# Uninstall an app
success = app.stampy.uninstall('blog')
```

## Available Apps

### Reddit Clone
```python
app.stampy.install('reddit')
```
- **Size**: XXL (Stampy-sized!)
- **Features**: voting, comments, subreddits, karma
- **Requirements**: Python 3.8+, Flask, SQLAlchemy

### Blog Platform
```python
app.stampy.install('blog')
```
- **Size**: M (Baby elephant - quick and easy)
- **Features**: posts, categories, comments, RSS
- **Requirements**: Python 3.7+

### E-commerce Platform
```python
app.stampy.install('shop')
```
- **Size**: XL (Adult elephant - substantial app)
- **Features**: products, cart, checkout, payments
- **Requirements**: Python 3.8+, Flask, Stripe

## Advanced Usage

### Custom Installation Options

```python
# Install with custom options
options = {
    'force': True,        # Overwrite existing installation
    'quick': True,        # Non-interactive mode
    'config': {           # Pre-configure settings
        'database_url': 'postgresql://user:pass@localhost/db',
        'stripe_key': 'pk_test_...'
    }
}

success = app.stampy.install('shop', options)
```

### Check Installation Status

```python
# Check if app is installed
if app.stampy.is_installed('blog'):
    print("Blog is installed!")

# Get installed apps info
for name, app_info in app.stampy.installed_apps.items():
    print(f"{name}: v{app_info.version} at {app_info.path}")
```

### Backup and Restore

```python
# Apps are automatically backed up before updates
# Manual backup creation
backup_path = app.stampy.create_backup('blog')

# Restore from backup
app.stampy.restore_from_backup(backup_path)
```

## Configuration

### Flask Configuration

```python
app.config.update({
    'STAMPY_REPOSITORY': 'https://apps.tuskpython.com/',
    'STAMPY_CACHE_DIR': 'cache/stampy',
    'STAMPY_INSTALL_DIR': 'installed-apps',
    'STAMPY_BACKUP_DIR': 'backups/stampy'
})
```

### .peanuts Configuration

```json
{
  "stampy": {
    "repository": "https://apps.tuskpython.com/",
    "cache_dir": "cache/stampy",
    "install_dir": "installed-apps",
    "backup_dir": "backups/stampy",
    "auto_backup": true,
    "verify_packages": true
  }
}
```

## App Development

### Creating Custom Apps

Apps are distributed as ZIP or TAR archives with the following structure:

```
my-app/
├── app.py                 # Main application file
├── requirements.txt       # Python dependencies
├── .peanuts.default      # Default configuration
├── install.py            # Installation script (optional)
├── uninstall.py          # Uninstall script (optional)
├── migrations/           # Database migrations
│   ├── 001_initial.sql
│   └── 002_add_users.sql
├── public/               # Public assets
│   ├── css/
│   ├── js/
│   └── images/
└── README.md             # Documentation
```

### Installation Script

```python
# install.py
import os
import sys
from pathlib import Path

def install():
    """Custom installation logic"""
    app_dir = Path(__file__).parent
    
    # Create database tables
    from flask import Flask
    from flask_sqlalchemy import SQLAlchemy
    
    app = Flask(__name__)
    app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///app.db'
    db = SQLAlchemy(app)
    
    # Import and create models
    from models import User, Post
    db.create_all()
    
    print("✅ Database tables created")
    
    # Set up initial data
    # ...

if __name__ == '__main__':
    install()
```

### Configuration Prompts

```python
# In your app's AppInfo
config_prompts = {
    'database_url': {
        'question': 'Enter database URL:',
        'default': 'sqlite:///app.db'
    },
    'admin_email': {
        'question': 'Admin email address:',
        'default': 'admin@example.com'
    },
    'secret_key': {
        'question': 'Secret key (leave empty to generate):',
        'default': ''
    }
}
```

## Integration with Flask-TSK

### 1. Register with Flask-TSK

```python
# In your Flask-TSK app initialization
from flask_tsk import FlaskTSK
from elephants.stampy import Stampy

app = FlaskTSK(__name__)

# Register Stampy
stampy = Stampy(app)
app.register_elephant('stampy', stampy)
```

### 2. Use with TuskLang Commands

```tusk
# In your .tsk files
stampy {
    repository = "https://apps.tuskpython.com/"
    auto_backup = true
    verify_packages = true
}

# Install apps via TuskLang
install {
    blog = true
    shop = {
        force = true
        config = {
            stripe_key = "pk_test_..."
        }
    }
}
```

### 3. CLI Integration

```bash
# Install apps via CLI
tsk stampy install blog
tsk stampy install shop --force
tsk stampy install reddit --quick

# List available apps
tsk stampy catalog

# List installed apps
tsk stampy list

# Uninstall apps
tsk stampy uninstall blog

# Update apps
tsk stampy update shop
```

## API Reference

### Core Methods

#### `Stampy(app=None)`
Initialize Stampy with optional Flask app.

#### `init_app(app)`
Initialize Stampy with Flask app (factory pattern).

#### `install(app_name, options=None)`
Install an app with optional configuration.

#### `uninstall(app_name)`
Uninstall an app with confirmation.

#### `catalog()`
Display available apps catalog.

#### `stomp(app_name)`
Quick install with force and non-interactive mode.

### App Management Methods

#### `is_installed(app_name)`
Check if an app is installed.

#### `create_backup(app_name)`
Create a backup of an installed app.

#### `restore_from_backup(backup_path)`
Restore an app from backup.

#### `update(app_name)`
Update an installed app to latest version.

### Utility Methods

#### `check_requirements(app)`
Check if app requirements are met.

#### `download_package(app)`
Download app package from repository.

#### `extract_package(package_path, app)`
Extract app package to installation directory.

#### `run_install_scripts(app, install_path)`
Run app installation scripts.

#### `configure_app(app, options)`
Configure installed app.

## File Structure

```
project/
├── installed-apps/           # Installed applications
│   ├── blog/
│   ├── shop/
│   └── reddit/
├── cache/stampy/            # Package cache
│   ├── downloads/
│   └── temp/
├── backups/stampy/          # App backups
│   ├── blog_2024-01-15_143022/
│   └── shop_2024-01-15_150045/
└── storage/stampy/          # Stampy data
    └── registry.peanuts     # Installed apps registry
```

## Security Features

### Package Verification
- SHA256 hash verification for downloaded packages
- Prevents tampering and ensures package integrity

### Backup System
- Automatic backups before installations/updates
- Manual backup creation and restoration
- Backup rotation and cleanup

### Isolation
- Apps are installed in separate directories
- Independent configurations and dependencies
- No interference between apps

## Performance Considerations

- **Caching**: Downloaded packages are cached for 1 hour
- **Parallel Downloads**: Multiple packages can be downloaded simultaneously
- **Incremental Updates**: Only changed files are updated
- **Cleanup**: Temporary files are automatically removed

## Troubleshooting

### Common Issues

1. **Download Failures**: Check network connection and repository URL
2. **Permission Errors**: Ensure write permissions to install directories
3. **Dependency Conflicts**: Use virtual environments for isolation
4. **Configuration Errors**: Check .peanuts file syntax

### Debug Mode

```python
# Enable debug logging
app.config['STAMPY_DEBUG'] = True

# Verbose installation
success = app.stampy.install('blog', {'verbose': True})
```

### Logs

Stampy logs are stored in:
- `logs/stampy.log` - General operations
- `logs/stampy_install.log` - Installation details
- `logs/stampy_error.log` - Error messages

## Examples

### Complete Flask App with Stampy

```python
from flask import Flask
from elephants.stampy import Stampy

app = Flask(__name__)

# Configure Stampy
app.config.update({
    'STAMPY_REPOSITORY': 'https://apps.tuskpython.com/',
    'STAMPY_INSTALL_DIR': 'apps',
    'STAMPY_BACKUP_DIR': 'backups'
})

# Initialize Stampy
stampy = Stampy(app)

@app.route('/')
def home():
    return "Welcome to the app installer!"

@app.route('/install/<app_name>')
def install_app(app_name):
    success = stampy.install(app_name)
    return f"Installation {'successful' if success else 'failed'}"

@app.route('/apps')
def list_apps():
    return {
        'installed': list(stampy.installed_apps.keys()),
        'available': list(stampy.available_apps.keys())
    }

if __name__ == '__main__':
    app.run(debug=True)
```

### Integration with Flask-TSK

```python
from flask_tsk import FlaskTSK
from elephants.stampy import Stampy

def create_app():
    app = FlaskTSK(__name__)
    
    # Load TuskLang configuration
    app.load_config('.peanuts')
    
    # Initialize Stampy
    stampy = Stampy(app)
    app.register_elephant('stampy', stampy)
    
    return app

app = create_app()
```

## Conclusion

Stampy provides a powerful and user-friendly way to install pre-built applications in your Flask-TSK project. With automatic dependency management, configuration wizards, and comprehensive backup systems, Stampy makes app installation as easy as "stomping" them into place.

Remember: "Stampy! Stampy! Where are you boy?" - Bart Simpson 