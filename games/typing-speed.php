<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Typing Speed Test</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Roboto:wght@400;500&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(45deg, #1e1e2f, #2a2a4a);
            color: #fff;
            font-family: 'Roboto', sans-serif;
            overflow-x: hidden;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 700px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: 2em;
            margin-bottom: 20px;
            color: #00ffcc;
            text-shadow: 0 0 10px rgba(0, 255, 204, 0.5);
        }

        .stats {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .stats div {
            background: rgba(255, 255, 255, 0.15);
            padding: 10px 15px;
            border-radius: 12px;
            font-size: 1em;
            flex: 1;
            min-width: 100px;
            transition: transform 0.3s;
        }

        .stats div:hover {
            transform: translateY(-5px);
        }

        .text-area {
            background: rgba(0, 0, 0, 0.2);
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 1.1em;
            line-height: 1.6;
            min-height: 120px;
            max-height: 200px;
            overflow-y: auto;
            color: #fff;
        }

        .text-area .word {
            display: inline-block;
            margin: 5px;
            padding: 5px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .text-area .correct {
            background: #00ffcc;
            color: #1e1e2f;
        }

        .text-area .incorrect {
            background: #ff5555;
            color: #fff;
        }

        .text-area .current {
            background: #ffd700;
            color: #1e1e2f;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.7);
        }

        #input-field {
            width: 100%;
            padding: 12px;
            font-size: 1.1em;
            border: none;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 15px;
            outline: none;
            transition: box-shadow 0.3s;
        }

        #input-field:focus {
            box-shadow: 0 0 15px rgba(0, 255, 204, 0.5);
        }

        #input-field::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .btn {
            padding: 12px 25px;
            font-size: 1em;
            border: none;
            border-radius: 12px;
            background: linear-gradient(45deg, #00ffcc, #ffd700);
            color: #1e1e2f;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 5px;
        }

        .btn:hover {
            background: linear-gradient(45deg, #00cc99, #ffcc00);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 255, 204, 0.4);
        }

        .btn:active {
            transform: translateY(0);
        }

        .result {
            display: none;
            margin-top: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            font-size: 1.1em;
            animation: fadeIn 0.5s ease;
        }

        .result.show {
            display: block;
        }

        .timer {
            font-size: 1.3em;
            font-weight: bold;
            color: #ffd700;
            margin-bottom: 10px;
            text-shadow: 0 0 5px rgba(255, 215, 0, 0.5);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 600px) {
            .container {
                padding: 15px;
                margin: 10px;
            }

            h1 {
                font-size: 1.5em;
            }

            .text-area {
                font-size: 1em;
                max-height: 150px;
            }

            .stats div {
                font-size: 0.9em;
                padding: 8px;
            }

            .btn {
                padding: 10px 20px;
                font-size: 0.9em;
            }

            #input-field {
                font-size: 1em;
                padding: 10px;
            }
        }

        @media (max-width: 400px) {
            h1 {
                font-size: 1.3em;
            }

            .stats {
                flex-direction: column;
                align-items: center;
            }

            .stats div {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Typing Speed Test</h1>
        <div class="stats">
            <div>WPM: <span id="wpm">0</span></div>
            <div>Accuracy: <span id="accuracy">0%</span></div>
            <div class="timer">Time: <span id="timer">60</span>s</div>
        </div>
        <div class="text-area" id="text-area"></div>
        <input type="text" id="input-field" placeholder="Start typing here..." autocomplete="off">
        <button class="btn" id="start-btn">Start Test</button>
        <button class="btn" id="reset-btn" style="display: none;">Reset Test</button>
        <div class="result" id="result"></div>
    </div>

    <script>
        const textArea = document.getElementById('text-area');
        const inputField = document.getElementById('input-field');
        const startBtn = document.getElementById('start-btn');
        const resetBtn = document.getElementById('reset-btn');
        const wpmDisplay = document.getElementById('wpm');
        const accuracyDisplay = document.getElementById('accuracy');
        const timerDisplay = document.getElementById('timer');
        const resultDisplay = document.getElementById('result');

        const words = [
            "the", "quick", "brown", "fox", "jumps", "over", "lazy", "dog", "sun", "shines",
            "bright", "moon", "stars", "night", "river", "flows", "calm", "mountain", "high",
            "tree", "green", "sky", "blue", "wind", "blows", "cloud", "white", "rain", "falls",
            "bird", "sings", "flower", "blooms", "path", "leads", "home", "warm", "fire", "burns"
        ];

        let currentWords = [];
        let currentWordIndex = 0;
        let correctChars = 0;
        let totalChars = 0;
        let timeLeft = 60;
        let timer = null;
        let isTestRunning = false;

        function generateText() {
            currentWords = [];
            for (let i = 0; i < 50; i++) {
                const randomIndex = Math.floor(Math.random() * words.length);
                currentWords.push(words[randomIndex]);
            }
            displayText();
        }

        function displayText() {
            textArea.innerHTML = currentWords.map((word, index) => {
                return `<span class="word${index === currentWordIndex ? ' current' : ''}">${word}</span>`;
            }).join(' ');
        }

        function startTest() {
            if (isTestRunning) return;
            isTestRunning = true;
            generateText();
            inputField.disabled = false;
            inputField.focus();
            startBtn.style.display = 'none';
            resetBtn.style.display = 'inline-block';
            timeLeft = 60;
            timerDisplay.textContent = timeLeft;
            correctChars = 0;
            totalChars = 0;
            currentWordIndex = 0;
            wpmDisplay.textContent = '0';
            accuracyDisplay.textContent = '0%';
            resultDisplay.classList.remove('show');
            timer = setInterval(updateTimer, 1000);
        }

        function updateTimer() {
            timeLeft--;
            timerDisplay.textContent = timeLeft;
            if (timeLeft <= 0) {
                endTest();
            }
        }

        function endTest() {
            clearInterval(timer);
            isTestRunning = false;
            inputField.disabled = true;
            const wpm = Math.round((correctChars / 5) / (60 - timeLeft) * 60);
            const accuracy = totalChars > 0 ? Math.round((correctChars / totalChars) * 100) : 0;
            resultDisplay.innerHTML = `Test Completed!<br>WPM: ${wpm}<br>Accuracy: ${accuracy}%`;
            resultDisplay.classList.add('show');
        }

        function checkInput() {
            const input = inputField.value.trim();
            const currentWord = currentWords[currentWordIndex];

            if (input === currentWord && input !== '') {
                const words = textArea.querySelectorAll('.word');
                words[currentWordIndex].classList.add('correct');
                words[currentWordIndex].classList.remove('current');
                correctChars += currentWord.length;
                totalChars += currentWord.length;
                currentWordIndex++;
                inputField.value = '';
                if (currentWordIndex < currentWords.length) {
                    words[currentWordIndex].classList.add('current');
                } else {
                    generateText();
                    currentWordIndex = 0;
                    words[0].classList.add('current');
                }
            } else if (input && currentWord.startsWith(input)) {
                // Partial match
            } else if (input !== '') {
                const words = textArea.querySelectorAll('.word');
                words[currentWordIndex].classList.add('incorrect');
                totalChars += input.length;
            }

            const wpm = Math.round((correctChars / 5) / (60 - timeLeft) * 60);
            const accuracy = totalChars > 0 ? Math.round((correctChars / totalChars) * 100) : 0;
            wpmDisplay.textContent = isNaN(wpm) ? 0 : wpm;
            accuracyDisplay.textContent = `${accuracy}%`;
        }

        function resetTest() {
            clearInterval(timer);
            isTestRunning = false;
            inputField.disabled = true;
            inputField.value = '';
            startBtn.style.display = 'inline-block';
            resetBtn.style.display = 'none';
            textArea.innerHTML = '';
            wpmDisplay.textContent = '0';
            accuracyDisplay.textContent = '0%';
            timerDisplay.textContent = '60';
            resultDisplay.classList.remove('show');
            currentWordIndex = 0;
            correctChars = 0;
            totalChars = 0;
        }

        startBtn.addEventListener('click', startTest);
        resetBtn.addEventListener('click', resetTest);
        inputField.addEventListener('input', checkInput);
        inputField.addEventListener('keydown', (e) => {
            if (e.key === ' ' && inputField.value.trim() !== '') {
                e.preventDefault();
                checkInput();
            }
        });

        // Initialize
        inputField.disabled = true;
    </script>
</body>
</html>