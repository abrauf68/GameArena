<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Match - Enhanced</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --dark-bg: #121826;
            --darker-bg: #0d1117;
            --card-bg: #1f2937;
            --accent: #7c3aed;
            --accent-hover: #6d28d9;
            --success: #10b981;
            --text-primary: #f9fafb;
            --text-secondary: #d1d5db;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, var(--darker-bg), var(--dark-bg));
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-primary);
            overflow-x: hidden;
            padding: 1rem;
        }

        .container {
            max-width: 1200px;
            width: 100%;
        }

        .card-container {
            display: grid;
            gap: 10px;
            max-width: 100%;
            margin: 0 auto;
            perspective: 1000px;
        }

        .card {
            aspect-ratio: 1;
            background: #fff;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: clamp(1.5rem, 4vw, 2rem);
            cursor: pointer;
            transform-style: preserve-3d;
            transition: transform 0.4s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .card.flipped {
            transform: rotateY(180deg);
        }

        .card.matched {
            opacity: 0.7;
            transform: scale(0.95);
            box-shadow: 0 0 15px var(--success);
        }

        .card .front,
        .card .back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
        }

        .card .front {
            background: var(--card-bg);
            color: white;
            transform: rotateY(180deg);
        }

        .card .back {
            background: linear-gradient(135deg, #374151, #1f2937);
        }

        .card .back i {
            font-size: 1.5rem;
            color: #4b5563;
        }

        .theme-emoji .card .front {
            font-size: 6.8rem;
        }

        .theme-number .card .front {
            font-size: 6.8rem;
        }

        .theme-color .card .front {
            font-size: 0;
            border: none;
        }

        .theme-color .card .front::before {
            content: '';
            width: 90%;
            height: 90%;
            border-radius: 6px;
        }

        .game-board {
            padding: 10px;
            scrollbar-width: thin;
            overflow: hidden;
        }

        .stats-card {
            background: rgba(31, 41, 55, 0.7);
            border-radius: 12px;
            padding: 1rem;
            backdrop-filter: blur(10px);
            border: 1px solid #374151;
        }

        .btn {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 6px rgba(124, 58, 237, 0.2);
        }

        .btn:hover {
            background: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(124, 58, 237, 0.3);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--accent);
            color: var(--accent);
        }

        .btn-outline:hover {
            background: rgba(124, 58, 237, 0.1);
        }

        .controls {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        select,
        .size-selector {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 2px solid #374151;
            background: rgba(31, 41, 55, 0.7);
            color: var(--text-primary);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        select:focus,
        .size-selector:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.3);
        }

        .size-selector {
            display: flex;
            gap: 0.5rem;
        }

        .size-btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            background: #374151;
            cursor: pointer;
            transition: all 0.2s;
        }

        .size-btn:hover {
            background: #4b5563;
        }

        .size-btn.active {
            background: var(--accent);
        }

        .progress-bar {
            height: 8px;
            background: #374151;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .progress {
            height: 100%;
            background: var(--accent);
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        @media (max-width: 768px) {
            .controls {
                flex-direction: column;
                align-items: center;
            }

            .size-selector {
                width: 100%;
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .theme-emoji .card .front,
            .theme-number .card .front {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 480px) {
            .btn {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }

            select,
            .size-btn {
                padding: 0.6rem 0.8rem;
            }

            .theme-emoji .card .front,
            .theme-number .card .front {
                font-size: 1.2rem;
            }
        }

        .flip-in {
            animation: flipIn 0.5s ease;
        }

        @keyframes flipIn {
            0% {
                transform: rotateY(0);
            }

            50% {
                transform: rotateY(90deg);
            }

            100% {
                transform: rotateY(180deg);
            }
        }

        .pulse {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        .win-animation {
            animation: winAnimation 1s ease;
        }

        @keyframes winAnimation {
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .header-gradient {
            background: linear-gradient(135deg, #8B5CF6, #EC4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .card-grid {
            display: grid;
            gap: 0.5rem;
            justify-content: center;
        }

        .card-container {
            display: grid;
            gap: 0.8rem;
            width: 100%;
        }

        .popup {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .popup.hidden {
            display: none;
        }

        .popup-content {
            background: #fff;
            border-radius: 12px;
            padding: 25px 30px;
            text-align: center;
            max-width: 90%;
            width: 400px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            animation: popup-in 0.3s ease-out;
        }

        .popup-content h2 {
            margin-bottom: 10px;
            font-size: 24px;
            color: #333;
        }

        .popup-content p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }

        #popupButton {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
        }

        #popupButton:hover {
            background-color: #0056b3;
        }

        @keyframes popup-in {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="container mx-auto p-4 max-w-6xl w-full">
        <div class="text-center mb-8">
            <h1 class="text-4xl sm:text-5xl font-bold mb-2 header-gradient">Memory Match Pro</h1>
            <p class="text-gray-400 max-w-2xl mx-auto">Test your memory with this enhanced matching game featuring
                multiple themes, grid sizes and smooth gameplay</p>
        </div>

        <div class="controls">
            <select id="theme" class="flex-1 max-w-xs">
                <option value="number">Numbers</option>
                <option value="emoji">Emojis</option>
                <option value="color">Colors</option>
            </select>

            <div class="size-selector">
                <div class="size-btn active" data-size="4">4x4</div>
                <div class="size-btn" data-size="6">6x6</div>
                <div class="size-btn" data-size="8">8x8</div>
            </div>

            <button id="startBtn" class="btn">
                <i class="fas fa-play"></i> Start Game
            </button>

            <button id="hintBtn" class="btn btn-outline">
                <i class="fas fa-lightbulb"></i> Hint
            </button>
        </div>

        <div class="stats-grid">
            <div class="stats-card">
                <div class="flex justify-between items-center">
                    <span class="text-gray-400"><i class="fas fa-shoe-prints mr-2"></i>Moves</span>
                    <span id="moves" class="text-xl font-bold">0</span>
                </div>
                <div class="progress-bar mt-2">
                    <div class="progress" id="movesProgress" style="width: 0%"></div>
                </div>
            </div>

            <div class="stats-card">
                <div class="flex justify-between items-center">
                    <span class="text-gray-400"><i class="fas fa-clock mr-2"></i>Time</span>
                    <span id="timer" class="text-xl font-bold">0s</span>
                </div>
                <div class="progress-bar mt-2">
                    <div class="progress" id="timeProgress" style="width: 0%"></div>
                </div>
            </div>

            <div class="stats-card">
                <div class="flex justify-between items-center">
                    <span class="text-gray-400"><i class="fas fa-star mr-2"></i>Matches</span>
                    <span id="matches" class="text-xl font-bold">0</span>
                </div>
                <div class="progress-bar mt-2">
                    <div class="progress" id="matchesProgress" style="width: 0%"></div>
                </div>
            </div>
        </div>

        <div class="card-container" id="gameBoard"></div>
    </div>

    <div id="customPopup" class="popup hidden">
        <div class="popup-content">
            <h2 id="popupTitle"></h2>
            <p id="popupMessage"></p>
            <button id="popupButton">OK</button>
        </div>
    </div>


    <script>
        const gameBoard = document.getElementById('gameBoard');
        const movesDisplay = document.getElementById('moves');
        const timerDisplay = document.getElementById('timer');
        const matchesDisplay = document.getElementById('matches');
        const themeSelect = document.getElementById('theme');
        const startBtn = document.getElementById('startBtn');
        const hintBtn = document.getElementById('hintBtn');
        const sizeBtns = document.querySelectorAll('.size-btn');
        const movesProgress = document.getElementById('movesProgress');
        const timeProgress = document.getElementById('timeProgress');
        const matchesProgress = document.getElementById('matchesProgress');

        let cards = [];
        let flippedCards = [];
        let moves = 0;
        let matches = 0;
        let timer = 0;
        let timerInterval;
        let isGameActive = false;
        let gridSize = 4;
        let totalPairs = 8;
        let maxTime = 180; // 3 minutes
        let maxMoves = 50;
        let hintUsed = false;

        // Emojis for the game
        const emojis = ['😺', '🐶', '🦊', '🐻', '🐼', '🐨', '🐯', '🦁', '🐮', '🐷', '🐸', '🐙', '🦄', '🐝', '🦋', '🐢', '🐍', '🦖', '🦅', '🦉', '🦇', '🐧', '🐘', '🦏', '🦒', '🦘', '🐫', '🦩', '🦚', '🦜', '🐿️', '🦔', '🦡', '🐇', '🦝', '🦨', '🦦', '🦫', '🐀', '🐁'];

        // Colors for the game
        const colors = [
            '#FF6B6B', '#4ECDC4', '#45B7D1', '#FFBE0B', '#FB5607', '#FF006E',
            '#8338EC', '#3A86FF', '#06D6A0', '#118AB2', '#073B4C', '#EF476F',
            '#F78C6B', '#FFD166', '#118AB2', '#073B4C', '#7209B7', '#3A0CA3',
            '#4361EE', '#4CC9F0', '#F72585', '#B5179E', '#560BAD', '#4895EF',
            '#4CC9F0', '#F15BB5', '#FEE440', '#00BBF9', '#00F5D4', '#9B5DE5'
        ];

        // Initialize the game
        function initGame() {
            resetGame();
            createBoard();
            document.body.classList.add(`theme-${themeSelect.value}`);
        }

        // Reset game state
        function resetGame() {
            cards = [];
            flippedCards = [];
            moves = 0;
            matches = 0;
            timer = 0;
            hintUsed = false;
            movesDisplay.textContent = moves;
            matchesDisplay.textContent = matches;
            timerDisplay.textContent = timer;
            clearInterval(timerInterval);
            isGameActive = false;
            updateProgressBars();
        }

        // Create the game board
        function createBoard() {
            gameBoard.innerHTML = '';
            totalPairs = (gridSize * gridSize) / 2;
            gameBoard.style.gridTemplateColumns = `repeat(${gridSize}, minmax(60px, 1fr))`;

            let values = [];
            if (themeSelect.value === 'number') {
                values = Array.from({ length: totalPairs }, (_, i) => i + 1);
            } else if (themeSelect.value === 'emoji') {
                values = emojis.slice(0, totalPairs);
            } else {
                values = colors.slice(0, totalPairs);
            }

            // Duplicate and shuffle values
            values = [...values, ...values].sort(() => Math.random() - 0.5);

            // Create card elements
            values.forEach((value, index) => {
                const card = document.createElement('div');
                card.classList.add('card');
                card.dataset.value = value;
                card.dataset.index = index;

                const back = document.createElement('div');
                back.classList.add('back');
                back.innerHTML = '<i class="fas fa-question"></i>';

                const front = document.createElement('div');
                front.classList.add('front');

                if (themeSelect.value === 'color') {
                    front.style.backgroundColor = value;
                } else {
                    front.textContent = value;
                }

                card.appendChild(back);
                card.appendChild(front);
                card.addEventListener('click', () => flipCard(card));

                gameBoard.appendChild(card);
                cards.push(card);
            });
        }

        // Flip a card
        function flipCard(card) {
            if (!isGameActive ||
                card.classList.contains('flipped') ||
                card.classList.contains('matched') ||
                flippedCards.length >= 2) return;

            card.classList.add('flipped');
            flippedCards.push(card);

            if (flippedCards.length === 2) {
                moves++;
                movesDisplay.textContent = moves;
                setTimeout(checkMatch, 300);
            }

            updateProgressBars();
        }

        // Check if flipped cards match
        function checkMatch() {
            const [card1, card2] = flippedCards;

            if (card1.dataset.value === card2.dataset.value) {
                // Match found
                matches++;
                matchesDisplay.textContent = matches;

                card1.classList.add('matched');
                card2.classList.add('matched');

                setTimeout(() => {
                    card1.classList.add('pulse');
                    card2.classList.add('pulse');
                }, 50);

                flippedCards = [];

                // Check for win
                if (matches === totalPairs) {
                    setTimeout(endGame, 500);
                }
            } else {
                // No match
                isGameActive = false;
                setTimeout(() => {
                    card1.classList.remove('flipped');
                    card2.classList.remove('flipped');
                    flippedCards = [];
                    isGameActive = true;
                }, 600);
            }
        }

        // Start the game
        function startGame() {
            resetGame();
            isGameActive = true;

            // Set max moves based on grid size
            maxMoves = gridSize * gridSize * 1.5;
            maxTime = gridSize * 15;

            // Update body class
            document.body.className = `theme-${themeSelect.value}`;

            // Start timer
            timerInterval = setInterval(() => {
                timer++;
                timerDisplay.textContent = timer;
                updateProgressBars();

                // Check for time limit
                if (timer >= maxTime) {
                    endGame(false);
                }
            }, 1000);

            createBoard();
        }

        function showPopup(title, message, buttonText = 'OK', callback = null) {
            const popup = document.getElementById('customPopup');
            document.getElementById('popupTitle').innerText = title;
            document.getElementById('popupMessage').innerHTML = message;
            const button = document.getElementById('popupButton');
            button.innerText = buttonText;
            popup.classList.remove('hidden');

            button.onclick = () => {
                popup.classList.add('hidden');
                if (callback) callback();
            };
        }


        // End the game
        // function endGame(isWin = true) {
        //     isGameActive = false;
        //     clearInterval(timerInterval);

        //     if (isWin) {
        //         // Add win animation to all cards
        //         cards.forEach(card => {
        //             card.classList.add('win-animation');
        //         });

        //         setTimeout(() => {
        //             const stars = Math.max(1, 3 - Math.floor(moves / maxMoves * 3));
        //             alert(`🏆 You won in ${moves} moves and ${timer} seconds!\n⭐ Rating: ${'★'.repeat(stars)}${'☆'.repeat(3 - stars)}`);
        //         }, 1000);
        //     } else {
        //         alert(`⏱️ Time's up! You matched ${matches} pairs. Try again!`);
        //     }
        // }

        function endGame(isWin = true) {
            isGameActive = false;
            clearInterval(timerInterval);

            if (isWin) {
                cards.forEach(card => {
                    card.classList.add('win-animation');
                });

                setTimeout(() => {
                    const stars = Math.max(1, 3 - Math.floor(moves / maxMoves * 3));
                    const starsHTML = '★'.repeat(stars) + '☆'.repeat(3 - stars);

                    showPopup(
                        '🏆 You Won!',
                        `You finished in <b>${moves}</b> moves and <b>${timer}</b> seconds.<br>
                 <div style="font-size: 24px; margin-top: 10px;">⭐ Rating: ${starsHTML}</div>`,
                        'Play Again'
                    );
                }, 1000);
            } else {
                showPopup(
                    '⏱️ Time\'s Up!',
                    `You matched <b>${matches}</b> pairs. Try again!`,
                    'Retry'
                );
            }
        }


        // Provide a hint
        function showHint() {
            if (!isGameActive || hintUsed || matches === totalPairs) return;

            hintUsed = true;

            // Find a pair that hasn't been matched yet
            const unmatchedCards = cards.filter(card =>
                !card.classList.contains('matched') &&
                !card.classList.contains('flipped')
            );

            if (unmatchedCards.length < 2) return;

            // Group by value
            const cardGroups = {};
            unmatchedCards.forEach(card => {
                const val = card.dataset.value;
                if (!cardGroups[val]) cardGroups[val] = [];
                cardGroups[val].push(card);
            });

            // Find a pair
            for (const [val, group] of Object.entries(cardGroups)) {
                if (group.length >= 2) {
                    // Temporarily show the cards
                    group[0].classList.add('flipped');
                    group[1].classList.add('flipped');

                    setTimeout(() => {
                        group[0].classList.remove('flipped');
                        group[1].classList.remove('flipped');
                    }, 1000);

                    break;
                }
            }
        }

        // Update progress bars
        function updateProgressBars() {
            movesProgress.style.width = `${Math.min(100, moves / maxMoves * 100)}%`;
            timeProgress.style.width = `${Math.min(100, timer / maxTime * 100)}%`;
            matchesProgress.style.width = `${Math.min(100, matches / totalPairs * 100)}%`;

            // Change color based on progress
            movesProgress.style.background = moves > maxMoves * 0.75 ? '#ef4444' : moves > maxMoves * 0.5 ? '#f59e0b' : '#10b981';
        }

        // Event listeners
        startBtn.addEventListener('click', startGame);
        hintBtn.addEventListener('click', showHint);

        themeSelect.addEventListener('change', () => {
            if (isGameActive) {
                startGame();
            } else {
                document.body.className = `theme-${themeSelect.value}`;
                createBoard();
            }
        });

        // Grid size selector
        sizeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                sizeBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                gridSize = parseInt(btn.dataset.size);

                if (isGameActive) {
                    startGame();
                } else {
                    createBoard();
                }
            });
        });

        // Initialize the game
        initGame();
    </script>
</body>

</html>