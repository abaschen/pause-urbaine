</main>

<footer class="site-footer" id="contact">
    <div class="section-inner footer-grid">
        <div>
            <p class="eyebrow"><?php echo esc_html(pu_text('Contact', 'Contact')); ?></p>
            <h2>Pause Urbaine</h2>
            <p><?php echo esc_html(pu_option('hero_text', 'Deux salons à Genève pour une pause simple, soignée et chaleureuse.')); ?></p>
        </div>

        <div class="footer-locations">
            <?php foreach (pu_get_locations() as $location) : ?>
                <address>
                    <strong><?php echo esc_html($location['title']); ?></strong>
                    <?php if (!empty($location['street'])) : ?><span><?php echo esc_html($location['street']); ?></span><?php endif; ?>
                    <?php if (!empty($location['postal_city'])) : ?><span><?php echo esc_html($location['postal_city']); ?></span><?php endif; ?>
                    <?php if (!empty($location['phone'])) : ?><a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $location['phone'])); ?>"><?php echo esc_html($location['phone']); ?></a><?php endif; ?>
                </address>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="footer-bottom">
        <span>&copy; <?php echo esc_html(date('Y')); ?> Pause Urbaine</span>
        <a href="#content"><?php echo esc_html(pu_text('Retour en haut', 'Back to top')); ?></a>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
