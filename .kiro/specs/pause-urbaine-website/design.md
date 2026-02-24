# Pause Urbaine - Design Document

## 1. Architecture Overview

### 1.1 Technology Stack

**Static Site Generator:** Hugo v0.120+
- Native multilingual support (i18n)
- Fast build times (< 5 seconds)
- Markdown content management
- Built-in image processing
- Template system with partials

**Frontend:**
- HTML5 semantic markup
- CSS3 with modern features (Grid, Flexbox)
- Vanilla JavaScript (no framework needed)
- Font Awesome 6 (Free) - tree-shaken, only used icons
- Progressive enhancement approach

**Hosting:**
- Production: AWS S3 + CloudFront + CloudFront Functions
- Development: GitHub Pages
- CI/CD: GitHub Actions

### 1.2 Project Structure

```
pause-urbaine-website/
├── archetypes/           # Content templates
│   └── default.md
├── assets/              # Source assets (SCSS, JS, images)
│   ├── scss/
│   │   ├── main.scss
│   │   ├── _variables.scss
│   │   ├── _layout.scss
│   │   └── _components.scss
│   ├── js/
│   │   ├── main.js
│   │   └── fontawesome.js
│   └── images/
├── content/             # Content files
│   ├── fr/             # French content
│   │   ├── _index.md
│   │   ├── services/
│   │   ├── tarifs/
│   │   ├── contact/
│   │   └── actualites/
│   └── en/             # English content
│       ├── _index.md
│       ├── services/
│       ├── pricing/
│       ├── contact/
│       └── news/
├── data/               # Data files
│   ├── locations.yaml  # Location information
│   └── pricing.yaml    # Pricing data
├── i18n/               # Translation strings
│   ├── fr.yaml
│   └── en.yaml
├── layouts/            # Templates
│   ├── _default/
│   │   ├── baseof.html
│   │   ├── single.html
│   │   └── list.html
│   ├── partials/
│   │   ├── header.html
│   │   ├── footer.html
│   │   ├── language-switcher.html
│   │   └── location-card.html
│   ├── index.html
│   └── 404.html
├── static/             # Static files (copied as-is)
│   ├── images/
│   ├── fonts/
│   └── favicon.ico
├── functions/          # CloudFront Functions
│   └── language-redirect.js
├── config/             # Hugo configuration
│   ├── _default/
│   │   └── config.yaml
│   └── production/
│       └── config.yaml
└── hugo.yaml           # Main config file
```

## 2. Multilingual Architecture

### 2.1 Language Configuration

**Hugo Configuration (hugo.yaml):**
```yaml
defaultContentLanguage: fr
defaultContentLanguageInSubdir: true

languages:
  fr:
    languageCode: fr-FR
    languageName: Français
    weight: 1
    title: Pause Urbaine
    params:
      description: "Salon de coiffure à Genève"
  en:
    languageCode: en-US
    languageName: English
    weight: 2
    title: Pause Urbaine
    params:
      description: "Hair salon in Geneva"
```

### 2.2 URL Structure

- Root: `https://pauseurbaine.com/` → redirects to `/fr/` or `/en/`
- French: `https://pauseurbaine.com/fr/`
- English: `https://pauseurbaine.com/en/`
- Pages: `https://pauseurbaine.com/fr/services/`, `https://pauseurbaine.com/en/services/`

### 2.3 Language Detection & Redirection

**CloudFront Function (language-redirect.js):**
```javascript
function handler(event) {
    var request = event.request;
    var uri = request.uri;
    
    // Only redirect root path
    if (uri === '/' || uri === '') {
        var headers = request.headers;
        var acceptLanguage = headers['accept-language'] ? 
            headers['accept-language'].value : '';
        
        // Check if English is preferred
        if (acceptLanguage.includes('en') && 
            !acceptLanguage.startsWith('fr')) {
            return {
                statusCode: 302,
                statusDescription: 'Found',
                headers: {
                    'location': { value: '/en/' }
                }
            };
        }
        
        // Default to French
        return {
            statusCode: 302,
            statusDescription: 'Found',
            headers: {
                'location': { value: '/fr/' }
            }
        };
    }
    
    return request;
}
```

