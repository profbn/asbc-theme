# ASBC Theme — Tema WordPress

Tema clássico do WordPress para o site TV ASBC, com transmissão ao vivo, publicações e jogo da cobrinha.

## Requisitos

- WordPress atualizado e PHP 8.0 ou superior (recomendado).
- Conexão com a internet para carregar a biblioteca HLS.js via CDN.
- Servidor HLS com playlist M3U8 ativa e permissões CORS adequadas para o domínio do site.

## Instalação

1. **Faça backup** do diretório do tema em produção e do banco de dados.
2. Baixe o código do tema e coloque a pasta `asbc-theme` em `wp-content/themes/`.
3. Em **Aparência > Temas**, ative **ASBC Theme**.
4. Em **Aparência > Menus**, configure **Menu Principal** e, se quiser, **Menu Rodapé**.
5. Em **Aparência > Personalizar > Identidade do site**, selecione a logo da emissora.
6. Em **Configurações > Geral**, configure o fuso horário do site.
7. Valide a página inicial, os posts, categorias, busca, menu móvel e transmissão principal/reserva.

## Transmissão ao vivo

A página inicial usa `front-page.php` e `assets/js/live-player.js`. O player mantém os dois endereços HLS já existentes no tema, alternando para o reserva em caso de erro fatal. Há um botão **Tentar novamente**.

Para alterar os endereços sem editar o tema, um plugin personalizado pode utilizar o filtro `asbc_stream_sources`:

```php
add_filter( 'asbc_stream_sources', function ( $streams ) {
    $streams['primary'] = 'https://exemplo.com/live.m3u8';
    $streams['backup']  = 'https://exemplo.com/backup.m3u8';
    return $streams;
} );
```

O filtro deve receber endereços HTTPS válidos. **Os arquivos M3U8 e a política CORS pertencem ao servidor de streaming**; o tema não pode corrigir erros de origem ou indisponibilidade desse servidor.

## Recursos

- Tema claro e escuro, com escolha guardada no navegador.
- Menu responsivo com navegação por teclado e botões de submenu.
- Identidade visual editável por logo personalizada, preservando o logo de fallback.
- Cartões de notícias, arquivos e pesquisa responsivos.
- Jogo da cobrinha como modelo de página.

## Verificação após atualização

- Teste com um navegador no computador e outro no celular.
- Verifique o modo claro/escuro e a persistência após atualizar a página.
- Confirme o funcionamento de menus e submenus por clique e tecla Tab.
- Simule falha do HLS principal para verificar a troca para o reserva.
- Confira em **Ferramentas > Saúde do site** se há novos avisos.
- Mantenha um tema padrão instalado para permitir recuperação em caso de erro.

## Código

CSS em `assets/css/main.css`; JavaScript em `assets/js/`. Os assets são carregados por `wp_enqueue_scripts` em `functions.php`, seguindo as práticas do WordPress.

Referências: [Documentação de temas WordPress](https://developer.wordpress.org/themes/) e [hls.js](https://github.com/video-dev/hls.js).
