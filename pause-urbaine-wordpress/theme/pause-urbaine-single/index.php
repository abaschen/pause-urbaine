<?php
get_header();

if (!is_front_page() && !is_home()) :
    ?>
    <section class="section">
        <div class="section-inner content-page">
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class('rich-text'); ?>>
                    <h1><?php the_title(); ?></h1>
                    <?php if (has_post_thumbnail()) : the_post_thumbnail('pu_hero'); endif; ?>
                    <?php the_content(); ?>
                </article>
            <?php endwhile; ?>
        </div>
    </section>
    <?php
    get_footer();
    return;
endif;

$locations = pu_get_locations();
$pricing = pu_get_pricing();
$articles = pu_get_articles();
$first_location = $locations[0] ?? array();
$hero_image = !empty($first_location['image']) ? $first_location['image'] : get_template_directory_uri() . '/assets/hero-placeholder.svg';
?>

<section class="hero">
    <img class="hero__image" src="<?php echo esc_url($hero_image); ?>" alt="">
    <div class="hero__content">
        <p class="eyebrow"><?php echo esc_html(pu_option('hero_eyebrow', 'Coiffure, couleur et soins à Genève')); ?></p>
        <h1><?php echo esc_html(pu_option('hero_title', 'Pause Urbaine')); ?></h1>
        <p><?php echo esc_html(pu_option('hero_text', 'Deux salons à Genève pour une pause simple, soignée et chaleureuse.')); ?></p>
        <div class="hero__actions">
            <?php if (!empty($first_location['booking_url'])) : ?>
                <a class="button button--primary" href="<?php echo esc_url($first_location['booking_url']); ?>" target="_blank" rel="noopener"><?php echo esc_html(pu_text('Reserver', 'Book now')); ?></a>
            <?php endif; ?>
            <a class="button button--ghost" href="#tarifs"><?php echo esc_html(pu_text('Voir les tarifs', 'View pricing')); ?></a>
        </div>
    </div>
</section>

<section class="section section--intro">
    <div class="section-inner intro-grid">
        <div>
            <p class="eyebrow"><?php echo esc_html(pu_text('Bienvenue', 'Welcome')); ?></p>
            <h2><?php echo esc_html(pu_option('intro_title', 'Une pause au cœur de la ville')); ?></h2>
        </div>
        <div class="rich-text">
            <p><?php echo esc_html(pu_option('intro_text', 'Coupes, brushings, colorations, soins capillaires, ongles et esthétique dans une ambiance de quartier attentive.')); ?></p>
            <?php if (is_front_page() && is_page()) : ?>
                <?php while (have_posts()) : the_post(); the_content(); endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section" id="salons">
    <div class="section-inner">
        <div class="section-heading">
            <p class="eyebrow"><?php echo esc_html(pu_text('Deux adresses', 'Two locations')); ?></p>
            <h2><?php echo esc_html(pu_text('Nos salons à Genève', 'Our Geneva salons')); ?></h2>
        </div>
        <div class="location-grid">
            <?php foreach ($locations as $location) : ?>
                <article class="location-card">
                    <?php if (!empty($location['image'])) : ?><img src="<?php echo esc_url($location['image']); ?>" alt=""><?php endif; ?>
                    <div class="location-card__body">
                        <h3><?php echo esc_html($location['title']); ?></h3>
                        <?php if (!empty($location['content'])) : ?><div class="location-card__description"><?php echo wp_kses_post($location['content']); ?></div><?php endif; ?>
                        <address>
                            <?php if (!empty($location['street'])) : ?><span><?php echo esc_html($location['street']); ?></span><?php endif; ?>
                            <?php if (!empty($location['postal_city'])) : ?><span><?php echo esc_html($location['postal_city']); ?></span><?php endif; ?>
                            <?php if (!empty($location['country'])) : ?><span><?php echo esc_html($location['country']); ?></span><?php endif; ?>
                        </address>
                        <?php if (!empty($location['hours'])) : ?><p class="location-hours"><?php echo nl2br(esc_html($location['hours'])); ?></p><?php endif; ?>
                        <div class="card-actions">
                            <?php if (!empty($location['booking_url'])) : ?><a class="button button--primary" href="<?php echo esc_url($location['booking_url']); ?>" target="_blank" rel="noopener"><?php echo esc_html(pu_text('Reserver', 'Book')); ?></a><?php endif; ?>
                            <?php if (!empty($location['maps_url'])) : ?><a class="button button--light" href="<?php echo esc_url($location['maps_url']); ?>" target="_blank" rel="noopener"><?php echo esc_html(pu_text('Itinéraire', 'Directions')); ?></a><?php endif; ?>
                            <?php if (!empty($location['instagram'])) : ?><a class="text-link" href="https://www.instagram.com/<?php echo esc_attr(ltrim($location['instagram'], '@')); ?>" target="_blank" rel="noopener">@<?php echo esc_html(ltrim($location['instagram'], '@')); ?></a><?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section--pricing" id="tarifs">
    <div class="section-inner">
        <div class="section-heading">
            <p class="eyebrow"><?php echo esc_html(pu_text('Prestations', 'Services')); ?></p>
            <h2><?php echo esc_html(pu_text('Tarifs', 'Pricing')); ?></h2>
            <p><?php echo esc_html(pu_option('pricing_note', "Les prix peuvent varier selon la longueur et l'épaisseur des cheveux.")); ?></p>
        </div>
        <div class="pricing-list">
            <?php foreach ($pricing as $group) : ?>
                <section class="pricing-group">
                    <h3><?php echo esc_html($group['category']); ?></h3>
                    <?php foreach ($group['items'] as $item) : ?>
                        <div class="price-row">
                            <div>
                                <strong><?php echo esc_html($item['title']); ?></strong>
                                <?php if (!empty($item['description'])) : echo wp_kses_post(wpautop($item['description'])); endif; ?>
                                <?php if (!empty($item['duration'])) : ?><p><?php echo esc_html($item['duration']); ?></p><?php endif; ?>
                            </div>
                            <span><?php echo esc_html($item['price']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </section>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section" id="articles">
    <div class="section-inner">
        <div class="section-heading">
            <p class="eyebrow"><?php echo esc_html(pu_text('Actualites', 'Journal')); ?></p>
            <h2><?php echo esc_html(pu_text('Articles', 'Articles')); ?></h2>
        </div>
        <?php if ($articles->have_posts()) : ?>
            <div class="article-grid">
                <?php while ($articles->have_posts()) : $articles->the_post(); ?>
                    <article <?php post_class('article-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('pu_card'); ?></a><?php endif; ?>
                        <div class="article-card__body">
                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <?php the_excerpt(); ?>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <p class="empty-note"><?php echo esc_html(pu_text('Les prochains articles apparaitront ici.', 'New articles will appear here.')); ?></p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