**GitHub Pages (static redirect):**
- Create `index.html` at root with meta refresh to `/fr/`

### 2.4 Translation Files

**i18n/fr.yaml:**
```yaml
nav:
  home: Accueil
  services: Services
  pricing: Tarifs
  contact: Contact
  news: Actualités
  main: Navigation principale

footer:
  follow_us: Suivez-nous
  opening_hours: Horaires d'ouverture
  locations: Nos salons

common:
  read_more: Lire la suite
  book_now: Prendre rendez-vous
  phone: Téléphone
  address: Adresse
  
locations:
  plainpalais: Plainpalais
  eauxvives: Eaux-Vives
```

**i18n/en.yaml:**
```yaml
nav:
  home: Home
  services: Services
  pricing: Pricing
  contact: Contact
  news: News
  main: Main navigation

footer:
  follow_us: Follow us
  opening_hours: Opening hours
  locations: Our salons

common:
  read_more: Read more
  book_now: Book now
  phone: Phone
  address: Address
  
locations:
  plainpalais: Plainpalais
  eauxvives: Eaux-Vives
```

## 3. Content Management

### 3.1 Content Organization

**Page Types:**
1. Homepage (`_index.md`)
2. Services page (single page)
3. Pricing page (single page)
4. Contact page (single page)
5. News/Blog posts (list + single)

**Content Structure:**
```markdown
---
title: "Services"
date: 2026-02-24
description: "Nos services de coiffure"
menu: main
weight: 2
---

Content here...
```

### 3.2 Data Files

**data/locations.yaml:**
```yaml
locations:
  - id: plainpalais
    name:
      fr: Plainpalais
      en: Plainpalais
    address:
      street: Rue de Carouge 42
      city: Genève
      postal: 1205
      country: Suisse
    phone: "+41 22 XXX XX XX"
    instagram: "@pauseurbaine_plainpalais"
    hours:
      monday: "Fermé"
      tuesday: "9h00 - 19h00"
      wednesday: "9h00 - 19h00"
      thursday: "9h00 - 19h00"
      friday: "9h00 - 19h00"
      saturday: "9h00 - 18h00"
      sunday: "Fermé"
    
  - id: eauxvives
    name:
      fr: Eaux-Vives
      en: Eaux-Vives
    address:
      street: Rue du Lac 15
      city: Genève
      postal: 1207
      country: Suisse
    phone: "+41 22 YYY YY YY"
    instagram: "@pauseurbaine_eauxvives"
    hours:
      monday: "Fermé"
      tuesday: "9h00 - 19h00"
      wednesday: "9h00 - 19h00"
      thursday: "9h00 - 19h00"
      friday: "9h00 - 19h00"
      saturday: "9h00 - 18h00"
      sunday: "Fermé"
```

**data/pricing.yaml:**
```yaml
categories:
  - name:
      fr: Coupes
      en: Haircuts
    services:
      - name:
          fr: Coupe femme
          en: Women's haircut
        price: "CHF 65"
        duration: "45 min"
      
      - name:
          fr: Coupe homme
          en: Men's haircut
        price: "CHF 45"
        duration: "30 min"
  
  - name:
      fr: Colorations
      en: Coloring
    services:
      - name:
          fr: Coloration complète
          en: Full color
        price: "CHF 120"
        duration: "2h"
```

## 4. Template Design

### 4.1 Base Template (baseof.html)

