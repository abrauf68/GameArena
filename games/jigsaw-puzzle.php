<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jigsaw Puzzle Mania</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #a1c4fd, #c2e9fb);
            padding: 20px;
            overflow: auto;
        }

        h1 {
            color: #fff;
            font-size: 2.3em;
            margin: 20px 0;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }

        .game-container {
            display: flex;
            gap: 30px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            width: 100%;
        }

        .left-section {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .puzzle-container {
            position: relative;
            width: 360px;
            height: 360px;
            background: #fff;
            border: 4px solid #1e1e1e;
            border-radius: 8px;
            overflow: hidden;
        }

        .pieces-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .puzzle-piece {
            position: relative;
            width: 120px;
            height: 120px;
            background-color: #ccc; /* Fallback color */
            border: 2px solid #ff0000; /* Debug border for visibility */
            cursor: grab;
            user-select: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            z-index: 20;
        }

        .puzzle-piece.dragging {
            cursor: grabbing;
            z-index: 100;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            transform: scale(1.1);
        }

        .puzzle-piece.correct {
            border: 2px solid #28a745;
            box-shadow: 0 0 10px rgba(40, 167, 69, 0.7);
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 15px;
            width: 300px;
            background: #e9ecef;
            border-radius: 8px;
            align-items: center;
        }

        .preview {
            width: 180px;
            height: 180px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #1e1e1e;
            position: relative;
        }

        .preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview .loading {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 0.9em;
            color: #fff;
            background: rgba(0, 0, 0, 0.7);
            padding: 8px;
            border-radius: 4px;
        }

        .info {
            text-align: center;
            font-size: 1.1em;
            color: #1e1e1e;
        }

        .info p {
            margin: 10px 0;
        }

        button {
            padding: 12px 30px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
            transition: background 0.3s, transform 0.2s;
        }

        button:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }

        .win-message {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.8);
            background: rgba(40, 167, 69, 0.95);
            color: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            text-align: center;
            z-index: 1000;
            animation: slideIn 0.3s ease forwards;
        }

        .win-message.show {
            display: block;
        }

        @keyframes slideIn {
            to {
                transform: translate(-50%, -50%) scale(1);
            }
        }

        @media (max-width: 768px) {
            .game-container {
                flex-direction: column;
                align-items: center;
            }

            .puzzle-container {
                width: 300px;
                height: 300px;
            }

            .puzzle-piece {
                width: 100px;
                height: 100px;
            }

            .sidebar {
                width: 100%;
                max-width: 300px;
            }

            .preview {
                width: 150px;
                height: 150px;
            }
        }
    </style>
