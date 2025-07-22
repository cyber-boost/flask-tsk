# Heffalump - The Fuzzy Search Expert (Python Edition)

## Overview

Heffalump is the fuzzy search expert that finds what you're looking for even when you're not quite sure what it is. Like the mysterious creature from Winnie-the-Pooh, Heffalump is elusive but always there when you need to find something. It handles misspellings, partial matches, and "sounds like" searches with remarkable accuracy.

## Features

### Core Functionality
- **Levenshtein distance matching** for typo tolerance
- **Phonetic matching** using Soundex/Metaphone algorithms
- **N-gram similarity** for partial matching
- **Fuzzy autocomplete** with real-time suggestions
- **Typo correction** with "Did you mean?" suggestions
- **Weighted multi-field search** for complex queries
- **Elasticsearch integration** for advanced search capabilities
- **Multi-instance support** for different search contexts
- **Search analytics** and performance tracking

### Technical Features
- **Multiple search algorithms** (exact, fuzzy, phonetic, n-gram)
- **Configurable tolerance levels** for fuzzy matching
- **Confidence scoring** for result ranking
- **Duplicate detection** and result deduplication
- **Real-time indexing** and bulk operations
- **Search history tracking** and analytics
- **Extensible architecture** for custom search types

## Installation

### Dependencies
```bash
# Core dependencies
pip install difflib

# Optional dependencies for enhanced features
pip install jellyfish  # For phonetic matching
pip install elasticsearch  # For Elasticsearch integration
```

## Usage

### Basic Initialization
```python
from elephants.py_ele.heffalump import Heffalump

# Initialize Heffalump with default configuration
heffalump = Heffalump()

# Initialize with custom configuration
config = {
    'tolerance': 3,
    'min_similarity': 0.6,
    'soundex_enabled': True,
    'elasticsearch_url': 'http://localhost:9200'
}
heffalump = Heffalump('custom_instance', config)
```

### Basic Search
```python
# Simple fuzzy search
results = heffalump.hunt("elefant")  # Will find "elephant"
for result in results:
    print(f"Found: {result.content} (confidence: {result.confidence})")

# Search in specific data
search_data = ["apple", "banana", "orange", "grapefruit"]
results = heffalump.hunt("bananna", search_data)  # Will find "banana"
```

### Enhanced Search
```python
# Enhanced search with Elasticsearch
results = heffalump.hunt_enhanced("elefant", {
    'use_elasticsearch': True,
    'max_results': 20,
    'search_in': ['documents', 'titles', 'content']
})
```

### Autocomplete and Suggestions
```python
# Get autocomplete suggestions
suggestions = heffalump.track_suggestions("ele", limit=5)
print(f"Suggestions: {suggestions}")

# Get "Did you mean?" suggestions
corrections = heffalump.did_you_mean("elefant")
print(f"Did you mean: {corrections}")
```

### Indexing Content
```python
# Index single item
success = heffalump.index("doc_001", "Elephant conservation efforts", {
    'category': 'wildlife',
    'tags': ['elephant', 'conservation', 'wildlife']
})

# Bulk indexing
items = [
    {'id': 'doc_001', 'content': 'Elephant facts', 'metadata': {'category': 'facts'}},
    {'id': 'doc_002', 'content': 'Elephant habitat', 'metadata': {'category': 'habitat'}},
    {'id': 'doc_003', 'content': 'Elephant behavior', 'metadata': {'category': 'behavior'}}
]

results = heffalump.bulk_index(items)
print(f"Indexed {results['successful']} items, {results['failed']} failed")
```

### Analytics
```python
# Get search analytics
analytics = heffalump.get_analytics(days=30)
print(f"Total searches: {analytics['total_searches']}")
print(f"Average response time: {analytics['average_response_time']:.3f}s")
print(f"Most common queries: {analytics['most_common_queries']}")
```

## Flask-TSK Integration

