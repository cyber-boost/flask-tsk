"""
Flask-TSK Elephant Integration Example
=====================================
"Complete example of elephant herd integration"
Demonstrates how to use all 12 elephants in a Flask-TSK application
Strong. Secure. Scalable. 🐘
"""

from flask import Flask, request, jsonify, render_template_string
from tsk_flask import TSKFlask, init_elephants
import time
from datetime import datetime

# Create Flask app
app = Flask(__name__)
app.config['SECRET_KEY'] = 'your-secret-key-here'

# Initialize Flask-TSK
tsk_flask = TSKFlask(app)

# Initialize elephant herd
init_elephants(app)

# Example routes demonstrating elephant usage
@app.route('/')
def home():
    """Home page with elephant showcase"""
    return render_template_string("""
    <!DOCTYPE html>
    <html>
    <head>
        <title>🐘 Flask-TSK Elephant Example</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 40px; }
            .elephant { margin: 20px 0; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
            .btn { padding: 10px 20px; margin: 5px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
            .btn:hover { background: #0056b3; }
        </style>
    </head>
    <body>
        <h1>🐘 Flask-TSK Elephant Integration Example</h1>
        <p>This example demonstrates all 12 elephants working together in Flask-TSK.</p>
        
        <div class="elephant">
            <h2>👑 Babar - Content Management</h2>
            <p>Create and manage content with the royal CMS.</p>
            <a href="/demo/babar" class="btn">Try Babar</a>
        </div>
        
        <div class="elephant">
            <h2>🦅 Dumbo - HTTP Operations</h2>
            <p>Make HTTP requests with graceful flying.</p>
            <a href="/demo/dumbo" class="btn">Try Dumbo</a>
        </div>
        
        <div class="elephant">
            <h2>🎨 Elmer - Theme Generation</h2>
            <p>Generate beautiful themes with AI assistance.</p>
            <a href="/demo/elmer" class="btn">Try Elmer</a>
        </div>
        
        <div class="elephant">
            <h2>😊 Happy - Image Processing</h2>
            <p>Apply emotional filters to images.</p>
            <a href="/demo/happy" class="btn">Try Happy</a>
        </div>
        
        <div class="elephant">
            <h2>🔍 Heffalump - Search</h2>
            <p>Fuzzy search with intelligent suggestions.</p>
            <a href="/demo/heffalump" class="btn">Try Heffalump</a>
        </div>
        
        <div class="elephant">
            <h2>⚙️ Horton - Job Processing</h2>
            <p>Background job processing and management.</p>
            <a href="/demo/horton" class="btn">Try Horton</a>
        </div>
        
        <div class="elephant">
            <h2>📁 Jumbo - File Upload</h2>
            <p>Handle large file uploads with chunking.</p>
            <a href="/demo/jumbo" class="btn">Try Jumbo</a>
        </div>
        
        <div class="elephant">
            <h2>🛡️ Kaavan - System Monitoring</h2>
            <p>Monitor system health and create backups.</p>
            <a href="/demo/kaavan" class="btn">Try Kaavan</a>
        </div>
        
        <div class="elephant">
            <h2>🎵 Koshik - Audio & Notifications</h2>
            <p>Text-to-speech and notification sounds.</p>
            <a href="/demo/koshik" class="btn">Try Koshik</a>
        </div>
        
        <div class="elephant">
            <h2>🔒 Satao - Security</h2>
            <p>Security monitoring and threat detection.</p>
            <a href="/demo/satao" class="btn">Try Satao</a>
        </div>
        
        <div class="elephant">
            <h2>📦 Stampy - Package Management</h2>
            <p>Install and manage applications.</p>
            <a href="/demo/stampy" class="btn">Try Stampy</a>
        </div>
        
        <div class="elephant">
            <h2>🗄️ Tantor - Database</h2>
            <p>Database operations and management.</p>
            <a href="/demo/tantor" class="btn">Try Tantor</a>
        </div>
        
        <div class="elephant">
            <h2>🎪 Complete Showcase</h2>
            <p>Interactive showcase of all elephants.</p>
            <a href="/showcase" class="btn">View Showcase</a>
            <a href="/api/elephants/status" class="btn">API Status</a>
        </div>
    </body>
    </html>
    """)

