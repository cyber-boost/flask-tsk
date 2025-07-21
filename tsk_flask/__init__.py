#!/usr/bin/env python3
"""
Flask-TSK - Flask Extension for TuskLang Integration
Provides seamless TuskLang configuration and function execution in Flask applications
Includes FULL TuskLang SDK capabilities for maximum power and flexibility
"""

from flask import Flask, current_app, g, request, jsonify
from typing import Any, Dict, List, Optional, Union
import logging
import os

try:
    import tusktsk
    from tusktsk import (
        TSK, parse, stringify, load_from_peanut, save, load,
        parse_enhanced, parse_with_comments, TSKParser, ShellStorage
    )
    TUSK_AVAILABLE = True
    TUSK_VERSION = getattr(tusktsk, '__version__', '2.0.3')
except ImportError:
    TUSK_AVAILABLE = False
    TUSK_VERSION = None
    logging.warning("tusktsk package not available. Install with: pip install tusktsk")

# Import performance engine
try:
    from .performance_engine import (
        TurboTemplateEngine, 
        render_turbo_template, 
        render_turbo_template_async,
        optimize_flask_app,
        get_performance_stats
    )
    PERFORMANCE_ENGINE_AVAILABLE = True
except ImportError:
    PERFORMANCE_ENGINE_AVAILABLE = False
    logging.warning("Performance engine not available")


