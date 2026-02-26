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
        
        <div class="pricing-contact">
            <h2><?php echo pause_urbaine_get_lang() === 'en' ? 'Ready to book?' : 'Prêt à réserver ?'; ?></h2>
            <p><?php echo pause_urbaine_get_lang() === 'en' ? 'Contact us to schedule your appointment' : 'Contactez-nous pour prendre rendez-vous'; ?></p>
            
            <div class="pricing-locations">
                <?php 
                $locations = pause_urbaine_get_locations();
                $lang = pause_urbaine_get_lang();
                foreach ($locations as $location) : 
                ?>
                <div class="pricing-location-card">
                    <h3>
                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                        <?php echo esc_html($location['name'][$lang]); ?>
                    </h3>
                    <p>
                        <i class="fa-solid fa-phone" aria-hidden="true"></i>
                        <a href="tel:<?php echo esc_attr($location['phone']); ?>">
                            <?php echo esc_html($location['phone']); ?>
                        </a>
                    </p>
                    <p>
                        <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                        <a href="https://www.instagram.com/<?php echo esc_attr($location['instagram']); ?>" target="_blank" rel="noopener">
                            <?php echo esc_html($location['instagram']); ?>
                        </a>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="pricing-contact-link">
                <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary">
                    <?php echo pause_urbaine_get_lang() === 'en' ? 'Contact Us' : 'Nous Contacter'; ?>
                </a>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
