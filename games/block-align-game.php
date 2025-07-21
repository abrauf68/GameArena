<!-- <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dark Theme Tetris</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --bg-primary: #0f172a;
      --bg-secondary: #1e293b;
      --bg-tertiary: #334155;
      --accent-primary: #8b5cf6;
      --accent-secondary: #7c3aed;
      --text-primary: #e2e8f0;
      --text-secondary: #94a3b8;
      --success: #10b981;
      --danger: #ef4444;
      --warning: #f59e0b;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(135deg, var(--bg-primary), var(--bg-secondary));
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      color: var(--text-primary);
    }

    .game-container {
      width: 100%;
      max-width: 1200px;
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    @media (min-width: 901px) {
      .game-container {
        display: grid;
        grid-template-columns: 1fr 300px;
      }
    }

    .game-area {
      background: var(--bg-secondary);
      border-radius: 16px;
      padding: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.05);
      display: flex;
      flex-direction: column;
      align-items: center;
      position: relative;
      overflow: hidden;
      order: 1;
    }

    .game-area::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at center, rgba(139, 92, 246, 0.1), transparent 70%);
      pointer-events: none;
      z-index: 0;
    }

    .canvas-wrapper {
      position: relative;
      margin-bottom: 20px;
      z-index: 1;
    }

    canvas {
      display: block;
      background-color: rgba(15, 23, 42, 0.7);
      border-radius: 8px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
    }

    #gameCanvas {
      border: 1px solid var(--bg-tertiary);
    }

    #nextPieceCanvas {
      border: 1px solid var(--bg-tertiary);
      background-color: rgba(15, 23, 42, 0.7);
      border-radius: 8px;
      margin-top: 10px;
    }

    .controls {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 12px;
      width: 100%;
      max-width: 500px;
      margin-top: 20px;
    }

    .control-button {
      background: linear-gradient(145deg, var(--bg-tertiary), var(--bg-secondary));
      color: var(--text-primary);
      padding: 12px 20px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.2s ease;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      flex: 1;
      min-width: 120px;
      justify-content: center;
    }

    .control-button:hover {
      background: linear-gradient(145deg, var(--accent-primary), var(--accent-secondary));
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(139, 92, 246, 0.3);
    }

    .control-button:active {
      transform: translateY(1px);
    }

    .control-button i {
      font-size: 1.2rem;
    }

    .sidebar {
      background: var(--bg-secondary);
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.05);
      display: flex;
      flex-direction: column;
      gap: 20px;
      order: 2;
    }

    .stats-card {
      background: var(--bg-tertiary);
      border-radius: 12px;
      padding: 20px;
    }

    .card-header {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 16px;
    }

    .card-header i {
      color: var(--accent-primary);
      font-size: 1.5rem;
    }

    .card-title {
      font-size: 1.25rem;
      font-weight: 600;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
    }

    .stat {
      background: rgba(15, 23, 42, 0.5);
      border-radius: 8px;
      padding: 12px;
    }

    .stat-label {
      font-size: 0.85rem;
      color: var(--text-secondary);
      margin-bottom: 5px;
    }

    .stat-value {
      font-size: 1.5rem;
      font-weight: 700;
    }

    .next-piece-container {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .next-piece-title {
      font-size: 1.1rem;
      margin-bottom: 10px;
      color: var(--text-secondary);
      font-weight: 600;
    }

    .game-title {
      font-size: 2.5rem;
      font-weight: 800;
      margin-bottom: 5px;
      background: linear-gradient(90deg, var(--accent-primary), #ec4899);
      -webkit-background-clip: text;
      background-clip: text;
      -webkit-text-fill-color: transparent;
      text-align: center;
    }

    .game-subtitle {
      color: var(--text-secondary);
      text-align: center;
      margin-bottom: 25px;
      font-size: 1rem;
    }

    .game-over {
      display: none;
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(15, 23, 42, 0.95);
      z-index: 20;
      border-radius: 16px;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 30px;
      text-align: center;
    }

    .game-over.show {
      display: flex;
    }

    .game-over h2 {
      font-size: 3rem;
      margin-bottom: 20px;
      color: var(--accent-primary);
    }

    .game-over p {
      font-size: 1.5rem;
      margin-bottom: 30px;
    }

    .difficulty-controls {
      display: flex;
      gap: 15px;
      margin-top: 15px;
      width: 100%;
      justify-content: center;
    }

    .difficulty-btn {
      padding: 8px 16px;
      border-radius: 8px;
      border: none;
      background: var(--bg-tertiary);
      color: var(--text-primary);
      cursor: pointer;
      transition: all 0.2s;
      font-weight: 500;
    }

    .difficulty-btn.active {
      background: var(--accent-primary);
    }

    .difficulty-btn:hover {
      background: var(--accent-secondary);
    }

    .mobile-controls {
      display: none;
      grid-template-columns: repeat(3, 1fr);
      grid-template-rows: repeat(2, 1fr);
      gap: 10px;
      margin-top: 20px;
      width: 100%;
      max-width: 300px;
    }

    .mobile-btn {
      background: var(--bg-tertiary);
      color: var(--text-primary);
      border: none;
      border-radius: 10px;
      height: 60px;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 1.5rem;
      cursor: pointer;
      transition: all 0.2s;
    }

    .mobile-btn:active {
      background: var(--accent-primary);
    }

    .rotate-btn {
      grid-column: 2;
      grid-row: 1;
    }

    .left-btn {
      grid-column: 1;
      grid-row: 2;
    }

    .down-btn {
      grid-column: 2;
      grid-row: 2;
    }

    .right-btn {
      grid-column: 3;
      grid-row: 2;
    }

    .drop-btn {
      grid-column: 1 / span 3;
      grid-row: 1;
      background: var(--accent-primary);
      font-size: 1rem;
      font-weight: 600;
    }

    @media (max-width: 768px) {
      .controls {
        display: none;
      }

      .mobile-controls {
        display: grid;
      }

      .game-container {
        gap: 15px;
      }

      .sidebar {
        padding: 20px;
      }

      .stat-value {
        font-size: 1.2rem;
      }
    }

    @media (max-width: 480px) {
      .game-title {
        font-size: 2rem;
      }

      .stats-grid {
        grid-template-columns: 1fr;
      }

      .difficulty-controls {
        flex-wrap: wrap;
      }
    }

    .pulse {
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% {
        box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.7);
      }

      70% {
        box-shadow: 0 0 0 10px rgba(139, 92, 246, 0);
      }

      100% {
        box-shadow: 0 0 0 0 rgba(139, 92, 246, 0);
      }
    }

    .glow {
      text-shadow: 0 0 10px rgba(139, 92, 246, 0.7);
    }
  </style>
</head>

<body>
  <div class="game-container">
    <div class="game-area">
      <h1 class="game-title">DARK TETRIS</h1>
      <p class="game-subtitle">Classic puzzle game with a modern dark theme</p>

      <div class="canvas-wrapper">
        <canvas id="gameCanvas" width="300" height="600"></canvas>
      </div>

      <div class="controls">
        <button class="control-button pulse" onclick="rotatePiece()">
          <i class="fas fa-sync-alt"></i> Rotate
        </button>
        <button class="control-button" onclick="moveLeft()">
          <i class="fas fa-arrow-left"></i> Left
        </button>
        <button class="control-button" onclick="moveRight()">
          <i class="fas fa-arrow-right"></i> Right
        </button>
        <button class="control-button" onclick="fastDrop()">
          <i class="fas fa-arrow-down"></i> Fast Drop
        </button>
        <button class="control-button" id="pauseBtn" onclick="togglePause()">
          <i class="fas fa-pause"></i> Pause
        </button>
      </div>

      <div class="mobile-controls">
        <button class="mobile-btn drop-btn" onclick="fastDrop()">FAST DROP</button>
        <button class="mobile-btn rotate-btn" onclick="rotatePiece()"><i class="fas fa-sync-alt"></i></button>
        <button class="mobile-btn left-btn" onclick="moveLeft()"><i class="fas fa-arrow-left"></i></button>
        <button class="mobile-btn down-btn" onclick="moveDown()"><i class="fas fa-arrow-down"></i></button>
        <button class="mobile-btn right-btn" onclick="moveRight()"><i class="fas fa-arrow-right"></i></button>
      </div>

      <div class="difficulty-controls">
        <button class="difficulty-btn active" onclick="setDifficulty('easy')">Easy</button>
        <button class="difficulty-btn" onclick="setDifficulty('medium')">Medium</button>
        <button class="difficulty-btn" onclick="setDifficulty('hard')">Hard</button>
        <button class="difficulty-btn" onclick="setDifficulty('expert')">Expert</button>
      </div>

      <div class="game-over" id="gameOver">
        <h2 class="glow">GAME OVER</h2>
        <p>Score: <span id="finalScore">0</span></p>
        <p>Lines: <span id="finalLines">0</span></p>
        <button class="control-button" onclick="resetGame()">
          <i class="fas fa-redo"></i> Play Again
        </button>
      </div>
    </div>

    <div class="sidebar">
      <div class="stats-card">
        <div class="card-header">
          <i class="fas fa-chart-line"></i>
          <h3 class="card-title">Game Stats</h3>
        </div>
        <div class="stats-grid">
          <div class="stat">
            <div class="stat-label">SCORE</div>
            <div class="stat-value" id="score">0</div>
          </div>
          <div class="stat">
            <div class="stat-label">LEVEL</div>
            <div class="stat-value" id="level">1</div>
          </div>
          <div class="stat">
            <div class="stat-label">LINES</div>
            <div class="stat-value" id="lines">0</div>
          </div>
          <div class="stat">
            <div class="stat-label">SPEED</div>
            <div class="stat-value" id="speed">Medium</div>
          </div>
        </div>
      </div>

      <div class="stats-card">
        <div class="card-header">
          <i class="fas fa-shapes"></i>
          <h3 class="card-title">Next Piece</h3>
        </div>
        <div class="next-piece-container">
          <canvas id="nextPieceCanvas" width="100" height="100"></canvas>
        </div>
      </div>

      <div class="stats-card">
        <div class="card-header">
          <i class="fas fa-gamepad"></i>
          <h3 class="card-title">Controls</h3>
        </div>
        <div class="controls-info">
          <p><i class="fas fa-arrow-left"></i> <i class="fas fa-arrow-right"></i> Move piece</p>
          <p><i class="fas fa-arrow-up"></i> Rotate piece</p>
          <p><i class="fas fa-arrow-down"></i> Soft drop</p>
          <p><strong>Space</strong> Hard drop</p>
          <p><strong>P</strong> Pause game</p>
        </div>
      </div>
    </div>
  </div>

  <script>
    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');
    const nextPieceCanvas = document.getElementById('nextPieceCanvas');
    const nextPieceCtx = nextPieceCanvas.getContext('2d');
    const scoreElement = document.getElementById('score');
    const levelElement = document.getElementById('level');
    const linesElement = document.getElementById('lines');
    const speedElement = document.getElementById('speed');
    const gameOverElement = document.getElementById('gameOver');
    const finalScoreElement = document.getElementById('finalScore');
    const finalLinesElement = document.getElementById('finalLines');
    const pauseBtn = document.getElementById('pauseBtn');

    let GRID_SIZE = 30;
    let COLS = Math.floor(canvas.width / GRID_SIZE);
    let ROWS = Math.floor(canvas.height / GRID_SIZE);

    if (window.innerWidth < 768) {
      GRID_SIZE = 25;
      canvas.width = 250;
      canvas.height = 500;
      COLS = Math.floor(canvas.width / GRID_SIZE);
      ROWS = Math.floor(canvas.height / GRID_SIZE);
    }

    const COLORS = [
      '#ff5555', // Red
      '#ffb86c', // Orange
      '#f1fa8c', // Yellow
      '#50fa7b', // Green
      '#8be9fd', // Cyan
      '#bd93f9', // Purple
      '#ff79c6' // Pink
    ];

    const BG_COLORS = [
      'rgba(255, 85, 85, 0.1)',
      'rgba(255, 184, 108, 0.1)',
      'rgba(241, 250, 140, 0.1)',
      'rgba(80, 250, 123, 0.1)',
      'rgba(139, 233, 253, 0.1)',
      'rgba(189, 147, 249, 0.1)',
      'rgba(255, 121, 198, 0.1)'
    ];

    let score = 0;
    let level = 1;
    let lines = 0;
    let gameActive = true;
    let isPaused = false;
    let dropSpeed = 500;
    let gameSpeed = 'medium';

    const SHAPES = [
      [
        [1, 1, 1, 1]
      ], // I
      [
        [1, 1],
        [1, 1]
      ], // O
      [
        [1, 1, 1],
        [0, 1, 0]
      ], // T
      [
        [1, 1, 1],
        [1, 0, 0]
      ], // L
      [
        [1, 1, 1],
        [0, 0, 1]
      ], // J
      [
        [1, 1, 0],
        [0, 1, 1]
      ], // S
      [
        [0, 1, 1],
        [1, 1, 0]
      ] // Z
    ];

    let board = Array(ROWS).fill().map(() => Array(COLS).fill(0));
    let currentPiece = null;
    let nextPiece = null;
    let currentX = 0;
    let currentY = 0;
    let lastUpdate = 0;
    let dropInterval = dropSpeed;
    let animationFrameId = null;

    function createPiece() {
      const shapeIndex = Math.floor(Math.random() * SHAPES.length);
      const shape = SHAPES[shapeIndex];
      const color = COLORS[shapeIndex];
      return {
        shape,
        color,
        x: Math.floor(COLS / 2) - Math.floor(shape[0].length / 2),
        y: 0
      };
    }

    function initGame() {
      currentPiece = createPiece();
      nextPiece = createPiece();
      currentX = currentPiece.x;
      currentY = currentPiece.y;
      drawNextPiece();
    }

    function drawBoard() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      for (let y = 0; y < ROWS; y++) {
        for (let x = 0; x < COLS; x++) {
          if (board[y][x]) {
            const colorIndex = COLORS.indexOf(board[y][x]);
            ctx.fillStyle = BG_COLORS[colorIndex];
            ctx.fillRect(x * GRID_SIZE, y * GRID_SIZE, GRID_SIZE, GRID_SIZE);

            ctx.fillStyle = board[y][x];
            ctx.fillRect(x * GRID_SIZE, y * GRID_SIZE, GRID_SIZE - 1, GRID_SIZE - 1);

            ctx.fillStyle = 'rgba(255, 255, 255, 0.2)';
            ctx.fillRect(x * GRID_SIZE + 2, y * GRID_SIZE + 2, GRID_SIZE - 5, 3);
            ctx.fillRect(x * GRID_SIZE + 2, y * GRID_SIZE + 2, 3, GRID_SIZE - 5);
          } else {
            ctx.fillStyle = 'rgba(255, 255, 255, 0.05)';
            ctx.fillRect(x * GRID_SIZE, y * GRID_SIZE, GRID_SIZE, GRID_SIZE);
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.1)';
            ctx.strokeRect(x * GRID_SIZE, y * GRID_SIZE, GRID_SIZE, GRID_SIZE);
          }
        }
      }
    }

    function drawPiece(piece, x, y) {
      for (let py = 0; py < piece.shape.length; py++) {
        for (let px = 0; px < piece.shape[py].length; px++) {
          if (piece.shape[py][px]) {
            ctx.fillStyle = 'rgba(0, 0, 0, 0.3)';
            ctx.fillRect((x + px) * GRID_SIZE + 3, (y + py) * GRID_SIZE + 3, GRID_SIZE - 1, GRID_SIZE - 1);

            ctx.fillStyle = piece.color;
            ctx.fillRect((x + px) * GRID_SIZE, (y + py) * GRID_SIZE, GRID_SIZE - 1, GRID_SIZE - 1);

            ctx.fillStyle = 'rgba(255, 255, 255, 0.3)';
            ctx.fillRect((x + px) * GRID_SIZE + 2, (y + py) * GRID_SIZE + 2, GRID_SIZE - 5, 2);
            ctx.fillRect((x + px) * GRID_SIZE + 2, (y + py) * GRID_SIZE + 2, 2, GRID_SIZE - 5);
          }
        }
      }
    }

    function drawNextPiece() {
      nextPieceCtx.clearRect(0, 0, nextPieceCanvas.width, nextPieceCanvas.height);

      nextPieceCtx.fillStyle = 'rgba(15, 23, 42, 0.7)';
      nextPieceCtx.fillRect(0, 0, nextPieceCanvas.width, nextPieceCanvas.height);

      const pieceSize = 20;
      const offsetX = (nextPieceCanvas.width - nextPiece.shape[0].length * pieceSize) / 2;
      const offsetY = (nextPieceCanvas.height - nextPiece.shape.length * pieceSize) / 2;

      for (let py = 0; py < nextPiece.shape.length; py++) {
        for (let px = 0; px < nextPiece.shape[py].length; px++) {
          if (nextPiece.shape[py][px]) {
            nextPieceCtx.fillStyle = 'rgba(0, 0, 0, 0.3)';
            nextPieceCtx.fillRect(offsetX + px * pieceSize + 3, offsetY + py * pieceSize + 3, pieceSize - 1, pieceSize - 1);

            nextPieceCtx.fillStyle = nextPiece.color;
            nextPieceCtx.fillRect(offsetX + px * pieceSize, offsetY + py * pieceSize, pieceSize - 1, pieceSize - 1);

            nextPieceCtx.fillStyle = 'rgba(255, 255, 255, 0.3)';
            nextPieceCtx.fillRect(offsetX + px * pieceSize + 2, offsetY + py * pieceSize + 2, pieceSize - 5, 2);
            nextPieceCtx.fillRect(offsetX + px * pieceSize + 2, offsetY + py * pieceSize + 2, 2, pieceSize - 5);
          }
        }
      }
    }

    function canMove(piece, x, y) {
      for (let py = 0; py < piece.shape.length; py++) {
        for (let px = 0; px < piece.shape[py].length; px++) {
          if (piece.shape[py][px]) {
            const newX = x + px;
            const newY = y + py;
            if (
              newX < 0 ||
              newX >= COLS ||
              newY >= ROWS ||
              (newY >= 0 && board[newY][newX])
            ) {
              return false;
            }
          }
        }
      }
      return true;
    }

    function mergePiece() {
      for (let py = 0; py < currentPiece.shape.length; py++) {
        for (let px = 0; px < currentPiece.shape[py].length; px++) {
          if (currentPiece.shape[py][px]) {
            board[currentY + py][currentX + px] = currentPiece.color;
          }
        }
      }
    }

    function clearLines() {
      let linesCleared = 0;
      for (let y = ROWS - 1; y >= 0; y--) {
        if (board[y].every(cell => cell !== 0)) {
          for (let x = 0; x < COLS; x++) {
            board[y][x] = '#ffffff';
          }
          drawBoard();
          if (currentPiece) drawPiece(currentPiece, currentX, currentY);

          setTimeout(() => {
            board.splice(y, 1);
            board.unshift(Array(COLS).fill(0));
            linesCleared++;
          }, 100);
        }
      }

      if (linesCleared > 0) {
        const linePoints = [40, 100, 300, 1200];
        score += linePoints[linesCleared - 1] * level;
        lines += linesCleared;

        level = Math.floor(lines / 10) + 1;

        dropInterval = Math.max(100, dropSpeed - (level * 20));

        scoreElement.textContent = score;
        linesElement.textContent = lines;
        levelElement.textContent = level;
      }
    }

    function rotatePiece() {
      if (!currentPiece || isPaused) return;

      const newShape = currentPiece.shape[0].map((_, i) =>
        currentPiece.shape.map(row => row[i]).reverse()
      );

      const tempShape = currentPiece.shape;
      currentPiece.shape = newShape;

      if (!canMove(currentPiece, currentX, currentY)) {
        if (canMove(currentPiece, currentX - 1, currentY)) {
          currentX--;
        } else if (canMove(currentPiece, currentX + 1, currentY)) {
          currentX++;
        } else {
          currentPiece.shape = tempShape;
        }
      }
    }

    function moveLeft() {
      if (!currentPiece || isPaused) return;
      if (canMove(currentPiece, currentX - 1, currentY)) currentX--;
    }

    function moveRight() {
      if (!currentPiece || isPaused) return;
      if (canMove(currentPiece, currentX + 1, currentY)) currentX++;
    }

    function moveDown() {
      if (!currentPiece || isPaused) return;
      if (canMove(currentPiece, currentX, currentY + 1)) currentY++;
    }

    function fastDrop() {
      if (!currentPiece || isPaused) return;
      while (canMove(currentPiece, currentX, currentY + 1)) {
        currentY++;
      }
    }

    function togglePause() {
      isPaused = !isPaused;

      if (isPaused) {
        pauseBtn.innerHTML = '<i class="fas fa-play"></i> Resume';
        pauseBtn.classList.remove('pulse');
      } else {
        pauseBtn.innerHTML = '<i class="fas fa-pause"></i> Pause';
        pauseBtn.classList.add('pulse');
        gameLoop();
      }
    }

    function setDifficulty(difficulty) {
      document.querySelectorAll('.difficulty-btn').forEach(btn => {
        btn.classList.remove('active');
      });
      event.target.classList.add('active');

      gameSpeed = difficulty;
      speedElement.textContent = difficulty.charAt(0).toUpperCase() + difficulty.slice(1);

      switch (difficulty) {
        case 'easy':
          dropSpeed = 700;
          break;
        case 'medium':
          dropSpeed = 500;
          break;
        case 'hard':
          dropSpeed = 300;
          break;
        case 'expert':
          dropSpeed = 150;
          break;
      }

      dropInterval = Math.max(100, dropSpeed - (level * 20));
    }

    function gameLoop(timestamp) {
      if (!gameActive || isPaused) return;

      if (!lastUpdate) lastUpdate = timestamp;

      if (!currentPiece) {
        currentPiece = nextPiece;
        nextPiece = createPiece();
        drawNextPiece();

        currentX = currentPiece.x;
        currentY = currentPiece.y;

        if (!canMove(currentPiece, currentX, currentY)) {
          gameActive = false;
          finalScoreElement.textContent = score;
          finalLinesElement.textContent = lines;
          gameOverElement.classList.add('show');
          return;
        }
      }

      if (timestamp - lastUpdate >= dropInterval) {
        if (canMove(currentPiece, currentX, currentY + 1)) {
          currentY++;
        } else {
          mergePiece();
          clearLines();
          currentPiece = null;
        }
        lastUpdate = timestamp;
      }

      drawBoard();
      if (currentPiece) drawPiece(currentPiece, currentX, currentY);

      animationFrameId = requestAnimationFrame(gameLoop);
    }

    function resetGame() {
      if (animationFrameId) {
        cancelAnimationFrame(animationFrameId);
      }

      board = Array(ROWS).fill().map(() => Array(COLS).fill(0));
      score = 0;
      level = 1;
      lines = 0;
      dropSpeed = 500;
      dropInterval = dropSpeed;
      gameActive = true;
      isPaused = false;
      lastUpdate = 0;

      scoreElement.textContent = score;
      linesElement.textContent = lines;
      levelElement.textContent = level;
      pauseBtn.innerHTML = '<i class="fas fa-pause"></i> Pause';
      pauseBtn.classList.add('pulse');
      gameOverElement.classList.remove('show');

      initGame();
      gameLoop();
    }

    initGame();
    gameLoop();

    document.addEventListener('keydown', (e) => {
      if (!gameActive) return;

      switch (e.key) {
        case 'ArrowLeft':
          moveLeft();
          break;
        case 'ArrowRight':
          moveRight();
          break;
        case 'ArrowDown':
          moveDown();
          break;
        case 'ArrowUp':
          rotatePiece();
          break;
        case ' ':
          fastDrop();
          break;
        case 'p':
        case 'P':
          togglePause();
          break;
      }
    });

    let touchStartX = 0;
    let touchStartY = 0;

    canvas.addEventListener('touchstart', (e) => {
      if (!gameActive || isPaused) return;

      touchStartX = e.touches[0].clientX;
      touchStartY = e.touches[0].clientY;
      e.preventDefault();
    });

    canvas.addEventListener('touchmove', (e) => {
      e.preventDefault();
    });

    canvas.addEventListener('touchend', (e) => {
      if (!gameActive || isPaused) return;

      const touchEndX = e.changedTouches[0].clientX;
      const touchEndY = e.changedTouches[0].clientY;

      const dx = touchEndX - touchStartX;
      const dy = touchEndY - touchStartY;

      const minSwipeDistance = 30;

      if (Math.abs(dx) > Math.abs(dy)) {
        if (dx > minSwipeDistance) {
          moveRight();
        } else if (dx < -minSwipeDistance) {
          moveLeft();
        }
      } else {
        if (dy > minSwipeDistance) {
          fastDrop();
        } else if (dy < -minSwipeDistance) {
          rotatePiece();
        }
      }
    });

    window.addEventListener('resize', () => {
      if (window.innerWidth < 768) {
        GRID_SIZE = 25;
        canvas.width = 250;
        canvas.height = 500;
      } else {
        GRID_SIZE = 30;
        canvas.width = 300;
        canvas.height = 600;
      }

      COLS = Math.floor(canvas.width / GRID_SIZE);
      ROWS = Math.floor(canvas.height / GRID_SIZE);

      board = Array(ROWS).fill().map(() => Array(COLS).fill(0));
      drawBoard();
    });
  </script>