```html
<!DOCTYPE html>
<html lang="{{ .Language.Lang }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ .Title }} | {{ .Site.Title }}</title>
    <meta name="description" content="{{ .Description | default .Site.Params.description }}">
    
    <!-- Multilingual SEO -->
    {{ range .Translations }}
    <link rel="alternate" hreflang="{{ .Language.Lang }}" href="{{ .Permalink }}">
    {{ end }}
    <link rel="alternate" hreflang="x-default" href="{{ .Site.BaseURL }}">
    
    <!-- Open Graph -->
    <meta property="og:title" content="{{ .Title }}">
    <meta property="og:description" content="{{ .Description }}">
    <meta property="og:locale" content="{{ .Language.Lang }}">
    
    <!-- Styles -->
    {{ $style := resources.Get "scss/main.scss" | toCSS | minify | fingerprint }}
    <link rel="stylesheet" href="{{ $style.Permalink }}">
</head>
<body>
    {{ partial "header.html" . }}
    
    <main>
        {{ block "main" . }}{{ end }}
    </main>
    
    {{ partial "footer.html" . }}
    
    <!-- Scripts -->
    {{ $fontawesome := resources.Get "js/fontawesome.js" | js.Build (dict "minify" true "target" "es2018") | fingerprint }}
    <script src="{{ $fontawesome.Permalink }}" defer></script>
    
    {{ $js := resources.Get "js/main.js" | minify | fingerprint }}
    <script src="{{ $js.Permalink }}" defer></script>
</body>
</html>
```

### 4.2 Header Partial (header.html)

```html
<header class="site-header">
    <div class="container">
        <!-- Top bar with locations info -->
        <div class="header-top">
            {{ $locations := .Site.Data.locations.locations }}
            <div class="locations-bar">
                {{ range $locations }}
                <div class="location-quick-info">
                    <span class="location-name">
                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                        {{ index .name $.Site.Language.Lang }}
                    </span>
                    <a href="tel:{{ .phone }}" class="phone-link" aria-label="{{ i18n "common.phone" }} {{ index .name $.Site.Language.Lang }}">
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        {{ .phone }}
                    </a>
                    <a href="https://instagram.com/{{ strings.TrimPrefix "@" .instagram }}" 
                       class="instagram-link" 
                       target="_blank" 
                       rel="noopener"
                       aria-label="Instagram {{ index .name $.Site.Language.Lang }}">
                        <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                        {{ .instagram }}
                    </a>
                </div>
                {{ end }}
            </div>
            
            {{ partial "language-switcher.html" . }}
        </div>
        
        <!-- Main header with logo and navigation -->
        <div class="header-main">
            <a href="{{ .Site.Home.Permalink }}" class="logo">
                <img src="/images/logo.svg" alt="{{ .Site.Title }}">
            </a>
            
            <nav class="main-nav" aria-label="{{ i18n "nav.main" }}">
                <ul>
                    <li><a href="{{ "services" | relLangURL }}">{{ i18n "nav.services" }}</a></li>
                    <li><a href="{{ "tarifs" | relLangURL }}">{{ i18n "nav.pricing" }}</a></li>
                    <li><a href="{{ "contact" | relLangURL }}">{{ i18n "nav.contact" }}</a></li>
                    <li><a href="{{ "actualites" | relLangURL }}">{{ i18n "nav.news" }}</a></li>
                </ul>
            </nav>
            
            <button class="mobile-menu-toggle" aria-label="Menu">
                <i class="fa-solid fa-bars" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</header>
```

### 4.3 Language Switcher (language-switcher.html)

```html
<div class="language-switcher">
    {{ range .Site.Languages }}
        {{ if eq . $.Language }}
            <span class="lang-active">{{ .LanguageName }}</span>
        {{ else }}
            {{ if $.IsTranslated }}
                <a href="{{ $.Permalink | relLangURL }}" lang="{{ .Lang }}">
                    {{ .LanguageName }}
                </a>
            {{ else }}
                <a href="{{ .Lang | relLangURL }}" lang="{{ .Lang }}">
                    {{ .LanguageName }}
                </a>
            {{ end }}
        {{ end }}
    {{ end }}
</div>
```

### 4.4 Location Card Partial (location-card.html)

