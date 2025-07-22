# Elmer - The Patchwork Theme Analyzer (Python Edition)

## 🐘 Overview

Elmer is the Theme Analyzer component of Flask-TSK, inspired by the colorful patchwork elephant who celebrates diversity and creativity. Just as Elmer's unique patchwork appearance makes him special, this theme analyzer combines different colors, patterns, and elements to create beautiful, harmonious themes that embrace diversity and find beauty in the combination of different elements.

## 🎨 Features

### Core Theme Analysis
- **AI-Powered Generation**: Claude integration for intelligent theme creation
- **Color Harmony Analysis**: Detect and optimize color relationships
- **Brand Color Extraction**: Extract themes from images and logos
- **Cultural Theme Creation**: Generate themes based on cultural aesthetics
- **Weather-Based Adaptation**: Adapt themes to weather conditions
- **Accessibility Optimization**: Support for color blindness and low vision
- **3D Color Space Visualization**: Advanced color space analysis
- **Historical Period Themes**: Recreate themes from different eras
- **Biometric Theme Generation**: Create themes from physiological data
- **Sound-to-Color Mapping**: Generate themes from audio data
- **Time-Evolving Themes**: Themes that change throughout the day

### Color Harmony Types
- **Complementary**: Colors opposite on the color wheel
- **Analogous**: Colors adjacent on the color wheel
- **Triadic**: Three colors equally spaced on the color wheel
- **Tetradic**: Four colors forming a rectangle on the color wheel
- **Split Complementary**: One base color with two adjacent to its complement
- **Monochromatic**: Variations of a single color

### Theme Moods
- **Happy**: Bright, cheerful colors
- **Sad**: Muted, melancholic colors
- **Calm**: Soft, peaceful colors
- **Energetic**: Vibrant, dynamic colors
- **Professional**: Clean, business-like colors
- **Playful**: Fun, whimsical colors
- **Mysterious**: Dark, enigmatic colors
- **Warm**: Red, orange, yellow tones
- **Cool**: Blue, green, purple tones

## 🚀 Installation & Setup

### 1. Basic Installation
```python
from elephants.py_ele.elmer import Elmer

# Initialize Elmer
elmer = Elmer()
```

### 2. Flask-TSK Integration
```python
from flask import Flask
from elephants.py_ele.elmer import init_elmer

app = Flask(__name__)
elmer = init_elmer(app, claude_api_key="your-api-key")
```

### 3. Dependencies
```bash
pip install pillow numpy
```

## 📚 Usage Examples

### AI-Powered Theme Generation
```python
# Generate theme using Claude AI
prompt = "Create a modern, professional theme for a tech startup"
context = {
    'industry': 'technology',
    'target_audience': 'professionals',
    'mood': 'professional'
}

theme = elmer.generate_claude_theme(prompt, context)
print(f"Generated theme: {theme.name}")
print(f"Primary colors: {[p.hex_color for p in theme.primary_colors]}")
```

### Brand Color Extraction
```python
# Extract colors from company logo
result = elmer.extract_brand_colors('path/to/logo.png', {
    'color_count': 5,
    'min_contrast': 4.5
})

if result['success']:
    print(f"Dominant colors: {result['dominant_colors']}")
    print(f"Harmony type: {result['color_analysis']['harmony']}")
    print(f"Accessibility score: {result['accessibility_score']}")
```

### Cultural Theme Creation
```python
# Create theme based on Japanese aesthetics
theme = elmer.create_cultural_theme('japanese', {
    'base_color': '#d32f2f',
    'include_neutrals': True
})

print(f"Cultural theme: {theme.name}")
print(f"Cultural context: {theme.cultural_context}")
print(f"Inspiration: {theme.metadata['inspiration']}")
```

### Weather-Based Themes
```python
# Create theme that adapts to weather
theme = elmer.create_weather_theme('New York', {
    'include_forecast': True,
    'adapt_to_time': True
})

print(f"Weather theme: {theme.name}")
print(f"Weather adapted: {theme.weather_adapted}")
print(f"Weather data: {theme.metadata['weather_data']}")
```

### Evolving Themes
```python
# Create theme that changes throughout the day
theme = elmer.create_evolving_theme('daily_evolution', '#2196f3')

print(f"Evolving theme: {theme.name}")
print(f"Time aware: {theme.time_aware}")
print(f"Evolution schedule: {theme.metadata['evolution_schedule']}")
```

### Sound-to-Color Mapping
```python
# Generate theme from audio file
with open('audio_sample.wav', 'rb') as f:
    audio_data = f.read()

theme = elmer.generate_from_sound(audio_data, {
    'frequency_analysis': True,
    'amplitude_weighting': True
})

print(f"Audio theme: {theme.name}")
print(f"Frequency range: {theme.metadata['frequency_range']}")
```

