<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neon RPS - Ultimate Rock Paper Scissors</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Montserrat:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #00f7ff;
            --secondary: #ff00e4;
            --tertiary: #9600ff;
            --dark: #0a0a15;
            --darker: #05050a;
            --light: #e0e0ff;
            --danger: #ff3860;
            --success: #2ecc71;
            --warning: #ff9f43;
            --glow: 0 0 10px rgba(0, 247, 255, 0.7);
            --glow-secondary: 0 0 10px rgba(255, 0, 228, 0.7);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--dark);
            color: var(--light);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image:
                radial-gradient(circle at 10% 20%, rgba(150, 0, 255, 0.1) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(0, 247, 255, 0.1) 0%, transparent 20%),
                linear-gradient(to bottom, var(--darker), var(--dark));
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
            width: 100%;
        }

        h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            color: var(--primary);
            text-shadow: var(--glow);
            margin-bottom: 0.5rem;
            letter-spacing: 2px;
            position: relative;
            display: inline-block;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 3px;
            box-shadow: var(--glow-secondary);
        }

        .subtitle {
            font-size: clamp(0.9rem, 2vw, 1.1rem);
            opacity: 0.8;
            max-width: 600px;
            margin: 0 auto;
        }

        .game-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 900px;
            background: rgba(10, 10, 20, 0.7);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .game-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 247, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
            z-index: -1;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .score-board {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            gap: 1rem;
        }

        .score {
            flex: 1;
            padding: 1.5rem;
            border-radius: 15px;
            text-align: center;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .score:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .score::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .player-score::after {
            background: var(--primary);
        }

        .computer-score::after {
            background: var(--secondary);
        }

        .score-title {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            opacity: 0.8;
        }

        .score-value {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .player-score .score-value {
            color: var(--primary);
            text-shadow: var(--glow);
        }

        .computer-score .score-value {
            color: var(--secondary);
            text-shadow: var(--glow-secondary);
        }

        .choices {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .choice {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            background: rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .choice::before {
            content: '';
            position: absolute;
            inset: -5px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            z-index: -1;
            opacity: 0;
            transition: var(--transition);
        }

        .choice:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            border-color: transparent;
        }

        .choice:hover::before {
            opacity: 1;
        }

        .choice i {
            font-size: 3.5rem;
            color: var(--light);
            transition: var(--transition);
            position: absolute;
            /* Added to ensure perfect centering */
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .choice:hover i {
            color: white;
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.7);
        }

        .choice[data-choice="rock"] i {
            color: var(--primary);
        }

        .choice[data-choice="paper"] i {
            color: var(--secondary);
        }

        .choice[data-choice="scissors"] i {
            color: var(--tertiary);
        }

        .choice[data-choice="rock"]:hover::before {
            background: var(--primary);
        }

        .choice[data-choice="paper"]:hover::before {
            background: var(--secondary);
        }

        .choice[data-choice="scissors"]:hover::before {
            background: var(--tertiary);
        }

        .battle-area {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            gap: 2rem;
        }

        .battle-choice {
            flex: 1;
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
            min-height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            opacity: 0.5;
            transform: scale(0.9);
        }

        .battle-choice.active {
            opacity: 1;
            transform: scale(1);
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .battle-choice.player.active {
            border-color: var(--primary);
            box-shadow: 0 0 20px rgba(0, 247, 255, 0.3);
        }

        .battle-choice.computer.active {
            border-color: var(--secondary);
            box-shadow: 0 0 20px rgba(255, 0, 228, 0.3);
        }

        .battle-title {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            opacity: 0.8;
        }

        .battle-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            transition: var(--transition);
            opacity: 0;
            transform: scale(0);
        }

        .battle-icon.show {
            opacity: 1;
            transform: scale(1);
        }

        .player .battle-icon {
            color: var(--primary);
        }

        .computer .battle-icon {
            color: var(--secondary);
        }

        .vs {
            font-family: 'Orbitron', sans-serif;
            font-size: 2rem;
            color: var(--light);
            opacity: 0.3;
            align-self: center;
        }

        .result-container {
            text-align: center;
            margin-bottom: 2rem;
            min-height: 60px;
        }

        .result-text {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.8rem;
            opacity: 0;
            transform: translateY(20px);
            transition: var(--transition);
            text-shadow: 0 0 10px currentColor;
        }

        .result-text.show {
            opacity: 1;
            transform: translateY(0);
        }

        .result-text.tie {
            color: var(--light);
        }

        .result-text.win {
            color: var(--success);
        }

        .result-text.lose {
            color: var(--danger);
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .btn {
            padding: 0.8rem 1.8rem;
            border: none;
            border-radius: 50px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            z-index: -1;
            opacity: 0;
            transition: var(--transition);
        }

        .btn:hover::before {
            opacity: 1;
        }

        .btn-primary {
            background: var(--primary);
            color: var(--dark);
        }

        .btn-primary:hover {
            box-shadow: 0 0 20px rgba(0, 247, 255, 0.5);
            transform: translateY(-3px);
        }

        .btn-secondary {
            background: transparent;
            color: var(--light);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .btn-secondary:hover {
            border-color: transparent;
            color: white;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
        }

        .btn-play-again {
            display: none;
        }

        .btn-play-again.show {
            display: inline-block;
        }

        .stats-container {
            width: 100%;
            margin-top: 2rem;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .stats-title {
            font-family: 'Orbitron', sans-serif;
            color: var(--primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stats-title i {
            font-size: 1.2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .stat-item {
            background: rgba(0, 0, 0, 0.2);
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
        }

        .stat-value {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.5rem;
            margin-bottom: 0.3rem;
        }

        .stat-label {
            font-size: 0.8rem;
            opacity: 0.7;
        }

        .history-container {
            width: 100%;
            margin-top: 2rem;
            max-height: 200px;
            overflow-y: auto;
            padding-right: 0.5rem;
        }

        .history-item {
            display: flex;
            justify-content: space-between;
            padding: 0.8rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: var(--transition);
        }

        .history-item:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .history-move {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .history-result {
            font-weight: bold;
        }

        .history-result.win {
            color: var(--success);
        }

        .history-result.lose {
            color: var(--danger);
        }

        .history-result.tie {
            color: var(--light);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .game-container {
                padding: 1.5rem;
            }

            .choices {
                gap: 1rem;
            }

            .choice {
                width: 90px;
                height: 90px;
            }

            .choice i {
                font-size: 2.5rem;
            }

            .battle-area {
                flex-direction: column;
                gap: 1rem;
            }

            .battle-choice {
                width: 100%;
                padding: 1.5rem;
                min-height: auto;
            }

            .vs {
                transform: rotate(90deg);
                margin: 1rem 0;
            }

            .score-board {
                flex-direction: column;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .game-container {
                padding: 1rem;
            }

            .choice {
                width: 70px;
                height: 70px;
            }

            .choice i {
                font-size: 2rem;
            }

            .battle-icon {
                font-size: 3rem;
            }

            .result-text {
                font-size: 1.5rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary);
        }

        /* Tooltip */
        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.8rem;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>NEON RPS</h1>
            <p class="subtitle">The ultimate Rock Paper Scissors experience with cutting-edge design and gameplay</p>
        </header>

        <div class="game-container">
            <div class="score-board">
                <div class="score player-score">
                    <div class="score-title">PLAYER</div>
                    <div class="score-value" id="player-score">0</div>
                </div>
                <div class="score computer-score">
                    <div class="score-title">COMPUTER</div>
                    <div class="score-value" id="computer-score">0</div>
                </div>
            </div>

            <div class="choices">
                <div class="choice tooltip" data-choice="rock" title="Rock crushes scissors">
                    <i class="fas fa-hand-rock"></i>
                    <span class="tooltiptext">Rock crushes scissors</span>
                </div>
                <div class="choice tooltip" data-choice="paper" title="Paper covers rock">
                    <i class="fas fa-hand-paper"></i>
                    <span class="tooltiptext">Paper covers rock</span>
                </div>
                <div class="choice tooltip" data-choice="scissors" title="Scissors cut paper">
                    <i class="fas fa-hand-scissors"></i>
                    <span class="tooltiptext">Scissors cut paper</span>
                </div>
            </div>

            <div class="battle-area">
                <div class="battle-choice player">
                    <div class="battle-title">YOUR CHOICE</div>
                    <i class="battle-icon" id="player-choice-icon"></i>
                </div>
                <div class="vs">VS</div>
                <div class="battle-choice computer">
                    <div class="battle-title">COMPUTER</div>
                    <i class="battle-icon" id="computer-choice-icon"></i>
                </div>
            </div>

            <div class="result-container">
                <div class="result-text" id="result-text"></div>
            </div>

            <div class="action-buttons">
                <button class="btn btn-primary btn-play-again" id="play-again">PLAY AGAIN</button>
                <button class="btn btn-secondary" id="reset-scores">RESET SCORES</button>
            </div>

            <div class="stats-container">
                <h3 class="stats-title"><i class="fas fa-chart-line"></i> GAME STATS</h3>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value" id="total-games">0</div>
                        <div class="stat-label">Total Games</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value" id="win-rate">0%</div>
                        <div class="stat-label">Win Rate</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value" id="current-streak">0</div>
                        <div class="stat-label">Current Streak</div>
                    </div>
                </div>
            </div>

            <div class="history-container">
                <h3 class="stats-title"><i class="fas fa-history"></i> GAME HISTORY</h3>
                <div id="history-list"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // DOM Elements
            const choices = document.querySelectorAll('.choice');
            const playerChoiceIcon = document.getElementById('player-choice-icon');
            const computerChoiceIcon = document.getElementById('computer-choice-icon');
            const resultText = document.getElementById('result-text');
            const playerScoreEl = document.getElementById('player-score');
            const computerScoreEl = document.getElementById('computer-score');
            const playAgainBtn = document.getElementById('play-again');
            const resetScoresBtn = document.getElementById('reset-scores');
            const totalGamesEl = document.getElementById('total-games');
            const winRateEl = document.getElementById('win-rate');
            const currentStreakEl = document.getElementById('current-streak');
            const historyList = document.getElementById('history-list');
            const battleChoices = document.querySelectorAll('.battle-choice');

            // Game State
            let playerScore = 0;
            let computerScore = 0;
            let totalGames = 0;
            let wins = 0;
            let currentStreak = 0;
            let maxStreak = 0;
            let gameHistory = [];

            // Icon Mapping
            const choiceIcons = {
                rock: 'fas fa-hand-rock',
                paper: 'fas fa-hand-paper',
                scissors: 'fas fa-hand-scissors'
            };

            // Sound Effects
            const playSound = (type) => {
                // In a real implementation, you would load and play audio files
                console.log(`Playing ${type} sound`);
            };

            // Computer Choice
            const getComputerChoice = () => {
                const choices = ['rock', 'paper', 'scissors'];
                return choices[Math.floor(Math.random() * 3)];
            };

            // Determine Winner
            const determineWinner = (playerChoice, computerChoice) => {
                if (playerChoice === computerChoice) return 'tie';

                if (
                    (playerChoice === 'rock' && computerChoice === 'scissors') ||
                    (playerChoice === 'paper' && computerChoice === 'rock') ||
                    (playerChoice === 'scissors' && computerChoice === 'paper')
                ) {
                    return 'win';
                } else {
                    return 'lose';
                }
            };

            // Update Stats
            const updateStats = (result) => {
                totalGames++;
                if (result === 'win') {
                    wins++;
                    currentStreak++;
                    if (currentStreak > maxStreak) maxStreak = currentStreak;
                } else if (result === 'lose') {
                    currentStreak = 0;
                }

                totalGamesEl.textContent = totalGames;
                winRateEl.textContent = totalGames > 0 ? Math.round((wins / totalGames) * 100) + '%' : '0%';
                currentStreakEl.textContent = currentStreak;
            };

            // Add to History
            const addToHistory = (playerChoice, computerChoice, result) => {
                const historyItem = {
                    playerChoice,
                    computerChoice,
                    result,
                    timestamp: new Date()
                };

                gameHistory.unshift(historyItem);

                // Limit history to 20 items
                if (gameHistory.length > 20) {
                    gameHistory.pop();
                }

                renderHistory();
            };

            // Render History
            const renderHistory = () => {
                historyList.innerHTML = '';

                gameHistory.forEach((item, index) => {
                    const historyItem = document.createElement('div');
                    historyItem.className = 'history-item';

                    const playerMove = document.createElement('div');
                    playerMove.className = 'history-move';
                    playerMove.innerHTML = `
                        <i class="${choiceIcons[item.playerChoice]}"></i>
                        <span>vs</span>
                        <i class="${choiceIcons[item.computerChoice]}"></i>
                    `;

                    const result = document.createElement('div');
                    result.className = `history-result ${item.result}`;
                    result.textContent = item.result.toUpperCase();

                    historyItem.appendChild(playerMove);
                    historyItem.appendChild(result);
                    historyList.appendChild(historyItem);
                });
            };

            // Play Game
            const playGame = (playerChoice) => {
                playSound('click');

                // Disable choices during gameplay
                choices.forEach(choice => {
                    choice.style.pointerEvents = 'none';
                    choice.style.opacity = '0.5';
                });

                const computerChoice = getComputerChoice();
                const result = determineWinner(playerChoice, computerChoice);

                // Update choices display
                playerChoiceIcon.className = `${choiceIcons[playerChoice]} battle-icon`;
                computerChoiceIcon.className = `${choiceIcons[computerChoice]} battle-icon`;

                // Activate battle areas
                battleChoices.forEach(choice => choice.classList.add('active'));

                // Show choices with animation
                setTimeout(() => {
                    playerChoiceIcon.classList.add('show');
                    playSound('player');
                }, 300);

                setTimeout(() => {
                    computerChoiceIcon.classList.add('show');
                    playSound('computer');
                }, 800);

                // Show result
                setTimeout(() => {
                    resultText.textContent = result === 'tie' ? "IT'S A TIE!" :
                        result === 'win' ? "YOU WIN!" : "YOU LOSE!";
                    resultText.className = `result-text show ${result}`;

                    // Update scores
                    if (result === 'win') {
                        playerScore++;
                        playerScoreEl.textContent = playerScore;
                        playSound('win');
                    } else if (result === 'lose') {
                        computerScore++;
                        computerScoreEl.textContent = computerScore;
                        playSound('lose');
                    } else {
                        playSound('tie');
                    }

                    // Update stats and history
                    updateStats(result);
                    addToHistory(playerChoice, computerChoice, result);

                    // Show play again button
                    playAgainBtn.classList.add('show');
                }, 1500);
            };

            // Reset Game
            const resetGame = () => {
                playSound('click');

                // Hide result and choices
                resultText.className = 'result-text';
                playerChoiceIcon.className = 'battle-icon';
                computerChoiceIcon.className = 'battle-icon';

                // Deactivate battle areas
                battleChoices.forEach(choice => choice.classList.remove('active'));

                // Enable choices
                choices.forEach(choice => {
                    choice.style.pointerEvents = 'auto';
                    choice.style.opacity = '1';
                });

                // Hide play again button
                playAgainBtn.classList.remove('show');
            };

            // Reset Scores
            const resetScores = () => {
                playSound('click');

                playerScore = 0;
                computerScore = 0;
                totalGames = 0;
                wins = 0;
                currentStreak = 0;
                maxStreak = 0;
                gameHistory = [];

                playerScoreEl.textContent = '0';
                computerScoreEl.textContent = '0';
                totalGamesEl.textContent = '0';
                winRateEl.textContent = '0%';
                currentStreakEl.textContent = '0';
                historyList.innerHTML = '';

                resetGame();
            };

            // Event Listeners
            choices.forEach(choice => {
                choice.addEventListener('click', () => {
                    const playerChoice = choice.dataset.choice;
                    playGame(playerChoice);
                });
            });

            playAgainBtn.addEventListener('click', resetGame);
            resetScoresBtn.addEventListener('click', resetScores);

            // Initialize
            renderHistory();
        });
    </script>
</body>

</html> -->

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

        :root {
            --primary: #00f7ff;
            --secondary: #ff00e4;
            --tertiary: #9600ff;
            --dark: #0a0a15;
            --darker: #05050a;
            --light: #e0e0ff;
            --danger: #ff3860;
            --success: #2ecc71;
            --warning: #ff9f43;
            --glow: 0 0 10px rgba(0, 247, 255, 0.7);
            --glow-secondary: 0 0 10px rgba(255, 0, 228, 0.7);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .parent-game-container {
            width: 100%;
            max-width: 1200px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .parent-game-container header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
            width: 100%;
        }

        .parent-game-container h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            color: var(--primary);
            text-shadow: var(--glow);
            margin-bottom: 0.5rem;
            letter-spacing: 2px;
            position: relative;
            display: inline-block;
        }

        .parent-game-container h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 3px;
            box-shadow: var(--glow-secondary);
        }

        .parent-game-container .subtitle {
            font-size: clamp(0.9rem, 2vw, 1.1rem);
            opacity: 0.8;
            max-width: 600px;
            margin: 0 auto;
        }

        .game-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 900px;
            background: rgba(10, 10, 20, 0.7);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .game-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 247, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
            z-index: -1;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .score-board {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            gap: 1rem;
        }

        .score {
            flex: 1;
            padding: 1.5rem;
            border-radius: 15px;
            text-align: center;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .score:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .score::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .player-score::after {
            background: var(--primary);
        }

        .computer-score::after {
            background: var(--secondary);
        }

        .score-title {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            opacity: 0.8;
        }

        .score-value {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .player-score .score-value {
            color: var(--primary);
            text-shadow: var(--glow);
        }

        .computer-score .score-value {
            color: var(--secondary);
            text-shadow: var(--glow-secondary);
        }

        .choices {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .choice {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            background: rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .choice::before {
            content: '';
            position: absolute;
            inset: -5px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            z-index: -1;
            opacity: 0;
            transition: var(--transition);
        }

        .choice:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            border-color: transparent;
        }

        .choice:hover::before {
            opacity: 1;
        }

        .choice i {
            font-size: 3.5rem;
            color: var(--light);
            transition: var(--transition);
            position: absolute;
            /* Added to ensure perfect centering */
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .choice:hover i {
            color: white;
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.7);
        }

        .choice[data-choice="rock"] i {
            color: var(--primary);
        }

        .choice[data-choice="paper"] i {
            color: var(--secondary);
        }

        .choice[data-choice="scissors"] i {
            color: var(--tertiary);
        }

        .choice[data-choice="rock"]:hover::before {
            background: var(--primary);
        }

        .choice[data-choice="paper"]:hover::before {
            background: var(--secondary);
        }

        .choice[data-choice="scissors"]:hover::before {
            background: var(--tertiary);
        }

        .battle-area {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            gap: 2rem;
        }

        .battle-choice {
            flex: 1;
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
            min-height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            opacity: 0.5;
            transform: scale(0.9);
        }

        .battle-choice.active {
            opacity: 1;
            transform: scale(1);
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .battle-choice.player.active {
            border-color: var(--primary);
            box-shadow: 0 0 20px rgba(0, 247, 255, 0.3);
        }

        .battle-choice.computer.active {
            border-color: var(--secondary);
            box-shadow: 0 0 20px rgba(255, 0, 228, 0.3);
        }

        .battle-title {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            opacity: 0.8;
        }

        .battle-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            transition: var(--transition);
            opacity: 0;
            transform: scale(0);
        }

        .battle-icon.show {
            opacity: 1;
            transform: scale(1);
        }

        .player .battle-icon {
            color: var(--primary);
        }

        .computer .battle-icon {
            color: var(--secondary);
        }

        .vs {
            font-family: 'Orbitron', sans-serif;
            font-size: 2rem;
            color: var(--light);
            opacity: 0.3;
            align-self: center;
        }

        .result-container {
            text-align: center;
            margin-bottom: 2rem;
            min-height: 60px;
        }

        .result-text {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.8rem;
            opacity: 0;
            transform: translateY(20px);
            transition: var(--transition);
            text-shadow: 0 0 10px currentColor;
        }

        .result-text.show {
            opacity: 1;
            transform: translateY(0);
        }

        .result-text.tie {
            color: var(--light);
        }

        .result-text.win {
            color: var(--success);
        }

        .result-text.lose {
            color: var(--danger);
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .btn {
            padding: 0.8rem 1.8rem;
            border: none;
            border-radius: 50px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            z-index: -1;
            opacity: 0;
            transition: var(--transition);
        }

        .btn:hover::before {
            opacity: 1;
        }

        .btn-primary {
            background: var(--primary);
            color: var(--dark);
        }

        .btn-primary:hover {
            box-shadow: 0 0 20px rgba(0, 247, 255, 0.5);
            transform: translateY(-3px);
        }

        .btn-secondary {
            background: transparent;
            color: var(--light);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .btn-secondary:hover {
            border-color: transparent;
            color: white;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
        }

        .btn-play-again {
            display: none;
        }

        .btn-play-again.show {
            display: inline-block;
        }

        .stats-container {
            width: 100%;
            margin-top: 2rem;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .stats-title {
            font-family: 'Orbitron', sans-serif;
            color: var(--primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stats-title i {
            font-size: 1.2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .stat-item {
            background: rgba(0, 0, 0, 0.2);
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
        }

        .stat-value {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.5rem;
            margin-bottom: 0.3rem;
        }

        .stat-label {
            font-size: 0.8rem;
            opacity: 0.7;
        }

        .history-container {
            width: 100%;
            margin-top: 2rem;
            max-height: 200px;
            overflow-y: auto;
            padding-right: 0.5rem;
        }

        .history-item {
            display: flex;
            justify-content: space-between;
            padding: 0.8rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: var(--transition);
        }

        .history-item:hover {
            background: rgba(255, 255, 255, 0.03);
        }

        .history-move {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .history-result {
            font-weight: bold;
        }

        .history-result.win {
            color: var(--success);
        }

        .history-result.lose {
            color: var(--danger);
        }

        .history-result.tie {
            color: var(--light);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .game-container {
                padding: 1.5rem;
            }

            .choices {
                gap: 1rem;
            }

            .choice {
                width: 90px;
                height: 90px;
            }

            .choice i {
                font-size: 2.5rem;
            }

            .battle-area {
                flex-direction: column;
                gap: 1rem;
            }

            .battle-choice {
                width: 100%;
                padding: 1.5rem;
                min-height: auto;
            }

            .vs {
                transform: rotate(90deg);
                margin: 1rem 0;
            }

            .score-board {
                flex-direction: column;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .game-container {
                padding: 1rem;
            }

            .choice {
                width: 70px;
                height: 70px;
            }

            .choice i {
                font-size: 2rem;
            }

            .battle-icon {
                font-size: 3rem;
            }

            .result-text {
                font-size: 1.5rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary);
        }

        /* Tooltip */
        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.8rem;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
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
            <div class="parent-game-container">
                <header>
                    <h1>ROCK PAPER SCISSORS</h1>
                </header>

                <div class="game-container">
                    <div class="score-board">
                        <div class="score player-score">
                            <div class="score-title">PLAYER</div>
                            <div class="score-value" id="player-score">0</div>
                        </div>
                        <div class="score computer-score">
                            <div class="score-title">COMPUTER</div>
                            <div class="score-value" id="computer-score">0</div>
                        </div>
                    </div>

                    <div class="choices">
                        <div class="choice tooltip" data-choice="rock" title="Rock crushes scissors">
                            <i class="fas fa-hand-rock"></i>
                            <span class="tooltiptext">Rock crushes scissors</span>
                        </div>
                        <div class="choice tooltip" data-choice="paper" title="Paper covers rock">
                            <i class="fas fa-hand-paper"></i>
                            <span class="tooltiptext">Paper covers rock</span>
                        </div>
                        <div class="choice tooltip" data-choice="scissors" title="Scissors cut paper">
                            <i class="fas fa-hand-scissors"></i>
                            <span class="tooltiptext">Scissors cut paper</span>
                        </div>
                    </div>

                    <div class="battle-area">
                        <div class="battle-choice player">
                            <div class="battle-title">YOUR CHOICE</div>
                            <i class="battle-icon" id="player-choice-icon"></i>
                        </div>
                        <div class="vs">VS</div>
                        <div class="battle-choice computer">
                            <div class="battle-title">COMPUTER</div>
                            <i class="battle-icon" id="computer-choice-icon"></i>
                        </div>
                    </div>

                    <div class="result-container">
                        <div class="result-text" id="result-text"></div>
                    </div>

                    <div class="action-buttons">
                        <button class="btn btn-primary btn-play-again" id="play-again">PLAY AGAIN</button>
                        <button class="btn btn-secondary" id="reset-scores">RESET SCORES</button>
                    </div>

                    <div class="stats-container">
                        <h3 class="stats-title"><i class="fas fa-chart-line"></i> GAME STATS</h3>
                        <div class="stats-grid">
                            <div class="stat-item">
                                <div class="stat-value" id="total-games">0</div>
                                <div class="stat-label">Total Games</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value" id="win-rate">0%</div>
                                <div class="stat-label">Win Rate</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value" id="current-streak">0</div>
                                <div class="stat-label">Current Streak</div>
                            </div>
                        </div>
                    </div>

                    <div class="history-container">
                        <h3 class="stats-title"><i class="fas fa-history"></i> GAME HISTORY</h3>
                        <div id="history-list"></div>
                    </div>
                </div>
            </div>
        </main>
        <!-- main end -->
    </div>
    <!-- app layout end -->

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // DOM Elements
            const choices = document.querySelectorAll('.choice');
            const playerChoiceIcon = document.getElementById('player-choice-icon');
            const computerChoiceIcon = document.getElementById('computer-choice-icon');
            const resultText = document.getElementById('result-text');
            const playerScoreEl = document.getElementById('player-score');
            const computerScoreEl = document.getElementById('computer-score');
            const playAgainBtn = document.getElementById('play-again');
            const resetScoresBtn = document.getElementById('reset-scores');
            const totalGamesEl = document.getElementById('total-games');
            const winRateEl = document.getElementById('win-rate');
            const currentStreakEl = document.getElementById('current-streak');
            const historyList = document.getElementById('history-list');
            const battleChoices = document.querySelectorAll('.battle-choice');

            // Game State
            let playerScore = 0;
            let computerScore = 0;
            let totalGames = 0;
            let wins = 0;
            let currentStreak = 0;
            let maxStreak = 0;
            let gameHistory = [];

            // Icon Mapping
            const choiceIcons = {
                rock: 'fas fa-hand-rock',
                paper: 'fas fa-hand-paper',
                scissors: 'fas fa-hand-scissors'
            };

            // Sound Effects
            const playSound = (type) => {
                // In a real implementation, you would load and play audio files
                console.log(`Playing ${type} sound`);
            };

            // Computer Choice
            const getComputerChoice = () => {
                const choices = ['rock', 'paper', 'scissors'];
                return choices[Math.floor(Math.random() * 3)];
            };

            // Determine Winner
            const determineWinner = (playerChoice, computerChoice) => {
                if (playerChoice === computerChoice) return 'tie';

                if (
                    (playerChoice === 'rock' && computerChoice === 'scissors') ||
                    (playerChoice === 'paper' && computerChoice === 'rock') ||
                    (playerChoice === 'scissors' && computerChoice === 'paper')
                ) {
                    return 'win';
                } else {
                    return 'lose';
                }
            };

            // Update Stats
            const updateStats = (result) => {
                totalGames++;
                if (result === 'win') {
                    wins++;
                    currentStreak++;
                    if (currentStreak > maxStreak) maxStreak = currentStreak;
                } else if (result === 'lose') {
                    currentStreak = 0;
                }

                totalGamesEl.textContent = totalGames;
                winRateEl.textContent = totalGames > 0 ? Math.round((wins / totalGames) * 100) + '%' : '0%';
                currentStreakEl.textContent = currentStreak;
            };

            // Add to History
            const addToHistory = (playerChoice, computerChoice, result) => {
                const historyItem = {
                    playerChoice,
                    computerChoice,
                    result,
                    timestamp: new Date()
                };

                gameHistory.unshift(historyItem);

                // Limit history to 20 items
                if (gameHistory.length > 20) {
                    gameHistory.pop();
                }

                renderHistory();
            };

            // Render History
            const renderHistory = () => {
                historyList.innerHTML = '';

                gameHistory.forEach((item, index) => {
                    const historyItem = document.createElement('div');
                    historyItem.className = 'history-item';

                    const playerMove = document.createElement('div');
                    playerMove.className = 'history-move';
                    playerMove.innerHTML = `
                        <i class="${choiceIcons[item.playerChoice]}"></i>
                        <span>vs</span>
                        <i class="${choiceIcons[item.computerChoice]}"></i>
                    `;

                    const result = document.createElement('div');
                    result.className = `history-result ${item.result}`;
                    result.textContent = item.result.toUpperCase();

                    historyItem.appendChild(playerMove);
                    historyItem.appendChild(result);
                    historyList.appendChild(historyItem);
                });
            };

            // Play Game
            const playGame = (playerChoice) => {
                playSound('click');

                // Disable choices during gameplay
                choices.forEach(choice => {
                    choice.style.pointerEvents = 'none';
                    choice.style.opacity = '0.5';
                });

                const computerChoice = getComputerChoice();
                const result = determineWinner(playerChoice, computerChoice);

                // Update choices display
                playerChoiceIcon.className = `${choiceIcons[playerChoice]} battle-icon`;
                computerChoiceIcon.className = `${choiceIcons[computerChoice]} battle-icon`;

                // Activate battle areas
                battleChoices.forEach(choice => choice.classList.add('active'));

                // Show choices with animation
                setTimeout(() => {
                    playerChoiceIcon.classList.add('show');
                    playSound('player');
                }, 300);

                setTimeout(() => {
                    computerChoiceIcon.classList.add('show');
                    playSound('computer');
                }, 800);

                // Show result
                setTimeout(() => {
                    resultText.textContent = result === 'tie' ? "IT'S A TIE!" :
                        result === 'win' ? "YOU WIN!" : "YOU LOSE!";
                    resultText.className = `result-text show ${result}`;

                    // Update scores
                    if (result === 'win') {
                        playerScore++;
                        playerScoreEl.textContent = playerScore;
                        playSound('win');
                    } else if (result === 'lose') {
                        computerScore++;
                        computerScoreEl.textContent = computerScore;
                        playSound('lose');
                    } else {
                        playSound('tie');
                    }

                    // Update stats and history
                    updateStats(result);
                    addToHistory(playerChoice, computerChoice, result);

                    // Show play again button
                    playAgainBtn.classList.add('show');
                }, 1500);
            };

            // Reset Game
            const resetGame = () => {
                playSound('click');

                // Hide result and choices
                resultText.className = 'result-text';
                playerChoiceIcon.className = 'battle-icon';
                computerChoiceIcon.className = 'battle-icon';

                // Deactivate battle areas
                battleChoices.forEach(choice => choice.classList.remove('active'));

                // Enable choices
                choices.forEach(choice => {
                    choice.style.pointerEvents = 'auto';
                    choice.style.opacity = '1';
                });

                // Hide play again button
                playAgainBtn.classList.remove('show');
            };

            // Reset Scores
            const resetScores = () => {
                playSound('click');

                playerScore = 0;
                computerScore = 0;
                totalGames = 0;
                wins = 0;
                currentStreak = 0;
                maxStreak = 0;
                gameHistory = [];

                playerScoreEl.textContent = '0';
                computerScoreEl.textContent = '0';
                totalGamesEl.textContent = '0';
                winRateEl.textContent = '0%';
                currentStreakEl.textContent = '0';
                historyList.innerHTML = '';

                resetGame();
            };

            // Event Listeners
            choices.forEach(choice => {
                choice.addEventListener('click', () => {
                    const playerChoice = choice.dataset.choice;
                    playGame(playerChoice);
                });
            });

            playAgainBtn.addEventListener('click', resetGame);
            resetScoresBtn.addEventListener('click', resetScores);

            // Initialize
            renderHistory();
        });
    </script>
</body>

</html>