<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flappy Bird: Dark Edition</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --primary: #8A2BE2;
            --secondary: #00BFFF;
            --accent: #FF00FF;
            --background: #121212;
            --card-bg: #1E1E1E;
            --text: #F0F0F0;
            --border: #333;
            --success: #4CAF50;
            --danger: #F44336;
            --warning: #FFC107;
            --info: #2196F3;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--background), #000);
            overflow: hidden;
            color: var(--text);
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 30%, rgba(138, 43, 226, 0.1), transparent 70%),
                radial-gradient(circle at 80% 70%, rgba(0, 191, 255, 0.1), transparent 70%);
            pointer-events: none;
            z-index: -1;
        }

        .game-container {
            position: relative;
            width: 420px;
            height: 700px;
            background: var(--card-bg);
            border: 2px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
            display: flex;
            flex-direction: column;
        }

        .game-header {
            padding: 15px 20px;
            background: rgba(30, 30, 30, 0.9);
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
            backdrop-filter: blur(5px);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo i {
            font-size: 1.8rem;
            color: var(--primary);
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 10px rgba(138, 43, 226, 0.3);
        }

        .stats {
            display: flex;
            gap: 15px;
            font-size: 1.1rem;
        }

        .stat {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stat i {
            color: var(--secondary);
        }

        #gameCanvas {
            display: block;
            width: 100%;
            flex: 1;
            background: #0a0a0a;
        }

        .score {
            position: absolute;
            top: 100px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 3.5rem;
            font-weight: bold;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.7);
            z-index: 5;
        }

        .game-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            z-index: 20;
            transition: all 0.5s ease;
        }

        .start-screen,
        .game-over {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
            background: rgba(30, 30, 30, 0.9);
            border-radius: 20px;
            border: 1px solid var(--border);
            max-width: 90%;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        /* .game-over {
            display: none;
        } */

        .screen-title {
            font-size: 2.5rem;
            margin-bottom: 20px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 15px rgba(138, 43, 226, 0.5);
        }

        .screen-subtitle {
            font-size: 1.2rem;
            margin-bottom: 25px;
            color: #aaa;
            max-width: 80%;
        }

        .final-score {
            font-size: 3rem;
            font-weight: bold;
            margin: 15px 0;
            color: var(--secondary);
            text-shadow: 0 0 10px rgba(0, 191, 255, 0.5);
        }

        .high-score {
            font-size: 1.4rem;
            margin-bottom: 25px;
            color: var(--warning);
        }

        .btn {
            padding: 12px 35px;
            font-size: 1.2rem;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 10px 0;
            width: 220px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 5px 15px rgba(138, 43, 226, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(138, 43, 226, 0.6);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .controls {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .control-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgba(255, 255, 255, 0.05);
            padding: 10px 15px;
            border-radius: 10px;
            min-width: 100px;
        }

        .control-item i {
            font-size: 1.8rem;
            margin-bottom: 5px;
            color: var(--secondary);
        }

        .instructions {
            margin-top: 30px;
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 10px;
            max-width: 90%;
        }

        .instructions h3 {
            margin-bottom: 10px;
            color: var(--primary);
        }

        .instructions p {
            color: #aaa;
            line-height: 1.6;
        }

        .game-footer {
            padding: 15px;
            text-align: center;
            background: rgba(30, 30, 30, 0.9);
            border-top: 1px solid var(--border);
            font-size: 0.9rem;
            color: #777;
        }

        .particle {
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            pointer-events: none;
            z-index: 5;
        }

        /* Animations */
        @keyframes float {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0);
            }
        }

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

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        .pulse {
            animation: pulse 2s ease-in-out infinite;
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        /* Responsive design */
        @media (max-width: 500px) {
            .game-container {
                width: 100%;
                height: 100vh;
                border-radius: 0;
            }

            .controls {
                flex-direction: column;
                align-items: center;
            }

            .control-item {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="game-container">
        <div class="game-header">
            <div class="logo">
                <i class="fas fa-dove"></i>
                <h1>FLAPPY DARK</h1>
            </div>
            <div class="stats">
                <div class="stat">
                    <i class="fas fa-star"></i>
                    <span id="highScoreDisplay">0</span>
                </div>
                <div class="stat">
                    <i class="fas fa-volume-up"></i>
                </div>
                <div class="stat">
                    <i class="fas fa-cog"></i>
                </div>
            </div>
        </div>

        <canvas id="gameCanvas" width="420" height="600"></canvas>

        <div class="score" id="score">0</div>

        <div class="game-overlay" id="startScreen">
            <div class="start-screen fade-in">
                <h2 class="screen-title floating">FLAPPY DARK</h2>
                <p class="screen-subtitle">The ultimate dark mode Flappy Bird experience</p>

                <button class="btn btn-primary pulse" onclick="startGame()">
                    <i class="fas fa-play"></i> START GAME
                </button>

                <div class="controls">
                    <div class="control-item fade-in" style="animation-delay: 0.2s">
                        <i class="fas fa-space-shuttle"></i>
                        <span>SPACE</span>
                        <small>to flap</small>
                    </div>
                    <div class="control-item fade-in" style="animation-delay: 0.4s">
                        <i class="fas fa-mouse-pointer"></i>
                        <span>CLICK</span>
                        <small>to flap</small>
                    </div>
                    <div class="control-item fade-in" style="animation-delay: 0.6s">
                        <i class="fas fa-mobile-alt"></i>
                        <span>TAP</span>
                        <small>to flap</small>
                    </div>
                </div>

                <div class="instructions fade-in" style="animation-delay: 0.8s">
                    <h3>HOW TO PLAY</h3>
                    <p>Navigate through the pipes without hitting them. Each pipe passed earns you a point. The game gets progressively faster!</p>
                </div>
            </div>
        </div>

        <div class="game-overlay" id="gameOver" style="display: none;">
            <div class="game-over fade-in">
                <h2 class="screen-title">GAME OVER</h2>
                <p class="screen-subtitle">Your flight has come to an end</p>

                <div class="final-score">
                    Score: <span id="finalScore">0</span>
                </div>

                <div class="high-score">
                    <i class="fas fa-trophy"></i> High Score: <span id="highScore">0</span>
                </div>

                <button class="btn btn-primary" onclick="restartGame()">
                    <i class="fas fa-redo"></i> PLAY AGAIN
                </button>

                <button class="btn btn-secondary" onclick="showStartScreen()">
                    <i class="fas fa-home"></i> MAIN MENU
                </button>
            </div>
        </div>

        <div class="game-footer">
            <p>© 2023 Flappy Dark | The Ultimate Dark Mode Experience</p>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('gameCanvas');
        const ctx = canvas.getContext('2d');
        const scoreDisplay = document.getElementById('score');
        const finalScoreDisplay = document.getElementById('finalScore');
        const highScoreDisplay = document.getElementById('highScore');
        const highScoreMainDisplay = document.getElementById('highScoreDisplay');
        const gameOverScreen = document.getElementById('gameOver');
        const startScreen = document.getElementById('startScreen');

        // Game variables
        let bird = {
            x: 100,
            y: canvas.height / 2,
            radius: 20,
            velocity: 0,
            gravity: 0.5,
            lift: -10,
            color: '#8A2BE2'
        };

        let pipes = [];
        let score = 0;
        let highScore = localStorage.getItem('flappyDarkHighScore') || 0;
        let gameStarted = false;
        let gameOver = false;
        const pipeWidth = 70;
        const pipeGap = 200;
        const pipeSpeed = 3;
        let frameCount = 0;
        let animationFrameId;
        let particles = [];
        let gameSpeed = 1;

        // Initialize high score display
        highScoreDisplay.textContent = highScore;
        highScoreMainDisplay.textContent = highScore;

        // Create particles
        function createParticles(x, y, color, count) {
            for (let i = 0; i < count; i++) {
                particles.push({
                    x: x,
                    y: y,
                    size: Math.random() * 5 + 2,
                    speedX: Math.random() * 6 - 3,
                    speedY: Math.random() * 6 - 3,
                    color: color,
                    life: 30
                });
            }
        }

        // Update particles
        function updateParticles() {
            for (let i = 0; i < particles.length; i++) {
                particles[i].x += particles[i].speedX;
                particles[i].y += particles[i].speedY;
                particles[i].life--;

                if (particles[i].life <= 0) {
                    particles.splice(i, 1);
                    i--;
                }
            }
        }

        // Draw particles
        function drawParticles() {
            for (let particle of particles) {
                ctx.globalAlpha = particle.life / 30;
                ctx.fillStyle = particle.color;
                ctx.beginPath();
                ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
                ctx.fill();
            }
            ctx.globalAlpha = 1;
        }

        // Draw background with gradient and stars
        function drawBackground() {
            // Draw gradient background
            const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
            gradient.addColorStop(0, "#0a0a1a");
            gradient.addColorStop(1, "#121230");
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Draw stars
            ctx.fillStyle = 'rgba(255, 255, 255, 0.8)';
            for (let i = 0; i < 100; i++) {
                const x = Math.random() * canvas.width;
                const y = Math.random() * canvas.height;
                const radius = Math.random() * 1.5;
                ctx.beginPath();
                ctx.arc(x, y, radius, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        // Draw bird with gradient and shine
        function drawBird() {
            // Draw glow
            ctx.shadowColor = bird.color;
            ctx.shadowBlur = 20;

            // Draw bird body with gradient
            const gradient = ctx.createRadialGradient(
                bird.x, bird.y, 0,
                bird.x, bird.y, bird.radius
            );
            gradient.addColorStop(0, '#ffffff');
            gradient.addColorStop(0.5, bird.color);
            gradient.addColorStop(1, '#4B0082');

            ctx.beginPath();
            ctx.arc(bird.x, bird.y, bird.radius, 0, Math.PI * 2);
            ctx.fillStyle = gradient;
            ctx.fill();

            // Draw eye
            ctx.beginPath();
            ctx.arc(bird.x + 8, bird.y - 5, 5, 0, Math.PI * 2);
            ctx.fillStyle = '#000';
            ctx.fill();

            ctx.beginPath();
            ctx.arc(bird.x + 9, bird.y - 5, 2, 0, Math.PI * 2);
            ctx.fillStyle = '#fff';
            ctx.fill();

            // Draw beak
            ctx.beginPath();
            ctx.moveTo(bird.x + 15, bird.y);
            ctx.lineTo(bird.x + 30, bird.y - 5);
            ctx.lineTo(bird.x + 30, bird.y + 5);
            ctx.closePath();
            ctx.fillStyle = '#FFD700';
            ctx.fill();

            // Reset shadow
            ctx.shadowBlur = 0;
        }

        // Draw pipes with gradient and shine
        function drawPipes() {
            pipes.forEach(pipe => {
                // Top pipe
                const topGradient = ctx.createLinearGradient(pipe.x, 0, pipe.x + pipeWidth, 0);
                topGradient.addColorStop(0, '#00BFFF');
                topGradient.addColorStop(1, '#0080FF');

                ctx.fillStyle = topGradient;
                ctx.fillRect(pipe.x, 0, pipeWidth, pipe.top);

                // Pipe cap
                ctx.fillStyle = '#0080FF';
                ctx.fillRect(pipe.x - 5, pipe.top - 20, pipeWidth + 10, 20);

                // Bottom pipe
                const bottomGradient = ctx.createLinearGradient(pipe.x, pipe.top + pipeGap, pipe.x + pipeWidth, pipe.top + pipeGap);
                bottomGradient.addColorStop(0, '#00BFFF');
                bottomGradient.addColorStop(1, '#0080FF');

                ctx.fillStyle = bottomGradient;
                ctx.fillRect(pipe.x, pipe.top + pipeGap, pipeWidth, canvas.height - pipe.top - pipeGap);

                // Pipe cap
                ctx.fillStyle = '#0080FF';
                ctx.fillRect(pipe.x - 5, pipe.top + pipeGap, pipeWidth + 10, 20);

                // Pipe shine
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.3)';
                ctx.lineWidth = 2;
                ctx.beginPath();
                ctx.moveTo(pipe.x + 5, 0);
                ctx.lineTo(pipe.x + 5, pipe.top - 20);
                ctx.stroke();

                ctx.beginPath();
                ctx.moveTo(pipe.x + 5, pipe.top + pipeGap);
                ctx.lineTo(pipe.x + 5, canvas.height);
                ctx.stroke();
            });
        }

        // Update bird position
        function updateBird() {
            if (gameStarted && !gameOver) {
                bird.velocity += bird.gravity;
                bird.y += bird.velocity;

                // Apply rotation based on velocity
                bird.rotation = bird.velocity * 0.1;

                // Floor and ceiling collision
                if (bird.y + bird.radius > canvas.height - 20 || bird.y - bird.radius < 0) {
                    createParticles(bird.x, bird.y, '#FF00FF', 30);
                    endGame();
                }
            }
        }

        // Generate new pipes
        function generatePipe() {
            const minHeight = 70;
            const maxHeight = canvas.height - pipeGap - minHeight - 20;
            const top = Math.floor(Math.random() * (maxHeight - minHeight + 1)) + minHeight;
            pipes.push({
                x: canvas.width,
                top: top,
                passed: false
            });
        }

        // Update pipes position
        function updatePipes() {
            if (gameStarted && !gameOver) {
                if (frameCount % 90 === 0) {
                    generatePipe();
                }

                pipes.forEach(pipe => {
                    pipe.x -= pipeSpeed * gameSpeed;

                    // Increase game speed every 5 pipes
                    if (score > 0 && score % 5 === 0) {
                        gameSpeed = 1 + (Math.floor(score / 5) * 0.1);
                    }

                    if (pipe.x + pipeWidth < bird.x && !pipe.passed) {
                        score++;
                        pipe.passed = true;
                        scoreDisplay.textContent = score;
                        createParticles(pipe.x + pipeWidth / 2, pipe.top + pipeGap / 2, '#00FF00', 15);
                    }

                    // Collision detection
                    if (
                        bird.x + bird.radius > pipe.x &&
                        bird.x - bird.radius < pipe.x + pipeWidth &&
                        (bird.y - bird.radius < pipe.top || bird.y + bird.radius > pipe.top + pipeGap)
                    ) {
                        createParticles(bird.x, bird.y, '#FF0000', 40);
                        endGame();
                    }
                });

                // Remove off-screen pipes
                pipes = pipes.filter(pipe => pipe.x + pipeWidth > 0);
            }
        }

        // Draw ground
        function drawGround() {
            ctx.fillStyle = '#222233';
            ctx.fillRect(0, canvas.height - 20, canvas.width, 20);

            // Draw ground pattern
            ctx.fillStyle = '#333344';
            for (let i = 0; i < canvas.width; i += 40) {
                ctx.fillRect(i, canvas.height - 20, 20, 20);
            }

            // Draw ground highlight
            ctx.strokeStyle = 'rgba(0, 191, 255, 0.3)';
            ctx.lineWidth = 2;
            ctx.beginPath();
            ctx.moveTo(0, canvas.height - 20);
            ctx.lineTo(canvas.width, canvas.height - 20);
            ctx.stroke();
        }

        // End game
        function endGame() {
            gameOver = true;
            gameOverScreen.style.display = 'flex';
            finalScoreDisplay.textContent = score;

            // Update high score
            if (score > highScore) {
                highScore = score;
                localStorage.setItem('flappyDarkHighScore', highScore);
                highScoreDisplay.textContent = highScore;
                highScoreMainDisplay.textContent = highScore;
            }

            cancelAnimationFrame(animationFrameId);
        }

        // Start game
        function startGame() {
            gameStarted = true;
            startScreen.style.display = 'none';
            score = 0;
            scoreDisplay.textContent = score;
            bird.y = canvas.height / 2;
            bird.velocity = 0;
            pipes = [];
            gameOver = false;
            gameOverScreen.style.display = 'none';
            frameCount = 0;
            gameSpeed = 1;
            gameLoop();
        }

        // Restart game
        function restartGame() {
            score = 0;
            scoreDisplay.textContent = score;
            bird.y = canvas.height / 2;
            bird.velocity = 0;
            pipes = [];
            gameOver = false;
            gameOverScreen.style.display = 'none';
            frameCount = 0;
            gameSpeed = 1;
            gameStarted = true;
            cancelAnimationFrame(animationFrameId);
            gameLoop();
        }

        // Show start screen
        function showStartScreen() {
            gameStarted = false;
            gameOver = false;
            gameOverScreen.style.display = 'none';
            startScreen.style.display = 'flex';
            particles = [];
        }

        // Bird flap
        function flap() {
            if (gameStarted && !gameOver) {
                bird.velocity = bird.lift;
                createParticles(bird.x, bird.y, '#8A2BE2', 10);
            }
        }

        // Main game loop
        function gameLoop() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            drawBackground();
            drawGround();
            drawPipes();
            drawBird();
            updateBird();
            updatePipes();
            updateParticles();
            drawParticles();

            frameCount++;

            if (!gameOver) {
                animationFrameId = requestAnimationFrame(gameLoop);
            }
        }

        // Event listeners
        document.addEventListener('keydown', (e) => {
            if (e.code === 'Space') {
                flap();
            }
        });

        canvas.addEventListener('click', flap);
        canvas.addEventListener('touchstart', (e) => {
            e.preventDefault();
            flap();
        });

        // Initialize start screen
        showStartScreen();
    </script>
</body>

</html> -->

<!DOCTYPE html>
<html dir="ltr" lang="en">

<?php include '../layout/head.php' ?>

<body>
    <style>
        :root {
            --primary: #8A2BE2;
            --secondary: #00BFFF;
            --accent: #FF00FF;
            --background: #121212;
            --card-bg: #1E1E1E;
            --text: #F0F0F0;
            --border: #333;
            --success: #4CAF50;
            --danger: #F44336;
            --warning: #FFC107;
            --info: #2196F3;
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
            position: relative;
            width: 420px;
            height: 700px;
            background: var(--card-bg);
            border: 2px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
            display: flex;
            flex-direction: column;
        }

        .game-header {
            padding: 15px 20px;
            background: rgba(30, 30, 30, 0.9);
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
            backdrop-filter: blur(5px);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo i {
            font-size: 1.8rem;
            color: var(--primary);
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 10px rgba(138, 43, 226, 0.3);
        }

        .stats {
            display: flex;
            gap: 15px;
            font-size: 1.1rem;
        }

        .stat {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .stat i {
            color: var(--secondary);
        }

        #gameCanvas {
            display: block;
            width: 100%;
            flex: 1;
            background: #0a0a0a;
        }

        .score {
            position: absolute;
            top: 100px;
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 3.5rem;
            font-weight: bold;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.7);
            z-index: 5;
        }

        .game-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            z-index: 20;
            transition: all 0.5s ease;
        }

        .start-screen,
        .game-over {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
            background: rgba(30, 30, 30, 0.9);
            border-radius: 20px;
            border: 1px solid var(--border);
            max-width: 90%;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        /* .game-over {
            display: none;
        } */

        .screen-title {
            font-size: 2.5rem;
            margin-bottom: 20px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 15px rgba(138, 43, 226, 0.5);
        }

        .screen-subtitle {
            font-size: 1.2rem;
            margin-bottom: 25px;
            color: #aaa;
            max-width: 80%;
        }

        .final-score {
            font-size: 3rem;
            font-weight: bold;
            margin: 15px 0;
            color: var(--secondary);
            text-shadow: 0 0 10px rgba(0, 191, 255, 0.5);
        }

        .high-score {
            font-size: 1.4rem;
            margin-bottom: 25px;
            color: var(--warning);
        }

        .btn {
            padding: 12px 35px;
            font-size: 1.2rem;
            font-weight: 600;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 10px 0;
            width: 220px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 5px 15px rgba(138, 43, 226, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(138, 43, 226, 0.6);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .controls {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .control-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgba(255, 255, 255, 0.05);
            padding: 10px 15px;
            border-radius: 10px;
            min-width: 100px;
        }

        .control-item i {
            font-size: 1.8rem;
            margin-bottom: 5px;
            color: var(--secondary);
        }

        .instructions {
            margin-top: 30px;
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 10px;
            max-width: 90%;
        }

        .instructions h3 {
            margin-bottom: 10px;
            color: var(--primary);
        }

        .instructions p {
            color: #aaa;
            line-height: 1.6;
        }

        .game-footer {
            padding: 15px;
            text-align: center;
            background: rgba(30, 30, 30, 0.9);
            border-top: 1px solid var(--border);
            font-size: 0.9rem;
            color: #777;
        }

        .particle {
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            pointer-events: none;
            z-index: 5;
        }

        /* Animations */
        @keyframes float {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0);
            }
        }

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

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        .pulse {
            animation: pulse 2s ease-in-out infinite;
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }

        /* Responsive design */
        @media (max-width: 500px) {
            .game-container {
                width: 100%;
                height: 100vh;
                border-radius: 0;
            }

            .controls {
                flex-direction: column;
                align-items: center;
            }

            .control-item {
                width: 100%;
            }
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
                <div class="game-header">
                    <div class="logo">
                        <i class="fas fa-dove"></i>
                        <h1>FLAPPY BIRD</h1>
                    </div>
                    <div class="stats">
                        <div class="stat">
                            <i class="fas fa-star"></i>
                            <span id="highScoreDisplay">0</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-volume-up"></i>
                        </div>
                        <div class="stat">
                            <i class="fas fa-cog"></i>
                        </div>
                    </div>
                </div>

                <canvas id="gameCanvas" width="420" height="600"></canvas>

                <div class="score" id="score">0</div>

                <div class="game-overlay" id="startScreen">
                    <div class="start-screen fade-in">
                        <h2 class="screen-title floating">FLAPPY BIRD</h2>
                        <p class="screen-subtitle">The ultimate dark mode Flappy Bird experience</p>

                        <button class="btn btn-primary pulse" onclick="startGame()">
                            <i class="fas fa-play"></i> START GAME
                        </button>

                        <div class="controls">
                            <div class="control-item fade-in" style="animation-delay: 0.2s">
                                <i class="fas fa-space-shuttle"></i>
                                <span>SPACE</span>
                                <small>to flap</small>
                            </div>
                            <div class="control-item fade-in" style="animation-delay: 0.4s">
                                <i class="fas fa-mouse-pointer"></i>
                                <span>CLICK</span>
                                <small>to flap</small>
                            </div>
                            <div class="control-item fade-in" style="animation-delay: 0.6s">
                                <i class="fas fa-mobile-alt"></i>
                                <span>TAP</span>
                                <small>to flap</small>
                            </div>
                        </div>

                        <div class="instructions fade-in" style="animation-delay: 0.8s">
                            <h3>HOW TO PLAY</h3>
                            <p>Navigate through the pipes without hitting them. Each pipe passed earns you a point. The game gets progressively faster!</p>
                        </div>
                    </div>
                </div>

                <div class="game-overlay" id="gameOver" style="display: none;">
                    <div class="game-over fade-in">
                        <h2 class="screen-title">GAME OVER</h2>
                        <p class="screen-subtitle">Your flight has come to an end</p>

                        <div class="final-score">
                            Score: <span id="finalScore">0</span>
                        </div>

                        <div class="high-score">
                            <i class="fas fa-trophy"></i> High Score: <span id="highScore">0</span>
                        </div>

                        <button class="btn btn-primary" onclick="restartGame()">
                            <i class="fas fa-redo"></i> PLAY AGAIN
                        </button>

                        <button class="btn btn-secondary" onclick="showStartScreen()">
                            <i class="fas fa-home"></i> MAIN MENU
                        </button>
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
        const scoreDisplay = document.getElementById('score');
        const finalScoreDisplay = document.getElementById('finalScore');
        const highScoreDisplay = document.getElementById('highScore');
        const highScoreMainDisplay = document.getElementById('highScoreDisplay');
        const gameOverScreen = document.getElementById('gameOver');
        const startScreen = document.getElementById('startScreen');

        // Game variables
        let bird = {
            x: 100,
            y: canvas.height / 2,
            radius: 20,
            velocity: 0,
            gravity: 0.5,
            lift: -10,
            color: '#8A2BE2'
        };

        let pipes = [];
        let score = 0;
        let highScore = localStorage.getItem('flappyDarkHighScore') || 0;
        let gameStarted = false;
        let gameOver = false;
        const pipeWidth = 70;
        const pipeGap = 200;
        const pipeSpeed = 3;
        let frameCount = 0;
        let animationFrameId;
        let particles = [];
        let gameSpeed = 1;

        // Initialize high score display
        highScoreDisplay.textContent = highScore;
        highScoreMainDisplay.textContent = highScore;

        // Create particles
        function createParticles(x, y, color, count) {
            for (let i = 0; i < count; i++) {
                particles.push({
                    x: x,
                    y: y,
                    size: Math.random() * 5 + 2,
                    speedX: Math.random() * 6 - 3,
                    speedY: Math.random() * 6 - 3,
                    color: color,
                    life: 30
                });
            }
        }

        // Update particles
        function updateParticles() {
            for (let i = 0; i < particles.length; i++) {
                particles[i].x += particles[i].speedX;
                particles[i].y += particles[i].speedY;
                particles[i].life--;

                if (particles[i].life <= 0) {
                    particles.splice(i, 1);
                    i--;
                }
            }
        }

        // Draw particles
        function drawParticles() {
            for (let particle of particles) {
                ctx.globalAlpha = particle.life / 30;
                ctx.fillStyle = particle.color;
                ctx.beginPath();
                ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
                ctx.fill();
            }
            ctx.globalAlpha = 1;
        }

        // Draw background with gradient and stars
        function drawBackground() {
            // Draw gradient background
            const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
            gradient.addColorStop(0, "#0a0a1a");
            gradient.addColorStop(1, "#121230");
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Draw stars
            ctx.fillStyle = 'rgba(255, 255, 255, 0.8)';
            for (let i = 0; i < 100; i++) {
                const x = Math.random() * canvas.width;
                const y = Math.random() * canvas.height;
                const radius = Math.random() * 1.5;
                ctx.beginPath();
                ctx.arc(x, y, radius, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        // Draw bird with gradient and shine
        function drawBird() {
            // Draw glow
            ctx.shadowColor = bird.color;
            ctx.shadowBlur = 20;

            // Draw bird body with gradient
            const gradient = ctx.createRadialGradient(
                bird.x, bird.y, 0,
                bird.x, bird.y, bird.radius
            );
            gradient.addColorStop(0, '#ffffff');
            gradient.addColorStop(0.5, bird.color);
            gradient.addColorStop(1, '#4B0082');

            ctx.beginPath();
            ctx.arc(bird.x, bird.y, bird.radius, 0, Math.PI * 2);
            ctx.fillStyle = gradient;
            ctx.fill();

            // Draw eye
            ctx.beginPath();
            ctx.arc(bird.x + 8, bird.y - 5, 5, 0, Math.PI * 2);
            ctx.fillStyle = '#000';
            ctx.fill();

            ctx.beginPath();
            ctx.arc(bird.x + 9, bird.y - 5, 2, 0, Math.PI * 2);
            ctx.fillStyle = '#fff';
            ctx.fill();

            // Draw beak
            ctx.beginPath();
            ctx.moveTo(bird.x + 15, bird.y);
            ctx.lineTo(bird.x + 30, bird.y - 5);
            ctx.lineTo(bird.x + 30, bird.y + 5);
            ctx.closePath();
            ctx.fillStyle = '#FFD700';
            ctx.fill();

            // Reset shadow
            ctx.shadowBlur = 0;
        }

        // Draw pipes with gradient and shine
        function drawPipes() {
            pipes.forEach(pipe => {
                // Top pipe
                const topGradient = ctx.createLinearGradient(pipe.x, 0, pipe.x + pipeWidth, 0);
                topGradient.addColorStop(0, '#00BFFF');
                topGradient.addColorStop(1, '#0080FF');

                ctx.fillStyle = topGradient;
                ctx.fillRect(pipe.x, 0, pipeWidth, pipe.top);

                // Pipe cap
                ctx.fillStyle = '#0080FF';
                ctx.fillRect(pipe.x - 5, pipe.top - 20, pipeWidth + 10, 20);

                // Bottom pipe
                const bottomGradient = ctx.createLinearGradient(pipe.x, pipe.top + pipeGap, pipe.x + pipeWidth, pipe.top + pipeGap);
                bottomGradient.addColorStop(0, '#00BFFF');
                bottomGradient.addColorStop(1, '#0080FF');

                ctx.fillStyle = bottomGradient;
                ctx.fillRect(pipe.x, pipe.top + pipeGap, pipeWidth, canvas.height - pipe.top - pipeGap);

                // Pipe cap
                ctx.fillStyle = '#0080FF';
                ctx.fillRect(pipe.x - 5, pipe.top + pipeGap, pipeWidth + 10, 20);

                // Pipe shine
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.3)';
                ctx.lineWidth = 2;
                ctx.beginPath();
                ctx.moveTo(pipe.x + 5, 0);
                ctx.lineTo(pipe.x + 5, pipe.top - 20);
                ctx.stroke();

                ctx.beginPath();
                ctx.moveTo(pipe.x + 5, pipe.top + pipeGap);
                ctx.lineTo(pipe.x + 5, canvas.height);
                ctx.stroke();
            });
        }

        // Update bird position
        function updateBird() {
            if (gameStarted && !gameOver) {
                bird.velocity += bird.gravity;
                bird.y += bird.velocity;

                // Apply rotation based on velocity
                bird.rotation = bird.velocity * 0.1;

                // Floor and ceiling collision
                if (bird.y + bird.radius > canvas.height - 20 || bird.y - bird.radius < 0) {
                    createParticles(bird.x, bird.y, '#FF00FF', 30);
                    endGame();
                }
            }
        }

        // Generate new pipes
        function generatePipe() {
            const minHeight = 70;
            const maxHeight = canvas.height - pipeGap - minHeight - 20;
            const top = Math.floor(Math.random() * (maxHeight - minHeight + 1)) + minHeight;
            pipes.push({
                x: canvas.width,
                top: top,
                passed: false
            });
        }

        // Update pipes position
        function updatePipes() {
            if (gameStarted && !gameOver) {
                if (frameCount % 90 === 0) {
                    generatePipe();
                }

                pipes.forEach(pipe => {
                    pipe.x -= pipeSpeed * gameSpeed;

                    // Increase game speed every 5 pipes
                    if (score > 0 && score % 5 === 0) {
                        gameSpeed = 1 + (Math.floor(score / 5) * 0.1);
                    }

                    if (pipe.x + pipeWidth < bird.x && !pipe.passed) {
                        score++;
                        pipe.passed = true;
                        scoreDisplay.textContent = score;
                        createParticles(pipe.x + pipeWidth / 2, pipe.top + pipeGap / 2, '#00FF00', 15);
                    }

                    // Collision detection
                    if (
                        bird.x + bird.radius > pipe.x &&
                        bird.x - bird.radius < pipe.x + pipeWidth &&
                        (bird.y - bird.radius < pipe.top || bird.y + bird.radius > pipe.top + pipeGap)
                    ) {
                        createParticles(bird.x, bird.y, '#FF0000', 40);
                        endGame();
                    }
                });

                // Remove off-screen pipes
                pipes = pipes.filter(pipe => pipe.x + pipeWidth > 0);
            }
        }

        // Draw ground
        function drawGround() {
            ctx.fillStyle = '#222233';
            ctx.fillRect(0, canvas.height - 20, canvas.width, 20);

            // Draw ground pattern
            ctx.fillStyle = '#333344';
            for (let i = 0; i < canvas.width; i += 40) {
                ctx.fillRect(i, canvas.height - 20, 20, 20);
            }

            // Draw ground highlight
            ctx.strokeStyle = 'rgba(0, 191, 255, 0.3)';
            ctx.lineWidth = 2;
            ctx.beginPath();
            ctx.moveTo(0, canvas.height - 20);
            ctx.lineTo(canvas.width, canvas.height - 20);
            ctx.stroke();
        }

        // End game
        function endGame() {
            gameOver = true;
            gameOverScreen.style.display = 'flex';
            finalScoreDisplay.textContent = score;

            // Update high score
            if (score > highScore) {
                highScore = score;
                localStorage.setItem('flappyDarkHighScore', highScore);
                highScoreDisplay.textContent = highScore;
                highScoreMainDisplay.textContent = highScore;
            }

            cancelAnimationFrame(animationFrameId);
        }

        // Start game
        function startGame() {
            gameStarted = true;
            startScreen.style.display = 'none';
            score = 0;
            scoreDisplay.textContent = score;
            bird.y = canvas.height / 2;
            bird.velocity = 0;
            pipes = [];
            gameOver = false;
            gameOverScreen.style.display = 'none';
            frameCount = 0;
            gameSpeed = 1;
            gameLoop();
        }

        // Restart game
        function restartGame() {
            score = 0;
            scoreDisplay.textContent = score;
            bird.y = canvas.height / 2;
            bird.velocity = 0;
            pipes = [];
            gameOver = false;
            gameOverScreen.style.display = 'none';
            frameCount = 0;
            gameSpeed = 1;
            gameStarted = true;
            cancelAnimationFrame(animationFrameId);
            gameLoop();
        }

        // Show start screen
        function showStartScreen() {
            gameStarted = false;
            gameOver = false;
            gameOverScreen.style.display = 'none';
            startScreen.style.display = 'flex';
            particles = [];
        }

        // Bird flap
        function flap() {
            if (gameStarted && !gameOver) {
                bird.velocity = bird.lift;
                createParticles(bird.x, bird.y, '#8A2BE2', 10);
            }
        }

        // Main game loop
        function gameLoop() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            drawBackground();
            drawGround();
            drawPipes();
            drawBird();
            updateBird();
            updatePipes();
            updateParticles();
            drawParticles();

            frameCount++;

            if (!gameOver) {
                animationFrameId = requestAnimationFrame(gameLoop);
            }
        }

        // Event listeners
        document.addEventListener('keydown', (e) => {
            if (e.code === 'Space') {
                flap();
            }
        });

        canvas.addEventListener('click', flap);
        canvas.addEventListener('touchstart', (e) => {
            e.preventDefault();
            flap();
        });

        // Initialize start screen
        showStartScreen();
    </script>
</body>

</html>