# Implementation Plan: Pause Urbaine Website

## Overview

This implementation plan covers the development of a bilingual (French/English) static website for Pause Urbaine hair salon using Hugo. The site will be hosted on AWS S3 + CloudFront (production) and GitHub Pages (development), with automated deployment via GitHub Actions.

## Tasks

- [x] 1. Initialize Hugo project and configure multilingual support
  - Install Hugo extended v0.120+
  - Create hugo.yaml with French (default) and English language configuration
  - Enable defaultContentLanguageInSubdir for /fr/ and /en/ URL structure
  - Set up content directory structure (content/fr/, content/en/)
  - Create .gitignore for Hugo, Node.js, and system files
  - _Requirements: 4.1, 3.6_

- [x] 2. Set up Font Awesome with tree-shaking
  - Create package.json with @fortawesome dependencies
  - Install npm packages (@fortawesome/fontawesome-svg-core, free-solid-svg-icons, free-brands-svg-icons)
  - Create assets/js/fontawesome.js with selective icon imports
  - Import only used icons (phone, location-dot, clock, bars, times, instagram, etc.)
  - Configure library and dom.watch() for SVG replacement
  - _Requirements: 4.1, 4.3_

- [x] 3. Create translation files for UI strings
  - Create i18n/fr.yaml with French translations (navigation, footer, common strings)
  - Create i18n/en.yaml with English translations
  - Add labels for: navigation menu, footer sections, common actions, location names
  - Ensure consistency between language files
  - _Requirements: 3.6, 4.1_


- [x] 4. Create location data structure
  - Create data/locations.yaml with array of location objects
  - Add Plainpalais location: address, phone (+41 22 XXX XX XX), Instagram handle, opening hours
  - Add Eaux-Vives location: address, phone (+41 22 YYY YY YY), Instagram handle, opening hours
  - Include bilingual name fields (fr/en) for each location
  - Structure hours as key-value pairs (monday: "Fermé", tuesday: "9h00 - 19h00", etc.)
  - _Requirements: 3.5_

- [x] 5. Extract and structure pricing data
  - Process tarifs-2026.jpeg (OCR or manual extraction)
  - Create data/pricing.yaml with categories array
  - Organize by service categories (Coupes, Colorations, Soins, etc.)
  - For each service: add bilingual name (fr/en), price (CHF), duration
  - Validate all pricing data for accuracy
  - _Requirements: 3.4, 5.2_

- [x] 6. Migrate WordPress content to Markdown
  - Parse WordPress.2026-02-20.xml export file
  - Extract posts and pages with metadata (title, date, author)
  - Convert HTML content to Markdown format
  - Download referenced images from WordPress
  - Optimize images (resize, compress, generate WebP versions)
  - Create content files in content/fr/actualites/ with proper frontmatter
  - Create English translations for homepage, services, pricing, and contact pages
  - _Requirements: 5.1, 3.2_


