    </div>
</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-locations">
                <h3><?php echo pause_urbaine_get_lang() === 'en' ? 'Our Locations' : 'Nos Salons'; ?></h3>
                <div class="locations-grid">
                    <?php 
                    $locations = pause_urbaine_get_locations();
                    $lang = pause_urbaine_get_lang();
                    foreach ($locations as $location) : 
                    ?>
                    <div class="footer-location">
                        <h4>
                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                            <?php echo esc_html($location['name'][$lang]); ?>
                        </h4>
                        
                        <div class="location-details">
                            <p class="address">
                                <i class="fa-solid fa-map-marker-alt" aria-hidden="true"></i>
                                <?php echo esc_html($location['address']['street']); ?><br>
                                <?php echo esc_html($location['address']['postal'] . ' ' . $location['address']['city']); ?><br>
                                <?php echo esc_html($location['address']['country']); ?>
                            </p>
                            
                            <p class="contact-info">
                                <a href="tel:<?php echo esc_attr($location['phone']); ?>">
                                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                                    <?php echo esc_html($location['phone']); ?>
                                </a>
                            </p>
                            
                            <p class="social-link">
                                <a href="https://www.instagram.com/<?php echo esc_attr($location['instagram']); ?>" target="_blank" rel="noopener">
                                    <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                                    <?php echo esc_html($location['instagram']); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="footer-hours">
                <h3>
                    <i class="fa-solid fa-clock" aria-hidden="true"></i>
                    <?php echo $lang === 'en' ? 'Opening Hours' : 'Horaires'; ?>
                </h3>
                <ul class="hours-list">
                    <?php foreach ($locations[0]['hours'] as $hour) : ?>
                    <li>
                        <span class="day"><?php echo esc_html($hour['day'][$lang]); ?>:</span>
                        <span class="time"><?php echo esc_html($hour['time']); ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p class="copyright">
                &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php echo $lang === 'en' ? 'All rights reserved.' : 'Tous droits réservés.'; ?>
            </p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