### Historical Period Themes
```python
# Create Art Deco theme
theme = elmer.create_historical_theme('art_deco', {
    'include_patterns': True,
    'geometric_elements': True
})

print(f"Historical theme: {theme.name}")
print(f"Period: {theme.metadata['period']}")
print(f"Description: {theme.metadata['inspiration']}")
```

### Biometric Theme Generation
```python
# Create theme based on user's biometric data
biometric_data = {
    'heart_rate': 75,
    'stress_level': 0.3,
    'energy_level': 0.8
}

theme = elmer.create_biometric_theme(biometric_data, {
    'real_time': True,
    'adaptive': True
})

print(f"Biometric theme: {theme.name}")
print(f"Heart rate: {theme.metadata['heart_rate']}")
print(f"Stress level: {theme.metadata['stress_level']}")
```

### Accessibility Optimization
```python
# Optimize theme for color blindness
result = elmer.simulate_vision_condition('my_theme', 'color_blindness')

if result['success']:
    print("Original accessibility score:", result['original_theme']['accessibility_score'])
    print("Optimized accessibility score:", result['optimized_theme']['accessibility_score'])
```

### 3D Color Space Visualization
```python
# Generate 3D color space data
result = elmer.generate_3d_color_space('my_theme')

if result['success']:
    print(f"Color points: {len(result['color_points'])}")
    print(f"Space bounds: {result['space_bounds']}")
    
    # Use this data for 3D visualization
    for point in result['color_points']:
        print(f"Color {point['color']} at ({point['x']}, {point['y']}, {point['z']})")
```

### Theme Sharing
```python
# Share theme with metadata
result = elmer.share_theme('my_theme', {
    'description': 'Modern tech startup theme',
    'tags': ['professional', 'modern', 'tech'],
    'author': 'Design Team'
})

if result['success']:
    print(f"Share ID: {result['share_id']}")
    print(f"Share URL: {result['share_url']}")
```

## 🎯 Color Analysis Features

### Harmony Detection
```python
# Analyze color harmony
colors = ['#ff0000', '#00ff00', '#0000ff']
analysis = elmer._analyze_color_relationships(colors)

print(f"Harmony type: {analysis['harmony']}")
print(f"Color temperature: {analysis['temperature']}")
print(f"Diversity score: {analysis['diversity_score']}")
```

### Mood Detection
```python
# Detect mood from color
mood = elmer._detect_mood('#ffeb3b')
print(f"Color mood: {mood.value}")
```

### Accessibility Scoring
```python
# Calculate accessibility score
score = elmer._calculate_theme_accessibility(theme.primary_colors)
print(f"Accessibility score: {score}")
```

## 🌍 Cultural Theme Library

### Available Cultures
- **Japanese**: Traditional Japanese aesthetics with red, blue, and green
- **Indian**: Vibrant Indian culture with orange, red, and purple
- **Nordic**: Clean Nordic design with blue, green, and white
- **Mediterranean**: Warm Mediterranean colors with blue, green, and orange

### Usage
```python
# List available cultures
cultures = list(elmer.cultural_library.keys())
print(f"Available cultures: {cultures}")

# Create theme for specific culture
theme = elmer.create_cultural_theme('japanese')
```

## 📅 Historical Theme Library

### Available Periods
- **Art Deco**: Bold geometric patterns with strong contrasts
- **Victorian**: Rich, dark colors with ornate details
- **Bauhaus**: Primary colors with geometric simplicity
- **Psychedelic**: Vibrant, saturated colors of the 1960s

### Usage
```python
# List available periods
periods = list(elmer.historical_palettes.keys())
print(f"Available periods: {periods}")

# Create historical theme
theme = elmer.create_historical_theme('art_deco')
```

## 🔧 Configuration Options

### Claude AI Integration
```python
# Initialize with Claude API key
elmer = Elmer(claude_api_key="your-claude-api-key")

# Generate AI-powered themes
theme = elmer.generate_claude_theme("Create a calming nature theme")
```

### Color Patch Configuration
```python
# Access color patches
patches = elmer.patches
print(f"Available patches: {len(patches)}")

# Get random patch
random_patch = elmer._get_random_patch()
print(f"Random color: {random_patch.hex_color}")
```

## 🎨 Color Conversion Utilities

### RGB to Hex
```python
rgb = (255, 0, 0)
hex_color = elmer._rgb_to_hex(rgb)
print(f"RGB {rgb} = Hex {hex_color}")
```

### Hex to HSL
```python
hex_color = '#ff0000'
hsl = elmer._hex_to_hsl(hex_color)
print(f"Hex {hex_color} = HSL {hsl}")
```

