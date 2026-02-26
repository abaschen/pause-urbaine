<?php
/**
 * Template Name: Contact Page
 */
get_header(); ?>

<div class="contact-page">
    <?php while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
        
        <div class="content">
            <?php the_content(); ?>
        </div>
        
        <div class="locations-grid">
            <?php 
            $locations = pause_urbaine_get_locations();
            $lang = pause_urbaine_get_lang();
            foreach ($locations as $location) : 
            ?>
            <div class="location-card">
                <h2 class="location-card__title">
                    <?php echo esc_html($location['name'][$lang]); ?>
                </h2>
                
                <div class="location-card__info">
                    <div class="location-card__address">
                        <p>
                            <i class="fa-solid fa-map-marker-alt" aria-hidden="true"></i>
                            <a href="<?php echo esc_url($location['maps_url']); ?>" target="_blank" rel="noopener" class="address-link">
                                <?php echo esc_html($location['address']['street']); ?><br>
                                <?php echo esc_html($location['address']['postal'] . ' ' . $location['address']['city']); ?><br>
                                <?php echo esc_html($location['address']['country']); ?>
                            </a>
                        </p>
                    </div>
                    
                    <div class="location-card__contact">
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
                        <?php if (!empty($location['booking_url'])) : ?>
                        <p>
                            <a href="<?php echo esc_url($location['booking_url']); ?>" target="_blank" rel="noopener" class="btn btn-primary">
                                <i class="fa-solid fa-calendar-check" aria-hidden="true"></i>
                                <?php echo $lang === 'en' ? 'Book online' : 'Réserver en ligne'; ?>
                            </a>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