```html
{{ $location := . }}
{{ $lang := $.Site.Language.Lang }}

<div class="location-card">
    <h3>
        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
        {{ index $location.name $lang }}
    </h3>
    
    <div class="location-info">
        <div class="address">
            <p>
                <i class="fa-solid fa-map-marker-alt" aria-hidden="true"></i>
                {{ $location.address.street }}<br>
                {{ $location.address.postal }} {{ $location.address.city }}<br>
                {{ $location.address.country }}
            </p>
        </div>
        
        <div class="contact">
            <p>
                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                <a href="tel:{{ $location.phone }}">{{ $location.phone }}</a>
            </p>
            <p>
                <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                <a href="https://instagram.com/{{ strings.TrimPrefix "@" $location.instagram }}" 
                   target="_blank" rel="noopener">
                    {{ $location.instagram }}
                </a>
            </p>
        </div>
        
        <div class="hours">
            <p class="hours-title">
                <i class="fa-solid fa-clock" aria-hidden="true"></i>
                <strong>{{ i18n "footer.opening_hours" }}:</strong>
            </p>
            <ul>
                {{ range $day, $hours := $location.hours }}
                <li>{{ $day | humanize }}: {{ $hours }}</li>
                {{ end }}
            </ul>
        </div>
    </div>
</div>
```

## 5. Styling Architecture

### 5.1 SCSS Structure

**assets/scss/_variables.scss:**
```scss
// Colors
$primary-color: #2c3e50;
$secondary-color: #e8b4b8;
$accent-color: #d4a5a5;
$text-color: #333;
$bg-color: #fff;
$light-gray: #f5f5f5;

// Typography
$font-family-base: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
$font-family-heading: 'Playfair Display', serif;

$font-size-base: 16px;
$line-height-base: 1.6;

// Breakpoints
$breakpoint-mobile: 480px;
$breakpoint-tablet: 768px;
$breakpoint-desktop: 1024px;
$breakpoint-wide: 1280px;

// Spacing
$spacing-unit: 1rem;
$container-max-width: 1200px;
```

**assets/scss/_layout.scss:**
```scss
.container {
    max-width: $container-max-width;
    margin: 0 auto;
    padding: 0 $spacing-unit;
}

.site-header {
    background: $bg-color;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 100;
    
    .header-top {
        background: $light-gray;
        padding: 0.5rem 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.875rem;
    }
    
    .locations-bar {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }
    
    .location-quick-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        
        .location-name {
            font-weight: 600;
            color: $primary-color;
        }
        
        .phone-link,
        .instagram-link {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            text-decoration: none;
            color: $text-color;
            transition: color 0.3s;
            
            &:hover {
                color: $primary-color;
            }
        }
        
        i {
            margin-right: 0.25rem;
        }
    }
    
    .header-main {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: $spacing-unit 0;
    }
}

.main-nav {
    ul {
        display: flex;
        gap: 2rem;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    
    a {
        text-decoration: none;
        color: $text-color;
        font-weight: 500;
        transition: color 0.3s;
        
        &:hover {
            color: $primary-color;
        }
    }
}

@media (max-width: $breakpoint-tablet) {
    .site-header {
        .header-top {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
        }
        
        .locations-bar {
            flex-direction: column;
            gap: 0.5rem;
            width: 100%;
        }
        
        .location-quick-info {
            flex-wrap: wrap;
            font-size: 0.8rem;
        }
    }
    
    .main-nav {
        display: none;
        
        &.is-open {
            display: block;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: $bg-color;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            
            ul {
                flex-direction: column;
                padding: $spacing-unit;
            }
        }
    }
}
```

### 5.2 Responsive Design

- Mobile-first approach
- Breakpoints: 480px, 768px, 1024px, 1280px
- Flexible grid system
- Touch-friendly interactive elements (min 44x44px)

## 6. JavaScript Functionality

### 6.1 Font Awesome Configuration (assets/js/fontawesome.js)

```javascript
// Font Awesome tree-shaking configuration
// Only import icons that are actually used in the site
import { library, dom } from '@fortawesome/fontawesome-svg-core';

// Solid icons
import { 
    faPhone,
    faLocationDot,
    faMapMarkerAlt,
    faClock,
    faBars,
    faTimes,
    faEnvelope,
    faChevronDown,
    faChevronUp
} from '@fortawesome/free-solid-svg-icons';

// Brand icons
import { 
    faInstagram,
    faFacebook
} from '@fortawesome/free-brands-svg-icons';

// Add only the icons we use to the library
library.add(
    // Solid
    faPhone,
    faLocationDot,
    faMapMarkerAlt,
    faClock,
    faBars,
    faTimes,
    faEnvelope,
    faChevronDown,
    faChevronUp,
    // Brands
    faInstagram,
    faFacebook
);

// Replace any existing <i> tags with <svg> and set up a MutationObserver to watch for new icons
dom.watch();
```

