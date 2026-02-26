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
        
    
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
