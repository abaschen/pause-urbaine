# Pause Urbaine WordPress Theme

Custom WordPress theme for Pause Urbaine hair salon with bilingual support (French/English).

## Features

- Bilingual support (French/English) - Compatible with Polylang and WPML
- Responsive design (mobile-first)
- Custom page templates for Services and Contact pages
- Location data management
- Modern CSS with CSS variables
- Font Awesome icons integration
- Mobile menu with smooth animations
- SEO-friendly structure

## Installation

1. Download or clone this theme into your WordPress `wp-content/themes/` directory
2. Activate the theme from WordPress Admin > Appearance > Themes
3. Install and configure a multilingual plugin (Polylang recommended)
4. Create pages and assign templates:
   - Services page: Use "Services Page" template
   - Contact page: Use "Contact Page" template

## Required Plugins

- **Polylang** or **WPML** for multilingual support (recommended)

## Theme Structure

```
pause-urbaine-wp-theme/
├── assets/
│   ├── css/
│   │   └── main.css          # Compiled styles
│   ├── js/
│   │   ├── main.js           # Main JavaScript
│   │   └── fontawesome.js    # Font Awesome icons
│   └── scss/                 # Source SCSS files
├── page-templates/
│   ├── template-contact.php  # Contact page template
│   └── template-services.php # Services page template
├── functions.php             # Theme functions
├── header.php               # Header template
├── footer.php               # Footer template
├── index.php                # Main template
├── page.php                 # Default page template
├── style.css                # Theme stylesheet (required)
└── README.md                # This file
```

## Customization

### Locations Data

Location information is managed in `functions.php` via the `pause_urbaine_get_locations()` function. Update this function to modify:
- Salon names
- Addresses
- Phone numbers
- Instagram handles
- Opening hours

### Colors

Theme colors are defined as CSS variables in `assets/css/main.css`:
- `--primary-color`: Main brand color (#2c3e50)
- `--secondary-color`: Accent color (#e8b4b8)
- `--accent-color`: Highlight color (#d4a5a5)

### Menus

Register your menus in WordPress Admin > Appearance > Menus:
- **Primary Menu**: Main navigation
- **Footer Menu**: Footer links

## Page Templates

### Services Page
Displays services content with a call-to-action section. Assign this template to your Services page.

### Contact Page
Shows location cards with addresses, phone numbers, opening hours, and map links. Assign this template to your Contact page.

## Multilingual Setup

1. Install Polylang plugin
2. Configure languages (French and English)
3. Translate pages and menus
4. The theme automatically detects the current language

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Credits

- Font Awesome for icons
- Google Fonts (Inter, Playfair Display)

## Version

1.0.0

## License

GNU General Public License v2 or later