</head>
<body>
    <h1>Jigsaw Puzzle Mania</h1>
    <div class="game-container">
        <div class="left-section">
            <div class="puzzle-container" id="puzzle-container"></div>
            <div class="pieces-container" id="pieces-container"></div>
        </div>
        <div class="sidebar">
            <div class="preview">
                <img id="puzzle-image" src="test.png" alt="Puzzle Image">
                <div class="loading" id="image-loading">Loading...</div>
            </div>
            <div class="info">
                <p>Time: <span id="timer">00:00</span></p>
                <p>Moves: <span id="move-counter">0</span></p>
            </div>
            <button id="start-btn">Start Game</button>
        </div>
    </div>
    <div class="win-message" id="win-message">
        <h2>You Solved It!</h2>
        <p>Time: <span id="final-time"></span> | Moves: <span id="final-moves"></span></p>
        <button id="restart-btn">Play Again</button>
    </div>

    <script>
        const puzzleContainer = document.getElementById('puzzle-container');
        const piecesContainer = document.getElementById('pieces-container');
        const startBtn = document.getElementById('start-btn');
        const timerDisplay = document.getElementById('timer');
        const moveCounter = document.getElementById('move-counter');
        const winMessage = document.getElementById('win-message');
        const finalTime = document.getElementById('final-time');
        const finalMoves = document.getElementById('final-moves');
        const restartBtn = document.getElementById('restart-btn');
        const puzzleImage = document.getElementById('puzzle-image');
        const imageLoading = document.getElementById('image-loading');

        const gridSize = 3;
        let pieceSize = 360 / gridSize; // 120px for 360x360 container
        let pieces = [];
        let moves = 0;
        let timer;
        let seconds = 0;
        let gameStarted = false;

        // Shuffle array function
        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        // Handle image loading
        puzzleImage.onerror = () => {
            console.error('Image failed to load, using fallback');
            puzzleImage.src = 'https://via.placeholder.com/360';
            imageLoading.style.display = 'none';
            createPuzzle();
        };
        puzzleImage.onload = () => {
            imageLoading.style.display = 'none';
            createPuzzle();
        };
        if (!puzzleImage.complete) {
            imageLoading.style.display = 'block';
        }

        function createPuzzle() {
            puzzleContainer.innerHTML = '';
            piecesContainer.innerHTML = '';
            pieces = [];
            pieceSize = puzzleContainer.offsetWidth / gridSize; // Adjust for responsive size
            const imageUrl = puzzleImage.src;

            // Create pieces
            for (let i = 0; i < gridSize * gridSize; i++) {
                const piece = document.createElement('div');
                piece.classList.add('puzzle-piece');
                piece.style.width = `${pieceSize}px`;
                piece.style.height = `${pieceSize}px`;
                piece.style.backgroundImage = `url(${imageUrl})`;
                piece.style.backgroundSize = `${puzzleContainer.offsetWidth}px ${puzzleContainer.offsetHeight}px`;
                const row = Math.floor(i / gridSize);
                const col = i % gridSize;
                piece.style.backgroundPosition = `-${col * pieceSize}px -${row * pieceSize}px`;
                piece.dataset.index = i;
                piece.dataset.correctRow = row;
                piece.dataset.correctCol = col;
                pieces.push(piece);
                console.log(`Piece ${i} created`);
            }

            // Shuffle and append pieces
            shuffleArray(pieces);
            pieces.forEach(piece => {
                piecesContainer.appendChild(piece);
                makeDraggable(piece);
            });
            console.log('Pieces shuffled and appended to pieces-container');
        }

        function makeDraggable(piece) {
            let offsetX, offsetY, isDragging = false;

            piece.addEventListener('mousedown', (e) => {
                if (!gameStarted) return;
                isDragging = true;
                piece.classList.add('dragging');
                const rect = piece.getBoundingClientRect();
                offsetX = e.clientX - rect.left;
                offsetY = e.clientY - rect.top;
                piece.style.position = 'absolute';
                document.body.appendChild(piece);
                e.preventDefault();
            });

            document.addEventListener('mousemove', (e) => {
                if (isDragging) {
                    piece.style.left = `${e.clientX - offsetX}px`;
                    piece.style.top = `${e.clientY - offsetY}px`;
                }
            });

            document.addEventListener('mouseup', () => {
                if (isDragging) {
                    isDragging = false;
                    piece.classList.remove('dragging');
                    snapToGrid(piece);
                    moves++;
                    moveCounter.textContent = moves;
                    checkWin();
                }
            });

            // Touch support
            piece.addEventListener('touchstart', (e) => {
                if (!gameStarted) return;
                isDragging = true;
                piece.classList.add('dragging');
                const touch = e.touches[0];
                const rect = piece.getBoundingClientRect();
                offsetX = touch.clientX - rect.left;
                offsetY = touch.clientY - rect.top;
                piece.style.position = 'absolute';
                document.body.appendChild(piece);
                e.preventDefault();
            });

            document.addEventListener('touchmove', (e) => {
                if (isDragging) {
                    const touch = e.touches[0];
                    piece.style.left = `${touch.clientX - offsetX}px`;
                    piece.style.top = `${touch.clientY - offsetY}px`;
                    e.preventDefault();
                }
            });

            document.addEventListener('touchend', () => {
                if (isDragging) {
                    isDragging = false;
                    piece.classList.remove('dragging');
                    snapToGrid(piece);
                    moves++;
                    moveCounter.textContent = moves;
                    checkWin();
                }
            });
        }

        function snapToGrid(piece) {
            const containerRect = puzzleContainer.getBoundingClientRect();
            const pieceRect = piece.getBoundingClientRect();
            const relativeX = pieceRect.left - containerRect.left;
            const relativeY = pieceRect.top - containerRect.top;

            const col = Math.round(relativeX / pieceSize);
            const row = Math.round(relativeY / pieceSize);

            if (col >= 0 && col < gridSize && row >= 0 && row < gridSize) {
                puzzleContainer.appendChild(piece);
                piece.style.left = `${col * pieceSize}px`;
                piece.style.top = `${row * pieceSize}px`;
                piece.dataset.currentRow = row;
                piece.dataset.currentCol = col;

                if (row == piece.dataset.correctRow && col == piece.dataset.correctCol) {
                    piece.classList.add('correct');
                } else {
                    piece.classList.remove('correct');
                }
            } else {
                piecesContainer.appendChild(piece);
                piece.style.position = 'relative';
                piece.style.left = '0';
                piece.style.top = '0';
            }
        }

        function checkWin() {
            const allCorrect = pieces.every(piece =>
                piece.dataset.currentRow == piece.dataset.correctRow &&
                piece.dataset.currentCol == piece.dataset.correctCol
            );

            if (allCorrect) {
                clearInterval(timer);
                winMessage.classList.add('show');
                finalTime.textContent = timerDisplay.textContent;
                finalMoves.textContent = moves;
                gameStarted = false;
            }
        }

        function startTimer() {
            clearInterval(timer);
            seconds = 0;
            timerDisplay.textContent = '00:00';
            timer = setInterval(() => {
                seconds++;
                const minutes = Math.floor(seconds / 60);
                const secs = seconds % 60;
                timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            }, 1000);
        }

        startBtn.addEventListener('click', () => {
            createPuzzle();
            moves = 0;
            moveCounter.textContent = moves;
            startTimer();
            gameStarted = true;
            winMessage.classList.remove('show');
        });

        restartBtn.addEventListener('click', () => {
            createPuzzle();
            moves = 0;
            moveCounter.textContent = moves;
            startTimer();
            gameStarted = true;
            winMessage.classList.remove('show');
        });

        // Initialize puzzle
        if (puzzleImage.complete) {
            imageLoading.style.display = 'none';
            createPuzzle();
        }
    </script>
</body>
</html>