</body>

</html> -->

<!DOCTYPE html>
<html dir="ltr" lang="en">

<?php include '../layout/head.php' ?>

<body>
  <style>
    :root {
      --bg-primary: #0f172a;
      --bg-secondary: #1e293b;
      --bg-tertiary: #334155;
      --accent-primary: #8b5cf6;
      --accent-secondary: #7c3aed;
      --text-primary: #e2e8f0;
      --text-secondary: #94a3b8;
      --success: #10b981;
      --danger: #ef4444;
      --warning: #f59e0b;
    }
    main {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      /* overflow-y: hidden; */
      padding: 0;
      padding-top: 100px;
    }

    .game-container {
      width: 100%;
      max-width: 1200px;
      display: flex;
      flex-direction: column;
      gap: 24px;
    }

    @media (min-width: 901px) {
      .game-container {
        display: grid;
        grid-template-columns: 1fr 300px;
      }
    }

    .game-area {
      background: var(--bg-secondary);
      border-radius: 16px;
      padding: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.05);
      display: flex;
      flex-direction: column;
      align-items: center;
      position: relative;
      overflow: hidden;
      order: 1;
    }

    .game-area::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at center, rgba(139, 92, 246, 0.1), transparent 70%);
      pointer-events: none;
      z-index: 0;
    }

    .canvas-wrapper {
      position: relative;
      margin-bottom: 20px;
      z-index: 1;
    }

    canvas {
      display: block;
      background-color: rgba(15, 23, 42, 0.7);
      border-radius: 8px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
    }

    #gameCanvas {
      border: 1px solid var(--bg-tertiary);
    }

    #nextPieceCanvas {
      border: 1px solid var(--bg-tertiary);
      background-color: rgba(15, 23, 42, 0.7);
      border-radius: 8px;
      margin-top: 10px;
    }

    .controls {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 12px;
      width: 100%;
      max-width: 500px;
      margin-top: 20px;
    }

    .control-button {
      background: linear-gradient(145deg, var(--bg-tertiary), var(--bg-secondary));
      color: var(--text-primary);
      padding: 12px 20px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.2s ease;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      flex: 1;
      min-width: 120px;
      justify-content: center;
    }

    .control-button:hover {
      background: linear-gradient(145deg, var(--accent-primary), var(--accent-secondary));
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(139, 92, 246, 0.3);
    }

    .control-button:active {
      transform: translateY(1px);
    }

    .control-button i {
      font-size: 1.2rem;
    }

    .game-container .sidebar {
      background: var(--bg-secondary);
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.05);
      display: flex;
      flex-direction: column;
      gap: 20px;
      order: 2;
    }

    .stats-card {
      background: var(--bg-tertiary);
      border-radius: 12px;
      padding: 20px;
    }

    .card-header {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 16px;
    }

    .card-header i {
      color: var(--accent-primary);
      font-size: 1.5rem;
    }

    .card-title {
      font-size: 1.25rem;
      font-weight: 600;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
    }

    .stat {
      background: rgba(15, 23, 42, 0.5);
      border-radius: 8px;
      padding: 12px;
    }

    .stat-label {
      font-size: 0.85rem;
      color: var(--text-secondary);
      margin-bottom: 5px;
    }

    .stat-value {
      font-size: 1.5rem;
      font-weight: 700;
    }

    .next-piece-container {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .next-piece-title {
      font-size: 1.1rem;
      margin-bottom: 10px;
      color: var(--text-secondary);
      font-weight: 600;
    }

    .game-title {
      font-size: 2.5rem;
      font-weight: 800;
      margin-bottom: 5px;
      background: linear-gradient(90deg, var(--accent-primary), #ec4899);
      -webkit-background-clip: text;
      background-clip: text;
      -webkit-text-fill-color: transparent;
      text-align: center;
    }

    .game-subtitle {
      color: var(--text-secondary);
      text-align: center;
      margin-bottom: 25px;
      font-size: 1rem;
    }

    .game-over {
      display: none;
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(15, 23, 42, 0.95);
      z-index: 20;
      border-radius: 16px;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 30px;
      text-align: center;
    }

    .game-over.show {
      display: flex;
    }

    .game-over h2 {
      font-size: 3rem;
      margin-bottom: 20px;
      color: var(--accent-primary);
    }

    .game-over p {
      font-size: 1.5rem;
      margin-bottom: 30px;
    }

    .difficulty-controls {
      display: flex;
      gap: 15px;
      margin-top: 15px;
      width: 100%;
      justify-content: center;
    }

    .difficulty-btn {
      padding: 8px 16px;
      border-radius: 8px;
      border: none;
      background: var(--bg-tertiary);
      color: var(--text-primary);
      cursor: pointer;
      transition: all 0.2s;
      font-weight: 500;
    }

    .difficulty-btn.active {
      background: var(--accent-primary);
    }

    .difficulty-btn:hover {
      background: var(--accent-secondary);
    }

    .mobile-controls {
      display: none;
      grid-template-columns: repeat(3, 1fr);
      grid-template-rows: repeat(2, 1fr);
      gap: 10px;
      margin-top: 20px;
      width: 100%;
      max-width: 300px;
    }

    .mobile-btn {
      background: var(--bg-tertiary);
      color: var(--text-primary);
      border: none;
      border-radius: 10px;
      height: 60px;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 1.5rem;
      cursor: pointer;
      transition: all 0.2s;
    }

    .mobile-btn:active {
      background: var(--accent-primary);
    }

    .drop-btn {
      grid-column: 1;
      grid-row: 1;
    }
    .rotate-btn {
      grid-column: 2;
      grid-row: 1;
    }
    .pause-btn {
      grid-column: 3;
      grid-row: 1;
    }

    .left-btn {
      grid-column: 1;
      grid-row: 2;
    }

    .down-btn {
      grid-column: 2;
      grid-row: 2;
    }

    .right-btn {
      grid-column: 3;
      grid-row: 2;
    }

    .drop-btn {
      grid-column: 1;
      grid-row: 1;
      background: var(--accent-primary);
      font-size: 1rem;
      font-weight: 600;
    }

    @media (max-width: 768px) {
      .controls {
        display: none;
      }

      .mobile-controls {
        display: grid;
      }

      .game-container {
        gap: 15px;
      }

      .sidebar {
        padding: 20px;
      }

      .stat-value {
        font-size: 1.2rem;
      }
    }

    @media (max-width: 480px) {
      .game-title {
        font-size: 2rem;
      }

      .stats-grid {
        grid-template-columns: 1fr;
      }

      .difficulty-controls {
        flex-wrap: wrap;
      }
    }

    .pulse {
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% {
        box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.7);
      }

      70% {
        box-shadow: 0 0 0 10px rgba(139, 92, 246, 0);
      }

      100% {
        box-shadow: 0 0 0 0 rgba(139, 92, 246, 0);
      }
    }

    .glow {
      text-shadow: 0 0 10px rgba(139, 92, 246, 0.7);
    }
  </style>

  <!-- preloader start -->
  <?php include '../layout/preloader.php' ?>
  <!-- preloader end -->

  <!-- scroll to top button start -->
  <button class="scroll-to-top show" id="scrollToTop">
    <i class="ti ti-arrow-up"></i>
  </button>
  <!-- scroll to top button end -->

  <!-- header start -->
  <?php include '../layout/header.php' ?>
  <!-- header end -->

  <!-- sidebar start -->
  <?php include '../layout/sidebar.php' ?>
  <!-- sidebar end -->

  <!-- app layout start -->
  <div class="app-layout">
    <!-- main start -->
    <main>
      <div class="game-container">
        <div class="game-area">
          <h1 class="game-title">BUILD THE BLOCK</h1>

          <div class="canvas-wrapper">
            <canvas id="gameCanvas" width="300" height="600"></canvas>
          </div>

          <div class="controls">
            <button class="control-button pulse" onclick="rotatePiece()">
              <i class="fas fa-sync-alt"></i> Rotate
            </button>
            <button class="control-button" onclick="moveLeft()">
              <i class="fas fa-arrow-left"></i> Left
            </button>
            <button class="control-button" onclick="moveRight()">
              <i class="fas fa-arrow-right"></i> Right
            </button>
            <button class="control-button" onclick="fastDrop()">
              <i class="fas fa-arrow-down"></i> Fast Drop
            </button>
            <button class="control-button" id="pauseBtn" onclick="togglePause()">
              <i class="fas fa-pause"></i> Pause
            </button>
          </div>

          <div class="mobile-controls">
            <button class="mobile-btn drop-btn" onclick="fastDrop()">FAST DROP</button>
            <button class="mobile-btn rotate-btn" onclick="rotatePiece()"><i class="fas fa-sync-alt"></i></button>
            <button class="mobile-btn pause-btn" id="pauseBtnMobile" onclick="togglePause()"><i class="fas fa-pause"></i></button>
            <button class="mobile-btn left-btn" onclick="moveLeft()"><i class="fas fa-arrow-left"></i></button>
            <button class="mobile-btn down-btn" onclick="moveDown()"><i class="fas fa-arrow-down"></i></button>
            <button class="mobile-btn right-btn" onclick="moveRight()"><i class="fas fa-arrow-right"></i></button>
          </div>

          <div class="difficulty-controls">
            <button class="difficulty-btn active" onclick="setDifficulty('easy')">Easy</button>
            <button class="difficulty-btn" onclick="setDifficulty('medium')">Medium</button>
            <button class="difficulty-btn" onclick="setDifficulty('hard')">Hard</button>
            <button class="difficulty-btn" onclick="setDifficulty('expert')">Expert</button>
          </div>

          <div class="game-over" id="gameOver">
            <h2 class="glow">GAME OVER</h2>
            <p>Score: <span id="finalScore">0</span></p>
            <p>Lines: <span id="finalLines">0</span></p>
            <button class="control-button" onclick="resetGame()">
              <i class="fas fa-redo"></i> Play Again
            </button>
          </div>
        </div>

        <div class="sidebar">
          <div class="stats-card">
            <div class="card-header">
              <i class="fas fa-chart-line"></i>
              <h3 class="card-title">Game Stats</h3>
            </div>
            <div class="stats-grid">
              <div class="stat">
                <div class="stat-label">SCORE</div>
                <div class="stat-value" id="score">0</div>
              </div>
              <div class="stat">
                <div class="stat-label">LEVEL</div>
                <div class="stat-value" id="level">1</div>
              </div>
              <div class="stat">
                <div class="stat-label">LINES</div>
                <div class="stat-value" id="lines">0</div>
              </div>
              <div class="stat">
                <div class="stat-label">SPEED</div>
                <div class="stat-value" id="speed">Medium</div>
              </div>
            </div>
          </div>

          <div class="stats-card">
            <div class="card-header">
              <i class="fas fa-shapes"></i>
              <h3 class="card-title">Next Piece</h3>
            </div>
            <div class="next-piece-container">
              <canvas id="nextPieceCanvas" width="100" height="100"></canvas>
            </div>
          </div>

          <div class="stats-card">
            <div class="card-header">
              <i class="fas fa-gamepad"></i>
              <h3 class="card-title">Controls</h3>
            </div>
            <div class="controls-info">
              <p><i class="fas fa-arrow-left"></i> <i class="fas fa-arrow-right"></i> Move piece</p>
              <p><i class="fas fa-arrow-up"></i> Rotate piece</p>
              <p><i class="fas fa-arrow-down"></i> Soft drop</p>
              <p><strong>Space</strong> Hard drop</p>
              <p><strong>P</strong> Pause game</p>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- main end -->
  </div>
  <!-- app layout end -->

  <script>
    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');
    const nextPieceCanvas = document.getElementById('nextPieceCanvas');
    const nextPieceCtx = nextPieceCanvas.getContext('2d');
    const scoreElement = document.getElementById('score');
    const levelElement = document.getElementById('level');
    const linesElement = document.getElementById('lines');
    const speedElement = document.getElementById('speed');
    const gameOverElement = document.getElementById('gameOver');
    const finalScoreElement = document.getElementById('finalScore');
    const finalLinesElement = document.getElementById('finalLines');
    const pauseBtn = document.getElementById('pauseBtn');
    const pauseBtnMobile = document.getElementById('pauseBtnMobile');

    let GRID_SIZE = 30;
    let COLS = Math.floor(canvas.width / GRID_SIZE);
    let ROWS = Math.floor(canvas.height / GRID_SIZE);

    if (window.innerWidth < 768) {
      GRID_SIZE = 25;
      canvas.width = 250;
      canvas.height = 500;
      COLS = Math.floor(canvas.width / GRID_SIZE);
      ROWS = Math.floor(canvas.height / GRID_SIZE);
    }

    const COLORS = [
      '#ff5555', // Red
      '#ffb86c', // Orange
      '#f1fa8c', // Yellow
      '#50fa7b', // Green
      '#8be9fd', // Cyan
      '#bd93f9', // Purple
      '#ff79c6' // Pink
    ];

    const BG_COLORS = [
      'rgba(255, 85, 85, 0.1)',
      'rgba(255, 184, 108, 0.1)',
      'rgba(241, 250, 140, 0.1)',
      'rgba(80, 250, 123, 0.1)',
      'rgba(139, 233, 253, 0.1)',
      'rgba(189, 147, 249, 0.1)',
      'rgba(255, 121, 198, 0.1)'
    ];

    let score = 0;
    let level = 1;
    let lines = 0;
    let gameActive = true;
    let isPaused = false;
    let dropSpeed = 500;
    let gameSpeed = 'medium';

    const SHAPES = [
      [
        [1, 1, 1, 1]
      ], // I
      [
        [1, 1],
        [1, 1]
      ], // O
      [
        [1, 1, 1],
        [0, 1, 0]
      ], // T
      [
        [1, 1, 1],
        [1, 0, 0]
      ], // L
      [
        [1, 1, 1],
        [0, 0, 1]
      ], // J
      [
        [1, 1, 0],
        [0, 1, 1]
      ], // S
      [
        [0, 1, 1],
        [1, 1, 0]
      ] // Z
    ];

    let board = Array(ROWS).fill().map(() => Array(COLS).fill(0));
    let currentPiece = null;
    let nextPiece = null;
    let currentX = 0;
    let currentY = 0;
    let lastUpdate = 0;
    let dropInterval = dropSpeed;
    let animationFrameId = null;

    function createPiece() {
      const shapeIndex = Math.floor(Math.random() * SHAPES.length);
      const shape = SHAPES[shapeIndex];
      const color = COLORS[shapeIndex];
      return {
        shape,
        color,
        x: Math.floor(COLS / 2) - Math.floor(shape[0].length / 2),
        y: 0
      };
    }

    function initGame() {
      currentPiece = createPiece();
      nextPiece = createPiece();
      currentX = currentPiece.x;
      currentY = currentPiece.y;
      drawNextPiece();
    }

    function drawBoard() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      for (let y = 0; y < ROWS; y++) {
        for (let x = 0; x < COLS; x++) {
          if (board[y][x]) {
            const colorIndex = COLORS.indexOf(board[y][x]);
            ctx.fillStyle = BG_COLORS[colorIndex];
            ctx.fillRect(x * GRID_SIZE, y * GRID_SIZE, GRID_SIZE, GRID_SIZE);

            ctx.fillStyle = board[y][x];
            ctx.fillRect(x * GRID_SIZE, y * GRID_SIZE, GRID_SIZE - 1, GRID_SIZE - 1);

            ctx.fillStyle = 'rgba(255, 255, 255, 0.2)';
            ctx.fillRect(x * GRID_SIZE + 2, y * GRID_SIZE + 2, GRID_SIZE - 5, 3);
            ctx.fillRect(x * GRID_SIZE + 2, y * GRID_SIZE + 2, 3, GRID_SIZE - 5);
          } else {
            ctx.fillStyle = 'rgba(255, 255, 255, 0.05)';
            ctx.fillRect(x * GRID_SIZE, y * GRID_SIZE, GRID_SIZE, GRID_SIZE);
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.1)';
            ctx.strokeRect(x * GRID_SIZE, y * GRID_SIZE, GRID_SIZE, GRID_SIZE);
          }
        }
      }
    }

    function drawPiece(piece, x, y) {
      for (let py = 0; py < piece.shape.length; py++) {
        for (let px = 0; px < piece.shape[py].length; px++) {
          if (piece.shape[py][px]) {
            ctx.fillStyle = 'rgba(0, 0, 0, 0.3)';
            ctx.fillRect((x + px) * GRID_SIZE + 3, (y + py) * GRID_SIZE + 3, GRID_SIZE - 1, GRID_SIZE - 1);

            ctx.fillStyle = piece.color;
            ctx.fillRect((x + px) * GRID_SIZE, (y + py) * GRID_SIZE, GRID_SIZE - 1, GRID_SIZE - 1);

            ctx.fillStyle = 'rgba(255, 255, 255, 0.3)';
            ctx.fillRect((x + px) * GRID_SIZE + 2, (y + py) * GRID_SIZE + 2, GRID_SIZE - 5, 2);
            ctx.fillRect((x + px) * GRID_SIZE + 2, (y + py) * GRID_SIZE + 2, 2, GRID_SIZE - 5);
          }
        }
      }
    }

    function drawNextPiece() {
      nextPieceCtx.clearRect(0, 0, nextPieceCanvas.width, nextPieceCanvas.height);

      nextPieceCtx.fillStyle = 'rgba(15, 23, 42, 0.7)';
      nextPieceCtx.fillRect(0, 0, nextPieceCanvas.width, nextPieceCanvas.height);

      const pieceSize = 20;
      const offsetX = (nextPieceCanvas.width - nextPiece.shape[0].length * pieceSize) / 2;
      const offsetY = (nextPieceCanvas.height - nextPiece.shape.length * pieceSize) / 2;

      for (let py = 0; py < nextPiece.shape.length; py++) {
        for (let px = 0; px < nextPiece.shape[py].length; px++) {
          if (nextPiece.shape[py][px]) {
            nextPieceCtx.fillStyle = 'rgba(0, 0, 0, 0.3)';
            nextPieceCtx.fillRect(offsetX + px * pieceSize + 3, offsetY + py * pieceSize + 3, pieceSize - 1, pieceSize - 1);

            nextPieceCtx.fillStyle = nextPiece.color;
            nextPieceCtx.fillRect(offsetX + px * pieceSize, offsetY + py * pieceSize, pieceSize - 1, pieceSize - 1);

            nextPieceCtx.fillStyle = 'rgba(255, 255, 255, 0.3)';
            nextPieceCtx.fillRect(offsetX + px * pieceSize + 2, offsetY + py * pieceSize + 2, pieceSize - 5, 2);
            nextPieceCtx.fillRect(offsetX + px * pieceSize + 2, offsetY + py * pieceSize + 2, 2, pieceSize - 5);
          }
        }
      }
    }

    function canMove(piece, x, y) {
      for (let py = 0; py < piece.shape.length; py++) {
        for (let px = 0; px < piece.shape[py].length; px++) {
          if (piece.shape[py][px]) {
            const newX = x + px;
            const newY = y + py;
            if (
              newX < 0 ||
              newX >= COLS ||
              newY >= ROWS ||
              (newY >= 0 && board[newY][newX])
            ) {
              return false;
            }
          }
        }
      }
      return true;
    }

    function mergePiece() {
      for (let py = 0; py < currentPiece.shape.length; py++) {
        for (let px = 0; px < currentPiece.shape[py].length; px++) {
          if (currentPiece.shape[py][px]) {
            board[currentY + py][currentX + px] = currentPiece.color;
          }
        }
      }
    }

    function clearLines() {
      let linesCleared = 0;
      for (let y = ROWS - 1; y >= 0; y--) {
        if (board[y].every(cell => cell !== 0)) {
          for (let x = 0; x < COLS; x++) {
            board[y][x] = '#ffffff';
          }
          drawBoard();
          if (currentPiece) drawPiece(currentPiece, currentX, currentY);

          setTimeout(() => {
            board.splice(y, 1);
            board.unshift(Array(COLS).fill(0));
            linesCleared++;
          }, 100);
        }
      }

      if (linesCleared > 0) {
        const linePoints = [40, 100, 300, 1200];
        score += linePoints[linesCleared - 1] * level;
        lines += linesCleared;

        level = Math.floor(lines / 10) + 1;

        dropInterval = Math.max(100, dropSpeed - (level * 20));

        scoreElement.textContent = score;
        linesElement.textContent = lines;
        levelElement.textContent = level;
      }
    }

    function rotatePiece() {
      if (!currentPiece || isPaused) return;

      const newShape = currentPiece.shape[0].map((_, i) =>
        currentPiece.shape.map(row => row[i]).reverse()
      );

      const tempShape = currentPiece.shape;
      currentPiece.shape = newShape;

      if (!canMove(currentPiece, currentX, currentY)) {
        if (canMove(currentPiece, currentX - 1, currentY)) {
          currentX--;
        } else if (canMove(currentPiece, currentX + 1, currentY)) {
          currentX++;
        } else {
          currentPiece.shape = tempShape;
        }
      }
    }

    function moveLeft() {
      if (!currentPiece || isPaused) return;
      if (canMove(currentPiece, currentX - 1, currentY)) currentX--;
    }

    function moveRight() {
      if (!currentPiece || isPaused) return;
      if (canMove(currentPiece, currentX + 1, currentY)) currentX++;
    }

    function moveDown() {
      if (!currentPiece || isPaused) return;
      if (canMove(currentPiece, currentX, currentY + 1)) currentY++;
    }

    function fastDrop() {
      if (!currentPiece || isPaused) return;
      while (canMove(currentPiece, currentX, currentY + 1)) {
        currentY++;
      }
    }

    function togglePause() {
      isPaused = !isPaused;

      if (isPaused) {
        pauseBtn.innerHTML = '<i class="fas fa-play"></i> Resume';
        pauseBtn.classList.remove('pulse');

        pauseBtnMobile.innerHTML = '<i class="fas fa-play"></i>';
        pauseBtnMobile.classList.remove('pulse');
      } else {
        pauseBtn.innerHTML = '<i class="fas fa-pause"></i> Pause';
        pauseBtn.classList.add('pulse');

        pauseBtnMobile.innerHTML = '<i class="fas fa-pause"></i>';
        pauseBtnMobile.classList.add('pulse');
        gameLoop();
      }
    }

    function setDifficulty(difficulty) {
      document.querySelectorAll('.difficulty-btn').forEach(btn => {
        btn.classList.remove('active');
      });
      event.target.classList.add('active');

      gameSpeed = difficulty;
      speedElement.textContent = difficulty.charAt(0).toUpperCase() + difficulty.slice(1);

      switch (difficulty) {
        case 'easy':
          dropSpeed = 700;
          break;
        case 'medium':
          dropSpeed = 500;
          break;
        case 'hard':
          dropSpeed = 300;
          break;
        case 'expert':
          dropSpeed = 150;
          break;
      }

      dropInterval = Math.max(100, dropSpeed - (level * 20));
    }

    function gameLoop(timestamp) {
      if (!gameActive || isPaused) return;

      if (!lastUpdate) lastUpdate = timestamp;

      if (!currentPiece) {
        currentPiece = nextPiece;
        nextPiece = createPiece();
        drawNextPiece();

        currentX = currentPiece.x;
        currentY = currentPiece.y;

        if (!canMove(currentPiece, currentX, currentY)) {
          gameActive = false;
          finalScoreElement.textContent = score;
          finalLinesElement.textContent = lines;
          gameOverElement.classList.add('show');
          return;
        }
      }

      if (timestamp - lastUpdate >= dropInterval) {
        if (canMove(currentPiece, currentX, currentY + 1)) {
          currentY++;
        } else {
          mergePiece();
          clearLines();
          currentPiece = null;
        }
        lastUpdate = timestamp;
      }

      drawBoard();
      if (currentPiece) drawPiece(currentPiece, currentX, currentY);

      animationFrameId = requestAnimationFrame(gameLoop);
    }

    function resetGame() {
      if (animationFrameId) {
        cancelAnimationFrame(animationFrameId);
      }

      board = Array(ROWS).fill().map(() => Array(COLS).fill(0));
      score = 0;
      level = 1;
      lines = 0;
      dropSpeed = 500;
      dropInterval = dropSpeed;
      gameActive = true;
      isPaused = false;
      lastUpdate = 0;

      scoreElement.textContent = score;
      linesElement.textContent = lines;
      levelElement.textContent = level;
      pauseBtn.innerHTML = '<i class="fas fa-pause"></i> Pause';
      pauseBtn.classList.add('pulse');
      gameOverElement.classList.remove('show');

      initGame();
      gameLoop();
    }

    initGame();
    gameLoop();

    document.addEventListener('keydown', (e) => {
      if (!gameActive) return;

      switch (e.key) {
        case 'ArrowLeft':
          moveLeft();
          break;
        case 'ArrowRight':
          moveRight();
          break;
        case 'ArrowDown':
          moveDown();
          break;
        case 'ArrowUp':
          rotatePiece();
          break;
        case ' ':
          fastDrop();
          break;
        case 'p':
        case 'P':
          togglePause();
          break;
      }
    });

    let touchStartX = 0;
    let touchStartY = 0;

    canvas.addEventListener('touchstart', (e) => {
      if (!gameActive || isPaused) return;

      touchStartX = e.touches[0].clientX;
      touchStartY = e.touches[0].clientY;
      e.preventDefault();
    });

    canvas.addEventListener('touchmove', (e) => {
      e.preventDefault();
    });

    canvas.addEventListener('touchend', (e) => {
      if (!gameActive || isPaused) return;

      const touchEndX = e.changedTouches[0].clientX;
      const touchEndY = e.changedTouches[0].clientY;

      const dx = touchEndX - touchStartX;
      const dy = touchEndY - touchStartY;

      const minSwipeDistance = 30;

      if (Math.abs(dx) > Math.abs(dy)) {
        if (dx > minSwipeDistance) {
          moveRight();
        } else if (dx < -minSwipeDistance) {
          moveLeft();
        }
      } else {
        if (dy > minSwipeDistance) {
          fastDrop();
        } else if (dy < -minSwipeDistance) {
          rotatePiece();
        }
      }
    });

    window.addEventListener('resize', () => {
      if (window.innerWidth < 768) {
        GRID_SIZE = 25;
        canvas.width = 250;
        canvas.height = 500;
      } else {
        GRID_SIZE = 30;
        canvas.width = 300;
        canvas.height = 600;
      }

      COLS = Math.floor(canvas.width / GRID_SIZE);
      ROWS = Math.floor(canvas.height / GRID_SIZE);

      board = Array(ROWS).fill().map(() => Array(COLS).fill(0));
      drawBoard();
    });
  </script>
</body>

</html>