### App Initialization
```python
from flask import Flask
from elephants.py_ele.heffalump import init_heffalump

app = Flask(__name__)

# Initialize with default instance
heffalump = init_heffalump(app)

# Initialize multiple instances
search_instance = init_heffalump(app, 'search', {'tolerance': 2})
content_instance = init_heffalump(app, 'content', {'tolerance': 3})
```

### Route Usage
```python
from flask import request, jsonify
from elephants.py_ele.heffalump import get_heffalump

@app.route('/api/search', methods=['POST'])
def search():
    heffalump = get_heffalump()
    
    if not heffalump:
        return jsonify({'error': 'Heffalump not initialized'}), 500
    
    data = request.get_json()
    query = data.get('query', '')
    search_in = data.get('search_in')
    
    results = heffalump.hunt(query, search_in)
    
    return jsonify({
        'query': query,
        'results': [
            {
                'id': result.id,
                'content': result.content,
                'score': result.score,
                'confidence': result.confidence,
                'match_type': result.match_type,
                'metadata': result.metadata
            }
            for result in results
        ],
        'total_results': len(results)
    })

@app.route('/api/search/enhanced', methods=['POST'])
def enhanced_search():
    heffalump = get_heffalump()
    
    data = request.get_json()
    query = data.get('query', '')
    options = data.get('options', {})
    
    results = heffalump.hunt_enhanced(query, options)
    
    return jsonify({
        'query': query,
        'results': [
            {
                'id': result.id,
                'content': result.content,
                'score': result.score,
                'confidence': result.confidence,
                'match_type': result.match_type
            }
            for result in results
        ]
    })

@app.route('/api/search/suggestions', methods=['GET'])
def get_suggestions():
    heffalump = get_heffalump()
    
    partial = request.args.get('q', '')
    limit = int(request.args.get('limit', 5))
    
    suggestions = heffalump.track_suggestions(partial, limit)
    
    return jsonify({
        'partial': partial,
        'suggestions': suggestions
    })

@app.route('/api/search/did-you-mean', methods=['GET'])
def did_you_mean():
    heffalump = get_heffalump()
    
    query = request.args.get('q', '')
    context = request.args.get('context', {})
    
    suggestions = heffalump.did_you_mean(query, context)
    
    return jsonify({
        'query': query,
        'suggestions': suggestions
    })

@app.route('/api/search/index', methods=['POST'])
def index_content():
    heffalump = get_heffalump()
    
    data = request.get_json()
    content_id = data.get('id')
    content = data.get('content')
    metadata = data.get('metadata', {})
    
    success = heffalump.index(content_id, content, metadata)
    
    return jsonify({
        'success': success,
        'id': content_id
    })

@app.route('/api/search/bulk-index', methods=['POST'])
def bulk_index():
    heffalump = get_heffalump()
    
    data = request.get_json()
    items = data.get('items', [])
    
    results = heffalump.bulk_index(items)
    
    return jsonify(results)

@app.route('/api/search/analytics')
def get_analytics():
    heffalump = get_heffalump()
    
    days = int(request.args.get('days', 30))
    analytics = heffalump.get_analytics(days)
    
    return jsonify(analytics)

# Multiple instance routes
@app.route('/api/search/content', methods=['POST'])
def content_search():
    heffalump = get_heffalump('content')
    
    if not heffalump:
        return jsonify({'error': 'Content Heffalump not initialized'}), 500
    
    data = request.get_json()
    query = data.get('query', '')
    
    results = heffalump.hunt(query)
    
    return jsonify({
        'query': query,
        'results': [
            {
                'id': result.id,
                'content': result.content,
                'confidence': result.confidence
            }
            for result in results
        ]
    })
```

## Configuration

