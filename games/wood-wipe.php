<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Word Wipe Puzzle Game</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #4a69bd, #e84393);
            color: #fff;
            overflow-y: auto;
        }

        .game-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            max-width: 700px;
            width: 90%;
            text-align: center;
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            font-size: 2.8em;
            color: #2d3436;
            margin-bottom: 20px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .game-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 1.2em;
            color: #2d3436;
        }

        .game-info span {
            font-weight: bold;
            color: #e84393;
        }

        .target-words {
            background: #f1f2f6;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .target-word {
            background: #dfe6e9;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 1em;
            color: #2d3436;
            transition: background 0.3s, transform 0.3s;
        }

        .target-word.found {
            background: #00b894;
            color: #fff;
            transform: scale(1.1);
        }

        .game-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            background: #dfe6e9;
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .tile {
            width: 70px;
            height: 70px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.8em;
            font-weight: bold;
            color: #2d3436;
            border: 3px solid #b2bec3;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        }

        .tile:hover {
            background: #e0e0e0;
            transform: scale(1.08);
        }

        .tile.selected {
            background: #e84393;
            color: #fff;
            border-color: #d63031;
            transform: scale(1.05);
        }

        .tile.invalid {
            background: #ff7675;
            border-color: #d63031;
            animation: shake 0.3s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-6px); }
            75% { transform: translateX(6px); }
        }

        .current-word {
            font-size: 1.3em;
            margin-bottom: 15px;
            color: #2d3436;
        }

        .word-list {
            max-height: 120px;
            overflow-y: auto;
            margin-bottom: 20px;
            padding: 10px;
            background: #f1f2f6;
            border-radius: 10px;
        }

        .word-list div {
            font-size: 1em;
            color: #2d3436;
            margin: 5px 0;
        }

        button {
            padding: 12px 25px;
            font-size: 1.1em;
            background: #e84393;
            color: #fff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            background: #d63031;
            transform: translateY(-2px);
        }

        .game-over, .success-screen {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .game-over-content, .success-content {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            animation: popIn 0.5s ease;
        }

        @keyframes popIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .game-over-content h2, .success-content h2 {
            font-size: 2.5em;
            color: #2d3436;
            margin-bottom: 15px;
        }

        .game-over-content p, .success-content p {
            font-size: 1.3em;
            color: #2d3436;
            margin-bottom: 20px;
        }

        .success-content {
            background: linear-gradient(135deg, #00b894, #55efc4);
            color: #fff;
        }

        .success-content h2, .success-content p {
            color: #fff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 600px) {
            .tile {
                width: 55px;
                height: 55px;
                font-size: 1.4em;
            }

            h1 {
                font-size: 2.2em;
            }

            .game-info {
                font-size: 1em;
            }

            .target-words {
                font-size: 0.9em;
            }

            button {
                padding: 10px 20px;
                font-size: 1em;
            }
        }
    </style>
</head>
<body>
    <div class="game-container">
        <h1>Word Wipe</h1>
        <div class="game-info">
            <div>Score: <span id="score">0</span></div>
            <div>Time: <span id="timer">2:00</span></div>
            <div>High Score: <span id="high-score">0</span></div>
        </div>
        <div class="target-words" id="target-words"></div>
        <div class="current-word">Word: <span id="current-word"></span></div>
        <div class="game-grid" id="game-grid"></div>
        <div class="word-list" id="word-list"></div>
        <button id="clear-button">Clear</button>
    </div>
    <div class="game-over" id="game-over">
        <div class="game-over-content">
            <h2>Game Over!</h2>
            <p>Final Score: <span id="final-score"></span></p>
            <button id="restart-button">Play Again</button>
        </div>
    </div>
    <div class="success-screen" id="success-screen">
        <div class="success-content">
            <h2>Congratulations!</h2>
            <p>You found all 10 words!</p>
            <p>Final Score: <span id="success-score"></span></p>
            <button id="success-restart">Play Again</button>
        </div>
    </div>

    <script>
        const gridSize = 4;
        const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');
        const minWordLength = 3;
        const gameTime = 120; // 2 minutes in seconds
        let grid = [];
        let selectedTiles = [];
        let currentWord = '';
        let score = 0;
        let highScore = localStorage.getItem('highScore') || 0;
        let timeLeft = gameTime;
        let timerInterval;
        let foundWords = new Set();

        // Predefined 10 words to find
        const targetWords = ['CAT', 'DOG', 'HAT', 'BAT', 'RAT', 'FAST', 'LAST', 'PAST', 'CAST', 'BEST'];
        // Simple dictionary including target words
        const dictionary = new Set([
            ...targetWords,
            'CATS', 'DOGS', 'HATS', 'BATS', 'RATS', 'MATS', 'PATS', 'SATS',
            'ABLE', 'BABE', 'CAKE', 'FAKE', 'LAKE', 'MAKE', 'RAKE', 'TAKE',
            'CANE', 'FANE', 'LANE', 'PANE', 'SANE', 'VANE', 'GAME', 'NAME',
            'TAME', 'LAME', 'FAME', 'CAME', 'SAME', 'DAME', 'BANE', 'JANE'
        ]);

        document.getElementById('high-score').textContent = highScore;

        function initializeGrid() {
            const gameGrid = document.getElementById('game-grid');
            gameGrid.innerHTML = '';
            grid = [];
            // Initialize with a solvable grid
            const solvableGrid = [
                ['C', 'A', 'T', 'S'],
                ['D', 'O', 'G', 'H'],
                ['B', 'A', 'T', 'F'],
                ['R', 'A', 'S', 'T']
            ];
            for (let i = 0; i < gridSize; i++) {
                const row = [];
                for (let j = 0; j < gridSize; j++) {
                    const letter = solvableGrid[i][j] || letters[Math.floor(Math.random() * letters.length)];
                    row.push(letter);
                    const tile = document.createElement('div');
                    tile.classList.add('tile');
                    tile.dataset.row = i;
                    tile.dataset.col = j;
                    tile.textContent = letter;
                    tile.addEventListener('click', () => handleTileClick(i, j));
                    gameGrid.appendChild(tile);
                }
                grid.push(row);
            }
            updateTargetWords();
        }

        function updateTargetWords() {
            const targetWordsDiv = document.getElementById('target-words');
            targetWordsDiv.innerHTML = '';
            targetWords.forEach(word => {
                const div = document.createElement('div');
                div.classList.add('target-word');
                div.textContent = word;
                if (foundWords.has(word)) {
                    div.classList.add('found');
                }
                targetWordsDiv.appendChild(div);
            });
        }

        function handleTileClick(row, col) {
            if (timeLeft <= 0 || foundWords.size === targetWords.length) return;

            const tile = document.querySelector(`.tile[data-row="${row}"][data-col="${col}"]`);
            const lastTile = selectedTiles[selectedTiles.length - 1];

            if (selectedTiles.some(t => t.row === row && t.col === col)) {
                if (selectedTiles.length > 1 && selectedTiles[selectedTiles.length - 2].row === row && selectedTiles[selectedTiles.length - 2].col === col) {
                    const last = selectedTiles.pop();
                    document.querySelector(`.tile[data-row="${last.row}"][data-col="${last.col}"]`).classList.remove('selected');
                    currentWord = currentWord.slice(0, -1);
                }
                updateCurrentWord();
                return;
            }

            if (lastTile && !isAdjacent(lastTile.row, lastTile.col, row, col)) {
                return;
            }

            selectedTiles.push({ row, col });
            tile.classList.add('selected');
            currentWord += grid[row][col];
            updateCurrentWord();

            if (currentWord.length >= minWordLength && dictionary.has(currentWord) && !foundWords.has(currentWord)) {
                submitWord();
            }
        }

        function isAdjacent(row1, col1, row2, col2) {
            const rowDiff = Math.abs(row1 - row2);
            const colDiff = Math.abs(col1 - col2);
            return rowDiff <= 1 && colDiff <= 1 && !(rowDiff === 0 && colDiff === 0);
        }

        function updateCurrentWord() {
            document.getElementById('current-word').textContent = currentWord;
        }

        function submitWord() {
            if (dictionary.has(currentWord) && !foundWords.has(currentWord)) {
                foundWords.add(currentWord);
                const points = currentWord.length * 10;
                score += points;
                document.getElementById('score').textContent = score;
                if (score > highScore) {
                    highScore = score;
                    localStorage.setItem('highScore', highScore);
                    document.getElementById('high-score').textContent = highScore;
                }
                updateWordList();
                updateTargetWords();
                clearSelection(true);
                collapseGrid();
                if (foundWords.size === targetWords.length) {
                    showSuccess();
                }
            } else {
                clearSelection(false);
            }
        }

        function clearSelection(valid) {
            selectedTiles.forEach(({ row, col }) => {
                const tile = document.querySelector(`.tile[data-row="${row}"][data-col="${col}"]`);
                tile.classList.remove('selected');
                if (!valid) {
                    tile.classList.add('invalid');
                    setTimeout(() => tile.classList.remove('invalid'), 300);
                }
            });
            selectedTiles = [];
            currentWord = '';
            updateCurrentWord();
        }

        function collapseGrid() {
            for (let col = 0; col < gridSize; col++) {
                let emptyRow = gridSize - 1;
                for (let row = gridSize - 1; row >= 0; row--) {
                    if (selectedTiles.some(t => t.row === row && t.col === col)) {
                        continue;
                    }
                    grid[emptyRow][col] = grid[row][col];
                    emptyRow--;
                }
                while (emptyRow >= 0) {
                    grid[emptyRow][col] = letters[Math.floor(Math.random() * letters.length)];
                    emptyRow--;
                }
            }
            updateGrid();
        }

        function updateGrid() {
            const tiles = document.querySelectorAll('.tile');
            tiles.forEach(tile => {
                const row = parseInt(tile.dataset.row);
                const col = parseInt(tile.dataset.col);
                tile.textContent = grid[row][col];
            });
        }

        function updateWordList() {
            const wordList = document.getElementById('word-list');
            wordList.innerHTML = '';
            foundWords.forEach(word => {
                const div = document.createElement('div');
                div.textContent = word;
                wordList.appendChild(div);
            });
        }

        function startTimer() {
            timerInterval = setInterval(() => {
                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                document.getElementById('timer').textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    endGame();
                }
            }, 1000);
        }

        function endGame() {
            if (foundWords.size < targetWords.length) {
                document.getElementById('final-score').textContent = score;
                document.getElementById('game-over').style.display = 'flex';
            }
        }

        function showSuccess() {
            clearInterval(timerInterval);
            document.getElementById('success-score').textContent = score;
            document.getElementById('success-screen').style.display = 'flex';
        }

        function startGame() {
            score = 0;
            timeLeft = gameTime;
            foundWords.clear();
            document.getElementById('score').textContent = score;
            document.getElementById('timer').textContent = '2:00';
            document.getElementById('current-word').textContent = '';
            document.getElementById('word-list').innerHTML = '';
            document.getElementById('game-over').style.display = 'none';
            document.getElementById('success-screen').style.display = 'none';
            initializeGrid();
            clearInterval(timerInterval);
            startTimer();
        }

        document.getElementById('clear-button').addEventListener('click', () => clearSelection(false));
        document.getElementById('restart-button').addEventListener('click', startGame);
        document.getElementById('success-restart').addEventListener('click', startGame);

        // Start the game on page load
        startGame();
    </script>
</body>
</html>