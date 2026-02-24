# Pause Urbaine - Implementation Tasks

## Phase 1: Project Setup and Infrastructure

### 1. Initialize Hugo Project
- [ ] 1.1 Install Hugo extended version (v0.120+)
- [ ] 1.2 Create new Hugo site structure
- [ ] 1.3 Initialize Git repository
- [ ] 1.4 Create .gitignore file
- [ ] 1.5 Set up package.json for Font Awesome dependencies
- [ ] 1.6 Install npm dependencies (@fortawesome packages)

### 2. Configure Hugo for Multilingual Support
- [ ] 2.1 Create hugo.yaml with language configuration (fr, en)
- [ ] 2.2 Set defaultContentLanguage to "fr"
- [ ] 2.3 Enable defaultContentLanguageInSubdir
- [ ] 2.4 Configure language-specific parameters
- [ ] 2.5 Set up content directory structure (content/fr/, content/en/)

### 3. Create Translation Files
- [ ] 3.1 Create i18n/fr.yaml with French translations
- [ ] 3.2 Create i18n/en.yaml with English translations
- [ ] 3.3 Add navigation labels
- [ ] 3.4 Add common UI strings
- [ ] 3.5 Add location-specific labels

## Phase 2: Data Structure and Content

### 4. Set Up Data Files
- [ ] 4.1 Create data/locations.yaml with both salon locations
- [ ] 4.2 Add Plainpalais location details (address, phone, Instagram, hours)
- [ ] 4.3 Add Eaux-Vives location details (address, phone, Instagram, hours)
- [ ] 4.4 Ensure bilingual location names

### 5. Extract and Structure Pricing Data
- [ ] 5.1 Process tarifs-2026.jpeg (OCR or manual extraction)
- [ ] 5.2 Create data/pricing.yaml structure
- [ ] 5.3 Organize services by categories (Coupes, Colorations, Soins, etc.)
- [ ] 5.4 Add bilingual service names and descriptions
- [ ] 5.5 Include prices and durations

### 6. Migrate WordPress Content
- [ ] 6.1 Parse WordPress.2026-02-20.xml export file
- [ ] 6.2 Extract pages and posts
- [ ] 6.3 Convert HTML content to Markdown
- [ ] 6.4 Download and optimize images from WordPress
- [ ] 6.5 Create content files in content/fr/ directory
- [ ] 6.6 Add frontmatter metadata (title, date, description)
- [ ] 6.7 Create English translations for key pages

## Phase 3: Styling and Assets

### 7. Set Up SCSS Architecture
- [ ] 7.1 Create assets/scss/_variables.scss (colors, fonts, breakpoints)
- [ ] 7.2 Create assets/scss/_layout.scss (container, header, footer)
- [ ] 7.3 Create assets/scss/_components.scss (buttons, cards, forms)
- [ ] 7.4 Create assets/scss/main.scss (import all partials)
- [ ] 7.5 Configure responsive breakpoints

### 8. Implement Font Awesome Integration
- [ ] 8.1 Create assets/js/fontawesome.js
- [ ] 8.2 Import required solid icons (phone, location-dot, clock, etc.)
- [ ] 8.3 Import required brand icons (instagram, facebook)
- [ ] 8.4 Configure Font Awesome library
- [ ] 8.5 Set up dom.watch() for icon replacement
- [ ] 8.6 Test tree-shaking (verify bundle size ~20KB)

### 9. Add Logo and Images
- [ ] 9.1 Download logo from WordPress (Logo-Pause-Urbaine-2022)
- [ ] 9.2 Convert logo to SVG if needed
- [ ] 9.3 Optimize logo for web
- [ ] 9.4 Add logo to static/images/
- [ ] 9.5 Download and optimize hero images
- [ ] 9.6 Create WebP versions of all images

## Phase 4: Templates and Layouts

### 10. Create Base Template
- [ ] 10.1 Create layouts/_default/baseof.html
- [ ] 10.2 Add HTML5 doctype and lang attribute
- [ ] 10.3 Add meta tags (charset, viewport, description)
- [ ] 10.4 Add multilingual SEO tags (hreflang)
- [ ] 10.5 Add Open Graph meta tags
- [ ] 10.6 Link SCSS stylesheet with Hugo Pipes
- [ ] 10.7 Add Font Awesome script with js.Build
- [ ] 10.8 Add main.js script
- [ ] 10.9 Add defer attributes to scripts

### 11. Create Header Partial
- [ ] 11.1 Create layouts/partials/header.html
- [ ] 11.2 Add header-top section with locations bar
- [ ] 11.3 Loop through locations data
- [ ] 11.4 Display location names with icons
- [ ] 11.5 Add clickable phone links with icons
- [ ] 11.6 Add Instagram links with icons
- [ ] 11.7 Add language switcher
- [ ] 11.8 Add header-main section with logo
- [ ] 11.9 Add main navigation menu
- [ ] 11.10 Add mobile menu toggle button

