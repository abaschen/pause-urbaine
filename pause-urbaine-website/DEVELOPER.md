# Developer Documentation - Pause Urbaine

Technical documentation for developers working on the Pause Urbaine website.

## Table of Contents

1. [Hugo Configuration](#hugo-configuration)
2. [SCSS Architecture](#scss-architecture)
3. [JavaScript Modules](#javascript-modules)
4. [Template Structure](#template-structure)
5. [Build Process](#build-process)
6. [Deployment](#deployment)

## Hugo Configuration

### hugo.yaml Overview

The main configuration file controls all Hugo behavior:

```yaml
baseURL: "https://username.github.io/pause-urbaine/"
languageCode: "fr-ch"
title: "Pause Urbaine"
theme: ""

# Multilingual Configuration
defaultContentLanguage: "fr"
defaultContentLanguageInSubdir: true

languages:
  fr:
    languageName: "Français"
    weight: 1
    contentDir: "content"
  en:
    languageName: "English"
    weight: 2
    contentDir: "content"
```

### Key Configuration Sections

#### Build Configuration

```yaml
build:
  writeStats: true  # Generates hugo_stats.json for PurgeCSS
```

#### Output Formats

Hugo generates multiple output formats:
- HTML pages
- XML sitemaps
- RSS feeds

#### Taxonomies

```yaml
taxonomies:
  tag: tags
  category: categories
```

### Content Organization

Uses **translation-by-filename** approach:
- French: `page.fr.md`
- English: `page.en.md`

Both files must exist in the same directory for proper translation linking.

### Menu Configuration

Menus are defined per language:

```yaml
languages:
  fr:
    menu:
      main:
        - identifier: services
          name: Services
          pageRef: /services  # Use pageRef, not url
          weight: 2
```

**Important**: Use `pageRef` instead of `url` for proper multilingual support.

## SCSS Architecture

### File Structure

```
assets/scss/
├── _variables.scss    # Colors, fonts, breakpoints
├── _layout.scss       # Layout components
├── _components.scss   # UI components
└── main.scss          # Main entry point
```

### _variables.scss

Defines design tokens:

```scss
// Colors
$primary-color: #00f0ff;      // Neon cyan
$secondary-color: #ff006e;    // Neon pink
$dark-bg: #0a0e27;            // Dark navy
$text-color: #ffffff;

// Typography
$font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
$font-size-base: 16px;
$line-height-base: 1.6;

// Breakpoints
$mobile: 480px;
$tablet: 768px;
$desktop: 1024px;
$wide: 1440px;

// Spacing
$spacing-unit: 1rem;
$spacing-small: $spacing-unit * 0.5;
$spacing-medium: $spacing-unit;
$spacing-large: $spacing-unit * 2;
```

### _layout.scss

Layout components:

```scss
// Container
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 $spacing-medium;
}

// Header
.header {
  background: $dark-bg;
  position: sticky;
  top: 0;
  z-index: 100;
}

// Footer
.footer {
  background: $dark-bg;
  padding: $spacing-large 0;
}
```

### _components.scss

Reusable UI components:

```scss
// Buttons
.btn {
  display: inline-block;
  padding: 0.75rem 1.5rem;
  border-radius: 4px;
  text-decoration: none;
  transition: all 0.3s ease;
  
  &--primary {
    background: $primary-color;
    color: $dark-bg;
    box-shadow: 0 0 20px rgba($primary-color, 0.5);
    
    &:hover {
      box-shadow: 0 0 30px rgba($primary-color, 0.8);
    }
  }
}

// Cards
.card {
  background: rgba(255, 255, 255, 0.05);
  border-radius: 8px;
  padding: $spacing-medium;
  backdrop-filter: blur(10px);
}
```

### main.scss

Entry point that imports all partials:

```scss
@import 'variables';
@import 'layout';
@import 'components';
```

### Hugo Pipes Integration

SCSS is processed through Hugo Pipes in `baseof.html`:

```html
{{ $scss := resources.Get "scss/main.scss" }}
{{ $css := $scss | resources.ToCSS | resources.Minify | resources.Fingerprint }}
<link rel="stylesheet" href="{{ $css.RelPermalink }}" integrity="{{ $css.Data.Integrity }}">
```

**Features**:
- SCSS compilation
- Minification
- Fingerprinting (cache busting)
- Subresource Integrity (SRI)

## JavaScript Modules

### File Structure

```
assets/js/
├── fontawesome.js    # Font Awesome configuration
└── main.js           # Main application logic
```

### fontawesome.js

Tree-shaken Font Awesome setup:

```javascript
import { library, dom } from '@fortawesome/fontawesome-svg-core';

// Import only needed icons
import { 
  faPhone, 
  faLocationDot, 
  faClock,
  faBars,
  faTimes
} from '@fortawesome/free-solid-svg-icons';

import { 
  faInstagram 
} from '@fortawesome/free-brands-svg-icons';

// Add icons to library
library.add(
  faPhone, 
  faLocationDot, 
  faClock,
  faBars,
  faTimes,
  faInstagram
);

// Watch DOM for icon replacements
dom.watch();
```

**Benefits**:
- Only imports needed icons (~20KB vs 900KB+)
- Automatic SVG replacement
- No external CSS needed

### main.js

Application logic:

```javascript
// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', () => {
  const menuToggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.nav');
  
  if (menuToggle && nav) {
    menuToggle.addEventListener('click', () => {
      nav.classList.toggle('is-open');
      
      // Toggle icon
      const icon = menuToggle.querySelector('i');
      if (icon) {
        icon.classList.toggle('fa-bars');
        icon.classList.toggle('fa-times');
      }
    });
    
    // Close on Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && nav.classList.contains('is-open')) {
        nav.classList.remove('is-open');
      }
    });
  }
});

// Lazy Loading Images
if ('IntersectionObserver' in window) {
  const imageObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.src;
        img.classList.add('loaded');
        imageObserver.unobserve(img);
      }
    });
  });
  
  document.querySelectorAll('img[data-src]').forEach(img => {
    imageObserver.observe(img);
  });
}
```

### Hugo Pipes Integration

JavaScript is processed through Hugo Pipes:

```html
{{ $js := resources.Get "js/main.js" | js.Build | resources.Minify | resources.Fingerprint }}
<script src="{{ $js.RelPermalink }}" defer></script>
```

**Features**:
- ES6 module bundling
- npm package resolution
- Minification
- Fingerprinting

## Template Structure

### Layout Hierarchy

```
layouts/
├── _default/
│   └── baseof.html          # Base template
├── partials/
│   ├── header.html          # Site header
│   ├── footer.html          # Site footer
│   ├── language-switcher.html
│   └── location-card.html
├── index.html               # Homepage
├── contact/
│   └── single.html
├── services/
│   └── single.html
└── tarifs/
    └── single.html
```

### baseof.html

Base template that all pages extend:

```html
<!DOCTYPE html>
<html lang="{{ .Site.Language.Lang }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ .Title }} | {{ .Site.Title }}</title>
  
  <!-- SEO -->
  <meta name="description" content="{{ .Description }}">
  <link rel="canonical" href="{{ .Permalink }}">
  
  <!-- Hreflang -->
  {{ range .Translations }}
  <link rel="alternate" hreflang="{{ .Language.Lang }}" href="{{ .Permalink }}">
  {{ end }}
  
  <!-- Styles -->
  {{ $scss := resources.Get "scss/main.scss" }}
  {{ $css := $scss | resources.ToCSS | resources.Minify | resources.Fingerprint }}
  <link rel="stylesheet" href="{{ $css.RelPermalink }}">
</head>
<body>
  {{ partial "header.html" . }}
  
  <main>
    {{ block "main" . }}{{ end }}
  </main>
  
  {{ partial "footer.html" . }}
  
  <!-- Scripts -->
  {{ $js := resources.Get "js/main.js" | js.Build | resources.Minify | resources.Fingerprint }}
  <script src="{{ $js.RelPermalink }}" defer></script>
</body>
</html>
```

### Partial Templates

#### header.html

```html
<header class="header">
  <div class="header-top">
    {{ range .Site.Data.locations.locations }}
    <div class="location-info">
      <span>{{ index .name $.Site.Language.Lang }}</span>
      <a href="tel:{{ .phone }}">
        <i class="fa-solid fa-phone"></i> {{ .phone }}
      </a>
    </div>
    {{ end }}
    
    {{ partial "language-switcher.html" . }}
  </div>
  
  <nav class="nav">
    <ul>
      {{ range .Site.Menus.main }}
      <li>
        <a href="{{ .URL | relLangURL }}">{{ .Name }}</a>
      </li>
      {{ end }}
    </ul>
  </nav>
</header>
```

#### language-switcher.html

```html
<div class="language-switcher">
  {{ range .Site.Languages }}
    {{ if ne $.Site.Language.Lang .Lang }}
      {{ if $.IsTranslated }}
        <a href="{{ .Permalink }}">{{ .LanguageName }}</a>
      {{ else }}
        <a href="{{ .Lang | relLangURL }}">{{ .LanguageName }}</a>
      {{ end }}
    {{ end }}
  {{ end }}
</div>
```

### Data Access

#### Accessing Site Data

```html
<!-- Locations -->
{{ range .Site.Data.locations.locations }}
  <p>{{ index .name $.Site.Language.Lang }}</p>
{{ end }}

<!-- Pricing -->
{{ range .Site.Data.pricing.categories }}
  <h2>{{ index .name $.Site.Language.Lang }}</h2>
  {{ range .services }}
    <p>{{ index .name $.Site.Language.Lang }}: {{ .price }}</p>
  {{ end }}
{{ end }}
```

#### Accessing Translations

```html
<!-- i18n strings -->
<p>{{ i18n "nav.home" }}</p>
<p>{{ i18n "footer.copyright" }}</p>
```

### Template Functions

Common Hugo functions used:

```html
<!-- URL functions -->
{{ .Permalink }}              <!-- Full URL -->
{{ .RelPermalink }}           <!-- Relative URL -->
{{ .URL | relLangURL }}       <!-- Language-aware URL -->

<!-- Content -->
{{ .Title }}                  <!-- Page title -->
{{ .Content }}                <!-- Page content -->
{{ .Description }}            <!-- Page description -->

<!-- Language -->
{{ .Site.Language.Lang }}     <!-- Current language code -->
{{ .IsTranslated }}           <!-- Has translation? -->
{{ .Translations }}           <!-- Get translations -->

<!-- Data -->
{{ .Site.Data.locations }}    <!-- Access data files -->
{{ i18n "key" }}              <!-- Get translation -->

<!-- Resources -->
{{ resources.Get "path" }}    <!-- Get asset -->
{{ $res | resources.ToCSS }}  <!-- Process SCSS -->
{{ $res | resources.Minify }} <!-- Minify -->
{{ $res | resources.Fingerprint }} <!-- Add hash -->
```


## Build Process

### Development Build

```bash
hugo server -D
```

**What happens**:
1. Hugo watches for file changes
2. Rebuilds on save
3. Live reloads browser
4. Serves at `http://localhost:1313`

**Flags**:
- `-D`: Include draft content
- `-p 1314`: Use different port
- `--navigateToChanged`: Auto-navigate to changed page
- `--verbose`: Show detailed output

### Production Build

```bash
hugo --minify
```

**What happens**:
1. Processes all content files
2. Compiles SCSS to CSS
3. Bundles JavaScript
4. Minifies HTML, CSS, JS
5. Generates sitemap.xml
6. Creates RSS feeds
7. Outputs to `public/` directory

**Build Pipeline**:

```
Content (.md) → Hugo → HTML
SCSS → Hugo Pipes → CSS → Minify → Fingerprint
JS → Hugo Pipes → Bundle → Minify → Fingerprint
Images → Copy to public/
Data (.yaml) → Embedded in templates
```

### Asset Processing

#### SCSS Processing

```
assets/scss/main.scss
  ↓ resources.Get
  ↓ resources.ToCSS (SCSS → CSS)
  ↓ resources.Minify
  ↓ resources.Fingerprint
  ↓
public/scss/main.min.[hash].css
```

#### JavaScript Processing

```
assets/js/main.js
  ↓ resources.Get
  ↓ js.Build (Bundle npm packages)
  ↓ resources.Minify
  ↓ resources.Fingerprint
  ↓
public/js/main.[hash].js
```

### Cache Busting

Hugo automatically adds content hashes to filenames:
- `main.min.abc123.css`
- `main.def456.js`

This ensures browsers always get the latest version.

### Build Optimization

#### Minification

Enabled with `--minify` flag:
- HTML: Removes whitespace, comments
- CSS: Removes whitespace, optimizes selectors
- JS: Removes whitespace, shortens variable names

#### Tree Shaking

Font Awesome uses tree shaking:
- Only imported icons are included
- Reduces bundle from 900KB+ to ~20KB

#### Image Optimization

Manual process (recommended tools):
- ImageOptim (Mac)
- TinyPNG (Web)
- squoosh.app (Web)

Convert to WebP for better compression:
```bash
cwebp input.jpg -o output.webp
```

## Deployment

### GitHub Actions Workflow

Located at `.github/workflows/deploy.yml`:

```yaml
name: Deploy Hugo site to Pages

on:
  push:
    branches: ["main", "master"]
  workflow_dispatch:

permissions:
  contents: read
  pages: write
  id-token: write

jobs:
  build:
    runs-on: ubuntu-latest
    steps:
      - name: Checkout
        uses: actions/checkout@v4
        
      - name: Setup Hugo
        uses: peaceiris/actions-hugo@v2
        with:
          hugo-version: '0.156.0'
          extended: true
          
      - name: Setup Node
        uses: actions/setup-node@v4
        with:
          node-version: '20'
          
      - name: Setup pnpm
        uses: pnpm/action-setup@v2
        with:
          version: 8
          
      - name: Install dependencies
        run: |
          cd pause-urbaine-website
          pnpm install
          
      - name: Build
        run: |
          cd pause-urbaine-website
          hugo --minify
          
      - name: Upload artifact
        uses: actions/upload-pages-artifact@v3
        with:
          path: ./pause-urbaine-website/public
          
  deploy:
    environment:
      name: github-pages
      url: ${{ steps.deployment.outputs.page_url }}
    runs-on: ubuntu-latest
    needs: build
    steps:
      - name: Deploy to GitHub Pages
        id: deployment
        uses: actions/deploy-pages@v4
```

### Deployment Flow

```
1. Push to main/master
   ↓
2. GitHub Actions triggered
   ↓
3. Checkout code
   ↓
4. Setup Hugo Extended
   ↓
5. Setup Node.js & pnpm
   ↓
6. Install npm dependencies
   ↓
7. Run hugo --minify
   ↓
8. Upload public/ as artifact
   ↓
9. Deploy to GitHub Pages
   ↓
10. Site live at username.github.io/pause-urbaine/
```

### Manual Deployment

If you need to deploy manually:

```bash
# Build the site
cd pause-urbaine-website
hugo --minify

# The public/ directory contains the built site
# Upload this directory to your hosting provider
```

### Environment Variables

For GitHub Actions, no secrets are needed for GitHub Pages deployment.

For AWS deployment (optional), add these secrets:
- `AWS_ACCESS_KEY_ID`
- `AWS_SECRET_ACCESS_KEY`
- `CLOUDFRONT_DISTRIBUTION_ID`

### Deployment Checklist

Before deploying:

- [ ] Test locally with `hugo server -D`
- [ ] Build with `hugo --minify` (no errors)
- [ ] Check all pages render correctly
- [ ] Test both languages (fr, en)
- [ ] Verify images load
- [ ] Test mobile menu
- [ ] Check console for JavaScript errors
- [ ] Validate HTML (validator.w3.org)
- [ ] Run Lighthouse audit
- [ ] Commit and push to main/master

### Rollback Procedure

If deployment fails or has issues:

1. **Revert to previous commit**:
```bash
git revert HEAD
git push origin master
```

2. **Or checkout previous commit**:
```bash
git log --oneline  # Find previous commit hash
git checkout abc123
git push origin master --force  # Use with caution
```

3. **GitHub Actions will automatically redeploy**

### Monitoring

After deployment:

1. Check GitHub Actions tab for build status
2. Visit the live site
3. Test key functionality:
   - Language switching
   - Navigation
   - Mobile menu
   - Phone/Instagram links
4. Check browser console for errors
5. Verify in multiple browsers

### Performance Monitoring

Use these tools to monitor performance:

- **Lighthouse** (Chrome DevTools): Overall performance score
- **PageSpeed Insights**: Google's performance analysis
- **GTmetrix**: Detailed performance metrics
- **WebPageTest**: Advanced testing with different locations

Target metrics:
- Lighthouse score: > 90
- First Contentful Paint: < 1.5s
- Largest Contentful Paint: < 2.5s
- Time to Interactive: < 3.5s
- Cumulative Layout Shift: < 0.1

## Development Best Practices

### Code Style

#### HTML/Templates
- Use semantic HTML5 elements
- Add ARIA labels for accessibility
- Use proper heading hierarchy (h1 → h2 → h3)
- Include alt text for all images

#### SCSS
- Use variables for colors, spacing, fonts
- Follow BEM naming convention (optional)
- Keep selectors simple and specific
- Use mobile-first media queries

#### JavaScript
- Use modern ES6+ syntax
- Add comments for complex logic
- Handle errors gracefully
- Test in multiple browsers

### Git Workflow

1. Create feature branch:
```bash
git checkout -b feature/new-feature
```

2. Make changes and commit:
```bash
git add .
git commit -m "feat: add new feature"
```

3. Push and create pull request:
```bash
git push origin feature/new-feature
```

4. Merge to main after review

### Testing

#### Local Testing

```bash
# Test development build
hugo server -D

# Test production build
hugo --minify
cd public
python3 -m http.server 8000
```

#### Browser Testing

Test in:
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Mobile Safari (iOS)
- Mobile Chrome (Android)

#### Responsive Testing

Test at these breakpoints:
- 320px (small mobile)
- 375px (mobile)
- 768px (tablet)
- 1024px (desktop)
- 1440px (wide desktop)

#### Accessibility Testing

- Use keyboard navigation (Tab, Enter, Escape)
- Test with screen reader (VoiceOver, NVDA)
- Check color contrast ratios
- Verify ARIA labels

### Debugging

#### Hugo Debugging

```bash
# Verbose output
hugo server -D --verbose

# Show build stats
hugo --templateMetrics

# List all pages
hugo list all

# Check configuration
hugo config
```

#### SCSS Debugging

```bash
# Check for syntax errors
hugo server -D --verbose

# The error will show the file and line number
```

#### JavaScript Debugging

- Use browser DevTools console
- Add `console.log()` statements
- Use breakpoints in DevTools
- Check Network tab for failed requests

### Common Issues

#### "SCSS processing failed"
- Ensure Hugo Extended is installed
- Check SCSS syntax
- Verify all imports exist

#### "Template not found"
- Check template path and filename
- Ensure template is in correct directory
- Check for typos in template name

#### "Page not found (404)"
- Check frontmatter (draft: false)
- Verify filename matches URL
- Check content directory structure

#### "JavaScript not working"
- Check browser console for errors
- Verify script is loaded (Network tab)
- Check for syntax errors
- Ensure DOM is ready before running code

## Additional Resources

### Hugo Documentation
- [Official Docs](https://gohugo.io/documentation/)
- [Template Functions](https://gohugo.io/functions/)
- [Content Management](https://gohugo.io/content-management/)
- [Hugo Pipes](https://gohugo.io/hugo-pipes/)

### SCSS Resources
- [Sass Documentation](https://sass-lang.com/documentation)
- [SCSS Basics](https://sass-lang.com/guide)

### JavaScript Resources
- [MDN Web Docs](https://developer.mozilla.org/)
- [JavaScript.info](https://javascript.info/)

### Tools
- [HTML Validator](https://validator.w3.org/)
- [CSS Validator](https://jigsaw.w3.org/css-validator/)
- [YAML Validator](https://www.yamllint.com/)
- [Markdown Preview](https://markdownlivepreview.com/)

---

Last updated: February 2026
