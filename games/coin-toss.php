<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coin Toss Simulator</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: #fff;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            width: 90%;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #ffd700;
        }

        .coin-area {
            width: 150px;
            height: 150px;
            margin: 20px auto;
            position: relative;
            perspective: 1000px;
            border-radius: 50%; /* Ensure the container is circular */
            overflow: hidden; /* Prevent any square overflow */
        }

        .coin {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.6s ease-in-out;
            border-radius: 50%; /* Reinforce circular shape */
        }

        .coin.flipping {
            animation: flip 0.6s ease-in-out 3;
        }

        .coin.heads {
            transform: rotateY(0deg);
        }

        .coin.tails {
            transform: rotateY(180deg);
        }

        .coin-face {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 50%; /* Ensure faces are circular */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2em;
            color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            overflow: hidden; /* Prevent any square edges */
        }

        .heads {
            background: #ffd700;
            color: #333;
        }

        .tails {
            background: #c0c0c0;
            color: #333;
            transform: rotateY(180deg);
        }

        @keyframes flip {
            0% { transform: rotateY(0deg); }
            100% { transform: rotateY(360deg); }
        }

        .controls {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 20px;
        }

        .control-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            align-items: center;
        }

        select, button {
            padding: 10px;
            font-size: 1em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        select {
            background: #fff;
            color: #333;
        }

        button {
            background: #ffd700;
            color: #333;
        }

        button:hover {
            background: #ffca28;
        }

        button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .stats {
            margin-top: 20px;
            font-size: 1.1em;
        }

        .stats p {
            margin: 10px 0;
        }

        .history {
            margin-top: 20px;
            max-height: 150px;
            overflow-y: auto;
            background: rgba(0, 0, 0, 0.2);
            padding: 10px;
            border-radius: 5px;
        }

        .history p {
            margin: 5px 0;
            font-size: 0.9em;
        }

        @media (max-width: 400px) {
            h1 {
                font-size: 1.8em;
            }

            .coin-area {
                width: 120px;
                height: 120px;
            }

            select, button {
                font-size: 0.9em;
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Coin Toss Simulator</h1>
        <div class="coin-area">
            <div class="coin" id="coin">
                <div class="coin-face heads">Heads</div>
                <div class="coin-face tails">Tails</div>
            </div>
        </div>
        <div class="controls">
            <div class="control-group">
                <select id="flipCount">
                    <option value="1">1 Flip</option>
                    <option value="5">5 Flips</option>
                    <option value="10">10 Flips</option>
                    <option value="20">20 Flips</option>
                </select>
                <button id="flipButton">Flip Coin</button>
                <button id="resetButton">Reset</button>
            </div>
        </div>
        <div class="stats">
            <p>Heads: <span id="headsCount">0</span></p>
            <p>Tails: <span id="tailsCount">0</span></p>
            <p>Total Flips: <span id="totalFlips">0</span></p>
        </div>
        <div class="history" id="history">
            <p>Flip History:</p>
        </div>
    </div>

    <script>
        const coin = document.getElementById('coin');
        const flipButton = document.getElementById('flipButton');
        const resetButton = document.getElementById('resetButton');
        const flipCountSelect = document.getElementById('flipCount');
        const headsCountEl = document.getElementById('headsCount');
        const tailsCountEl = document.getElementById('tailsCount');
        const totalFlipsEl = document.getElementById('totalFlips');
        const historyEl = document.getElementById('history');

        let headsCount = 0;
        let tailsCount = 0;
        let totalFlips = 0;

        function updateStats() {
            headsCountEl.textContent = headsCount;
            tailsCountEl.textContent = tailsCount;
            totalFlipsEl.textContent = totalFlips;
        }

        function addHistory(result) {
            const p = document.createElement('p');
            p.textContent = `Flip ${totalFlips}: ${result}`;
            historyEl.appendChild(p);
            historyEl.scrollTop = historyEl.scrollHeight;
        }

        async function flipCoin() {
            flipButton.disabled = true;
            const flips = parseInt(flipCountSelect.value);

            for (let i = 0; i < flips; i++) {
                coin.classList.add('flipping');
                const result = Math.random() < 0.5 ? 'heads' : 'tails';
                await new Promise(resolve => setTimeout(resolve, 600));
                coin.classList.remove('flipping');
                coin.classList.remove('heads', 'tails');
                coin.classList.add(result);

                if (result === 'heads') headsCount++;
                else tailsCount++;
                totalFlips++;
                addHistory(result.charAt(0).toUpperCase() + result.slice(1));
                updateStats();

                if (i < flips - 1) {
                    await new Promise(resolve => setTimeout(resolve, 200));
                }
            }

            flipButton.disabled = false;
        }

        function resetGame() {
            headsCount = 0;
            tailsCount = 0;
            totalFlips = 0;
            updateStats();
            historyEl.innerHTML = '<p>Flip History:</p>';
            coin.classList.remove('heads', 'tails', 'flipping');
        }

        flipButton.addEventListener('click', flipCoin);
        resetButton.addEventListener('click', resetGame);
    </script>
</body>
</html>