### 12. Create Language Switcher Partial
- [ ] 12.1 Create layouts/partials/language-switcher.html
- [ ] 12.2 Loop through available languages
- [ ] 12.3 Highlight active language
- [ ] 12.4 Link to translated pages if available
- [ ] 12.5 Fallback to language home if translation missing
- [ ] 12.6 Add proper lang attributes

### 13. Create Footer Partial
- [ ] 13.1 Create layouts/partials/footer.html
- [ ] 13.2 Add location information
- [ ] 13.3 Add social media links
- [ ] 13.4 Add opening hours summary
- [ ] 13.5 Add copyright notice
- [ ] 13.6 Ensure responsive layout

### 14. Create Location Card Partial
- [ ] 14.1 Create layouts/partials/location-card.html
- [ ] 14.2 Display location name with icon
- [ ] 14.3 Display address with map marker icon
- [ ] 14.4 Display phone with phone icon
- [ ] 14.5 Display Instagram with Instagram icon
- [ ] 14.6 Display opening hours with clock icon
- [ ] 14.7 Make phone and Instagram links clickable

### 15. Create Homepage Template
- [ ] 15.1 Create layouts/index.html
- [ ] 15.2 Add hero section with image
- [ ] 15.3 Add welcome text
- [ ] 15.4 Display latest news/articles (3 most recent)
- [ ] 15.5 Add call-to-action buttons
- [ ] 15.6 Display both locations using location-card partial

### 16. Create Services Page Template
- [ ] 16.1 Create layouts/services/single.html or use _default/single.html
- [ ] 16.2 Display page title
- [ ] 16.3 Render markdown content
- [ ] 16.4 Add service categories if needed
- [ ] 16.5 Link to pricing page

### 17. Create Pricing Page Template
- [ ] 17.1 Create layouts/pricing/single.html or use _default/single.html
- [ ] 17.2 Loop through pricing data categories
- [ ] 17.3 Display category names
- [ ] 17.4 Display services with prices and durations
- [ ] 17.5 Make layout responsive (table or cards)
- [ ] 17.6 Add note about price variations if applicable

### 18. Create Contact Page Template
- [ ] 18.1 Create layouts/contact/single.html or use _default/single.html
- [ ] 18.2 Display both locations using location-card partial
- [ ] 18.3 Add Google Maps embed (optional)
- [ ] 18.4 Add contact form (optional, or link to external booking)

### 19. Create News/Blog Templates
- [ ] 19.1 Create layouts/actualites/list.html (blog list)
- [ ] 19.2 Display list of articles with excerpts
- [ ] 19.3 Add pagination if needed
- [ ] 19.4 Create layouts/actualites/single.html (single post)
- [ ] 19.5 Display post title, date, content
- [ ] 19.6 Add "read more" links

### 20. Create 404 Page
- [ ] 20.1 Create layouts/404.html
- [ ] 20.2 Add friendly error message
- [ ] 20.3 Add links to homepage and main sections
- [ ] 20.4 Ensure bilingual support

## Phase 5: JavaScript Functionality

### 21. Implement Mobile Menu
- [ ] 21.1 Create assets/js/main.js
- [ ] 21.2 Add mobile menu toggle functionality
- [ ] 21.3 Toggle .is-open class on nav
- [ ] 21.4 Toggle icon between bars and times
- [ ] 21.5 Add keyboard support (Escape to close)
- [ ] 21.6 Close menu when clicking outside

### 22. Implement Image Lazy Loading
- [ ] 22.1 Add IntersectionObserver for lazy loading
- [ ] 22.2 Add data-src attributes to images
- [ ] 22.3 Load images when they enter viewport
- [ ] 22.4 Add loaded class for fade-in effect
- [ ] 22.5 Add fallback for browsers without IntersectionObserver

## Phase 6: CloudFront Function

### 23. Create Language Detection Function
- [ ] 23.1 Create functions/language-redirect.js
- [ ] 23.2 Check if request URI is root path
- [ ] 23.3 Parse Accept-Language header
- [ ] 23.4 Detect if English is preferred
- [ ] 23.5 Return 302 redirect to /en/ or /fr/
- [ ] 23.6 Default to French for unsupported languages
- [ ] 23.7 Test function locally
- [ ] 23.8 Ensure function size < 10KB

## Phase 7: AWS Infrastructure

