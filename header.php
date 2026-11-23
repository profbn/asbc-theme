<?php
/**
 * Cabeçalho do tema ASBC.
 * current_time() respeita o fuso configurado em Configurações > Geral.
 */
$asbc_hour = (int) current_time( 'G' );
$asbc_day  = $asbc_hour >= 6 && $asbc_hour < 18;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class( $asbc_day ? 'light-mode' : '' ); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#conteudo-principal"><?php esc_html_e( 'Pular para o conteúdo', 'asbc-theme' ); ?></a>

<header class="site-header">
    <div class="container-header">
        <div class="logo-area">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo-link" rel="home">
                    <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sfsf.png' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                </a>
            <?php endif; ?>
        </div>

        <div class="header-actions">
            <button id="asbc-menu-toggle" class="menu-toggle-btn" type="button"
                aria-controls="asbc-primary-navigation" aria-expanded="false">
                ☰ Menu
            </button>
            <nav id="asbc-primary-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Navegação principal', 'asbc-theme' ); ?>">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary-menu',
                    'fallback_cb'    => 'wp_page_menu',
                    'container'      => false,
                ) );
                ?>
            </nav>

            <button id="themeToggle" class="theme-toggle-btn" type="button"
                aria-label="<?php esc_attr_e( 'Alternar tema claro ou escuro', 'asbc-theme' ); ?>"
                aria-pressed="<?php echo $asbc_day ? 'true' : 'false'; ?>">
                <?php echo $asbc_day ? '🌙 Noite' : '☀️ Dia'; ?>
            </button>
        </div>
    </div>
</header>