### 6.2 Main Script (assets/js/main.js)

```javascript
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const mainNav = document.querySelector('.main-nav');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', () => {
            mainNav.classList.toggle('is-open');
            menuToggle.classList.toggle('is-active');
            
            // Update icon
            const icon = menuToggle.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            }
        });
    }
    
    // Lazy load images
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
});
```

## 7. Image Processing

### 7.1 Hugo Image Processing

```html
{{ $image := resources.Get "images/hero.jpg" }}
{{ $webp := $image.Resize "1200x webp" }}
{{ $jpg := $image.Resize "1200x jpg" }}

<picture>
    <source srcset="{{ $webp.RelPermalink }}" type="image/webp">
    <img src="{{ $jpg.RelPermalink }}" 
         alt="{{ .Title }}"
         width="{{ $jpg.Width }}"
         height="{{ $jpg.Height }}"
         loading="lazy">
</picture>
```

### 7.2 Image Optimization

- Convert to WebP with JPEG fallback
- Responsive images with srcset
- Lazy loading for below-the-fold images
- Proper width/height attributes to prevent layout shift

## 8. SEO Implementation

### 8.1 Structured Data (Schema.org)

```html
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "HairSalon",
    "name": "Pause Urbaine",
    "image": "{{ .Site.BaseURL }}/images/logo.png",
    "url": "{{ .Site.BaseURL }}",
    "telephone": "+41 22 XXX XX XX",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "Rue de Carouge 42",
        "addressLocality": "Genève",
        "postalCode": "1205",
        "addressCountry": "CH"
    },
    "openingHoursSpecification": [
        {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Tuesday", "Wednesday", "Thursday", "Friday"],
            "opens": "09:00",
            "closes": "19:00"
        },
        {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": "Saturday",
            "opens": "09:00",
            "closes": "18:00"
        }
    ],
    "sameAs": [
        "https://instagram.com/pauseurbaine"
    ]
}
</script>
```

### 8.2 Sitemap Configuration

Hugo automatically generates sitemap.xml with all language versions.

## 9. Deployment Architecture

### 9.1 GitHub Actions Workflow

```yaml
name: Deploy to AWS S3 and GitHub Pages

on:
  push:
    branches: [main]
  workflow_dispatch:

jobs:
  build:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
        with:
          submodules: true
          fetch-depth: 0
      
      - name: Setup Hugo
        uses: peaceiris/actions-hugo@v2
        with:
          hugo-version: 'latest'
          extended: true
      
      - name: Build
        run: hugo --minify
      
      - name: Deploy to GitHub Pages
        uses: peaceiris/actions-gh-pages@v3
        with:
          github_token: ${{ secrets.GITHUB_TOKEN }}
          publish_dir: ./public
      
      - name: Deploy to S3
        run: |
          aws s3 sync ./public s3://pauseurbaine.com --delete
          aws cloudfront create-invalidation --distribution-id ${{ secrets.CLOUDFRONT_ID }} --paths "/*"
        env:
          AWS_ACCESS_KEY_ID: ${{ secrets.AWS_ACCESS_KEY_ID }}
          AWS_SECRET_ACCESS_KEY: ${{ secrets.AWS_SECRET_ACCESS_KEY }}
          AWS_REGION: eu-west-1
```

### 9.2 AWS Infrastructure

**S3 Bucket Configuration:**
- Bucket name: `pauseurbaine.com`
- Static website hosting enabled
- Public read access via bucket policy
- CORS configuration for fonts/assets

**CloudFront Distribution:**
- Origin: S3 bucket
- Custom domain: pauseurbaine.com
- SSL certificate (ACM)
- CloudFront Function association: language-redirect (viewer request)
- Cache behavior: Cache based on Accept-Language header
- Compression enabled (gzip, brotli)
- Origin Access Control (OAC) for S3 security

