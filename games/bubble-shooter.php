<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bubble Shooter</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            font-family: 'Poppins', sans-serif;
            color: #fff;
            overflow: hidden;
        }

        #game-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            max-width: 90vw;
            max-height: 90vh;
            position: relative;
        }

        #game-canvas {
            border-radius: 10px;
            background: linear-gradient(180deg, #e0f7fa, #b2ebf2);
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.2);
            touch-action: none;
            max-width: 100%;
            max-height: 70vh;
        }

        #score, #level {
            font-size: clamp(1rem, 4vw, 1.5rem);
            margin: 10px 0;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        #game-over {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translate(-50%, -60%); }
            to { opacity: 1; transform: translate(-50%, -50%); }
        }

        #game-over h2 {
            font-size: clamp(1.5rem, 5vw, 2rem);
            color: #ff4d4d;
            margin-bottom: 10px;
        }

        button {
            padding: 10px 20px;
            font-size: clamp(0.9rem, 3vw, 1.2rem);
            background: linear-gradient(45deg, #ff6f61, #ff8a65);
            border: none;
            border-radius: 25px;
            color: white;
            cursor: pointer;
            transition: transform 0.2s, background 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        button:hover {
            background: linear-gradient(45deg, #ff3d2e, #ff7043);
            transform: scale(1.05);
        }

        #next-bubble {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 600px) {
            #game-container {
                padding: 10px;
            }
            #game-canvas {
                max-height: 60vh;
            }
            #score, #level {
                font-size: clamp(0.8rem, 3vw, 1.2rem);
            }
            button {
                padding: 8px 16px;
            }
        }

        @media (orientation: landscape) and (max-height: 500px) {
            #game-canvas {
                max-height: 80vh;
            }
        }
    </style>
