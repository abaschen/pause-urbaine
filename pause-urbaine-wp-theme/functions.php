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

// Include pricing post type
require_once get_template_directory() . '/inc/pricing-post-type.php';

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

// Customizer settings
function pause_urbaine_customize_register($wp_customize) {
    // Pricing Section
    $wp_customize->add_section('pause_urbaine_pricing', array(
        'title'    => __('Pricing Settings', 'pause-urbaine'),
        'priority' => 30,
    ));
    
    // Enable/Disable Pricing Display
    $wp_customize->add_setting('pause_urbaine_show_pricing', array(
        'default'           => true,
        'sanitize_callback' => 'pause_urbaine_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('pause_urbaine_show_pricing', array(
        'label'    => __('Display Pricing', 'pause-urbaine'),
        'section'  => 'pause_urbaine_pricing',
        'type'     => 'checkbox',
    ));
    
    // Pricing Note
    $wp_customize->add_setting('pause_urbaine_pricing_note', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('pause_urbaine_pricing_note', array(
        'label'       => __('Pricing Note', 'pause-urbaine'),
        'description' => __('Additional note to display on pricing page', 'pause-urbaine'),
        'section'     => 'pause_urbaine_pricing',
        'type'        => 'textarea',
    ));
    
    // Locations Section
    $wp_customize->add_section('pause_urbaine_locations', array(
        'title'    => __('Locations', 'pause-urbaine'),
        'priority' => 31,
    ));
    
    // Location 1
    $wp_customize->add_setting('pause_urbaine_location1_name', array(
        'default'           => 'Pause Urbaine Bel-Air',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('pause_urbaine_location1_name', array(
        'label'   => __('Location 1 Name', 'pause-urbaine'),
        'section' => 'pause_urbaine_locations',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('pause_urbaine_location1_address', array(
        'default'           => 'Quai des Moulins 12A',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('pause_urbaine_location1_address', array(
        'label'   => __('Location 1 Address', 'pause-urbaine'),
        'section' => 'pause_urbaine_locations',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('pause_urbaine_location1_city', array(
        'default'           => '1204 Genève',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('pause_urbaine_location1_city', array(
        'label'   => __('Location 1 City', 'pause-urbaine'),
        'section' => 'pause_urbaine_locations',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('pause_urbaine_location1_phone', array(
        'default'           => '022 310 4081',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('pause_urbaine_location1_phone', array(
        'label'   => __('Location 1 Phone', 'pause-urbaine'),
        'section' => 'pause_urbaine_locations',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('pause_urbaine_location1_instagram', array(
        'default'           => 'pauseurbaine',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('pause_urbaine_location1_instagram', array(
        'label'   => __('Location 1 Instagram', 'pause-urbaine'),
        'section' => 'pause_urbaine_locations',
        'type'    => 'text',
    ));
    
    // Location 2
    $wp_customize->add_setting('pause_urbaine_location2_name', array(
        'default'           => 'Pause Urbaine Eaux-Vives',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('pause_urbaine_location2_name', array(
        'label'   => __('Location 2 Name', 'pause-urbaine'),
        'section' => 'pause_urbaine_locations',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('pause_urbaine_location2_address', array(
        'default'           => 'Rue de Montchoisy 40',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('pause_urbaine_location2_address', array(
        'label'   => __('Location 2 Address', 'pause-urbaine'),
        'section' => 'pause_urbaine_locations',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('pause_urbaine_location2_city', array(
        'default'           => '1207 Genève',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('pause_urbaine_location2_city', array(
        'label'   => __('Location 2 City', 'pause-urbaine'),
        'section' => 'pause_urbaine_locations',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('pause_urbaine_location2_phone', array(
        'default'           => '022 736 2030',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('pause_urbaine_location2_phone', array(
        'label'   => __('Location 2 Phone', 'pause-urbaine'),
        'section' => 'pause_urbaine_locations',
        'type'    => 'text',
    ));
    
    $wp_customize->add_setting('pause_urbaine_location2_instagram', array(
        'default'           => 'pauseurbaine_eauxvives',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('pause_urbaine_location2_instagram', array(
        'label'   => __('Location 2 Instagram', 'pause-urbaine'),
        'section' => 'pause_urbaine_locations',
        'type'    => 'text',
    ));
}
add_action('customize_register', 'pause_urbaine_customize_register');

// Sanitize checkbox
function pause_urbaine_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

// Get locations data from customizer
function pause_urbaine_get_locations() {
    return array(
        array(
            'id' => 'belair',
            'name' => array(
                'fr' => get_theme_mod('pause_urbaine_location1_name', 'Pause Urbaine Bel-Air'),
                'en' => get_theme_mod('pause_urbaine_location1_name', 'Pause Urbaine Bel-Air')
            ),
            'address' => array(
                'street' => get_theme_mod('pause_urbaine_location1_address', 'Quai des Moulins 12A'),
                'city' => 'Genève',
                'postal' => explode(' ', get_theme_mod('pause_urbaine_location1_city', '1204 Genève'))[0],
                'country' => 'Suisse'
            ),
            'phone' => get_theme_mod('pause_urbaine_location1_phone', '022 310 4081'),
            'instagram' => get_theme_mod('pause_urbaine_location1_instagram', 'pauseurbaine'),
            'booking_url' => 'https://book.heygoldie.com/PauseUrbaine',
            'maps_url' => 'https://www.google.com/maps/search/?api=1&query=' . urlencode(get_theme_mod('pause_urbaine_location1_address', 'Quai des Moulins 12A') . ', ' . get_theme_mod('pause_urbaine_location1_city', '1204 Genève')),
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
                'fr' => get_theme_mod('pause_urbaine_location2_name', 'Pause Urbaine Eaux-Vives'),
                'en' => get_theme_mod('pause_urbaine_location2_name', 'Pause Urbaine Eaux-Vives')
            ),
            'address' => array(
                'street' => get_theme_mod('pause_urbaine_location2_address', 'Rue de Montchoisy 40'),
                'city' => 'Genève',
                'postal' => explode(' ', get_theme_mod('pause_urbaine_location2_city', '1207 Genève'))[0],
                'country' => 'Suisse'
            ),
            'phone' => get_theme_mod('pause_urbaine_location2_phone', '022 736 2030'),
            'instagram' => get_theme_mod('pause_urbaine_location2_instagram', 'pauseurbaine_eauxvives'),
            'booking_url' => 'https://book.heygoldie.com/PauseUrbaineEAUX-VIVES',
            'maps_url' => 'https://www.google.com/maps/search/?api=1&query=' . urlencode(get_theme_mod('pause_urbaine_location2_address', 'Rue de Montchoisy 40') . ', ' . get_theme_mod('pause_urbaine_location2_city', '1207 Genève')),
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
