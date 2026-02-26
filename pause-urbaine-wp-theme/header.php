<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-main">
        <div class="container">
            <nav class="main-nav" aria-label="<?php esc_attr_e('Main Navigation', 'pause-urbaine'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => '',
                    'fallback_cb' => function() {
                        echo '<ul>';
                        echo '<li><a href="' . esc_url(home_url('/')) . '">' . (pause_urbaine_get_lang() === 'en' ? 'Home' : 'Accueil') . '</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/services')) . '">' . (pause_urbaine_get_lang() === 'en' ? 'Services' : 'Services') . '</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/tarifs')) . '">' . (pause_urbaine_get_lang() === 'en' ? 'Pricing' : 'Tarifs') . '</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/contact')) . '">' . (pause_urbaine_get_lang() === 'en' ? 'Contact' : 'Contact') . '</a></li>';
                        echo '</ul>';
                    }
                ));
                ?>
            </nav>
            
            <div class="header-actions">
                <?php if (function_exists('pll_the_languages')) : ?>
                <ul class="language-switcher">
                    <?php pll_the_languages(array('show_flags' => 1, 'show_names' => 0)); ?>
                </ul>
                <?php endif; ?>
                
                <button class="mobile-menu-toggle" aria-label="<?php esc_attr_e('Menu', 'pause-urbaine'); ?>">
                    <i class="fa-solid fa-bars" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
    
    <div class="header-locations">
        <div class="container">
            <div class="locations-bar">
                <?php 
                $locations = pause_urbaine_get_locations();
                $lang = pause_urbaine_get_lang();
                foreach ($locations as $location) : 
                ?>
                <div class="location-quick-info">
                    <a href="<?php echo esc_url($location['maps_url']); ?>" target="_blank" rel="noopener noreferrer" class="location-name">
                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                        <?php echo esc_html($location['name'][$lang]); ?>
                    </a>
                    <a href="tel:<?php echo esc_attr($location['phone']); ?>" class="phone-link">
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        <?php echo esc_html($location['phone']); ?>
                    </a>
                    <a href="https://instagram.com/<?php echo esc_attr($location['instagram']); ?>" class="instagram-link" target="_blank" rel="noopener">
                        <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                        <?php echo esc_html($location['instagram']); ?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</header>

<main class="main">
    <div class="container">
