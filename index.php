<?php get_header(); ?>

<main id="conteudo-principal" class="container">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                
                <?php if ( has_post_thumbnail() ) : ?>
                    <div><?php the_post_thumbnail( 'medium' ); ?></div>
                <?php endif; ?>

                <div>
                    <?php the_excerpt(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p>Nenhum conteúdo encontrado para o site ASBC TV.</p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>