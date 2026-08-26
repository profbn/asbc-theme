<?php
/*
Template Name: Jogo da Cobrinha
*/
get_header(); 
?>

<main class="site-main game-container">
    <h1>Jogo da Cobrinha</h1>
    <p>Use as setas do teclado (PC) ou os botões (Celular) para jogar</p>
    
    <!-- Menu de Controles -->
    <div id="gameMenu" class="game-controls">
        <label for="difficulty">Velocidade:</label>
        <select id="difficulty">
            <option value="30">Fácil (Bem Lento)</option>
            <option value="15" selected>Médio (Normal)</option>
            <option value="8">Difícil (Rápido)</option>
        </select>
        
        <button id="startBtn" class="btn-start">Iniciar</button>
        <button id="stopBtn" class="btn-stop" disabled>Finalizar</button>
    </div>
    
    <canvas id="snakeGame" width="400" height="400"></canvas>
    
    <p id="score" class="score-board">Pontuação: 0</p>

    <!-- Botões Direcionais (Celular) -->
    <div class="mobile-controls">
        <button class="d-pad-btn up" id="btnUp">▲</button>
        <div class="d-pad-row">
            <button class="d-pad-btn left" id="btnLeft">◄</button>
            <button class="d-pad-btn down" id="btnDown">▼</button>
            <button class="d-pad-btn right" id="btnRight">►</button>
        </div>
    </div>
</main>

<?php get_footer(); ?>