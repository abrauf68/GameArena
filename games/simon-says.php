<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simon Says Game</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            font-family: 'Arial', sans-serif;
            color: white;
            overflow: hidden;
        }

        .game-container {
            text-align: center;
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .score {
            font-size: 1.5em;
            margin: 10px 0;
        }

        .game-board {
            display: grid;
            grid-template-columns: repeat(2, 150px);
            gap: 10px;
            margin: 20px auto;
        }

        .color-btn {
            width: 150px;
            height: 150px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: transform 0.2s, opacity 0.2s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
        }

        .color-btn:active {
            transform: scale(0.95);
        }

        .color-btn.green { background-color: #28a745; }
        .color-btn.red { background-color: #dc3545; }
        .color-btn.yellow { background-color: #ffc107; }
        .color-btn.blue { background-color: #007bff; }

        .color-btn.active {
            opacity: 0.7;
            transform: scale(1.05);
        }

        #start-btn, #strict-btn {
            padding: 10px 20px;
            font-size: 1.2em;
            margin: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #17a2b8;
            color: white;
            transition: background-color 0.3s;
        }

        #start-btn:hover, #strict-btn:hover {
            background-color: #138496;
        }

        #strict-btn.active {
            background-color: #dc3545;
        }

        .message {
            font-size: 1.2em;
            margin-top: 10px;
            height: 1.5em;
        }

        @media (max-width: 600px) {
            .game-board {
                grid-template-columns: repeat(2, 100px);
            }
            .color-btn {
                width: 100px;
                height: 100px;
            }
            h1 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <div class="game-container">
        <h1>Simon Says</h1>
        <div class="score">Score: <span id="score">0</span></div>
        <div class="game-board">
            <button class="color-btn green" id="green"></button>
            <button class="color-btn red" id="red"></button>
            <button class="color-btn yellow" id="yellow"></button>
            <button class="color-btn blue" id="blue"></button>
        </div>
        <button id="start-btn">Start</button>
        <button id="strict-btn">Strict Mode: Off</button>
        <div class="message" id="message"></div>
    </div>

    <script>
        const buttons = {
            green: document.getElementById('green'),
            red: document.getElementById('red'),
            yellow: document.getElementById('yellow'),
            blue: document.getElementById('blue')
        };

        const sounds = {
            green: new Audio('https://s3.amazonaws.com/freecodecamp/simonSound1.mp3'),
            red: new Audio('https://s3.amazonaws.com/freecodecamp/simonSound2.mp3'),
            yellow: new Audio('https://s3.amazonaws.com/freecodecamp/simonSound3.mp3'),
            blue: new Audio('https://s3.amazonaws.com/freecodecamp/simonSound4.mp3'),
            error: new Audio('https://www.soundjay.com/buttons/beep-01a.mp3')
        };

        let sequence = [];
        let playerSequence = [];
        let score = 0;
        let isPlaying = false;
        let strictMode = false;
        let playerTurn = false;

        const startBtn = document.getElementById('start-btn');
        const strictBtn = document.getElementById('strict-btn');
        const scoreDisplay = document.getElementById('score');
        const messageDisplay = document.getElementById('message');

        function updateScore() {
            scoreDisplay.textContent = score;
        }

        function showMessage(msg) {
            messageDisplay.textContent = msg;
            setTimeout(() => messageDisplay.textContent = '', 2000);
        }

        function playSound(color) {
            sounds[color].currentTime = 0;
            sounds[color].play();
        }

        function flashButton(color) {
            buttons[color].classList.add('active');
            playSound(color);
            setTimeout(() => buttons[color].classList.remove('active'), 500);
        }

        function addToSequence() {
            const colors = ['green', 'red', 'yellow', 'blue'];
            const randomColor = colors[Math.floor(Math.random() * 4)];
            sequence.push(randomColor);
        }

        function playSequence() {
            playerTurn = false;
            let i = 0;
            const interval = setInterval(() => {
                if (i >= sequence.length) {
                    clearInterval(interval);
                    playerTurn = true;
                    showMessage("Your turn!");
                    return;
                }
                flashButton(sequence[i]);
                i++;
            }, 800);
        }

        function startGame() {
            if (!isPlaying) {
                sequence = [];
                playerSequence = [];
                score = 0;
                updateScore();
                isPlaying = true;
                startBtn.textContent = 'Restart';
                nextRound();
            } else {
                // Restart game
                sequence = [];
                playerSequence = [];
                score = 0;
                updateScore();
                isPlaying = true;
                nextRound();
            }
        }

        function nextRound() {
            playerSequence = [];
            addToSequence();
            score++;
            updateScore();
            showMessage("Watch the sequence!");
            setTimeout(playSequence, 1000);
        }

        function checkPlayerInput(color) {
            if (!playerTurn) return;

            playerSequence.push(color);
            playSound(color);
            buttons[color].classList.add('active');
            setTimeout(() => buttons[color].classList.remove('active'), 200);

            const currentStep = playerSequence.length - 1;

            if (playerSequence[currentStep] !== sequence[currentStep]) {
                handleError();
                return;
            }

            if (playerSequence.length === sequence.length) {
                if (score >= 20) {
                    showMessage("You win!");
                    isPlaying = false;
                    startBtn.textContent = 'Start';
                    return;
                }
                setTimeout(nextRound, 1000);
            }
        }

        function handleError() {
            playSound('error');
            showMessage("Wrong! Try again.");
            playerTurn = false;

            if (strictMode) {
                showMessage("Game Over! Starting new game.");
                sequence = [];
                playerSequence = [];
                score = 0;
                updateScore();
                setTimeout(startGame, 2000);
            } else {
                playerSequence = [];
                setTimeout(playSequence, 1000);
            }
        }

        // Event Listeners
        startBtn.addEventListener('click', startGame);

        strictBtn.addEventListener('click', () => {
            strictMode = !strictMode;
            strictBtn.textContent = `Strict Mode: ${strictMode ? 'On' : 'Off'}`;
            strictBtn.classList.toggle('active');
        });

        Object.keys(buttons).forEach(color => {
            buttons[color].addEventListener('click', () => checkPlayerInput(color));
        });
    </script>
</body>
</html>