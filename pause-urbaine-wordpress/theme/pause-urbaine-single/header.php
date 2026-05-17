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
            <a href="#salons"><?php echo esc_html(pu_translate('Salons')); ?></a>
            <a href="#tarifs"><?php echo esc_html(pu_translate('Tarifs')); ?></a>
            <a href="#articles"><?php echo esc_html(pu_translate('Articles')); ?></a>
            <a href="#contact"><?php echo esc_html(pu_translate('Contact')); ?></a>
            <?php if (function_exists('pll_the_languages')) : ?>
                <?php
                $languages = pll_the_languages(array(
                    'raw' => 1,
                    'show_flags' => 0,
                    'show_names' => 0,
                    'display_names_as' => 'slug',
                    'hide_current' => 0,
                ));
                $current_language = null;
                foreach ($languages as $language) {
                    if (!empty($language['current_lang'])) {
                        $current_language = $language;
                        break;
                    }
                }
                ?>
                <?php if ($current_language && count($languages) > 1) : ?>
                    <div class="language-switcher" data-language-switcher>
                        <button class="language-switcher__toggle" type="button" aria-expanded="false" aria-haspopup="true" data-language-toggle>
                            <?php echo esc_html(strtoupper($current_language['slug'])); ?>
                        </button>
                        <ul class="language-switcher__menu" data-language-menu>
                            <?php foreach ($languages as $language) : ?>
                                <?php if (!empty($language['current_lang'])) : continue; endif; ?>
                                <li>
                                    <a href="<?php echo esc_url($language['url']); ?>" lang="<?php echo esc_attr($language['slug']); ?>">
                                        <?php echo esc_html(strtoupper($language['slug'])); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main id="content">
