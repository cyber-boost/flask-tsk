#!/usr/bin/env python3
"""
Flask-TSK CLI Tool
Command-line interface for managing Flask-TSK projects
"""

import argparse
import os
import sys
import logging
from pathlib import Path
from typing import Optional

from .optimization_tools import get_asset_optimizer, get_layout_manager, optimize_project_assets

def setup_logging(verbose: bool = False):
    """Setup logging configuration"""
    level = logging.DEBUG if verbose else logging.INFO
    logging.basicConfig(
        level=level,
        format='%(asctime)s - %(name)s - %(levelname)s - %(message)s'
    )

def create_project_structure(project_path: str, force: bool = False):
    """Create Flask-TSK project structure"""
    from . import FlaskTSK
    
    project_path = os.path.abspath(project_path)
    
    if not os.path.exists(project_path):
        os.makedirs(project_path)
        print(f"Created project directory: {project_path}")
    
    # Create a minimal Flask app to use FlaskTSK
    from flask import Flask
    
    app = Flask(__name__)
    tsk = FlaskTSK(app)
    
    # Setup project structure
    success = tsk.setup_project_structure(project_path)
    
    if success:
        print(f"✅ Flask-TSK project structure created in: {project_path}")
        print("\n📁 Created folders:")
        folders = [
            'tsk/assets/css', 'tsk/assets/js', 'tsk/assets/images', 'tsk/assets/fonts',
            'tsk/layouts/headers', 'tsk/layouts/footers', 'tsk/layouts/navigation',
            'tsk/optimization/scripts', 'tsk/optimization/tools',
            'tsk/config', 'tsk/templates', 'tsk/static/css', 'tsk/static/js',
            'tsk/static/images', 'tsk/static/fonts', 'tsk/build', 'tsk/cache'
        ]
        for folder in folders:
            print(f"   📂 {folder}")
        
        print("\n📄 Created files:")
        files = [
            'tsk/config/peanu.tsk',
            'tsk/layouts/headers/default.html',
            'tsk/layouts/footers/default.html',
            'tsk/layouts/navigation/default.html',
            'tsk/assets/css/main.css',
            'tsk/assets/js/main.js'
        ]
        for file in files:
            print(f"   📄 {file}")
        
        print("\n🚀 Next steps:")
        print("   1. cd " + project_path)
        print("   2. python -m flask run")
        print("   3. Visit http://localhost:5000")
    else:
        print("❌ Failed to create project structure")
        sys.exit(1)

def optimize_assets(project_path: str, minify: bool = True, obfuscate: bool = False,
                   compress_images: bool = True, gzip: bool = True, watch: bool = False):
    """Optimize project assets"""
    project_path = os.path.abspath(project_path)
    
    if not os.path.exists(project_path):
        print(f"❌ Project path does not exist: {project_path}")
        sys.exit(1)
    
    print(f"🔧 Optimizing assets in: {project_path}")
    
    if watch:
        print("👀 Starting asset watcher...")
        optimizer = get_asset_optimizer(project_path)
        observer = optimizer.watch_assets()
        
        if observer:
            try:
                print("Press Ctrl+C to stop watching")
                observer.join()
            except KeyboardInterrupt:
                observer.stop()
                observer.join()
                print("\n👋 Asset watching stopped")
        else:
            print("❌ Asset watching not available")
    else:
        results = optimize_project_assets(
            project_path,
            minify=minify,
            obfuscate=obfuscate,
            compress_images=compress_images,
            gzip=gzip
        )
        
        print("\n📊 Optimization Results:")
        for category, files in results.items():
            if files:
                print(f"   {category.title()}: {len(files)} files")
                for file in files:
                    print(f"     📄 {os.path.basename(file)}")

def generate_manifest(project_path: str, output_file: str = None):
    """Generate asset manifest"""
    project_path = os.path.abspath(project_path)
    
    if not os.path.exists(project_path):
        print(f"❌ Project path does not exist: {project_path}")
        sys.exit(1)
    
    optimizer = get_asset_optimizer(project_path)
    manifest = optimizer.generate_asset_manifest()
    
    if output_file:
        import json
        with open(output_file, 'w') as f:
            json.dump(manifest, f, indent=2)
        print(f"📄 Asset manifest saved to: {output_file}")
    else:
        print("📋 Asset Manifest:")
        for original, hashed in manifest.items():
            print(f"   {original} -> {hashed}")

