#!/usr/bin/env python3
"""
WordPress to Hugo content migration script.
Parses WordPress XML export and creates Hugo content files.
"""

import xml.etree.ElementTree as ET
import re
import os
import sys
from datetime import datetime
from pathlib import Path
import urllib.request
import urllib.error

# WordPress XML namespaces
NAMESPACES = {
    'excerpt': 'http://wordpress.org/export/1.2/excerpt/',
    'content': 'http://purl.org/rss/1.0/modules/content/',
    'wfw': 'http://wellformedweb.org/CommentAPI/',
    'dc': 'http://purl.org/dc/elements/1.1/',
    'wp': 'http://wordpress.org/export/1.2/'
}

def parse_wordpress_xml(xml_file):
    """Parse WordPress XML export file."""
    tree = ET.parse(xml_file)
    root = tree.getroot()
    
    channel = root.find('channel')
    items = []
    
    for item in channel.findall('item'):
        post_type = item.find('wp:post_type', NAMESPACES)
        if post_type is not None:
            post_type_text = post_type.text
            
            # Extract item data
            item_data = {
                'title': item.find('title').text if item.find('title') is not None else '',
                'link': item.find('link').text if item.find('link') is not None else '',
                'pubDate': item.find('pubDate').text if item.find('pubDate') is not None else '',
                'creator': item.find('dc:creator', NAMESPACES).text if item.find('dc:creator', NAMESPACES) is not None else '',
                'content': item.find('content:encoded', NAMESPACES).text if item.find('content:encoded', NAMESPACES) is not None else '',
                'excerpt': item.find('excerpt:encoded', NAMESPACES).text if item.find('excerpt:encoded', NAMESPACES) is not None else '',
                'post_id': item.find('wp:post_id', NAMESPACES).text if item.find('wp:post_id', NAMESPACES) is not None else '',
                'post_date': item.find('wp:post_date', NAMESPACES).text if item.find('wp:post_date', NAMESPACES) is not None else '',
                'post_name': item.find('wp:post_name', NAMESPACES).text if item.find('wp:post_name', NAMESPACES) is not None else '',
                'status': item.find('wp:status', NAMESPACES).text if item.find('wp:status', NAMESPACES) is not None else '',
                'post_type': post_type_text,
            }
            
            # For attachments, get the attachment URL
            if post_type_text == 'attachment':
                attachment_url = item.find('wp:attachment_url', NAMESPACES)
                if attachment_url is not None:
                    item_data['attachment_url'] = attachment_url.text
            
            items.append(item_data)
    
    return items

def download_image(url, dest_path):
    """Download an image from URL to destination path."""
    try:
        # Create directory if it doesn't exist
        os.makedirs(os.path.dirname(dest_path), exist_ok=True)
        
        # Download the image
        print(f"Downloading: {url}")
        urllib.request.urlretrieve(url, dest_path)
        print(f"  → Saved to: {dest_path}")
        return True
    except urllib.error.URLError as e:
        print(f"  ✗ Failed to download {url}: {e}")
        return False
    except Exception as e:
        print(f"  ✗ Error downloading {url}: {e}")
        return False

def html_to_markdown(html):
    """Convert basic HTML to Markdown."""
    if not html:
        return ''
    
    # Remove CDATA
    text = html.replace('<![CDATA[', '').replace(']]>', '')
    
    # Convert common HTML tags to Markdown
    text = re.sub(r'<h1>(.*?)</h1>', r'# \1', text)
    text = re.sub(r'<h2>(.*?)</h2>', r'## \1', text)
    text = re.sub(r'<h3>(.*?)</h3>', r'### \1', text)
    text = re.sub(r'<h4>(.*?)</h4>', r'#### \1', text)
    text = re.sub(r'<strong>(.*?)</strong>', r'**\1**', text)
    text = re.sub(r'<b>(.*?)</b>', r'**\1**', text)
    text = re.sub(r'<em>(.*?)</em>', r'*\1*', text)
    text = re.sub(r'<i>(.*?)</i>', r'*\1*', text)
    text = re.sub(r'<a href="(.*?)">(.*?)</a>', r'[\2](\1)', text)
    text = re.sub(r'<p>(.*?)</p>', r'\1\n\n', text)
    text = re.sub(r'<br\s*/?>', '\n', text)
    text = re.sub(r'<ul>', '', text)
    text = re.sub(r'</ul>', '\n', text)
    text = re.sub(r'<li>(.*?)</li>', r'- \1', text)
    
    # Remove remaining HTML tags
    text = re.sub(r'<[^>]+>', '', text)
    
    # Clean up whitespace
    text = re.sub(r'\n{3,}', '\n\n', text)
    text = text.strip()
    
    return text

