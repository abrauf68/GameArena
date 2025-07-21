<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Chrome Dino Clone</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #1a1a1a;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            color: #e0e0e0;
        }

        .game-container {
            width: 100%;
            max-width: 800px;
            height: 300px;
            background: #252525;
            position: relative;
            overflow: hidden;
            border: 2px solid #00ff88;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 255, 136, 0.2);
        }

        .ground {
            position: absolute;
            bottom: 0;
            width: 2400px;
            height: 24px;
            background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAABgCAYAAABCKIWvAAAAAXNSR0IArs4c6QAAAERlWElmTU0AKgAAAAgAAYdpAAQAAAABAAAAGgAAAAAAA6ABAAMAAAABAAEAAKACAAQAAAABAAAIyKADAAQAAAABAAAAYAAAAAD/WEWqAAABh0lEQVR4Xu3UsQ2AMAwEwL9/6T66AEsj0DJBk8v0kMxtB8DMzMzsO3YAAMAwzMzsO3YAAMAwM7Pv2AEAgGFmdt+xAwAAw8zMvmMHAAAGmdmH7QAAwDAzs+/YAQCAMTMz+44dAAA4ZmZ23zEDAAADzMzsO3YAAGCYmdmH7QAAwDAzs+/YAQCAMTMz+44dAAA4ZmZ23zEDAAADzMzsO3YAAGCYmdmH7QAAwDAzs+/YAQCAMTMz+44dAAA4ZmZ23zEDAAADzMzsO3YAAGCYmdmH7QAAwDAzs+/YAQCAMTMz+44dAAA4ZmZ23zEDAAADzMzsO3YAAGCYmdmH7QAAwDAzs+/YAQCAMTMz+44dAAA4ZmZ23zEDAAADzMzsO3YAAGCYmdmH7QAAwDAzs+/YAQCAMTMz+44dAAA4ZmZ23zEDAAADzMzsO3YAAGCYmdmH7QAAwDAzs+/YAQCAMTMz+44dAAA4ZmZ23zEDAAADzP8B+U5HQqXjW5gAAAAASUVORK5CYII=') repeat-x;
            animation: scroll 1s linear infinite;
            filter: brightness(0.8);
        }

        @keyframes scroll {
            100% { transform: translateX(-800px); }
        }

        #dino {
            position: absolute;
            bottom: 24px;
            left: 50px;
            width: 44px;
            height: 47px;
            font-size: 40px;
            line-height: 47px;
            text-align: center;
            color: #00ff88;
            user-select: none;
            transition: bottom 0.1s ease;
            transform: scaleX(-1); /* Flip dino horizontally to face right */
        }

        .cactus {
            position: absolute;
            bottom: 24px;
            width: 25px;
            height: 50px;
            font-size: 40px;
            line-height: 50px;
            text-align: center;
            color: #00ff88;
            user-select: none;
        }

        .score-board {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 16px;
            font-weight: 500;
            color: #00ff88;
            text-shadow: 0 0 5px rgba(0, 255, 136, 0.5);
        }

        .game-over {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            display: none;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 8px;
        }

        .game-over h1 {
            font-size: 24px;
            color: #ff4d4d;
            text-shadow: 0 0 10px rgba(255, 77, 77, 0.5);
        }

        .game-over p {
            font-size: 16px;
            color: #e0e0e0;
        }

        .restart-btn {
            width: 40px;
            height: 40px;
            background: none;
            border: none;
            cursor: pointer;
            transition: transform 0.2s ease, filter 0.2s ease;
        }

        .restart-btn svg {
            fill: #00ff88;
            filter: drop-shadow(0 0 5px rgba(0, 255, 136, 0.5));
        }

        .restart-btn:hover {
            transform: scale(1.2);
            filter: brightness(1.2);
        }

        .instructions {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 12px;
            color: #00ff88;
            text-shadow: 0 0 5px rgba(0, 255, 136, 0.5);
        }

        @media (max-width: 600px) {
            .game-container {
                height: 200px;
                border-width: 1px;
            }

            #dino {
                left: 20px;
                width: 30px;
                height: 32px;
                font-size: 28px;
                line-height: 32px;
            }

            .cactus {
                width: 18px;
                height: 36px;
                font-size: 28px;
                line-height: 36px;
            }

            .ground {
                height: 16px;
            }

            .score-board {
                font-size: 12px;
            }

            .game-over h1 {
                font-size: 18px;
            }

            .game-over p {
                font-size: 12px;
            }

            .restart-btn {
                width: 30px;
                height: 30px;
                text-align: center;
            }

            .instructions {
                font-size: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="game-container">
        <div class="ground"></div>
        <div id="dino">🦕</div>
        <div class="score-board">
            <span id="score">00000</span> HI <span id="high-score">00000</span>
        </div>
        <div class="instructions">Tap or SPACE to start/jump</div>
        <div class="game-over" id="game-over">
            <h1>GAME OVER</h1>
            <p>Score: <span id="final-score">00000</span></p>
            <button class="restart-btn" onclick="restartGame()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="40" height="40">
                    <path d="M12 4V1L8 5l4 4V6c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                </svg>
            </button>
        </div>
    </div>

    <script>
        const dino = document.getElementById('dino');
        const scoreDisplay = document.getElementById('score');
        const highScoreDisplay = document.getElementById('high-score');
        const gameOverScreen = document.getElementById('game-over');
        const finalScoreDisplay = document.getElementById('final-score');

        let dinoY = 0;
        let velocity = 0;
        let gravity = 0.6;
        let jumpPower = 12;
        let isJumping = false;
        let score = 0;
        let highScore = localStorage.getItem('highScore') ? parseInt(localStorage.getItem('highScore')) : 0;
        let gameOver = false;
        let gameStarted = false;
        let cacti = [];
        let gameSpeed = 6;
        let frame = 0;

        highScoreDisplay.textContent = highScore.toString().padStart(5, '0');

        class Cactus {
            constructor() {
                this.x = 800;
                this.y = 300 - 74;
                this.width = window.innerWidth <= 600 ? 18 : 25;
                this.height = window.innerWidth <= 600 ? 36 : 50;
                this.element = document.createElement('div');
                this.element.className = 'cactus';
                this.element.textContent = '🌵';
                this.element.style.right = '0px';
                document.querySelector('.game-container').appendChild(this.element);
            }

            update() {
                this.x -= gameSpeed;
                this.element.style.right = (800 - this.x) + 'px';
            }

            remove() {
                this.element.remove();
            }
        }

        function jump() {
            if (!gameStarted) {
                gameStarted = true;
                update();
            }
            if (!isJumping && !gameOver) {
                velocity = jumpPower;
                isJumping = true;
                dino.style.transition = 'none';
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.code === 'Space') {
                e.preventDefault();
                jump();
            }
        });

        document.addEventListener('touchstart', (e) => {
            e.preventDefault();
            jump();
        });

        function spawnCactus() {
            if (frame % Math.floor(100 - gameSpeed * 5) === 0 && gameStarted && !gameOver) {
                cacti.push(new Cactus());
            }
        }

        function checkCollision(dinoRect, cactusRect) {
            return (
                dinoRect.x + 10 < cactusRect.x + cactusRect.width &&
                dinoRect.x + dinoRect.width - 10 > cactusRect.x &&
                dinoRect.y + 10 < cactusRect.y + cactusRect.height &&
                dinoRect.y + dinoRect.height - 10 > cactusRect.y
            );
        }

        function update() {
            if (!gameStarted || gameOver) return;

            velocity -= gravity;
            dinoY += velocity;
            if (dinoY <= 0) {
                dinoY = 0;
                velocity = 0;
                isJumping = false;
                dino.style.transition = 'bottom 0.1s ease';
            } else {
                dino.style.transition = 'bottom 0.05s linear';
            }
            dino.style.bottom = (24 + dinoY) + 'px';

            frame++;
            if (frame % 5 === 0) {
                score++;
                scoreDisplay.textContent = score.toString().padStart(5, '0');
                if (score > highScore) {
                    highScore = score;
                    highScoreDisplay.textContent = highScore.toString().padStart(5, '0');
                    localStorage.setItem('highScore', highScore);
                }
            }

            spawnCactus();
            cacti.forEach((cactus, index) => {
                cactus.update();
                if (cactus.x < -cactus.width) {
                    cactus.remove();
                    cacti.splice(index, 1);
                }

                const dinoRect = {
                    x: 50,
                    y: 300 - 74 + dinoY,
                    width: window.innerWidth <= 600 ? 30 : 44,
                    height: window.innerWidth <= 600 ? 32 : 47
                };
                const cactusRect = {
                    x: cactus.x,
                    y: cactus.y,
                    width: cactus.width,
                    height: cactus.height
                };

                if (checkCollision(dinoRect, cactusRect)) {
                    gameOver = true;
                    gameOverScreen.style.display = 'flex';
                    finalScoreDisplay.textContent = score.toString().padStart(5, '0');
                }
            });

            if (frame % 1000 === 0) {
                gameSpeed += 0.5;
            }

            requestAnimationFrame(update);
        }

        function restartGame() {
            score = 0;
            scoreDisplay.textContent = score.toString().padStart(5, '0');
            gameOver = false;
            gameStarted = false;
            gameOverScreen.style.display = 'none';
            cacti.forEach(cactus => cactus.remove());
            cacti = [];
            dinoY = 0;
            velocity = 0;
            isJumping = false;
            gameSpeed = 6;
            frame = 0;
            dino.style.bottom = '24px';
            dino.style.transition = 'none';
        }

        scoreDisplay.textContent = score.toString().padStart(5, '0');
    </script>
</body>
</html>