def list_layouts(project_path: str):
    """List available layouts"""
    project_path = os.path.abspath(project_path)
    
    if not os.path.exists(project_path):
        print(f"❌ Project path does not exist: {project_path}")
        sys.exit(1)
    
    layout_manager = get_layout_manager(project_path)
    layouts_path = os.path.join(project_path, 'tsk', 'layouts')
    
    print(f"📁 Available layouts in: {layouts_path}")
    
    for layout_type in ['headers', 'footers', 'navigation']:
        layout_dir = os.path.join(layouts_path, layout_type)
        if os.path.exists(layout_dir):
            print(f"\n   {layout_type.title()}:")
            for file in os.listdir(layout_dir):
                if file.endswith('.html'):
                    print(f"     📄 {file}")

def main():
    """Main CLI entry point"""
    parser = argparse.ArgumentParser(
        description="Flask-TSK CLI Tool - Manage Flask-TSK projects and assets",
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog="""
Examples:
  flask-tsk init my-project          # Create new Flask-TSK project
  flask-tsk optimize my-project      # Optimize all assets
  flask-tsk watch my-project         # Watch assets for changes
  flask-tsk manifest my-project      # Generate asset manifest
  flask-tsk layouts my-project       # List available layouts
        """
    )
    
    parser.add_argument('--verbose', '-v', action='store_true',
                       help='Enable verbose logging')
    
    subparsers = parser.add_subparsers(dest='command', help='Available commands')
    
    # Init command
    init_parser = subparsers.add_parser('init', help='Initialize new Flask-TSK project')
    init_parser.add_argument('project_path', help='Project directory path')
    init_parser.add_argument('--force', action='store_true',
                           help='Force creation even if directory exists')
    
    # Optimize command
    optimize_parser = subparsers.add_parser('optimize', help='Optimize project assets')
    optimize_parser.add_argument('project_path', help='Project directory path')
    optimize_parser.add_argument('--no-minify', action='store_true',
                               help='Skip minification')
    optimize_parser.add_argument('--obfuscate', action='store_true',
                               help='Obfuscate JavaScript')
    optimize_parser.add_argument('--no-compress-images', action='store_true',
                               help='Skip image compression')
    optimize_parser.add_argument('--no-gzip', action='store_true',
                               help='Skip gzip compression')
    
    # Watch command
    watch_parser = subparsers.add_parser('watch', help='Watch assets for changes')
    watch_parser.add_argument('project_path', help='Project directory path')
    
    # Manifest command
    manifest_parser = subparsers.add_parser('manifest', help='Generate asset manifest')
    manifest_parser.add_argument('project_path', help='Project directory path')
    manifest_parser.add_argument('--output', '-o', help='Output file path')
    
    # Layouts command
    layouts_parser = subparsers.add_parser('layouts', help='List available layouts')
    layouts_parser.add_argument('project_path', help='Project directory path')
    
    args = parser.parse_args()
    
    if not args.command:
        parser.print_help()
        sys.exit(1)
    
    setup_logging(args.verbose)
    
    try:
        if args.command == 'init':
            create_project_structure(args.project_path, args.force)
        elif args.command == 'optimize':
            optimize_assets(
                args.project_path,
                minify=not args.no_minify,
                obfuscate=args.obfuscate,
                compress_images=not args.no_compress_images,
                gzip=not args.no_gzip
            )
        elif args.command == 'watch':
            optimize_assets(args.project_path, watch=True)
        elif args.command == 'manifest':
            generate_manifest(args.project_path, args.output)
        elif args.command == 'layouts':
            list_layouts(args.project_path)
        else:
            print(f"❌ Unknown command: {args.command}")
            sys.exit(1)
            
    except KeyboardInterrupt:
        print("\n👋 Operation cancelled by user")
        sys.exit(0)
    except Exception as e:
        print(f"❌ Error: {e}")
        if args.verbose:
            import traceback
            traceback.print_exc()
        sys.exit(1)

if __name__ == '__main__':
    main() 