### Environment Variables
```bash
# Elasticsearch configuration
ELASTICSEARCH_URL=http://localhost:9200
ELASTICSEARCH_INDEX=heffalump_search

# Search tolerance and similarity
HEFFALUMP_TOLERANCE=2
HEFFALUMP_MIN_SIMILARITY=0.7
HEFFALUMP_SOUNDEX_ENABLED=true

# N-gram configuration
HEFFALUMP_NGRAM_SIZE=2
HEFFALUMP_MAX_RESULTS=50
```

### Configuration File
```python
# config.py
HEFFALUMP_CONFIG = {
    'tolerance': 2,
    'min_similarity': 0.7,
    'soundex_enabled': True,
    'ngram_size': 2,
    'max_results': 50,
    'elasticsearch_url': 'http://localhost:9200',
    'elasticsearch_index': 'heffalump_search'
}
```

## Search Algorithms

### Levenshtein Distance
- **Purpose**: Find strings that are similar with minor differences
- **Use case**: Typo correction, fuzzy matching
- **Example**: "elefant" → "elephant"

### Phonetic Matching (Soundex)
- **Purpose**: Find words that sound similar
- **Use case**: Name matching, pronunciation variations
- **Example**: "Smith" → "Smyth"

### N-gram Similarity
- **Purpose**: Find partial matches and substrings
- **Use case**: Autocomplete, partial word matching
- **Example**: "ele" → "elephant", "element"

### Elasticsearch Integration
- **Purpose**: Advanced full-text search with scoring
- **Use case**: Large datasets, complex queries
- **Features**: Relevance scoring, highlighting, aggregations

## Search Types

### Exact Match
```python
# Perfect string match
results = heffalump.hunt("elephant")
# Returns only exact matches
```

### Fuzzy Match
```python
# Tolerant of typos and variations
results = heffalump.hunt("elefant")
# Returns "elephant" with high confidence
```

### Phonetic Match
```python
# Sound-based matching
results = heffalump.hunt("elefant")
# Returns "elephant" based on pronunciation
```

### N-gram Match
```python
# Partial string matching
results = heffalump.hunt("ele")
# Returns "elephant", "element", etc.
```

## Performance Optimization

### Indexing Strategies
```python
# Batch indexing for large datasets
items = []
for i in range(1000):
    items.append({
        'id': f'doc_{i}',
        'content': f'Document content {i}',
        'metadata': {'category': 'documents'}
    })

results = heffalump.bulk_index(items)
```

### Search Optimization
```python
# Use specific search types for better performance
if len(query) < 3:
    # Use n-gram for short queries
    results = heffalump._ngram_hunt(query, search_data)
elif query.isalpha():
    # Use phonetic for word queries
    results = heffalump._soundex_hunt(query, search_data)
else:
    # Use fuzzy for mixed queries
    results = heffalump._levenshtein_hunt(query, search_data)
```

### Caching
```python
# Cache frequent searches
from functools import lru_cache

@lru_cache(maxsize=1000)
def cached_search(query, search_in=None):
    return heffalump.hunt(query, search_in)
```

## Error Handling

### Common Error Scenarios
```python
try:
    results = heffalump.hunt("query")
except Exception as e:
    print(f"Search error: {e}")
    # Fallback to exact search or return empty results
```

### Validation
```python
def validate_search_query(query):
    if not query or len(query.strip()) == 0:
        raise ValueError("Query cannot be empty")
    
    if len(query) > 1000:
        raise ValueError("Query too long")
    
    return query.strip()
```

## Analytics and Monitoring

### Search Metrics
```python
analytics = heffalump.get_analytics(days=7)

# Key metrics
print(f"Total searches: {analytics['total_searches']}")
print(f"Average response time: {analytics['average_response_time']:.3f}s")
print(f"Most common queries: {analytics['most_common_queries']}")
print(f"Search types: {analytics['search_types']}")
```

### Performance Monitoring
```python
import time

def monitor_search_performance():
    start_time = time.time()
    results = heffalump.hunt("test query")
    response_time = time.time() - start_time
    
    if response_time > 1.0:  # Alert if search takes more than 1 second
        print(f"Slow search detected: {response_time:.3f}s")
    
    return results
```

