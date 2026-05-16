<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <a class="skip-link" href="#content"><?php esc_html_e('Skip to content', 'pause-urbaine'); ?></a>
    <div class="site-header__inner">
        <a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <span class="brand__mark">PU</span>
                <span class="brand__name">Pause Urbaine</span>
            <?php endif; ?>
        </a>

        <button class="nav-toggle" type="button" aria-controls="site-nav" aria-expanded="false" data-nav-toggle>
            <span></span><span></span><span></span>
            <span class="screen-reader-text"><?php esc_html_e('Menu', 'pause-urbaine'); ?></span>
        </button>

        <nav class="site-nav" id="site-nav" data-site-nav>
            <a href="#salons"><?php echo esc_html(pu_text('Salons', 'Locations')); ?></a>
            <a href="#tarifs"><?php echo esc_html(pu_text('Tarifs', 'Pricing')); ?></a>
            <a href="#articles"><?php echo esc_html(pu_text('Articles', 'Articles')); ?></a>
            <a href="#contact"><?php echo esc_html(pu_text('Contact', 'Contact')); ?></a>
        </nav>
    </div>
</header>

<main id="content">
