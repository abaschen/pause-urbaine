# WordPress to Hugo Migration

## Migration Summary

This document describes the WordPress content migration process for the Pause Urbaine website.

## What Was Migrated

### Images (61 files)
- All images from WordPress export downloaded to `static/images/wordpress/`
- Logo file copied to `static/images/logo.jpg`
- Images include: salon photos, pricing documents (PDFs), and various header images

### Content Structure Created

#### French Content (`content/fr/`)
- Homepage (`_index.md`)
- Services page (`services/_index.md`)
- Pricing page (`tarifs/_index.md`)
- Contact page (`contact/_index.md`)
- News section (`actualites/_index.md`)
- Sample blog post (`actualites/bienvenue-nouveau-site.md`)

#### English Content (`content/en/`)
- Homepage (`_index.md`)
- Services page (`services/_index.md`)
- Pricing page (`pricing/_index.md`)
- Contact page (`contact/_index.md`)
- News section (`news/_index.md`)

## WordPress Export Analysis

The WordPress export file (`WordPress.2026-02-20.xml`) contained:
- **0 published posts** - No blog content to migrate
- **4 pages** - Structure noted but content created manually
- **61 attachments** - All downloaded successfully

## Pages Found in WordPress

The following pages were identified in the export:
1. Accueil (Homepage)
2. Services
3. Tarifs (Pricing)
4. Trouver l'addresse - Horaires (Contact/Location)

Since the export didn't contain the actual page content, new content was created based on the site requirements and design specifications.

## Migration Script

A Python migration script was created at `scripts/migrate-wordpress.py` that:
- Parses WordPress XML export files
- Downloads all images and attachments
- Converts HTML content to Markdown
- Creates Hugo-compatible frontmatter
- Handles posts, pages, and attachments

## Next Steps

### Content Updates Needed
1. **Update location information** in `data/locations.yaml` with actual addresses and phone numbers
2. **Add pricing data** to `data/pricing.yaml` (extract from pricing PDFs in wordpress folder)
3. **Review and enhance** page content with specific salon information
4. **Add more blog posts** to the actualites/news sections as needed

### Image Optimization
Images should be optimized for web use:
- Resize large images (max 1920px width)
- Generate WebP versions using Hugo image processing
- Add responsive image srcsets in templates

### Logo
The logo file is available at:
- Original: `static/images/wordpress/Logo-Pause-Urbaine-2022--e1674599868824.jpeg`
- Copy: `static/images/logo.jpg`

Consider converting to SVG format for better scalability.

## Files Created

### Migration Tools
- `scripts/migrate-wordpress.py` - WordPress XML parser and image downloader

### Content Files
- 6 French content pages
- 5 English content pages
- 1 sample blog post

### Images
- 61 files in `static/images/wordpress/`
- 1 logo file in `static/images/`

## Usage

To run the migration script again (if needed):

```bash
python3 scripts/migrate-wordpress.py
```

The script will:
1. Parse the WordPress XML export
2. Download all images to `static/images/wordpress/`
3. Create content files for any posts found
4. Report on pages that need manual creation