# Babar Demo
@app.route('/demo/babar')
def babar_demo():
    """Babar CMS demonstration"""
    from tsk_flask.elephants import get_babar_cms
    
    babar = get_babar_cms()
    if not babar:
        return jsonify({'error': 'Babar not available'}), 503
    
    # Create sample content
    content_data = {
        'title': 'Welcome to the Elephant Kingdom',
        'content': 'In the great forest, a little elephant is born. His name is Babar.',
        'type': 'page',
        'language': 'en'
    }
    
    result = babar.create_story(content_data)
    
    return jsonify({
        'elephant': 'Babar',
        'demo': 'Content Creation',
        'result': result
    })

# Dumbo Demo
@app.route('/demo/dumbo')
def dumbo_demo():
    """Dumbo HTTP demonstration"""
    from tsk_flask.elephants import get_dumbo_http
    
    dumbo = get_dumbo_http()
    if not dumbo:
        return jsonify({'error': 'Dumbo not available'}), 503
    
    # Make a test HTTP request
    response = dumbo.get('https://httpbin.org/get')
    
    return jsonify({
        'elephant': 'Dumbo',
        'demo': 'HTTP Request',
        'status_code': response.status_code,
        'response_time': response.elapsed_time
    })

# Elmer Demo
@app.route('/demo/elmer')
def elmer_demo():
    """Elmer theme demonstration"""
    from tsk_flask.elephants import get_elmer_theme
    
    elmer = get_elmer_theme()
    if not elmer:
        return jsonify({'error': 'Elmer not available'}), 503
    
    # Create a cultural theme
    theme = elmer.create_cultural_theme('japanese')
    
    return jsonify({
        'elephant': 'Elmer',
        'demo': 'Theme Generation',
        'theme_name': theme.name,
        'primary_colors': [patch.hex_color for patch in theme.primary_colors],
        'mood': theme.mood.value
    })

# Happy Demo
@app.route('/demo/happy')
def happy_demo():
    """Happy image demonstration"""
    from tsk_flask.elephants import get_happy_image
    
    happy = get_happy_image()
    if not happy:
        return jsonify({'error': 'Happy not available'}), 503
    
    # Get Happy's stats
    stats = happy.get_stats()
    
    return jsonify({
        'elephant': 'Happy',
        'demo': 'Image Processing Stats',
        'stats': stats
    })

# Heffalump Demo
@app.route('/demo/heffalump')
def heffalump_demo():
    """Heffalump search demonstration"""
    from tsk_flask.elephants import get_heffalump_search
    
    heffalump = get_heffalump_search()
    if not heffalump:
        return jsonify({'error': 'Heffalump not available'}), 503
    
    # Index some sample content
    heffalump.index('1', 'elephant kingdom forest babar')
    heffalump.index('2', 'dumbo flying magic feather')
    heffalump.index('3', 'elmer patchwork colorful theme')
    
    # Search
    results = heffalump.hunt('elephant')
    
    return jsonify({
        'elephant': 'Heffalump',
        'demo': 'Fuzzy Search',
        'query': 'elephant',
        'results_count': len(results),
        'results': [
            {
                'id': result.id,
                'content': result.content,
                'score': result.score
            }
            for result in results
        ]
    })

# Horton Demo
@app.route('/demo/horton')
def horton_demo():
    """Horton job demonstration"""
    from tsk_flask.elephants import get_horton_jobs
    
    horton = get_horton_jobs()
    if not horton:
        return jsonify({'error': 'Horton not available'}), 503
    
    # Dispatch a test job
    job_id = horton.dispatch('test_job', {'message': 'Hello from Horton!'})
    
    # Get job status
    status = horton.status(job_id)
    
    return jsonify({
        'elephant': 'Horton',
        'demo': 'Job Processing',
        'job_id': job_id,
        'status': status
    })