class FlaskTSK:
    """Flask extension for TuskLang integration with FULL SDK capabilities"""
    
    def __init__(self, app: Optional[Flask] = None):
        self.app = app
        self.tsk_instance: Optional[TSK] = None
        self.peanut_loaded = False
        
        if app is not None:
            self.init_app(app)
    
    def init_app(self, app: Flask):
        """Initialize the Flask extension"""
        self.app = app
        
        # Set default configuration
        app.config.setdefault('TSK_CONFIG_PATH', None)
        app.config.setdefault('TSK_AUTO_LOAD', True)
        app.config.setdefault('TSK_ENABLE_BLUEPRINT', True)
        app.config.setdefault('TSK_ENABLE_CONTEXT', True)
        app.config.setdefault('TSK_ENABLE_FULL_SDK', True)  # Enable full TuskLang SDK
        
        # Initialize TuskLang if available
        if TUSK_AVAILABLE and app.config.get('TSK_AUTO_LOAD', True):
            self._initialize_tusk()
        
        # Register blueprint if enabled
        if app.config.get('TSK_ENABLE_BLUEPRINT', True):
            from .blueprint import tsk_blueprint
            app.register_blueprint(tsk_blueprint)
        
        # Register context processor if enabled
        if app.config.get('TSK_ENABLE_CONTEXT', True):
            app.context_processor(self._context_processor)
        
        # Register before_request handler
        app.before_request(self._before_request)
        
        # Register teardown_appcontext handler
        app.teardown_appcontext(self._teardown_appcontext)
        
        # Add extension to app
        app.extensions['flask-tsk'] = self
        
        # Apply performance optimizations if available
        if PERFORMANCE_ENGINE_AVAILABLE:
            optimize_flask_app(app)
            current_app.logger.info("Flask-TSK: Performance optimizations applied")
    
    def _initialize_tusk(self):
        """Initialize TuskLang integration"""
        try:
            # Try to load from peanu.tsk first
            self.tsk_instance = load_from_peanut()
            self.peanut_loaded = True
            current_app.logger.info(f"Flask-TSK: Successfully loaded TuskLang configuration (tusktsk v{TUSK_VERSION})")
        except Exception as e:
            current_app.logger.warning(f"Flask-TSK: Failed to load peanu.tsk: {e}")
            # Create empty TSK instance
            self.tsk_instance = TSK()
    
    def _context_processor(self):
        """Context processor to make TSK available in templates"""
        return {
            'tsk': self,
            'tsk_available': TUSK_AVAILABLE,
            'tsk_version': TUSK_VERSION,
            'tsk_full_sdk': TUSK_AVAILABLE
        }
    
    def _before_request(self):
        """Before request handler to set up TSK context"""
        if TUSK_AVAILABLE and self.tsk_instance:
            g.tsk = self.tsk_instance
        else:
            g.tsk = None
    
    def _teardown_appcontext(self, exception=None):
        """Teardown app context handler"""
        if hasattr(g, 'tsk'):
            del g.tsk
    
    # ===== CORE TUSKLANG SDK METHODS =====
    
    def get_config(self, section: str, key: str, default: Any = None) -> Any:
        """Get configuration value from TuskLang"""
        if not TUSK_AVAILABLE or not self.tsk_instance:
            return default
        
        try:
            return self.tsk_instance.get_value(section, key)
        except Exception as e:
            current_app.logger.warning(f"Flask-TSK: Failed to get config {section}.{key}: {e}")
            return default
    
    def set_config(self, section: str, key: str, value: Any) -> bool:
        """Set configuration value in TuskLang"""
        if not TUSK_AVAILABLE or not self.tsk_instance:
            return False
        
        try:
            self.tsk_instance.set_value(section, key, value)
            return True
        except Exception as e:
            current_app.logger.error(f"Flask-TSK: Failed to set config {section}.{key}: {e}")
            return False
    
    def get_section(self, section: str) -> Optional[Dict[str, Any]]:
        """Get entire section from TuskLang"""
        if not TUSK_AVAILABLE or not self.tsk_instance:
            return None
        
        try:
            return self.tsk_instance.get_section(section)
        except Exception as e:
            current_app.logger.warning(f"Flask-TSK: Failed to get section {section}: {e}")
            return None
    
    def execute_function(self, section: str, key: str, *args, **kwargs) -> Any:
        """Execute a TuskLang function"""
        if not TUSK_AVAILABLE or not self.tsk_instance:
            return None
        
        try:
            return self.tsk_instance.execute_fujsen(section, key, *args, **kwargs)
        except Exception as e:
            current_app.logger.error(f"Flask-TSK: Failed to execute function {section}.{key}: {e}")
            return None
    
    # ===== ADVANCED TUSKLANG SDK METHODS =====
    
    def parse_tsk(self, content: str, enhanced: bool = False, with_comments: bool = False) -> Dict[str, Any]:
        """Parse TuskLang content with advanced options"""
        if not TUSK_AVAILABLE:
            return {}
        
        try:
            if enhanced:
                return parse_enhanced(content)
            elif with_comments:
                return parse_with_comments(content)
            else:
                return parse(content)
        except Exception as e:
            current_app.logger.error(f"Flask-TSK: Failed to parse TuskLang content: {e}")
            return {}
    
    def stringify_tsk(self, data: Dict[str, Any]) -> str:
        """Convert data back to TuskLang format"""
        if not TUSK_AVAILABLE:
            return ""
        
        try:
            return stringify(data)
        except Exception as e:
            current_app.logger.error(f"Flask-TSK: Failed to stringify data: {e}")
            return ""
    
    def save_tsk(self, data: Dict[str, Any], filepath: str) -> bool:
        """Save TuskLang data to file"""
        if not TUSK_AVAILABLE:
            return False
        
        try:
            save(data, filepath)
            return True
        except Exception as e:
            current_app.logger.error(f"Flask-TSK: Failed to save TuskLang data: {e}")
            return False
    
    def load_tsk(self, filepath: str) -> Dict[str, Any]:
        """Load TuskLang data from file"""
        if not TUSK_AVAILABLE:
            return {}
        
        try:
            return load(filepath)
        except Exception as e:
            current_app.logger.error(f"Flask-TSK: Failed to load TuskLang data: {e}")
            return {}
    
    def create_parser(self) -> Optional[TSKParser]:
        """Create a TuskLang parser instance"""
        if not TUSK_AVAILABLE:
            return None
        
        try:
            return TSKParser()
        except Exception as e:
            current_app.logger.error(f"Flask-TSK: Failed to create parser: {e}")
            return None
    
    def create_shell_storage(self) -> Optional[ShellStorage]:
        """Create a TuskLang shell storage instance"""
        if not TUSK_AVAILABLE:
            return None
        
        try:
            return ShellStorage()
        except Exception as e:
            current_app.logger.error(f"Flask-TSK: Failed to create shell storage: {e}")
            return None
    
    # ===== CONFIGURATION MANAGEMENT =====
    
    def get_database_config(self) -> Dict[str, Any]:
        """Get database configuration from TuskLang"""
        db_config = self.get_section('database')
        if db_config:
            return db_config
        
        # Fallback to Flask config
        return {
            'type': 'sqlite',
            'host': current_app.config.get('DB_HOST', 'localhost'),
            'port': current_app.config.get('DB_PORT', 5432),
            'name': current_app.config.get('DB_NAME', 'app.db'),
            'username': current_app.config.get('DB_USERNAME', ''),
            'password': current_app.config.get('DB_PASSWORD', ''),
            'charset': 'utf8mb4',
            'pool_size': 10
        }
    
    def get_security_config(self) -> Dict[str, Any]:
        """Get security configuration from TuskLang"""
        security_config = self.get_section('security')
        if security_config:
            return security_config
        
        # Fallback to Flask config
        return {
            'encryption_key': current_app.config.get('SECRET_KEY', ''),
            'jwt_secret': current_app.config.get('JWT_SECRET_KEY', ''),
            'app_key': current_app.config.get('APP_KEY', '')
        }
    
    def get_ui_config(self) -> Dict[str, Any]:
        """Get UI configuration from TuskLang"""
        ui_config = self.get_section('ui')
        if ui_config:
            return ui_config
        
        # Fallback to Flask config
        return {
            'theme': current_app.config.get('UI_THEME', 'default'),
            'component_cache': current_app.config.get('UI_COMPONENT_CACHE', True),
            'minify_assets': current_app.config.get('UI_MINIFY_ASSETS', True),
            'responsive_design': current_app.config.get('UI_RESPONSIVE_DESIGN', True)
        }
    
    # ===== UTILITY METHODS =====
    
    def is_available(self) -> bool:
        """Check if TuskLang is available"""
        return TUSK_AVAILABLE and self.tsk_instance is not None
    
    def get_status(self) -> Dict[str, Any]:
        """Get TuskLang integration status"""
        status = {
            'available': TUSK_AVAILABLE,
            'version': TUSK_VERSION,
            'initialized': self.tsk_instance is not None,
            'peanut_loaded': self.peanut_loaded,
            'package_source': 'PyPI' if TUSK_AVAILABLE else 'None',
            'performance_engine': PERFORMANCE_ENGINE_AVAILABLE,
            'full_sdk_enabled': TUSK_AVAILABLE
        }
        
        # Add performance stats if available
        if PERFORMANCE_ENGINE_AVAILABLE:
            try:
                status['performance_stats'] = get_performance_stats()
            except Exception as e:
                status['performance_error'] = str(e)
        
        return status
    
    def save_config(self, filepath: str) -> bool:
        """Save TuskLang configuration to file"""
        if not TUSK_AVAILABLE or not self.tsk_instance:
            return False
        
        try:
            self.tsk_instance.to_file(filepath)
            return True
        except Exception as e:
            current_app.logger.error(f"Flask-TSK: Failed to save config to {filepath}: {e}")
            return False
    
    def load_config(self, filepath: str) -> bool:
        """Load TuskLang configuration from file"""
        if not TUSK_AVAILABLE:
            return False
        
        try:
            self.tsk_instance = TSK.from_file(filepath)
            return True
        except Exception as e:
            current_app.logger.error(f"Flask-TSK: Failed to load config from {filepath}: {e}")
            return False
    
    # ===== ADVANCED FEATURES =====
    
    def get_all_sections(self) -> List[str]:
        """Get all available sections"""
        if not TUSK_AVAILABLE or not self.tsk_instance:
            return []
        
        try:
            return list(self.tsk_instance.data.keys())
        except Exception as e:
            current_app.logger.error(f"Flask-TSK: Failed to get sections: {e}")
            return []
    
    def has_section(self, section: str) -> bool:
        """Check if section exists"""
        if not TUSK_AVAILABLE or not self.tsk_instance:
            return False
        
        try:
            return section in self.tsk_instance.data
        except Exception as e:
            current_app.logger.error(f"Flask-TSK: Failed to check section {section}: {e}")
            return False
    
    def delete_section(self, section: str) -> bool:
        """Delete a section"""
        if not TUSK_AVAILABLE or not self.tsk_instance:
            return False
        
        try:
            if section in self.tsk_instance.data:
                del self.tsk_instance.data[section]
                return True
            return False
        except Exception as e:
            current_app.logger.error(f"Flask-TSK: Failed to delete section {section}: {e}")
            return False
    
    def get_all_keys(self, section: str) -> List[str]:
        """Get all keys in a section"""
        section_data = self.get_section(section)
        if section_data:
            return list(section_data.keys())
        return []

    def setup_project_structure(self, project_path: str = None):
        """
        Create Flask-TSK special folder structure for asset management, layouts, and optimization.
        
        Creates:
        - tsk/assets/ (CSS, JS, images, fonts)
        - tsk/layouts/ (HTML templates, headers, footers)
        - tsk/optimization/ (minification, obfuscation scripts)
        - tsk/config/ (TuskLang configuration files)
        - tsk/templates/ (Jinja2 templates)
        - tsk/static/ (Flask static files)
        - tsk/components/ (Ready-to-use Flask components)
        """
        if project_path is None:
            project_path = os.getcwd()
        
        # Define the folder structure
        folders = [
            'tsk/assets/css',
            'tsk/assets/js', 
            'tsk/assets/images',
            'tsk/assets/fonts',
            'tsk/layouts/headers',
            'tsk/layouts/footers',
            'tsk/layouts/navigation',
            'tsk/optimization/scripts',
            'tsk/optimization/tools',
            'tsk/config',
            'tsk/templates',
            'tsk/static/css',
            'tsk/static/js',
            'tsk/static/images',
            'tsk/static/fonts',
            'tsk/build',
            'tsk/cache',
            'tsk/components',
            'tsk/components/navigation',
            'tsk/components/forms',
            'tsk/components/ui',
            'tsk/components/layouts',
            'tsk/components/ecommerce',
            'tsk/components/blog',
            'tsk/components/dashboard'
        ]
        
        # Create folders
        for folder in folders:
            folder_path = os.path.join(project_path, folder)
            os.makedirs(folder_path, exist_ok=True)
            current_app.logger.info(f"Created Flask-TSK folder: {folder}")
        
        # Create default files
        self._create_default_files(project_path)
        
        current_app.logger.info("Flask-TSK project structure setup complete!")
        return True
    
    def _create_default_files(self, project_path: str):
        """Create default configuration and template files."""
        
        # Default peanu.tsk configuration
        peanu_content = '''[flask_tsk]
# Flask-TSK Configuration
version = "1.0.1"
auto_setup = true
optimization_enabled = true

[assets]
# Asset management configuration
css_dir = "tsk/assets/css"
js_dir = "tsk/assets/js"
images_dir = "tsk/assets/images"
fonts_dir = "tsk/assets/fonts"

[optimization]
# Optimization settings
minify_css = true
minify_js = true
obfuscate_js = false
compress_images = true
cache_enabled = true

[layouts]
# Layout configuration
default_header = "tsk/layouts/headers/default.html"
default_footer = "tsk/layouts/footers/default.html"
default_nav = "tsk/layouts/navigation/default.html"

[components]
# Component configuration
auto_include = true
component_dir = "tsk/components"
default_theme = "modern"
responsive = true

[build]
# Build settings
output_dir = "tsk/build"
source_maps = true
watch_mode = false
'''
        
        # Default header template
        header_content = '''<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ title|default('Flask-TSK App') }}</title>
    
    <!-- Flask-TSK Asset Management -->
    {% if tsk_available %}
        <link rel="stylesheet" href="{{ tsk_asset('css', 'main.css') }}">
        <link rel="stylesheet" href="{{ tsk_asset('css', 'components.css') }}">
        <script src="{{ tsk_asset('js', 'main.js') }}" defer></script>
    {% else %}
        <link rel="stylesheet" href="{{ url_for('static', filename='css/main.css') }}">
        <link rel="stylesheet" href="{{ url_for('static', filename='css/components.css') }}">
        <script src="{{ url_for('static', filename='js/main.js') }}" defer></script>
    {% endif %}
    
    <!-- Meta tags -->
    <meta name="description" content="{{ description|default('Flask-TSK Application') }}">
    <meta name="keywords" content="{{ keywords|default('flask, tusk, python') }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ url_for('static', filename='favicon.ico') }}">
</head>
<body>
    <!-- Navigation -->
    {% include 'tsk/layouts/navigation/default.html' %}
    
    <!-- Main content wrapper -->
    <main class="main-content">
'''
        
        # Default footer template
        footer_content = '''    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ current_year|default(2024) }} Flask-TSK Application. Powered by <a href="https://github.com/cyber-boost/tusktsk" target="_blank">TuskLang</a>.</p>
        </div>
    </footer>
    
    <!-- Flask-TSK Asset Management -->
    {% if tsk_available %}
        <script src="{{ tsk_asset('js', 'footer.js') }}"></script>
    {% else %}
        <script src="{{ url_for('static', filename='js/footer.js') }}"></script>
    {% endif %}
</body>
</html>
'''
        
        # Default navigation template
        nav_content = '''<nav class="navbar">
    <div class="container">
        <div class="navbar-brand">
            <a href="{{ url_for('index') }}" class="navbar-item">
                Flask-TSK
            </a>
        </div>
        
        <div class="navbar-menu">
            <a href="{{ url_for('index') }}" class="navbar-item">Home</a>
            <a href="{{ url_for('about') }}" class="navbar-item">About</a>
            <a href="{{ url_for('contact') }}" class="navbar-item">Contact</a>
        </div>
    </div>
</nav>
'''
        
        # Default CSS
        css_content = '''/* Flask-TSK Default Styles */
:root {
    --primary-color: #4ECDC4;
    --secondary-color: #FF6B6B;
    --accent-color: #FFE66D;
    --text-color: #1A1A1A;
    --background-color: #F8F9FA;
    --border-radius: 8px;
    --transition: all 0.3s ease;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    line-height: 1.6;
    color: var(--text-color);
    background-color: var(--background-color);
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Navigation */
.navbar {
    background: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 1rem 0;
}

.navbar-brand {
    font-weight: bold;
    font-size: 1.5rem;
}

.navbar-item {
    color: var(--text-color);
    text-decoration: none;
    padding: 0.5rem 1rem;
    border-radius: var(--border-radius);
    transition: var(--transition);
}

.navbar-item:hover {
    background-color: var(--primary-color);
    color: white;
}

/* Main content */
.main-content {
    min-height: calc(100vh - 200px);
    padding: 2rem 0;
}

/* Footer */
.footer {
    background: var(--text-color);
    color: white;
    padding: 2rem 0;
    text-align: center;
}

.footer a {
    color: var(--primary-color);
    text-decoration: none;
}

.footer a:hover {
    text-decoration: underline;
}
'''
        
        # Default JavaScript
        js_content = '''// Flask-TSK Default JavaScript
document.addEventListener('DOMContentLoaded', function() {
    console.log('Flask-TSK Application Loaded');
    
    // Initialize navigation
    initNavigation();
    
    // Initialize any TuskLang features
    if (typeof tsk !== 'undefined') {
        initTuskFeatures();
    }
});

function initNavigation() {
    // Add active class to current page
    const currentPath = window.location.pathname;
    const navItems = document.querySelectorAll('.navbar-item');
    
    navItems.forEach(item => {
        if (item.getAttribute('href') === currentPath) {
            item.classList.add('active');
        }
    });
}

function initTuskFeatures() {
    // Initialize TuskLang-specific features
    console.log('TuskLang features initialized');
    
    // Example: Dynamic configuration loading
    if (tsk && tsk.getConfig) {
        const theme = tsk.getConfig('ui', 'theme', 'light');
        document.body.setAttribute('data-theme', theme);
    }
}

// Utility functions
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
'''
        
        # Files to create
        files = {
            'tsk/config/peanu.tsk': peanu_content,
            'tsk/layouts/headers/default.html': header_content,
            'tsk/layouts/footers/default.html': footer_content,
            'tsk/layouts/navigation/default.html': nav_content,
            'tsk/assets/css/main.css': css_content,
            'tsk/assets/js/main.js': js_content,
            'tsk/static/css/main.css': css_content,
            'tsk/static/js/main.js': js_content,
        }
        
        # Create files
        for file_path, content in files.items():
            full_path = os.path.join(project_path, file_path)
            with open(full_path, 'w', encoding='utf-8') as f:
                f.write(content)
            current_app.logger.info(f"Created Flask-TSK file: {file_path}")


