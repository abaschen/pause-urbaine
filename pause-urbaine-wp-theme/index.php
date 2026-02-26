<?php get_header(); ?>

<div class="hero">
    <div class="hero-content">
        <h1 class="hero-subtitle">
            <?php 
            if (pause_urbaine_get_lang() === 'en') {
                echo 'Your urban break in Geneva';
            } else {
                echo 'Votre pause urbaine à Genève';
            }
            ?>
        </h1>
        <div class="hero-cta">
            <a href="<?php echo esc_url(home_url('/services')); ?>" class="btn btn-primary">
                <?php echo pause_urbaine_get_lang() === 'en' ? 'Our Services' : 'Nos Services'; ?>
            </a>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-secondary">
                <?php echo pause_urbaine_get_lang() === 'en' ? 'Book Now' : 'Réserver'; ?>
            </a>
        </div>
    </div>
</div>

<div class="homepage">
    <section class="intro">
        <div class="container">
            <div class="intro-content">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </section>
</div>

<?php get_footer(); ?>