### Color Manipulation
```python
# Lighten color
lightened = elmer._lighten('#ff0000', 20)
print(f"Lightened: {lightened}")

# Darken color
darkened = elmer._darken('#ff0000', 20)
print(f"Darkened: {darkened}")
```

## 🔐 Accessibility Features

### Color Blindness Support
```python
# Optimize for color blindness
optimized_patches = elmer._optimize_for_color_blindness(theme.primary_colors)

for patch in optimized_patches:
    print(f"Optimized color: {patch.hex_color}")
```

### Contrast Ratio Checking
```python
# Ensure minimum contrast
foreground = '#000000'
background = '#ffffff'
adjusted = elmer._ensure_contrast(foreground, background, 4.5)
print(f"Adjusted color: {adjusted}")
```

## 📊 Performance Monitoring

### Theme Analysis Metrics
```python
# Analyze theme performance
theme = elmer.create_theme('test_theme')

print(f"Primary colors: {len(theme.primary_colors)}")
print(f"Secondary colors: {len(theme.secondary_colors)}")
print(f"Accessibility score: {theme.accessibility_score}")
print(f"Harmony type: {theme.harmony_type.value}")
print(f"Mood: {theme.mood.value}")
```

### Color Diversity Analysis
```python
# Calculate color diversity
colors = ['#ff0000', '#00ff00', '#0000ff']
diversity = elmer._calculate_diversity(colors)
print(f"Color diversity: {diversity}")
```

## 🐛 Debugging and Logging

### Theme Generation Debugging
```python
import logging

# Enable debug logging
logging.getLogger('elmer').setLevel(logging.DEBUG)

# Generate theme with debug info
theme = elmer.generate_claude_theme("Debug theme generation")
```

### Error Handling
```python
try:
    theme = elmer.extract_brand_colors('nonexistent.png')
    if not theme['success']:
        print(f"Error: {theme['error']}")
except Exception as e:
    print(f"Exception: {e}")
```

## 🔮 Advanced Usage

### Custom Color Patches
```python
# Create custom color patch
custom_patch = elmer._create_color_patch('#ff6b6b', 'custom')
print(f"Custom patch: {custom_patch.hex_color}")
print(f"Usage: {custom_patch.usage}")
print(f"Accessibility: {custom_patch.accessibility_score}")
```

### Theme Metadata Management
```python
# Add custom metadata
theme.metadata.update({
    'custom_field': 'custom_value',
    'version': '1.0.0',
    'created_by': 'user123'
})

# Access metadata
print(f"Custom field: {theme.metadata['custom_field']}")
```

### Batch Theme Generation
```python
# Generate multiple themes
themes = []
for culture in ['japanese', 'indian', 'nordic']:
    theme = elmer.create_cultural_theme(culture)
    themes.append(theme)

print(f"Generated {len(themes)} cultural themes")
```

## 🎯 Best Practices

### Theme Creation
1. **Start with Brand Colors**: Extract colors from existing brand assets
2. **Consider Cultural Context**: Use cultural themes for international audiences
3. **Optimize for Accessibility**: Ensure color contrast meets WCAG guidelines
4. **Test Across Devices**: Verify themes work on different screens and devices

### Color Harmony
1. **Use Complementary Colors**: For high contrast and visual impact
2. **Apply Analogous Colors**: For harmonious, calming designs
3. **Consider Triadic Colors**: For balanced, dynamic designs
4. **Test Color Blindness**: Ensure accessibility for all users

### Performance
1. **Cache Generated Themes**: Store themes for reuse
2. **Optimize Image Processing**: Use appropriate image sizes for analysis
3. **Batch Operations**: Process multiple themes together when possible

## 🔮 Future Enhancements

### Planned Features
- **Advanced AI Integration**: More sophisticated Claude prompts and responses
- **Real-time Weather Integration**: Live weather data for dynamic themes
- **Machine Learning**: Learn from user preferences and behavior
- **Advanced Color Spaces**: Support for more color space conversions
- **Pattern Generation**: Create repeating patterns from themes
- **Animation Support**: Animated theme transitions

### Integration Opportunities
- **Design Tools**: Figma, Sketch, Adobe Creative Suite integration
- **Web Frameworks**: React, Vue, Angular theme generation
- **Mobile Apps**: iOS and Android theme generation
- **Design Systems**: Automated design system theme creation

## 📖 Conclusion

Elmer brings the same creativity and diversity that the patchwork elephant brings to the herd. With its comprehensive color analysis, AI-powered generation, cultural awareness, and accessibility features, Elmer provides the tools needed to create beautiful, harmonious themes that celebrate diversity and find beauty in the combination of different elements.

Whether you're creating themes for web applications, mobile apps, or design systems, Elmer provides the intelligence and creativity needed to craft themes that are both beautiful and functional.

*"Elmer is different. Elmer is patchwork. The grey elephants all love Elmer because he is not grey like them."* 