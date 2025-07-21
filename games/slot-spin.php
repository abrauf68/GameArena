<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slot Machine Game</title>
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
            background: linear-gradient(135deg, #1e1e2f, #2a2a3e);
            color: #fff;
            transition: background 0.3s, color 0.3s;
        }

        body.light-theme {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            color: #333;
        }

        .slot-machine {
            background: #2c2c44;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            width: 90%;
            max-width: 500px;
            text-align: center;
        }

        .light-theme .slot-machine {
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: clamp(1.5rem, 5vw, 2rem);
            margin-bottom: 20px;
            color: #ffd700;
        }

        .balance {
            font-size: clamp(1rem, 4vw, 1.5rem);
            margin: 10px 0;
            color: #00ff88;
        }

        .result {
            font-size: clamp(0.9rem, 3.5vw, 1.2rem);
            margin: 10px 0;
            min-height: 30px;
            color: #ff4d4d;
        }

        .reels {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px 0;
            background: #1a1a2e;
            padding: 20px;
            border-radius: 10px;
            border: 2px solid #ffd700;
        }

        .light-theme .reels {
            background: #f0f0f0;
        }

        .reel {
            width: clamp(80px, 25vw, 100px);
            height: clamp(80px, 25vw, 100px);
            background: #fff;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: clamp(2rem, 8vw, 2.5rem);
            color: #2c2c44;
            animation: spin 0.5s ease-in-out;
            transition: transform 0.3s;
        }

        @keyframes spin {
            0% { transform: translateY(-100px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        .bet-section {
            margin: 20px 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            align-items: center;
        }

        .bet-input {
            padding: 10px;
            font-size: clamp(0.9rem, 3vw, 1rem);
            width: 100px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
            background: #3a3a5a;
            color: #fff;
        }

        .light-theme .bet-input {
            background: #e0e0e0;
            color: #333;
        }

        .bet-presets {
            display: flex;
            gap: 5px;
            margin-top: 10px;
        }

        .preset-btn {
            padding: 5px 10px;
            font-size: 0.9rem;
            background: #555;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s;
        }

        .preset-btn:hover {
            background: #666;
        }

        .spin-btn, .auto-spin-btn, .theme-toggle {
            padding: 10px 20px;
            font-size: clamp(0.9rem, 3.5vw, 1.2rem);
            background: #ffd700;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            margin: 5px;
        }

        .spin-btn:hover, .auto-spin-btn:hover, .theme-toggle:hover {
            background: #ffcc00;
            transform: scale(1.05);
        }

        .spin-btn:disabled, .auto-spin-btn:disabled {
            background: #555;
            cursor: not-allowed;
            transform: none;
        }

        .win-animation {
            animation: win 0.5s ease-in-out infinite;
        }

        @keyframes win {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: #2c2c44;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            color: #fff;
            max-width: 90%;
        }

        .light-theme .modal-content {
            background: #fff;
            color: #333;
        }

        .modal-content button {
            margin-top: 10px;
            padding: 10px 20px;
            background: #ffd700;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-content button:hover {
            background: #ffcc00;
        }

        .history {
            margin-top: 20px;
            max-height: 150px;
            overflow-y: auto;
            font-size: 0.9rem;
            background: #1a1a2e;
            padding: 10px;
            border-radius: 5px;
        }

        .light-theme .history {
            background: #f0f0f0;
        }

        @media (max-width: 600px) {
            .slot-machine {
                padding: 15px;
            }

            .reels {
                gap: 5px;
                padding: 15px;
            }

            .bet-section {
                flex-direction: column;
                align-items: center;
            }

            .bet-input {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="slot-machine">
        <h1>Slot Machine Game</h1>
        <div class="balance">Balance: $<span id="balance">1000</span></div>
        <div class="result" id="result"></div>
        <div class="reels">
            <div class="reel" id="reel1">?</div>
            <div class="reel" id="reel2">?</div>
            <div class="reel" id="reel3">?</div>
        </div>
        <div class="bet-section">
            <input type="number" id="betAmount" class="bet-input" placeholder="Bet Amount" min="1" max="1000">
            <div class="bet-presets">
                <button class="preset-btn" onclick="setBet(10)">$10</button>
                <button class="preset-btn" onclick="setBet(50)">$50</button>
                <button class="preset-btn" onclick="setBet(100)">$100</button>
            </div>
            <button class="spin-btn" id="spinBtn">Spin</button>
            <button class="auto-spin-btn" id="autoSpinBtn">Auto Spin</button>
            <button class="theme-toggle" id="themeToggle">Toggle Theme</button>
        </div>
        <div class="history" id="history"></div>
    </div>

    <div class="modal" id="modal">
        <div class="modal-content">
            <p id="modalMessage"></p>
            <button onclick="closeModal()">OK</button>
        </div>
    </div>

    <script>
        let balance = 1000;
        let isAutoSpinning = false;
        const symbols = ['🍒', '🍋', '🍊', '🍇', '💎'];
        const balanceElement = document.getElementById('balance');
        const resultElement = document.getElementById('result');
        const betAmountElement = document.getElementById('betAmount');
        const spinBtn = document.getElementById('spinBtn');
        const autoSpinBtn = document.getElementById('autoSpinBtn');
        const themeToggle = document.getElementById('themeToggle');
        const historyElement = document.getElementById('history');
        const reels = [
            document.getElementById('reel1'),
            document.getElementById('reel2'),
            document.getElementById('reel3')
        ];
        const modal = document.getElementById('modal');
        const modalMessage = document.getElementById('modalMessage');

        // Sound effects with error handling
        // Replace these paths with your local audio files
        let spinSound, winSound, loseSound;
        try {
            spinSound = new Audio('assets/spin.mp3'); // Add your local spin sound file
            winSound = new Audio('assets/win.mp3');   // Add your local win sound file
            loseSound = new Audio('assets/lose.mp3'); // Add your local lose sound file
        } catch (e) {
            console.warn('Audio initialization failed:', e);
            // Fallback: Create dummy audio objects that won't throw errors
            spinSound = { play: () => {} };
            winSound = { play: () => {} };
            loseSound = { play: () => {} };
        }

        // Add error event listeners for audio elements
        [spinSound, winSound, loseSound].forEach(sound => {
            if (sound instanceof Audio) {
                sound.addEventListener('error', () => {
                    console.warn('Failed to load audio:', sound.src);
                });
            }
        });

        function updateBalance() {
            balanceElement.textContent = balance.toFixed(2);
        }

        function addToHistory(message) {
            const entry = document.createElement('div');
            entry.textContent = `[${new Date().toLocaleTimeString()}] ${message}`;
            historyElement.appendChild(entry);
            historyElement.scrollTop = historyElement.scrollHeight;
        }

        function showModal(message) {
            modalMessage.textContent = message;
            modal.style.display = 'flex';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        function setBet(amount) {
            betAmountElement.value = amount;
        }

        function spin() {
            const bet = parseFloat(betAmountElement.value);
            if (!bet || bet <= 0) {
                showModal('Please enter a valid bet amount!');
                return;
            }
            if (bet > balance) {
                showModal('Insufficient balance!');
                return;
            }

            spinBtn.disabled = true;
            autoSpinBtn.disabled = true;
            balance -= bet;
            updateBalance();
            resultElement.textContent = '';
            try {
                spinSound.play().catch(e => console.warn('Spin sound failed:', e));
            } catch (e) {
                console.warn('Spin sound not available');
            }
            addToHistory(`Bet $${bet.toFixed(2)}`);

            let spins = 10;
            const spinInterval = setInterval(() => {
                reels.forEach(reel => {
                    reel.textContent = symbols[Math.floor(Math.random() * symbols.length)];
                });
                spins--;
                if (spins <= 0) {
                    clearInterval(spinInterval);
                    checkResult(bet);
                    spinBtn.disabled = false;
                    autoSpinBtn.disabled = false;
                }
            }, 100);
        }

        function checkResult(bet) {
            const result = reels.map(reel => reel.textContent);
            if (result[0] === result[1] && result[1] === result[2]) {
                const winAmount = bet * 10;
                balance += winAmount;
                resultElement.textContent = `Jackpot! You won $${winAmount.toFixed(2)}!`;
                resultElement.style.color = '#00ff88';
                reels.forEach(reel => reel.classList.add('win-animation'));
                try {
                    winSound.play().catch(e => console.warn('Win sound failed:', e));
                } catch (e) {
                    console.warn('Win sound not available');
                }
                addToHistory(`Jackpot! Won $${winAmount.toFixed(2)}`);
                setTimeout(() => reels.forEach(reel => reel.classList.remove('win-animation')), 2000);
            } else if (result[0] === result[1] || result[1] === result[2] || result[0] === result[2]) {
                const winAmount = bet * 2;
                balance += winAmount;
                resultElement.textContent = `Win! You won $${winAmount.toFixed(2)}!`;
                resultElement.style.color = '#00ff88';
                try {
                    winSound.play().catch(e => console.warn('Win sound failed:', e));
                } catch (e) {
                    console.warn('Win sound not available');
                }
                addToHistory(`Won $${winAmount.toFixed(2)}`);
            } else {
                resultElement.textContent = 'Try Again!';
                resultElement.style.color = '#ff4d4d';
                try {
                    loseSound.play().catch(e => console.warn('Lose sound failed:', e));
                } catch (e) {
                    console.warn('Lose sound not available');
                }
                addToHistory('Lost');
            }
            updateBalance();
            if (balance <= 0) {
                showModal('Game Over! You ran out of money.');
                spinBtn.disabled = true;
                autoSpinBtn.disabled = true;
            }
        }

        function autoSpin() {
            if (isAutoSpinning) {
                isAutoSpinning = false;
                autoSpinBtn.textContent = 'Auto Spin';
                return;
            }
            isAutoSpinning = true;
            autoSpinBtn.textContent = 'Stop Auto Spin';
            function runAutoSpin() {
                if (!isAutoSpinning || balance <= 0) {
                    isAutoSpinning = false;
                    autoSpinBtn.textContent = 'Auto Spin';
                    return;
                }
                spin();
                setTimeout(runAutoSpin, 2500);
            }
            runAutoSpin();
        }

        function toggleTheme() {
            document.body.classList.toggle('light-theme');
            const isLight = document.body.classList.contains('light-theme');
            themeToggle.textContent = isLight ? 'Dark Theme' : 'Light Theme';
        }

        spinBtn.addEventListener('click', spin);
        autoSpinBtn.addEventListener('click', autoSpin);
        themeToggle.addEventListener('click', toggleTheme);
        betAmountElement.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') spin();
        });

        updateBalance();
    </script>
</body>
</html>