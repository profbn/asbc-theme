<?php
// Define o fuso horário para o do Brasil/Servidor
date_default_timezone_set('America_Sao_Paulo');

// Pega a hora atual do SERVIDOR (de 0 a 23)
$hora_servidor = (int) date('H');

// Se for entre 06:00 e 17:59, considera DIA. Caso contrário, NOITE.
$eh_dia_no_servidor = ($hora_servidor >= 6 && $hora_servidor < 18);
$classe_tema_servidor = $eh_dia_no_servidor ? 'light-mode' : '';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class( $classe_tema_servidor ); ?>>

<header class="site-header">
    <div class="container-header">
        
        <div class="logo-area">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/sfsf.png" alt="<?php bloginfo( 'name' ); ?>">
            </a>
        </div>
        
        <div class="header-actions">
            <nav class="main-navigation">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary-menu',
                    'fallback_cb'    => 'wp_page_menu', // Mostra as páginas existentes caso o menu personalizado não esteja criado
                ) );
                ?>
            </nav>
            
            <button id="themeToggle" class="theme-toggle-btn">
                <?php echo $eh_dia_no_servidor ? '🌙 Noite' : '☀️ Dia'; ?>
            </button>
        </div>
        
    </div>
</header>