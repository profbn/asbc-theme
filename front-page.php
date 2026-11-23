<?php
/**
 * Página inicial com player HLS e últimas publicações.
 */
get_header();

$asbc_streams = apply_filters( 'asbc_stream_sources', array(
    'primary' => 'https://asbc.bntv.com.br/8d385a50-c5f0-4ddd-8f33-e35e1febbece.m3u8',
    'backup'  => 'https://asbc.bntv.com.br/memfs/5986a150-9125-4035-9266-77e8fa3ef60b.m3u8',
) );
?>

<main id="conteudo-principal" class="container asbc-front-page">
    <section class="live-stream-section" aria-labelledby="asbc-live-heading">
        <h1 id="asbc-live-heading">Transmissão Ao Vivo - TV ASBC</h1>
        <div class="video-responsive">
            <video id="asbc-player" class="asbc-player"
                aria-label="<?php esc_attr_e( 'Transmissão ao vivo da TV ASBC', 'asbc-theme' ); ?>"
                data-stream-primary="<?php echo esc_attr( esc_url( $asbc_streams['primary'] ?? '' ) ); ?>"
                data-stream-backup="<?php echo esc_attr( esc_url( $asbc_streams['backup'] ?? '' ) ); ?>"
                controls autoplay muted playsinline preload="none">
                Seu navegador não suporta a reprodução de vídeo HTML5.
            </video>
        </div>
        <div class="player-actions">
            <p id="asbc-player-status" role="status" aria-live="polite">Carregando transmissão...</p>
            <button id="asbc-player-retry" class="btn-read-more" type="button">Tentar novamente</button>
        </div>
    </section>

    <?php if ( is_page() && have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php if ( trim( get_the_content() ) !== '' ) : ?>
                <section class="front-page-content entry-content">
                    <?php the_content(); ?>
                </section>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php endif; ?>

    <section class="latest-news" aria-labelledby="asbc-news-heading">
        <h2 id="asbc-news-heading" class="section-heading">Últimas Novidades</h2>
        <div class="posts-grid">
            <?php
            $recent_posts = new WP_Query( array(
                'posts_per_page'      => 3,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true,
            ) );

            if ( $recent_posts->have_posts() ) :
                while ( $recent_posts->have_posts() ) :
                    $recent_posts->the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'card-post' ); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="card-thumbnail">
                                <a href="<?php echo esc_url( get_permalink() ); ?>">
                                    <?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h3 class="card-title">
                                <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                            </h3>
                            <p class="card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '…' ) ); ?></p>
                            <a class="btn-read-more" href="<?php echo esc_url( get_permalink() ); ?>">Leia mais</a>
                        </div>
                    </article>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <p>Nenhuma publicação encontrada.</p>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