- [x] 7. Create SCSS architecture and styling
  - Create assets/scss/_variables.scss (colors, typography, breakpoints, spacing)
  - Define color palette (primary: #2c3e50, secondary: #e8b4b8, accent: #d4a5a5)
  - Set font families (base: Inter, heading: Playfair Display)
  - Define responsive breakpoints (mobile: 480px, tablet: 768px, desktop: 1024px, wide: 1280px)
  - Create assets/scss/_layout.scss (container, header, footer, grid system)
  - Create assets/scss/_components.scss (buttons, cards, forms, navigation)
  - Create assets/scss/main.scss to import all partials
  - Implement mobile-first responsive design
  - _Requirements: 3.1, 4.3_

- [x] 8. Optimize and prepare images
  - Download Logo-Pause-Urbaine-2022 from WordPress
  - Convert logo to SVG format if needed, optimize for web
  - Save logo to static/images/logo.svg
  - Download hero images and service photos from WordPress
  - Resize images to appropriate dimensions (max 1920px width)
  - Generate WebP versions of all images using Hugo image processing
  - Create responsive image srcsets for different screen sizes
  - _Requirements: 4.3, 5.1_


- [x] 9. Create base template with SEO and multilingual support
  - Create layouts/_default/baseof.html
  - Add HTML5 doctype with dynamic lang attribute ({{ .Language.Lang }})
  - Add meta tags: charset UTF-8, viewport, description
  - Add hreflang links for all translations ({{ range .Translations }})
  - Add x-default hreflang pointing to site root
  - Add Open Graph meta tags (og:title, og:description, og:locale)
  - Link SCSS stylesheet using Hugo Pipes (resources.Get | toCSS | minify | fingerprint)
  - Add Font Awesome script using js.Build with minify and fingerprint
  - Add main.js script with defer attribute
  - Include header and footer partials
  - _Requirements: 3.6, 4.4_

- [x] 10. Create header partial with location info and navigation
  - Create layouts/partials/header.html
  - Add header-top section with locations bar
  - Loop through .Site.Data.locations.locations
  - Display each location with: name, phone (tel: link), Instagram link
  - Add Font Awesome icons: fa-location-dot, fa-phone, fa-instagram
  - Include language switcher partial
  - Add header-main section with logo linked to homepage
  - Create main navigation with links: Services, Tarifs, Contact, Actualités
  - Use relLangURL for language-aware links
  - Add mobile menu toggle button with fa-bars icon
  - Implement sticky header with box-shadow
  - _Requirements: 3.5, 3.7_

- [x] 11. Create language switcher partial
  - Create layouts/partials/language-switcher.html
  - Loop through .Site.Languages
  - Highlight active language with .lang-active class
  - Check if current page is translated ({{ if $.IsTranslated }})
  - Link to translated version if available, otherwise link to language home
  - Add proper lang attributes to links
  - Style as inline list with separator
  - _Requirements: 3.6_

- [x] 12. Create footer partial
  - Create layouts/partials/footer.html
  - Display both locations with contact information
  - Add social media links (Instagram for each location)
  - Display opening hours summary
  - Add copyright notice with current year
  - Include links to main pages
  - Ensure responsive layout (stack on mobile)
  - _Requirements: 3.7_

- [~] 13. Create location card partial
  - Create layouts/partials/location-card.html
  - Accept location data as parameter
  - Display location name with fa-location-dot icon
  - Display full address with fa-map-marker-alt icon
  - Display clickable phone link with fa-phone icon
  - Display Instagram link with fa-instagram icon
  - Display opening hours table with fa-clock icon
  - Use i18n for "Opening hours" label
  - Style as card with border and padding
  - _Requirements: 3.5_


- [~] 14. Create homepage template
  - Create layouts/index.html extending baseof.html
  - Add hero section with background image and welcome text
  - Display site title and tagline
  - Add section displaying 3 most recent articles from actualites
  - Use .Site.RegularPages.ByDate.Reverse to get latest posts
  - Display article title, date, excerpt with "Read more" link
  - Add call-to-action buttons (View Services, See Pricing)
  - Display both locations using location-card partial
  - Ensure responsive layout (stack sections on mobile)
  - _Requirements: 3.1_

- [~] 15. Create services page template
  - Create content/fr/services/_index.md and content/en/services/_index.md
  - Use layouts/_default/single.html or create layouts/services/single.html
  - Display page title and description
  - Render markdown content with service descriptions
  - Organize services by categories if needed
  - Add link to pricing page at bottom
  - Include call-to-action for booking
  - _Requirements: 3.3_

- [~] 16. Create pricing page template
  - Create content/fr/tarifs/_index.md and content/en/pricing/_index.md
  - Create layouts/pricing/single.html or use _default/single.html
  - Loop through .Site.Data.pricing.categories
  - Display category name (index .name $.Site.Language.Lang)
  - For each service in category: display name, price, duration
  - Use responsive table or card layout
  - Add note about price variations if applicable
  - Include contact information for bookings
  - _Requirements: 3.4_

- [~] 17. Create contact page template
  - Create content/fr/contact/_index.md and content/en/contact/_index.md
  - Create layouts/contact/single.html or use _default/single.html
  - Display both locations using location-card partial
  - Add Google Maps embed for each location (optional)
  - Include contact form or link to external booking system (optional)
  - Display opening hours prominently
  - _Requirements: 3.5_

- [~] 18. Create news/blog templates
  - Create layouts/actualites/list.html for blog listing page
  - Display list of articles with title, date, excerpt
  - Add pagination if more than 10 articles
  - Create layouts/actualites/single.html for individual posts
  - Display post title, publication date, featured image
  - Render full markdown content
  - Add "Back to news" link
  - Include social sharing buttons (optional)
  - _Requirements: 3.1, 3.2_

- [~] 19. Create 404 error page
  - Create layouts/404.html
  - Add friendly error message in both languages
  - Detect current language from URL path
  - Display links to homepage and main sections
  - Use same header/footer as other pages
  - Style consistently with site design
  - _Requirements: 4.2_


- [~] 20. Implement mobile menu functionality
  - Create assets/js/main.js
  - Add DOMContentLoaded event listener
  - Select mobile menu toggle button and main nav elements
  - Add click event listener to toggle button
  - Toggle .is-open class on nav element
  - Toggle .is-active class on button
  - Switch icon between fa-bars and fa-times
  - Add keyboard support: Escape key closes menu
  - Add click-outside-to-close functionality
  - _Requirements: 3.7_

- [~] 21. Implement lazy loading for images
  - In assets/js/main.js, add IntersectionObserver
  - Select all images with data-src attribute
  - Observe each image for viewport intersection
  - When image enters viewport: set src from data-src, add .loaded class
  - Add CSS transition for fade-in effect on .loaded class
  - Provide fallback for browsers without IntersectionObserver support
  - Update image templates to use data-src for below-fold images
  - _Requirements: 4.3_


- [~] 22. Create CloudFront Function for language detection
  - Create functions/language-redirect.js
  - Implement handler function that receives event with request object
  - Check if request.uri is root path ('/' or '')
  - Parse Accept-Language header from request.headers
  - Detect if English is preferred (check if 'en' appears before 'fr')
  - Return 302 redirect response to /en/ if English preferred
  - Return 302 redirect response to /fr/ as default
  - Pass through all other requests unchanged
  - Ensure function size < 10KB (CloudFront Function limit)
  - Test function logic with sample Accept-Language values
  - _Requirements: 3.6, 4.2_


- [ ]* 23. Configure AWS S3 bucket for static hosting
  - Create S3 bucket named "pauseurbaine.com"
  - Enable static website hosting in bucket properties
  - Set index document to "index.html"
  - Set error document to "404.html"
  - Create bucket policy for public read access to all objects
  - Enable versioning for rollback capability (optional)
  - Configure CORS if needed for fonts/assets
  - _Requirements: 4.2_

- [ ]* 24. Set up CloudFront distribution
  - Create new CloudFront distribution in AWS Console
  - Set S3 bucket as origin
  - Configure Origin Access Control (OAC) for secure S3 access
  - Set default root object to "index.html"
  - Enable compression (gzip and brotli)
  - Configure custom error response: 404 → /404.html
  - Set cache behavior to vary on Accept-Language header
  - Create cache policy with appropriate TTLs (HTML: 1h, assets: 1y)
  - Enable HTTP/2 and HTTP/3 support
  - _Requirements: 4.2, 4.3_

- [ ]* 25. Configure SSL certificate and custom domain
  - Request SSL certificate in AWS Certificate Manager (ACM) in us-east-1 region
  - Add domain validation records to DNS
  - Wait for certificate validation to complete
  - Attach validated certificate to CloudFront distribution
  - Configure alternate domain names (CNAMEs): pauseurbaine.com, www.pauseurbaine.com
  - Enable "Redirect HTTP to HTTPS" in CloudFront
  - _Requirements: 4.2_

- [ ]* 26. Deploy CloudFront Function for language detection
  - Open CloudFront Functions in AWS Console
  - Create new function named "language-redirect"
  - Copy code from functions/language-redirect.js
  - Test function with sample events (different Accept-Language headers)
  - Publish function to LIVE stage
  - Associate function with CloudFront distribution (viewer request event)
  - Test language detection with curl commands using different Accept-Language headers
  - _Requirements: 3.6, 4.2_

- [ ]* 27. Configure DNS for custom domain
  - Access DNS provider for pauseurbaine.com
  - Create A record (or ALIAS if Route 53) pointing to CloudFront distribution
  - Create AAAA record for IPv6 support (optional)
  - Wait for DNS propagation (can take up to 48 hours)
  - Verify site is accessible via custom domain
  - Test HTTPS certificate is working correctly
  - _Requirements: 4.2_


- [x] 28. Configure GitHub Pages for development environment
  - Create gh-pages branch in repository
  - Enable GitHub Pages in repository settings
  - Set source to gh-pages branch
  - Configure custom domain if desired (optional)
  - Enable HTTPS enforcement
  - _Requirements: 4.2_

- [x] 29. Create root redirect for GitHub Pages
  - Create static/index.html with meta refresh tag
  - Set refresh to redirect to /fr/ after 0 seconds
  - Add JavaScript fallback: window.location.href = '/fr/'
  - Add noscript message for users without JavaScript
  - Test redirect works on GitHub Pages
  - _Requirements: 3.6, 4.2_


- [x] 30. Create GitHub Actions workflow for automated deployment
  - Create .github/workflows/deploy.yml
  - Configure workflow to trigger on push to main branch
  - Add manual workflow_dispatch trigger
  - Add checkout step with submodules and full fetch-depth
  - Add Hugo setup step using peaceiris/actions-hugo@v2 (extended: true)
  - Add npm install step for Font Awesome dependencies
  - Add Hugo build step with --minify flag
  - Add deploy to GitHub Pages step using peaceiris/actions-gh-pages@v3
  - _Requirements: 4.2_

- [ ]* 31. Add AWS deployment to GitHub Actions workflow
  - Add AWS S3 sync step to deploy.yml
  - Sync ./public directory to s3://pauseurbaine.com with --delete flag
  - Add CloudFront cache invalidation step
  - Invalidate all paths (/*) after S3 sync
  - Configure AWS credentials using GitHub secrets
  - Set AWS_REGION environment variable (eu-west-1 or appropriate region)
  - _Requirements: 4.2_

- [ ]* 32. Configure GitHub repository secrets for AWS
  - Add AWS_ACCESS_KEY_ID secret in repository settings
  - Add AWS_SECRET_ACCESS_KEY secret
  - Add CLOUDFRONT_DISTRIBUTION_ID secret
  - Test workflow by pushing a commit
  - Verify deployment to both GitHub Pages and S3
  - _Requirements: 4.2_


- [x] 33. Implement SEO best practices
  - Create static/robots.txt allowing all user-agents
  - Verify Hugo generates sitemap.xml automatically
  - Add Schema.org structured data (LocalBusiness) to base template
  - Include both salon locations in structured data
  - Verify hreflang tags are present on all pages
  - Add canonical URL tags to prevent duplicate content
  - Optimize meta descriptions for all pages (50-160 characters)
  - Add Open Graph images for social sharing
  - _Requirements: 4.4_

- [~] 34. Optimize site performance
  - Enable Hugo minification with --minify flag in build
  - Fingerprint all assets for cache busting
  - Implement critical CSS inlining for above-the-fold content (optional)
  - Verify WebP image generation with Hugo image processing
  - Test lazy loading functionality on various devices
  - Verify Font Awesome bundle size is ~20KB (tree-shaking working)
  - _Requirements: 4.3_

- [ ]* 35. Configure CloudFront cache policies
  - Set HTML files cache TTL to 1 hour with revalidation
  - Set fingerprinted assets (CSS/JS) cache TTL to 1 year
  - Set images cache TTL to 1 month
  - Set fonts cache TTL to 1 year
  - Enable query string forwarding for dynamic content if needed
  - Monitor cache hit ratio in CloudWatch
  - _Requirements: 4.3_

- [~] 36. Implement accessibility features
  - Add skip-to-content link at top of page
  - Verify all images have descriptive alt text
  - Ensure proper heading hierarchy (h1 → h2 → h3)
  - Test keyboard navigation (Tab, Enter, Escape)
  - Verify color contrast ratios meet WCAG 2.1 AA (4.5:1 minimum)
  - Add ARIA labels to icon-only buttons and links
  - Test with screen reader (NVDA, JAWS, or VoiceOver)
  - _Requirements: 4.5_


- [ ]* 37. Perform cross-browser testing
  - Test on Chrome (latest version) - desktop and mobile
  - Test on Firefox (latest version) - desktop and mobile
  - Test on Safari (latest version) - desktop and iOS
  - Test on Edge (latest version) - desktop
  - Verify all features work consistently across browsers
  - Document any browser-specific issues
  - _Requirements: 3.1, 4.3_

- [ ]* 38. Perform responsive design testing
  - Test on mobile devices (320px - 480px width)
  - Test on tablets (768px - 1024px width)
  - Test on desktop (1024px - 1920px width)
  - Test on wide screens (1920px+ width)
  - Verify mobile menu functionality on touch devices
  - Test touch interactions (tap, swipe)
  - Verify location info is accessible on all screen sizes
  - _Requirements: 3.1, 3.5_

- [ ]* 39. Test multilingual functionality
  - Test language switching on all pages
  - Verify language preference is maintained during navigation
  - Test CloudFront language detection with different Accept-Language headers
  - Test GitHub Pages fallback (should default to French)
  - Verify hreflang tags are correct
  - Test that untranslated pages fallback to language home
  - Verify phone links work correctly (tel: protocol)
  - Verify Instagram links open in new tab with rel="noopener"
  - Test 404 page in both languages
  - _Requirements: 3.6, 3.7_

- [ ]* 40. Perform performance testing
  - Run Lighthouse audit on multiple pages (target score > 90 all categories)
  - Test with WebPageTest from multiple locations
  - Verify Core Web Vitals: LCP < 2.5s, FID < 100ms, CLS < 0.1
  - Check page load times (target < 2 seconds)
  - Verify image optimization (WebP format, appropriate sizes)
  - Check JavaScript bundle size (Font Awesome should be ~20KB)
  - Test CloudFront cache hit ratio in CloudWatch
  - _Requirements: 4.3_

- [ ]* 41. Validate SEO implementation
  - Verify sitemap.xml is accessible at /sitemap.xml
  - Test robots.txt at /robots.txt
  - Verify hreflang tags with Google Search Console
  - Test structured data with Google Rich Results Test
  - Verify Open Graph tags with Facebook Sharing Debugger
  - Check meta descriptions on all pages (50-160 characters)
  - Verify canonical URLs are correct
  - Test that both language versions are indexed separately
  - _Requirements: 4.4_


- [x] 42. Create user documentation for content management
  - Write README.md with project overview and purpose
  - Document local development setup (Hugo installation, npm install, hugo server)
  - Create CONTENT_GUIDE.md in French for site owner
  - Document how to add new articles (create .md file, add frontmatter, write content)
  - Document how to update pricing (edit data/pricing.yaml)
  - Document how to update location information (edit data/locations.yaml)
  - Add troubleshooting section for common issues
  - Include examples of frontmatter and markdown formatting
  - _Requirements: 3.2_

- [x] 43. Create developer documentation
  - Create DEVELOPER.md with technical documentation
  - Document Hugo configuration (hugo.yaml structure)
  - Document SCSS architecture (_variables, _layout, _components)
  - Document JavaScript modules (fontawesome.js, main.js)
  - Document template structure and partials
  - Document data file formats (locations.yaml, pricing.yaml)
  - Add code examples and best practices
  - _Requirements: 4.1_

- [ ]* 44. Document deployment and AWS infrastructure
  - Document GitHub Actions workflow configuration
  - Document AWS S3 bucket setup steps
  - Document CloudFront distribution configuration
  - Document CloudFront Function deployment process
  - Document DNS configuration steps
  - Add rollback procedures for failed deployments
  - Document cost monitoring setup (billing alerts, Cost Explorer)
  - Include estimated monthly costs breakdown
  - _Requirements: 4.2_

- [ ]* 45. Final review and launch preparation
  - Review all content for accuracy and completeness
  - Verify all French and English translations are complete
  - Test all functionality one final time (checklist)
  - Set up uptime monitoring (UptimeRobot, Pingdom, or similar)
  - Configure AWS billing alerts at $5/month threshold
  - Create backup of current WordPress site before DNS switch
  - Prepare rollback plan in case of issues
  - _Requirements: All_

- [ ]* 46. Launch and post-launch monitoring
  - Update DNS records to point to CloudFront distribution
  - Monitor site for first 24 hours after launch
  - Check CloudWatch metrics for errors
  - Review CloudFront access logs
  - Verify both language versions are working correctly
  - Test from multiple locations and devices
  - Monitor AWS costs daily for first week
  - Celebrate successful launch! 🎉
  - _Requirements: All_

## Notes

- Tasks marked with `*` are optional or require AWS/production access
- Tasks marked with `[x]` are already completed
- Each task references specific requirements for traceability
- Focus on completing core functionality before optional enhancements
- Test thoroughly on GitHub Pages before deploying to AWS production
- CloudFront Functions are included in CloudFront pricing (no additional Lambda costs)
- Estimated AWS costs: $1.50-2.00/month for typical traffic
