# 🎛️ Flask-TSK Layout Management System

**Easy Management for Headers, Footers, Navigation, and Layouts using Flask Templates**

## 📁 Layout Structure

```
tsk_flask/templates/layouts/
├── header.html      ← Header layout component
├── footer.html      ← Footer layout component  
├── navigation.html  ← Navigation layout component
└── README.md        ← This documentation
```

## 🧭 Navigation Management (`navigation.html`)

### Usage in Flask Routes:
```python
from flask import render_template

@app.route('/')
def index():
    navigation_items = [
        {'text': 'Home', 'url': '/', 'active': True, 'icon': 'fas fa-home'},
        {'text': 'About', 'url': '/about', 'icon': 'fas fa-info-circle'},
        {'text': 'Products', 'url': '/products', 'children': [
            {'text': 'Category 1', 'url': '/products/cat1'},
            {'text': 'Category 2', 'url': '/products/cat2'}
        ]},
        {'text': 'Contact', 'url': '/contact', 'icon': 'fas fa-envelope'}
    ]
    
    return render_template('index.html', navigation_items=navigation_items)
```

### Usage in Templates:
```html
{% include 'layouts/navigation.html' %}
```

### Available Options:
- `navigation_items` - List of navigation items
- `brand_text` - Brand/logo text
- `brand_logo` - Brand logo image URL
- `brand_url` - Brand link URL
- `theme` - Navigation theme (default, dark, light)
- `show_search` - Show search functionality
- `user_menu` - User menu configuration

## 🎯 Header Management (`header.html`)

### Usage in Flask Routes:
```python
@app.route('/')
def index():
    header_config = {
        'title': 'My Awesome App',
        'subtitle': 'Built with Flask-TSK',
        'show_search': True,
        'navigation_items': [
            {'text': 'Home', 'url': '/', 'active': True},
            {'text': 'About', 'url': '/about'}
        ]
    }
    
    return render_template('index.html', **header_config)
```

### Usage in Templates:
```html
{% include 'layouts/header.html' %}
```

### Available Options:
- `title` - Header title
- `subtitle` - Header subtitle
- `theme` - Header theme
- `show_search` - Show search bar
- `search_url` - Search form action URL
- `search_query` - Pre-filled search query
- `navigation_items` - Header navigation items

## 🦶 Footer Management (`footer.html`)

### Usage in Flask Routes:
```python
@app.route('/')
def index():
    footer_config = {
        'footer_links': [
            {'text': 'Privacy Policy', 'url': '/privacy'},
            {'text': 'Terms of Service', 'url': '/terms'},
            {'text': 'Contact', 'url': '/contact'}
        ],
        'social_links': [
            {'text': 'Twitter', 'url': 'https://twitter.com', 'icon': 'fab fa-twitter'},
            {'text': 'GitHub', 'url': 'https://github.com', 'icon': 'fab fa-github'}
        ],
        'contact_info': {
            'email': 'contact@example.com',
            'phone': '+1 (555) 123-4567',
            'address': '123 Main St, City, State 12345'
        },
        'copyright_text': '© 2024 My Awesome App. All rights reserved.'
    }
    
    return render_template('index.html', **footer_config)
```

### Usage in Templates:
```html
{% include 'layouts/footer.html' %}
```

### Available Options:
- `footer_links` - Quick links in footer
- `social_links` - Social media links
- `contact_info` - Contact information
- `footer_title` - Footer section title
- `social_title` - Social section title
- `contact_title` - Contact section title
- `copyright_text` - Copyright text
- `footer_bottom_links` - Bottom footer links
- `theme` - Footer theme

## 🚀 Complete Page Example

