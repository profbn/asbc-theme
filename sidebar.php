<?php if ( is_active_sidebar( 'main-sidebar' ) ) : ?>
    <aside id="secondary" class="widget-area sidebar-container" role="complementary">
        <?php dynamic_sidebar( 'main-sidebar' ); ?>
    </aside>
<?php endif; ?>