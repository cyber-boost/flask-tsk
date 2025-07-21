"""
<?tusk> TuskPython Tai - The Video Handler
=======================================

🐘 BACKSTORY: Tai - The Gentle Giant
-----------------------------------
Tai is a famous Asian elephant who appeared in many Hollywood films,
including "Water for Elephants" and "The Zookeeper." She was known for
her gentle nature, intelligence, and ability to perform complex tasks
with grace and precision. Tai could paint, play musical instruments,
and even act in movies - showing remarkable adaptability and skill.

WHY THIS NAME: Like Tai who could handle any task with elegance and
precision, this video handler manages all aspects of video processing,
embedding, and delivery with the same gentle efficiency. Tai was a
master of her craft, and this system handles video content with the
same level of expertise and care.

FEATURES:
- Multi-platform video embedding (YouTube, Vimeo, etc.)
- Video processing and optimization
- Lazy loading and performance optimization
- Analytics and tracking
- Custom player controls
- Video galleries and playlists
- AI-powered video analysis
- Streaming and live video support

@package TuskPython\Elephants
@author  TuskPython Team
@since   1.0.0
"""

import re
import json
import hashlib
import time
from typing import Dict, List, Optional, Any, Tuple
from dataclasses import dataclass, asdict
from urllib.parse import urlparse, parse_qs
import requests
from flask import current_app, request, jsonify
import yaml


@dataclass
class VideoData:
    """Represents video metadata and configuration"""
    url: str
    platform: str
    video_id: str
    title: str = ""
    description: str = ""
    thumbnail: str = ""
    duration: int = 0
    width: int = 640
    height: int = 360
    autoplay: bool = False
    controls: bool = True
    loop: bool = False
    muted: bool = False
    preload: str = "metadata"


@dataclass
class EmbedOptions:
    """Configuration options for video embedding"""
    width: int = 640
    height: int = 360
    autoplay: bool = False
    controls: bool = True
    loop: bool = False
    muted: bool = False
    preload: str = "metadata"
    responsive: bool = True
    lazy_load: bool = False
    custom_css: str = ""
    custom_js: str = ""


