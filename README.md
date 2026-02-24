# Pause Urbaine Website

Modern, bilingual website for Pause Urbaine hair salon in Geneva, built with Hugo static site generator.

## Overview

Pause Urbaine is a professional hair salon with two locations in Geneva (Plainpalais and Eaux-Vives). This website provides information about services, pricing, and locations in both French and English.

## Features

- **Bilingual Support**: Full French and English translations with automatic language detection
- **Responsive Design**: Mobile-first design that works on all devices
- **Modern UI**: Dark cyberpunk-themed hero banner with neon effects
- **SEO Optimized**: Structured data, canonical URLs, hreflang tags, and sitemap
- **Performance**: Minified assets, lazy loading images, fingerprinted resources
- **Accessibility**: Keyboard navigation, ARIA labels, semantic HTML

## Tech Stack

- **Hugo**: v0.156.0 (extended)
- **SCSS**: Custom styling with variables and components
- **JavaScript**: Vanilla JS for mobile menu and lazy loading
- **Font Awesome**: Tree-shaken icons (~20KB)
- **GitHub Actions**: Automated deployment to GitHub Pages

## Project Structure

```
pause-urbaine-website/
├── archetypes/          # Content templates
├── assets/
│   ├── js/              # JavaScript files
│   │   ├── fontawesome.js
│   │   └── main.js
│   └── scss/            # SCSS stylesheets
│       ├── _variables.scss
│       ├── _layout.scss
│       ├── _components.scss
│       └── main.scss
├── content/             # Markdown content
│   ├── _index.fr.md
│   ├── _index.en.md
│   ├── services.fr.md
│   ├── services.en.md
│   ├── tarifs.fr.md
│   ├── tarifs.en.md
│   ├── contact.fr.md
│   └── contact.en.md
├── data/                # Data files
│   ├── locations.yaml
│   └── pricing.yaml
├── i18n/                # Translation files
│   ├── fr.yaml
│   └── en.yaml
├── layouts/             # Hugo templates
│   ├── _default/
│   │   └── baseof.html
│   ├── partials/
│   │   ├── header.html
│   │   ├── footer.html
│   │   ├── language-switcher.html
│   │   └── location-card.html
│   ├── index.html
│   ├── contact/
│   ├── services/
│   └── tarifs/
├── static/              # Static assets
│   ├── images/
│   │   └── hero-banner.svg
│   ├── robots.txt
│   └── index.html
├── hugo.yaml            # Hugo configuration
└── package.json         # Node dependencies
```

## Local Development

### Prerequisites

- Hugo Extended v0.120+ ([installation guide](https://gohugo.io/installation/))
- Node.js 20+
- pnpm (or npm/yarn)

### Setup

1. Clone the repository:
```bash
git clone <repository-url>
cd pause-urbaine-website
```

2. Install dependencies:
```bash
pnpm install
```

3. Start the development server:
```bash
hugo server -D
```

4. Open your browser to `http://localhost:1313`

### Building for Production

```bash
hugo --minify
```

The built site will be in the `public/` directory.

## Content Management

### Adding/Updating Content

Content files are in `content/` directory using Markdown format with YAML frontmatter.

Example:
```markdown
---
title: "Page Title"
description: "Page description for SEO"
---

Your content here in Markdown format.
```

### Updating Pricing

Edit `data/pricing.yaml` to update service prices and descriptions. The file is structured by categories with bilingual names and prices.

### Updating Locations

Edit `data/locations.yaml` to update salon information (addresses, phone numbers, hours, Instagram links).

### Adding Translations

1. Add translation keys to `i18n/fr.yaml` and `i18n/en.yaml`
2. Use in templates with `{{ i18n "key" }}`

## Deployment

### GitHub Pages (Automatic)

The site automatically deploys to GitHub Pages when you push to the `main` or `master` branch.

1. Enable GitHub Pages in repository settings
2. Set source to "GitHub Actions"
3. Push your changes
4. The workflow will build and deploy automatically

### Manual Deployment

```bash
# Build the site
hugo --minify

# Deploy the public/ directory to your hosting provider
```

## Configuration

### Hugo Configuration

Main configuration is in `hugo.yaml`:
- Base URL
- Language settings
- Menu configuration
- Build options
- SEO settings

### Multilingual Setup

The site uses Hugo's translation-by-filename approach:
- French files: `page.fr.md`
- English files: `page.en.md`
- Default language: French
- Both languages appear in subdirectories: `/fr/` and `/en/`

## Performance

- Minified HTML, CSS, and JavaScript
- Fingerprinted assets for cache busting
- Lazy loading images with IntersectionObserver
- Tree-shaken Font Awesome icons
- Optimized SCSS compilation

## SEO Features

- Structured data (Schema.org HairSalon)
- Canonical URLs on all pages
- Hreflang tags for multilingual content
- XML sitemap generation
- robots.txt
- Open Graph meta tags
- Responsive meta viewport

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Android)

## License

All rights reserved © 2026 Pause Urbaine

## Contact

- Website: https://pauseurbaine.com
- Instagram: [@pauseurbaine](https://www.instagram.com/pauseurbaine/)
- Phone: 022 310 4081

## Locations

**Plainpalais**
Rue de Carouge 52, 1205 Genève

**Eaux-Vives**
Rue du Lac 8-10, 1207 Genève