**CloudFront Function (NOT Lambda@Edge):**
- Attached to viewer request event
- Handles language detection and redirection
- Lightweight (< 10KB, runs in CloudFront edge locations)
- No additional Lambda costs
- Sub-millisecond execution time

## 10. Performance Optimization

### 10.1 Build Optimization

- Minify HTML, CSS, JS
- Fingerprint assets for cache busting
- Generate WebP images
- Inline critical CSS
- Defer non-critical JavaScript
- Tree-shake Font Awesome (only include used icons)
- Bundle JavaScript with Hugo Pipes (js.Build)

### 10.2 Caching Strategy

**CloudFront Cache Policies:**
- HTML: Cache for 1 hour, revalidate
- Assets (CSS/JS with fingerprint): Cache for 1 year
- Images: Cache for 1 month
- Fonts: Cache for 1 year

### 10.3 Performance Targets

- First Contentful Paint: < 1.5s
- Largest Contentful Paint: < 2.5s
- Time to Interactive: < 3.5s
- Cumulative Layout Shift: < 0.1
- Lighthouse Score: > 90 (all categories)

## 11. Accessibility

### 11.1 WCAG 2.1 Level AA Compliance

- Semantic HTML5 elements
- ARIA labels where needed
- Keyboard navigation support
- Focus indicators
- Color contrast ratio > 4.5:1
- Alt text for all images
- Skip to main content link
- Responsive text sizing

### 11.2 Language Accessibility

- `lang` attribute on HTML element
- `hreflang` for language alternatives
- Clear language switcher
- Consistent navigation across languages

## 12. Content Migration Strategy

### 12.1 WordPress Export Processing

1. Parse `WordPress.2026-02-20.xml`
2. Extract posts and pages
3. Convert HTML to Markdown
4. Download and optimize images
5. Create frontmatter with metadata
6. Organize into content structure

### 12.2 Pricing Data Extraction

1. OCR `tarifs-2026.jpeg`
2. Structure data into YAML format
3. Create bilingual pricing entries
4. Validate pricing information

## 13. Testing Strategy

### 13.1 Manual Testing

- Cross-browser testing (Chrome, Firefox, Safari, Edge)
- Mobile device testing (iOS, Android)
- Language switching functionality
- All links and navigation
- Form submissions (if any)

### 13.2 Automated Testing

- Lighthouse CI in GitHub Actions
- HTML validation
- Link checking
- Accessibility testing (axe-core)

### 13.3 Performance Testing

- WebPageTest
- Google PageSpeed Insights
- Core Web Vitals monitoring

## 14. Documentation

### 14.1 User Documentation (French)

**Guide d'ajout de contenu:**
1. Créer un fichier Markdown dans `content/fr/actualites/`
2. Ajouter le frontmatter requis
3. Écrire le contenu en Markdown
4. Ajouter des images dans `static/images/`
5. Commit et push vers GitHub
6. Le site se met à jour automatiquement

### 14.2 Developer Documentation

- Setup instructions
- Build commands
- Deployment process
- Theme customization guide
- Troubleshooting common issues

## 15. Maintenance Plan

### 15.1 Regular Updates

- Hugo version updates (quarterly)
- Dependency updates (monthly)
- Content updates (as needed)
- Security patches (as released)

### 15.2 Monitoring

- CloudWatch for AWS metrics
- GitHub Actions for build status
- Uptime monitoring (UptimeRobot or similar)
- Analytics (privacy-friendly: Plausible or Fathom)

## 16. Future Enhancements (Phase 2)

- Online booking system integration
- Customer reviews/testimonials
- Photo gallery with lightbox
- Blog with categories and tags
- Newsletter subscription
- Additional languages (German, Italian)
- Progressive Web App (PWA) features


## 17. Cost Optimization

### 17.1 AWS Cost Breakdown (Estimated Monthly)

**S3 Storage:**
- Static website files: ~100MB
- Cost: ~$0.02/month (first 50TB is $0.023/GB)

**CloudFront:**
- Data transfer: ~10GB/month (estimated)
- Cost: ~$0.85/month (first 10TB is $0.085/GB)
- Requests: ~100,000/month
- Cost: ~$0.10/month ($0.0075 per 10,000 HTTPS requests)