# Jumbo Demo
@app.route('/demo/jumbo')
def jumbo_demo():
    """Jumbo upload demonstration"""
    from tsk_flask.elephants import get_jumbo_upload
    
    jumbo = get_jumbo_upload()
    if not jumbo:
        return jsonify({'error': 'Jumbo not available'}), 503
    
    # Get upload statistics
    stats = jumbo.get_statistics()
    
    return jsonify({
        'elephant': 'Jumbo',
        'demo': 'File Upload Stats',
        'stats': stats
    })

# Kaavan Demo
@app.route('/demo/kaavan')
def kaavan_demo():
    """Kaavan monitoring demonstration"""
    from tsk_flask.elephants import get_kaavan_monitor
    
    kaavan = get_kaavan_monitor()
    if not kaavan:
        return jsonify({'error': 'Kaavan not available'}), 503
    
    # Watch system
    watch_result = kaavan.watch()
    
    return jsonify({
        'elephant': 'Kaavan',
        'demo': 'System Monitoring',
        'watch_result': watch_result
    })

# Koshik Demo
@app.route('/demo/koshik')
def koshik_demo():
    """Koshik audio demonstration"""
    from tsk_flask.elephants import get_koshik_audio
    
    koshik = get_koshik_audio()
    if not koshik:
        return jsonify({'error': 'Koshik not available'}), 503
    
    # Get vocabulary stats
    vocab_stats = koshik.get_vocabulary_stats()
    
    return jsonify({
        'elephant': 'Koshik',
        'demo': 'Audio & Notifications',
        'vocabulary_stats': vocab_stats
    })

# Satao Demo
@app.route('/demo/satao')
def satao_demo():
    """Satao security demonstration"""
    from tsk_flask.elephants import get_satao_security
    
    satao = get_satao_security()
    if not satao:
        return jsonify({'error': 'Satao not available'}), 503
    
    # Get protection status
    protection_status = satao.get_protection_status()
    
    return jsonify({
        'elephant': 'Satao',
        'demo': 'Security & Protection',
        'protection_status': protection_status
    })

# Stampy Demo
@app.route('/demo/stampy')
def stampy_demo():
    """Stampy package demonstration"""
    from tsk_flask.elephants import get_stampy_packages
    
    stampy = get_stampy_packages()
    if not stampy:
        return jsonify({'error': 'Stampy not available'}), 503
    
    # Get app catalog
    catalog = stampy.catalog()
    
    return jsonify({
        'elephant': 'Stampy',
        'demo': 'Package Management',
        'catalog_count': len(catalog) if catalog else 0
    })

# Tantor Demo
@app.route('/demo/tantor')
def tantor_demo():
    """Tantor database demonstration"""
    from tsk_flask.elephants import get_tantor_database
    
    tantor = get_tantor_database()
    if not tantor:
        return jsonify({'error': 'Tantor not available'}), 503
    
    # Get database stats
    stats = tantor.stats()
    
    return jsonify({
        'elephant': 'Tantor',
        'demo': 'Database Operations',
        'stats': stats
    })

# Complete elephant showcase
@app.route('/api/elephants/complete-demo')
def complete_elephant_demo():
    """Complete demonstration of all elephants working together"""
    from tsk_flask.elephants import showcase_elephant_capabilities
    
    # Get all elephant capabilities
    capabilities = showcase_elephant_capabilities()
    
    # Run a comprehensive demo
    demo_results = {
        'timestamp': datetime.now().isoformat(),
        'total_elephants': 12,
        'capabilities': capabilities,
        'integration_status': 'complete'
    }
    
    return jsonify({
        'success': True,
        'message': 'Complete elephant herd demonstration',
        'data': demo_results
    })

if __name__ == '__main__':
    print("🐘 Starting Flask-TSK Elephant Integration Example...")
    print("📱 Access the application at: http://localhost:5000")
    print("🎪 View the showcase at: http://localhost:5000/showcase")
    print("🔧 API endpoints available at: /api/elephants/*")
    
    app.run(debug=True, host='0.0.0.0', port=5000) 