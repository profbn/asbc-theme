<?php get_header(); ?>

<main id="conteudo-principal" class="page-layout-grid">
    <div class="primary-content">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            
            <article id="page-<?php the_ID(); ?>" <?php post_class('single-article'); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="post-featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>

        <?php endwhile; endif; ?>
    </div>

    <!-- Puxa a sidebar para o lado direito da página -->
    <?php get_sidebar(); ?>
</main>

<?php get_footer(); ?>