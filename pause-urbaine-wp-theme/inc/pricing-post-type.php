<?php
/**
 * Pricing Custom Post Type
 */

// Register Pricing Post Type
function pause_urbaine_register_pricing_post_type() {
    $labels = array(
        'name'                  => _x('Pricing', 'Post Type General Name', 'pause-urbaine'),
        'singular_name'         => _x('Price', 'Post Type Singular Name', 'pause-urbaine'),
        'menu_name'             => __('Pricing', 'pause-urbaine'),
        'name_admin_bar'        => __('Price', 'pause-urbaine'),
        'archives'              => __('Price Archives', 'pause-urbaine'),
        'attributes'            => __('Price Attributes', 'pause-urbaine'),
        'parent_item_colon'     => __('Parent Price:', 'pause-urbaine'),
        'all_items'             => __('All Prices', 'pause-urbaine'),
        'add_new_item'          => __('Add New Price', 'pause-urbaine'),
        'add_new'               => __('Add New', 'pause-urbaine'),
        'new_item'              => __('New Price', 'pause-urbaine'),
        'edit_item'             => __('Edit Price', 'pause-urbaine'),
        'update_item'           => __('Update Price', 'pause-urbaine'),
        'view_item'             => __('View Price', 'pause-urbaine'),
        'view_items'            => __('View Prices', 'pause-urbaine'),
        'search_items'          => __('Search Price', 'pause-urbaine'),
        'not_found'             => __('Not found', 'pause-urbaine'),
        'not_found_in_trash'    => __('Not found in Trash', 'pause-urbaine'),
    );
    
    $args = array(
        'label'                 => __('Price', 'pause-urbaine'),
        'description'           => __('Service pricing', 'pause-urbaine'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'page-attributes'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-tag',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );
    
    register_post_type('pricing', $args);
}
add_action('init', 'pause_urbaine_register_pricing_post_type', 0);

// Register Pricing Category Taxonomy
function pause_urbaine_register_pricing_category_taxonomy() {
    $labels = array(
        'name'                       => _x('Categories', 'Taxonomy General Name', 'pause-urbaine'),
        'singular_name'              => _x('Category', 'Taxonomy Singular Name', 'pause-urbaine'),
        'menu_name'                  => __('Categories', 'pause-urbaine'),
        'all_items'                  => __('All Categories', 'pause-urbaine'),
        'parent_item'                => __('Parent Category', 'pause-urbaine'),
        'parent_item_colon'          => __('Parent Category:', 'pause-urbaine'),
        'new_item_name'              => __('New Category Name', 'pause-urbaine'),
        'add_new_item'               => __('Add New Category', 'pause-urbaine'),
        'edit_item'                  => __('Edit Category', 'pause-urbaine'),
        'update_item'                => __('Update Category', 'pause-urbaine'),
        'view_item'                  => __('View Category', 'pause-urbaine'),
        'separate_items_with_commas' => __('Separate categories with commas', 'pause-urbaine'),
        'add_or_remove_items'        => __('Add or remove categories', 'pause-urbaine'),
        'choose_from_most_used'      => __('Choose from the most used', 'pause-urbaine'),
        'popular_items'              => __('Popular Categories', 'pause-urbaine'),
        'search_items'               => __('Search Categories', 'pause-urbaine'),
        'not_found'                  => __('Not Found', 'pause-urbaine'),
        'no_terms'                   => __('No categories', 'pause-urbaine'),
        'items_list'                 => __('Categories list', 'pause-urbaine'),
        'items_list_navigation'      => __('Categories list navigation', 'pause-urbaine'),
    );
    
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
    );
    
    register_taxonomy('pricing_category', array('pricing'), $args);
}
add_action('init', 'pause_urbaine_register_pricing_category_taxonomy', 0);

// Add meta boxes for pricing
function pause_urbaine_add_pricing_meta_boxes() {
    add_meta_box(
        'pricing_details',
        __('Pricing Details', 'pause-urbaine'),
        'pause_urbaine_pricing_details_callback',
        'pricing',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'pause_urbaine_add_pricing_meta_boxes');

// Meta box callback
function pause_urbaine_pricing_details_callback($post) {
    wp_nonce_field('pause_urbaine_pricing_meta_box', 'pause_urbaine_pricing_meta_box_nonce');
    
    $price = get_post_meta($post->ID, '_pricing_price', true);
    $duration = get_post_meta($post->ID, '_pricing_duration', true);
    
    ?>
    <p>
        <label for="pricing_price"><strong><?php _e('Price (CHF)', 'pause-urbaine'); ?></strong></label><br>
        <input type="text" id="pricing_price" name="pricing_price" value="<?php echo esc_attr($price); ?>" style="width: 100%;" placeholder="70 CHF">
        <span class="description"><?php _e('e.g., "70 CHF" or "70-90 CHF"', 'pause-urbaine'); ?></span>
    </p>
    <p>
        <label for="pricing_duration"><strong><?php _e('Duration', 'pause-urbaine'); ?></strong></label><br>
        <input type="text" id="pricing_duration" name="pricing_duration" value="<?php echo esc_attr($duration); ?>" style="width: 100%;" placeholder="45 min">
        <span class="description"><?php _e('e.g., "45 min" or "1h 30min"', 'pause-urbaine'); ?></span>
    </p>
    <?php
}

// Save meta box data
function pause_urbaine_save_pricing_meta_box_data($post_id) {
    if (!isset($_POST['pause_urbaine_pricing_meta_box_nonce'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['pause_urbaine_pricing_meta_box_nonce'], 'pause_urbaine_pricing_meta_box')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['pricing_price'])) {
        update_post_meta($post_id, '_pricing_price', sanitize_text_field($_POST['pricing_price']));
    }
    
    if (isset($_POST['pricing_duration'])) {
        update_post_meta($post_id, '_pricing_duration', sanitize_text_field($_POST['pricing_duration']));
    }
}
add_action('save_post', 'pause_urbaine_save_pricing_meta_box_data');

// Get all pricing items grouped by category
function pause_urbaine_get_pricing_data() {
    $categories = get_terms(array(
        'taxonomy' => 'pricing_category',
        'hide_empty' => false,
        'orderby' => 'term_order',
    ));
    
    $pricing_data = array();
    
    foreach ($categories as $category) {
        $items = get_posts(array(
            'post_type' => 'pricing',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'pricing_category',
                    'field' => 'term_id',
                    'terms' => $category->term_id,
                ),
            ),
        ));
        
        $services = array();
        foreach ($items as $item) {
            $services[] = array(
                'name' => $item->post_title,
                'description' => $item->post_content,
                'price' => get_post_meta($item->ID, '_pricing_price', true),
                'duration' => get_post_meta($item->ID, '_pricing_duration', true),
            );
        }
        
        if (!empty($services)) {
            $pricing_data[] = array(
                'category' => $category->name,
                'services' => $services,
            );
        }
    }
    
    return $pricing_data;
}