</head>
<body>
    <div id="game-container">
        <div id="score">Score: 0</div>
        <div id="level">Level: 1</div>
        <canvas id="game-canvas"></canvas>
        <canvas id="next-bubble" width="40" height="40"></canvas>
        <div id="game-over">
            <h2>Game Over!</h2>
            <p id="final-score">Score: 0</p>
            <button onclick="restartGame()">Restart</button>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('game-canvas');
        const ctx = canvas.getContext('2d');
        const nextBubbleCanvas = document.getElementById('next-bubble');
        const nextBubbleCtx = nextBubbleCanvas.getContext('2d');
        const scoreDisplay = document.getElementById('score');
        const levelDisplay = document.getElementById('level');
        const gameOverDisplay = document.getElementById('game-over');
        const finalScoreDisplay = document.getElementById('final-score');

        // Game constants - Moved above resizeCanvas to avoid TDZ
        let BUBBLE_RADIUS = 25;
        let BUBBLE_DIAMETER = BUBBLE_RADIUS * 2;
        const GRID_COLS = 8;
        const GRID_ROWS = 12;
        const SHOOTER_POS = { x: 0, y: 0 }; // Initialize with dummy values, updated in resizeCanvas
        const COLORS = ['#ff4d4d', '#4da8ff', '#4dff4d', '#ffff4d', '#ff4dff'];
        const BUBBLE_SPEED = 8;
        const MAX_ANGLE = Math.PI * 0.45;

        // Responsive canvas sizing
        function resizeCanvas() {
            const maxWidth = Math.min(window.innerWidth * 0.9, 600);
            const maxHeight = Math.min(window.innerHeight * 0.7, 800);
            const aspectRatio = 3 / 4;
            canvas.width = Math.max(300, Math.min(maxWidth, maxHeight * aspectRatio));
            canvas.height = canvas.width / aspectRatio;
            BUBBLE_RADIUS = Math.min(canvas.width / 16, canvas.height / 20);
            BUBBLE_DIAMETER = BUBBLE_RADIUS * 2;
            SHOOTER_POS.x = canvas.width / 2;
            SHOOTER_POS.y = canvas.height - BUBBLE_RADIUS * 2;
            // Redraw bubbles after resize
            if (bubbles.length > 0) {
                repositionBubbles();
                draw();
            }
        }

        // Reposition bubbles after canvas resize
        function repositionBubbles() {
            for (let row = 0; row < bubbles.length; row++) {
                for (let col = 0; col < GRID_COLS; col++) {
                    if (bubbles[row][col]) {
                        bubbles[row][col].x = col * BUBBLE_DIAMETER + BUBBLE_RADIUS + (row % 2 ? BUBBLE_RADIUS : 0);
                        bubbles[row][col].y = row * BUBBLE_DIAMETER + BUBBLE_RADIUS;
                    }
                }
            }
            if (currentBubble) {
                currentBubble.x = SHOOTER_POS.x;
                currentBubble.y = SHOOTER_POS.y;
            }
        }

        window.addEventListener('resize', resizeCanvas);

        // Game state
        let bubbles = [];
        let currentBubble = null;
        let nextBubble = null;
        let shooting = false;
        let angle = -Math.PI / 2;
        let score = 0;
        let level = 1;
        let gameOver = false;

        // Initialize the game
        function initGame() {
            resizeCanvas(); // Ensure canvas is sized before creating bubbles
            bubbles = [];
            score = 0;
            level = 1;
            gameOver = false;
            scoreDisplay.textContent = `Score: ${score}`;
            levelDisplay.textContent = `Level: ${level}`;
            gameOverDisplay.style.display = 'none';
            createInitialBubbles();
            createNewBubble();
            drawNextBubble();
            console.log('Game initialized with bubbles:', bubbles); // Debugging
        }

        // Create initial bubble grid with guaranteed bubbles
        function createInitialBubbles() {
            for (let row = 0; row < 5; row++) {
                bubbles[row] = [];
                for (let col = 0; col < GRID_COLS; col++) {
                    // Ensure at least 50% of cells have bubbles
                    if (Math.random() > 0.5 || (row < 3 && col < 4)) {
                        const x = col * BUBBLE_DIAMETER + BUBBLE_RADIUS + (row % 2 ? BUBBLE_RADIUS : 0);
                        const y = row * BUBBLE_DIAMETER + BUBBLE_RADIUS;
                        // Ensure bubble is within canvas bounds
                        if (x + BUBBLE_RADIUS <= canvas.width && y + BUBBLE_RADIUS <= canvas.height) {
                            bubbles[row][col] = {
                                x: x,
                                y: y,
                                color: COLORS[Math.floor(Math.random() * COLORS.length)]
                            };
                        }
                    }
                }
            }
        }

        // Create a new bubble for shooting
        function createNewBubble() {
            if (!nextBubble) {
                nextBubble = {
                    color: COLORS[Math.floor(Math.random() * COLORS.length)]
                };
            }
            currentBubble = {
                x: SHOOTER_POS.x,
                y: SHOOTER_POS.y,
                color: nextBubble.color,
                dx: 0,
                dy: 0
            };
            nextBubble = {
                color: COLORS[Math.floor(Math.random() * COLORS.length)]
            };
            shooting = false;
            drawNextBubble();
        }

        // Draw next bubble preview
        function drawNextBubble() {
            nextBubbleCtx.clearRect(0, 0, nextBubbleCanvas.width, nextBubbleCanvas.height);
            nextBubbleCtx.beginPath();
            nextBubbleCtx.arc(20, 20, 18, 0, Math.PI * 2);
            nextBubbleCtx.fillStyle = nextBubble.color;
            nextBubbleCtx.fill();
            nextBubbleCtx.strokeStyle = 'rgba(0, 0, 0, 0.3)';
            nextBubbleCtx.lineWidth = 2;
            nextBubbleCtx.stroke();
        }

        // Draw the game
        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Draw bubbles
            for (let row = 0; row < bubbles.length; row++) {
                for (let col = 0; col < GRID_COLS; col++) {
                    if (bubbles[row][col]) {
                        drawBubble(bubbles[row][col]);
                    }
                }
            }

            // Draw shooter bubble
            if (currentBubble) {
                drawBubble(currentBubble);
            }

            // Draw aiming laser
            if (!shooting && currentBubble) {
                ctx.beginPath();
                ctx.moveTo(SHOOTER_POS.x, SHOOTER_POS.y);
                ctx.lineTo(
                    SHOOTER_POS.x + Math.cos(angle) * canvas.width,
                    SHOOTER_POS.y + Math.sin(angle) * canvas.height
                );
                ctx.strokeStyle = 'rgba(255, 255, 255, 0.4)';
                ctx.lineWidth = 2;
                ctx.setLineDash([5, 5]);
                ctx.stroke();
                ctx.setLineDash([]);
            }
        }

        // Draw a single bubble with shine effect
        function drawBubble(bubble) {
            ctx.beginPath();
            ctx.arc(bubble.x, bubble.y, BUBBLE_RADIUS - 2, 0, Math.PI * 2);
            ctx.fillStyle = bubble.color;
            ctx.fill();

            // Add shine effect
            const gradient = ctx.createRadialGradient(
                bubble.x - BUBBLE_RADIUS * 0.5,
                bubble.y - BUBBLE_RADIUS * 0.5,
                BUBBLE_RADIUS * 0.2,
                bubble.x,
                bubble.y,
                BUBBLE_RADIUS
            );
            gradient.addColorStop(0, 'rgba(255, 255, 255, 0.8)');
            gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');
            ctx.fillStyle = gradient;
            ctx.fill();

            ctx.strokeStyle = 'rgba(0, 0, 0, 0.2)';
            ctx.lineWidth = 2;
            ctx.stroke();
        }

        // Handle mouse movement for aiming
        canvas.addEventListener('mousemove', (e) => {
            if (!shooting && !gameOver) {
                const rect = canvas.getBoundingClientRect();
                const mouseX = e.clientX - rect.left;
                const mouseY = e.clientY - rect.top;
                angle = Math.atan2(mouseY - SHOOTER_POS.y, mouseX - SHOOTER_POS.x);
                angle = Math.max(-Math.PI + MAX_ANGLE, Math.min(-MAX_ANGLE, angle));
            }
        });

        // Handle touch controls
        canvas.addEventListener('touchmove', (e) => {
            if (!shooting && !gameOver) {
                e.preventDefault();
                const rect = canvas.getBoundingClientRect();
                const touch = e.touches[0];
                const touchX = touch.clientX - rect.left;
                const touchY = touch.clientY - rect.top;
                angle = Math.atan2(touchY - SHOOTER_POS.y, touchX - SHOOTER_POS.x);
                angle = Math.max(-Math.PI + MAX_ANGLE, Math.min(-MAX_ANGLE, angle));
            }
        });

        // Handle mouse click to shoot
        canvas.addEventListener('click', () => {
            if (!shooting && !gameOver && currentBubble) {
                shooting = true;
                currentBubble.dx = Math.cos(angle) * BUBBLE_SPEED;
                currentBubble.dy = Math.sin(angle) * BUBBLE_SPEED;
            }
        });

        // Handle touch to shoot
        canvas.addEventListener('touchstart', (e) => {
            if (!shooting && !gameOver && currentBubble) {
                e.preventDefault();
                shooting = true;
                currentBubble.dx = Math.cos(angle) * BUBBLE_SPEED;
                currentBubble.dy = Math.sin(angle) * BUBBLE_SPEED;
            }
        });

        // Update game state
        function update() {
            if (gameOver) return;

            if (shooting && currentBubble) {
                currentBubble.x += currentBubble.dx;
                currentBubble.y += currentBubble.dy;

                // Wall collisions
                if (currentBubble.x - BUBBLE_RADIUS < 0) {
                    currentBubble.x = BUBBLE_RADIUS;
                    currentBubble.dx = -currentBubble.dx;
                } else if (currentBubble.x + BUBBLE_RADIUS > canvas.width) {
                    currentBubble.x = canvas.width - BUBBLE_RADIUS;
                    currentBubble.dx = -currentBubble.dx;
                }

                // Ceiling collision
                if (currentBubble.y - BUBBLE_RADIUS < 0) {
                    snapToGrid();
                    return;
                }

                // Bubble collisions
                for (let row = 0; row < bubbles.length; row++) {
                    for (let col = 0; col < GRID_COLS; col++) {
                        if (bubbles[row][col]) {
                            const dx = currentBubble.x - bubbles[row][col].x;
                            const dy = currentBubble.y - bubbles[row][col].y;
                            const distance = Math.sqrt(dx * dx + dy * dy);
                            if (distance < BUBBLE_DIAMETER - 2) {
                                snapToGrid();
                                return;
                            }
                        }
                    }
                }
            }
        }

        // Snap bubble to grid
        function snapToGrid() {
            shooting = false;
            let row = Math.round(currentBubble.y / BUBBLE_DIAMETER);
            let col = Math.round((currentBubble.x - (row % 2 ? BUBBLE_RADIUS : 0)) / BUBBLE_DIAMETER);

            // Ensure within bounds
            if (row >= GRID_ROWS || currentBubble.y + BUBBLE_RADIUS > canvas.height) {
                gameOver = true;
                finalScoreDisplay.textContent = `Score: ${score}`;
                gameOverDisplay.style.display = 'block';
                return;
            }
            if (col < 0) col = 0;
            if (col >= GRID_COLS) col = GRID_COLS - 1;

            // Add new row if needed
            while (row >= bubbles.length) {
                bubbles.push(new Array(GRID_COLS).fill(null));
            }

            // Place bubble
            bubbles[row][col] = {
                x: col * BUBBLE_DIAMETER + BUBBLE_RADIUS + (row % 2 ? BUBBLE_RADIUS : 0),
                y: row * BUBBLE_DIAMETER + BUBBLE_RADIUS,
                color: currentBubble.color
            };

            // Check for matches
            checkMatches(row, col);

            // Check for level completion
            if (bubbles.every(row => row.every(bubble => !bubble))) {
                level++;
                levelDisplay.textContent = `Level: ${level}`;
                createInitialBubbles();
            }

            createNewBubble();
        }

        // Check for matching bubbles
        function checkMatches(row, col) {
            const color = bubbles[row][col].color;
            const cluster = findCluster(row, col, color);
            if (cluster.length >= 3) {
                cluster.forEach(([r, c]) => {
                    bubbles[r][c] = null;
                    score += 10;
                });
                scoreDisplay.textContent = `Score: ${score}`;
                removeFloatingBubbles();
            }
        }

        // Find connected bubbles of the same color
        function findCluster(row, col, color, visited = new Set()) {
            if (
                row < 0 ||
                row >= bubbles.length ||
                col < 0 ||
                col >= GRID_COLS ||
                !bubbles[row][col] ||
                bubbles[row][col].color !== color ||
                visited.has(`${row},${col}`)
            ) {
                return [];
            }

            visited.add(`${row},${col}`);
            const cluster = [[row, col]];

            const neighbors = [
                [row - 1, col], [row + 1, col],
                [row, col - 1], [row, col + 1],
                [row - 1, col + (row % 2 ? 0 : -1)], [row - 1, col + (row % 2 ? 1 : 0)],
                [row + 1, col + (row % 2 ? 0 : -1)], [row + 1, col + (row % 2 ? 1 : 0)]
            ];

            neighbors.forEach(([r, c]) => {
                cluster.push(...findCluster(r, c, color, visited));
            });

            return cluster;
        }

        // Remove floating bubbles
        function removeFloatingBubbles() {
            const visited = new Set();
            const queue = [];

            // Start from top row
            for (let col = 0; col < GRID_COLS; col++) {
                if (bubbles[0][col]) {
                    queue.push([0, col]);
                    visited.add(`0,${col}`);
                }
            }

            // BFS to find connected bubbles
            while (queue.length) {
                const [row, col] = queue.shift();
                const neighbors = [
                    [row - 1, col], [row + 1, col],
                    [row, col - 1], [row, col + 1],
                    [row - 1, col + (row % 2 ? 0 : -1)], [row - 1, col + (row % 2 ? 1 : 0)],
                    [row + 1, col + (row % 2 ? 0 : -1)], [row + 1, col + (row % 2 ? 1 : 0)]
                ];

                neighbors.forEach(([r, c]) => {
                    if (r >= 0 && r < bubbles.length && c >= 0 && c < GRID_COLS && bubbles[r][c] && !visited.has(`${r},${c}`)) {
                        visited.add(`${r},${c}`);
                        queue.push([r, c]);
                    }
                });
            }

            // Remove unvisited bubbles
            for (let row = 0; row < bubbles.length; row++) {
                for (let col = 0; col < GRID_COLS; col++) {
                    if (bubbles[row][col] && !visited.has(`${row},${col}`)) {
                        bubbles[row][col] = null;
                        score += 5;
                    }
                }
            }
            scoreDisplay.textContent = `Score: ${score}`;
        }

        // Restart the game
        function restartGame() {
            initGame();
        }

        // Game loop
        function gameLoop() {
            update();
            draw();
            requestAnimationFrame(gameLoop);
        }

        // Load Poppins font
        const link = document.createElement('link');
        link.href = 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap';
        link.rel = 'stylesheet';
        document.head.appendChild(link);

        // Start the game
        initGame();
        gameLoop();
    </script>
</body>
</html>