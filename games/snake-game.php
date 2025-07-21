<!DOCTYPE html>
<html dir="ltr" lang="en">

<?php include '../layout/head.php' ?>

<body>
    <style>
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            /* overflow-y: hidden; */
            padding: 0;
            padding-top: 100px;
        }

        :root {
            --primary: #00ff88;
            --secondary: #6c63ff;
            --accent: #ff3d3d;
            --dark-1: #0f0c29;
            --dark-2: #1a1a2e;
            --dark-3: #16213e;
            --light: #e6f1ff;
            --grid-color: rgba(255, 255, 255, 0.05);
        }

        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            background: var(--primary);
            opacity: 0.3;
            animation: float 15s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translateY(0) translateX(0);
            }

            100% {
                transform: translateY(-100vh) translateX(-50vw);
            }
        }

        .game-container {
            width: 95%;
            max-width: 1200px;
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            padding: 20px;
            overflow-y: auto;
        }

        .game-panel {
            background: rgba(26, 26, 46, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(108, 99, 255, 0.2);
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .game-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(108, 99, 255, 0.3);
        }

        .game-header h1 {
            font-size: 2.8rem;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 10px;
            text-shadow: 0 0 15px rgba(0, 255, 136, 0.3);
            letter-spacing: 1px;
        }

        .game-header p {
            font-size: 1.1rem;
            opacity: 0.8;
            margin-top: 5px;
        }

        .score-board {
            display: flex;
            justify-content: space-between;
            background: rgba(0, 0, 0, 0.3);
            padding: 15px;
            border-radius: 12px;
            border: 1px solid rgba(108, 99, 255, 0.2);
        }

        .score-item {
            text-align: center;
        }

        .score-item h3 {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 5px;
            opacity: 0.8;
        }

        .score-item span {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
        }

        .game-options {
            background: rgba(0, 0, 0, 0.3);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid rgba(108, 99, 255, 0.2);
        }

        .game-options h2 {
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .option-group {
            margin-bottom: 20px;
        }

        .option-group h3 {
            font-size: 1.1rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            background: rgba(108, 99, 255, 0.2);
            color: var(--light);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
            min-width: 120px;
            justify-content: center;
        }

        .btn:hover {
            background: rgba(108, 99, 255, 0.3);
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(1px);
        }

        .btn.active {
            background: var(--secondary);
            box-shadow: 0 0 15px rgba(108, 99, 255, 0.5);
        }

        .btn.primary {
            background: var(--primary);
            color: var(--dark-2);
            font-weight: 600;
        }

        .btn.primary:hover {
            background: #00e67a;
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.5);
        }

        .btn.danger {
            background: var(--accent);
            color: white;
        }

        .btn.danger:hover {
            background: #ff2a2a;
            box-shadow: 0 0 20px rgba(255, 61, 61, 0.5);
        }

        .game-area {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .canvas-container {
            position: relative;
            background: var(--dark-3);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid rgba(108, 99, 255, 0.2);
        }

        canvas {
            border-radius: 15px;
            display: block;
            max-width: 100%;
            background: var(--dark-2);
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.5);
        }

        .mobile-controls {
            display: none;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(3, 1fr);
            gap: 10px;
            height: 200px;
        }

        .control-btn {
            background: rgba(108, 99, 255, 0.2);
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid rgba(108, 99, 255, 0.3);
        }

        .control-btn:active {
            background: var(--secondary);
            transform: scale(0.95);
        }

        .control-btn.up {
            grid-area: 1 / 2 / 2 / 3;
        }

        .control-btn.down {
            grid-area: 3 / 2 / 4 / 3;
        }

        .control-btn.left {
            grid-area: 2 / 1 / 3 / 2;
        }

        .control-btn.right {
            grid-area: 2 / 3 / 3 / 4;
        }

        .control-btn.center {
            grid-area: 2 / 2 / 3 / 3;
        }

        .game-over {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 10, 20, 0.95);
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 100;
            border-radius: 20px;
            text-align: center;
        }

        .game-over h2 {
            font-size: 4rem;
            margin-bottom: 20px;
            color: var(--accent);
            text-shadow: 0 0 20px rgba(255, 61, 61, 0.7);
        }

        .game-over p {
            font-size: 2rem;
            margin-bottom: 30px;
        }

        .game-over span {
            color: var(--primary);
            font-weight: 700;
        }

        .game-over .buttons {
            justify-content: center;
        }

        .instructions {
            background: rgba(0, 0, 0, 0.3);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid rgba(108, 99, 255, 0.2);
        }

        .instructions h2 {
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .instructions ul {
            padding-left: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .instructions li {
            line-height: 1.6;
        }

        /* Responsive design */
        @media (max-width: 900px) {
            .game-container {
                grid-template-columns: 1fr;
                max-width: 600px;
            }

            .game-panel {
                order: 2;
            }
        }

        @media (max-width: 600px) {
            .game-header h1 {
                font-size: 2.2rem;
            }

            .score-item span {
                font-size: 1.5rem;
            }

            .mobile-controls {
                display: grid;
            }

            .btn {
                min-width: 100px;
                padding: 10px 15px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 400px) {
            .game-header h1 {
                font-size: 1.8rem;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        /* Animations */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .pulse {
            animation: pulse 2s infinite;
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
        <div class="particles" id="particles"></div>
        <!-- main start -->
        <main>
            <div class="game-container">
                <div class="game-panel">
                    <div class="game-header">
                        <h1>NEON SNAKE</h1>
                        <p>The Ultimate Snake Experience</p>
                    </div>

                    <div class="score-board">
                        <div class="score-item">
                            <h3><i class="fas fa-star"></i> SCORE</h3>
                            <span id="score">0</span>
                        </div>
                        <div class="score-item">
                            <h3><i class="fas fa-crown"></i> HIGH SCORE</h3>
                            <span id="highScore">0</span>
                        </div>
                    </div>

                    <div class="game-options">
                        <h2><i class="fas fa-cog"></i> GAME OPTIONS</h2>

                        <div class="option-group">
                            <h3><i class="fas fa-tachometer-alt"></i> SPEED</h3>
                            <div class="buttons">
                                <button class="btn active" id="speedSlow">Slow</button>
                                <button class="btn" id="speedMedium">Medium</button>
                                <button class="btn" id="speedFast">Fast</button>
                            </div>
                        </div>

                        <div class="option-group">
                            <h3><i class="fas fa-palette"></i> THEME</h3>
                            <div class="buttons">
                                <button class="btn active" id="themeNeon">Neon</button>
                                <button class="btn" id="themeCyber">Cyber</button>
                                <button class="btn" id="themeClassic">Classic</button>
                            </div>
                        </div>

                        <div class="option-group">
                            <h3><i class="fas fa-snake"></i> SNAKE SKIN</h3>
                            <div class="buttons">
                                <button class="btn active" id="skinDefault">Default</button>
                                <button class="btn" id="skinFire">Fire</button>
                                <button class="btn" id="skinIce">Ice</button>
                            </div>
                        </div>

                        <div class="buttons" style="margin-top: 25px;">
                            <button class="btn primary" id="pauseBtn"><i class="fas fa-pause"></i> PAUSE</button>
                            <button class="btn danger" id="resetBtn"><i class="fas fa-redo"></i> RESET</button>
                        </div>
                    </div>

                    <div class="instructions">
                        <h2><i class="fas fa-info-circle"></i> HOW TO PLAY</h2>
                        <ul>
                            <li>Use <b>Arrow Keys</b> or <b>Swipe</b> to control the snake</li>
                            <li>Eat the glowing food to grow and earn points</li>
                            <li>Avoid colliding with walls or yourself</li>
                            <li>Press <b>P</b> to pause/resume the game</li>
                        </ul>
                    </div>
                </div>

                <div class="game-area">
                    <div class="canvas-container">
                        <canvas id="gameCanvas" width="600" height="600"></canvas>
                        <div class="game-over" id="gameOverScreen">
                            <h2>GAME OVER</h2>
                            <p>Your Score: <span id="finalScore">0</span></p>
                            <div class="buttons">
                                <button class="btn primary" id="restartBtn"><i class="fas fa-play"></i> PLAY AGAIN</button>
                                <button class="btn" id="menuBtn"><i class="fas fa-home"></i> MAIN MENU</button>
                            </div>
                        </div>
                    </div>

                    <div class="mobile-controls">
                        <div class="control-btn up"><i class="fas fa-arrow-up"></i></div>
                        <div class="control-btn down"><i class="fas fa-arrow-down"></i></div>
                        <div class="control-btn left"><i class="fas fa-arrow-left"></i></div>
                        <div class="control-btn right"><i class="fas fa-arrow-right"></i></div>
                        <div class="control-btn center"><i class="fas fa-pause"></i></div>
                    </div>
                </div>
            </div>
        </main>
        <!-- main end -->
    </div>
    <!-- app layout end -->

    <script>
        // Canvas setup
        const canvas = document.getElementById('gameCanvas');
        const ctx = canvas.getContext('2d');
        const scoreElement = document.getElementById('score');
        const highScoreElement = document.getElementById('highScore');
        const pauseBtn = document.getElementById('pauseBtn');
        const resetBtn = document.getElementById('resetBtn');
        const gameOverScreen = document.getElementById('gameOverScreen');
        const finalScoreElement = document.getElementById('finalScore');
        const restartBtn = document.getElementById('restartBtn');
        const menuBtn = document.getElementById('menuBtn');

        // Game constants
        const gridSize = 20;
        const tileCount = canvas.width / gridSize;
        let snake = [{
            x: 10,
            y: 10
        }];
        let food = {
            x: 15,
            y: 15
        };
        let dx = 0;
        let dy = 0;
        let score = 0;
        let highScore = localStorage.getItem('highScore') || 0;
        let gameSpeed = 150; // Milliseconds per frame
        let lastTime = 0;
        let isPaused = false;
        let gameLoop;

        // Theme variables
        let currentTheme = 'neon';
        let snakeHeadColor = '#00ff88';
        let snakeBodyColor = '#00cc70';
        let foodColor = '#ff3d3d';
        let gridColor = 'rgba(255, 255, 255, 0.05)';

        // Initialize high score
        highScoreElement.textContent = highScore;

        // Create background particles
        function createParticles() {
            const particles = document.getElementById('particles');
            particles.innerHTML = '';

            for (let i = 0; i < 30; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                // Random size and position
                const size = Math.random() * 5 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.left = `${Math.random() * 100}%`;
                particle.style.top = `${Math.random() * 100}%`;

                // Random animation duration
                particle.style.animationDuration = `${Math.random() * 20 + 10}s`;
                particle.style.animationDelay = `${Math.random() * 5}s`;

                // Random color
                const colors = ['#00ff88', '#6c63ff', '#ff3d3d'];
                particle.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];

                particles.appendChild(particle);
            }
        }

        // Set theme
        function setTheme(theme) {
            currentTheme = theme;

            switch (theme) {
                case 'cyber':
                    snakeHeadColor = '#6c63ff';
                    snakeBodyColor = '#4a43c9';
                    foodColor = '#ff3d3d';
                    break;
                case 'classic':
                    snakeHeadColor = '#4CAF50';
                    snakeBodyColor = '#8BC34A';
                    foodColor = '#F44336';
                    break;
                case 'neon':
                default:
                    snakeHeadColor = '#00ff88';
                    snakeBodyColor = '#00cc70';
                    foodColor = '#ff3d3d';
            }
        }

        // Draw grid on canvas
        function drawGrid() {
            ctx.strokeStyle = gridColor;
            ctx.lineWidth = 1;

            // Draw vertical lines
            for (let i = 0; i < tileCount; i++) {
                ctx.beginPath();
                ctx.moveTo(i * gridSize, 0);
                ctx.lineTo(i * gridSize, canvas.height);
                ctx.stroke();
            }

            // Draw horizontal lines
            for (let i = 0; i < tileCount; i++) {
                ctx.beginPath();
                ctx.moveTo(0, i * gridSize);
                ctx.lineTo(canvas.width, i * gridSize);
                ctx.stroke();
            }
        }

        // Get random position for food
        function getRandomPosition() {
            return {
                x: Math.floor(Math.random() * tileCount),
                y: Math.floor(Math.random() * tileCount)
            };
        }

        // Main game draw function
        function drawGame(timestamp) {
            if (isPaused) return;

            if (timestamp - lastTime < gameSpeed) {
                requestAnimationFrame(drawGame);
                return;
            }
            lastTime = timestamp;

            // Clear canvas with background
            ctx.fillStyle = '#1a1a2e';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Draw grid
            drawGrid();

            // Move snake
            const head = {
                x: snake[0].x + dx,
                y: snake[0].y + dy
            };

            // Check wall collision (teleport to opposite side)
            if (head.x < 0) head.x = tileCount - 1;
            if (head.x >= tileCount) head.x = 0;
            if (head.y < 0) head.y = tileCount - 1;
            if (head.y >= tileCount) head.y = 0;

            snake.unshift(head);

            // Check food collision
            if (head.x === food.x && head.y === food.y) {
                score += 10;
                scoreElement.textContent = score;
                if (score > highScore) {
                    highScore = score;
                    highScoreElement.textContent = highScore;
                    localStorage.setItem('highScore', highScore);
                }
                food = getRandomPosition();
                // Check if food appears on snake
                for (let segment of snake) {
                    if (food.x === segment.x && food.y === segment.y) {
                        food = getRandomPosition();
                        break;
                    }
                }
                gameSpeed = Math.max(50, gameSpeed - 2); // Increase speed
            } else {
                snake.pop();
            }

            // Check self collision
            for (let i = 1; i < snake.length; i++) {
                if (head.x === snake[i].x && head.y === snake[i].y) {
                    gameOver();
                    return;
                }
            }

            // Draw snake with gradient
            snake.forEach((segment, index) => {
                if (index === 0) {
                    // Draw snake head with gradient
                    const gradient = ctx.createRadialGradient(
                        segment.x * gridSize + gridSize / 2,
                        segment.y * gridSize + gridSize / 2,
                        0,
                        segment.x * gridSize + gridSize / 2,
                        segment.y * gridSize + gridSize / 2,
                        gridSize / 2
                    );
                    gradient.addColorStop(0, snakeHeadColor);
                    gradient.addColorStop(1, snakeBodyColor);

                    ctx.fillStyle = gradient;
                    ctx.shadowColor = snakeHeadColor;
                } else {
                    // Draw snake body
                    ctx.fillStyle = snakeBodyColor;
                    ctx.shadowColor = snakeBodyColor;
                }

                ctx.shadowBlur = 10;
                ctx.beginPath();
                ctx.arc(
                    segment.x * gridSize + gridSize / 2,
                    segment.y * gridSize + gridSize / 2,
                    gridSize / 2 - 1,
                    0,
                    Math.PI * 2
                );
                ctx.fill();
                ctx.shadowBlur = 0;
            });

            // Draw food with pulsing effect
            ctx.fillStyle = foodColor;
            ctx.shadowColor = foodColor;
            ctx.shadowBlur = 15;
            ctx.beginPath();
            ctx.arc(
                food.x * gridSize + gridSize / 2,
                food.y * gridSize + gridSize / 2,
                gridSize / 2 - 2,
                0,
                Math.PI * 2
            );
            ctx.fill();
            ctx.shadowBlur = 0;

            gameLoop = requestAnimationFrame(drawGame);
        }

        // Game over function
        function gameOver() {
            cancelAnimationFrame(gameLoop);
            finalScoreElement.textContent = score;
            gameOverScreen.style.display = 'flex';
            pauseBtn.disabled = true;
        }

        // Reset game function
        function resetGame() {
            snake = [{
                x: 10,
                y: 10
            }];
            food = getRandomPosition();
            dx = 0;
            dy = 0;
            score = 0;
            gameSpeed = 150;
            scoreElement.textContent = score;
            gameOverScreen.style.display = 'none';
            pauseBtn.disabled = false;
            pauseBtn.innerHTML = '<i class="fas fa-pause"></i> PAUSE';
            isPaused = false;
            lastTime = 0;
            gameLoop = requestAnimationFrame(drawGame);
        }

        // Keyboard controls
        document.addEventListener('keydown', (e) => {
            switch (e.key) {
                case 'ArrowUp':
                    if (dy === 0) {
                        dx = 0;
                        dy = -1;
                    }
                    break;
                case 'ArrowDown':
                    if (dy === 0) {
                        dx = 0;
                        dy = 1;
                    }
                    break;
                case 'ArrowLeft':
                    if (dx === 0) {
                        dx = -1;
                        dy = 0;
                    }
                    break;
                case 'ArrowRight':
                    if (dx === 0) {
                        dx = 1;
                        dy = 0;
                    }
                    break;
                case 'p':
                case 'P':
                    isPaused = !isPaused;
                    pauseBtn.innerHTML = isPaused ?
                        '<i class="fas fa-play"></i> RESUME' :
                        '<i class="fas fa-pause"></i> PAUSE';
                    if (!isPaused) gameLoop = requestAnimationFrame(drawGame);
                    break;
            }
        });

        // Touch controls for mobile
        let touchStartX = 0;
        let touchStartY = 0;

        canvas.addEventListener('touchstart', (e) => {
            const touch = e.touches[0];
            touchStartX = touch.clientX;
            touchStartY = touch.clientY;
        });

        canvas.addEventListener('touchmove', (e) => {
            e.preventDefault();
            const touch = e.touches[0];
            const deltaX = touch.clientX - touchStartX;
            const deltaY = touch.clientY - touchStartY;

            if (Math.abs(deltaX) > Math.abs(deltaY)) {
                // Horizontal swipe
                if (deltaX > 50 && dx === 0) {
                    dx = 1;
                    dy = 0;
                } // Right
                else if (deltaX < -50 && dx === 0) {
                    dx = -1;
                    dy = 0;
                } // Left
            } else {
                // Vertical swipe
                if (deltaY > 50 && dy === 0) {
                    dx = 0;
                    dy = 1;
                } // Down
                else if (deltaY < -50 && dy === 0) {
                    dx = 0;
                    dy = -1;
                } // Up
            }
        }, {
            passive: false
        });

        // Button event listeners
        pauseBtn.addEventListener('click', () => {
            isPaused = !isPaused;
            pauseBtn.innerHTML = isPaused ?
                '<i class="fas fa-play"></i> RESUME' :
                '<i class="fas fa-pause"></i> PAUSE';
            if (!isPaused) gameLoop = requestAnimationFrame(drawGame);
        });

        resetBtn.addEventListener('click', resetGame);
        restartBtn.addEventListener('click', resetGame);

        menuBtn.addEventListener('click', () => {
            gameOverScreen.style.display = 'none';
            isPaused = true;
            pauseBtn.innerHTML = '<i class="fas fa-play"></i> RESUME';
        });

        // Speed buttons
        document.getElementById('speedSlow').addEventListener('click', function() {
            document.querySelectorAll('#speedSlow, #speedMedium, #speedFast').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            gameSpeed = 200;
        });

        document.getElementById('speedMedium').addEventListener('click', function() {
            document.querySelectorAll('#speedSlow, #speedMedium, #speedFast').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            gameSpeed = 150;
        });

        document.getElementById('speedFast').addEventListener('click', function() {
            document.querySelectorAll('#speedSlow, #speedMedium, #speedFast').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            gameSpeed = 100;
        });

        // Theme buttons
        document.getElementById('themeNeon').addEventListener('click', function() {
            document.querySelectorAll('#themeNeon, #themeCyber, #themeClassic').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            setTheme('neon');
        });

        document.getElementById('themeCyber').addEventListener('click', function() {
            document.querySelectorAll('#themeNeon, #themeCyber, #themeClassic').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            setTheme('cyber');
        });

        document.getElementById('themeClassic').addEventListener('click', function() {
            document.querySelectorAll('#themeNeon, #themeCyber, #themeClassic').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            setTheme('classic');
        });

        // Skin buttons
        document.getElementById('skinDefault').addEventListener('click', function() {
            document.querySelectorAll('#skinDefault, #skinFire, #skinIce').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            snakeHeadColor = '#00ff88';
            snakeBodyColor = '#00cc70';
        });

        document.getElementById('skinFire').addEventListener('click', function() {
            document.querySelectorAll('#skinDefault, #skinFire, #skinIce').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            snakeHeadColor = '#ff6600';
            snakeBodyColor = '#ff3300';
        });

        document.getElementById('skinIce').addEventListener('click', function() {
            document.querySelectorAll('#skinDefault, #skinFire, #skinIce').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            snakeHeadColor = '#00ccff';
            snakeBodyColor = '#0066ff';
        });

        // Mobile controls
        document.querySelector('.control-btn.up').addEventListener('click', () => {
            if (dy === 0) {
                dx = 0;
                dy = -1;
            }
        });

        document.querySelector('.control-btn.down').addEventListener('click', () => {
            if (dy === 0) {
                dx = 0;
                dy = 1;
            }
        });

        document.querySelector('.control-btn.left').addEventListener('click', () => {
            if (dx === 0) {
                dx = -1;
                dy = 0;
            }
        });

        document.querySelector('.control-btn.right').addEventListener('click', () => {
            if (dx === 0) {
                dx = 1;
                dy = 0;
            }
        });

        document.querySelector('.control-btn.center').addEventListener('click', () => {
            isPaused = !isPaused;
            pauseBtn.innerHTML = isPaused ?
                '<i class="fas fa-play"></i> RESUME' :
                '<i class="fas fa-pause"></i> PAUSE';
            if (!isPaused) gameLoop = requestAnimationFrame(drawGame);
        });

        // Initialize game
        createParticles();
        gameLoop = requestAnimationFrame(drawGame);
    </script>
</body>

</html>