### 24. Set Up S3 Bucket
- [ ]* 24.1 Create S3 bucket named "pauseurbaine.com"
- [ ]* 24.2 Enable static website hosting
- [ ]* 24.3 Set index document to index.html
- [ ]* 24.4 Set error document to 404.html
- [ ]* 24.5 Configure bucket policy for public read access
- [ ]* 24.6 Enable versioning (optional)

### 25. Configure CloudFront Distribution
- [ ]* 25.1 Create CloudFront distribution
- [ ]* 25.2 Set S3 bucket as origin
- [ ]* 25.3 Configure Origin Access Control (OAC)
- [ ]* 25.4 Set default root object to index.html
- [ ]* 25.5 Enable compression (gzip, brotli)
- [ ]* 25.6 Configure custom error responses (404 → /404.html)
- [ ]* 25.7 Set cache behaviors
- [ ]* 25.8 Configure cache policy (vary on Accept-Language)

### 26. Set Up SSL Certificate
- [ ]* 26.1 Request SSL certificate in AWS Certificate Manager (ACM)
- [ ]* 26.2 Validate domain ownership (DNS or email)
- [ ]* 26.3 Attach certificate to CloudFront distribution
- [ ]* 26.4 Configure HTTPS redirect

### 27. Deploy CloudFront Function
- [ ]* 27.1 Create CloudFront Function in AWS Console
- [ ]* 27.2 Copy language-redirect.js code
- [ ]* 27.3 Test function in CloudFront console
- [ ]* 27.4 Publish function
- [ ]* 27.5 Associate function with distribution (viewer request)
- [ ]* 27.6 Test language detection with different Accept-Language headers

### 28. Configure DNS
- [ ]* 28.1 Create/update DNS records for pauseurbaine.com
- [ ]* 28.2 Point A record to CloudFront distribution
- [ ]* 28.3 Add AAAA record for IPv6 (optional)
- [ ]* 28.4 Verify DNS propagation
- [ ]* 28.5 Test site access via custom domain

## Phase 8: GitHub Pages Setup

### 29. Configure GitHub Pages
- [ ] 29.1 Create gh-pages branch
- [ ] 29.2 Enable GitHub Pages in repository settings
- [ ] 29.3 Set source to gh-pages branch
- [ ] 29.4 Configure custom domain (optional)
- [ ] 29.5 Enable HTTPS

### 30. Create Root Redirect for GitHub Pages
- [ ] 30.1 Create static/index.html with meta refresh
- [ ] 30.2 Redirect to /fr/ by default
- [ ] 30.3 Add JavaScript fallback redirect
- [ ] 30.4 Test redirect functionality

## Phase 9: CI/CD Pipeline

### 31. Create GitHub Actions Workflow
- [ ] 31.1 Create .github/workflows/deploy.yml
- [ ] 31.2 Configure workflow triggers (push to main)
- [ ] 31.3 Add Hugo setup step
- [ ] 31.4 Add npm install step
- [ ] 31.5 Add Hugo build step (hugo --minify)
- [ ] 31.6 Add deploy to GitHub Pages step
- [ ]* 31.7 Add deploy to S3 step
- [ ]* 31.8 Add CloudFront invalidation step
- [ ]* 31.9 Configure AWS credentials as secrets

### 32. Configure GitHub Secrets
- [ ]* 32.1 Add AWS_ACCESS_KEY_ID secret
- [ ]* 32.2 Add AWS_SECRET_ACCESS_KEY secret
- [ ]* 32.3 Add CLOUDFRONT_DISTRIBUTION_ID secret
- [ ] 32.4 Test workflow with a commit

## Phase 10: SEO and Performance

### 33. Implement SEO Best Practices
- [ ] 33.1 Add robots.txt file
- [ ] 33.2 Verify sitemap.xml generation
- [ ] 33.3 Add structured data (Schema.org LocalBusiness)
- [ ] 33.4 Verify hreflang tags on all pages
- [ ] 33.5 Add canonical URLs
- [ ] 33.6 Optimize meta descriptions
- [ ] 33.7 Add Open Graph images

### 34. Optimize Performance
- [ ] 34.1 Enable Hugo minification (--minify flag)
- [ ] 34.2 Fingerprint all assets
- [ ] 34.3 Implement critical CSS inlining (optional)
- [ ] 34.4 Verify WebP image generation
- [ ] 34.5 Test lazy loading functionality
- [ ] 34.6 Verify Font Awesome tree-shaking (check bundle size)
- [ ]* 34.7 Configure CloudFront cache TTLs

### 35. Implement Accessibility Features
- [ ] 35.1 Add skip-to-content link
- [ ] 35.2 Verify all images have alt text
- [ ] 35.3 Ensure proper heading hierarchy
- [ ] 35.4 Test keyboard navigation
- [ ] 35.5 Verify color contrast ratios
- [ ] 35.6 Add ARIA labels where needed
- [ ] 35.7 Test with screen reader

