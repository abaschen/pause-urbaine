# Image Optimization Guide

## Overview

This project uses Hugo's built-in image processing to automatically generate optimized images in multiple formats and sizes.

## Directory Structure

```
pause-urbaine-website/
├── assets/images/          # Source images (processed by Hugo)
│   ├── logo.jpg
│   ├── hero-*.jpg
│   └── service-*.jpg
└── static/images/          # Static images (copied as-is)
    └── wordpress/          # Original WordPress images (backup)
```

## Image Processing

### Automatic Processing

Images in `assets/images/` are automatically processed by Hugo to:
- Generate WebP versions (85% quality)
- Create multiple sizes (400px, 800px, 1200px, 1600px widths)
- Optimize file sizes
- Generate responsive srcsets

### Configuration

Image processing settings in `hugo.yaml`:

```yaml
imaging:
  resampleFilter: lanczos  # High-quality resampling
  quality: 85              # Default quality (1-100)
  anchor: smart            # Smart cropping anchor
```

## Using Images in Templates

### Responsive Images

Use the `responsive-image.html` partial for hero images, banners, and content images:

```html
{{ partial "responsive-image.html" (dict 
  "src" "images/hero.jpg" 
  "alt" "Salon Pause Urbaine" 
  "sizes" "(min-width: 1024px) 1200px, (min-width: 768px) 800px, 100vw"
  "loading" "lazy"
  "class" "hero-image"
) }}
```

**Parameters:**
- `src` (required): Path relative to `assets/` directory
- `alt` (required): Alternative text for accessibility
- `sizes` (optional): Responsive sizes attribute (default: "100vw")
- `loading` (optional): "lazy" or "eager" (default: "lazy")
- `class` (optional): CSS class name

### Logo

Use the `logo.html` partial for the site logo:

```html
{{ partial "logo.html" . }}
```

This automatically:
- Loads logo from `assets/images/logo.jpg`
- Generates WebP version (400px width, 90% quality)
- Provides JPEG fallback
- Includes proper alt text from site title

### Manual Image Processing

For custom image processing in templates:

```html
{{ $image := resources.Get "images/photo.jpg" }}
{{ $webp := $image.Resize "1200x webp q85" }}
{{ $jpg := $image.Resize "1200x q85" }}

<picture>
  <source srcset="{{ $webp.RelPermalink }}" type="image/webp">
  <img src="{{ $jpg.RelPermalink }}" alt="Description">
</picture>
```

## Image Sizes

### Responsive Breakpoints

The responsive-image partial generates these sizes:
- **400px**: Mobile phones (portrait)
- **800px**: Tablets and small laptops
- **1200px**: Desktop screens
- **1600px**: Large desktop screens and retina displays

### Sizes Attribute Examples

```html
<!-- Full-width hero image -->
sizes="100vw"

<!-- Content image (max 800px) -->
sizes="(min-width: 800px) 800px, 100vw"

<!-- Two-column layout -->
sizes="(min-width: 1024px) 50vw, 100vw"

<!-- Sidebar image (300px max) -->
sizes="(min-width: 1024px) 300px, (min-width: 768px) 400px, 100vw"
```

## Adding New Images

### For Hugo Processing

1. Add image to `assets/images/` directory
2. Use the responsive-image partial in your template
3. Hugo will automatically generate optimized versions on build

### For Static Images

1. Add image to `static/images/` directory
2. Reference directly in templates: `{{ "images/photo.jpg" | relURL }}`
3. No automatic optimization (use for icons, small graphics)

## Performance Benefits

### Before Optimization
- Original JPEG: ~2-5 MB
- No responsive sizes
- No modern formats

### After Optimization
- WebP format: ~60-80% smaller than JPEG
- Multiple sizes: Only load what's needed
- Lazy loading: Images load as user scrolls
- Result: **~70-90% bandwidth reduction**

## Image Formats

### WebP
- Modern format with excellent compression
- Supported by all modern browsers (95%+ coverage)
- Fallback to JPEG/PNG for older browsers

### JPEG
- Fallback format for compatibility
- Good compression for photos
- Universal browser support

### When to Use Static Images
- SVG icons and logos
- Small images (<10KB)
- Images that don't need responsive sizes
- Animated GIFs (Hugo doesn't process animations)

## Lazy Loading

All images use `loading="lazy"` by default except:
- Logo (always visible)
- Hero images (use `loading="eager"`)

To disable lazy loading:

```html
{{ partial "responsive-image.html" (dict 
  "src" "images/hero.jpg" 
  "alt" "Hero" 
  "loading" "eager"
) }}
```

## Build Process

During `hugo build`:
1. Hugo scans templates for image references
2. Processes images from `assets/images/`
3. Generates optimized versions in `resources/_gen/images/`
4. Copies static images from `static/` to `public/`
5. Final output in `public/` directory

## Troubleshooting

### Image Not Found
- Check path is relative to `assets/` directory
- Verify file exists in `assets/images/`
- Check file extension matches (case-sensitive)

### Image Not Optimized
- Ensure image is in `assets/images/`, not `static/images/`
- Check Hugo extended version is installed
- Clear `resources/_gen/` and rebuild

### Poor Quality
- Increase quality parameter: `q90` instead of `q85`
- Use larger source images (at least 2x final display size)
- Check original image quality

## Best Practices

1. **Source Images**: Use high-quality originals (at least 1920px width)
2. **File Names**: Use descriptive, lowercase names with hyphens
3. **Alt Text**: Always provide meaningful alternative text
4. **Lazy Loading**: Use for below-the-fold images
5. **Sizes Attribute**: Match your actual layout breakpoints
6. **WebP First**: Always generate WebP with JPEG fallback

## Examples

### Hero Section

```html
<section class="hero">
  {{ partial "responsive-image.html" (dict 
    "src" "images/hero-salon.jpg" 
    "alt" "Intérieur du salon Pause Urbaine" 
    "sizes" "100vw"
    "loading" "eager"
    "class" "hero-image"
  ) }}
</section>
```

### Service Gallery

```html
<div class="services-grid">
  {{ range .Site.Data.services }}
    <div class="service-card">
      {{ partial "responsive-image.html" (dict 
        "src" (printf "images/service-%s.jpg" .id)
        "alt" .name
        "sizes" "(min-width: 1024px) 33vw, (min-width: 768px) 50vw, 100vw"
        "loading" "lazy"
      ) }}
    </div>
  {{ end }}
</div>
```

### Content Images

```markdown
---
title: "Nouvelle coupe tendance"
image: "images/coupe-2024.jpg"
---

Content here...
```

```html
{{ with .Params.image }}
  {{ partial "responsive-image.html" (dict 
    "src" . 
    "alt" $.Title
    "sizes" "(min-width: 800px) 800px, 100vw"
  ) }}
{{ end }}
```
