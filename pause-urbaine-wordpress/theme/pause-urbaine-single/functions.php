<?php
/**
 * Pause Urbaine Single Page theme.
 */

if (!defined('ABSPATH')) {
    exit;
}

define('PU_SINGLE_VERSION', '1.0.2');

function pu_setup() {
    load_theme_textdomain('pause-urbaine', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 120,
        'width'       => 360,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array('caption', 'gallery', 'style', 'script'));
    add_theme_support('responsive-embeds');
    add_image_size('pu_hero', 1800, 1100, true);
    add_image_size('pu_card', 760, 570, true);
}
add_action('after_setup_theme', 'pu_setup');

function pu_assets() {
    wp_enqueue_style('pu-style', get_stylesheet_uri(), array(), PU_SINGLE_VERSION);
    wp_enqueue_script('pu-site', get_template_directory_uri() . '/assets/site.js', array(), PU_SINGLE_VERSION, true);
}
add_action('wp_enqueue_scripts', 'pu_assets');

function pu_translate($text) {
    if (function_exists('pll__')) {
        return pll__($text);
    }

    return $text;
}

function pu_customize_register($wp_customize) {
    $wp_customize->add_section('pu_page', array(
        'title'    => __('Pause Urbaine Page', 'pause-urbaine'),
        'priority' => 30,
    ));

    $fields = array(
        'hero_eyebrow' => array('Hero eyebrow', 'Coiffure, couleur et soins à Genève', 'text'),
        'hero_title' => array('Hero title', 'Pause Urbaine', 'text'),
        'hero_text' => array('Hero text', 'Deux salons à Genève pour une pause simple, soignée et chaleureuse.', 'textarea'),
        'intro_title' => array('Shop details title', 'Une pause au cœur de la ville', 'text'),
        'intro_text' => array('Shop details text', 'Coupes, brushings, colorations, soins capillaires, ongles et esthétique dans une ambiance de quartier attentive.', 'textarea'),
        'pricing_note' => array('Pricing note', "Les prix peuvent varier selon la longueur et l'épaisseur des cheveux.", 'textarea'),
    );

    foreach ($fields as $key => $field) {
        $wp_customize->add_setting('pu_' . $key, array(
            'default'           => $field[1],
            'sanitize_callback' => $field[2] === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field',
        ));
        $wp_customize->add_control('pu_' . $key, array(
            'label'   => __($field[0], 'pause-urbaine'),
            'section' => 'pu_page',
            'type'    => $field[2],
        ));
    }
}
add_action('customize_register', 'pu_customize_register');

function pu_option($key, $default = '') {
    return pu_translate(get_theme_mod('pu_' . $key, $default));
}

