<?php
/**
 * Template Name: Services Page
 */
get_header(); ?>

<div class="services-page">
    <?php while (have_posts()) : the_post(); ?>
        <div class="page-header">
            <h1><?php the_title(); ?></h1>
          
        </div>
        
        <div class="services-content">
            <div class="content">
                <?php the_content(); ?>
            </div>
        </div>
        
        <div class="services-cta">
            <div class="cta-card">
                <h2><?php echo pause_urbaine_get_lang() === 'en' ? 'Ready to book?' : 'Prêt à réserver ?'; ?></h2>
                <p><?php echo pause_urbaine_get_lang() === 'en' ? 'Contact us to schedule your appointment' : 'Contactez-nous pour prendre rendez-vous'; ?></p>
                <div class="cta-buttons">
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary">
                        <?php echo pause_urbaine_get_lang() === 'en' ? 'Contact Us' : 'Nous Contacter'; ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/tarifs')); ?>" class="btn btn-outline">
                        <?php echo pause_urbaine_get_lang() === 'en' ? 'View Pricing' : 'Voir les Tarifs'; ?>
                    </a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