## Integration with Other Elephants

### Happy Integration
```python
# Search for filter names in Happy
happy_filters = ["sunshine", "cheerful", "vibrant", "vintage"]
results = heffalump.hunt("sunshin", happy_filters)  # Will find "sunshine"
```

### Horton Integration
```python
# Search for job names in Horton
job_names = ["email_send", "image_process", "data_backup"]
results = heffalump.hunt("email", job_names)  # Will find "email_send"
```

### Babar Integration
```python
# Search for content in Babar CMS
content_titles = ["About Elephants", "Conservation Efforts", "Habitat Protection"]
results = heffalump.hunt("elefant", content_titles)  # Will find "About Elephants"
```

## Custom Search Implementations

### Custom Search Handler
```python
class CustomHeffalump(Heffalump):
    def custom_search(self, query, context):
        # Implement custom search logic
        results = []
        
        # Add custom search algorithms
        results.extend(self._custom_algorithm(query, context))
        
        return results
    
    def _custom_algorithm(self, query, context):
        # Custom search implementation
        return []
```

### Custom Scoring
```python
def custom_scoring_function(query, content, metadata):
    score = 0.0
    
    # Exact match bonus
    if query.lower() in content.lower():
        score += 1.0
    
    # Metadata relevance
    if metadata.get('category') == 'preferred':
        score += 0.5
    
    # Content length penalty
    if len(content) > 1000:
        score -= 0.1
    
    return min(1.0, max(0.0, score))
```

## Troubleshooting

### Common Issues

1. **Elasticsearch Connection Failed**
   ```python
   # Check Elasticsearch status
   try:
       from elasticsearch import Elasticsearch
       es = Elasticsearch(['http://localhost:9200'])
       if es.ping():
           print("Elasticsearch is running")
       else:
           print("Elasticsearch is not responding")
   except Exception as e:
       print(f"Elasticsearch error: {e}")
   ```

2. **Jellyfish Not Available**
   ```bash
   pip install jellyfish
   ```

3. **Memory Issues with Large Datasets**
   ```python
   # Process in batches
   def batch_search(queries, batch_size=100):
       results = []
       for i in range(0, len(queries), batch_size):
           batch = queries[i:i + batch_size]
           batch_results = heffalump.hunt(batch)
           results.extend(batch_results)
       return results
   ```

4. **Slow Search Performance**
   ```python
   # Optimize search parameters
   config = {
       'tolerance': 1,  # Reduce tolerance for faster search
       'min_similarity': 0.8,  # Increase minimum similarity
       'max_results': 10  # Limit results
   }
   heffalump = Heffalump('optimized', config)
   ```

### Debug Mode
```python
import logging

# Enable debug logging
logging.basicConfig(level=logging.DEBUG)

# Debug search operations
def debug_search(query, search_in=None):
    print(f"Searching for: '{query}'")
    print(f"Search in: {search_in}")
    
    results = heffalump.hunt(query, search_in)
    
    print(f"Found {len(results)} results:")
    for result in results:
        print(f"  - {result.content} (confidence: {result.confidence})")
    
    return results
```

## Future Enhancements

- **Machine learning-based relevance scoring**
- **Real-time search suggestions**
- **Multi-language support**
- **Semantic search capabilities**
- **Search result clustering**
- **Advanced analytics dashboard**
- **Search result caching**
- **Distributed search across multiple instances**

## Contributing

To contribute to Heffalump's development:

1. Follow the fuzzy search principles
2. Maintain the mysterious and helpful nature
3. Include comprehensive error handling
4. Add performance optimizations
5. Test with various data types and sizes

## License

Heffalump is part of the TuskPHP ecosystem and follows the same licensing terms as the main project.

---

*"A Heffalump or Horrible Heffalump is a creature mentioned in the Winnie-the-Pooh stories"* 🔍🐘 