### Flask Route:
```python
from flask import Flask, render_template
from tsk_flask import FlaskTSK

app = Flask(__name__)
tsk = FlaskTSK(app)

@app.route('/')
def index():
    # Navigation configuration
    navigation_items = [
        {'text': 'Home', 'url': '/', 'active': True, 'icon': 'fas fa-home'},
        {'text': 'About', 'url': '/about', 'icon': 'fas fa-info-circle'},
        {'text': 'Products', 'url': '/products', 'children': [
            {'text': 'Category 1', 'url': '/products/cat1'},
            {'text': 'Category 2', 'url': '/products/cat2'}
        ]},
        {'text': 'Contact', 'url': '/contact', 'icon': 'fas fa-envelope'}
    ]
    
    # Header configuration
    header_config = {
        'title': 'Flask-TSK Demo',
        'subtitle': 'Revolutionary Flask Extension',
        'show_search': True,
        'navigation_items': navigation_items
    }
    
    # Footer configuration
    footer_config = {
        'footer_links': [
            {'text': 'Privacy Policy', 'url': '/privacy'},
            {'text': 'Terms of Service', 'url': '/terms'},
            {'text': 'Contact', 'url': '/contact'}
        ],
        'social_links': [
            {'text': 'Twitter', 'url': 'https://twitter.com', 'icon': 'fab fa-twitter'},
            {'text': 'GitHub', 'url': 'https://github.com', 'icon': 'fab fa-github'}
        ],
        'contact_info': {
            'email': 'contact@flask-tsk.com',
            'phone': '+1 (555) 123-4567'
        },
        'copyright_text': '© 2024 Flask-TSK. All rights reserved.'
    }
    
    return render_template('index.html', 
                         navigation_items=navigation_items,
                         **header_config,
                         **footer_config)
```

### Template (`index.html`):
```html
{% extends "base.html" %}

{% block content %}
<!-- Include navigation -->
{% include 'layouts/navigation.html' %}

<!-- Include header -->
{% include 'layouts/header.html' %}

<!-- Your page content here -->
<div class="container">
    <h1>Welcome to Flask-TSK</h1>
    <p>This is your main content area.</p>
</div>

<!-- Include footer -->
{% include 'layouts/footer.html' %}
{% endblock %}
```

## 🎨 Customization

### CSS Styling:
- All layout components use CSS classes for easy styling
- Theme support with `theme-{name}` classes
- Responsive design built-in
- Customizable via CSS variables

### JavaScript Functionality:
- Mobile menu toggle
- Search dropdown toggle
- User menu dropdown
- Dropdown navigation support

## 📋 Best Practices

1. **Consistent Configuration**: Use the same navigation/footer across all pages
2. **Template Inheritance**: Extend `base.html` for consistent structure
3. **Component Reuse**: Use `{% include %}` to include layout components
4. **Configuration Objects**: Pass configuration from Flask routes to templates
5. **Responsive Design**: All components are mobile-friendly

## 🔧 Advanced Usage

### Dynamic Navigation:
```python
def get_navigation_items(current_page):
    items = [
        {'text': 'Home', 'url': '/', 'icon': 'fas fa-home'},
        {'text': 'About', 'url': '/about', 'icon': 'fas fa-info-circle'},
        {'text': 'Products', 'url': '/products', 'icon': 'fas fa-shopping-cart'},
        {'text': 'Contact', 'url': '/contact', 'icon': 'fas fa-envelope'}
    ]
    
    # Mark current page as active
    for item in items:
        if item['url'] == current_page:
            item['active'] = True
            break
    
    return items

@app.route('/<path:page>')
def dynamic_page(page):
    navigation_items = get_navigation_items(f'/{page}')
    return render_template(f'{page}.html', navigation_items=navigation_items)
```

### User Menu Integration:
```python
@app.route('/dashboard')
def dashboard():
    user_menu = {
        'name': 'John Doe',
        'avatar': '/static/images/avatar.jpg',
        'items': [
            {'text': 'Profile', 'url': '/profile', 'icon': 'fas fa-user'},
            {'text': 'Settings', 'url': '/settings', 'icon': 'fas fa-cog'},
            {'text': 'Logout', 'url': '/logout', 'icon': 'fas fa-sign-out-alt'}
        ]
    }
    
    return render_template('dashboard.html', user_menu=user_menu)
```

---

**Flask-TSK Layout Management** - Making Flask development easier with organized, reusable layout components! 🚀 