<?php get_header(); ?>

<main id="conteudo-principal" class="container page-layout-grid">
    <div class="primary-content">
        <header class="archive-header">
            <h1 class="archive-title">
                Resultados para: <span>"<?php echo get_search_query(); ?>"</span>
            </h1>
        </header>

        <?php if ( have_posts() ) : ?>
            <div class="posts-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('card-post'); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="card-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="card-body">
                            <span class="card-date"><?php echo get_the_date(); ?></span>
                            <h3 class="card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div class="card-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn-read-more">Leia mais &raquo;</a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="posts-pagination">
                <?php the_posts_pagination( array(
                    'mid_size'  => 2,
                    'prev_text' => __( '&laquo; Anteriores', 'asbc-theme' ),
                    'next_text' => __( 'Próximos &raquo;', 'asbc-theme' ),
                ) ); ?>
            </div>

        <?php else : ?>
            <div class="no-results">
                <p>Nenhuma notícia ou conteúdo foi encontrado com este termo.</p>
                <p>Tente buscar por palavras-chave diferentes:</p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>

    <?php get_sidebar(); ?>
</main>

<?php get_footer(); ?>