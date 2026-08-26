<footer class="site-footer">
    <div class="container footer-container">
        <div class="footer-info">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Todos os direitos reservados.</p>
        </div>
        
        <nav class="footer-navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer-menu',
                'fallback_cb'    => false,
            ) );
            ?>
        </nav>
    </div>
    <?php wp_footer(); ?>
</footer>
</body>
</html>