function pu_register_content_types() {
    register_post_type('pu_location', array(
        'labels' => array(
            'name'          => __('Locations', 'pause-urbaine'),
            'singular_name' => __('Location', 'pause-urbaine'),
            'add_new_item'  => __('Add Location', 'pause-urbaine'),
            'edit_item'     => __('Edit Location', 'pause-urbaine'),
        ),
        'public'              => true,
        'show_ui'             => true,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-location-alt',
        'supports'            => array('title', 'editor', 'thumbnail', 'page-attributes'),
        'has_archive'         => false,
        'publicly_queryable'  => false,
        'exclude_from_search' => true,
    ));

    register_post_type('pu_price', array(
        'labels' => array(
            'name'          => __('Pricing', 'pause-urbaine'),
            'singular_name' => __('Price', 'pause-urbaine'),
            'add_new_item'  => __('Add Price', 'pause-urbaine'),
            'edit_item'     => __('Edit Price', 'pause-urbaine'),
        ),
        'public'              => true,
        'show_ui'             => true,
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-money-alt',
        'supports'            => array('title', 'editor', 'page-attributes'),
        'has_archive'         => false,
        'publicly_queryable'  => false,
        'exclude_from_search' => true,
    ));

    register_taxonomy('pu_price_category', array('pu_price'), array(
        'labels' => array(
            'name'          => __('Pricing Categories', 'pause-urbaine'),
            'singular_name' => __('Pricing Category', 'pause-urbaine'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
    ));
}
add_action('init', 'pu_register_content_types');
add_action('init', 'pu_seed_starter_content', 20);
add_action('init', 'pu_register_polylang_strings', 30);
add_action('init', 'pu_seed_polylang_translations', 40);

function pu_polylang_post_types($post_types, $is_settings) {
    $post_types['pu_location'] = 'pu_location';
    $post_types['pu_price'] = 'pu_price';

    return $post_types;
}
add_filter('pll_get_post_types', 'pu_polylang_post_types', 10, 2);

function pu_polylang_taxonomies($taxonomies, $is_settings) {
    $taxonomies['pu_price_category'] = 'pu_price_category';

    return $taxonomies;
}
add_filter('pll_get_taxonomies', 'pu_polylang_taxonomies', 10, 2);

function pu_polylang_copy_meta($metas) {
    $shared_meta = array(
        '_pu_street',
        '_pu_postal_city',
        '_pu_country',
        '_pu_phone',
        '_pu_instagram',
        '_pu_booking_url',
        '_pu_maps_url',
        '_pu_hours',
        '_pu_price',
        '_pu_duration',
    );

    return array_values(array_unique(array_merge($metas, $shared_meta)));
}
add_filter('pll_copy_post_metas', 'pu_polylang_copy_meta');

function pu_register_polylang_strings() {
    if (!function_exists('pll_register_string')) {
        return;
    }

    $group = 'Pause Urbaine';

    $strings = array(
        'Salons',
        'Tarifs',
        'Articles',
        'Contact',
        'Réserver',
        'Voir les tarifs',
        'Bienvenue',
        'Deux adresses',
        'Nos salons à Genève',
        'Prestations',
        'Itinéraire',
        'Actualités',
        'Les prochains articles apparaîtront ici.',
        'Retour en haut',
        'Coiffure, couleur et soins à Genève',
        'Pause Urbaine',
        'Deux salons à Genève pour une pause simple, soignée et chaleureuse.',
        'Une pause au cœur de la ville',
        'Coupes, brushings, colorations, soins capillaires, ongles et esthétique dans une ambiance de quartier attentive.',
        "Les prix peuvent varier selon la longueur et l'épaisseur des cheveux.",
    );

    foreach ($strings as $string) {
        pll_register_string($string, $string, $group);
    }

    foreach (array('hero_eyebrow', 'hero_title', 'hero_text', 'intro_title', 'intro_text', 'pricing_note') as $key) {
        $value = get_theme_mod('pu_' . $key);
        if ($value) {
            pll_register_string('Customizer: ' . $key, $value, $group);
        }
    }
}

function pu_string_translations() {
    return array(
        'Salons' => array('en' => 'Locations', 'fr' => 'Salons'),
        'Tarifs' => array('en' => 'Pricing', 'fr' => 'Tarifs'),
        'Articles' => array('en' => 'Articles', 'fr' => 'Articles'),
        'Contact' => array('en' => 'Contact', 'fr' => 'Contact'),
        'Réserver' => array('en' => 'Book', 'fr' => 'Réserver'),
        'Voir les tarifs' => array('en' => 'View pricing', 'fr' => 'Voir les tarifs'),
        'Bienvenue' => array('en' => 'Welcome', 'fr' => 'Bienvenue'),
        'Deux adresses' => array('en' => 'Two locations', 'fr' => 'Deux adresses'),
        'Nos salons à Genève' => array('en' => 'Our Geneva salons', 'fr' => 'Nos salons à Genève'),
        'Prestations' => array('en' => 'Services', 'fr' => 'Prestations'),
        'Itinéraire' => array('en' => 'Directions', 'fr' => 'Itinéraire'),
        'Actualités' => array('en' => 'Journal', 'fr' => 'Actualités'),
        'Les prochains articles apparaîtront ici.' => array('en' => 'New articles will appear here.', 'fr' => 'Les prochains articles apparaîtront ici.'),
        'Retour en haut' => array('en' => 'Back to top', 'fr' => 'Retour en haut'),
        'Coiffure, couleur et soins à Genève' => array('en' => 'Haircuts, color and treatments in Geneva', 'fr' => 'Coiffure, couleur et soins à Genève'),
        'Pause Urbaine' => array('en' => 'Pause Urbaine', 'fr' => 'Pause Urbaine'),
        'Deux salons à Genève pour une pause simple, soignée et chaleureuse.' => array('en' => 'Two Geneva salons for a simple, polished and warm pause.', 'fr' => 'Deux salons à Genève pour une pause simple, soignée et chaleureuse.'),
        'Une pause au cœur de la ville' => array('en' => 'A pause in the heart of the city', 'fr' => 'Une pause au cœur de la ville'),
        'Coupes, brushings, colorations, soins capillaires, ongles et esthétique dans une ambiance de quartier attentive.' => array('en' => 'Cuts, blow-dries, color, hair treatments, nails and beauty services in a caring neighborhood atmosphere.', 'fr' => 'Coupes, brushings, colorations, soins capillaires, ongles et esthétique dans une ambiance de quartier attentive.'),
        "Les prix peuvent varier selon la longueur et l'épaisseur des cheveux." => array('en' => 'Prices may vary depending on hair length and thickness.', 'fr' => "Les prix peuvent varier selon la longueur et l'épaisseur des cheveux."),
    );
}

function pu_seed_polylang_translations() {
    if (!function_exists('pll_set_post_language') || !function_exists('pll_save_post_translations')) {
        return;
    }

    if (!function_exists('PLL') || !PLL()->model->get_language('fr') || !PLL()->model->get_language('en')) {
        return;
    }

    if (get_option('pu_polylang_translations_seeded') !== '3') {
        pu_seed_polylang_string_translations();
        pu_seed_location_translations();
        pu_seed_pricing_translations();
        update_option('pu_polylang_translations_seeded', '3', false);
    }
}

function pu_seed_polylang_string_translations() {
    if (!class_exists('PLL_MO') || !function_exists('PLL')) {
        return;
    }

    foreach (array('fr', 'en') as $slug) {
        $language = PLL()->model->get_language($slug);
        if (!$language) {
            continue;
        }

        $mo = new PLL_MO();
        $mo->import_from_db($language);

        foreach (pu_string_translations() as $original => $translations) {
            if (empty($translations[$slug])) {
                continue;
            }

            $mo->add_entry($mo->make_entry($original, $translations[$slug]));
        }

        $mo->export_to_db($language);
    }
}

function pu_seed_location_translations() {
    $locations = array(
        'Pause Urbaine Bel-Air' => array(
            'title' => 'Pause Urbaine Bel-Air',
            'content' => 'A central salon for haircuts, color, brushing and treatments near Bel-Air.',
            'country' => 'Switzerland',
            'hours' => "Tuesday - Friday: 10:00 - 18:00\nSaturday: 10:00 - 17:00\nSunday - Monday: Closed",
        ),
        'Pause Urbaine Eaux-Vives' => array(
            'title' => 'Pause Urbaine Eaux-Vives',
            'content' => 'A neighborhood salon for hair, nails and beauty services in Eaux-Vives.',
            'country' => 'Switzerland',
            'hours' => "Tuesday - Friday: 10:00 - 18:00\nSaturday: 10:00 - 17:00\nSunday - Monday: Closed",
        ),
    );

    foreach ($locations as $fr_title => $en_data) {
        $fr_post = get_page_by_title($fr_title, OBJECT, 'pu_location');
        if (!$fr_post) {
            continue;
        }

        pll_set_post_language($fr_post->ID, 'fr');
        $translations = pll_get_post_translations($fr_post->ID);

        if (!empty($translations['en'])) {
            continue;
        }

        $en_id = wp_insert_post(array(
            'post_type' => 'pu_location',
            'post_status' => 'publish',
            'post_title' => $en_data['title'],
            'post_content' => $en_data['content'],
            'menu_order' => $fr_post->menu_order,
        ));

        if (is_wp_error($en_id)) {
            continue;
        }

        foreach (array_keys(pu_location_fields()) as $key) {
            update_post_meta($en_id, '_pu_' . $key, get_post_meta($fr_post->ID, '_pu_' . $key, true));
        }

        update_post_meta($en_id, '_pu_country', $en_data['country']);
        update_post_meta($en_id, '_pu_hours', $en_data['hours']);

        pll_set_post_language($en_id, 'en');
        pll_save_post_translations(array('fr' => $fr_post->ID, 'en' => $en_id));
    }
}

function pu_pricing_translation_data() {
    return array(
        'Coupes / Brushing' => array(
            'term' => 'Haircuts / Blow-dry',
            'items' => array(
                'Shampoing + massage crânien + coupe garçon + séchage' => array('title' => 'Shampoo + head massage + short haircut + drying', 'description' => ''),
                'Shampoing + coupe + brushing cheveux courts' => array('title' => 'Shampoo + cut + blow-dry, short hair', 'description' => ''),
                'Shampoing + coupe + brushing cheveux mi-longs' => array('title' => 'Shampoo + cut + blow-dry, medium hair', 'description' => ''),
                'Shampoing + coupe + brushing cheveux longs' => array('title' => 'Shampoo + cut + blow-dry, long hair', 'description' => ''),
                'Brushing, shampoing inclus' => array('title' => 'Blow-dry, shampoo included', 'description' => 'Short, medium or long hair.'),
            ),
        ),
        'Colorations / Mèches' => array(
            'term' => 'Color / Highlights',
            'items' => array(
                'Couleur racine' => array('title' => 'Root color', 'description' => 'Shampoo + treatment included.'),
                'Coloration complète' => array('title' => 'Full color', 'description' => 'With or without blow-dry depending on hair length.'),
                'Patine' => array('title' => 'Toner', 'description' => 'Shampoo + treatment included.'),
                'Mèches' => array('title' => 'Highlights', 'description' => 'Full head or half head.'),
            ),
        ),
        'Lissages / Soins' => array(
            'term' => 'Smoothing / Treatments',
            'items' => array(
                'Botox capillaire + coupe + brushing' => array('title' => 'Hair botox + cut + blow-dry', 'description' => ''),
                'Lissage bio à la kératine' => array('title' => 'Organic keratin smoothing', 'description' => 'Formaldehyde-free.'),
                'Hydratation à la kératine' => array('title' => 'Keratin hydration treatment', 'description' => 'Blow-dry included.'),
            ),
        ),
    );
}

function pu_seed_pricing_translations() {
    foreach (pu_pricing_translation_data() as $fr_term_name => $data) {
        $fr_term = pu_get_price_category_by_name($fr_term_name);
        if (!$fr_term) {
            continue;
        }

        pll_set_term_language($fr_term->term_id, 'fr');
        $term_translations = pll_get_term_translations($fr_term->term_id);

        if (!empty($term_translations['en'])) {
            $en_term_id = (int) $term_translations['en'];
        } else {
            $created_term = wp_insert_term($data['term'], 'pu_price_category');
            if (is_wp_error($created_term)) {
                continue;
            }

            $en_term_id = (int) $created_term['term_id'];
            pll_set_term_language($en_term_id, 'en');
            pll_save_term_translations(array('fr' => $fr_term->term_id, 'en' => $en_term_id));
        }

        foreach ($data['items'] as $fr_title => $en_item) {
            $fr_post = get_page_by_title($fr_title, OBJECT, 'pu_price');
            if (!$fr_post) {
                continue;
            }

            pll_set_post_language($fr_post->ID, 'fr');
            $post_translations = pll_get_post_translations($fr_post->ID);

            if (!empty($post_translations['en'])) {
                continue;
            }

            $en_id = wp_insert_post(array(
                'post_type' => 'pu_price',
                'post_status' => 'publish',
                'post_title' => $en_item['title'],
                'post_content' => $en_item['description'],
                'menu_order' => $fr_post->menu_order,
            ));

            if (is_wp_error($en_id)) {
                continue;
            }

            update_post_meta($en_id, '_pu_price', get_post_meta($fr_post->ID, '_pu_price', true));
            update_post_meta($en_id, '_pu_duration', get_post_meta($fr_post->ID, '_pu_duration', true));
            wp_set_object_terms($en_id, array($en_term_id), 'pu_price_category');

            pll_set_post_language($en_id, 'en');
            pll_save_post_translations(array('fr' => $fr_post->ID, 'en' => $en_id));
        }
    }
}

function pu_get_price_category_by_name($name) {
    $terms = get_terms(array(
        'taxonomy' => 'pu_price_category',
        'hide_empty' => false,
        'name' => $name,
        'lang' => '',
    ));

    if (is_wp_error($terms) || empty($terms)) {
        return false;
    }

    return $terms[0];
}

function pu_location_fields() {
    return array(
        'street'      => __('Street address', 'pause-urbaine'),
        'postal_city' => __('Postal code and city', 'pause-urbaine'),
        'country'     => __('Country', 'pause-urbaine'),
        'phone'       => __('Phone', 'pause-urbaine'),
        'instagram'   => __('Instagram account', 'pause-urbaine'),
        'booking_url' => __('Booking URL', 'pause-urbaine'),
        'maps_url'    => __('Google Maps URL', 'pause-urbaine'),
        'hours'       => __('Opening hours', 'pause-urbaine'),
    );
}

function pu_add_meta_boxes() {
    add_meta_box('pu_location_details', __('Location Details', 'pause-urbaine'), 'pu_location_meta_box', 'pu_location', 'normal', 'high');
    add_meta_box('pu_price_details', __('Price Details', 'pause-urbaine'), 'pu_price_meta_box', 'pu_price', 'side', 'high');
}
add_action('add_meta_boxes', 'pu_add_meta_boxes');

function pu_location_meta_box($post) {
    wp_nonce_field('pu_location_save', 'pu_location_nonce');
    foreach (pu_location_fields() as $key => $label) {
        $value = get_post_meta($post->ID, '_pu_' . $key, true);
        echo '<p><label for="pu_' . esc_attr($key) . '"><strong>' . esc_html($label) . '</strong></label><br>';
        if ($key === 'hours') {
            echo '<textarea id="pu_' . esc_attr($key) . '" name="pu_' . esc_attr($key) . '" rows="5" style="width:100%;">' . esc_textarea($value) . '</textarea>';
        } else {
            $type = str_contains($key, 'url') ? 'url' : 'text';
            echo '<input id="pu_' . esc_attr($key) . '" name="pu_' . esc_attr($key) . '" type="' . esc_attr($type) . '" value="' . esc_attr($value) . '" style="width:100%;">';
        }
        echo '</p>';
    }
}

function pu_price_meta_box($post) {
    wp_nonce_field('pu_price_save', 'pu_price_nonce');
    $price = get_post_meta($post->ID, '_pu_price', true);
    $duration = get_post_meta($post->ID, '_pu_duration', true);
    echo '<p><label for="pu_price"><strong>' . esc_html__('Price', 'pause-urbaine') . '</strong></label><br>';
    echo '<input id="pu_price" name="pu_price" type="text" value="' . esc_attr($price) . '" placeholder="70 CHF" style="width:100%;"></p>';
    echo '<p><label for="pu_duration"><strong>' . esc_html__('Duration', 'pause-urbaine') . '</strong></label><br>';
    echo '<input id="pu_duration" name="pu_duration" type="text" value="' . esc_attr($duration) . '" placeholder="45 min" style="width:100%;"></p>';
}

function pu_save_location($post_id) {
    if (!isset($_POST['pu_location_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['pu_location_nonce'])), 'pu_location_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || !current_user_can('edit_post', $post_id)) {
        return;
    }
    foreach (pu_location_fields() as $key => $label) {
        $field = 'pu_' . $key;
        if (!isset($_POST[$field])) {
            continue;
        }
        $value = wp_unslash($_POST[$field]);
        $value = str_contains($key, 'url') ? esc_url_raw($value) : sanitize_textarea_field($value);
        update_post_meta($post_id, '_pu_' . $key, $value);
    }
}
add_action('save_post_pu_location', 'pu_save_location');

function pu_save_price($post_id) {
    if (!isset($_POST['pu_price_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['pu_price_nonce'])), 'pu_price_save')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || !current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['pu_price'])) {
        update_post_meta($post_id, '_pu_price', sanitize_text_field(wp_unslash($_POST['pu_price'])));
    }
    if (isset($_POST['pu_duration'])) {
        update_post_meta($post_id, '_pu_duration', sanitize_text_field(wp_unslash($_POST['pu_duration'])));
    }
}
add_action('save_post_pu_price', 'pu_save_price');

function pu_default_locations() {
    return array(
        array(
            'title'       => 'Pause Urbaine Bel-Air',
            'street'      => 'Quai des Moulins 12A',
            'postal_city' => '1204 Genève',
            'country'     => 'Suisse',
            'phone'       => '022 310 4081',
            'instagram'   => 'pauseurbaine',
            'booking_url' => 'https://book.heygoldie.com/PauseUrbaine',
            'maps_url'    => 'https://www.google.com/maps/search/?api=1&query=Quai+des+Moulins+12A,+1204+Geneve',
            'hours'       => "Mardi - Vendredi: 10h - 18h\nSamedi: 10h - 17h\nDimanche - Lundi: Fermé",
            'content'     => '',
            'image'       => '',
        ),
        array(
            'title'       => 'Pause Urbaine Eaux-Vives',
            'street'      => 'Rue de Montchoisy 40',
            'postal_city' => '1207 Genève',
            'country'     => 'Suisse',
            'phone'       => '022 736 2030',
            'instagram'   => 'pauseurbaine_eauxvives',
            'booking_url' => 'https://book.heygoldie.com/PauseUrbaineEAUX-VIVES',
            'maps_url'    => 'https://www.google.com/maps/search/?api=1&query=Rue+de+Montchoisy+40,+1207+Geneve',
            'hours'       => "Mardi - Vendredi: 10h - 18h\nSamedi: 10h - 17h\nDimanche - Lundi: Fermé",
            'content'     => '',
            'image'       => '',
        ),
    );
}

function pu_seed_starter_content() {
    if (get_option('pu_starter_content_seeded')) {
        return;
    }

    $has_locations = get_posts(array(
        'post_type'      => 'pu_location',
        'posts_per_page' => 1,
        'post_status'    => 'any',
        'fields'         => 'ids',
    ));

    if (empty($has_locations)) {
        foreach (pu_default_locations() as $index => $location) {
            $post_id = wp_insert_post(array(
                'post_type'    => 'pu_location',
                'post_status'  => 'publish',
                'post_title'   => $location['title'],
                'post_content' => $location['content'],
                'menu_order'   => $index,
            ));

            if (!is_wp_error($post_id)) {
                foreach (pu_location_fields() as $key => $label) {
                    update_post_meta($post_id, '_pu_' . $key, $location[$key] ?? '');
                }
            }
        }
    }

    $has_prices = get_posts(array(
        'post_type'      => 'pu_price',
        'posts_per_page' => 1,
        'post_status'    => 'any',
        'fields'         => 'ids',
    ));

    if (empty($has_prices)) {
        foreach (pu_default_pricing() as $group_index => $group) {
            $term = term_exists($group['category'], 'pu_price_category');
            if (!$term) {
                $term = wp_insert_term($group['category'], 'pu_price_category');
            }

            if (is_wp_error($term)) {
                continue;
            }

            $term_id = is_array($term) ? (int) $term['term_id'] : (int) $term;

            foreach ($group['items'] as $item_index => $item) {
                $post_id = wp_insert_post(array(
                    'post_type'    => 'pu_price',
                    'post_status'  => 'publish',
                    'post_title'   => $item['title'],
                    'post_content' => $item['description'],
                    'menu_order'   => ($group_index * 100) + $item_index,
                ));

                if (is_wp_error($post_id)) {
                    continue;
                }

                wp_set_object_terms($post_id, array($term_id), 'pu_price_category');
                update_post_meta($post_id, '_pu_price', $item['price']);
                update_post_meta($post_id, '_pu_duration', $item['duration']);
            }
        }
    }

    update_option('pu_starter_content_seeded', 1, false);
}

function pu_get_locations() {
    $posts = get_posts(array(
        'post_type'      => 'pu_location',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
    ));
    if (!$posts) {
        return pu_default_locations();
    }
    return array_map(function ($post) {
        $location = array(
            'title'   => get_the_title($post),
            'content' => apply_filters('the_content', $post->post_content),
            'image'   => get_the_post_thumbnail_url($post, 'pu_card'),
        );
        foreach (pu_location_fields() as $key => $label) {
            $location[$key] = get_post_meta($post->ID, '_pu_' . $key, true);
        }
        return $location;
    }, $posts);
}

function pu_default_pricing() {
    return array(
        array('category' => 'Coupes / Brushing', 'items' => array(
            array('title' => 'Shampoing + massage crânien + coupe garçon + séchage', 'description' => '', 'price' => '38 CHF', 'duration' => ''),
            array('title' => 'Shampoing + coupe + brushing cheveux courts', 'description' => '', 'price' => '70 CHF', 'duration' => ''),
            array('title' => 'Shampoing + coupe + brushing cheveux mi-longs', 'description' => '', 'price' => '80 CHF', 'duration' => ''),
            array('title' => 'Shampoing + coupe + brushing cheveux longs', 'description' => '', 'price' => '90 CHF', 'duration' => ''),
            array('title' => 'Brushing, shampoing inclus', 'description' => 'Cheveux courts, mi-longs ou longs.', 'price' => '45 - 55 CHF', 'duration' => ''),
        )),
        array('category' => 'Colorations / Mèches', 'items' => array(
            array('title' => 'Couleur racine', 'description' => 'Shampoing + soin inclus.', 'price' => '70 - 90 CHF', 'duration' => ''),
            array('title' => 'Coloration complète', 'description' => 'Avec ou sans brushing selon la longueur.', 'price' => '95 - 115 CHF', 'duration' => ''),
            array('title' => 'Patine', 'description' => 'Shampoing + soin inclus.', 'price' => '95 - 115 CHF', 'duration' => ''),
            array('title' => 'Mèches', 'description' => 'Tête complète ou demi-tête.', 'price' => '95 - 135 CHF', 'duration' => ''),
        )),
        array('category' => 'Lissages / Soins', 'items' => array(
            array('title' => 'Botox capillaire + coupe + brushing', 'description' => '', 'price' => '125 - 145 CHF', 'duration' => ''),
            array('title' => 'Lissage bio à la kératine', 'description' => 'Sans formol.', 'price' => '190 - 250 CHF', 'duration' => ''),
            array('title' => 'Hydratation à la kératine', 'description' => 'Brushing inclus.', 'price' => '70 - 90 CHF', 'duration' => ''),
        )),
    );
}

function pu_get_pricing() {
    $terms = get_terms(array(
        'taxonomy'   => 'pu_price_category',
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ));
    $groups = array();
    foreach ($terms as $term) {
        $posts = get_posts(array(
            'post_type'      => 'pu_price',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'menu_order title',
            'order'          => 'ASC',
            'tax_query'      => array(array(
                'taxonomy' => 'pu_price_category',
                'field'    => 'term_id',
                'terms'    => $term->term_id,
            )),
        ));
        if (!$posts) {
            continue;
        }
        $groups[] = array(
            'category' => $term->name,
            'items'    => array_map(function ($post) {
                return array(
                    'title'       => get_the_title($post),
                    'description' => apply_filters('the_content', $post->post_content),
                    'price'       => get_post_meta($post->ID, '_pu_price', true),
                    'duration'    => get_post_meta($post->ID, '_pu_duration', true),
                );
            }, $posts),
        );
    }
    return $groups ?: pu_default_pricing();
}

function pu_get_articles() {
    $default_post = get_page_by_path('hello-world', OBJECT, 'post');
    $exclude = array();

    if ($default_post && str_contains($default_post->post_content, 'Welcome to WordPress. This is your first post.')) {
        $exclude[] = $default_post->ID;
    }

    return new WP_Query(array(
        'post_type'           => 'post',
        'posts_per_page'      => 3,
        'post_status'         => 'publish',
        'ignore_sticky_posts' => true,
        'post__not_in'        => $exclude,
    ));
}
