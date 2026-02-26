<?php
/**
 * Template Name: Pricing Page
 */
get_header(); ?>

<div class="pricing-page">
    <?php while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
        
        <div class="content">
            <?php the_content(); ?>
        </div>
        
        <?php if (get_theme_mod('pause_urbaine_show_pricing', true)) : ?>
            <?php 
            $pricing_data = pause_urbaine_get_pricing_data();
            if (!empty($pricing_data)) :
            ?>
                <?php foreach ($pricing_data as $category_data) : ?>
                <div class="pricing-category">
                    <h2><?php echo esc_html($category_data['category']); ?></h2>
                    <div class="pricing-services">
                        <?php foreach ($category_data['services'] as $service) : ?>
                        <div class="pricing-service-card">
                            <div class="pricing-service-info">
                                <h3 class="pricing-service-name"><?php echo esc_html($service['name']); ?></h3>
                                <?php if (!empty($service['duration'])) : ?>
                                <p class="pricing-service-duration">
                                    <i class="fa-solid fa-clock" aria-hidden="true"></i>
                                    <?php echo esc_html($service['duration']); ?>
                                </p>
                                <?php endif; ?>
                                <?php if (!empty($service['description'])) : ?>
                                <div class="pricing-service-description">
                                    <?php echo wpautop($service['description']); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($service['price'])) : ?>
                            <div class="pricing-service-price">
                                <?php echo esc_html($service['price']); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <?php if (get_theme_mod('pause_urbaine_pricing_note')) : ?>
                <div class="pricing-notes">
                    <p><?php echo esc_html(get_theme_mod('pause_urbaine_pricing_note')); ?></p>
                </div>
                <?php endif; ?>
            <?php else : ?>
                <p><?php echo pause_urbaine_get_lang() === 'en' ? 'No pricing information available.' : 'Aucune information tarifaire disponible.'; ?></p>
            <?php endif; ?>
        <?php endif; ?>
        
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
