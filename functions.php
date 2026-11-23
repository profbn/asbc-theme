<?php
/**
 * Configurações Principais e Funções do Tema ASBC
 * 
 * @package asbc-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Impede acesso direto ao arquivo por segurança
}

/**
 * 1. Suporte a Recursos do Tema e Registros
 */
if ( ! function_exists( 'asbc_theme_setup' ) ) :
    function asbc_theme_setup() {
        // Título dinâmico na aba do navegador
        add_theme_support( 'title-tag' );

        // Suporte a Imagens Destacadas (Thumbnails)
        add_theme_support( 'post-thumbnails' );

        // Suporte a Logo Customizado via Painel
        add_theme_support( 'custom-logo', array(
            'height'      => 100,
            'width'       => 300,
            'flex-height' => true,
            'flex-width'  => true,
        ) );

        // Tags HTML5 válidas para formulários e buscas
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ) );

        // Registra os locais de menus
        register_nav_menus( array(
            'primary-menu' => __( 'Menu Principal', 'asbc-theme' ),
            'footer-menu'  => __( 'Menu Rodapé', 'asbc-theme' ),
        ) );
    }
endif;
add_action( 'after_setup_theme', 'asbc_theme_setup' );


/**
 * 2. Carregamento de Arquivos CSS e JavaScript (Enqueue)
 */
function asbc_enqueue_scripts() {
    $version = wp_get_theme()->get( 'Version' );
    $main_css = get_theme_file_path( 'assets/css/main.css' );
    $toggle_js = get_theme_file_path( 'assets/js/theme-toggle.js' );

    // O WordPress controla as dependências e evita duplicação do CSS.
    wp_enqueue_style( 'asbc-style', get_stylesheet_uri(), array(), $version );
    wp_enqueue_style(
        'asbc-main-style',
        get_theme_file_uri( 'assets/css/main.css' ),
        array( 'asbc-style' ),
        file_exists( $main_css ) ? (string) filemtime( $main_css ) : $version
    );

    wp_enqueue_script(
        'asbc-theme-toggle',
        get_theme_file_uri( 'assets/js/theme-toggle.js' ),
        array(),
        file_exists( $toggle_js ) ? (string) filemtime( $toggle_js ) : $version,
        true
    );

    if ( is_front_page() ) {
        // Dependência externa do player HLS; o JavaScript local oferece
        // mensagem amigável caso a biblioteca não fique disponível.
        wp_enqueue_script(
            'asbc-hls',
            'https://cdn.jsdelivr.net/npm/hls.js@1/dist/hls.min.js',
            array(),
            null,
            true
        );
        $player_js = get_theme_file_path( 'assets/js/live-player.js' );
        wp_enqueue_script(
            'asbc-live-player',
            get_theme_file_uri( 'assets/js/live-player.js' ),
            array( 'asbc-hls' ),
            file_exists( $player_js ) ? (string) filemtime( $player_js ) : $version,
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'asbc_enqueue_scripts' );


/**
 * 3. Registra as Áreas de Widgets (Sidebar)
 */
function asbc_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Barra Lateral Principal', 'asbc-theme' ),
        'id'            => 'main-sidebar',
        'description'   => __( 'Widgets adicionados aqui aparecerão ao lado das notícias/posts.', 'asbc-theme' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'asbc_widgets_init' );


/**
 * 4. Segurança e Limpeza do Cabeçalho WordPress
 */

// Desativa o XML-RPC para conter tentativas de força bruta
add_filter( 'xmlrpc_enabled', '__return_false' );

// Oculta a versão do WordPress
function asbc_remove_version() {
    return '';
}
add_filter( 'the_generator', 'asbc_remove_version' );

// Limpa metatags desnecessárias da tag <head>
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );



// Jogo snake
function asbc_enqueue_game_assets() {
    if (is_page_template('page-cobrinha.php')) {
        wp_enqueue_style(
            'snake-style', 
            get_template_directory_uri() . '/assets/css/snake.css', 
            array(), 
            '1.0.0'
        );
        
        wp_enqueue_script(
            'snake-script', 
            get_template_directory_uri() . '/assets/js/snake.js', 
            array(), 
            '1.0.0', 
            true // Carrega no footer
        );
    }
}
add_action('wp_enqueue_scripts', 'asbc_enqueue_game_assets');