<?php get_header(); ?>

<main class="container page-layout-grid">
    <div class="primary-content">
        <section class="error-404 not-found">
            <h1 class="error-title">404</h1>
            <h2 class="error-subtitle">Página não encontrada!</h2>
            <p class="error-message">A página ou o conteúdo que você está procurando não existe ou foi movido.</p>
            
            <div class="error-search-form">
                <?php get_search_form(); ?>
            </div>

            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-read-more" style="display: inline-block; margin-top: 20px;">&laquo; Voltar para a Página Inicial</a>
        </section>
    </div>

    <?php get_sidebar(); ?>
</main>

<?php get_footer(); ?>