def create_frontmatter(title, date, description='', author=''):
    """Create Hugo frontmatter."""
    frontmatter = f"""---
title: "{title}"
date: {date}
"""
    if description:
        frontmatter += f'description: "{description}"\n'
    if author:
        frontmatter += f'author: "{author}"\n'
    frontmatter += "---\n\n"
    return frontmatter

def main():
    # Paths
    script_dir = Path(__file__).parent
    project_root = script_dir.parent
    xml_file = project_root.parent / '.importedWordpress' / 'WordPress.2026-02-20.xml'
    content_dir = project_root / 'content' / 'fr' / 'actualites'
    static_images_dir = project_root / 'static' / 'images' / 'wordpress'
    
    print("=" * 60)
    print("WordPress to Hugo Migration Script")
    print("=" * 60)
    print()
    
    # Check if XML file exists
    if not xml_file.exists():
        print(f"✗ Error: WordPress export file not found: {xml_file}")
        sys.exit(1)
    
    print(f"✓ Found WordPress export: {xml_file}")
    print()
    
    # Parse WordPress XML
    print("Parsing WordPress XML...")
    items = parse_wordpress_xml(xml_file)
    print(f"✓ Found {len(items)} items")
    print()
    
    # Separate posts, pages, and attachments
    posts = [item for item in items if item['post_type'] == 'post' and item['status'] == 'publish']
    pages = [item for item in items if item['post_type'] == 'page' and item['status'] == 'publish']
    attachments = [item for item in items if item['post_type'] == 'attachment']
    
    print(f"  Posts: {len(posts)}")
    print(f"  Pages: {len(pages)}")
    print(f"  Attachments: {len(attachments)}")
    print()
    
    # Download images
    if attachments:
        print("Downloading images...")
        downloaded = 0
        for attachment in attachments:
            if 'attachment_url' in attachment:
                url = attachment['attachment_url']
                # Extract filename from URL
                filename = url.split('/')[-1]
                dest_path = static_images_dir / filename
                
                if download_image(url, dest_path):
                    downloaded += 1
        
        print()
        print(f"✓ Downloaded {downloaded}/{len(attachments)} images")
        print()
    
    # Create content files for posts
    if posts:
        print("Creating blog posts...")
        os.makedirs(content_dir, exist_ok=True)
        
        for post in posts:
            # Create filename from post name
            filename = f"{post['post_name']}.md"
            filepath = content_dir / filename
            
            # Convert HTML to Markdown
            content = html_to_markdown(post['content'])
            
            # Create frontmatter
            frontmatter = create_frontmatter(
                title=post['title'],
                date=post['post_date'].replace(' ', 'T'),
                description=html_to_markdown(post['excerpt'])[:160] if post['excerpt'] else '',
                author=post['creator']
            )
            
            # Write file
            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(frontmatter)
                f.write(content)
            
            print(f"  ✓ Created: {filename}")
        
        print()
        print(f"✓ Created {len(posts)} blog posts")
        print()
    else:
        print("ℹ No published posts found in WordPress export")
        print()
    
    # Report on pages
    if pages:
        print(f"ℹ Found {len(pages)} pages (will be created manually):")
        for page in pages:
            print(f"  - {page['title']}")
        print()
    
    print("=" * 60)
    print("Migration complete!")
    print("=" * 60)

if __name__ == '__main__':
    main()