class Tai:
    """
    Tai - The Video Handler
    
    Like Tai who could handle any task with elegance and precision,
    this class manages all aspects of video processing, embedding,
    and delivery with the same gentle efficiency.
    """
    
    def __init__(self, app=None):
        self.supported_platforms = {}
        self.default_options = {}
        self.analytics_enabled = False
        self.ai_services = {}
        
        # Initialize with Flask app if provided
        if app is not None:
            self.init_app(app)
    
    def init_app(self, app):
        """Initialize Tai with Flask app"""
        self.app = app
        
        # Load configuration
        self.load_config()
        
        # Setup supported platforms
        self.setup_supported_platforms()
        
        # Setup default options
        self.setup_default_options()
        
        # Register routes if needed
        self.register_routes()
    
    def load_config(self):
        """Load Tai configuration"""
        config = getattr(self.app, 'config', {})
        
        self.analytics_enabled = config.get('TAI_ANALYTICS_ENABLED', False)
        self.ai_services = config.get('TAI_AI_SERVICES', {})
        
        # Load from .peanuts file if available
        peanuts_file = config.get('TAI_PEANUTS_FILE', '.peanuts')
        if os.path.exists(peanuts_file):
            try:
                with open(peanuts_file, 'r') as f:
                    peanuts_config = json.load(f)
                    video_config = peanuts_config.get('video', {})
                    self.analytics_enabled = video_config.get('analytics_enabled', self.analytics_enabled)
                    self.ai_services = video_config.get('ai_services', self.ai_services)
            except Exception as e:
                print(f"Tai: Could not load .peanuts config: {e}")
    
    def setup_supported_platforms(self):
        """Setup supported video platforms"""
        self.supported_platforms = {
            'youtube': {
                'patterns': [
                    r'(?:youtube\.com/watch\?v=|youtu\.be/|youtube\.com/embed/)([a-zA-Z0-9_-]{11})',
                    r'youtube\.com/watch\?.*v=([a-zA-Z0-9_-]{11})'
                ],
                'embed_url': 'https://www.youtube.com/embed/{video_id}',
                'thumbnail_url': 'https://img.youtube.com/vi/{video_id}/maxresdefault.jpg',
                'api_url': 'https://www.googleapis.com/youtube/v3/videos'
            },
            'vimeo': {
                'patterns': [
                    r'vimeo\.com/(\d+)',
                    r'player\.vimeo\.com/video/(\d+)'
                ],
                'embed_url': 'https://player.vimeo.com/video/{video_id}',
                'thumbnail_url': 'https://vumbnail.com/{video_id}.jpg',
                'api_url': 'https://api.vimeo.com/videos/{video_id}'
            },
            'dailymotion': {
                'patterns': [
                    r'dailymotion\.com/video/([a-zA-Z0-9]+)',
                    r'dailymotion\.com/embed/video/([a-zA-Z0-9]+)'
                ],
                'embed_url': 'https://www.dailymotion.com/embed/video/{video_id}',
                'thumbnail_url': 'https://www.dailymotion.com/thumbnail/video/{video_id}'
            },
            'twitch': {
                'patterns': [
                    r'twitch\.tv/videos/(\d+)',
                    r'twitch\.tv/([a-zA-Z0-9_]+)'
                ],
                'embed_url': 'https://player.twitch.tv/?video=v{video_id}',
                'thumbnail_url': 'https://static-cdn.jtvnw.net/previews-ttv/live_user_{video_id}.jpg'
            }
        }
    
    def setup_default_options(self):
        """Setup default embedding options"""
        self.default_options = EmbedOptions(
            width=640,
            height=360,
            autoplay=False,
            controls=True,
            loop=False,
            muted=False,
            preload="metadata",
            responsive=True,
            lazy_load=False
        )
    
    def register_routes(self):
        """Register Tai routes with Flask app"""
        @self.app.route('/api/tai/embed', methods=['POST'])
        def tai_embed():
            """API endpoint for video embedding"""
            data = request.get_json()
            video_url = data.get('url')
            options = data.get('options', {})
            
            if not video_url:
                return jsonify({'error': 'Video URL required'}), 400
            
            try:
                embed_html = self.action(video_url, options)
                return jsonify({'embed_html': embed_html})
            except Exception as e:
                return jsonify({'error': str(e)}), 400
        
        @self.app.route('/api/tai/metadata/<platform>/<video_id>')
        def tai_metadata(platform, video_id):
            """API endpoint for video metadata"""
            try:
                metadata = self.get_metadata(f"{platform}://{video_id}")
                return jsonify(metadata)
            except Exception as e:
                return jsonify({'error': str(e)}), 400
    
    def action(self, url: str, options: Dict = None) -> str:
        """
        Main video embedding action - Tai's gentle touch
        
        Args:
            url: Video URL to embed
            options: Embedding options
            
        Returns:
            HTML embed code
        """
        options = options or {}
        
        # Detect platform and extract video ID
        platform = self.detect_platform(url)
        if not platform:
            raise ValueError(f"Unsupported video platform: {url}")
        
        video_id = self.extract_video_id(url, platform)
        if not video_id:
            raise ValueError(f"Could not extract video ID from: {url}")
        
        # Merge options with defaults
        embed_options = EmbedOptions(**{**asdict(self.default_options), **options})
        
        # Generate embed HTML
        embed_html = self.generate_embed(platform, video_id, embed_options)
        
        # Add analytics if enabled
        if self.analytics_enabled:
            embed_html = self.add_analytics(embed_html, platform, video_id)
        
        return embed_html
    
    def detect_platform(self, url: str) -> Optional[str]:
        """Detect video platform from URL"""
        for platform, config in self.supported_platforms.items():
            for pattern in config['patterns']:
                if re.search(pattern, url):
                    return platform
        return None
    
    def extract_video_id(self, url: str, platform: str) -> Optional[str]:
        """Extract video ID from URL"""
        if platform not in self.supported_platforms:
            return None
        
        config = self.supported_platforms[platform]
        for pattern in config['patterns']:
            match = re.search(pattern, url)
            if match:
                return match.group(1)
        return None
    
    def generate_embed(self, platform: str, video_id: str, options: EmbedOptions) -> str:
        """Generate embed HTML for video"""
        if platform not in self.supported_platforms:
            raise ValueError(f"Unsupported platform: {platform}")
        
        config = self.supported_platforms[platform]
        embed_url = config['embed_url'].format(video_id=video_id)
        
        # Build query parameters
        params = []
        if options.autoplay:
            params.append('autoplay=1')
        if not options.controls:
            params.append('controls=0')
        if options.loop:
            params.append('loop=1')
        if options.muted:
            params.append('muted=1')
        
        if params:
            embed_url += '?' + '&'.join(params)
        
        # Generate responsive wrapper
        if options.responsive:
            wrapper_class = "video-responsive"
            wrapper_style = """
                position: relative;
                padding-bottom: 56.25%; /* 16:9 aspect ratio */
                height: 0;
                overflow: hidden;
                max-width: 100%;
            """
        else:
            wrapper_class = ""
            wrapper_style = ""
        
        # Generate iframe
        iframe_attrs = {
            'src': embed_url,
            'width': options.width,
            'height': options.height,
            'frameborder': '0',
            'allowfullscreen': 'true',
            'allow': 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture'
        }
        
        if options.responsive:
            iframe_attrs['style'] = """
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            """
        
        # Build iframe HTML
        iframe_html = '<iframe'
        for attr, value in iframe_attrs.items():
            if value is not None:
                iframe_html += f' {attr}="{value}"'
        iframe_html += '></iframe>'
        
        # Build final HTML
        html = f'<div class="{wrapper_class}" style="{wrapper_style}">'
        html += iframe_html
        html += '</div>'
        
        # Add custom CSS and JS
        if options.custom_css:
            html += f'<style>{options.custom_css}</style>'
        
        if options.custom_js:
            html += f'<script>{options.custom_js}</script>'
        
        return html
    
    def lazy_action(self, url: str, options: Dict = None) -> str:
        """Generate lazy-loaded video embed"""
        options = options or {}
        options['lazy_load'] = True
        
        # Generate unique ID for this video
        video_hash = hashlib.md5(url.encode()).hexdigest()[:8]
        lazy_id = f"tai_lazy_{video_hash}"
        
        # Generate placeholder
        placeholder_html = f'''
        <div id="{lazy_id}" class="tai-lazy-video" style="
            width: {options.get('width', 640)}px;
            height: {options.get('height', 360)}px;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        ">
            <div style="text-align: center;">
                <div style="font-size: 48px; margin-bottom: 10px;">▶️</div>
                <div>Click to load video</div>
            </div>
        </div>
        '''
        
        # Generate lazy load script
        script = self.generate_lazy_load_script(lazy_id, url, options)
        
        return placeholder_html + script
    
    def generate_lazy_load_script(self, lazy_id: str, url: str, options: Dict) -> str:
        """Generate JavaScript for lazy loading"""
        return f'''
        <script>
        (function() {{
            const container = document.getElementById('{lazy_id}');
            if (!container) return;
            
            let loaded = false;
            
            function loadVideo() {{
                if (loaded) return;
                loaded = true;
                
                // Load the video embed
                fetch('/api/tai/embed', {{
                    method: 'POST',
                    headers: {{
                        'Content-Type': 'application/json',
                    }},
                    body: JSON.stringify({{
                        url: '{url}',
                        options: {json.dumps(options)}
                    }})
                }})
                .then(response => response.json())
                .then(data => {{
                    if (data.embed_html) {{
                        container.innerHTML = data.embed_html;
                    }}
                }})
                .catch(error => {{
                    console.error('Failed to load video:', error);
                    container.innerHTML = '<div style="color: red;">Failed to load video</div>';
                }});
            }}
            
            // Load on click
            container.addEventListener('click', loadVideo);
            
            // Load on scroll into view (optional)
            if ('IntersectionObserver' in window) {{
                const observer = new IntersectionObserver((entries) => {{
                    entries.forEach(entry => {{
                        if (entry.isIntersecting) {{
                            loadVideo();
                            observer.unobserve(entry.target);
                        }}
                    }});
                }});
                observer.observe(container);
            }}
        }})();
        </script>
        '''
    
    def playlist(self, videos: List[str], options: Dict = None) -> str:
        """Generate video playlist"""
        options = options or {}
        playlist_id = f"tai_playlist_{hashlib.md5(str(videos).encode()).hexdigest()[:8]}"
        
        # Generate playlist HTML
        html = f'<div id="{playlist_id}" class="tai-playlist">'
        html += '<div class="tai-playlist-main">'
        html += '<div class="tai-playlist-video"></div>'
        html += '</div>'
        html += '<div class="tai-playlist-thumbnails">'
        
        for i, video_url in enumerate(videos):
            platform = self.detect_platform(video_url)
            video_id = self.extract_video_id(video_url, platform)
            
            if platform and video_id:
                thumbnail_url = self.get_thumbnail_url(platform, video_id)
                html += f'''
                <div class="tai-playlist-item" data-video="{video_url}" data-index="{i}">
                    <img src="{thumbnail_url}" alt="Video {i+1}" style="width: 120px; height: 67px; object-fit: cover;">
                    <div class="tai-playlist-title">Video {i+1}</div>
                </div>
                '''
        
        html += '</div></div>'
        
        # Generate playlist script
        script = self.generate_playlist_script(playlist_id, videos, options)
        
        return html + script
    
    def generate_playlist_script(self, playlist_id: str, videos: List[str], options: Dict) -> str:
        """Generate JavaScript for video playlist"""
        return f'''
        <script>
        (function() {{
            const playlist = document.getElementById('{playlist_id}');
            if (!playlist) return;
            
            const videoContainer = playlist.querySelector('.tai-playlist-video');
            const items = playlist.querySelectorAll('.tai-playlist-item');
            let currentIndex = 0;
            
            function loadVideo(url) {{
                fetch('/api/tai/embed', {{
                    method: 'POST',
                    headers: {{
                        'Content-Type': 'application/json',
                    }},
                    body: JSON.stringify({{
                        url: url,
                        options: {json.dumps(options)}
                    }})
                }})
                .then(response => response.json())
                .then(data => {{
                    if (data.embed_html) {{
                        videoContainer.innerHTML = data.embed_html;
                    }}
                }})
                .catch(error => {{
                    console.error('Failed to load video:', error);
                }});
            }}
            
            // Load first video
            if (items.length > 0) {{
                loadVideo('{videos[0]}');
                items[0].classList.add('active');
            }}
            
            // Handle playlist item clicks
            items.forEach((item, index) => {{
                item.addEventListener('click', () => {{
                    const url = item.dataset.video;
                    if (url) {{
                        // Update active state
                        items.forEach(i => i.classList.remove('active'));
                        item.classList.add('active');
                        
                        // Load video
                        loadVideo(url);
                        currentIndex = index;
                    }}
                }});
            }});
        }})();
        </script>
        '''
    
    def get_metadata(self, url: str) -> Dict[str, Any]:
        """Get video metadata"""
        platform = self.detect_platform(url)
        video_id = self.extract_video_id(url, platform)
        
        if not platform or not video_id:
            raise ValueError(f"Could not extract metadata from: {url}")
        
        # Try to get metadata from platform API
        if platform == 'youtube' and self.ai_services.get('youtube_api_key'):
            return self.get_youtube_metadata(video_id)
        elif platform == 'vimeo' and self.ai_services.get('vimeo_access_token'):
            return self.get_vimeo_metadata(video_id)
        
        # Fallback to basic metadata
        return {
            'platform': platform,
            'video_id': video_id,
            'url': url,
            'thumbnail': self.get_thumbnail_url(platform, video_id),
            'embed_url': self.supported_platforms[platform]['embed_url'].format(video_id=video_id)
        }
    
    def get_youtube_metadata(self, video_id: str) -> Dict[str, Any]:
        """Get YouTube video metadata"""
        api_key = self.ai_services.get('youtube_api_key')
        if not api_key:
            raise ValueError("YouTube API key not configured")
        
        url = f"https://www.googleapis.com/youtube/v3/videos"
        params = {
            'part': 'snippet,contentDetails,statistics',
            'id': video_id,
            'key': api_key
        }
        
        try:
            response = requests.get(url, params=params)
            response.raise_for_status()
            data = response.json()
            
            if data['items']:
                item = data['items'][0]
                snippet = item['snippet']
                content_details = item['contentDetails']
                statistics = item['statistics']
                
                return {
                    'platform': 'youtube',
                    'video_id': video_id,
                    'title': snippet['title'],
                    'description': snippet['description'],
                    'thumbnail': snippet['thumbnails']['maxres']['url'],
                    'duration': self.parse_youtube_duration(content_details['duration']),
                    'view_count': int(statistics.get('viewCount', 0)),
                    'like_count': int(statistics.get('likeCount', 0)),
                    'published_at': snippet['publishedAt'],
                    'channel_title': snippet['channelTitle']
                }
        except Exception as e:
            print(f"Failed to get YouTube metadata: {e}")
        
        return self.get_metadata(f"youtube://{video_id}")
    
    def get_vimeo_metadata(self, video_id: str) -> Dict[str, Any]:
        """Get Vimeo video metadata"""
        access_token = self.ai_services.get('vimeo_access_token')
        if not access_token:
            raise ValueError("Vimeo access token not configured")
        
        url = f"https://api.vimeo.com/videos/{video_id