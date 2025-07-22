# Babar - The Royal CMS (Python Edition)

## 🐘 Overview

Babar is the Content Management System (CMS) component of Flask-TSK, inspired by the beloved elephant king who brought civilization and order to the elephant kingdom. Just as King Babar transformed a jungle into the organized city of Celesteville, this CMS brings structure and elegance to content management.

## 🏛️ Features

### Core CMS Capabilities
- **Hierarchical Content Organization**: Like Celesteville's organized structure
- **Role-Based Access Control**: Integration with Herd permission system
- **Multi-Language Support**: Babar spoke French, so we support multiple languages
- **Version Control**: Complete content history and versioning
- **Workflow Management**: Draft → Review → Publish workflow
- **Rich Media Management**: Handle images, videos, and other media
- **SEO Optimization**: Meta tags, friendly URLs, and structured data
- **Component-Based Builder**: Modular page building system
- **Theme Integration**: Works with all 13 TuskPHP themes

### Content Types
- **Pages**: Static content pages
- **Posts**: Blog-style content
- **Articles**: Long-form content
- **Stories**: Narrative content
- **Components**: Reusable content blocks

### Status Management
- **Draft**: Work in progress
- **Published**: Live content
- **Archived**: Historical content
- **Deleted**: Soft-deleted content

## 🚀 Installation & Setup

### 1. Basic Installation
```python
from elephants.py_ele.babar import Babar

# Initialize Babar CMS
babar = Babar()
```

### 2. Flask-TSK Integration
```python
from flask import Flask
from elephants.py_ele.babar import init_babar

app = Flask(__name__)
babar = init_babar(app)
```

### 3. Database Setup
Babar automatically creates its database tables on initialization:
- `babar_content`: Main content storage
- `babar_versions`: Version history tracking

## 📚 Usage Examples

### Creating Content
```python
# Set current user (required for permissions)
babar.set_current_user({
    'id': 1,
    'role': 'admin',
    'capabilities': ['cms.create', 'cms.publish']
})

# Create a new story
story_data = {
    'title': 'Welcome to Celesteville',
    'content': 'In the great forest, a little elephant is born...',
    'type': 'page',
    'language': 'en',
    'template': 'welcome',
    'theme': 'tusk_modern'
}

result = babar.create_story(story_data)
if result['success']:
    print(f"Story created: {result['data']['id']}")
```

### Updating Content
```python
# Update existing content
update_data = {
    'title': 'Welcome to Celesteville - Updated',
    'content': 'Updated content here...',
    'meta_description': 'A magical place for elephants'
}

result = babar.update_story('story_abc123', update_data)
```

### Publishing Content
```python
# Publish content (requires cms.publish permission)
result = babar.publish('story_abc123')
if result['success']:
    print("🎺 Royal decree has been published!")
```

### Retrieving Content
```python
# Get content by ID
story = babar.get_story('story_abc123')

# Get content by slug
story = babar.get_story('welcome-to-celesteville')

# List content with filters
library = babar.get_library({
    'type': 'page',
    'status': 'published',
    'language': 'en',
    'page': 1,
    'per_page': 20
})
```

### Content Analytics
```python
# Get CMS analytics (requires cms.view_analytics permission)
analytics = babar.get_analytics()
print(f"Total content: {analytics['summary']['total_content']}")
print(f"Published: {analytics['summary']['published']}")
```

## 🔐 Permission System

Babar integrates with Flask-TSK's Herd permission system:

### Required Permissions
- `cms.view`: View CMS interface
- `cms.create`: Create new content
- `cms.edit`: Edit own content
- `cms.edit_others`: Edit others' content
- `cms.publish`: Publish content
- `cms.delete`: Delete content
- `cms.manage_media`: Manage media library
- `cms.view_analytics`: View analytics

### Permission Checks
```python
# Check if user can create content
if babar.has_permission('cms.create'):
    # Allow content creation
    pass

# Check if user can edit specific content
story = babar.get_story('story_abc123')
can_edit = (babar.has_permission('cms.edit') or 
           (babar.has_permission('cms.edit_others') and 
            story['author_id'] != current_user['id']) or
           (story['author_id'] == current_user['id']))
```

## 🎨 Theme Integration

Babar works seamlessly with all 13 TuskPHP themes:

```python
# Create content with specific theme
story_data = {
    'title': 'Themed Content',
    'content': 'Content here...',
    'theme': 'tusk_modern'  # or 'tusk_dark', 'tusk_classic', etc.
}
```

### Available Themes
- `tusk_modern`: Clean, modern design
- `tusk_dark`: Dark mode theme
- `tusk_classic`: Traditional design
- `tusk_custom`: Customizable theme
- `tusk_happy`: Cheerful theme
- `tusk_sad`: Melancholic theme
- `tusk_peanuts`: Configuration theme
- `tusk_horton`: Job processing theme
- `tusk_dumbo`: Terminal theme
- `tusk_satao`: Security theme
- `tusk_animal`: Safari theme
- `tusk_babar`: Content theme
- `tusk_90s`: Retro theme

## 🔄 Version Control

Babar maintains complete version history:

```python
# Get version history
versions = babar.get_version_history('story_abc123')
for version in versions:
    print(f"Version {version['version_number']}: {version['change_note']}")
```

### Version Features
- **Automatic Versioning**: Every change creates a new version
- **Change Notes**: Track what changed and why
- **Rollback Capability**: Restore previous versions
- **Author Tracking**: Know who made each change

## 🌍 Multi-Language Support

Babar supports multiple languages like the international Babar:

```python
# Create content in different languages
english_story = {
    'title': 'Welcome to Celesteville',
    'content': 'English content...',
    'language': 'en'
}

french_story = {
    'title': 'Bienvenue à Celesteville',
    'content': 'Contenu français...',
    'language': 'fr'
}
```

### Supported Languages
- `en`: English
- `fr`: French (Babar's language!)
- `es`: Spanish
- `de`: German

## 📊 Content Analytics

Get insights into your content kingdom:

```python
analytics = babar.get_analytics()

# Summary statistics
print(f"Total content: {analytics['summary']['total_content']}")
print(f"Published: {analytics['summary']['published']}")
print(f"Drafts: {analytics['summary']['drafts']}")

# Content by type
for type_data in analytics['content_by_type']:
    print(f"{type_data['type']}: {type_data['count']}")

# Recent activity
for activity in analytics['recent_activity']:
    print(f"{activity['title']} - {activity['updated_at']}")
```

## 🗄️ Database Schema

### babar_content Table
```sql
CREATE TABLE babar_content (
    id TEXT PRIMARY KEY,
    title TEXT NOT NULL,
    slug TEXT UNIQUE,
    content TEXT,
    excerpt TEXT,
    type TEXT DEFAULT 'page',
    status TEXT DEFAULT 'draft',
    author_id INTEGER NOT NULL,
    created_at INTEGER NOT NULL,
    updated_at INTEGER NOT NULL,
    published_at INTEGER,
    deleted_at INTEGER,
    version INTEGER DEFAULT 1,
    language TEXT DEFAULT 'en',
    parent_id TEXT,
    template TEXT DEFAULT 'default',
    theme TEXT DEFAULT 'tusk_modern',
    meta_title TEXT,
    meta_description TEXT,
    meta_keywords TEXT,
    featured_image TEXT,
    components TEXT,
    settings TEXT
);
```

### babar_versions Table
```sql
CREATE TABLE babar_versions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    content_id TEXT NOT NULL,
    version_number INTEGER NOT NULL,
    title TEXT,
    content TEXT,
    components TEXT,
    settings TEXT,
    changed_by INTEGER NOT NULL,
    changed_at INTEGER NOT NULL,
    change_note TEXT
);
```

## 🔧 Configuration

### Database Configuration
```python
# Custom database path
babar = Babar(db_path="/path/to/custom/babar_cms.db")
```

### Language Configuration
```python
# Set default language
babar.default_language = 'fr'

# Add custom languages
babar.languages.append('it')  # Italian
```

## 🎯 Best Practices

### Content Organization
1. **Use Hierarchical Structure**: Organize content with parent-child relationships
2. **Consistent Naming**: Use descriptive titles and slugs
3. **SEO Optimization**: Fill meta tags for better search visibility
4. **Version Control**: Always add meaningful change notes

### Performance
1. **Caching**: Babar integrates with Flask-TSK's Memory system for caching
2. **Pagination**: Use pagination for large content libraries
3. **Indexing**: Database indexes are automatically created for common queries

### Security
1. **Permission Checks**: Always verify permissions before operations
2. **Input Validation**: Validate all user input
3. **Soft Deletes**: Content is soft-deleted by default

## 🐛 Error Handling

Babar provides comprehensive error handling:

```python
try:
    result = babar.create_story(story_data)
    if result['success']:
        print("Content created successfully")
    else:
        print(f"Error: {result['error']}")
except Exception as e:
    print(f"Exception: {e}")
```

### Common Error Scenarios
- **Permission Denied**: User lacks required capabilities
- **Content Not Found**: Invalid content ID or slug
- **Database Errors**: Connection or query issues
- **Validation Errors**: Invalid input data

## 🔮 Future Enhancements

### Planned Features
- **Advanced Workflow**: Multi-step approval processes
- **Content Scheduling**: Publish content at specific times
- **Media Library**: Enhanced media management
- **Search Integration**: Full-text search capabilities
- **API Endpoints**: RESTful API for external access
- **Webhook Support**: Trigger external systems on content changes

### Integration Opportunities
- **Search Engines**: Elasticsearch, Solr integration
- **CDN Integration**: Automatic content distribution
- **Analytics Platforms**: Google Analytics, Mixpanel integration
- **Social Media**: Automatic social media posting

## 📖 Conclusion

Babar brings the same wisdom and organization that King Babar brought to the elephant kingdom. With its comprehensive content management capabilities, role-based access control, and seamless theme integration, Babar provides a solid foundation for any content-driven application in the Flask-TSK ecosystem.

Just as Babar transformed a jungle into a civilized kingdom, this CMS transforms chaotic content into an organized, manageable system that scales with your needs.

*"In the great forest, a little elephant is born. His name is Babar."* 