# Convenience function to get Flask-TSK instance
def get_tsk() -> FlaskTSK:
    """Get the Flask-TSK instance from current app"""
    return current_app.extensions.get('flask-tsk')


# ===== TEMPLATE HELPERS =====

def tsk_config(section: str, key: str, default: Any = None) -> Any:
    """Template helper to get TuskLang configuration"""
    tsk = get_tsk()
    if tsk:
        return tsk.get_config(section, key, default)
    return default


def tsk_section(section: str) -> Optional[Dict[str, Any]]:
    """Template helper to get TuskLang section"""
    tsk = get_tsk()
    if tsk:
        return tsk.get_section(section)
    return None


def tsk_function(section: str, key: str, *args, **kwargs) -> Any:
    """Template helper to execute TuskLang function"""
    tsk = get_tsk()
    if tsk:
        return tsk.execute_function(section, key, *args, **kwargs)
    return None


def tsk_parse(content: str, enhanced: bool = False) -> Dict[str, Any]:
    """Template helper to parse TuskLang content"""
    tsk = get_tsk()
    if tsk:
        return tsk.parse_tsk(content, enhanced)
    return {}


def tsk_stringify(data: Dict[str, Any]) -> str:
    """Template helper to stringify data to TuskLang format"""
    tsk = get_tsk()
    if tsk:
        return tsk.stringify_tsk(data)
    return ""


