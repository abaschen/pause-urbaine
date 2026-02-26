<?php
/**
 * Pause Urbaine Theme Functions
 */

// Theme setup
function pause_urbaine_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'pause-urbaine'),
        'footer' => __('Footer Menu', 'pause-urbaine'),
    ));
    
    // Add image sizes
    add_image_size('service-card', 400, 300, true);
    add_image_size('hero-banner', 1200, 600, true);
}
add_action('after_setup_theme', 'pause_urbaine_setup');

// Enqueue styles and scripts
function pause_urbaine_scripts() {
    // Main stylesheet
    wp_enqueue_style('pause-urbaine-style', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
    
    // Main JavaScript
    wp_enqueue_script('pause-urbaine-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'pause_urbaine_scripts');

// Register widget areas
function pause_urbaine_widgets_init() {
    register_sidebar(array(
        'name'          => __('Footer Sidebar', 'pause-urbaine'),
        'id'            => 'footer-sidebar',
        'description'   => __('Add widgets here to appear in your footer.', 'pause-urbaine'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'pause_urbaine_widgets_init');

// Get locations data
function pause_urbaine_get_locations() {
    return array(
        array(
            'id' => 'plainpalais',
            'name' => array(
                'fr' => 'Pause Urbaine Plainpalais',
                'en' => 'Pause Urbaine Plainpalais'
            ),
            'address' => array(
                'street' => 'Quai des Moulins 12A',
                'city' => 'Genève',
                'postal' => '1204',
                'country' => 'Suisse'
            ),
            'phone' => '022 310 4081',
            'instagram' => 'pauseurbaine',
            'maps_url' => 'https://www.google.com/maps/search/?api=1&query=Quai+des+Moulins+12A,+1204+Genève',
            'hours' => array(
                array('day' => array('fr' => 'Lundi', 'en' => 'Monday'), 'time' => 'Fermé'),
                array('day' => array('fr' => 'Mardi', 'en' => 'Tuesday'), 'time' => '10h - 18h'),
                array('day' => array('fr' => 'Mercredi', 'en' => 'Wednesday'), 'time' => '10h - 18h'),
                array('day' => array('fr' => 'Jeudi', 'en' => 'Thursday'), 'time' => '10h - 18h'),
                array('day' => array('fr' => 'Vendredi', 'en' => 'Friday'), 'time' => '10h - 18h'),
                array('day' => array('fr' => 'Samedi', 'en' => 'Saturday'), 'time' => '10h - 17h'),
                array('day' => array('fr' => 'Dimanche', 'en' => 'Sunday'), 'time' => 'Fermé')
            )
        ),
        array(
            'id' => 'eauxvives',
            'name' => array(
                'fr' => 'Pause Urbaine Eaux-Vives',
                'en' => 'Pause Urbaine Eaux-Vives'
            ),
            'address' => array(
                'street' => 'Rue de Montchoisy 40',
                'city' => 'Genève',
                'postal' => '1207',
                'country' => 'Suisse'
            ),
            'phone' => '022 736 2030',
            'instagram' => 'pauseurbaine_eauxvives',
            'maps_url' => 'https://www.google.com/maps/search/?api=1&query=Rue+de+Montchoisy+40,+1207+Genève',
            'hours' => array(
                array('day' => array('fr' => 'Lundi', 'en' => 'Monday'), 'time' => 'Fermé'),
                array('day' => array('fr' => 'Mardi', 'en' => 'Tuesday'), 'time' => '10h - 18h'),
                array('day' => array('fr' => 'Mercredi', 'en' => 'Wednesday'), 'time' => '10h - 18h'),
                array('day' => array('fr' => 'Jeudi', 'en' => 'Thursday'), 'time' => '10h - 18h'),
                array('day' => array('fr' => 'Vendredi', 'en' => 'Friday'), 'time' => '10h - 18h'),
                array('day' => array('fr' => 'Samedi', 'en' => 'Saturday'), 'time' => '10h - 17h'),
                array('day' => array('fr' => 'Dimanche', 'en' => 'Sunday'), 'time' => 'Fermé')
            )
        )
    );
}

// Get current language (for Polylang/WPML compatibility)
function pause_urbaine_get_lang() {
    if (function_exists('pll_current_language')) {
        return pll_current_language();
    }
    if (defined('ICL_LANGUAGE_CODE')) {
        return ICL_LANGUAGE_CODE;
    }
    return 'fr'; // Default to French
}