## Phase 11: Testing and Quality Assurance

### 36. Cross-Browser Testing
- [ ] 36.1 Test on Chrome (latest)
- [ ] 36.2 Test on Firefox (latest)
- [ ] 36.3 Test on Safari (latest)
- [ ] 36.4 Test on Edge (latest)
- [ ] 36.5 Test on mobile Safari (iOS)
- [ ] 36.6 Test on mobile Chrome (Android)

### 37. Responsive Design Testing
- [ ] 37.1 Test on mobile (320px - 480px)
- [ ] 37.2 Test on tablet (768px - 1024px)
- [ ] 37.3 Test on desktop (1024px+)
- [ ] 37.4 Test on wide screens (1920px+)
- [ ] 37.5 Verify mobile menu functionality
- [ ] 37.6 Test touch interactions

### 38. Functionality Testing
- [ ] 38.1 Test language switching on all pages
- [ ] 38.2 Verify phone links work (tel: protocol)
- [ ] 38.3 Verify Instagram links open correctly
- [ ] 38.4 Test navigation between pages
- [ ] 38.5 Verify CloudFront language detection
- [ ] 38.6 Test GitHub Pages fallback (French default)
- [ ] 38.7 Test 404 page

### 39. Performance Testing
- [ ] 39.1 Run Lighthouse audit (target score > 90)
- [ ] 39.2 Test with WebPageTest
- [ ] 39.3 Verify Core Web Vitals (LCP, FID, CLS)
- [ ] 39.4 Check page load times (target < 2s)
- [ ] 39.5 Verify image optimization
- [ ] 39.6 Check JavaScript bundle size
- [ ] 39.7 Test CloudFront cache hit ratio

### 40. SEO Testing
- [ ] 40.1 Verify sitemap.xml is accessible
- [ ] 40.2 Test robots.txt
- [ ] 40.3 Verify hreflang tags with Google Search Console
- [ ] 40.4 Check structured data with Google Rich Results Test
- [ ] 40.5 Verify Open Graph tags with Facebook Debugger
- [ ] 40.6 Test meta descriptions on all pages

## Phase 12: Documentation and Handoff

### 41. Create User Documentation
- [ ] 41.1 Write README.md with project overview
- [ ] 41.2 Document local development setup
- [ ] 41.3 Create content management guide (French)
- [ ] 41.4 Document how to add new articles
- [ ] 41.5 Document how to update pricing
- [ ] 41.6 Document how to update location information
- [ ] 41.7 Add troubleshooting section

### 42. Create Developer Documentation
- [ ] 42.1 Document Hugo configuration
- [ ] 42.2 Document SCSS architecture
- [ ] 42.3 Document JavaScript modules
- [ ] 42.4 Document template structure
- [ ] 42.5 Document deployment process
- [ ] 42.6 Document AWS infrastructure
- [ ] 42.7 Add architecture diagrams

### 43. Create Deployment Guide
- [ ] 43.1 Document GitHub Actions workflow
- [ ] 43.2 Document AWS setup steps
- [ ] 43.3 Document CloudFront Function deployment
- [ ] 43.4 Document DNS configuration
- [ ] 43.5 Document rollback procedures
- [ ] 43.6 Add cost monitoring instructions

### 44. Final Review and Launch
- [ ] 44.1 Review all content for accuracy
- [ ] 44.2 Verify all translations are complete
- [ ] 44.3 Test all functionality one final time
- [ ] 44.4 Verify analytics setup (if applicable)
- [ ] 44.5 Set up uptime monitoring
- [ ] 44.6 Configure AWS billing alerts
- [ ] 44.7 Create backup of WordPress site
- [ ] 44.8 Update DNS to point to new site
- [ ] 44.9 Monitor for issues post-launch
- [ ] 44.10 Celebrate! 🎉

## Phase 13: Post-Launch (Optional)

### 45. Monitor and Optimize
- [ ] 45.1 Monitor CloudWatch metrics
- [ ] 45.2 Review CloudFront access logs
- [ ] 45.3 Analyze user behavior (if analytics enabled)
- [ ] 45.4 Optimize based on real-world performance data
- [ ] 45.5 Review and optimize AWS costs monthly

### 46. Future Enhancements (Phase 2)
- [ ] 46.1 Add online booking system integration
- [ ] 46.2 Add customer testimonials section
- [ ] 46.3 Create photo gallery
- [ ] 46.4 Add blog categories and tags
- [ ] 46.5 Implement newsletter subscription
- [ ] 46.6 Add more languages (German, Italian)
- [ ] 46.7 Implement PWA features
