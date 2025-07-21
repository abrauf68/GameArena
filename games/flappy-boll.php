<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flappy Bird</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            overflow: hidden;
        }

        .game-container {
            position: relative;
            width: 400px;
            height: 600px;
            background: #87CEEB;
            border: 4px solid #333;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        #gameCanvas {
            display: block;
            width: 100%;
            height: 100%;
        }

        .game-over {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            display: none;
            flex-direction: column;
            gap: 20px;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .game-over h2 {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .game-over p {
            font-size: 1.2em;
        }

        .game-over button {
            padding: 10px 20px;
            font-size: 1em;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .game-over button:hover {
            background: #c0392b;
        }

        .score {
            position: absolute;
            top: 20px;
            left: 20px;
            color: white;
            font-size: 2em;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .start-screen {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            animation: fadeIn 0.5s;
        }

        .start-screen h2 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        .start-screen button {
            padding: 10px 20px;
            font-size: 1em;
            background: #2ecc71;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .start-screen button:hover {
            background: #27ae60;
        }

        @media (max-width: 500px) {
            .game-container {
                width: 100%;
                height: 100vh;
                border: none;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="game-container">
        <canvas id="gameCanvas" width="400" height="600"></canvas>
        <div class="score" id="score">0</div>
        <div class="start-screen" id="startScreen">
            <h2>Flappy Boll</h2>
            <button onclick="startGame()">Start Game</button>
        </div>
        <div class="game-over" id="gameOver">
            <h2>Game Over</h2>
            <p>Score: <span id="finalScore">0</span></p>
            <button onclick="restartGame()">Restart</button>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('gameCanvas');
        const ctx = canvas.getContext('2d');
        const scoreDisplay = document.getElementById('score');
        const finalScoreDisplay = document.getElementById('finalScore');
        const gameOverScreen = document.getElementById('gameOver');
        const startScreen = document.getElementById('startScreen');

        let bird = {
            x: 100,
            y: canvas.height / 2,
            radius: 20,
            velocity: 0,
            gravity: 0.5,
            lift: -10
        };

        let pipes = [];
        let score = 0;
        let gameStarted = false;
        let gameOver = false;
        const pipeWidth = 50;
        const pipeGap = 150;
        const pipeSpeed = 2;
        let frameCount = 0;
        let animationFrameId;

        function drawBird() {
            ctx.beginPath();
            ctx.arc(bird.x, bird.y, bird.radius, 0, Math.PI * 2);
            ctx.fillStyle = '#e74c3c';
            ctx.fill();
            ctx.strokeStyle = '#c0392b';
            ctx.lineWidth = 3;
            ctx.stroke();
            ctx.closePath();
        }

        function drawPipes() {
            pipes.forEach(pipe => {
                ctx.fillStyle = '#2ecc71';
                ctx.fillRect(pipe.x, 0, pipeWidth, pipe.top);
                ctx.fillRect(pipe.x, pipe.top + pipeGap, pipeWidth, canvas.height - pipe.top - pipeGap);
            });
        }

        function updateBird() {
            if (gameStarted && !gameOver) {
                bird.velocity += bird.gravity;
                bird.y += bird.velocity;

                if (bird.y + bird.radius > canvas.height || bird.y - bird.radius < 0) {
                    endGame();
                }
            }
        }

        function generatePipe() {
            const minHeight = 50;
            const maxHeight = canvas.height - pipeGap - minHeight;
            const top = Math.floor(Math.random() * (maxHeight - minHeight + 1)) + minHeight;
            pipes.push({ x: canvas.width, top: top, passed: false });
        }

        function updatePipes() {
            if (gameStarted && !gameOver) {
                if (frameCount % 100 === 0) {
                    generatePipe();
                }

                pipes.forEach(pipe => {
                    pipe.x -= pipeSpeed;

                    if (pipe.x + pipeWidth < bird.x && !pipe.passed) {
                        score++;
                        pipe.passed = true;
                        scoreDisplay.textContent = score;
                    }

                    if (
                        bird.x + bird.radius > pipe.x &&
                        bird.x - bird.radius < pipe.x + pipeWidth &&
                        (bird.y - bird.radius < pipe.top || bird.y + bird.radius > pipe.top + pipeGap)
                    ) {
                        endGame();
                    }
                });

                pipes = pipes.filter(pipe => pipe.x + pipeWidth > 0);
            }
        }

        function endGame() {
            gameOver = true;
            gameOverScreen.style.display = 'flex';
            finalScoreDisplay.textContent = score;
            cancelAnimationFrame(animationFrameId); // Stop the game loop
        }

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
            gameLoop(); // Start the game loop
        }

        function restartGame() {
            // Reset all game state and start a new game loop
            score = 0;
            scoreDisplay.textContent = score;
            bird.y = canvas.height / 2;
            bird.velocity = 0;
            pipes = [];
            gameOver = false;
            gameOverScreen.style.display = 'none';
            frameCount = 0;
            gameStarted = true;
            cancelAnimationFrame(animationFrameId); // Ensure any running loop is stopped
            gameLoop(); // Restart the game loop
        }

        function flap() {
            if (gameStarted && !gameOver) {
                bird.velocity = bird.lift;
            }
        }

        function gameLoop() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Draw ground
            ctx.fillStyle = '#8B4513';
            ctx.fillRect(0, canvas.height - 20, canvas.width, 20);

            drawBird();
            updateBird();
            drawPipes();
            updatePipes();

            frameCount++;

            if (!gameOver) {
                animationFrameId = requestAnimationFrame(gameLoop);
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.code === 'Space') {
                flap();
            }
        });

        canvas.addEventListener('click', flap);
        canvas.addEventListener('touchstart', flap);
    </script>
</body>
</html>