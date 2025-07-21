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

        #game-container {
            position: relative;
            width: 400px;
            height: 600px;
            background: radial-gradient(circle, #0a0a0a, #1c2526);
            border: 5px solid #00ffcc;
            border-radius: 15px;
            box-shadow: 0 0 20px #00ffcc, inset 0 0 10px #00ffcc;
            overflow: hidden;
        }

        #ball {
            position: absolute;
            width: 20px;
            height: 20px;
            background: radial-gradient(circle, #ff00ff, #ff66ff);
            border-radius: 50%;
            box-shadow: 0 0 10px #ff00ff;
        }

        .brick {
            position: absolute;
            width: 50px;
            height: 20px;
            background: linear-gradient(45deg, #ff3333, #ff6666);
            border: 2px solid #ff9999;
            box-shadow: 0 0 8px #ff3333;
        }

        #paddle {
            position: absolute;
            bottom: 20px;
            width: 100px;
            height: 15px;
            background: linear-gradient(45deg, #00ccff, #00ffcc);
            border-radius: 5px;
            box-shadow: 0 0 10px #00ccff;
            left: 150px;
        }

        #score {
            position: absolute;
            top: 10px;
            left: 10px;
            color: #00ffcc;
            font-size: 24px;
            text-shadow: 0 0 5px #00ffcc;
        }

        #level {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #00ffcc;
            font-size: 24px;
            text-shadow: 0 0 5px #00ffcc;
        }

        #game-over,
        #level-complete {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #ff00ff;
            font-size: 36px;
            text-shadow: 0 0 10px #ff00ff;
            display: none;
            text-align: center;
        }

        #restart-btn,
        #next-level-btn {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            background: #ff00ff;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 0 10px #ff00ff;
        }

        #restart-btn:hover,
        #next-level-btn:hover {
            background: #ff66ff;
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
            <div id="game-container">
                <div id="ball"></div>
                <div id="paddle"></div>
                <div id="score">Score: 0</div>
                <div id="level">Level: 1</div>
                <div id="game-over">
                    Game Over!<br>
                    <button id="restart-btn">Restart</button>
                </div>
                <div id="level-complete">
                    Level Complete!<br>
                    <button id="next-level-btn">Next Level</button>
                </div>
            </div>
        </main>
        <!-- main end -->
    </div>
    <!-- app layout end -->

    <script>
        const canvas = document.getElementById('game-container');
        const ball = document.getElementById('ball');
        const paddle = document.getElementById('paddle');
        const scoreDisplay = document.getElementById('score');
        const levelDisplay = document.getElementById('level');
        const gameOverScreen = document.getElementById('game-over');
        const levelCompleteScreen = document.getElementById('level-complete');
        const restartBtn = document.getElementById('restart-btn');
        const nextLevelBtn = document.getElementById('next-level-btn');

        let ballX = 200,
            ballY = 500;
        let ballSpeedX = 4,
            ballSpeedY = -12; // Faster initial speed
        const ballRadius = 10;
        let paddleX = 150;
        const paddleWidth = 100;
        const paddleSpeed = 8; // Very responsive paddle
        let score = 0;
        let level = 1;
        let gameOver = false;
        let levelComplete = false;
        const gravity = 0.08; // Very low gravity for high bounces
        const friction = 1; // No friction for maximum speed
        const brickBounce = 1.2;
        const paddleBounce = 14; // Strong bounce to reach top
        let bricks = [];

        const levelLayouts = [
            // Level 1: Simple grid
            [{
                    x: 50,
                    y: 50
                }, {
                    x: 110,
                    y: 50
                }, {
                    x: 170,
                    y: 50
                }, {
                    x: 230,
                    y: 50
                }, {
                    x: 290,
                    y: 50
                },
                {
                    x: 50,
                    y: 80
                }, {
                    x: 110,
                    y: 80
                }, {
                    x: 170,
                    y: 80
                }, {
                    x: 230,
                    y: 80
                }, {
                    x: 290,
                    y: 80
                }
            ],
            // Level 2: Triangle shape
            [{
                    x: 170,
                    y: 50
                },
                {
                    x: 140,
                    y: 80
                }, {
                    x: 200,
                    y: 80
                },
                {
                    x: 110,
                    y: 110
                }, {
                    x: 170,
                    y: 110
                }, {
                    x: 230,
                    y: 110
                }
            ],
            // Level 3: Scattered
            [{
                    x: 50,
                    y: 50
                }, {
                    x: 290,
                    y: 50
                },
                {
                    x: 110,
                    y: 80
                }, {
                    x: 230,
                    y: 80
                },
                {
                    x: 170,
                    y: 110
                }
            ]
        ];

        function createBricks(layout) {
            bricks.forEach(brick => brick.element.remove());
            bricks = [];
            layout.forEach(pos => {
                const brick = document.createElement('div');
                brick.className = 'brick';
                brick.style.left = `${pos.x}px`;
                brick.style.top = `${pos.y}px`;
                canvas.appendChild(brick);
                bricks.push({
                    x: pos.x + 25,
                    y: pos.y + 10,
                    element: brick,
                    width: 50,
                    height: 20
                });
            });
        }

        const keys = {
            ArrowLeft: false,
            ArrowRight: false
        };

        document.addEventListener('keydown', (e) => {
            if (e.key in keys) {
                keys[e.key] = true;
                e.preventDefault();
            }
        });

        document.addEventListener('keyup', (e) => {
            if (e.key in keys) {
                keys[e.key] = false;
                e.preventDefault();
            }
        });

        restartBtn.addEventListener('click', resetGame);
        nextLevelBtn.addEventListener('click', startNextLevel);

        function resetGame() {
            ballX = 200;
            ballY = 500;
            ballSpeedX = 4;
            ballSpeedY = -12;
            paddleX = 150;
            score = 0;
            level = 1;
            gameOver = false;
            levelComplete = false;
            scoreDisplay.textContent = `Score: ${score}`;
            levelDisplay.textContent = `Level: ${level}`;
            gameOverScreen.style.display = 'none';
            levelCompleteScreen.style.display = 'none';
            ball.style.display = 'block';
            paddle.style.left = `${paddleX}px`;
            createBricks(levelLayouts[0]);
        }

        function startNextLevel() {
            level++;
            if (level > levelLayouts.length) level = 1;
            ballX = 200;
            ballY = 500;
            ballSpeedX = 4 * (1 + level * 0.2); // Faster per level
            ballSpeedY = -12 * (1 + level * 0.2);
            paddleX = 150;
            levelComplete = false;
            levelDisplay.textContent = `Level: ${level}`;
            levelCompleteScreen.style.display = 'none';
            ball.style.display = 'block';
            paddle.style.left = `${paddleX}px`;
            createBricks(levelLayouts[level - 1]);
        }

        function moveBall() {
            if (gameOver || levelComplete) return;

            ballSpeedY += gravity;
            ballSpeedX *= friction;
            ballSpeedY *= friction;
            ballX += ballSpeedX;
            ballY += ballSpeedY;

            // Wall collisions
            if (ballX - ballRadius < 0) {
                ballX = ballRadius;
                ballSpeedX = Math.abs(ballSpeedX) * 1.1; // Slight speed boost
            }
            if (ballX + ballRadius > 400) {
                ballX = 400 - ballRadius;
                ballSpeedX = -Math.abs(ballSpeedX) * 1.1;
            }
            if (ballY - ballRadius < 0) {
                ballY = ballRadius;
                ballSpeedY = Math.abs(ballSpeedY) * 1.1;
            }
            if (ballY + ballRadius > 600) {
                gameOver = true;
                gameOverScreen.style.display = 'block';
                ball.style.display = 'none';
            }

            // Brick collisions
            bricks = bricks.filter(brick => {
                const dx = ballX - brick.x;
                const dy = ballY - brick.y;
                const closestX = Math.max(brick.x - brick.width / 2, Math.min(ballX, brick.x + brick.width / 2));
                const closestY = Math.max(brick.y - brick.height / 2, Math.min(ballY, brick.y + brick.height / 2));
                const distanceX = ballX - closestX;
                const distanceY = ballY - closestY;
                const distance = Math.sqrt(distanceX * distanceX + distanceY * distanceY);

                if (distance < ballRadius) {
                    const absDx = Math.abs(dx);
                    const absDy = Math.abs(dy);
                    if (absDx > absDy) {
                        ballSpeedX = (dx > 0 ? -Math.abs(ballSpeedX) : Math.abs(ballSpeedX)) * brickBounce;
                    } else {
                        ballSpeedY = (dy > 0 ? -Math.abs(ballSpeedY) : Math.abs(ballSpeedY)) * brickBounce;
                    }
                    score += 10;
                    scoreDisplay.textContent = `Score: ${score}`;
                    brick.element.style.background = `linear-gradient(45deg, #333, #666)`;
                    setTimeout(() => brick.element.remove(), 100);
                    return false;
                }
                return true;
            });

            // Check for level completion
            if (bricks.length === 0) {
                levelComplete = true;
                levelCompleteScreen.style.display = 'block';
                ball.style.display = 'none';
            }

            // Paddle collision
            const paddleY = 580; // Paddle at y=580 (600 - 20)
            if (ballY + ballRadius > paddleY && ballX > paddleX && ballX < paddleX + paddleWidth && ballSpeedY > 0) {
                const relativeX = (ballX - (paddleX + paddleWidth / 2)) / (paddleWidth / 2);
                ballSpeedY = -paddleBounce; // Strong upward speed to reach top
                ballSpeedX = relativeX * 6; // Strong horizontal control
                score += 5;
                scoreDisplay.textContent = `Score: ${score}`;
            }

            ball.style.left = `${ballX - ballRadius}px`;
            ball.style.top = `${ballY - ballRadius}px`;
        }

        function movePaddle() {
            if (keys.ArrowLeft && paddleX > 0) {
                paddleX -= paddleSpeed;
            }
            if (keys.ArrowRight && paddleX < 400 - paddleWidth) {
                paddleX += paddleSpeed;
            }
            paddle.style.left = `${paddleX}px`;
        }

        function gameLoop() {
            moveBall();
            movePaddle();
            requestAnimationFrame(gameLoop);
        }

        // Initialize first level
        createBricks(levelLayouts[0]);
        gameLoop();
    </script>
</body>

</html>