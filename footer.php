<footer class="site-footer">
    <div class="container footer-container">
        <div class="footer-info">
            <p>&copy; <?php echo esc_html( current_time( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. Todos os direitos reservados.</p>
        </div>

        <nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Navegação do rodapé', 'asbc-theme' ); ?>">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer-menu',
                'fallback_cb'    => false,
                'container'      => false,
            ) );
            ?>
        </nav>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
