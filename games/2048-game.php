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

        .game-container {
            text-align: center;
            background: #1e293b;
            padding: 16px;
            border-radius: 16px;
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.4);
            max-width: 500px;
            width: 90%;
            margin: 0 auto;
            border: 1px solid #334155;
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
        }

        .game-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 50% 0%, rgba(59, 130, 246, 0.25), transparent 70%);
            z-index: -1;
        }

        h1 {
            color: #ffffff;
            font-size: 2em;
            margin: 10px 0;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .score-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .score-box {
            background: #334155;
            color: #e2e8f0;
            padding: 8px;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 500;
            width: 100px;
            text-align: center;
            border: 1px solid #475569;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .score-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .grid-container {
            width: 100%;
            aspect-ratio: 1/1;
            background: #1e293b;
            border-radius: 8px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            padding: 10px;
            border: 1px solid #334155;
        }

        .tile {
            background: #334155;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.2em;
            font-weight: 600;
            color: #f1f5f9;
            transition: all 0.2s ease-in-out;
            position: relative;
            user-select: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .tile-2 {
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
        }

        .tile-4 {
            background: linear-gradient(135deg, #60a5fa, #93c5fd);
        }

        .tile-8 {
            background: linear-gradient(135deg, #f97316, #fb923c);
            color: #ffffff;
        }

        .tile-16 {
            background: linear-gradient(135deg, #fb923c, #fdba74);
            color: #ffffff;
        }

        .tile-32 {
            background: linear-gradient(135deg, #f43f5e, #fb7185);
            color: #ffffff;
        }

        .tile-64 {
            background: linear-gradient(135deg, #e11d48, #f43f5e);
            color: #ffffff;
        }

        .tile-128 {
            background: linear-gradient(135deg, #eab308, #facc15);
            color: #ffffff;
        }

        .tile-256 {
            background: linear-gradient(135deg, #facc15, #fef08a);
            color: #ffffff;
        }

        .tile-512 {
            background: linear-gradient(135deg, #22c55e, #4ade80);
            color: #ffffff;
        }

        .tile-1024 {
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: #ffffff;
        }

        .tile-2048 {
            background: linear-gradient(135deg, #047857, #059669);
            color: #ffffff;
        }

        .tile-merged {
            animation: pop 0.25s ease;
        }

        .tile-new {
            animation: appear 0.25s ease;
        }

        @keyframes pop {
            0% {
                transform: scale(0.85);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes appear {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .game-message {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.85);
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: #ffffff;
            font-size: 1.8em;
            text-align: center;
            z-index: 10;
            backdrop-filter: blur(8px);
        }

        .game-message p {
            margin-bottom: 16px;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .game-message button {
            width: 48px;
            height: 48px;
            font-size: 1.5em;
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .game-message button:hover {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
        }

        .game-message button::before {
            content: '⟲';
        }

        .controls {
            margin-top: 12px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .controls button {
            width: 48px;
            height: 48px;
            font-size: 1.5em;
            background: #334155;
            color: #f1f5f9;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .controls button:hover {
            background: #475569;
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
        }

        .controls button.up::before {
            content: '➔';
            transform: rotate(-90deg);
        }

        .controls button.down::before {
            content: '➔';
            transform: rotate(90deg);
        }

        .controls button.left::before {
            content: '➔';
            transform: rotate(180deg);
        }

        .controls button.right::before {
            content: '➔';
        }

        .controls button.restart::before {
            content: '⟲';
        }

        .controls button.restart {
            background: linear-gradient(135deg, #ef4444, #f87171);
        }

        .controls button.restart:hover {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.4);
        }

        @media (max-width: 500px) {
            h1 {
                font-size: 1.6em;
            }

            .score-box {
                font-size: 0.9em;
                width: 90px;
            }

            .tile {
                font-size: 1em;
            }

            .controls button {
                width: 40px;
                height: 40px;
                font-size: 1.2em;
            }

            .game-message {
                font-size: 1.4em;
            }

            .game-message button {
                width: 40px;
                height: 40px;
                font-size: 1.2em;
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
                <h1>2048</h1>
                <div class="score-container">
                    <div class="score-box">Score: <span id="score">0</span></div>
                    <div class="score-box">Best: <span id="best">0</span></div>
                </div>
                <div class="grid-container" id="grid">
                    <!-- Grid tiles will be generated by JavaScript -->
                </div>
                <div class="controls">
                    <button class="left" onclick="move('left')"></button>
                    <button class="up" onclick="move('up')"></button>
                    <button class="down" onclick="move('down')"></button>
                    <button class="right" onclick="move('right')"></button>
                    <button class="restart" onclick="restartGame()"></button>
                </div>
                <div class="game-message" id="game-over">
                    <p>Game Over!</p>
                    <button onclick="restartGame()"></button>
                </div>
                <div class="game-message" id="game-won">
                    <p>You Win!</p>
                    <button onclick="restartGame()"></button>
                </div>
            </div>
        </main>
        <!-- main end -->
    </div>
    <!-- app layout end -->

    <script>
        const grid = document.getElementById('grid');
        const scoreDisplay = document.getElementById('score');
        const bestDisplay = document.getElementById('best');
        const gameOverMessage = document.getElementById('game-over');
        const gameWonMessage = document.getElementById('game-won');
        let board = [];
        let score = 0;
        let bestScore = localStorage.getItem('bestScore') ? parseInt(localStorage.getItem('bestScore')) : 0;
        let gameWon = false;

        bestDisplay.textContent = bestScore;

        function initBoard() {
            board = Array(4).fill().map(() => Array(4).fill(0));
            for (let i = 0; i < 16; i++) {
                const tile = document.createElement('div');
                tile.classList.add('tile');
                grid.appendChild(tile);
            }
            addNewTile();
            addNewTile();
            updateBoard();
        }

        function addNewTile() {
            const emptyCells = [];
            for (let i = 0; i < 4; i++) {
                for (let j = 0; j < 4; j++) {
                    if (board[i][j] === 0) emptyCells.push([i, j]);
                }
            }
            if (emptyCells.length > 0) {
                const [i, j] = emptyCells[Math.floor(Math.random() * emptyCells.length)];
                board[i][j] = Math.random() < 0.9 ? 2 : 4;
            }
        }

        function updateBoard() {
            const tiles = grid.children;
            for (let i = 0; i < 4; i++) {
                for (let j = 0; j < 4; j++) {
                    const tile = tiles[i * 4 + j];
                    const value = board[i][j];
                    tile.textContent = value === 0 ? '' : value;
                    tile.className = 'tile';
                    if (value > 0) {
                        tile.classList.add(`tile-${value}`);
                        if (value === 2048 && !gameWon) {
                            gameWon = true;
                            gameWonMessage.style.display = 'flex';
                        }
                    }
                }
            }
            scoreDisplay.textContent = score;
            if (score > bestScore) {
                bestScore = score;
                localStorage.setItem('bestScore', bestScore);
                bestDisplay.textContent = bestScore;
            }
            if (!canMove()) {
                gameOverMessage.style.display = 'flex';
            }
        }

        function move(direction) {
            if (gameWon || gameOverMessage.style.display === 'flex') return;
            let moved = false;
            const newBoard = board.map(row => [...row]);

            if (direction === 'up') {
                for (let j = 0; j < 4; j++) {
                    let k = 0;
                    for (let i = 1; i < 4; i++) {
                        if (newBoard[i][j] !== 0) {
                            let ni = i;
                            while (ni > 0 && newBoard[ni - 1][j] === 0) {
                                newBoard[ni - 1][j] = newBoard[ni][j];
                                newBoard[ni][j] = 0;
                                ni--;
                                moved = true;
                            }
                            if (ni > 0 && newBoard[ni - 1][j] === newBoard[ni][j]) {
                                newBoard[ni - 1][j] *= 2;
                                score += newBoard[ni - 1][j];
                                newBoard[ni][j] = 0;
                                moved = true;
                            }
                        }
                    }
                }
            } else if (direction === 'down') {
                for (let j = 0; j < 4; j++) {
                    for (let i = 2; i >= 0; i--) {
                        if (newBoard[i][j] !== 0) {
                            let ni = i;
                            while (ni < 3 && newBoard[ni + 1][j] === 0) {
                                newBoard[ni + 1][j] = newBoard[ni][j];
                                newBoard[ni][j] = 0;
                                ni++;
                                moved = true;
                            }
                            if (ni < 3 && newBoard[ni + 1][j] === newBoard[ni][j]) {
                                newBoard[ni + 1][j] *= 2;
                                score += newBoard[ni + 1][j];
                                newBoard[ni][j] = 0;
                                moved = true;
                            }
                        }
                    }
                }
            } else if (direction === 'left') {
                for (let i = 0; i < 4; i++) {
                    let k = 0;
                    for (let j = 1; j < 4; j++) {
                        if (newBoard[i][j] !== 0) {
                            let nj = j;
                            while (nj > 0 && newBoard[i][nj - 1] === 0) {
                                newBoard[i][nj - 1] = newBoard[i][nj];
                                newBoard[i][nj] = 0;
                                nj--;
                                moved = true;
                            }
                            if (nj > 0 && newBoard[i][nj - 1] === newBoard[i][nj]) {
                                newBoard[i][nj - 1] *= 2;
                                score += newBoard[i][nj - 1];
                                newBoard[i][nj] = 0;
                                moved = true;
                            }
                        }
                    }
                }
            } else if (direction === 'right') {
                for (let i = 0; i < 4; i++) {
                    for (let j = 2; j >= 0; j--) {
                        if (newBoard[i][j] !== 0) {
                            let nj = j;
                            while (nj < 3 && newBoard[i][nj + 1] === 0) {
                                newBoard[i][nj + 1] = newBoard[i][nj];
                                newBoard[i][nj] = 0;
                                nj++;
                                moved = true;
                            }
                            if (nj < 3 && newBoard[i][nj + 1] === newBoard[i][nj]) {
                                newBoard[i][nj + 1] *= 2;
                                score += newBoard[i][nj + 1];
                                newBoard[i][nj] = 0;
                                moved = true;
                            }
                        }
                    }
                }
            }

            if (moved) {
                board = newBoard;
                addNewTile();
                updateBoard();
            }
        }

        function canMove() {
            for (let i = 0; i < 4; i++) {
                for (let j = 0; j < 4; j++) {
                    if (board[i][j] === 0) return true;
                    if (i < 3 && board[i][j] === board[i + 1][j]) return true;
                    if (j < 3 && board[i][j] === board[i][j + 1]) return true;
                }
            }
            return false;
        }

        function restartGame() {
            board = Array(4).fill().map(() => Array(4).fill(0));
            score = 0;
            gameWon = false;
            gameOverMessage.style.display = 'none';
            gameWonMessage.style.display = 'none';
            grid.innerHTML = '';
            initBoard();
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowUp') move('up');
            else if (e.key === 'ArrowDown') move('down');
            else if (e.key === 'ArrowLeft') move('left');
            else if (e.key === 'ArrowRight') move('right');
        });

        let touchStartX = 0;
        let touchStartY = 0;

        document.addEventListener('touchstart', (e) => {
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
        });

        document.addEventListener('touchend', (e) => {
            const touchEndX = e.changedTouches[0].clientX;
            const touchEndY = e.changedTouches[0].clientY;
            const dx = touchEndX - touchStartX;
            const dy = touchEndY - touchStartY;

            if (Math.abs(dx) > Math.abs(dy)) {
                if (dx > 50) move('right');
                else if (dx < -50) move('left');
            } else {
                if (dy > 50) move('down');
                else if (dy < -50) move('up');
            }
        });

        initBoard();
    </script>
</body>

</html>