# ===== PERFORMANCE HELPERS =====

def render_turbo_template(template_content: str, context: Dict[str, Any] = None) -> str:
    """High-performance template rendering"""
    if PERFORMANCE_ENGINE_AVAILABLE:
        from .performance_engine import render_turbo_template as turbo_render
        return turbo_render(template_content, context)
    else:
        # Fallback to regular rendering
        return template_content


async def render_turbo_template_async(template_content: str, context: Dict[str, Any] = None) -> str:
    """Asynchronous high-performance template rendering"""
    if PERFORMANCE_ENGINE_AVAILABLE:
        from .performance_engine import render_turbo_template_async as turbo_render_async
        return await turbo_render_async(template_content, context)
    else:
        # Fallback to regular rendering
        return template_content


def get_performance_stats() -> Dict[str, Any]:
    """Get performance statistics"""
    if PERFORMANCE_ENGINE_AVAILABLE:
        from .performance_engine import get_performance_stats as get_stats
        return get_stats()
    else:
        return {'error': 'Performance engine not available'}


# ===== EXPORT ALL TUSKLANG FEATURES =====

# Export all TuskLang SDK features for direct access
if TUSK_AVAILABLE:
    __all__ = [
        'FlaskTSK', 'get_tsk',
        'tsk_config', 'tsk_section', 'tsk_function', 'tsk_parse', 'tsk_stringify',
        'render_turbo_template', 'render_turbo_template_async', 'get_performance_stats',
        'optimize_flask_app',
        # TuskLang SDK exports
        'TSK', 'parse', 'stringify', 'load_from_peanut', 'save', 'load',
        'parse_enhanced', 'parse_with_comments', 'TSKParser', 'ShellStorage',
        'TUSK_AVAILABLE', 'TUSK_VERSION', 'PERFORMANCE_ENGINE_AVAILABLE'
    ]
else:
    __all__ = [
        'FlaskTSK', 'get_tsk',
        'tsk_config', 'tsk_section', 'tsk_function', 'tsk_parse', 'tsk_stringify',
        'render_turbo_template', 'render_turbo_template_async', 'get_performance_stats',
        'optimize_flask_app',
        'TUSK_AVAILABLE', 'TUSK_VERSION', 'PERFORMANCE_ENGINE_AVAILABLE'
    ] 