#!/usr/bin/env python3
"""
Generate WordPress import XML with pricing data from YAML file
No external dependencies - uses only standard library
"""

import re
import sys

def parse_yaml_pricing(yaml_file):
    """Simple YAML parser for pricing data structure"""
    with open(yaml_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    categories = []
    current_category = None
    current_service = None
    indent_stack = []
    
    for line in content.split('\n'):
        if line.strip().startswith('#') or not line.strip():
            continue
        
        # Count indentation
        indent = len(line) - len(line.lstrip())
        
        # Category definition
        if '- id:' in line:
            if current_category and current_service:
                current_category['services'].append(current_service)
                current_service = None
            if current_category:
                categories.append(current_category)
            
            cat_id = line.split('id:')[1].strip()
            current_category = {'id': cat_id, 'name': {}, 'services': []}
            
        # Category name
        elif current_category and 'name:' in line and indent == 4:
            pass  # Name section starts
        elif current_category and 'fr:' in line and indent == 6 and 'name' not in str(current_service):
            name_fr = line.split('fr:')[1].strip().strip('"')
            current_category['name']['fr'] = name_fr
        elif current_category and 'en:' in line and indent == 6 and 'name' not in str(current_service):
            name_en = line.split('en:')[1].strip().strip('"')
            current_category['name']['en'] = name_en
            
        # Services section
        elif current_category and 'services:' in line:
            pass  # Services section starts
            
        # Service item
        elif current_category and '- name:' in line and indent == 6:
            if current_service:
                current_category['services'].append(current_service)
            current_service = {'name': {}, 'price': '', 'duration': ''}
            
        # Service name
        elif current_service and 'fr:' in line and indent == 10:
            name_fr = line.split('fr:')[1].strip().strip('"')
            current_service['name']['fr'] = name_fr
        elif current_service and 'en:' in line and indent == 10:
            name_en = line.split('en:')[1].strip().strip('"')
            current_service['name']['en'] = name_en
            
        # Service price
        elif current_service and 'price:' in line and indent == 8:
            price = line.split('price:')[1].strip().strip('"')
            current_service['price'] = price
            
        # Service duration
        elif current_service and 'duration:' in line and indent == 8:
            duration = line.split('duration:')[1].strip().strip('"')
            current_service['duration'] = duration
    
    # Add last service and category
    if current_service:
        current_category['services'].append(current_service)
    if current_category:
        categories.append(current_category)
    
    return categories

def escape_cdata(text):
    """Escape text for CDATA sections"""
    return text.replace(']]>', ']]]]><![CDATA[>')

def make_slug(text):
    """Create URL-safe slug from text"""
    slug = text.lower()
    # Remove special characters
    slug = slug.replace(' ', '-').replace('«', '').replace('»', '')
    slug = slug.replace('(', '').replace(')', '').replace('+', '')
    slug = slug.replace('/', '-').replace('–', '-').replace('à', 'a')
    slug = slug.replace('é', 'e').replace('è', 'e').replace('ê', 'e')
    slug = slug.replace("'", '-').replace(',', '').replace('"', '')
    # Remove multiple dashes
    while '--' in slug:
        slug = slug.replace('--', '-')
    return slug.strip('-')

def generate_pricing_xml(yaml_file):
    """Generate WordPress WXR XML from pricing YAML"""
    
    categories = parse_yaml_pricing(yaml_file)
    
    # Start XML
    xml = '''<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
	xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:wp="http://wordpress.org/export/1.2/">

<channel>
	<title>Pause Urbaine - Pricing Data</title>
	<link>https://pauseurbaine.com</link>
	<description>Pricing data import</description>
	<pubDate>Wed, 26 Feb 2026 12:00:00 +0000</pubDate>
	<language>fr-FR</language>
	<wp:wxr_version>1.2</wp:wxr_version>
	<wp:base_site_url>https://pauseurbaine.com</wp:base_site_url>
	<wp:base_blog_url>https://pauseurbaine.com</wp:base_blog_url>

	<wp:author>
		<wp:author_id>1</wp:author_id>
		<wp:author_login><![CDATA[admin]]></wp:author_login>
		<wp:author_email><![CDATA[admin@pauseurbaine.com]]></wp:author_email>
		<wp:author_display_name><![CDATA[Admin]]></wp:author_display_name>
		<wp:author_first_name><![CDATA[]]></wp:author_first_name>
		<wp:author_last_name><![CDATA[]]></wp:author_last_name>
	</wp:author>

'''
    
    # Add categories
    xml += '\t<!-- Pricing Categories -->\n'
    term_id = 1
    for category in categories:
        if not category['services']:
            continue
        xml += f'''\t<wp:term>
		<wp:term_id>{term_id}</wp:term_id>
		<wp:term_taxonomy>pricing_category</wp:term_taxonomy>
		<wp:term_slug>{category['id']}</wp:term_slug>
		<wp:term_name><![CDATA[{escape_cdata(category['name']['fr'])}]]></wp:term_name>
	</wp:term>

'''
        term_id += 1
    
    # Add pricing items
    post_id = 100
    menu_order = 1
    
    for category in categories:
        if not category['services']:
            continue
            
        xml += f'\t<!-- Pricing Items: {category["name"]["fr"]} -->\n'
        
        for service in category['services']:
            title_fr = service['name']['fr']
            slug = make_slug(title_fr)
            price = service.get('price', '')
            duration = service.get('duration', '')
            
            # Skip "XX min" placeholder durations
            if duration == 'XX min':
                duration = ''
            
            xml += f'''\t<item>
		<title>{escape_cdata(title_fr)}</title>
		<link>https://pauseurbaine.com/pricing/{slug}/</link>
		<pubDate>Wed, 26 Feb 2026 12:00:00 +0000</pubDate>
		<dc:creator><![CDATA[admin]]></dc:creator>
		<guid isPermaLink="false">https://pauseurbaine.com/?post_type=pricing&amp;p={post_id}</guid>
		<description></description>
		<content:encoded><![CDATA[]]></content:encoded>
		<excerpt:encoded><![CDATA[]]></excerpt:encoded>
		<wp:post_id>{post_id}</wp:post_id>
		<wp:post_date><![CDATA[2026-02-26 12:00:00]]></wp:post_date>
		<wp:post_date_gmt><![CDATA[2026-02-26 12:00:00]]></wp:post_date_gmt>
		<wp:post_modified><![CDATA[2026-02-26 12:00:00]]></wp:post_modified>
		<wp:post_modified_gmt><![CDATA[2026-02-26 12:00:00]]></wp:post_modified_gmt>
		<wp:comment_status><![CDATA[closed]]></wp:comment_status>
		<wp:ping_status><![CDATA[closed]]></wp:ping_status>
		<wp:post_name><![CDATA[{slug}]]></wp:post_name>
		<wp:status><![CDATA[publish]]></wp:status>
		<wp:post_parent>0</wp:post_parent>
		<wp:menu_order>{menu_order}</wp:menu_order>
		<wp:post_type><![CDATA[pricing]]></wp:post_type>
		<wp:post_password><![CDATA[]]></wp:post_password>
		<wp:is_sticky>0</wp:is_sticky>
		<category domain="pricing_category" nicename="{category['id']}"><![CDATA[{escape_cdata(category['name']['fr'])}]]></category>
		<wp:postmeta>
			<wp:meta_key><![CDATA[_pricing_price]]></wp:meta_key>
			<wp:meta_value><![CDATA[{escape_cdata(price)}]]></wp:meta_value>
		</wp:postmeta>
		<wp:postmeta>
			<wp:meta_key><![CDATA[_pricing_duration]]></wp:meta_key>
			<wp:meta_value><![CDATA[{escape_cdata(duration)}]]></wp:meta_value>
		</wp:postmeta>
	</item>

'''
            post_id += 1
            menu_order += 1
    
    # Close XML
    xml += '''</channel>
</rss>
'''
    
    return xml

if __name__ == '__main__':
    yaml_file = 'pause-urbaine-website/data/pricing.yaml'
    output_file = 'pause-urbaine-wp-theme/import/pricing-import.xml'
    
    try:
        xml_content = generate_pricing_xml(yaml_file)
        
        with open(output_file, 'w', encoding='utf-8') as f:
            f.write(xml_content)
        
        print(f'✓ Generated {output_file}')
        print(f'  Ready to import into WordPress')
        
    except Exception as e:
        print(f'✗ Error: {e}', file=sys.stderr)
        import traceback
        traceback.print_exc()
        sys.exit(1)