**CloudFront Functions:**
- Included in CloudFront pricing
- No additional Lambda@Edge costs
- Cost: $0.00 (free tier covers typical usage)

**Route 53 (if used):**
- Hosted zone: $0.50/month
- Queries: negligible

**Total Estimated Cost: ~$1.50-2.00/month**

### 17.2 Cost Optimization Strategies

1. **Use CloudFront Functions instead of Lambda@Edge**
   - No Lambda invocation costs
   - No Lambda duration costs
   - Included in CloudFront pricing

2. **Optimize Cache Hit Ratio**
   - Long cache TTLs for static assets
   - Proper cache key configuration
   - Reduces origin requests to S3

3. **Image Optimization**
   - WebP format reduces bandwidth
   - Responsive images reduce unnecessary data transfer
   - Lazy loading reduces initial page load

4. **Minimize CloudFront Invalidations**
   - Use versioned/fingerprinted assets
   - Only invalidate when necessary
   - Batch invalidations when possible

5. **S3 Lifecycle Policies**
   - Delete old deployment artifacts
   - Keep only necessary files

6. **Free Tier Benefits**
   - CloudFront: 1TB data transfer out/month (12 months)
   - S3: 5GB storage, 20,000 GET requests (12 months)
   - Lambda: Not needed (using CloudFront Functions)

### 17.3 Monitoring Costs

- Enable AWS Cost Explorer
- Set up billing alerts at $5/month threshold
- Review CloudWatch metrics monthly
- Monitor CloudFront usage patterns

### 17.4 GitHub Pages Alternative (Free)

For development/staging:
- Completely free hosting
- No bandwidth limits
- HTTPS included
- Limited to static content only
- No CloudFront Function (simple redirect to /fr/)


## 18. Font Awesome Integration

### 18.1 Installation

```bash
npm install --save @fortawesome/fontawesome-svg-core \
                   @fortawesome/free-solid-svg-icons \
                   @fortawesome/free-brands-svg-icons
```

### 18.2 Tree-Shaking Strategy

**Benefits:**
- Only icons actually used are included in the bundle
- Reduces JavaScript bundle size significantly
- Typical bundle: ~20KB (vs 900KB+ for full Font Awesome)
- Better performance and faster page loads

**Icons Used:**
- `fa-phone` - Phone numbers
- `fa-location-dot` - Location markers
- `fa-map-marker-alt` - Address markers
- `fa-clock` - Opening hours
- `fa-bars` - Mobile menu (open)
- `fa-times` - Mobile menu (close)
- `fa-envelope` - Email contact
- `fa-chevron-down` - Dropdowns/accordions
- `fa-chevron-up` - Dropdowns/accordions
- `fa-instagram` (brand) - Instagram links
- `fa-facebook` (brand) - Facebook links (if needed)

### 18.3 Hugo Build Configuration

Hugo's `js.Build` function uses esbuild to:
1. Bundle JavaScript modules
2. Tree-shake unused code
3. Minify the output
4. Support ES6+ syntax

**package.json:**
```json
{
  "name": "pause-urbaine-website",
  "version": "1.0.0",
  "private": true,
  "dependencies": {
    "@fortawesome/fontawesome-svg-core": "^6.5.0",
    "@fortawesome/free-solid-svg-icons": "^6.5.0",
    "@fortawesome/free-brands-svg-icons": "^6.5.0"
  }
}
```

### 18.4 Adding New Icons

To add a new icon:

1. Import it in `assets/js/fontawesome.js`:
```javascript
import { faNewIcon } from '@fortawesome/free-solid-svg-icons';
```

2. Add to library:
```javascript
library.add(faNewIcon);
```

3. Use in templates:
```html
<i class="fa-solid fa-new-icon" aria-hidden="true"></i>
```

### 18.5 Performance Impact

**Before tree-shaking (full Font Awesome):**
- CSS: ~75KB (gzipped)
- Webfonts: ~400KB
- Total: ~475KB

**After tree-shaking (10 icons):**
- JavaScript: ~20KB (gzipped)
- No webfonts needed
- Total: ~20KB

**Savings: ~95% reduction in icon-related assets**
