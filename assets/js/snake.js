document.addEventListener('DOMContentLoaded', () => {
  const canvas = document.getElementById("snakeGame");
  if (!canvas) return;

  const ctx = canvas.getContext("2d");
  const grid = 20;
  let count = 0;
  let score = 0;
  
  // Variáveis para controlar o menu e o jogo
  let animationId = null; 
  let isPlaying = false;
  let speedLimit = 15; // Velocidade padrão

  let snake = { x: 160, y: 160, dx: grid, dy: 0, cells: [], maxCells: 4 };
  let apple = { x: 320, y: 320 };

  // Pegando os elementos do HTML (Menu e Botões do Celular)
  const startBtn = document.getElementById('startBtn');
  const stopBtn = document.getElementById('stopBtn');
  const difficultySelect = document.getElementById('difficulty');
  const scoreDisplay = document.getElementById('score');

  const btnUp = document.getElementById('btnUp');
  const btnDown = document.getElementById('btnDown');
  const btnLeft = document.getElementById('btnLeft');
  const btnRight = document.getElementById('btnRight');

  function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
  }

  function resetGame() {
    snake.x = 160;
    snake.y = 160;
    snake.cells = [];
    snake.maxCells = 4;
    snake.dx = grid;
    snake.dy = 0;
    score = 0;
    if (scoreDisplay) scoreDisplay.innerText = 'Pontuação: ' + score;
    apple.x = getRandomInt(0, 20) * grid;
    apple.y = getRandomInt(0, 20) * grid;
  }

  function loop() {
    if (!isPlaying) return; // Se o jogo estiver parado, cancela a animação

    animationId = requestAnimationFrame(loop);

    // Usa a velocidade escolhida pelo jogador
    if (++count < speedLimit) return;
    count = 0;

    ctx.clearRect(0, 0, canvas.width, canvas.height);

    snake.x += snake.dx;
    snake.y += snake.dy;

    // Atravessa as paredes
    if (snake.x < 0) snake.x = canvas.width - grid;
    else if (snake.x >= canvas.width) snake.x = 0;
    if (snake.y < 0) snake.y = canvas.height - grid;
    else if (snake.y >= canvas.height) snake.y = 0;

    snake.cells.unshift({x: snake.x, y: snake.y});

    if (snake.cells.length > snake.maxCells) {
      snake.cells.pop();
    }

    // Maçã
    ctx.fillStyle = '#ff4d4d';
    ctx.fillRect(apple.x, apple.y, grid - 1, grid - 1);

    // Cobra
    ctx.fillStyle = '#4caf50';
    snake.cells.forEach((cell, index) => {
      ctx.fillRect(cell.x, cell.y, grid - 1, grid - 1);  

      // Comeu a maçã
      if (cell.x === apple.x && cell.y === apple.y) {
        snake.maxCells++;
        score += 10;
        if (scoreDisplay) scoreDisplay.innerText = 'Pontuação: ' + score;
        apple.x = getRandomInt(0, 20) * grid;
        apple.y = getRandomInt(0, 20) * grid;
      }

      // Bateu no próprio corpo (Game Over)
      for (let i = index + 1; i < snake.cells.length; i++) {
        if (cell.x === snake.cells[i].x && cell.y === snake.cells[i].y) {
          stopGame();
          alert("Fim de Jogo! Sua pontuação foi: " + score);
          resetGame();
        }
      }
    });
  }

  // Função para Iniciar o Jogo (Menu)
  function startGame() {
    if (isPlaying) return;
    isPlaying = true;
    
    if (difficultySelect) speedLimit = parseInt(difficultySelect.value);
    
    if (startBtn) {
      startBtn.disabled = true;
      startBtn.style.opacity = "0.5";
    }
    if (stopBtn) {
      stopBtn.disabled = false;
      stopBtn.style.opacity = "1";
    }
    if (difficultySelect) difficultySelect.disabled = true;
    
    resetGame();
    animationId = requestAnimationFrame(loop);
  }

  // Função para Parar o Jogo (Menu)
  function stopGame() {
    isPlaying = false;
    cancelAnimationFrame(animationId);
    
    if (startBtn) {
      startBtn.disabled = false;
      startBtn.style.opacity = "1";
      startBtn.innerText = "Jogar Novamente";
    }
    if (stopBtn) {
      stopBtn.disabled = true;
      stopBtn.style.opacity = "0.5";
    }
    if (difficultySelect) difficultySelect.disabled = false;
  }

  if (startBtn) startBtn.addEventListener('click', startGame);
  if (stopBtn) stopBtn.addEventListener('click', stopGame);

  // Controles do teclado (PC)
  document.addEventListener('keydown', (e) => {
    if (!isPlaying) return;

    if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'].includes(e.key)) {
      e.preventDefault();
    }

    if (e.key === 'ArrowLeft' && snake.dx === 0) { snake.dx = -grid; snake.dy = 0; }
    else if (e.key === 'ArrowUp' && snake.dy === 0) { snake.dy = -grid; snake.dx = 0; }
    else if (e.key === 'ArrowRight' && snake.dx === 0) { snake.dx = grid; snake.dy = 0; }
    else if (e.key === 'ArrowDown' && snake.dy === 0) { snake.dy = grid; snake.dx = 0; }
  });

  // ---- CONTROLES PARA CELULAR ----
  function changeDirection(direction) {
    if (!isPlaying) return; 

    if (direction === 'Left' && snake.dx === 0) { snake.dx = -grid; snake.dy = 0; }
    else if (direction === 'Up' && snake.dy === 0) { snake.dy = -grid; snake.dx = 0; }
    else if (direction === 'Right' && snake.dx === 0) { snake.dx = grid; snake.dy = 0; }
    else if (direction === 'Down' && snake.dy === 0) { snake.dy = grid; snake.dx = 0; }
  }

  if (btnUp) {
    btnUp.addEventListener('touchstart', (e) => { e.preventDefault(); changeDirection('Up'); });
    btnUp.addEventListener('mousedown', (e) => { e.preventDefault(); changeDirection('Up'); });
  }
  if (btnDown) {
    btnDown.addEventListener('touchstart', (e) => { e.preventDefault(); changeDirection('Down'); });
    btnDown.addEventListener('mousedown', (e) => { e.preventDefault(); changeDirection('Down'); });
  }
  if (btnLeft) {
    btnLeft.addEventListener('touchstart', (e) => { e.preventDefault(); changeDirection('Left'); });
    btnLeft.addEventListener('mousedown', (e) => { e.preventDefault(); changeDirection('Left'); });
  }
  if (btnRight) {
    btnRight.addEventListener('touchstart', (e) => { e.preventDefault(); changeDirection('Right'); });
    btnRight.addEventListener('mousedown', (e) => { e.preventDefault(); changeDirection('Right'); });
  }

  // Desenha a tela inicial parada para não ficar o quadro preto vazio
  ctx.fillStyle = '#4caf50';
  ctx.fillRect(snake.x, snake.y, grid - 1, grid - 1);
});