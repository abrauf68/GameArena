<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dice Roller Game</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(-45deg, #1e3c72, #2a5298, #6b48ff, #ff6b6b);
            background-size: 400%;
            animation: gradient 15s ease infinite;
            color: #fff;
            padding: 1rem;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem;
            width: 100%;
            max-width: 900px; /* Increased for larger screens */
            text-align: center;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }

        /* .container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 10%, transparent 10.01%);
            animation: pulse 8s ease-in-out infinite;
            z-index: -1;
        } */

        @keyframes pulse {
            0% { transform: scale(0.8); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0.2; }
            100% { transform: scale(0.8); opacity: 0.5; }
        }

        h1 {
            font-size: clamp(2rem, 5vw, 3.5rem); /* Responsive font size */
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            background: linear-gradient(45deg, #ff6b6b, #ffd700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 10px rgba(255, 107, 107, 0.5);
        }

        .game-options {
            display: flex;
            flex-wrap: wrap; /* Allow wrapping on smaller screens */
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        select, button {
            padding: clamp(0.6rem, 2vw, 0.8rem) clamp(1rem, 3vw, 1.5rem);
            border: none;
            border-radius: 50px;
            font-size: clamp(0.9rem, 2.5vw, 1rem);
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .custom-select {
            position: relative;
            display: inline-block;
            min-width: 150px; /* Ensure dropdown doesn't get too small */
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: linear-gradient(45deg, #ffffff, #f0f0f0);
            color: #333;
            border: 2px solid #ffd700;
            padding-right: 2.5rem;
            font-weight: 600;
            width: 100%;
        }

        select:focus {
            outline: none;
            box-shadow: 0 0 10px #ffd700;
        }

        .custom-select::after {
            content: '▼';
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #ff6b6b;
            font-size: 0.8rem;
            pointer-events: none;
        }

        button {
            background: linear-gradient(45deg, #ff6b6b, #ff8e53);
            color: white;
            font-weight: bold;
        }

        button:hover {
            background: linear-gradient(45deg, #ff8e53, #ff6b6b);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 107, 107, 0.5);
        }

        .dice-container {
            display: flex;
            flex-wrap: wrap; /* Allow stacking on smaller screens */
            justify-content: space-around;
            margin: 2rem 0;
            gap: 1rem;
        }

        .player {
            background: rgba(255, 255, 255, 0.1);
            padding: clamp(1rem, 3vw, 1.5rem);
            border-radius: 15px;
            width: clamp(200px, 45%, 400px); /* Responsive width */
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .player.rolling {
            animation: shake 0.5s ease-in-out;
            box-shadow: 0 0 20px rgba(255, 107, 107, 0.7);
        }

        .player::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 20%, transparent 20.01%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .player.rolling::before {
            opacity: 1;
        }

        .dice {
            font-size: clamp(2.5rem, 8vw, 4rem);
            margin: 1rem 0;
            height: clamp(50px, 10vw, 80px);
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }

        .score {
            font-size: clamp(1rem, 3vw, 1.2rem);
            margin-top: 0.5rem;
            background: rgba(0, 0, 0, 0.2);
            padding: 0.5rem;
            border-radius: 10px;
        }

        .result {
            font-size: clamp(1.2rem, 3.5vw, 1.5rem);
            margin-top: 1.5rem;
            padding: 1rem;
            background: linear-gradient(45deg, rgba(255, 107, 107, 0.3), rgba(255, 215, 0, 0.3));
            border-radius: 15px;
            min-height: 60px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            animation: resultPop 0.5s ease;
        }

        @keyframes resultPop {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .history {
            margin-top: 2rem;
            max-height: 200px;
            overflow-y: auto;
            padding: 1rem;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            scrollbar-width: thin;
            scrollbar-color: #ff6b6b transparent;
        }

        .history::-webkit-scrollbar {
            width: 8px;
        }

        .history::-webkit-scrollbar-track {
            background: transparent;
        }

        .history::-webkit-scrollbar-thumb {
            background: #ff6b6b;
            border-radius: 10px;
        }

        .history-item {
            font-size: clamp(0.8rem, 2.5vw, 0.9rem);
            margin-bottom: 0.5rem;
            padding: 0.5rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .history-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-8px); }
            50% { transform: translateX(8px); }
            75% { transform: translateX(-8px); }
        }

        /* Tablet and smaller desktop screens */
        @media (max-width: 768px) {
            .container {
                padding: 1.5rem;
                max-width: 600px;
            }
            .dice-container {
                flex-direction: column;
                align-items: center;
            }
            .player {
                width: 80%;
                margin-bottom: 1rem;
            }
            .game-options {
                flex-direction: column;
                align-items: center;
            }
            .custom-select, button {
                width: 100%;
                max-width: 300px;
            }
        }

        /* Mobile screens */
        @media (max-width: 480px) {
            .container {
                padding: 1rem;
            }
            .dice {
                font-size: 2rem;
                height: 40px;
            }
            .player {
                width: 90%;
                padding: 0.8rem;
            }
            select, button {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }
            .custom-select {
                min-width: 120px;
            }
        }

        /* Large desktop screens */
        @media (min-width: 1200px) {
            .container {
                max-width: 1000px;
                padding: 2.5rem;
            }
            .player {
                width: 40%;
            }
            .dice {
                font-size: 4.5rem;
                height: 90px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dice Roller Game</h1>
        
        <div class="game-options">
            <div class="custom-select">
                <select id="gameMode">
                    <option value="single">Single Roll</option>
                    <option value="bestOf3">Best of 3</option>
                    <option value="bestOf5">Best of 5</option>
                </select>
            </div>
            <button onclick="rollDice()">Roll Dice</button>
            <button onclick="resetGame()">Reset</button>
        </div>

        <div class="dice-container">
            <div class="player" id="player1">
                <h2>Player 1</h2>
                <div class="dice" id="dice1">⚀</div>
                <div class="score">Score: <span id="score1">0</span></div>
            </div>
            <div class="player" id="player2">
                <h2>Player 2</h2>
                <div class="dice" id="dice2">⚀</div>
                <div class="score">Score: <span id="score2">0</span></div>
            </div>
        </div>

        <div class="result" id="result">Roll to start the game!</div>
        <div class="history" id="history"></div>
    </div>

    <script>
        const diceFaces = ['⚀', '⚁', '⚂', '⚃', '⚄', '⚅'];
        let player1Score = 0;
        let player2Score = 0;
        let rollsLeft = 1;
        let currentRound = 0;
        let gameMode = 'single';

        const dice1Element = document.getElementById('dice1');
        const dice2Element = document.getElementById('dice2');
        const score1Element = document.getElementById('score1');
        const score2Element = document.getElementById('score2');
        const resultElement = document.getElementById('result');
        const historyElement = document.getElementById('history');
        const gameModeSelect = document.getElementById('gameMode');
        const player1Element = document.getElementById('player1');
        const player2Element = document.getElementById('player2');

        gameModeSelect.addEventListener('change', () => {
            gameMode = gameModeSelect.value;
            resetGame();
        });

        function rollDice() {
            if (rollsLeft === 0) return;

            player1Element.classList.add('rolling');
            player2Element.classList.add('rolling');

            const rollInterval = setInterval(() => {
                dice1Element.textContent = diceFaces[Math.floor(Math.random() * 6)];
                dice2Element.textContent = diceFaces[Math.floor(Math.random() * 6)];
            }, 100);

            setTimeout(() => {
                clearInterval(rollInterval);
                player1Element.classList.remove('rolling');
                player2Element.classList.remove('rolling');

                const roll1 = Math.floor(Math.random() * 6) + 1;
                const roll2 = Math.floor(Math.random() * 6) + 1;
                dice1Element.textContent = diceFaces[roll1 - 1];
                dice2Element.textContent = diceFaces[roll2 - 1];

                let roundResult = '';
                if (roll1 > roll2) {
                    player1Score++;
                    roundResult = 'Player 1 wins this round!';
                } else if (roll2 > roll1) {
                    player2Score++;
                    roundResult = 'Player 2 wins this round!';
                } else {
                    roundResult = 'Tie!';
                }

                score1Element.textContent = player1Score;
                score2Element.textContent = player2Score;
                addHistory(`Round ${currentRound + 1}: P1 (${roll1}) vs P2 (${roll2}) - ${roundResult}`);

                currentRound++;
                rollsLeft--;

                if (gameMode !== 'single' && rollsLeft === 0) {
                    determineWinner();
                } else if (gameMode === 'single') {
                    resultElement.textContent = roundResult;
                    rollsLeft = 0;
                } else {
                    resultElement.textContent = `Round ${currentRound} result: ${roundResult}`;
                }
            }, 1000);
        }

        function determineWinner() {
            let finalResult = '';
            if (player1Score > player2Score) {
                finalResult = `Player 1 wins the game! (${player1Score}-${player2Score})`;
            } else if (player2Score > player1Score) {
                finalResult = `Player 2 wins the game! (${player2Score}-${player1Score})`;
            } else {
                finalResult = `Game ends in a tie! (${player1Score}-${player2Score})`;
            }
            resultElement.textContent = finalResult;
            addHistory(finalResult);
        }

        function addHistory(message) {
            const historyItem = document.createElement('div');
            historyItem.className = 'history-item';
            historyItem.textContent = message;
            historyElement.prepend(historyItem);
        }

        function resetGame() {
            player1Score = 0;
            player2Score = 0;
            currentRound = 0;
            rollsLeft = gameMode === 'single' ? 1 : gameMode === 'bestOf3' ? 3 : 5;
            score1Element.textContent = '0';
            score2Element.textContent = '0';
            dice1Element.textContent = '⚀';
            dice2Element.textContent = '⚀';
            resultElement.textContent = 'Roll to start the game!';
            historyElement.innerHTML = '';
        }

        // Preload font
        const link = document.createElement('link');
        link.href = 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap';
        link.rel = 'stylesheet';
        document.head.appendChild(link);
    </script>
</body>
</html>