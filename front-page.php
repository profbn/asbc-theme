<?php get_header(); ?>

<main class="container" style="max-width: 1200px; margin: 30px auto; padding: 0 15px;">
    <!-- Seção do Player de Transmissão Ao Vivo (HLS / M3U8) -->
    <section class="live-stream-section" style="margin-bottom: 40px;">
        <h2 style="margin-bottom: 15px;">Transmissão Ao Vivo - TV ASBC</h2>
        
        <!-- Container Responsivo para o Player -->
        <div class="video-responsive" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; background: #000; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            
            <!-- Player de Vídeo Nativo HTML5 -->
            <video id="asbc-player" controls autoplay muted playsinline style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; outline: none;"></video>
            
            <!-- Script Mágico (HLS.js) com Sistema de Backup Instantâneo -->
            <script src="https://cdn.jsdelivr.net/npm/hls.js@1"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var video = document.getElementById('asbc-player');
                    
                    var linkPrincipal = 'https://asbc.bntv.com.br/8d385a50-c5f0-4ddd-8f33-e35e1febbece.m3u8';
                    var linkBackup    = 'https://asbc.bntv.com.br/memfs/5986a150-9125-4035-9266-77e8fa3ef60b.m3u8';
                    
                    var usandoBackup = false;
                    var hls = null;

                    function carregarStream(url) {
                        // Se já existir um player travado, destrói para liberar memória
                        if (hls) {
                            hls.destroy();
                        }

                        if (Hls.isSupported()) {
                            hls = new Hls({
                                manifestLoadingTimeOut: 5000, // Detecta se o link morreu em 5 segundos
                                manifestLoadingMaxRetry: 2
                            });
                            
                            hls.loadSource(url);
                            hls.attachMedia(video);
                            
                            hls.on(Hls.Events.MANIFEST_PARSED, function() {
                                video.play().catch(function() {
                                    console.log("Autoplay bloqueado pelo navegador.");
                                });
                            });

                            // SISTEMA DE TROCA AUTOMÁTICA SEM RECARREGAR PÁGINA
                            hls.on(Hls.Events.ERROR, function (event, data) {
                                if (data.fatal && !usandoBackup) {
                                    console.warn("Sinal principal caiu. Alternando para o backup automaticamente...");
                                    usandoBackup = true;
                                    carregarStream(linkBackup); // Força a troca instantânea
                                }
                            });

                        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                            // Suporte NATIVO para Safari / iPhone / iPad
                            video.src = url;
                            video.addEventListener('loadedmetadata', function() {
                                video.play();
                            });
                            
                            video.addEventListener('error', function() {
                                if (!usandoBackup) {
                                    console.warn("Erro no Safari. Alternando para o backup...");
                                    usandoBackup = true;
                                    video.src = linkBackup;
                                    video.load();
                                    video.play();
                                }
                            });
                        }
                    }

                    // Inicia o player no link principal
                    carregarStream(linkPrincipal);
                });
            </script>
        </div>
    </section>

    <!-- Seção dos Últimos Destaques / Programação -->
    <section class="latest-news">
        <h3 style="border-bottom: 2px solid var(--border-red, #e50914); padding-bottom: 8px; display: inline-block;">Últimas Novidades</h3>
        <div class="posts-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-top: 20px;">
            <?php
            $recent_posts = new WP_Query( array(
                'posts_per_page' => 3,
                'post_status'    => 'publish'
            ) );

            if ( $recent_posts->have_posts() ) :
                while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
                    
                    <!-- Artigo configurado para obedecer ao botão de Dia/Noite -->
                    <article style="border: 1px solid var(--card-border, #ddd); padding: 15px; border-radius: 8px; background-color: var(--card-bg, #fff); transition: background-color 0.3s, border-color 0.3s; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div style="margin-bottom: 10px;">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium', array('style' => 'width:100%; height:auto; border-radius: 4px;')); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <h4 style="margin: 10px 0;">
                            <a href="<?php the_permalink(); ?>" style="color: var(--text-main, #333); text-decoration: none;"><?php the_title(); ?></a>
                        </h4>
                        <p style="color: var(--text-muted, #666); font-size: 14px; margin-bottom: 0;">
                            <?php echo wp_trim_words( get_the_excerpt(), 15, '...' ); ?>
                        </p>
                    </article>

                <?php endwhile;
                wp_reset_postdata();
            else : ?>
                <p>Nenhuma publicação encontrada.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>